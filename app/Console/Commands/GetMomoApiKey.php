<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class GetMomoApiKey extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'schoolviser:get-momo-apikey';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate an API key for the MTN MoMo API user.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Fetch the X-Reference-Id and subscription key from the .env file
        $xReferenceId = env('MOMO_XREFERENCE_ID');
        $subscriptionKey = env('MOMO_SUBSCRIPTION_KEY');

        if (!$xReferenceId || !$subscriptionKey) {
            $this->error('The X-Reference-Id or Subscription Key is not set in the .env file.');
            return 1;
        }

        // Define the API endpoint
        $url = "https://sandbox.momodeveloper.mtn.com/v1_0/apiuser/{$xReferenceId}/apikey";

        // Send the POST request
        try {
            $response = Http::withHeaders([
                'Ocp-Apim-Subscription-Key' => $subscriptionKey,
            ])->post($url);

            // Print the response
            if ($response->status() === 201) {
                $this->info('API Key Generated Successfully:');
                $this->line('API Key: ' . $response->json('apiKey'));
            } else {
                $this->error('Failed to generate API key. Response:');
                $this->line('Status Code: ' . $response->status());
                $this->line('Body: ' . $response->body());
            }
        } catch (\Exception $e) {
            // Handle exceptions
            $this->error('An error occurred while sending the request:');
            $this->error($e->getMessage());
        }

        return 0;
    }
}
