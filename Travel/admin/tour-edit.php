<?php

declare(strict_types=1);

require __DIR__ . DIRECTORY_SEPARATOR . '_layout_top.php';

$config = admin_load_config();
$db = admin_connect_db($config);
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$departureOptions = [
    'moscow' => 'Москва',
    'spb' => 'Санкт‑Петербург',
    'kazan' => 'Казань'
];

$defaults = [
    'id' => '',
    'title' => '',
    'country' => 'turkey',
    'type' => 'beach',
    'price' => '0',
    'nights' => '7',
    'image' => 'img/turkiya.jpeg',
    'description' => '',
    'resort' => '',
    'meal' => 'ai',
    'hotel_stars' => '5',
    'max_guests' => '6',
    'available_from' => '',
    'available_to' => ''
];

$values = $defaults;
$selectedDepartures = ['moscow'];
$error = '';
$saved = false;

if ($id > 0) {
    $stmt = $db->prepare('SELECT * FROM tours WHERE id = :id');
    $stmt->execute([':id' => $id]);
    $tour = $stmt->fetch();
    if (!$tour) {
        http_response_code(404);
        echo 'Not Found';
        exit;
    }
    foreach ($values as $k => $_) {
        if (array_key_exists($k, $tour) && $tour[$k] !== null) $values[$k] = (string)$tour[$k];
    }
    $dep = $db->prepare('SELECT city_code FROM tour_departures WHERE tour_id = :id');
    $dep->execute([':id' => $id]);
    $selectedDepartures = array_map(fn($r) => $r['city_code'], $dep->fetchAll());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    admin_verify_csrf();
    foreach ($values as $k => $_) {
        if (isset($_POST[$k])) $values[$k] = trim((string)$_POST[$k]);
    }
    $selectedDepartures = array_values(array_filter(array_map('trim', (array)($_POST['departures'] ?? []))));
    $selectedDepartures = array_values(array_intersect($selectedDepartures, array_keys($departureOptions)));

    if ($values['title'] === '' || $values['country'] === '' || $values['type'] === '' || $values['image'] === '' || $values['description'] === '') {
        $error = 'Заполни обязательные поля.';
    } elseif ((int)$values['price'] <= 0 || (int)$values['nights'] <= 0) {
        $error = 'Цена и ночи должны быть больше 0.';
    } elseif (count($selectedDepartures) === 0) {
        $error = 'Выбери хотя бы один город вылета.';
    } else {
        $payload = [
            ':id' => $id > 0 ? $id : (int)$values['id'],
            ':title' => $values['title'],
            ':country' => $values['country'],
            ':type' => $values['type'],
            ':price' => (int)$values['price'],
            ':nights' => (int)$values['nights'],
            ':image' => $values['image'],
            ':description' => $values['description'],
            ':resort' => $values['resort'] !== '' ? $values['resort'] : null,
            ':meal' => $values['meal'] !== '' ? $values['meal'] : null,
            ':hotel_stars' => $values['hotel_stars'] !== '' ? (int)$values['hotel_stars'] : null,
            ':max_guests' => $values['max_guests'] !== '' ? (int)$values['max_guests'] : null,
            ':available_from' => $values['available_from'] !== '' ? $values['available_from'] : null,
            ':available_to' => $values['available_to'] !== '' ? $values['available_to'] : null
        ];

        try {
            if ($payload[':id'] <= 0) {
                $error = 'ID тура обязателен для нового тура.';
            } else {
                $stmt = $db->prepare(
                    'INSERT INTO tours (id, title, country, type, price, nights, image, description, resort, meal, hotel_stars, max_guests, available_from, available_to)
                     VALUES (:id, :title, :country, :type, :price, :nights, :image, :description, :resort, :meal, :hotel_stars, :max_guests, :available_from, :available_to)
                     ON DUPLICATE KEY UPDATE
                       title=VALUES(title),
                       country=VALUES(country),
                       type=VALUES(type),
                       price=VALUES(price),
                       nights=VALUES(nights),
                       image=VALUES(image),
                       description=VALUES(description),
                       resort=VALUES(resort),
                       meal=VALUES(meal),
                       hotel_stars=VALUES(hotel_stars),
                       max_guests=VALUES(max_guests),
                       available_from=VALUES(available_from),
                       available_to=VALUES(available_to)'
                );
                $stmt->execute($payload);

                $tourId = (int)$payload[':id'];
                $db->prepare('DELETE FROM tour_departures WHERE tour_id = :id')->execute([':id' => $tourId]);
                $stmtDep = $db->prepare('INSERT INTO tour_departures (tour_id, city_code) VALUES (:tour_id, :city)');
                foreach ($selectedDepartures as $city) {
                    $stmtDep->execute([':tour_id' => $tourId, ':city' => $city]);
                }

                $saved = true;
                $id = $tourId;
            }
        } catch (Throwable $e) {
            $error = 'Ошибка сохранения: ' . $e->getMessage();
        }
    }
}

