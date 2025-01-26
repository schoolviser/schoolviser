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
                    return ['status' => 'success', 'details' => $transactionStatus];
                case 'FAILED':
                    return 'failed';
                    return ['status' => 'failed'];
                case 'PENDING':
                default:
                return 'pending';
                    return ['status' => 'pending'];
            }
        }

    }

    private function processSuccessfulRequest(MomoRequestToPay $request): void
    {
        $handlerClass = $request->handler;

        if (class_exists($handlerClass)) {
            try {
                $handlerInstance = app($handlerClass);

                if (method_exists($handlerInstance, 'handle')) {
                    $callbackData = $request->callback_data ?? [];
                    $handlerInstance->handle($callbackData);

                    // Update request status
                    $request->update(['status' => 'successful']);
                    $this->info("Handler '{$handlerClass}' processed the request successfully.");
                } else {
                    $this->error("The handler '{$handlerClass}' does not have a 'handle' method.");
                }
            } catch (\Exception $e) {
                $this->error("Error processing handler '{$handlerClass}': " . $e->getMessage());
            }
        } else {
            $this->error("Handler class '{$handlerClass}' not found.");
        }
    }
}
