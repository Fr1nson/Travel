<?php

declare(strict_types=1);

$config = [
    'db' => [
        'host' => '127.0.0.1',
        'port' => 3306,
        'name' => 'travel',
        'user' => 'root',
        'pass' => '',
        'charset' => 'utf8mb4'
    ]
];

$localPath = __DIR__ . DIRECTORY_SEPARATOR . 'config.local.php';
if (is_file($localPath)) {
    $local = require $localPath;
    if (is_array($local)) {
        $config = array_replace_recursive($config, $local);
    }
}

return $config;

