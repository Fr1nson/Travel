<?php

declare(strict_types=1);

require __DIR__ . DIRECTORY_SEPARATOR . '_layout_top.php';

$config = admin_load_config();
$db = admin_connect_db($config);

$items = $db->query(
    'SELECT id, created_at, email
     FROM newsletter_subscribers
     ORDER BY id DESC'
)->fetchAll();

?>
<div class="card">
    <h2 style="margin:0 0 10px;">Подписки на рассылку</h2>
    <div class="muted" style="margin-bottom:10px;">Всего: <?=admin_h((string)count($items))?></div>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Дата</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($items as $r): ?>
            <tr>
                <td><?=admin_h((string)$r['id'])?></td>
                <td><?=admin_h((string)$r['created_at'])?></td>
                <td><?=admin_h((string)$r['email'])?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php
require __DIR__ . DIRECTORY_SEPARATOR . '_layout_bottom.php';

