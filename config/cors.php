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

    'paths' => ['api/*', 'login', 'logout', 'sanctum/csrf-cookie'],

    'allowed_methods' => ['*'],

    'allowed_origins' => [
        'http://localhost:5173',
        'https://myfitness-frontend.vercel.app',
        'https://myfitness-frontend-git-main-kaif394s-projects.vercel.app', // Main branch preview
        'https://myfitness-frontend-9cfznnr1v-kaif394s-projects.vercel.app',
        'https://myfitness-frontend-3e6y5cgwk-kaif394s-projects.vercel.app', // Newest preview URL from error
        'https://myfitness-frontend-bld7yeh2-kaif394s-projects.vercel.app',
        'https://myfitness-frontend-1kmttagjx-kaif394s-projects.vercel.app',
        // Add any other Vercel preview URLs here as they are generated
    ],

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => true,

];
