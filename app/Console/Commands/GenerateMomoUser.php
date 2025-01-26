<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class GenerateMomoUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'schoolviser:generate-momo-user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate an MTN MoMo API user and print the response.';

    /**
     * Execute the console command.
    *
     * @return int
     */
    public function handle()
    {
        // Generate a UUID for the X-Reference-Id header
        $uuid = Str::uuid()->toString();

        $secondary_key = env('MOMO_SUBSCRIPTION_KEY');

        // Define the API endpoint
        $url = 'https://sandbox.momodeveloper.mtn.com/v1_0/apiuser';

        // Prepare the headers
        $headers = [
            'X-Reference-Id' => env('MOMO_XREFERENCE_ID') ?? $uuid,
            'Content-Type' => 'application/json',
            'Ocp-Apim-Subscription-Key' => env('MOMO_SUBSCRIPTION_KEY'),
        ];

        // Prepare the request body
        $payload = [
            'providerCallbackHost' => 'https://your-callback-url.com', // Replace with your actual callback URL
        ];

        // Send the POST request
        try {
            $response = Http::withHeaders($headers)->post($url, $payload);

            // Print the response
            $this->info('Request Sent. Response:');
            $this->line('Status Code: ' . $response->status());
            $this->line('Body: ' . $response->body());
        } catch (\Exception $e) {
            // Handle exceptions
            $this->error('An error occurred while sending the request:');
            $this->error($e->getMessage());
        }

        return 0;
    }
}
