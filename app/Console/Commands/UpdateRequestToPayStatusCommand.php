<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Momo\Product\Collection;
use App\Entities\MomoRequestToPay;
use Illuminate\Support\Facades\Log;
use App\Momo\MomoCallback;


class UpdateRequestToPayStatusCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'momo:update-request-to-pay-status {transactionId? : The transaction ID or partial ID to search}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Search for and update the status of a Request to Pay transaction using the MoMo API';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $partialTransactionId = $this->argument('transactionId');

        if (!$partialTransactionId) {
            $this->error('Please provide at least the first 3 digits of a transaction ID.');
            return Command::FAILURE;
        }

        // Search for matching transactions
        $transactions = MomoRequestToPay::where('transaction_id', 'like', "{$partialTransactionId}%")
            ->select('id', 'transaction_id', 'momo_transaction_id', 'status', 'transaction_status')
            ->orderBy('created_at', 'desc')
            ->get();

        if ($transactions->isEmpty()) {
            $this->error("No transactions found matching: {$partialTransactionId}");
            return Command::FAILURE;
        }

        // Display the list of transactions in a table
        $this->info("Matching transactions:");
        $this->table(
            ['ID', 'Transaction ID', 'MoMo Transaction ID', 'Status', 'Transaction Status'],
            $transactions->map(function ($transaction) {
                return [
                    'ID' => $transaction->id,
                    'Transaction ID' => $transaction->transaction_id,
                    'MoMo Transaction ID' => $transaction->momo_transaction_id ?? 'N/A',
                    'Status' => $transaction->status,
                    'Transaction Status' => $transaction->transaction_status,
                ];
            })->toArray()
        );

        // Prompt the user to select a transaction ID
        $chosenTransactionId = $this->ask('Enter the full Transaction ID from the list to update');

        // Find the selected transaction in the database
        $transaction = MomoRequestToPay::where('transaction_id', $chosenTransactionId)->first();

        if (!$transaction) {
            $this->error("No transaction found with ID: {$chosenTransactionId}");
            return Command::FAILURE;
        }

        $this->info("Fetching status for Transaction ID: {$chosenTransactionId}");

        // Create a new Collection instance to call the API
        $collection = new Collection();
        $statusResponse = $collection->getRequestToPayTransactionStatus($transaction->momo_transaction_id);

        if (isset($statusResponse['status']) && $statusResponse['status'] === 'error') {
            $this->error("Failed to fetch transaction status: {$statusResponse['message']}");
            if (isset($statusResponse['details'])) {
                $this->error("Details: {$statusResponse['details']}");
            }
            return Command::FAILURE;
        }

        // Attempt to execute the callback if the status is successful
        $transactionStatus = $this->mapTransactionStatus($statusResponse['status']);
        if ($transactionStatus === 'successful') {
            $this->executeCallback($transaction, true, $statusResponse);
        }

        // Update the transaction details and status
        $transaction->update([
            'response_details' => $statusResponse,
            'transaction_status' => $transactionStatus,
        ]);

        $this->info("Transaction ID: {$chosenTransactionId} updated successfully.");
        $this->info("Current Status: {$transaction->transaction_status}");
        $this->info("Response Details:");
        $this->line(json_encode($statusResponse, JSON_PRETTY_PRINT));

        return Command::SUCCESS;
    }

    /**
     * Map the API status to the local transaction status.
     *
     * @param string $apiStatus
     * @return string
     */
    private function mapTransactionStatus(string $apiStatus): string
    {
        return match ($apiStatus) {
            'SUCCESSFUL' => 'successful',
            'FAILED' => 'failed',
            'PENDING' => 'pending',
            default => 'unknown',
        };
    }

    /**
     * Execute the callback for a MomoRequestToPay transaction.
     *
     * @param MomoRequestToPay $transaction
     * @param bool $isSuccessful
     * @return void
     */
    public function executeCallback(MomoRequestToPay $transaction, bool $isSuccessful, $data)
    {
        $callbackClass = $transaction->callback;

        if (empty($callbackClass)) {
            $this->warn("No callback class defined for transaction {$transaction->transaction_id}.");
            return;
        }

        if (!class_exists($callbackClass)) {
            Log::warning("Callback class {$callbackClass} does not exist for transaction {$transaction->transaction_id}.");
            $this->warn("Callback class does not exist for this transaction.");
            return;
        }

        if (!is_subclass_of($callbackClass, MomoCallback::class)) {
            Log::warning("Callback class {$callbackClass} is invalid or does not extend MomoCallback for transaction {$transaction->transaction_id}.");
            $this->warn("Callback class is invalid or does not extend the required base class.");
            return;
        }

        $callbackMethod = $isSuccessful ? 'onSuccess' : 'onFail';

        if (!method_exists($callbackClass, $callbackMethod)) {
            Log::warning("Callback method {$callbackMethod} not found in {$callbackClass} for transaction {$transaction->transaction_id}.");
            $this->warn("Callback method {$callbackMethod} not found in the callback class.");
            return;
        }

        // Call the appropriate callback method
        call_user_func([$callbackClass, $callbackMethod], $data ?? []);
        Log::info("Callback method {$callbackMethod} executed successfully for transaction {$transaction->transaction_id}.");
        $this->info("Callback executed successfully.");
    }
}
