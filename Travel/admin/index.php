<?php

declare(strict_types=1);

require __DIR__ . DIRECTORY_SEPARATOR . '_layout_top.php';

$config = admin_load_config();
$db = null;
$stats = [
    'tours' => 0,
    'bookings' => 0,
    'messages' => 0,
    'subscribers' => 0
];

try {
    $db = admin_connect_db($config);
    $stats['tours'] = (int)($db->query('SELECT COUNT(*) AS c FROM tours')->fetch()['c'] ?? 0);
    $stats['bookings'] = (int)($db->query('SELECT COUNT(*) AS c FROM bookings')->fetch()['c'] ?? 0);
    $stats['messages'] = (int)($db->query('SELECT COUNT(*) AS c FROM contact_messages')->fetch()['c'] ?? 0);
    $stats['subscribers'] = (int)($db->query('SELECT COUNT(*) AS c FROM newsletter_subscribers')->fetch()['c'] ?? 0);
} catch (Throwable $e) {
}

?>
<div class="card">
    <h2 style="margin:0 0 10px;">Дашборд</h2>
    <div class="grid">
        <div class="card">
            <div class="muted">Туры</div>
            <div style="font-size:34px;font-weight:900;"><?=admin_h((string)$stats['tours'])?></div>
            <div style="margin-top:10px;"><a class="btn secondary" href="tours.php">Управлять турами</a></div>
        </div>
        <div class="card">
            <div class="muted">Заявки</div>
            <div style="font-size:34px;font-weight:900;"><?=admin_h((string)$stats['bookings'])?></div>
            <div style="margin-top:10px;"><a class="btn secondary" href="bookings.php">Смотреть заявки</a></div>
        </div>
        <div class="card">
            <div class="muted">Сообщения</div>
            <div style="font-size:34px;font-weight:900;"><?=admin_h((string)$stats['messages'])?></div>
            <div style="margin-top:10px;"><a class="btn secondary" href="messages.php">Смотреть сообщения</a></div>
        </div>
        <div class="card">
            <div class="muted">Подписки</div>
            <div style="font-size:34px;font-weight:900;"><?=admin_h((string)$stats['subscribers'])?></div>
            <div style="margin-top:10px;"><a class="btn secondary" href="newsletter.php">Список email</a></div>
        </div>
    </div>
</div>

<?php
require __DIR__ . DIRECTORY_SEPARATOR . '_layout_bottom.php';

