<?php

declare(strict_types=1);

/**
 * Base path helper for running the site:
 * - at domain root (e.g. https://example.com/)
 * - in a subdirectory (e.g. http://localhost/portfolio/)
 */

$scriptName = (string) ($_SERVER['SCRIPT_NAME'] ?? '');
$basePath = '';

if ($scriptName !== '') {
    $basePath = str_replace('\\', '/', dirname($scriptName));
    if ($basePath === '/' || $basePath === '.') {
        $basePath = '';
    }
}

if (!defined('BASE_PATH')) {
    define('BASE_PATH', $basePath);
}

function url(string $path = '/'): string
{
    $path = '/' . ltrim($path, '/');

    if ($path === '/') {
        return (BASE_PATH ?: '') . '/';
    }

    return (BASE_PATH ?: '') . $path;
}

function asset(string $path): string
{
    return url($path);
}

function currentPath(): string
{
    $path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
    $path = rtrim($path, '/') ?: '/';

    if (BASE_PATH !== '' && str_starts_with($path, BASE_PATH)) {
        $path = substr($path, strlen(BASE_PATH)) ?: '/';
        $path = rtrim($path, '/') ?: '/';
    }

    return $path;
}

