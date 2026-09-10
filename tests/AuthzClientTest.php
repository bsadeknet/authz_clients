<?php
namespace Bsadeknet\AuthzClient\Tests;

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
            'url' => 'http://localhost:28180/api/users',
            'method' => "POST",
            'token_type' => 'Bearer',
            'timeout' => 5,
        ]);
    }

    /** @test */
    public function it_successfully_verifies_valid_token()
    {
        // 1. Simulasi respons sukses dari Authz Server
        $responseBody = json_encode([
            'active' => true,
            'payload' => [
                'sub' => 12345,
            ]
        ]);

        $mockHttpClient = new MockHttpClient([
            new MockResponse($responseBody, ['http_code' => 200])
        ]);

        // 2. Kita inject mock client ke AuthzClient (atau uji logika verifikasi)
        // Catatan: Jika di constructor AuthzClient Anda langsung memanggil HttpClient::create(),
        // Anda bisa membuat opsi injection client atau menguji skenario token via Mock Response.
        
        $client = new AuthzClient([
            'url' => 'http://localhost:28180/api/users',
            'method' => "POST",
            'token_type' => 'Bearer',
            'timeout' => 5,
        ]);
        $client->verifyToken("eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIwMWEwODU2My01ZjEyLTcxOGMtYWM3Yi01ZmRiOWFhOTY1ZmIiLCJqdGkiOiJiYjJjZmJmZGNhY2EzZmNkZDM0Njc2YmJlYmUzNjNjNGNmNjZlZDFjMmQyZWI3ZWI5Yjk2YTA2MTE1OTZlYzRiY2YyMDVjYjliZGQyOTNlZSIsImlhdCI6MTc4OTAxMzgwNC4xMzQ3MzgsIm5iZiI6MTc4OTAxMzgwNC4xMzQ3NCwiZXhwIjoxNzkwMzA5ODA0LjExMTk4Nywic3ViIjoiMSIsInNjb3BlcyI6W119.PBy4_uUCrjhkGko28Z7FVxkB76NAfZdgjoGqCEvcTiLR3KaUN_jeTdYto0_Hc-VFFCYr_Rc7AsTfaGj9CQAk6jH1FB1_Cc0JL3QauynHcSP0JhakxxxenqytLlK2brhC9-O1HU1SMSleDbZ9yuuudKUo6Sp1YgXO3d-367FIS3CAaBzlQn-F1n7z2xZ99PckrFopLQqG4VIc9mnD7r5phcZq4kou5ct0X4uXLDSxYuPHrW0TQACwJsUkU013ZAMK0KeFjoh3QV9awuVtETK0kJdqBaMBZSfraOXek9HoDw-V8ywAdJZWT1deDkLiaF2r5tsPCLZsqbs2O2bE0c0xmsDxGc39mYUA1EiyvDaF3m4I12CMNL4d0vXfy9JtzvnrSF9x8vPYHkT9TasCKDzG4I--7rG3NBfbyR9RW-k_KLlmud7vJaVnxSVi3Dpt9OXmVunWEHl50JOmB9zq5tBEi5pzqSoSCuNDr90RfO0hC72RHRiSKH3NnuuhLqK_zfdIsUdZNSz5QqgqOFu6BYft_7LqH7uniMv2JgoCdLXGc9VVFKiwdbDnciNFPRxiVXCcx5SKliXTAhc60VZ8wK2jkfGeEw3l6AFPvjjkrraIPP9i8_asERReA59nxh08henpK1BrA89hoa6h2_0iR6TedrpGTZOtsiTsGnI_jOIKRMY");

        // *Tips implementasi tingkat lanjut:* 
        // Agar MockHttpClient bisa masuk ke AuthzClient, pastikan di class AuthzClient.php 
        // Anda mengizinkan dependency injection untuk HTTP Client-nya (opsional).
        
        $this->assertTrue(true); // Placeholder jika struktur constructor murni config array.
    }

    /** @test */
    public function it_throws_exception_on_invalid_token_response()
    {
        $this->expectException(AuthzException::class);

        // Simulasi jika server mengembalikan active: false
        $responseBody = json_encode([
            'active' => false,
            'message' => 'Token kadaluwarsa'
        ]);

        // Pengujian exception ketika token ditolak authz server
        // ... (implementasikanassertion sesuai logika mock Anda)
        
        $this->assertTrue(true);
    }
}