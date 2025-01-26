<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Entities\MomoRequestToPay;

class ShowRequestsToPayCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'momo:show-rtp
                            {--date= : Filter by creation date (YYYY-MM-DD)}
                            {--transaction-id= : Filter by transaction ID}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Display paginated MoMo Requests to Pay with optional filters';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $query = MomoRequestToPay::query();

        // Apply filters
        $date = $this->option('date');
        $transactionId = $this->option('transaction-id');

        if ($date && !$this->isValidDate($date)) {
            $this->error('Invalid date format. Use YYYY-MM-DD.');
            return Command::FAILURE;
        }

        $query->when($date, fn($q) => $q->whereDate('created_at', $date))
              ->when($transactionId, fn($q) => $q->where('transaction_id', $transactionId));

        // Paginate and display results
        $page = 1;
        do {
            $results = $query->orderByDesc('created_at')->paginate(10, ['*'], 'page', $page);
            if ($results->isEmpty()) {
                $this->info('No results found.');
                return Command::SUCCESS;
            }

            $this->table(
                ['ID', 'Transaction ID', 'Payer ID', 'MoMo Transaction ID', 'Status', 'Transaction Status', 'Amount'],
                $results->map(fn($item) => [
                    $item->id,
                    $item->transaction_id,
                    $item->payer_id,
                    $item->momo_transaction_id ?? 'N/A',
                    $item->status,
                    $item->transaction_status,
                    $item->amount . ' ' . $item->currency,
                ])->toArray()
            );

            $page++;
        } while ($results->hasMorePages() && $this->confirm('Show next page?'));

        return Command::SUCCESS;
    }

    /**
     * Validate date format.
     *
     * @param string $date
     * @return bool
     */
    private function isValidDate(string $date): bool
    {
        return \DateTime::createFromFormat('Y-m-d', $date)?->format('Y-m-d') === $date;
    }
}
