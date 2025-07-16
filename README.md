# SafeJson

**Безопасный и строгий парсинг JSON в PHP через декларативные схемы.**

- ✅ Простые в написании схемы как классы
- ✅ Безопасная типизация
- ✅ Значения по умолчанию и `required`
- ✅ Вложенные схемы
- ✅ Генерация строго типизированных DTO

---

## 🔧 Установка

```bash
composer require heliostat/safe-json
```

Для разработки:

```bash
composer require --dev phpunit/phpunit friendsofphp/php-cs-fixer phpstan/phpstan captainhook/captainhook
vendor/bin/captainhook install
```

---

## 🚀 Быстрый старт

### 1. Определите DTO

```php
class User
{
    public function __construct(
        public int $id,
        public string $email,
        public string $name,
        public bool $is_active,
        public Settings $settings
    ) {}
}

class Settings
{
    public function __construct(
        public bool $notifications
    ) {}
}
```

---

### 2. Создайте схемы

```php
use SafeJson\JsonSchema;

class UserSchema extends JsonSchema
{
    public function rules(): array
    {
        return [
            'id' => self::int()->required(),
            'email' => self::string()->required(),
            'name' => self::string()->default('Anonymous'),
            'is_active' => self::bool()->default(false),
            'settings' => self::object(SettingsSchema::class)->required(),
        ];
    }

    public function cast(): User
    {
        return new User(
            $this->id,
            $this->email,
            $this->name,
            $this->is_active,
            $this->settings->cast()
        );
    }
}

class SettingsSchema extends JsonSchema
{
    public function rules(): array
    {
        return [
            'notifications' => self::bool()->default(true),
        ];
    }

    public function cast(): Settings
    {
        return new Settings($this->notifications);
    }
}
```

---

### 3. Использование

```php
$json = <<<JSON
{
  "id": 123,
  "email": "user@example.com",
  "settings": {
    "notifications": false
  }
}
JSON;

$user = SafeJson\SafeJson::parse($json, new UserSchema())->cast();

echo $user->email;              // user@example.com
echo $user->settings->notifications ? 'yes' : 'no'; // no
```

---

## ⚙️ Возможности

- `int()`, `string()`, `bool()`, `object(Schema::class)`
- `->required()`, `->default(...)`
- Поддержка вложенных объектов
- Генерация безопасных DTO через `cast()`

---

## 🧪 Команды разработчика

```bash
composer fix        # Линтер
composer stan       # Статическая проверка
composer test       # Юнит-тесты
composer hook:run   # Pre-commit hook
```

---

## 🪝 CaptainHook

Пример `.captainhook.json` для pre-commit:

```json
{
  "pre-commit": {
    "enabled": true,
    "actions": [
      { "action": "composer fix" },
      { "action": "composer stan" },
      { "action": "composer test" }
    ]
  }
}
```

---

## 📦 Планы на будущее

- `float()`, `arrayOf(...)`, `enum([...])`
- `min`, `max`, `regex` правила
- Генерация схем или DTO из JSON
- Автогенерация документации  
