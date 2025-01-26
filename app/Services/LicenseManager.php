<?php
namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Exception;

class LicenseManager
{
    private const LICENSE_CACHE_KEY = 'viser';
    private const LICENSE_FILE = 'license.json';
    private const PUBLIC_KEY_FILE = 'public.key';
    private const HIDDEN_BASIC_PUBLIC_KEY = <<<KEY
    -----BEGIN PUBLIC KEY-----
    MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAs5EdtuZrX6Nq3LrwCqxt
    D9Wi2LoNSzNVGYqTn4BCPabtLbwfyEB9K3OAJGr+3MYCBBMj0n34mHSyvBMl3rQS
    7Saddz2sPzxG1sRqO5xgJEvpFXu8gCMTsWDgbYec5mWDo0otRAuqnJihdRvoVyvp
    orkjHbv0VX7/nRA/93mry74DsaPbopf1/wUa44U10o5QYYiGvGmdUoUaAlxDUJaS
    kWOyRQduNNy1SCw5esyplFBaSoZY1inDr5w7vcvVgJAOnlrBBvz/Uv4x+d3UTwV3
    /0pJlgavdURDeIDUyiy5LGkRvgoxth4VtzEp/NwfOeBxJzW8EyeV8ZLuc7A1MWWb
    AQIDAQAB
    -----END PUBLIC KEY-----
    KEY;

    /**
     * Validate and retrieve license data.
     *
     * @return array
     * @throws Exception
     */
    public function getLicenseType(): string
    {
        $license = Cache::get(self::LICENSE_CACHE_KEY);

        if (!$license) {
            $license = $this->validateLicense();
        }

        return $license['type'] ?? 'basic';
    }

    /**
     * Validate the license file and return license data.
     *
     * @return array
     * @throws Exception
     */
    private function validateLicense(): array
    {

        $publicKeyPath = storage_path(self::PUBLIC_KEY_FILE);
        $licenseFilePath = storage_path(self::LICENSE_FILE);

        // Check if the public key exists
        if (!file_exists(storage_path(self::PUBLIC_KEY_FILE))) {
            $this->generatePublicKey();
            //throw new Exception('Public key is missing. Please run: php artisan schoolviser:generate-public-key');
        }



        // Check if license file exists
        if (!file_exists($licenseFilePath)) {
            throw new Exception('License file is missing. Please contact support.');
        }

        // Read public key
        $publicKey = openssl_pkey_get_public(file_get_contents($publicKeyPath));
        if (!$publicKey) {
            throw new Exception('Failed to load public key. Ensure the public key is valid.');
        }

        // Read and validate the license file
        $license = json_decode(file_get_contents($licenseFilePath), true);

        if (!$license) {
            throw new Exception('License file is corrupt or invalid.');
        }

        $signature = base64_decode($license['signature']);
        unset($license['signature']);

        $isValid = openssl_verify(json_encode($license), $signature, $publicKey, OPENSSL_ALGO_SHA256);

        if (!$isValid || strtotime($license['expiry_date']) < time()) {
            abort(403, 'Invalid or expired license.');
        }

        // Cache the validated license data
        Cache::put(self::LICENSE_CACHE_KEY, $license, now()->addDays(7));

        return $license;
    }

    /**
     * Generate the public key
     *
     * @return void
     */
    public function generatePublicKey(): void
    {
        $publicKeyPath = storage_path(self::PUBLIC_KEY_FILE);

        if (file_exists($publicKeyPath)) {
            throw new Exception('Public key already exists.');
        }

        file_put_contents($publicKeyPath, self::HIDDEN_BASIC_PUBLIC_KEY);
    }
}
