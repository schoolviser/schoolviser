<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\LicenseManager;

class GeneratePublicKey extends Command
{
    protected $signature = 'schoolviser:generate-public-key';
    protected $description = 'Generates the public key file for license validation.';

    public function handle()
    {
        $licenseManager = app(LicenseManager::class);

        try {
            $licenseManager->generatePublicKey();
            $this->info('Public key file has been successfully generated.');
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }

        return Command::SUCCESS;
    }
}
