## База данных TRAVEL (MySQL / MariaDB)

По умолчанию используется MySQL/MariaDB из XAMPP. Настройки подключения: `api/config.local.php`

### Цели

- Хранить каталог туров и связанные справочники (города вылета).
- Принимать заявки на бронирование, сообщения из формы контактов, подписки на рассылку.
- Обеспечить безопасные запросы (только параметризованный SQL), валидацию и понятную структуру данных.

---

## Схема данных

### Таблица `tours`

Содержит туры, доступные в каталоге.

| Поле | Тип | Описание |
|---|---|---|
| id | INT PK | Идентификатор тура |
| title | VARCHAR | Название |
| country | VARCHAR | Код страны (`turkey`, `egypt` и т.п.) |
| type | VARCHAR | Тип (`beach`, `mountains`, `excursion`) |
| price | INT | Цена в рублях |
| nights | INT | Количество ночей |
| image | VARCHAR | Путь к изображению |
| description | TEXT | Описание |
| resort | VARCHAR | Курорт/локация |
| meal | VARCHAR | Питание (`ai`, `hb`, `bb`, `ro`) |
| hotel_stars | TINYINT | 3..5 |
| max_guests | TINYINT | Максимум туристов |
| available_from | DATE | Дата доступности (YYYY-MM-DD) |
| available_to | DATE | Дата доступности (YYYY-MM-DD) |
| created_at | TIMESTAMP | Автоматически |

### Таблица `tour_departures`

Связь «тур → города вылета».

| Поле | Тип | Описание |
|---|---|---|
| tour_id | INT | FK на `tours.id` |
| city_code | VARCHAR | Код города (`moscow`, `spb`, `kazan`) |

PK: `(tour_id, city_code)`

### Таблица `bookings`

Заявки на бронирование из модального окна.

| Поле | Тип | Описание |
|---|---|---|
| id | INT PK | Идентификатор заявки |
| tour_id | INT nullable | FK на `tours.id` (может быть NULL для “подбор тура”) |
| name | VARCHAR | Имя |
| phone | VARCHAR | Телефон |
| email | VARCHAR | Email |
| start_date | DATE | Дата выезда (YYYY-MM-DD) |
| end_date | DATE | Дата возвращения (YYYY-MM-DD) |
| guests | TINYINT | Кол-во туристов |
| note | TEXT | Пожелания |
| created_at | TIMESTAMP | Автоматически |

### Таблица `newsletter_subscribers`

Подписки на рассылку.

| Поле | Тип | Описание |
|---|---|---|
| id | INT PK | Идентификатор |
| email | VARCHAR UNIQUE | Email |
| created_at | TIMESTAMP | Автоматически |

### Таблица `contact_messages`

Сообщения из формы “Контакты”.

| Поле | Тип | Описание |
|---|---|---|
| id | INT PK | Идентификатор |
| name | VARCHAR | Имя |
| email | VARCHAR | Email |
| phone | VARCHAR nullable | Телефон |
| message | TEXT | Сообщение |
| created_at | TIMESTAMP | Автоматически |

---

## Миграции

Миграции лежат в `migrations/`.

- `001_init.sql` — создание таблиц и индексов.

Миграции применяются автоматически при первом обращении к API.

---

## Примеры запросов

### Получить туры по стране и бюджету

```sql
SELECT *
FROM tours
WHERE country = :country
  AND price BETWEEN :min_price AND :max_price
ORDER BY price ASC;
```

### Получить туры с фильтром по городам вылета

```sql
SELECT t.*
FROM tours t
JOIN tour_departures d ON d.tour_id = t.id
WHERE d.city_code = :city_code
GROUP BY t.id;
```

### Создать заявку

```sql
INSERT INTO bookings (tour_id, name, phone, email, start_date, end_date, guests, note)
VALUES (:tour_id, :name, :phone, :email, :start_date, :end_date, :guests, :note);
```

---

## Резервное копирование

Для MySQL/MariaDB удобнее использовать дамп.

Пример (если есть `mysqldump`):

```bash
mysqldump -u root travel > backups/travel.sql
```

---

## Восстановление

```bash
mysql -u root travel < backups/travel.sql
```
