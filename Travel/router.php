<?php

declare(strict_types=1);

$starts_with = function (string $haystack, string $needle): bool {
    if (function_exists('str_starts_with')) {
        return str_starts_with($haystack, $needle);
    }
    return substr($haystack, 0, strlen($needle)) === $needle;
};

$uri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
if (is_string($uri) && $starts_with($uri, '/api/')) {
    require __DIR__ . '/api/index.php';
    exit;
}

$path = realpath(__DIR__ . $uri);
$root = realpath(__DIR__);
if ($path !== false && $root !== false && $starts_with($path, $root) && is_file($path)) {
    return false;
}

$fallback = __DIR__ . '/index.html';
if (is_file($fallback)) {
    header('Content-Type: text/html; charset=utf-8');
    readfile($fallback);
    exit;
}

http_response_code(404);
echo 'Not Found';
