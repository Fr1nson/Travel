<?php

declare(strict_types=1);

require __DIR__ . DIRECTORY_SEPARATOR . '_auth.php';
admin_require_login();

$email = admin_current_user_email();

?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TRAVEL · Admin</title>
    <link rel="stylesheet" href="assets/admin.css">
</head>
<body>
<div class="topbar">
    <div class="wrap">
        <div class="brand">TRAVEL · Admin</div>
        <div class="nav">
            <a href="index.php">Дашборд</a>
            <a href="tours.php">Туры</a>
            <a href="bookings.php">Заявки</a>
            <a href="messages.php">Сообщения</a>
            <a href="newsletter.php">Подписки</a>
            <a href="logout.php">Выход</a>
        </div>
    </div>
</div>
<div class="wrap">
    <div class="muted" style="margin:14px 0;">Пользователь: <?=admin_h($email ?? '')?></div>

