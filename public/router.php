<?php

declare(strict_types=1);

$path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
$path = rtrim($path, '/') ?: '/';

$fullPath = __DIR__ . $path;
if ($path !== '/' && is_file($fullPath)) {
    return false;
}

$routes = [
    '/' => '/index.php',
    '/about-me' => '/about-me.php',
    '/projects' => '/projects.php',
    '/coding-examples' => '/coding-examples.php',
    '/scion-scheme' => '/scion-scheme.php',
    '/contact' => '/contact.php',
];

if (isset($routes[$path])) {
    require __DIR__ . $routes[$path];
    return true;
}

http_response_code(404);
require __DIR__ . '/404.php';

