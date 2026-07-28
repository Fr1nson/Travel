<?php

declare(strict_types=1);

require __DIR__ . DIRECTORY_SEPARATOR . '_layout_top.php';

$config = admin_load_config();
$db = admin_connect_db($config);
$msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'delete') {
    admin_verify_csrf();
    $id = (int)($_POST['id'] ?? 0);
    if ($id > 0) {
        $stmt = $db->prepare('DELETE FROM tours WHERE id = :id');
        $stmt->execute([':id' => $id]);
        $msg = 'Тур удалён.';
    }
}

$items = $db->query('SELECT id, title, country, type, price, nights, hotel_stars FROM tours ORDER BY id DESC')->fetchAll();
$csrf = admin_csrf_token();

?>
<div class="card">
    <div style="display:flex;align-items:center;justify-content:space-between;gap:12px;flex-wrap:wrap;">
        <h2 style="margin:0;">Туры</h2>
        <a class="btn" href="tour-edit.php">Добавить тур</a>
    </div>
    <?php if ($msg !== ''): ?>
        <div class="msg ok"><?=admin_h($msg)?></div>
    <?php endif; ?>
    <table class="table" style="margin-top:10px;">
        <thead>
            <tr>
                <th>ID</th>
                <th>Название</th>
                <th>Страна</th>
                <th>Тип</th>
                <th>Ночи</th>
                <th>Звёзды</th>
                <th>Цена</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($items as $t): ?>
            <tr>
                <td><?=admin_h((string)$t['id'])?></td>
                <td><?=admin_h((string)$t['title'])?></td>
                <td><span class="pill"><?=admin_h((string)$t['country'])?></span></td>
                <td><span class="pill"><?=admin_h((string)$t['type'])?></span></td>
                <td><?=admin_h((string)$t['nights'])?></td>
                <td><?=admin_h((string)($t['hotel_stars'] ?? ''))?></td>
                <td><?=admin_h(number_format((int)$t['price'], 0, '.', ' '))?> ₽</td>
                <td class="row-actions" style="white-space:nowrap;">
                    <a class="btn secondary" href="tour-edit.php?id=<?=admin_h((string)$t['id'])?>">Редактировать</a>
                    <form method="post" style="display:inline;" onsubmit="return confirm('Удалить тур?');">
                        <input type="hidden" name="csrf" value="<?=admin_h($csrf)?>">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="id" value="<?=admin_h((string)$t['id'])?>">
                        <button class="btn danger" type="submit">Удалить</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php
require __DIR__ . DIRECTORY_SEPARATOR . '_layout_bottom.php';

