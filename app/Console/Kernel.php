<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

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
        Commands\ShowMomoSettingsCommand::class,
    ];


    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {


         // Run Accounting Module Scheduled Commands
         $this->runAccountingScheduledCommands($schedule);

         // Run Admission Module Scheduled Commands
         $this->runAdmissionScheduledCommands($schedule);

         if (config('queue.default') == 'database') {
            $schedule->command('queue:work database --stop-when-empty --memory=256')->everyMinute()->withoutOverlapping();

            $schedule->command('queue:restart')->everyFiveMinutes()->withoutOverlapping();
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
        return ;
    }

    /**
     * Define accounting scheduled commands.
     *
     * @param Schedule $schedule
     * @return void
     */
    protected function runAccountingScheduledCommands(Schedule $schedule)
    {
        if (in_array('Modules\\Accounting\\AccountingServiceProvider', config('app.providers', []))) {
            $schedule->command('update:expense-summary')->everyFiveMinutes()->withoutOverlapping();
            $schedule->command('update:department-expense-summary')->everyFiveMinutes()->withoutOverlapping();
            $schedule->command('update:monthly-expense-summary')->everyFiveMinutes()->withoutOverlapping();
        }
    }

    /**
     * Define Admission scheduled commands.
     *
     * @param Schedule $schedule
     * @return void
     */
    protected function runAdmissionScheduledCommands(Schedule $schedule)
    {
        if (in_array('Modules\\Admission\\AdmissionServiceProvider', config('app.providers', []))) {
            $schedule->command('notify:pending-applications')->twiceWeekly(2, 5)->withoutOverlapping();
        }
    }


}
