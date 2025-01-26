<?php

namespace App\Momo\Product;

use App\Momo\Product;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class Collection extends Product
{

    public function __construct($headers = [])
    {
        $this->subscriptionKey = config('mtn-momo.products.collection.subscription_key');
        $this->clientId = config('mtn-momo.products.collection.client_id');
        $this->clientSecret = config('mtn-momo.products.collection.client_secret');
        $this->accessTokenCacheKey = 'momo_collection_access_token';

        parent::__construct($headers);
    }

    public function createInvoice(string $transactionId, $payerId, $amount) : ?array
    {

        $data = $this->getAccessToken();

        if (isset($data['status']) && $data['status'] === 'error') {
            return $data; // Return token error if token fetching failed
        }

        $accessToken = $data['access_token'];
        $momoTransactionId = Str::uuid()->toString();

        $headers = [
            'Authorization' => "Bearer {$accessToken}",
            'X-Reference-Id' => $momoTransactionId,
            'X-Target-Environment' => $this->getEnvironment(),
            'Ocp-Apim-Subscription-Key' => $this->getSubscriptionKey(),
        ];


        $body = [
            'amount' => $amount,
            'currency' => $this->getCurrency(),
            'externalId' => $transactionId,
            'intendedPayer' => [
                'partyIdType' => $this->getPartyIdType() ?? 'MSISDN',
                'partyId' => $payerId,
            ],
            'validityDuration' => '3600'
        ];

        try {
            //code...
            $response = Http::withHeaders($headers)->post($this->getBaseUri() . 'collection/v2_0/invoice', $body);

           switch ($response->status()) {
            case 202:
                return [
                    'status' => 'success',
                    'momoTransactionId' => $momoTransactionId,
                    'details' => $response
                ];
                break;

            case 400:
                return [
                    'status' => 'error',
                    'message' => 'Bad Request: Invalid data sent in the request.',
                    'details' => $response->body(),
                ];
            case 409:
                return [
                    'status' => 'error',
                    'message' => 'Conflict: Duplicated reference ID.',
                    'details' => $response->body(),
                ];
            default:
                return [
                    'status' => 'success',
                    'details' => $response->body(),
                ];
                break;
           }

        } catch (\Exception $e) {
             Log::error('Error in Create Invoice', ['error' => $e->getMessage()]);
            return [
                'status' => 'error',
                'message' => $e->getMessage(),
            ];
        }

    }

    public function getInvoiceStatus(string $momoTransactionId) : ?array
    {
        $data = $this->getAccessToken();

        if (isset($data['status']) && $data['status'] === 'error') {
            return $data; // Return token error if token fetching failed
        }

        $accessToken = $data['access_token'];
        $momoTransactionId = Str::uuid()->toString();

        $headers = [
            'Authorization' => "Bearer {$accessToken}",
            'X-Target-Environment' => $this->getEnvironment(),
            'Ocp-Apim-Subscription-Key' => $this->getSubscriptionKey(),
        ];

        $url = $this->getBaseUri()."collection/v2_0/invoice/{$momoTransactionId}";

        try {
            //code...
            $response = Http::withHeaders($headers)->get($url);

            // Check the response status
            switch ($response->status()) {
                case 200:
                    return $response->json();
                case 400:
                    return [
                        'status' => 'error',
                        'message' => 'Bad request, e.g. an incorrectly formatted reference id was provided.'
                    ];
                case 404:
                    return [
                        'status' => 'error',
                        'message' => 'Resource not found',
                        'details' => $response->json()
                    ];
                default:
                    return [
                        'status' => 'error',
                        'message' => 'Unknown Error ...',
                        'details' => $response->json()
                    ];
            }
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }


    }

     /**
     * Make a Request to Pay.
     *
     * @param string $amount
     * @param string $currency
     * @param string $referenceId
     * @param string $externalId
     * @param array $payer
     * @param string $payerMessage
     * @param string $payeeNote
     * @param string|null $callbackUrl
     * @return array|null
     */
    public function requestToPay(string $transactionId, $payerId, $amount, $payerMessage = '', $payeeNote = '') : ?array
    {
        $data = $this->getAccessToken();

        if (isset($data['status']) && $data['status'] === 'error') {
            return $data; // Return token error if token fetching failed
        }

        $accessToken = $data['access_token'];
        $momoTransactionId = Str::uuid()->toString();

        $headers = [
            'Authorization' => "Bearer {$accessToken}",
            'X-Reference-Id' => $momoTransactionId,
            'X-Target-Environment' => $this->getEnvironment(),
            'Ocp-Apim-Subscription-Key' => $this->getSubscriptionKey(),
        ];

        $body = [
            'amount' => $amount,
            'currency' => $this->getCurrency(),
            'externalId' => $transactionId,
            'payer' => [
                'partyIdType' => $this->getPartyIdType() ?? 'MSISDN',
                'partyId' => $payerId,
            ],
            'payerMessage' => $payerMessage,
            'payeeNote' => $payeeNote,
        ];

        try {
            $response = Http::withHeaders($headers)->post($this->getBaseUri() . 'collection/v1_0/requesttopay', $body);

            switch ($response->status()) {
                case 202:
                    return [
                        'status' => 'success',
                        'momoTransactionId' => $momoTransactionId,
                    ];
                case 400:
                    Log::error('Request to Pay failed: Bad Request', [
                        'status' => 400,
                        'body' => $response->body(),
                    ]);
                    return [
                        'status' => 'error',
                        'message' => 'Bad Request: Invalid data sent in the request.',
                        'details' => $response->body(),
                    ];
                case 409:
                    Log::error('Request to Pay failed: Conflict', [
                        'status' => 409,
                        'body' => $response->body(),
                    ]);
                    return [
                        'status' => 'error',
                        'message' => 'Conflict: Duplicated reference ID.',
                        'details' => $response->body(),
                    ];
                default:
                    Log::error('Request to Pay failed: Unknown Error', [
                        'status' => $response->status(),
                        'body' => $response->body(),
                    ]);
                    return [
                        'status' => 'error',
                        'message' => 'Unknown error occurred.',
                        'momoTransactionId' => $momoTransactionId,
                        'details' => $response->body(),
                    ];
            }
        } catch (\Exception $e) {
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
    public function getRequestToPayTransactionStatus(string $momoTransactionId) : ?array
    {
         $data = $this->getAccessToken();

        if (isset($data['status']) && $data['status'] === 'error') {
            return $data; // Return token error if token fetching failed
        }

        $accessToken = $data['access_token'];

        try {
            if (!$accessToken) {
                throw new \Exception('Access token is missing. Please generate a new token.');
            }

            // Prepare the request headers
            $headers = [
                'Authorization' => "Bearer {$accessToken}",
                'X-Target-Environment' => $this->getEnvironment(), // Adjust to 'production' for live environment
                'Ocp-Apim-Subscription-Key' => $this->getSubscriptionKey(),
            ];

            // Define the API endpoint
            $url = $this->getBaseUri()."collection/v1_0/requesttopay/{$momoTransactionId}";

            // Send the GET request
            $response = Http::withHeaders($headers)->get($url);

            // Check the response status
            switch ($response->status()) {
                case 200:
                    return $response->json();
                case 400:
                    return [
                        'status' => 'error',
                        'message' => 'Bad request, e.g. an incorrectly formatted reference id was provided.'
                    ];
                default:
                    return [
                        'status' => 'error',
                        'message' => 'Unknown Error ...',
                    ];
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

    public function sendRequesttoPayDeliveryNotification(string $referenceId, string $notificationMessage) : ?array
    {
        $data = $this->getAccessToken();

        if (isset($data['status']) && $data['status'] === 'error') {
            return $data; // Return token error if token fetching failed
        }

        $accessToken = $data['access_token'];

        $headers = [
            'Authorization' => "Bearer {$accessToken}",
            'X-Target-Environment' => $this->getEnvironment(),
            'Ocp-Apim-Subscription-Key' => $this->getSubscriptionKey(),
        ];

        $body = [
            'notificationMessage' => $notificationMessage
        ];

        // Define the API endpoint
        $url = $this->getBaseUri()."collection/v1_0/requesttopay/{$referenceId}/deliverynotification";

        try {
            //code...
            $response = Http::withHeaders($headers)->post($url, $body);

            switch ($response->status()) {
                case '200':
                    return $response->json();
                    break;
                case '400':
                    return [
                        'status' => 'error',
                        'message' => 'Bad request. Invalid data was sent in the request.'
                    ];
                    break;
                case '429':
                    return [
                        'status' => 'error',
                        'message' => 'Too many requests. Too many attempts for the same ID has been made recently. This will only occur if a successful attempt has previously been performed.'
                    ];
                    break;
                case '409':
                    return [
                        'status' => 'error',
                        'message' => 'Conflict. The transaction is not successfully completed.'
                    ];
                    break;
                case '410':
                    return [
                        'status' => 'error',
                        'message' => 'Gone. The delivery notification opportunity has expired.'
                    ];
                    break;

                default:
                    Log::error('Request to Pay failed: Unknown Error', [
                        'status' => $response->status(),
                        'body' => $response->body(),
                    ]);
                    return [
                        'status' => 'error',
                        'message' => 'Unknown error occurred.',
                        'details' => $response->body(),
                    ];
                    break;
            }
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
