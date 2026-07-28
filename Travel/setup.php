<?php

declare(strict_types=1);

function h(string $value): string {
    return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function base_dir(): string {
    return __DIR__;
}

function data_dir(): string {
    return base_dir() . DIRECTORY_SEPARATOR . 'data';
}

function lock_path(): string {
    if (!is_dir(data_dir())) mkdir(data_dir(), 0777, true);
    return data_dir() . DIRECTORY_SEPARATOR . 'installed.lock';
}

function migrations_dir(): string {
    return base_dir() . DIRECTORY_SEPARATOR . 'migrations';
}

function apply_migrations(PDO $db): void {
    $files = glob(migrations_dir() . DIRECTORY_SEPARATOR . '*.sql');
    sort($files);

    $db->exec(
        "CREATE TABLE IF NOT EXISTS schema_migrations (
            filename VARCHAR(255) NOT NULL,
            applied_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (filename)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;"
    );

    $check = $db->prepare('SELECT 1 FROM schema_migrations WHERE filename = :filename LIMIT 1');
    $mark = $db->prepare('INSERT IGNORE INTO schema_migrations (filename) VALUES (:filename)');

    $appliedCount = (int)($db->query('SELECT COUNT(*) AS c FROM schema_migrations')->fetchColumn() ?: 0);
    if ($appliedCount === 0) {
        $hasToursTable = (bool)$db
            ->query("SELECT 1 FROM information_schema.tables WHERE table_schema = DATABASE() AND table_name = 'tours' LIMIT 1")
            ->fetchColumn();
        if ($hasToursTable) {
            foreach ($files as $file) {
                $mark->execute([':filename' => basename($file)]);
            }
            return;
        }
    }

    foreach ($files as $file) {
        $filename = basename($file);
        $check->execute([':filename' => $filename]);
        if ($check->fetchColumn()) continue;

        $sql = file_get_contents($file);
        if ($sql === false) continue;
        $db->exec($sql);
        $mark->execute([':filename' => $filename]);
    }
}

function seed_if_empty(PDO $db): void {
    $row = $db->query('SELECT COUNT(*) AS c FROM tours')->fetch(PDO::FETCH_ASSOC);
    if ($row && (int)$row['c'] > 0) return;

    $tours = [
        [
            'id' => 1,
            'title' => 'Мальдивы - Райский Остров',
            'country' => 'maldives',
            'type' => 'beach',
            'price' => 185000,
            'nights' => 10,
            'image' => 'img/mald1.jpg',
            'description' => 'Незабываемый отдых на белоснежных пляжах Мальдив. Проживание в роскошном отеле 5*, питание all inclusive, трансфер и экскурсии включены.',
            'resort' => 'Мале',
            'meal' => 'ai',
            'hotel_stars' => 5,
            'max_guests' => 6,
            'available_from' => '2026-01-15',
            'available_to' => '2026-12-20',
            'departures' => ['moscow', 'spb', 'kazan']
        ],
        [
            'id' => 2,
            'title' => 'Швейцарские Альпы',
            'country' => 'switzerland',
            'type' => 'mountains',
            'price' => 245000,
            'nights' => 7,
            'image' => 'img/alps2.png',
            'description' => 'Горнолыжный тур в Швейцарию. Катание на лучших склонах Европы, проживание в шале, инструктор включен.',
            'resort' => 'Церматт',
            'meal' => 'hb',
            'hotel_stars' => 4,
            'max_guests' => 5,
            'available_from' => '2026-01-10',
            'available_to' => '2026-03-20',
            'departures' => ['moscow', 'spb']
        ],
        [
            'id' => 3,
            'title' => 'Романтический Париж',
            'country' => 'france',
            'type' => 'excursion',
            'price' => 95000,
            'nights' => 5,
            'image' => 'img/paris3.jpg',
            'description' => 'Экскурсионный тур по Парижу и его окрестностям. Эйфелева башня, Лувр, Версаль. Русскоязычный гид.',
            'resort' => 'Париж',
            'meal' => 'bb',
            'hotel_stars' => 4,
            'max_guests' => 6,
            'available_from' => '2026-02-01',
            'available_to' => '2026-12-15',
            'departures' => ['moscow', 'spb', 'kazan']
        ],
        [
            'id' => 4,
            'title' => 'Греческие Острова',
            'country' => 'greece',
            'type' => 'beach',
            'price' => 165000,
            'nights' => 8,
            'image' => 'img/grecOstr4.jpg',
            'description' => 'Круиз по островам Греции: Санторини, Миконос, Крит. Проживание на яхте, питание включено.',
            'resort' => 'Санторини',
            'meal' => 'hb',
            'hotel_stars' => 4,
            'max_guests' => 6,
            'available_from' => '2026-04-01',
            'available_to' => '2026-10-31',
            'departures' => ['moscow', 'spb']
        ],
        [
            'id' => 5,
            'title' => 'Япония - Цветение Сакуры',
            'country' => 'japan',
            'type' => 'excursion',
            'price' => 285000,
            'nights' => 12,
            'image' => 'img/japan5.jpg',
            'description' => 'Тур в Японию в период цветения сакуры. Токио, Киото, Осака. Посещение храмов и традиционных садов.',
            'resort' => 'Токио',
            'meal' => 'bb',
            'hotel_stars' => 4,
            'max_guests' => 5,
            'available_from' => '2026-03-15',
            'available_to' => '2026-04-20',
            'departures' => ['moscow']
        ],
        [
            'id' => 6,
            'title' => 'Турция - Анталья',
            'country' => 'turkey',
            'type' => 'beach',
            'price' => 98000,
            'nights' => 7,
            'image' => 'img/turkiya.jpeg',
            'description' => 'Классический пляжный отдых в Анталье. Отель у моря, бассейн, питание all inclusive.',
            'resort' => 'Анталья',
            'meal' => 'ai',
            'hotel_stars' => 5,
            'max_guests' => 6,
            'available_from' => '2026-04-10',
            'available_to' => '2026-11-10',
            'departures' => ['moscow', 'spb', 'kazan']
        ],
        [
            'id' => 7,
            'title' => 'Турция - Аланья',
            'country' => 'turkey',
            'type' => 'beach',
            'price' => 82000,
            'nights' => 6,
            'image' => 'img/turkiya.jpeg',
            'description' => 'Комфортный отдых в Аланье: пляж, прогулки, удобный формат для пары или семьи.',
            'resort' => 'Аланья',
            'meal' => 'hb',
            'hotel_stars' => 4,
            'max_guests' => 6,
            'available_from' => '2026-04-10',
            'available_to' => '2026-11-15',
            'departures' => ['moscow', 'spb']
        ],
        [
            'id' => 8,
            'title' => 'Египет - Хургада',
            'country' => 'egypt',
            'type' => 'beach',
            'price' => 89000,
            'nights' => 8,
            'image' => 'img/bali.jpg',
            'description' => 'Тёплое Красное море, снорклинг и комфортные отели. Отлично для отдыха круглый год.',
            'resort' => 'Хургада',
            'meal' => 'ai',
            'hotel_stars' => 4,
            'max_guests' => 6,
            'available_from' => '2026-01-10',
            'available_to' => '2026-12-25',
            'departures' => ['moscow', 'kazan']
        ],
        [
            'id' => 9,
            'title' => 'Египет - Шарм‑эль‑Шейх',
            'country' => 'egypt',
            'type' => 'beach',
            'price' => 102000,
            'nights' => 9,
            'image' => 'img/bali.jpg',
            'description' => 'Идеально для дайвинга и пляжного отдыха. Красивые рифы и насыщенная экскурсионка.',
            'resort' => 'Шарм‑эль‑Шейх',
            'meal' => 'ai',
            'hotel_stars' => 5,
            'max_guests' => 6,
            'available_from' => '2026-01-10',
            'available_to' => '2026-12-25',
            'departures' => ['moscow', 'spb']
        ],
        [
            'id' => 10,
            'title' => 'ОАЭ - Дубай',
            'country' => 'uae',
            'type' => 'beach',
            'price' => 165000,
            'nights' => 7,
            'image' => 'img/4.jpg',
            'description' => 'Современный мегаполис и пляжи Персидского залива. Шопинг, развлечения и море.',
            'resort' => 'Дубай',
            'meal' => 'bb',
            'hotel_stars' => 5,
            'max_guests' => 6,
            'available_from' => '2026-01-05',
            'available_to' => '2026-12-25',
            'departures' => ['moscow', 'spb', 'kazan']
        ],
        [
            'id' => 11,
            'title' => 'Россия - Красная Поляна',
            'country' => 'russia',
            'type' => 'mountains',
            'price' => 54000,
            'nights' => 5,
            'image' => 'img/kavkaz.jpg',
            'description' => 'Горы, термальные источники и прогулки. Отлично для короткого отдыха на выходные.',
            'resort' => 'Красная Поляна',
            'meal' => 'ro',
            'hotel_stars' => 3,
            'max_guests' => 5,
            'available_from' => '2026-01-10',
            'available_to' => '2026-12-25',
            'departures' => ['moscow', 'spb', 'kazan']
        ],
    ];

    $stmtTour = $db->prepare(
        'INSERT INTO tours (id, title, country, type, price, nights, image, description, resort, meal, hotel_stars, max_guests, available_from, available_to)
         VALUES (:id, :title, :country, :type, :price, :nights, :image, :description, :resort, :meal, :hotel_stars, :max_guests, :available_from, :available_to)'
    );
    $stmtDep = $db->prepare('INSERT INTO tour_departures (tour_id, city_code) VALUES (:tour_id, :city_code)');

    foreach ($tours as $tour) {
        $stmtTour->execute([
            ':id' => $tour['id'],
            ':title' => $tour['title'],
            ':country' => $tour['country'],
            ':type' => $tour['type'],
            ':price' => $tour['price'],
            ':nights' => $tour['nights'],
            ':image' => $tour['image'],
            ':description' => $tour['description'],
            ':resort' => $tour['resort'],
            ':meal' => $tour['meal'],
            ':hotel_stars' => $tour['hotel_stars'],
            ':max_guests' => $tour['max_guests'],
            ':available_from' => $tour['available_from'],
            ':available_to' => $tour['available_to']
        ]);
        foreach ($tour['departures'] as $city) {
            $stmtDep->execute([
                ':tour_id' => $tour['id'],
                ':city_code' => $city
            ]);
        }
    }
}

$isInstalled = is_file(lock_path());
$force = isset($_GET['force']) && $_GET['force'] === '1';
if ($isInstalled && !$force) {
    http_response_code(200);
    echo '<meta charset="utf-8"><div style="font-family: Arial; padding: 24px;">Установка уже выполнена. Если нужно переустановить — добавь <b>?force=1</b>.</div>';
    exit;
}

$defaults = [
    'host' => '127.0.0.1',
    'port' => '3306',
    'name' => 'travel',
    'user' => 'root',
    'pass' => '',
    'admin_email' => 'admin@travel.local'
];

$values = $defaults;
$error = '';
$success = '';
$warning = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($values as $k => $v) {
        if (isset($_POST[$k])) $values[$k] = trim((string)$_POST[$k]);
    }
    $adminPass = trim((string)($_POST['admin_pass'] ?? ''));

    if ($values['host'] === '' || $values['name'] === '' || $values['user'] === '' || $values['admin_email'] === '' || $adminPass === '') {
        $error = 'Заполни все обязательные поля.';
    } else {
        try {
            $port = (int)$values['port'];
            $serverDsn = "mysql:host={$values['host']};port={$port};charset=utf8mb4";
            $password = $values['pass'];
            try {
                $pdoServer = new PDO($serverDsn, $values['user'], $password, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                ]);
            } catch (PDOException $e) {
                $driverCode = is_array($e->errorInfo ?? null) && isset($e->errorInfo[1]) ? (int)$e->errorInfo[1] : 0;
                if ($driverCode === 1045 && $password !== '') {
                    $pdoServer = new PDO($serverDsn, $values['user'], '', [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                    ]);
                    $password = '';
                    $values['pass'] = '';
                    $warning = 'Доступ к MySQL с паролем не прошёл. В XAMPP часто у root пароль пустой — установщик попробовал без пароля и подключился.';
                } else {
                    throw $e;
                }
            }

            $dbName = $values['name'];
            $pdoServer->exec("CREATE DATABASE IF NOT EXISTS `{$dbName}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");

            $dbDsn = "mysql:host={$values['host']};port={$port};dbname={$dbName};charset=utf8mb4";
            $db = new PDO($dbDsn, $values['user'], $password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);

            apply_migrations($db);
            seed_if_empty($db);

            $hash = password_hash($adminPass, PASSWORD_DEFAULT);
            $stmt = $db->prepare('INSERT INTO admin_users (email, password_hash) VALUES (:email, :hash) ON DUPLICATE KEY UPDATE password_hash = VALUES(password_hash)');
            $stmt->execute([':email' => strtolower($values['admin_email']), ':hash' => $hash]);

            $cfg = [
                'db' => [
                    'host' => $values['host'],
                    'port' => (int)$values['port'],
                    'name' => $values['name'],
                    'user' => $values['user'],
                    'pass' => $password,
                    'charset' => 'utf8mb4'
                ]
            ];

            $cfgPath = __DIR__ . DIRECTORY_SEPARATOR . 'api' . DIRECTORY_SEPARATOR . 'config.local.php';
            $cfgPhp = "<?php\n\nreturn " . var_export($cfg, true) . ";\n";
            file_put_contents($cfgPath, $cfgPhp);

            file_put_contents(lock_path(), date('c'));
            $success = 'Установка завершена. Можно заходить в админку.';
        } catch (PDOException $e) {
            $driverCode = is_array($e->errorInfo ?? null) && isset($e->errorInfo[1]) ? (int)$e->errorInfo[1] : 0;
            if ($driverCode === 1045) {
                $error = 'Ошибка установки: нет доступа к MySQL (неверный логин/пароль). В XAMPP обычно user=root и пароль пустой. Попробуй оставить поле Password пустым и Host=127.0.0.1.';
            } else {
                $error = 'Ошибка установки: ' . $e->getMessage();
            }
        } catch (Throwable $e) {
            $error = 'Ошибка установки: ' . $e->getMessage();
        }
    }
}

