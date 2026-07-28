# TRAVEL — запуск через XAMPP (Apache + MySQL)

## Требования

- Windows 10/11
- XAMPP (Apache + MySQL/MariaDB + PHP 8+)

Проверка (необязательно):

```powershell
php -v
```

---

## Запуск через XAMPP

1) Скопируй папку проекта в:

`C:\xampp\htdocs\travel`

2) Открой XAMPP Control Panel и запусти:

- Apache
- MySQL

3) Открой установку (создаст БД/таблицы и админа):

`http://localhost/travel/setup.php`

4) Открой сайт:

- Главная: http://localhost/travel/index.html
- Все туры (поиск + фильтры): http://localhost/travel/tours-all.html
- О нас: http://localhost/travel/about.html
- Контакты: http://localhost/travel/contacts.html

Админка:

- http://localhost/travel/admin

После установки лучше удалить `setup.php`.

---

## Быстрый перенос на другой ПК (5–10 минут)

1) На новом ПК установи XAMPP и запусти Apache + MySQL.

2) Скопируй проект целиком (папку `travel`) в:

`C:\xampp\htdocs\travel`

3) Открой в браузере:

`http://localhost/travel/setup.php`

4) В установщике обычно достаточно:

- Host: `127.0.0.1`
- Port: `3306`
- User: `root`
- Password: пусто
- Database: `travel`
- Admin email/пароль: любые (запомни пароль)

5) После сообщения “Установка завершена” открой:

- Сайт: `http://localhost/travel/index.html`
- Поиск туров: `http://localhost/travel/tours-all.html`
- Админка: `http://localhost/travel/admin`

### Если переносишь вместе с данными

Вариант А (быстро, через phpMyAdmin):

- На старом ПК: phpMyAdmin → база `travel` → Export → Format SQL → скачать файл
- На новом ПК: phpMyAdmin → Import → выбрать этот SQL

Вариант Б (через дамп):

- `mysqldump -u root travel > travel.sql`
- `mysql -u root travel < travel.sql`

---

## Типовые проблемы

- `http://localhost/travel/api/metadata` возвращает 404:
  - включи mod_rewrite и AllowOverride для `.htaccess` в Apache
- “Access denied for user root”:
  - в XAMPP обычно пароль root пустой; если менял — введи реальный пароль

---

## База данных

Используется MySQL/MariaDB (XAMPP).

- Настройки подключения сохраняются в `api/config.local.php` (создаётся установщиком)
- Таблицы создаются из `migrations/*.sql`
- Демо-туры добавляются автоматически, если таблица `tours` пустая

---

## API (как проверить, что всё работает)

- Метаданные для фильтров:
  - http://localhost/travel/api/metadata
- Список туров:
  - http://localhost/travel/api/tours
  - пример с фильтрами:
    - http://localhost/travel/api/tours?country=turkey&departure=moscow&sort=priceAsc

### Тестовые POST-запросы (PowerShell)

Подписка:

```powershell
$body = @{ email = 'test@example.com' } | ConvertTo-Json
Invoke-RestMethod -Method Post -Uri 'http://localhost/travel/api/newsletter' -ContentType 'application/json' -Body $body
```

Заявка на бронирование:

```powershell
$body = @{
  tour_id = 6
  name = 'Тест'
  phone = '+79990000000'
  email = 'test@example.com'
  start_date = '2026-02-01'
  end_date = '2026-02-08'
  guests = 2
  note = 'Без комментариев'
} | ConvertTo-Json
Invoke-RestMethod -Method Post -Uri 'http://localhost/travel/api/bookings' -ContentType 'application/json' -Body $body
```

Сообщение из контактов:

```powershell
$body = @{ name = 'Тест'; email = 'test@example.com'; phone = '+79990000000'; message = 'Привет' } | ConvertTo-Json
Invoke-RestMethod -Method Post -Uri 'http://localhost/travel/api/contact' -ContentType 'application/json' -Body $body
```

---

## Запуск без XAMPP (опционально)

Можно запустить встроенным сервером PHP:

```powershell
php -S 127.0.0.1:8000 router.php
```

Открывай: `http://127.0.0.1:8000/index.html`

---

## Если API не открывается (404)

Если `http://localhost/travel/api/metadata` отдаёт 404:

- Убедись, что в Apache включён mod_rewrite
- Для папки `htdocs` должен быть разрешён `.htaccess` (AllowOverride)

## Если установка ругается “Access denied for user root”

- В XAMPP по умолчанию: user `root`, пароль пустой
- Поставь Host `127.0.0.1`, Port `3306`
- Если в phpMyAdmin ты задавал пароль root — введи его в установщике

---

## Документация по БД

Смотри: `docs/database.md`
