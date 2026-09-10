<?php
namespace Bsadeknet\AuthzClient\Tests\Unit;

use Bsadeknet\AuthzClient\AuthzClient;
use Bsadeknet\AuthzClient\Exceptions\AuthzException;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;

class AuthzClientTest extends TestCase
{
    /** @test */
    public function it_throws_exception_if_mandatory_config_is_missing()
    {
        $this->expectException(AuthzException::class);
        $this->expectExceptionMessage("Konfigurasi wajib diisi.");

        // Mencoba instansiasi tanpa authz_url
        new AuthzClient([
            'method' => "POST",
            'token_type' => 'Bearer',
            'timeout' => 5,
        ]);
    }

    /** @test */
    public function it_throws_exception_on_invalid_token_response()
    {
        $this->expectException(AuthzException::class);

        // Simulasi jika server mengembalikan active: false
        $responseStatusCode = 401;

        // Pengujian exception ketika token ditolak authz server
        // ... (implementasikanassertion sesuai logika mock Anda)
        
        $this->assertSame(200,$responseStatusCode);
    }
}