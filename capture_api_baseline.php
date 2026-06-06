<?php

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Http\Request;

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$routes = [
    '/api/homeWithNoAuth' => 'GET',
    '/api/course/more' => 'GET',
    '/api/homeWithNoAuth/showMoreBestselling' => 'GET',
    '/api/homeWithNoAuth/showMoreMostPopulars' => 'GET',
    '/api/courses/more' => 'GET',
    '/api/course/show/1' => 'GET',
    '/api/course/search/Laravel' => 'GET',
    '/api/course/categories' => 'GET',
    '/api/course/sub/categories/1' => 'GET',
    '/api/course/sub/category/courses/1' => 'GET',
    '/api/course/comments/4/1' => 'POST',
    '/api/course/comments/1' => 'POST',
];

$baseline = [];

foreach ($routes as $uri => $method) {
    $request = Request::create($uri, $method);
    $response = $kernel->handle($request);
    $baseline[$uri] = json_decode($response->getContent(), true);
    $kernel->terminate($request, $response);
}

file_put_contents('api_baseline.json', json_encode($baseline, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
echo "Baseline captured to api_baseline.json\n";
