<?php

declare(strict_types=1);

function admin_base_dir(): string {
    return dirname(__DIR__);
}

function admin_load_config(): array {
    $cfgPath = admin_base_dir() . DIRECTORY_SEPARATOR . 'api' . DIRECTORY_SEPARATOR . 'config.php';
    $cfg = require $cfgPath;
    return is_array($cfg) ? $cfg : [];
}

function admin_connect_db(array $config): PDO {
    $db = $config['db'] ?? [];
    $host = (string)($db['host'] ?? '127.0.0.1');
    $port = (int)($db['port'] ?? 3306);
    $name = (string)($db['name'] ?? 'travel');
    $user = (string)($db['user'] ?? 'root');
    $pass = (string)($db['pass'] ?? '');
    $charset = (string)($db['charset'] ?? 'utf8mb4');

    $dsn = "mysql:host={$host};port={$port};dbname={$name};charset={$charset}";
    return new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
}

function admin_h(string $value): string {
    return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function admin_redirect(string $to): void {
    header('Location: ' . $to);
    exit;
}

function admin_csrf_token(): string {
    if (session_status() !== PHP_SESSION_ACTIVE) session_start();
    if (!isset($_SESSION['csrf']) || !is_string($_SESSION['csrf']) || $_SESSION['csrf'] === '') {
        $_SESSION['csrf'] = bin2hex(random_bytes(16));
    }
    return $_SESSION['csrf'];
}

function admin_verify_csrf(): void {
    if (session_status() !== PHP_SESSION_ACTIVE) session_start();
    $token = (string)($_POST['csrf'] ?? '');
    $expected = (string)($_SESSION['csrf'] ?? '');
    if ($token === '' || $expected === '' || !hash_equals($expected, $token)) {
        http_response_code(403);
        echo 'Forbidden';
        exit;
    }
}

