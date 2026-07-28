<?php

declare(strict_types=1);

header('X-Content-Type-Options: nosniff');

function json_response(int $status, $payload): void {
    $body = json_encode($payload, JSON_UNESCAPED_UNICODE);
    if ($body === false) {
        $status = 500;
        $body = json_encode(['error' => 'server_error']);
    }
    http_response_code($status);
    header('Content-Type: application/json; charset=utf-8');
    header('Content-Length: ' . strlen($body));
    echo $body;
    exit;
}

function read_json_body(): array {
    $raw = file_get_contents('php://input');
    if ($raw === false || trim($raw) === '') return [];
    $data = json_decode($raw, true);
    if (!is_array($data)) json_response(400, ['error' => 'invalid_json']);
    return $data;
}

function is_valid_email(string $email): bool {
    return (bool)preg_match('/^[^\s@]+@[^\s@]+\.[^\s@]+$/u', $email);
}

function is_valid_date(string $value): bool {
    if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $value)) return false;
    $dt = DateTime::createFromFormat('Y-m-d', $value);
    return $dt !== false && $dt->format('Y-m-d') === $value;
}

function to_int($value, ?int $default = null, ?int $min = null, ?int $max = null): ?int {
    if ($value === null || $value === '') return $default;
    if (!is_numeric($value)) return $default;
    $n = (int)$value;
    if ($min !== null && $n < $min) return $default;
    if ($max !== null && $n > $max) return $default;
    return $n;
}

function base_dir(): string {
    return dirname(__DIR__);
}

function migrations_dir(): string {
    return base_dir() . DIRECTORY_SEPARATOR . 'migrations';
}

function installed_lock_path(): string {
    $dir = base_dir() . DIRECTORY_SEPARATOR . 'data';
    if (!is_dir($dir)) mkdir($dir, 0777, true);
    return $dir . DIRECTORY_SEPARATOR . 'installed.lock';
}

function load_config(): array {
    $path = __DIR__ . DIRECTORY_SEPARATOR . 'config.php';
    $cfg = require $path;
    return is_array($cfg) ? $cfg : [];
}

