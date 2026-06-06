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

$baseline = json_decode(file_get_contents('api_baseline.json'), true);
$current = [];

foreach ($routes as $uri => $method) {
    $request = Request::create($uri, $method);
    $response = $kernel->handle($request);
    $current[$uri] = json_decode($response->getContent(), true);
    $kernel->terminate($request, $response);
}

$success = true;
foreach ($routes as $uri => $method) {
    if ($uri === '/api/course/more') {
        // Skip random order check but verify structure
        if (count($current[$uri] ?? []) !== count($baseline[$uri] ?? [])) {
             echo "Mismatch in /api/course/more structure\n";
             $success = false;
        }
        continue;
    }
    if (json_encode($current[$uri]) !== json_encode($baseline[$uri])) {
        echo "Mismatch in $uri\n";
        echo "Baseline: " . json_encode($baseline[$uri]) . "\n";
        echo "Current:  " . json_encode($current[$uri]) . "\n";
        $success = false;
    }
}

if ($success) {
    echo "API verification successful!\n";
} else {
    echo "API verification failed!\n";
    exit(1);
}
