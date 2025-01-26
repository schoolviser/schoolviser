<?php
namespace App\Momo;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

abstract class Product
{
    /**
     * Product.
     *
     * @var string
     */
    const PRODUCT = null;

    /**
     * Base URI.
     *
     * @var string
     */
    protected $baseUri;

     /**
     * Access Token Cache Key
     *
     * @var string
     */
    protected $accessTokenCacheKey;


    /**
     * Token URI.
     *
     * @var string
     */
    protected $tokenUri;

    /**
     * Subscription key.
     *
     * @var string
     */
    protected $subscriptionKey;

    /**
     * Client ID or App ID.
     *
     * @var string
     */
    protected $clientId;

    /**
     * Client Secret or Access Token.
     *
     * @var string
     */
    protected $clientSecret;

    /**
     * Client callback URI.
     *
     * @var string
     */
    protected $clientCallbackUri;

    /**
     * Currency.
     *
     * @var string
     */
    protected $currency;

    /**
     * Environment.
     *
     * @var string
     */
    protected $environment;

    /**
     * Party ID type.
     *
     * @var string
     */
    protected $partyIdType;



    /**
     * @return string
     */
    public function getBaseUri()
    {
        return $this->baseUri;
    }

    /**
     * @param string $baseUri
     */
    public function setBaseUri($baseUri)
    {
        $this->baseUri = $baseUri;
    }

    /**
     * @return string
     */
    public function getTokenUri()
    {
        return $this->tokenUri;
    }

    /**
     * @param string $tokenUri
     */
    public function setTokenUri($tokenUri)
    {
        $this->tokenUri = $tokenUri;
    }

    /**
     * @return string
     */
    public function getSubscriptionKey()
    {
        return $this->subscriptionKey;
    }

    /**
     * @param string $subscriptionKey
     */
    public function setSubscriptionKey($subscriptionKey)
    {
        $this->subscriptionKey = $subscriptionKey;
    }

    /**
     * @return string
     */
    public function getClientId()
    {
        return $this->clientId;
    }

    /**
     * @param string $clientId
     */
    public function setClientId($clientId)
    {
        $this->clientId = $clientId;
    }

    /**
     * @return string
     */
    public function getClientSecret()
    {
        return $this->clientSecret;
    }

    /**
     * @param string $clientSecret
     */
    public function setClientSecret($clientSecret)
    {
        $this->clientSecret = $clientSecret;
    }

    /**
     * @return string
     */
    public function getClientCallbackUri()
    {
        return $this->clientCallbackUri;
    }

    /**
     * @param string $clientCallbackUri
     */
    public function setClientCallbackUri($clientCallbackUri)
    {
        $this->clientCallbackUri = $clientCallbackUri;
    }

    /**
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @param string $currency
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;
    }

    /**
     * @return string
     */
    public function getEnvironment()
    {
        return $this->environment;
    }

    /**
     * @param string $environment
     */
    public function setEnvironment($environment)
    {
        $this->environment = $environment;
    }

    /**
     * @return string
     */
    public function getPartyIdType()
    {
        return $this->partyIdType;
    }

    /**
     * @param string $partyIdType
     */
    public function setPartyIdType($partyIdType)
    {
        $this->partyIdType = $partyIdType;
    }

    /**
     * @return string
    */
    public function getAccessTokenCacheKey()
    {
        return $this->accessTokenCacheKey;
    }

    /**
     * @param string $accessTokenCacheKey
     */
    public function setaccessTokenCacheKey($accessTokenCacheKey)
    {
        $this->accessTokenCacheKey = $accessTokenCacheKey;
    }


    /**
     * Constructor.
     *
     * @param array $headers
     *
     * @throws \Exception
     */
    public function __construct( $headers = [] )
    {

        $this->baseUri = config('mtn-momo.baseUri');
        $this->currency = config('mtn-momo.currency');
        $this->environment = config('mtn-momo.environment');

        $headers = array_merge([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Ocp-Apim-Subscription-Key' => $this->subscriptionKey,
        ], $headers);
    }




    public function getAccessToken() : ?array
    {
        try {
            // Check if token exists in cache
            $cachedToken = Cache::get($this->getAccessTokenCacheKey());
            if ($cachedToken && isset($cachedToken['access_token'], $cachedToken['expires_at'])) {
                // Check if the token is still valid
                if (time() < $cachedToken['expires_at']) {
                    return $cachedToken;
                }
            }

            // Get the required credentials
            $client_id = $this->getClientId();
            $client_secret = $this->getClientSecret();

            if (!$client_id || !$client_secret) {
                throw new \Exception('Missing API credentials.');
            }

            // Prepare the Authorization header
            $authHeader = base64_encode("{$client_id}:{$client_secret}");

            // Send the POST request to fetch a new token
            $response = Http::withHeaders([
                'Authorization' => "Basic {$authHeader}",
                'Ocp-Apim-Subscription-Key' => $this->getSubscriptionKey(),
            ])->post($this->getBaseUri() . 'collection/token/');

            // Check the response status
            if ($response->status() === 200) {
                $tokenData = $response->json();

                // Cache the token with an expiry buffer (e.g., 5 minutes before actual expiry)
                $expiresIn = $tokenData['expires_in'] ?? 3600; // Default to 1 hour if not provided
                $tokenData['expires_at'] = time() + $expiresIn - 300; // Subtract 5 minutes for buffer

                Cache::put($this->getAccessTokenCacheKey(), $tokenData, $expiresIn - 300);

                return $tokenData;
            } elseif ($response->status() === 401) {
                return [
                    'status' => 'error',
                    'message' => 'Response: 401 Unauthorized'
                ];
            }

            Log::error('Failed to generate MoMo Access Token', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return null;
        } catch (\Exception $e) {
            Log::error('Error generating MoMo Access Token', ['error' => $e->getMessage()]);
            return [
                'status' => 'error',
                'message' => $e->getMessage()
            ];
        }
    }

    public function getBasicUserInfo(string $accountHolderId, string $accountHolderIdType = 'MSISDN') : ?array
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

        // Define the API endpoint
        $url = $this->getBaseUri()."collection/v1_0/accountholder/{$accountHolderIdType}/{$accountHolderId}/basicuserinfo";

        try {
            //code...
            if (!$accessToken) {
                throw new \Exception('Access token is missing. Please generate a new token.');
            }

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
