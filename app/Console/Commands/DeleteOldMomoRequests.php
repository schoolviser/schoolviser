<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class DeleteOldMomoRequests extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'momo:delete-old-rtps';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete MoMo requests older than 2 hours with pending or failed status';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        DB::table('momo_request_to_pays')
            ->whereIn('transaction_status', ['pending', 'failed'])
            ->where('updated_at', '>', now()->subHours(2))
            ->delete();

        $this->info('Old MoMo requests deleted successfully.');
    }
}
