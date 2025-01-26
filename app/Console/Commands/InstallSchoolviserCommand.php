<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

// Models
use Delgont\Armor\Models\Role;
use Delgont\Core\Entities\Any;
use App\Models\Employee\Employee;

use Modules\User\Entities\Master;

use App\Services\LicenseManager;
use Exception;

use Illuminate\Support\Facades\Http;

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

    private $licenseManager;

    public function __construct(LicenseManager $licenseManager)
    {
        parent::__construct();
        $this->licenseManager = $licenseManager;
    }
    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        // Check if APP_KEY exists
        if (empty(config('app.key'))) {
            $this->warn('No application key found. Please generate one using:');
            $this->line('  php artisan key:generate');
            return Command::FAILURE;
        }


        // Display the application version
        $this->info('You are currently using Schoolviser version ' . config('schoolviser.version'));
        $this->call('armor:install');
        $this->info("\n  ");


        $this->setUpUserAccounts();

        $this->info('Syncing O Level subjects...');
        $this->call('subjects:sync', ['--O' => true]);
        $this->info('O Level subjects synced successfully.');
        $this->info("\n  ");


        $this->info('Syncing A Level subjects...');
        $this->call('schoolviser:sync-subjects', ['--A' => true]);
        $this->info('A Level subjects synced successfully.');
        $this->info("\n  ");


        $this->info('Syncing Courses...');
        $this->call('schoolviser:sync-courses');
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
