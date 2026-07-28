<?php

declare(strict_types=1);

require __DIR__ . DIRECTORY_SEPARATOR . '_bootstrap.php';

if (session_status() !== PHP_SESSION_ACTIVE) session_start();

$config = admin_load_config();
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = strtolower(trim((string)($_POST['email'] ?? '')));
    $pass = (string)($_POST['password'] ?? '');

    if ($email === '' || $pass === '') {
        $error = 'Введите email и пароль.';
    } else {
        try {
            $db = admin_connect_db($config);
            $stmt = $db->prepare('SELECT email, password_hash FROM admin_users WHERE email = :email LIMIT 1');
            $stmt->execute([':email' => $email]);
            $user = $stmt->fetch();
            if ($user && is_string($user['password_hash']) && password_verify($pass, $user['password_hash'])) {
                $_SESSION['admin_email'] = $user['email'];
                admin_csrf_token();
                admin_redirect('index.php');
            }
            $error = 'Неверный email или пароль.';
        } catch (Throwable $e) {
            $error = 'Не удалось подключиться к БД. Сначала запусти установку /setup.php.';
        }
    }
}

?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Админка TRAVEL — вход</title>
    <link rel="stylesheet" href="assets/admin.css">
</head>
<body>
<div class="topbar">
    <div class="wrap">
        <div class="brand">TRAVEL · Admin</div>
    </div>
</div>
<div class="wrap">
    <div class="card" style="max-width:520px;margin:18px auto;">
        <h2 style="margin:0 0 10px;">Вход</h2>
        <div class="muted">Если ещё не настроено — открой <a href="../setup.php">setup.php</a></div>
        <?php if ($error !== ''): ?>
            <div class="msg err"><?=admin_h($error)?></div>
        <?php endif; ?>
        <form method="post" style="margin-top:10px;">
            <label>Email</label>
            <input name="email" type="email" autocomplete="username" required>
            <label style="margin-top:10px;">Пароль</label>
            <input name="password" type="password" autocomplete="current-password" required>
            <button class="btn" type="submit" style="margin-top:14px;width:100%;">Войти</button>
        </form>
    </div>
</div>
</body>
</html>

