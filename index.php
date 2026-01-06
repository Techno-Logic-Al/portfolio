<?php

declare(strict_types=1);

$path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
$path = rtrim($path, '/') ?: '/';

$routes = [
    '/' => __DIR__ . '/public/index.php',
    '/about-me' => __DIR__ . '/public/about-me.php',
    '/projects' => __DIR__ . '/public/projects.php',
    '/coding-examples' => __DIR__ . '/public/coding-examples.php',
    '/scion-scheme' => __DIR__ . '/public/scion-scheme.php',
    '/contact' => __DIR__ . '/public/contact.php',
];

if (isset($routes[$path])) {
    require $routes[$path];
    exit;
}

http_response_code(404);
require __DIR__ . '/public/404.php';

