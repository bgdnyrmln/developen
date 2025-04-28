<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for cross-origin resource sharing
    | or "CORS". This determines what cross-origin operations may execute
    | in web browsers. You are free to adjust these settings as needed.
    |
    | To learn more: https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
    |
    */
    'paths' => ['api/*', 'sanctum/csrf-cookie', '/login', '/logout', '/register', '/users/*', '*'],

    'allowed_methods' => ['*'],  // Allow all HTTP methods

    'allowed_origins' => ['*'],  // Allow all origins (use specific origins for production)

    'allowed_origins_patterns' => [],  // Empty if you don't need to use regex patterns for origins

    'allowed_headers' => ['*'],  // Allow all headers

    'exposed_headers' => [],  // Optional: specify which headers to expose to the browser

    'max_age' => 0,  // Optional: max cache time in seconds for preflight requests

    'supports_credentials' => true,  // Allow cookies and authentication headers (important for your case)

];
