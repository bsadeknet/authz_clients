<?php

namespace Bsadeknet\AuthzClient;
use Symfony\Component\HttpClient\HttpClient;
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
        $this->authzMethod = strtoupper($config['method'] ?? "post");
        $this->timeout = ($config['timeout'] ?? "50" );
        $this->responseType = ($config['response_type'] ?? "" );
    }

    /**
     * Meminta Server Authz untuk mendecrypt/memvalidasi token.
     * 
     * @param string $token Bearer token dari client (bisa dengan atau tanpa prefix 'Bearer ')
     * @return array Payload data user jika valid
     * @throws AuthzException Jika token invalid atau gagal menghubungi Authz Server
     */
    public function verifyToken(string $token)
    {
        // Bersihkan prefix 'Bearer ' jika ada
        if (str_starts_with($token, 'Bearer ')) {
            $token = substr($token, 7);
        }

        $payloadToken = implode(" ",[$this->authzTokenType,$token]);
        $client = HttpClient::create();

        $response = $client->request(
            $this->authzMethod,
            $this->authzUrl,
            [
                'max_redirects' => 0,
                'headers'=>[
                    "Content-Type"=>"application/json",
                    "Accept"=>"application/json",
                    "Authorization"=>$payloadToken
                ]
            ]
        );
        $statusCode = $response->getStatusCode();
        if ($statusCode == 200) {
            // $statusCode = 200
            $contentType = $response->getHeaders()['content-type'][0];
            // $contentType = 'application/json'

            switch ($this->responseType) {
                case 'array':
                    return $response->toArray();
                    // $content = ['id' => 521583, 'name' => 'symfony-docs', ...]
                    break;
                case 'string':
                    return $response->getContent();
                    // $content = '{"id":521583, "name":"symfony-docs", ...}'
                    break;
                
                default:
                    return $statusCode;
                    break;
            }
        }
        return $statusCode;
    }
}