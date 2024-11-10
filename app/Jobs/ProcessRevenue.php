<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;


use App\OtherRevenue;

use Illuminate\Support\Facades\Artisan;

class ProcessRevenue implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $account_id = null;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($account_id)
    {
        $this->account_id = $account_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Artisan::call('revenue:sync');
        //app(OtherRevenue::class)->termly()->populate($this->account_id);
    }
}
