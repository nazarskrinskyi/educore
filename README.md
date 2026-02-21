# 🎓 EduPlatform — Онлайн-платформа для курсів

EduPlatform — це повнофункціональна Fullstack-платформа для онлайн-навчання, побудована з використанням **Vue 3**, **Inertia.js**, **Laravel 12**, **Filament 3**, **Tailwind CSS** та **MySQL**. Студенти можуть проходити курси, переглядати відео, проходити тести, отримувати сертифікати та здійснювати покупки через Stripe. Інструктори та адміністратори керують контентом через потужну панель Filament, а система надсилає автоматичні нагадування через Telegram-бота.

---

## 🧑‍💻 Technology Stack

### Frontend
- **Vue 3** — Progressive JavaScript Framework
- **Inertia.js** — Modern monolith approach (SPA without API)
- **Pinia** — State management
- **Vue Router** — Client-side routing
- **Tailwind CSS** — Utility-first CSS framework
- **Axios** — HTTP client
- **Vite** — Next generation frontend tooling
- **Vue Plyr** — Video player component
- **Vue3 Carousel** — Carousel component
- **Vue3 Circle Progress** — Progress visualization

### Backend
- **Laravel 12** — PHP Framework
- **Filament 3** — Admin panel builder
- **Laravel Sanctum** — API authentication
- **Laravel Breeze** — Authentication scaffolding
- **Laravel Socialite** — OAuth authentication (Google)
- **Laravel Cashier** — Stripe integration
- **Inertia Laravel** — Server-side adapter

### Database & Storage
- **MySQL 8.0** — Relational database
- **Database Sessions** — Session storage
- **Database Queue** — Job queue driver
- **Database Cache** — Cache driver

### Integrations
- **Stripe** — Payment processing
- **Telegram Bot API** — Notifications and reminders
- **Laravel DOMPDF** — PDF certificate generation
- **Google OAuth** — Social authentication
- **Mailtrap** — Email testing

### DevOps & Tools
- **Docker** — Containerization (PHP-FPM, Nginx, MySQL)
- **Docker Compose** — Multi-container orchestration
- **Pest** — Testing framework
- **Laravel Pint** — Code style fixer
- **Laravel Pail** — Log viewer
- **Ziggy** — Laravel routes in JavaScript

---

## 🗂 Функціонал

**Database Schema:** https://dbdiagram.io/d/68724213f413ba35088a104b

### 👤 Студент
- ✅ Реєстрація / логін (Email + Google OAuth)
- ✅ Перегляд каталогу курсів з фільтрацією та пошуком
- ✅ Перегляд деталей курсу, відео уроків, секцій
- ✅ Запис на курси (безкоштовні та платні)
- ✅ Проходження інтерактивних тестів
- ✅ Автоматичне оцінювання тестів
- ✅ Відстеження прогресу по курсу
- ✅ Отримання PDF сертифікатів після завершення
- ✅ Коментування уроків
- ✅ Відгуки та рейтинги курсів
- ✅ Кошик та оформлення замовлень
- ✅ Оплата через Stripe
- ✅ Wishlist (список бажань)
- ✅ Особистий кабінет з історією курсів та тестів
- ✅ Telegram нагадування про незавершені курси
- ✅ Email верифікація

### 👨‍🏫 Інструктор
- ✅ Окрема реєстрація та вхід для інструкторів
- ✅ Доступ до Filament Admin Panel
- ✅ Створення та управління курсами
- ✅ Організація контенту по секціях
- ✅ Додавання відео уроків
- ✅ Створення тестів з питаннями та відповідями
- ✅ Управління категоріями та тегами
- ✅ Перегляд статистики студентів
- ✅ Управління відгуками

### 🛠 Адмін
- ✅ Повна Filament Admin Panel
- ✅ Управління користувачами (Students, Instructors, Admins)
- ✅ Управління всіма курсами та контентом
- ✅ Перегляд та управління замовленнями
- ✅ Система промокодів
- ✅ Управління сертифікатами
- ✅ Перегляд результатів тестів
- ✅ Історія входів користувачів
- ✅ Повідомлення з контактної форми
- ✅ Налаштування сторінок (Page Configuration)
- ✅ Аналітика та звіти

---

## 🏗 Архітектура

### Monolith SPA Architecture
- **Inertia.js** забезпечує SPA досвід без необхідності створення REST API
- Vue компоненти рендеряться через Laravel контролери
- Автоматична синхронізація роутів через Ziggy
- SSR-ready архітектура

