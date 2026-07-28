<?php

declare(strict_types=1);

require __DIR__ . DIRECTORY_SEPARATOR . '_layout_top.php';

$config = admin_load_config();
$db = admin_connect_db($config);

$items = $db->query(
    'SELECT id, created_at, name, email, phone, message
     FROM contact_messages
     ORDER BY id DESC'
)->fetchAll();

?>
<div class="card">
    <h2 style="margin:0 0 10px;">Сообщения</h2>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Дата</th>
                <th>Имя</th>
                <th>Контакты</th>
                <th>Сообщение</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($items as $r): ?>
            <tr>
                <td><?=admin_h((string)$r['id'])?></td>
                <td><?=admin_h((string)$r['created_at'])?></td>
                <td><?=admin_h((string)$r['name'])?></td>
                <td>
                    <div><?=admin_h((string)$r['email'])?></div>
                    <div class="muted"><?=admin_h((string)($r['phone'] ?? ''))?></div>
                </td>
                <td style="white-space:pre-wrap;"><?=admin_h((string)$r['message'])?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php
require __DIR__ . DIRECTORY_SEPARATOR . '_layout_bottom.php';

