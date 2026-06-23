# Frameworks — Label API (варіант 160)

Навчальний проєкт: реалізація CRUD-операцій для сутності **Label** на двох PHP-фреймворках — **Symfony** та **Laravel**.

## Структура репозиторію

```
frameworks/
├── symfony/                         # проєкт на Symfony
├── laravel/                         # проєкт на Laravel
├── symfony.postman_collection.json  # Postman-колекція для Symfony
├── laravel.postman_collection.json  # Postman-колекція для Laravel
└── README.md
```

## Сутність Label

| Поле          | Тип      | Опис                                  |
|---------------|----------|---------------------------------------|
| `id`          | integer  | Унікальний ідентифікатор (auto)       |
| `name`        | string   | Назва мітки (обов'язкове)             |
| `description` | string   | Опис (необов'язкове)                  |
| `color`       | string   | Колір у форматі HEX, напр. `#FF0000`  |
| `isActive`    | boolean  | Чи активна мітка (Laravel: `is_active`) |
| `createdAt`   | datetime | Дата створення (Laravel: `created_at`)  |

> У Symfony поля у JSON у форматі camelCase (`isActive`), у Laravel — snake_case (`is_active`). Це враховано в Postman-колекціях.

## Запуск

### Symfony

```bash
cd symfony
composer install
# у .env: DATABASE_URL="sqlite:///%kernel.project_dir%/var/data.db"
php bin/console doctrine:database:create
php bin/console make:migration
php bin/console doctrine:migrations:migrate
php -S localhost:8000 -t public
```

### Laravel

```bash
cd laravel
composer install
php artisan install:api   # якщо routes/api.php відсутній
php artisan migrate
php artisan serve          # http://localhost:8000
```

## Endpoints

Базовий URL: `http://localhost:8000`. Усі запити та відповіді у форматі JSON.

### 1. Отримати всі мітки

```
GET /api/labels
```

**Відповідь `200 OK`:**
```json
[
  {
    "id": 1,
    "name": "Urgent",
    "description": "High priority items",
    "color": "#FF0000",
    "isActive": true,
    "createdAt": "2026-01-01T10:00:00+00:00"
  }
]
```

### 2. Отримати одну мітку

```
GET /api/labels/{id}
```

**Відповідь `200 OK`** — об'єкт мітки.
**Відповідь `404 Not Found`:**
```json
{ "message": "Label not found" }
```

### 3. Створити мітку

```
POST /api/labels
Content-Type: application/json
```

**Тіло запиту:**
```json
{
  "name": "Urgent",
  "description": "High priority items",
  "color": "#FF0000",
  "isActive": true
}
```

**Відповідь `201 Created`** — створений об'єкт.
**Відповідь `400 Bad Request`** — якщо не передано обов'язкове поле `name`.

### 4. Оновити мітку (часткове оновлення)

```
PATCH /api/labels/{id}
Content-Type: application/json
```

**Тіло запиту** (передаються лише ті поля, які треба змінити):
```json
{
  "name": "Updated name",
  "color": "#00FF00",
  "isActive": false
}
```

**Відповідь `200 OK`** — оновлений об'єкт.
**Відповідь `404 Not Found`** — якщо мітку не знайдено.

### 5. Видалити мітку

```
DELETE /api/labels/{id}
```

**Відповідь `204 No Content`** — успішне видалення (без тіла).
**Відповідь `404 Not Found`** — якщо мітку не знайдено.

## Коди відповідей

| Код | Значення                                  |
|-----|-------------------------------------------|
| 200 | Успішний GET / PATCH                       |
| 201 | Об'єкт створено (POST)                     |
| 204 | Об'єкт видалено (DELETE), без тіла          |
| 400 | Некоректний запит (немає обов'язкового поля) |
| 404 | Об'єкт не знайдено                          |

## Postman

Імпортуй файли `symfony.postman_collection.json` та `laravel.postman_collection.json`
у Postman (**Import** → перетягнути файл). Змінна `{{base_url}}` за замовчуванням
дорівнює `http://localhost:8000` і налаштовується в параметрах колекції.
