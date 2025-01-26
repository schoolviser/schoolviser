<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Repositories\MomoSettingRepository;

class ShowMomoSettingsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'schoolviser:momo-settings';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Displays Momo settings on the console';

    /**
     * The MomoSettingRepository instance.
     *
     * @var MomoSettingRepository
     */
    protected $momoSettingRepository;

    /**
     * Create a new command instance.
     *
     * @param MomoSettingRepository $momoSettingRepository
     * @return void
     */
    public function __construct(MomoSettingRepository $momoSettingRepository)
    {
        parent::__construct();
        $this->momoSettingRepository = $momoSettingRepository;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Fetch Momo settings
        $settings = $this->momoSettingRepository->getSettings();

        if (!$settings) {
            $this->info('No Momo settings found.');
            return 0;
        }

        // Display settings in a table format
        $this->table(
            ['Key', 'Value'],
            collect($settings->toArray())->map(fn($value, $key) => ['key' => $key, 'value' => $value])->values()
        );

        return 0;
    }
}
