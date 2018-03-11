<?php

$container = $app->getContainer();

// Coba Pasang Middleware response dengan header
$app->add(function ($request, $response, $next) {
    $response_without_header = $next($request, $response);
    return $response_without_header
        ->withHeader('Access-Control-Allow-Origin', getenv("APP_URL"))
        ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
        ->withHeader('Access-Control-Allow-Methods', 'GET, POST');
});