function connect_db(array $config): PDO {
    $db = $config['db'] ?? [];
    $host = (string)($db['host'] ?? '127.0.0.1');
    $port = (int)($db['port'] ?? 3306);
    $name = (string)($db['name'] ?? 'travel');
    $user = (string)($db['user'] ?? 'root');
    $pass = (string)($db['pass'] ?? '');
    $charset = (string)($db['charset'] ?? 'utf8mb4');

    $dsn = "mysql:host={$host};port={$port};dbname={$name};charset={$charset}";
    return new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
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
    $row = $db->query('SELECT COUNT(*) AS c FROM tours')->fetch();
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

function metadata(PDO $db): array {
    $countries = $db->query('SELECT DISTINCT country FROM tours ORDER BY country ASC')->fetchAll();
    $departures = $db->query('SELECT DISTINCT city_code FROM tour_departures ORDER BY city_code ASC')->fetchAll();
    $meals = $db->query('SELECT DISTINCT meal FROM tours WHERE meal IS NOT NULL ORDER BY meal ASC')->fetchAll();
    $stars = $db->query('SELECT DISTINCT hotel_stars FROM tours WHERE hotel_stars IS NOT NULL ORDER BY hotel_stars ASC')->fetchAll();
    $resorts = $db->query('SELECT DISTINCT country, resort FROM tours WHERE resort IS NOT NULL ORDER BY country ASC, resort ASC')->fetchAll();

    return [
        'countries' => array_map(fn($r) => $r['country'], $countries),
        'departures' => array_map(fn($r) => $r['city_code'], $departures),
        'meals' => array_map(fn($r) => $r['meal'], $meals),
        'stars' => array_map(fn($r) => (int)$r['hotel_stars'], $stars),
        'resorts' => array_values(array_filter(array_map(function ($r) {
            if (!$r['resort']) return null;
            return ['country' => $r['country'], 'resort' => $r['resort']];
        }, $resorts)))
    ];
}

function query_tours(PDO $db, array $qs): array {
    $departure = trim((string)($qs['departure'] ?? 'all'));
    $country = trim((string)($qs['country'] ?? 'all'));
    $meal = trim((string)($qs['meal'] ?? 'all'));
    $sort = trim((string)($qs['sort'] ?? 'popular'));
    $type = trim((string)($qs['type'] ?? 'all'));

    $budgetMin = to_int($qs['budgetMin'] ?? null, null, 0, null);
    $budgetMax = to_int($qs['budgetMax'] ?? null, null, 0, null);
    $nightsMin = to_int($qs['nightsMin'] ?? null, null, 1, 30);
    $nightsMax = to_int($qs['nightsMax'] ?? null, null, 1, 30);

    $adults = to_int($qs['adults'] ?? 2, 2, 1, 10);
    $children = to_int($qs['children'] ?? 0, 0, 0, 10);
    $guests = (int)$adults + (int)$children;

    $dateFrom = trim((string)($qs['dateFrom'] ?? ''));
    $dateTo = trim((string)($qs['dateTo'] ?? ''));
    if ($dateFrom !== '' && !is_valid_date($dateFrom)) $dateFrom = '';
    if ($dateTo !== '' && !is_valid_date($dateTo)) $dateTo = '';

    $starsParam = trim((string)($qs['stars'] ?? ''));
    $stars = [];
    if ($starsParam !== '') {
        foreach (explode(',', $starsParam) as $s) {
            $s = trim($s);
            if ($s === '') continue;
            if (ctype_digit($s)) {
                $v = (int)$s;
                if (in_array($v, [3, 4, 5], true)) $stars[] = $v;
            }
        }
    }

    $resortsParam = trim((string)($qs['resorts'] ?? ($qs['resort'] ?? '')));
    $resorts = [];
    if ($resortsParam !== '') {
        foreach (explode(',', $resortsParam) as $r) {
            $r = trim($r);
            if ($r !== '') $resorts[] = $r;
        }
    }

    $params = [];
    $clauses = ['1=1'];
    $joinDeparture = $departure !== 'all';

    if ($country !== 'all') {
        $clauses[] = 't.country = :country';
        $params[':country'] = $country;
    }
    if ($type !== 'all') {
        $clauses[] = 't.type = :type';
        $params[':type'] = $type;
    }
    if ($meal !== 'all') {
        $clauses[] = 't.meal = :meal';
        $params[':meal'] = $meal;
    }
    if ($budgetMin !== null) {
        $clauses[] = 't.price >= :budgetMin';
        $params[':budgetMin'] = $budgetMin;
    }
    if ($budgetMax !== null) {
        $clauses[] = 't.price <= :budgetMax';
        $params[':budgetMax'] = $budgetMax;
    }
    if ($nightsMin !== null) {
        $clauses[] = 't.nights >= :nightsMin';
        $params[':nightsMin'] = $nightsMin;
    }
    if ($nightsMax !== null) {
        $clauses[] = 't.nights <= :nightsMax';
        $params[':nightsMax'] = $nightsMax;
    }

    $clauses[] = '(t.max_guests IS NULL OR t.max_guests >= :guests)';
    $params[':guests'] = $guests;

    if ($dateFrom !== '') {
        $clauses[] = '(t.available_to IS NULL OR t.available_to >= :dateFrom)';
        $params[':dateFrom'] = $dateFrom;
    }
    if ($dateTo !== '') {
        $clauses[] = '(t.available_from IS NULL OR t.available_from <= :dateTo)';
        $params[':dateTo'] = $dateTo;
    }
    if (count($stars) > 0) {
        $ph = [];
        foreach ($stars as $i => $v) {
            $k = ':star' . $i;
            $ph[] = $k;
            $params[$k] = $v;
        }
        $clauses[] = 't.hotel_stars IN (' . implode(',', $ph) . ')';
    }
    if (count($resorts) > 0) {
        $ph = [];
        foreach ($resorts as $i => $v) {
            $k = ':resort' . $i;
            $ph[] = $k;
            $params[$k] = $v;
        }
        $clauses[] = 't.resort IN (' . implode(',', $ph) . ')';
    }
    if ($joinDeparture) {
        $clauses[] = 'd.city_code = :departure';
        $params[':departure'] = $departure;
    }

    $orderBy = 't.id ASC';
    if ($sort === 'priceAsc') $orderBy = 't.price ASC';
    if ($sort === 'priceDesc') $orderBy = 't.price DESC';
    if ($sort === 'nightsAsc') $orderBy = 't.nights ASC';
    if ($sort === 'nightsDesc') $orderBy = 't.nights DESC';

    $sql = 'SELECT t.* FROM tours t ' . ($joinDeparture ? 'JOIN tour_departures d ON d.tour_id = t.id ' : '') .
        'WHERE ' . implode(' AND ', $clauses) . ' GROUP BY t.id ORDER BY ' . $orderBy;

    $stmt = $db->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll();
}

function normalize_api_path(string $requestUri, string $scriptName): string {
    $path = parse_url($requestUri, PHP_URL_PATH);
    if (!is_string($path)) return '/';
    $base = rtrim(str_replace('\\', '/', dirname($scriptName)), '/');
    if ($base !== '' && $base !== '.' && strpos($path, $base) === 0) {
        $path = substr($path, strlen($base));
        if ($path === '') $path = '/';
    }
    $pos = strpos($path, '/api/');
    if ($pos !== false) {
        $path = substr($path, $pos + 4);
        if ($path === '') $path = '/';
    } else {
        $pos2 = strpos($path, '/api');
        if ($pos2 !== false && substr($path, $pos2) === '/api') {
            $path = '/';
        }
    }
    return $path;
}

$requestUri = (string)($_SERVER['REQUEST_URI'] ?? '/');
$scriptName = (string)($_SERVER['SCRIPT_NAME'] ?? '/api/index.php');
$path = normalize_api_path($requestUri, $scriptName);
$path = $path === '/' ? '/' : rtrim($path, '/');
$method = (string)($_SERVER['REQUEST_METHOD'] ?? 'GET');

if ($method === 'OPTIONS') {
    http_response_code(204);
    exit;
}

$config = load_config();
try {
    $db = connect_db($config);
} catch (Throwable $e) {
    json_response(500, ['error' => 'db_connect_error']);
}

try {
    apply_migrations($db);
    seed_if_empty($db);
} catch (Throwable $e) {
    json_response(500, ['error' => 'db_migration_error']);
}

if ($method === 'GET' && $path === '/metadata') {
    json_response(200, metadata($db));
}

if ($method === 'GET' && $path === '/tours') {
    json_response(200, ['items' => query_tours($db, $_GET)]);
}

if ($method !== 'POST' && in_array($path, ['/newsletter', '/contact', '/bookings'], true)) {
    json_response(405, ['error' => 'method_not_allowed', 'allow' => 'POST']);
}

if ($method === 'POST' && $path === '/newsletter') {
    $data = read_json_body();
    $email = strtolower(trim((string)($data['email'] ?? '')));
    if ($email === '' || !is_valid_email($email)) json_response(400, ['error' => 'invalid_email']);
    try {
        $stmt = $db->prepare('INSERT INTO newsletter_subscribers (email) VALUES (:email)');
        $stmt->execute([':email' => $email]);
    } catch (Throwable $e) {
    }
    json_response(200, ['ok' => true]);
}

if ($method === 'POST' && $path === '/contact') {
    $data = read_json_body();
    $name = trim((string)($data['name'] ?? ''));
    $email = strtolower(trim((string)($data['email'] ?? '')));
    $phone = trim((string)($data['phone'] ?? ''));
    $message = trim((string)($data['message'] ?? ''));
    if ($name === '' || $message === '' || $email === '' || !is_valid_email($email)) json_response(400, ['error' => 'invalid_fields']);
    $stmt = $db->prepare('INSERT INTO contact_messages (name, email, phone, message) VALUES (:name, :email, :phone, :message)');
    $stmt->execute([
        ':name' => $name,
        ':email' => $email,
        ':phone' => ($phone === '' ? null : $phone),
        ':message' => $message
    ]);
    json_response(200, ['ok' => true]);
}

if ($method === 'POST' && $path === '/bookings') {
    $data = read_json_body();
    $tourId = to_int($data['tour_id'] ?? null, null, 1, null);
    $name = trim((string)($data['name'] ?? ''));
    $phone = trim((string)($data['phone'] ?? ''));
    $email = strtolower(trim((string)($data['email'] ?? '')));
    $startDate = trim((string)($data['start_date'] ?? ''));
    $endDate = trim((string)($data['end_date'] ?? ''));
    $guests = to_int($data['guests'] ?? null, null, 1, 20);
    $note = trim((string)($data['note'] ?? ''));

    if ($name === '' || $phone === '' || $email === '' || !is_valid_email($email)) json_response(400, ['error' => 'invalid_fields']);
    if (!is_valid_date($startDate) || !is_valid_date($endDate) || $endDate < $startDate) json_response(400, ['error' => 'invalid_dates']);
    if ($guests === null) json_response(400, ['error' => 'invalid_guests']);

    $stmt = $db->prepare(
        'INSERT INTO bookings (tour_id, name, phone, email, start_date, end_date, guests, note)
         VALUES (:tour_id, :name, :phone, :email, :start_date, :end_date, :guests, :note)'
    );
    $stmt->execute([
        ':tour_id' => $tourId,
        ':name' => $name,
        ':phone' => $phone,
        ':email' => $email,
        ':start_date' => $startDate,
        ':end_date' => $endDate,
        ':guests' => $guests,
        ':note' => ($note === '' ? null : $note)
    ]);
    json_response(200, ['ok' => true]);
}

json_response(404, ['error' => 'not_found']);
