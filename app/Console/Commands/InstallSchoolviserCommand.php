<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

// Models
use Delgont\Armor\Models\Role;
use Delgont\Core\Entities\Any;
use App\Models\Employee\Employee;

use Modules\User\Entities\Master;


use Illuminate\Support\Facades\Artisan;


class InstallSchoolviserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'schoolviser:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Display the application version
        $this->info('You are currently using Schoolviser version ' . config('schoolviser.version'));

        // Prompt the user for confirmation
        if (!$this->confirm('Would you like to proceed with running the backup-compatible command?', true)) {
            $this->info('Operation aborted by the user.');
            return Command::SUCCESS;
        }


        $this->call('armor:install');
        $this->info("\n  ");


        $this->setUpUserAccounts();

        $this->info('Syncing O Level subjects...');
        $this->call('subjects:sync', ['--O' => true]);
        $this->info('O Level subjects synced successfully.');
        $this->info("\n  ");


        $this->info('Syncing A Level subjects...');
        $this->call('subjects:sync', ['--A' => true]);
        $this->info('A Level subjects synced successfully.');
        $this->info("\n  ");


        $this->info('Syncing Courses...');
        $this->call('courses:sync');
        $this->info("\n  ");

        $this->info("\n🎉 DONE: Schoolviser installation and setup completed!");

        return 0;
    }

    private function setUpUserAccounts()
    {
        // Retrieve roles from the configuration and sync them
        $roles = collect(config('schoolviser.roles', []))->map(function ($description, $roleName) {
            return Role::firstOrCreate(
                ['name' => $roleName],
                ['name' => $roleName, 'description' => $description]
            );
        });

        // Prepare data for table output
        $tableData = $roles->map(function ($role) {
            return [
                'Name' => $role->name,
                'Description' => $role->description ?? 'No Description',
            ];
        })->toArray();

        // Display the roles in a table format
        $this->info('User roles synced successfully.....:');
        $this->table(['Role Name', 'Description'], $tableData);
        $this->info("\n  ");
    }

}
