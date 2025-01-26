<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MomoCollectionInitCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'momo:collection:init';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set MOMO collection product environment variables';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $envVariables = [
            'MOMO_COLLECTION_SUBSCRIPTION_KEY',
            'MOMO_COLLECTION_CLIENT_ID',
            'MOMO_COLLECTION_SECRET',
        ];

        foreach ($envVariables as $key) {
            // Get the current value
            $currentValue = env($key, 'not set');
            $this->info("Current value of {$key}: {$currentValue}");

            // Ask the user for the new value
            $newValue = $this->ask("Enter a new value for {$key} (leave blank to skip)");

            // Skip if no value is provided
            if (empty($newValue)) {
                $this->info("Skipping {$key}.");
                continue;
            }

            // Update the value in the .env file
            $this->updateEnvVariable($key, $newValue);
            $this->info("Updated {$key} to the new value.");
        }

        return 0;
    }

    /**
     * Update an environment variable in the .env file.
     *
     * @param string $key
     * @param string $value
     * @return void
     */
    protected function updateEnvVariable($key, $value)
    {
        $path = base_path('.env');

        if (file_exists($path)) {
            // Read the .env file content
            $envContent = file_get_contents($path);

            // Update or add the key-value pair
            if (preg_match("/^{$key}=.*/m", $envContent)) {
                $envContent = preg_replace("/^{$key}=.*/m", "{$key}={$value}", $envContent);
            } else {
                $envContent .= "\n{$key}={$value}";
            }

            // Write back to the .env file
            file_put_contents($path, $envContent);
        }
    }
}
