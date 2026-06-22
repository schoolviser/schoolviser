<?php

namespace Modules\Schoolviser\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class SchoolviserBootstrapBrandingCommand extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'schoolviser:bootstrap:branding';

    /**
     * The console command description.
     */
    protected $description = 'Command description.';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle() 
    {
        $this->call('delxero:bootstrap:branding', [
            '--favicon' => 'modules/schoolviser/media/Favicon.png',
            '--logo-light' => 'modules/schoolviser/media/logo-light.svg',
            '--logo-dark' => 'modules/schoolviser/media/logo-dark.svg'
        ]);

    }
    
}
