<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Entities\MomoRequestToPay;

class ShowMomoRequestToPayCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'momo:show-rtp';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Show Momo Request to Pay records';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Fetch the necessary columns
        $rtpRecords = MomoRequestToPay::select(
            'transaction_id',
            'amount',
            'callback'
        )->get();

        if ($rtpRecords->isEmpty()) {
            $this->info('No Momo Request to Pay records found.');
            return 0;
        }

        // Display the records in a table
        $this->table(
            ['Transaction Reference', 'Amount', 'Handler'],
            $rtpRecords->toArray()
        );

        return 0;
    }
}
