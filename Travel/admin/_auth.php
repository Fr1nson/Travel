<?php

declare(strict_types=1);

require __DIR__ . DIRECTORY_SEPARATOR . '_bootstrap.php';

if (session_status() !== PHP_SESSION_ACTIVE) session_start();

function admin_current_user_email(): ?string {
    $email = $_SESSION['admin_email'] ?? null;
    return is_string($email) && $email !== '' ? $email : null;
}

function admin_require_login(): void {
    if (admin_current_user_email() === null) {
        admin_redirect('login.php');
    }
}

