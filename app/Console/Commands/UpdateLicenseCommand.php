<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class UpdateLicenseCommand extends Command
{
    protected $signature = 'schoolviser:update-license';
    protected $description = 'Update the local license file with data from the license server.';

    public function handle()
    {
        // Fetch configuration
        $licenseUrl = config('schoolviser.license_url');
        $schoolviserId = config('schoolviser.schoolviser_id');
        $schoolviserKey = config('schoolviser.secrete_key');
        $licenseKey = config('schoolviser.license_key');

        // Ensure required environment variables are set
        if (!$licenseUrl || !$schoolviserId || !$schoolviserKey || !$licenseKey) {
            $this->error('Missing required configuration. Ensure SCHOOLVISER_ID, SCHOOLVISER_SECRETE_KEY, and SCHOOLVISER_LICENSE_KEY are set in your environment.');
            return Command::FAILURE;
        }

        // Make the request to the license server
        try {
            $response = Http::get("$licenseUrl/get-license/$schoolviserId/$schoolviserKey/$licenseKey");

            if ($response->failed()) {
                $this->error("Failed to fetch license details. Server responded with status: {$response->status()}");
                return Command::FAILURE;
            }

            $licenseData = $response->json();

            // Save the license data to a local file
            $licenseFilePath = storage_path('license.json');
            file_put_contents($licenseFilePath, json_encode($licenseData, JSON_PRETTY_PRINT));


            $this->info('hello');

            $this->info("License file successfully updated at: $licenseFilePath");

            return Command::SUCCESS;

        } catch (\Exception $e) {
            $this->error("An error occurred while updating the license: {$e->getMessage()}");
            return Command::FAILURE;
        }
    }
}
