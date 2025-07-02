<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Entities\MomoRequestToPay;

use App\Momo\Product\Collection;

class CheckRequestToPayStatusCommand extends Command
{
    protected $signature = 'momo:check-rtp-status';
    protected $description = 'Check the status of pending Momo requests to pay';

    public function handle()
    {
        $pendingRequests = MomoRequestToPay::where('status', 'pending')->get();

        if ($pendingRequests->isEmpty()) {
            $this->info('No pending Momo requests to process.');
            return;
        }

        foreach ($pendingRequests as $request) {
            $status = $this->checkMomoStatus($request->transaction_id);

            if ($status === 'successful') {
                $this->processSuccessfulRequest($request);
            } elseif ($status === 'failed') {
                $request->update(['status' => 'failed']);
                $this->info("Request {$request->transaction_id} marked as failed.");
            }else{
                $this->info('hello');
            }
        }

        $this->info('Momo request to pay statuses have been checked.');
    }

    private function checkMomoStatus(string $transactionReference) : string
    {
        $collection = new Collection();
        $transactionStatus = $collection->getRequestToPayTransactionStatus($transactionReference);

        if (isset($transactionStatus['status'])) {
            switch ($transactionStatus['status']) {
                case 'SUCCESSFUL':
                    return 'successful';
                case 'FAILED':
                    return 'failed';
                case 'PENDING':
                default:
                return 'pending';
            }
        }
        return 'faiiled';

    }

    private function processSuccessfulRequest(MomoRequestToPay $request): void
    {
        $callbackClass = $request->callback;


        if (class_exists($callbackClass)) {
            try {
                $callbackInstance = app($callbackClass);

                if (method_exists($callbackInstance, 'onSuccess')) {
                    $callbackData = $request->callback_data ?? [];
                    $callbackInstance::onSuccess($callbackData);

                    // Update request status
                    $request->update(['status' => 'successful']);
                    $this->info("Callbackclass '{$callbackClass}' processed the request successfully.");
                } else {
                    $this->error("The Callbackclass '{$callbackClass}' does not have a 'handle' method.");
                }
            } catch (\Exception $e) {
                $this->error("Error processing handler '{$callbackClass}': " . $e->getMessage());
            }
        } else {
            $this->error("Callbackclass class '{$callbackClass}' not found.");
        }
    }
}
