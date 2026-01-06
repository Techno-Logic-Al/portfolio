<?php
/**
 * Simple PDO connection helper using .env configuration.
 */

function loadEnv(string $path): void
{
    if (!is_readable($path)) {
        return;
    }

    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    foreach ($lines as $line) {
        $line = trim($line);

        if ($line === '' || strpos($line, '#') === 0) {
            continue;
        }

        $parts = explode('=', $line, 2);

        if (count($parts) !== 2) {
            continue;
        }

        $name = trim($parts[0]);
        $value = trim($parts[1]);

        if ($name === '') {
            continue;
        }

        // Make values available via getenv(), $_ENV and $_SERVER.
        putenv("$name=$value");
        $_ENV[$name] = $value;
        $_SERVER[$name] = $value;
    }
}

/**
 * Get a shared PDO instance configured from .env.
 */
function getPdo(): PDO
{
    static $pdo = null;

    if ($pdo instanceof PDO) {
        return $pdo;
    }

    $rootDir = dirname(__DIR__);
    loadEnv($rootDir . DIRECTORY_SEPARATOR . '.env');

    $host = getenv('DB_HOST') ?: 'localhost';
    $db   = getenv('DB_NAME') ?: '';
    $user = getenv('DB_USER') ?: '';
    $pass = getenv('DB_PASS') ?: '';
    $charset = getenv('DB_CHARSET') ?: 'utf8mb4';

$port = getenv('DB_PORT') ?: '3306';
$dsn = "mysql:host={$host};port={$port};dbname={$db};charset={$charset}";

    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    try {
        $pdo = new PDO($dsn, $user, $pass, $options);
    } catch (PDOException $e) {
        throw new RuntimeException('Database connection error. Please try again later.', 0, $e);
    }

    return $pdo;
}
