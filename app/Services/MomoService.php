<?php

namespace App\Services;

use App\Entities\Momo;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class MomoService
{

    

    public function updateOrCreateSettings(array $data)
    {
        foreach ($data as $key => $value) {
            Momo::updateOrCreate(
                ['key' => $key],
                ['value' => $value, 'group' => 'momo']
            );
        }
    }

    /**
     * Generate an MTN MoMo Access Token.
     */
    public function generateAccessToken() : ?array
    {
        try {
            // Get the required credentials
            $apiUser = env('MOMO_XREFERENCE_ID'); // API User ID from .env
            $apiKey = option('momo_api_key', 'momo'); // Get API key from database

            if (!$apiUser || !$apiKey) {
                throw new \Exception('Missing API credentials.');
            }

            // Prepare the Authorization header
            $authHeader = base64_encode("{$apiUser}:{$apiKey}");

            // Send the POST request
            $response = Http::withHeaders([
                'Authorization' => "Basic {$authHeader}",
                'Ocp-Apim-Subscription-Key' => env('MOMO_SUBSCRIPTION_KEY'),
            ])->post('https://sandbox.momodeveloper.mtn.com/collection/token/');

            // Check the response status
            if ($response->status() === 200) {
                $data = $response->json();

                // Save access token in settings
                $this->updateOrCreateSettings([
                    'momo_access_token' => $data['access_token'],
                    'momo_token_expires_in' => now()->addSeconds($data['expires_in'])->toDateTimeString(),
                ]);

                return $data; // Return the token details
            }

            // Log error for non-200 responses
            Log::error('Failed to generate MoMo Access Token', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return null;
        } catch (\Exception $e) {
            // Log the exception
            Log::error('Error generating MoMo Access Token', ['error' => $e->getMessage()]);
            return null;
        }
    }

    /**
     * Make a Request to Pay.
     *
     * @param string $amount
     * @param string $currency
     * @param string $externalId
     * @param array $payer
     * @param string $payerMessage
     * @param string $payeeNote
     * @param string|null $callbackUrl
     * @return array|null
     */
    public function requestToPay(
        string $amount,
        string $currency,
        string $externalId,
        array $payer,
        string $payerMessage,
        string $payeeNote,
        ?string $callbackUrl = null
    ): ?array {
        try {
            // Retrieve the access token
            //$accessToken = Momo::where('key', 'momo_access_token')->value('value');

            $accessToken = option('momo_access_token', 'momo');

            if (!$accessToken) {
                throw new \Exception('Access token is missing. Please generate a new token.');
            }

            // Generate a unique reference ID
            $referenceId = Str::uuid()->toString();

            // Prepare the request headers
            $headers = [
                'Authorization' => "Bearer {$accessToken}",
                //'X-Callback-Url' => $callbackUrl ?? env('MOMO_CALLBACK_HOST'),
                'X-Reference-Id' => $referenceId,
                'X-Target-Environment' => 'sandbox', // Adjust to 'production' for live environment
                'Ocp-Apim-Subscription-Key' => env('MOMO_SUBSCRIPTION_KEY'),
            ];

            // Prepare the request body
            $body = [
                'amount' => $amount,
                'currency' => $currency,
                'externalId' => $externalId,
                'payer' => $payer,
                'payerMessage' => $payerMessage,
                'payeeNote' => $payeeNote,
            ];

            // Send the POST request
            $response = Http::withHeaders($headers)->post('https://sandbox.momodeveloper.mtn.com/collection/v1_0/requesttopay', $body);

            // Check the response status
            if ($response->status() === 202) {
                return [
                    'status' => 'success',
                    'referenceId' => $referenceId,
                ];
            }

            // Log errors for non-202 responses
            Log::error('Request to Pay failed', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return [
                'status' => 'error',
                'message' => 'Request to Pay failed',
                'details' => $response->body(),
            ];
        } catch (\Exception $e) {
            // Log any exceptions
            Log::error('Error in Request to Pay', ['error' => $e->getMessage()]);
            return [
                'status' => 'error',
                'message' => $e->getMessage(),
            ];
        }
    }


    /**
     * Get the status of a Request to Pay transaction.
     *
     * @param string $referenceId The X-Reference-Id of the transaction.
     * @return array|null The transaction status or null on failure.
     */
    public function requestToPayTransactionStatus(string $referenceId) : ?array
    {
        try {
            // Retrieve the access token
            //$accessToken = Momo::where('key', 'momo_access_token')->value('value');

            $accessToken = option('momo_access_token', 'momo');

            if (!$accessToken) {
                throw new \Exception('Access token is missing. Please generate a new token.');
            }

            // Prepare the request headers
            $headers = [
                'Authorization' => "Bearer {$accessToken}",
                'X-Target-Environment' => 'sandbox', // Adjust to 'production' for live environment
                'Ocp-Apim-Subscription-Key' => env('MOMO_SUBSCRIPTION_KEY'),
            ];

            // Define the API endpoint
            $url = "https://sandbox.momodeveloper.mtn.com/collection/v1_0/requesttopay/{$referenceId}";

            // Send the GET request
            $response = Http::withHeaders($headers)->get($url);

            // Check the response status
            if ($response->status() === 200) {
                return $response->json(); // Return the response data
            }

            // Log errors for non-200 responses
            Log::error('Failed to fetch Request to Pay transaction status', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return [
                'status' => 'error',
                'message' => 'Failed to fetch transaction status',
                'details' => $response->body(),
            ];
        } catch (\Exception $e) {
            // Log any exceptions
            Log::error('Error fetching Request to Pay transaction status', ['error' => $e->getMessage()]);
            return [
                'status' => 'error',
                'message' => $e->getMessage(),
            ];
        }
    }
}
