<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;


use Delgont\Armor\Models\Role;
use Delgont\Armor\Models\Permission;

use Modules\User\Entities\User;
use Modules\User\Entities\Master;

class MasterInitCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'master:init';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates default master account ....)';

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
        $master_role = Role::firstOrCreate(['name' => 'master'], ['name' => 'master']);

        $master = Master::create([
            'first_name' => 'Justine',
            'last_name' => 'Omoding',
        ]);

        $exists = User::whereName('stephen')->exists();

        if($exists){
            $this->info('The master account you are trying to creat already exists .....');
            return 0;
        }

        $master->user()->create([
            'name' => 'stephen',
            'email' => 'stephen.schoolviser@gmail.com',
            'password' => bcrypt('secrete'),
            'role_id' => $master_role->id
        ]);

        $permissions = Permission::all();

        $user = User::whereName('stephen')->first();

        if($user){
            $user->givePermissionTo($permissions);
            $master_role->givePermissionTo($permissions);
        }



        $this->info('Master account has been created successfully......');
        
        return 0;
    }
}