### Backend Structure
```
app/
├── Console/Commands/          # Artisan команди
├── Enums/                     # Enum класи (RoleEnum, etc.)
├── Filament/Resources/        # Filament admin ресурси (18 ресурсів)
├── Http/
│   ├── Controllers/           # Laravel контролери
│   ├── Middleware/            # Custom middleware (role-based)
│   ├── Requests/              # Form requests
│   └── Resources/             # API resources
├── Jobs/                      # Queue jobs (Telegram, Certificates)
├── Mail/                      # Mail classes
├── Models/                    # Eloquent models (24 моделі)
├── Policies/                  # Authorization policies
├── Repositories/              # Repository pattern (10 repositories)
└── Services/                  # Business logic services (6 services)
```

### Frontend Structure
```
resources/js/
├── Components/                # Reusable Vue components (36)
├── Layouts/                   # Layout components (3)
├── Pages/                     # Inertia pages (32)
│   ├── Auth/                  # Authentication pages
│   ├── Courses/               # Course pages
│   ├── Profile/               # User profile
│   ├── Tests/                 # Test pages
│   └── Cart/                  # Shopping cart
├── composables/               # Vue composables (4)
├── directives/                # Custom directives
└── router.js                  # Vue Router configuration
```

### Database Models
- **User** — Користувачі з ролями (Student, Instructor, Admin)
- **Course** — Курси з категоріями, тегами, цінами
- **Section** — Секції курсів
- **Lesson** — Уроки з відео контентом
- **Test** — Тести з питаннями
- **Question** — Питання тестів
- **Answer** — Відповіді на питання
- **TestAttempt** — Спроби проходження тестів
- **TestResult** — Результати тестів
- **Certificate** — Сертифікати
- **Review** — Відгуки на курси
- **LessonComment** — Коментарі до уроків
- **Order** — Замовлення
- **OrderItem** — Позиції замовлень
- **PromoCode** — Промокоди
- **Wishlist** — Список бажань
- **CourseUser** — Зв'язок користувачів та курсів
- **LoginHistory** — Історія входів
- **ContactMessage** — Повідомлення з форми контактів
- **PageConfiguration** — Налаштування сторінок

---

## 📬 Інтеграції

### Telegram Bot
- **Автоматичні нагадування** про незавершені курси
- **Сповіщення про нові курси** для підписаних користувачів
- **Сповіщення про сертифікати** після завершення курсу
- **Webhook підтримка** для real-time повідомлень
- **Scheduled jobs** виконуються кожну хвилину
- **Безпечна обробка помилок** з логуванням

### Stripe Payment
- **Stripe Checkout** для безпечних платежів
- **Webhook обробка** для автоматичного підтвердження платежів
- **Підтримка промокодів** зі знижками
- **Історія замовлень** для користувачів

### Email System
- **Email верифікація** для нових користувачів
- **Mailtrap** для тестування email в development
- **Налаштовувані шаблони** для різних типів листів

### Google OAuth
- **Швидка реєстрація** через Google акаунт
- **Автоматичне призначення ролі** Student для нових користувачів
- **Безпечна автентифікація** через Laravel Socialite

---

## 🎓 Система Сертифікатів

- ✅ Автоматична генерація після завершення 100% курсу
- ✅ PDF формат через Laravel DOMPDF
- ✅ Унікальний ID для кожного сертифіката
- ✅ Завантаження в особистому кабінеті
- ✅ Telegram сповіщення про отримання сертифіката
- ✅ Scheduled job для автоматичної генерації

---

## 📦 Встановлення

### Вимоги
- PHP 8.2+
- Composer
- Node.js 18+ & NPM
- MySQL 8.0+
- Docker & Docker Compose (опціонально)

### Локальна установка

#### 1. Клонування репозиторію
```bash
git clone <repository-url>
cd educore
```

#### 2. Backend Setup
```bash
# Встановити PHP залежності
composer install

# Створити .env файл
cp .env.example .env

# Згенерувати application key
php artisan key:generate

# Налаштувати базу даних в .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=educore
DB_USERNAME=your_username
DB_PASSWORD=your_password

# Запустити міграції та seeders
php artisan migrate --seed

# Створити symbolic link для storage
php artisan storage:link
```

#### 3. Frontend Setup
```bash
# Встановити Node.js залежності
npm install

# Зібрати assets для development
npm run dev
```

#### 4. Налаштування сервісів

**Stripe:**
```env
STRIPE_KEY=your-stripe-publishable-key
STRIPE_SECRET=your-stripe-secret-key
STRIPE_WEBHOOK_SECRET=your-stripe-webhook-secret
```

**Telegram Bot:**
```env
TELEGRAM_BOT_TOKEN=your-bot-token
TELEGRAM_BOT_NAME=YourBotName
TELEGRAM_ADMIN_ID=your-telegram-id
```

