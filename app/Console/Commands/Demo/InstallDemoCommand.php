<?php

namespace App\Console\Commands\Demo;

use Illuminate\Console\Command;
// Models
use Delgont\Armor\Models\Role;
use Delgont\Core\Entities\Any;
use App\Models\Employee\Employee;

use Modules\User\Entities\Master;


use Illuminate\Support\Facades\Artisan;


class InstallDemoCommand extends Command
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
        $this->setUpUserAccounts();
        return 0;
    }

    private function setUpUserAccounts()
    {
        //Setup Roles
        $roles = collect(config('defaults.roles', []))->map(function($description, $roleName){
            return Role::firstOrCreate([
                'name' => $roleName
            ],['name' => $roleName, 'description' => $description]
            );
        });

        $this->info($roles);
        $this->info('User roles created successfully ...');


        Artisan::call('permissions:sync');
        Artisan::call('defaults:load');

        

    }
}
