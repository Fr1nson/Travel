<?php

declare(strict_types=1);

require __DIR__ . DIRECTORY_SEPARATOR . '_layout_top.php';

$config = admin_load_config();
$db = admin_connect_db($config);

$items = $db->query(
    'SELECT b.id, b.created_at, b.name, b.phone, b.email, b.start_date, b.end_date, b.guests, b.note, t.title AS tour_title
     FROM bookings b
     LEFT JOIN tours t ON t.id = b.tour_id
     ORDER BY b.id DESC'
)->fetchAll();

?>
<div class="card">
    <h2 style="margin:0 0 10px;">Заявки на бронирование</h2>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Дата</th>
                <th>Клиент</th>
                <th>Тур</th>
                <th>Даты</th>
                <th>Туристы</th>
                <th>Контакты</th>
                <th>Комментарий</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($items as $r): ?>
            <tr>
                <td><?=admin_h((string)$r['id'])?></td>
                <td><?=admin_h((string)$r['created_at'])?></td>
                <td><?=admin_h((string)$r['name'])?></td>
                <td><?=admin_h((string)($r['tour_title'] ?? 'Подбор тура'))?></td>
                <td><?=admin_h((string)$r['start_date'])?> → <?=admin_h((string)$r['end_date'])?></td>
                <td><?=admin_h((string)$r['guests'])?></td>
                <td>
                    <div><?=admin_h((string)$r['phone'])?></div>
                    <div class="muted"><?=admin_h((string)$r['email'])?></div>
                </td>
                <td><?=admin_h((string)($r['note'] ?? ''))?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php
require __DIR__ . DIRECTORY_SEPARATOR . '_layout_bottom.php';

