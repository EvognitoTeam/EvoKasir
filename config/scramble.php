<?php

return [
    'info' => [
        'title' => 'Evokasir API',
        'description' => 'API documentation for the Evokasir web application.',
        'version' => '1.0.0',
    ],
    'route' => [
        'uri' => 'docs/api',
        'json_uri' => 'docs/api.json',
        'middleware' => [
            function ($request, $next) {
                \Illuminate\Support\Facades\Log::info('Mengakses Scramble /docs/api', ['url' => $request->fullUrl()]);
                return $next($request);
            },
        ],
    ],
    'routes' => [
        'api/*',
    ],
    'enabled_in_production' => env('SCRAMBLE_ENABLED_IN_PRODUCTION', false),
    'auth' => [
        'middleware' => 'auth:api',
        'description' => 'Gunakan Bearer token untuk endpoint yang dilindungi.',
    ],
    'extensions' => [],
];
