<?php
return [
    'url' => env('AUTHZ_CLIENT_URL', "http://localhost:28180/oauth2/auth/callback"),
    'method' => env('AUTHZ_CLIENT_URL_METHOD',"POST"),
    'token_type' => env('AUTHZ_TOKEN_TYPE', 'Bearer'),
    'timeout' => 50,
    'response_type'=>env('AUTHZ_RESPONSE_TYPE', 'array'), // default array
];