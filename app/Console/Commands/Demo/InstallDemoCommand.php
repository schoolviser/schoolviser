<?php

namespace App\Console\Commands\Demo;

use Illuminate\Console\Command;
// Models
use Delgont\Armor\Models\Role;
use App\Models\Any;
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
        $roles = collect(config('demo.roles', ['hello']))->map(function($item, $key){
            Role::updateOrCreate(['name' => $item], ['name' => $item]);
            return $item;
        });

        $this->info($roles);
        $this->info('User roles created successfully ...');

        $master_role = Role::firstOrCreate(['name' => 'master']);

        //Setup Master | System | Super accounts
        $masters = collect(config('demo.masters', []))->map(function($item, $key) use ($master_role){
            $master = new Any($item);
            Master::updateOrCreate([
                'first_name' => $master->first_name,
                'last_name' => $master->last_name,
            ])->user()->updateOrCreate(['name' => $master->username, 'email' => $master->email],[
                'name' => $master->username,
                'email' => $master->email,
                'password' => $master->password,
                'role_id' => $master_role->id
            ]);;
            return $master->username;
        });

        $this->info($masters);
        $this->info('Master user accounts created successfully .....!');

        //Setup admin account
        $admin_role = Role::firstOrCreate(['name' => 'admin']);
        $admin = new Any(config('demo.admin',[]));

        Employee::updateOrCreate(['email' => $admin->email],[
            'email' => $admin->email,
            'first_name' => $admin->first_name,
            'last_name' => $admin->last_name
        ])->user()->updateOrCreate(['name' => $admin->username],[
            'name' => $admin->username,
            'email' => $admin->email,
            'password' => $admin->password,
            'role_id' => $admin_role->id
        ]);

        $this->info($admin);
        $this->info('Admin account created ...');

        //Setup Bursar account
        $bursar_role = Role::firstOrCreate(['name' => 'bursar']);
        $bursar = new Any(config('demo.bursar',[]));

        Employee::updateOrCreate(['email' => $bursar->email],[
            'email' => $bursar->email,
            'first_name' => $bursar->first_name,
            'last_name' => $bursar->last_name
        ])->user()->updateOrCreate(['name' => $bursar->username],[
            'name' => $bursar->username,
            'email' => $bursar->email,
            'password' => $bursar->password,
            'role_id' => $bursar_role->id
        ]);

        $this->info($bursar);
        $this->info('bursar account created ...');

        $teacher_role = Role::firstOrCreate(['name' => 'teacher']);

        //Setup teacher accounts
        $teachers = collect(config('demo.teachers', []))->map(function($item, $key) use ($teacher_role){
            $teacher = new Any($item);
            Employee::updateOrCreate([
                'first_name' => $teacher->first_name,
                'last_name' => $teacher->last_name,
            ])->user()->updateOrCreate(['name' => $teacher->username, 'email' => $teacher->email],[
                'name' => $teacher->username,
                'email' => $teacher->email,
                'password' => $teacher->password,
                'teacher' => '1',
                'role_id' => $teacher_role->id
            ]);;
            return $teacher->username;
        });

        $this->info($teachers);
        $this->info('teacher account created ...');

        Artisan::call('permission:sync');
        Artisan::call('defaults:load');

        

    }
}