**Google OAuth:**
```env
GOOGLE_CLIENT_ID=your-google-client-id
GOOGLE_CLIENT_SECRET=your-google-client-secret
GOOGLE_REDIRECT_URL=http://localhost/api/auth/google/callback
```

#### 5. Запуск додатку
```bash
# Запустити Laravel development server
php artisan serve

# В окремому терміналі запустити Vite
npm run dev

# В окремому терміналі запустити queue worker
php artisan queue:work

# Запустити scheduler (для production)
php artisan schedule:work
```

**Доступ:**
- Frontend: http://localhost:8000
- Filament Admin: http://localhost:8000/admin

### Docker Setup

```bash
# Запустити всі сервіси
docker-compose up -d

# Встановити залежності в контейнері
docker-compose exec app composer install
docker-compose exec app npm install

# Запустити міграції
docker-compose exec app php artisan migrate --seed

# Зібрати frontend
docker-compose exec app npm run build
```

**Доступ:**
- Application: http://localhost
- MySQL: localhost:3306

---

## 🧪 Тестування

```bash
# Запустити всі тести
php artisan test

# Запустити тести з coverage
php artisan test --coverage

# Запустити конкретний тест
php artisan test --filter=CourseTest

# Pest тестування
./vendor/bin/pest
```

---

## 🚀 Production Deployment

### Build для production
```bash
# Оптимізувати autoloader
composer install --optimize-autoloader --no-dev

# Кешувати конфігурацію
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Зібрати frontend assets
npm run build
```

### Cron Jobs
Додайте до crontab:
```bash
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```

### Queue Worker
Налаштуйте supervisor для queue worker:
```ini
[program:educore-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /path-to-your-project/artisan queue:work --sleep=3 --tries=3
autostart=true
autorestart=true
user=www-data
numprocs=2
redirect_stderr=true
stdout_logfile=/path-to-your-project/storage/logs/worker.log
```

---

## 🔐 Система Автентифікації

### Ролі користувачів
- **STUDENT** — Звичайні користувачі, які проходять курси
- **INSTRUCTOR** — Викладачі, які створюють курси
- **ADMIN** — Адміністратори з повним доступом

### Окремі портали входу
- **Студенти:** `/student/login` та `/student/register`
- **Інструктори:** `/instructor/login` та `/instructor/register`
- **Вибір ролі:** `/auth/choose-role`

### Middleware
- `auth` — Перевірка автентифікації
- `verified` — Перевірка email верифікації
- `student` — Доступ тільки для студентів
- `instructor` — Доступ тільки для інструкторів
- `admin` — Доступ тільки для адмінів

Детальна документація: [AUTHENTICATION_GUIDE.md](AUTHENTICATION_GUIDE.md)

---

## 📚 Корисні команди

```bash
# Очистити всі кеші
php artisan optimize:clear

# Переглянути логи в real-time
php artisan pail

# Запустити всі сервіси одночасно (dev mode)
composer dev

# Перевірити code style
./vendor/bin/pint

# Створити нового користувача
php artisan tinker
>>> User::factory()->create(['email' => 'test@example.com', 'role' => 'admin'])

# Налаштувати Telegram webhook
curl -X POST "https://api.telegram.org/bot{YOUR_BOT_TOKEN}/setWebhook?url={YOUR_APP_URL}/api/telegram/webhook"
```

---

## 🤝 Contributing

Цей проєкт є частиною дипломної роботи. Якщо ви знайшли баг або маєте пропозиції:

1. Створіть Issue з детальним описом
2. Fork репозиторій
3. Створіть feature branch (`git checkout -b feature/AmazingFeature`)
4. Commit зміни (`git commit -m 'Add some AmazingFeature'`)
5. Push до branch (`git push origin feature/AmazingFeature`)
6. Відкрийте Pull Request

---

## 🧑‍🏫 Автор

**Назар Скринський**
Fullstack Developer | PHP & Vue.js
🔗 Telegram: [@kiyotakaAjanokoji](https://t.me/kiyotakaAjanokoji)

---

## 📃 Ліцензія

Цей проєкт є частиною дипломної роботи. Усі права захищені © 2026

---

## 🙏 Подяки

- [Laravel](https://laravel.com) — The PHP Framework for Web Artisans
- [Vue.js](https://vuejs.org) — The Progressive JavaScript Framework
- [Filament](https://filamentphp.com) — The elegant TALL stack admin panel
- [Inertia.js](https://inertiajs.com) — The Modern Monolith
- [Tailwind CSS](https://tailwindcss.com) — A utility-first CSS framework
