<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use App\Momo\Product\Collection;
use App\Entities\MomoRequestToPay;

class RequestToPayCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'momo:send-rtp';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a request-to-pay transaction via MTN MoMo API';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Request to Pay - MTN MoMo');

        $transactionId = $this->ask('Enter a Transaction ID (leave blank to auto-generate a 6-digit number)');
        $transactionId = $transactionId ?: $this->generateTransactionId();

        if (!preg_match('/^\d{6}$/', $transactionId)) {
            $this->error('Invalid Transaction ID. It must be a 6-digit number.');
            return Command::FAILURE;
        }

        $payerId = $this->ask('Enter the Payer ID (in format 256774285504)');
        if (!preg_match('/^256\d{9}$/', $payerId)) {
            $this->error('Invalid Payer ID. It must be a 12-digit number starting with "256".');
            return Command::FAILURE;
        }

        $amount = $this->ask('Enter the Amount to be paid');
        if (!is_numeric($amount) || $amount <= 0) {
            $this->error('Invalid Amount. It must be a positive number.');
            return Command::FAILURE;
        }

        $payerMessage = $this->ask('Enter a Message for the Payer (optional)', '');
        $payeeNote = $this->ask('Enter a Note for the Payee (optional)', '');

        $collection = new Collection();

        // Save the request in the database
        $momoRequest = MomoRequestToPay::create([
            'transaction_id' => $transactionId,
            'payer_id' => $payerId,
            'amount' => $amount,
            'currency' => 'UGX',
            'payer_message' => $payerMessage,
            'payee_note' => $payeeNote,
            'status' => 'pending',
            'transaction_status' => 'pending',
        ]);

        $result = $collection->requestToPay($transactionId, $payerId, $amount, $payerMessage, $payeeNote);

        if ($result['status'] === 'success') {
            $momoRequest->update([
                'momo_transaction_id' => $result['momoTransactionId'],
                'status' => 'successful',
                'transaction_status' => 'pending', // Remains pending until verified
            ]);

            $this->info("Request to Pay successful!");
            $this->info("Transaction ID: {$transactionId}");
            $this->info("MoMo Transaction ID: {$result['momoTransactionId']}");
        } else {
            $momoRequest->update([
                'status' => 'failed',
                'transaction_status' => 'failed',
                'response_details' => $result['details'] ?? null,
            ]);

            $this->error("Request to Pay failed: {$result['message']}");
            if (isset($result['details'])) {
                $this->error("Details: {$result['details']}");
            }
        }

        return Command::SUCCESS;
    }

    /**
     * Generate a unique 6-digit transaction ID.
     *
     * @return string
     */
    private function generateTransactionId(): string
    {
        return str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT); // Generate a 6-digit number
    }
}
