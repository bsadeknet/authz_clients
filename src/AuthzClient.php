<?php

namespace BSadekNet\AuthzClient;
use Bsadeknet\AuthzClient\Exceptions\AuthzException;

class AuthzClient
{
    private string $authzUrl;
    private string $authzTokenType;
    private string $authzMethod;
    private int $timeout;
    /**
     * @param string $authzUrl Endpoint URL di Server Authz (misal: https://auth.domain.com/api/v1/token/introspect)
     * @param string $clientId Client ID dari Resource Server ini
     * @param string $clientSecret Client Secret dari Resource Server ini
     * @param int $timeout Timeout cURL dalam detik
     */
    public function __construct(array $config)
    {
        if (empty($config['url'])) {
            throw new AuthzException("URL wajib diisi");
        }
        $this->authzUrl = $config['url'];
        $this->authzTokenType = ($config['token_type'] ?? "Bearer");
        $this->authzMethod = strtolower($config['method'] ?? "post");
        $this->timeout = ($config['timeout'] ?? 50 );
    }

    /**
     * Meminta Server Authz untuk mendecrypt/memvalidasi token.
     * 
     * @param string $token Bearer token dari client (bisa dengan atau tanpa prefix 'Bearer ')
     * @return array Payload data user jika valid
     * @throws AuthzException Jika token invalid atau gagal menghubungi Authz Server
     */
    public function verifyToken(string $token): array
    {
        // Bersihkan prefix 'Bearer ' jika ada
        if (str_starts_with($token, 'Bearer ')) {
            $token = substr($token, 7);
        }

        $payloadToken = implode(" ",[$this->authzTokenType,$token]);

        $ch = curl_init($this->authzUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $this->authzMethod);
        curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeout);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Accept: application/json',
            'Authorization: '. $payloadToken
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);

        if ($curlError) {
            throw new AuthzException("Gagal terhubung ke Authz Server: {$curlError}");
        }

        $data = json_decode($response, true);

        if ($httpCode !== 200 || !isset($data['active']) || $data['active'] !== true) {
            $message = $data['message'] ?? 'Token tidak valid atau sudah kedaluwarsa di Authz Server';
            throw new AuthzException($message, $httpCode ?: 401);
        }

        return $data ?? [];
    }
}