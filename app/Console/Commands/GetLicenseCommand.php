<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class GetLicenseCommand extends Command
{
    protected $signature = 'schoolviser:get-license';
    protected $description = 'Fetch license details from the license server.';

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

            $this->info('License Details:');
            $this->table(
                ['License Key', 'Type', 'Host', 'Expiry Date', 'SchoolViser ID'],
                [[
                    $licenseData['license_key'] ?? 'N/A',
                    $licenseData['type'] ?? 'N/A',
                    $licenseData['host'] ?? 'N/A',
                    $licenseData['expiry_date'] ?? 'N/A',
                    $licenseData['schoolviser_id'] ?? 'N/A',
                ]]
            );

            return Command::SUCCESS;

        } catch (\Exception $e) {
            $this->error("An error occurred while fetching the license: {$e->getMessage()}");
            return Command::FAILURE;
        }
    }
}