$csrf = admin_csrf_token();

?>
<div class="card">
    <div style="display:flex;align-items:center;justify-content:space-between;gap:12px;flex-wrap:wrap;">
        <h2 style="margin:0;"><?= $id > 0 ? 'Редактирование тура' : 'Новый тур' ?></h2>
        <a class="btn secondary" href="tours.php">Назад</a>
    </div>
    <?php if ($error !== ''): ?>
        <div class="msg err"><?=admin_h($error)?></div>
    <?php elseif ($saved): ?>
        <div class="msg ok">Сохранено.</div>
    <?php endif; ?>

    <form method="post">
        <input type="hidden" name="csrf" value="<?=admin_h($csrf)?>">
        <div class="grid">
            <div>
                <label>ID</label>
                <input name="id" value="<?=admin_h($values['id'] ?: (string)$id)?>" <?= $id > 0 ? 'readonly' : '' ?> required>
            </div>
            <div>
                <label>Цена (₽)</label>
                <input name="price" type="number" min="1" value="<?=admin_h($values['price'])?>" required>
            </div>
            <div>
                <label>Название</label>
                <input name="title" value="<?=admin_h($values['title'])?>" required>
            </div>
            <div>
                <label>Ночей</label>
                <input name="nights" type="number" min="1" max="30" value="<?=admin_h($values['nights'])?>" required>
            </div>
            <div>
                <label>Страна (код)</label>
                <input name="country" value="<?=admin_h($values['country'])?>" required>
            </div>
            <div>
                <label>Тип</label>
                <select name="type" required>
                    <?php foreach (['beach'=>'Пляж','mountains'=>'Горы','excursion'=>'Экскурсии'] as $k=>$label): ?>
                        <option value="<?=admin_h($k)?>" <?= $values['type']===$k?'selected':'' ?>><?=admin_h($label)?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label>Курорт</label>
                <input name="resort" value="<?=admin_h($values['resort'])?>">
            </div>
            <div>
                <label>Питание</label>
                <select name="meal">
                    <?php foreach (['ai'=>'All Inclusive','hb'=>'Half Board','bb'=>'Breakfast','ro'=>'Без питания'] as $k=>$label): ?>
                        <option value="<?=admin_h($k)?>" <?= $values['meal']===$k?'selected':'' ?>><?=admin_h($label)?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label>Звёзды</label>
                <select name="hotel_stars">
                    <?php foreach ([''=>'—', '3'=>'3', '4'=>'4', '5'=>'5'] as $k=>$label): ?>
                        <option value="<?=admin_h($k)?>" <?= $values['hotel_stars']===$k?'selected':'' ?>><?=admin_h($label)?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label>Макс. туристов</label>
                <input name="max_guests" type="number" min="1" max="20" value="<?=admin_h($values['max_guests'])?>">
            </div>
            <div>
                <label>Доступно с</label>
                <input name="available_from" type="date" value="<?=admin_h($values['available_from'])?>">
            </div>
            <div>
                <label>Доступно до</label>
                <input name="available_to" type="date" value="<?=admin_h($values['available_to'])?>">
            </div>
            <div style="grid-column:1 / -1;">
                <label>Изображение (путь)</label>
                <input name="image" value="<?=admin_h($values['image'])?>" required>
            </div>
            <div style="grid-column:1 / -1;">
                <label>Описание</label>
                <textarea name="description" required><?=admin_h($values['description'])?></textarea>
            </div>
            <div style="grid-column:1 / -1;">
                <label>Города вылета</label>
                <div style="display:flex;gap:14px;flex-wrap:wrap;">
                    <?php foreach ($departureOptions as $code => $label): ?>
                        <label style="display:flex;align-items:center;gap:8px;font-weight:800;margin:0;">
                            <input type="checkbox" name="departures[]" value="<?=admin_h($code)?>" <?= in_array($code, $selectedDepartures, true) ? 'checked' : '' ?> style="width:auto;">
                            <span><?=admin_h($label)?></span>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <div style="margin-top:14px;display:flex;gap:10px;flex-wrap:wrap;">
            <button class="btn" type="submit">Сохранить</button>
            <a class="btn secondary" href="../tours-all.html">Открыть каталог</a>
        </div>
    </form>
</div>

<?php
require __DIR__ . DIRECTORY_SEPARATOR . '_layout_bottom.php';