?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TRAVEL — установка</title>
    <style>
        body{font-family:Arial, sans-serif; background:#f5f7fb; margin:0; padding:24px;}
        .wrap{max-width:860px; margin:0 auto;}
        .card{background:#fff; border:1px solid #e6e9f2; border-radius:16px; padding:20px; box-shadow:0 10px 24px rgba(0,0,0,.06);}
        .grid{display:grid; grid-template-columns:1fr 1fr; gap:14px;}
        label{display:block; font-weight:700; margin:10px 0 6px;}
        input{width:100%; padding:12px 12px; border:1px solid #d9dfef; border-radius:10px; font-size:14px;}
        .btn{margin-top:14px; background:#2f7cff; color:#fff; border:0; padding:12px 16px; border-radius:10px; font-weight:800; cursor:pointer;}
        .note{color:#566; font-size:14px; line-height:1.6;}
        .msg{padding:12px 14px; border-radius:10px; margin:12px 0;}
        .err{background:#ffecec; border:1px solid #ffbdbd; color:#7a1b1b;}
        .ok{background:#eafff0; border:1px solid #b9f2c7; color:#145a2a;}
        @media (max-width: 760px){.grid{grid-template-columns:1fr;}}
    </style>
</head>
<body>
<div class="wrap">
    <h2 style="margin:0 0 14px;">Установка TRAVEL (XAMPP)</h2>
    <div class="card">
        <div class="note">
            Создаёт базу/таблицы, добавляет демо-данные и администратора. После установки открой <b>/admin</b>.
        </div>
        <?php if ($error !== ''): ?>
            <div class="msg err"><?=h($error)?></div>
        <?php endif; ?>
        <?php if ($warning !== ''): ?>
            <div class="msg ok"><?=h($warning)?></div>
        <?php endif; ?>
        <?php if ($success !== ''): ?>
            <div class="msg ok"><?=h($success)?> <a href="admin/login.php">Перейти в админку</a></div>
        <?php endif; ?>

        <form method="post">
            <h3 style="margin:14px 0 8px;">MySQL</h3>
            <div class="grid">
                <div>
                    <label>Host</label>
                    <input name="host" value="<?=h($values['host'])?>" required>
                </div>
                <div>
                    <label>Port</label>
                    <input name="port" value="<?=h($values['port'])?>" required>
                </div>
                <div>
                    <label>Database</label>
                    <input name="name" value="<?=h($values['name'])?>" required>
                </div>
                <div>
                    <label>User</label>
                    <input name="user" value="<?=h($values['user'])?>" required>
                </div>
                <div>
                    <label>Password</label>
                    <input name="pass" value="<?=h($values['pass'])?>">
                </div>
                <div></div>
            </div>

            <h3 style="margin:18px 0 8px;">Админ</h3>
            <div class="grid">
                <div>
                    <label>Email</label>
                    <input name="admin_email" value="<?=h($values['admin_email'])?>" required>
                </div>
                <div>
                    <label>Пароль</label>
                    <input name="admin_pass" type="password" required>
                </div>
            </div>

            <button class="btn" type="submit">Установить</button>
        </form>
    </div>
</div>
</body>
</html>
