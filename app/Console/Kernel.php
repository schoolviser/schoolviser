<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

//use App\Jobs\ProcessRevenue;

/**
 * Module Schedule Commands
 */

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\SyncSubjects::class,
        Commands\TestMail::class,
    ];
    

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        /**Sync Bank Deposits FeePayments Withdrawals & Expenses */
        //$schedule->command('bank:sync')->everyFiveMinutes()->withoutOverlapping();
        //$schedule->command('receivable:sync')->everyFiveMinutes()->withoutOverlapping();
        //$schedule->command('revenue:sync')->everyFiveMinutes()->withoutOverlapping();

        /**
         * Vendor Scheduled Commands and JObs
         */
        //$schedule->command('vendor:cache')->dailyAt('12:00')->withoutOverlapping()->name('cache-vendor-data')->onOneServer();

        //$schedule->command('queue:work --stop-when-empty')->everyMinute()->withoutOverlapping(15*60);


         // Conditionally run accounting scheduled commands
         if ($this->isAccountingModuleEnabled()) {
            $this->runAccountingScheduledCommands($schedule);
        }

    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }


    /**
     * Check if the accounting module is enabled.
     *
     * @return bool
     */
    protected function isAccountingModuleEnabled()
    {
        // Check if the accounting service provider exists in the configuration
        return in_array('Modules\\Accounting\\AccountingServiceProvider', config('app.providers', []));
    }

    /**
     * Define accounting scheduled commands.
     *
     * @param Schedule $schedule
     * @return void
     */
    protected function runAccountingScheduledCommands(Schedule $schedule)
    {
        // Schedule accounting commands here
        $schedule->command('update:expense-summary')->everyFiveMinutes()->withoutOverlapping();
        $schedule->command('update:department-expense-summary')->everyFiveMinutes()->withoutOverlapping();
        $schedule->command('update:monthly-expense-summary')->everyFiveMinutes()->withoutOverlapping();
    }
}
