<?php
return [
    'url' => env('AUTHZ_CLIENT_URL', "http://localhost:28280/oauth2/auth/callback"),
    'method' => env('AUTHZ_CLIENT_URL_METHOD',"POST"),
    'token_type' => env('AUTHZ_TOKEN_TYPE', 'Bearer'),
    'timeout' => 5,
];