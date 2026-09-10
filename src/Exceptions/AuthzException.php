<?php
namespace Bsadeknet\AuthzClient\Exceptions;

use Exception;

class AuthzException extends Exception
{
    /**
     * Konstruktor kustom untuk AuthzException.
     * Mewarisi sifat dari class Exception bawaan PHP, namun memudahkan 
     * penyesuaian penanganan status HTTP atau pesan error.
     * 
     * @param string $message Pesan kesalahan
     * @param int $code Kode HTTP (misal: 401, 503, dll)
     * @param \Throwable|null $previous Exception sebelumnya jika ada (untuk chaining)
     */
    public function __construct(string $message = "", int $code = 401, ?\Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}