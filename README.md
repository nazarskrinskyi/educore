# 🎓 EduCore — Онлайн-платформа для курсів

EduCore — це повнофункціональна Fullstack-платформа для онлайн-навчання, побудована з використанням **Vue 3**, **Laravel 12**, **Tailwind CSS** та **MySQL**. Студенти можуть проходити курси, переглядати відео, проходити тести, отримувати сертифікати. Інструктори створюють курси, а система надсилає нагадування через Telegram-бота.

---

## 🧑‍💻 Stack

- **Frontend**: Vue 3, Pinia, Vue Router, Tailwind CSS, Axios
- **Backend**: Laravel 12, Sanctum, REST API
- **Database**: MySQL 8
- **Auth**: Sanctum
- **Email**: Laravel Mail
- **Telegram Bot**: PHP Telegram Bot API (нагадування)
- **PDF**: Laravel DOMPDF (сертифікати)
- **CI/CD**: (optional) GitHub Actions

---

## 🗂 Функціонал

https://dbdiagram.io/d/68724213f413ba35088a104b

### 👤 Студент
- Реєстрація / логін
- Перегляд курсу, відео, уроків
- Проходження тестів
- Автоматичне оцінювання
- Отримання сертифіката у PDF
- Нагадування через Telegram
- Графік прогресу по курсу
- Темна/світла тема

### 👨‍🏫 Інструктор
- Створення курсів, уроків, тестів
- Редагування / видалення контенту
- Перегляд статистики учнів

### 🛠 Адмін
- Панель аналітики
- Управління курсами, користувачами
- Перегляд загального прогресу
---

📬 Інтеграція Telegram

    Користувач додає Telegram username

    Laravel щодня (через schedule:run) перевіряє незавершені курси

    Якщо користувач не відкривав курс >3 днів — бот надсилає нагадування

🎓 Сертифікати

    Після завершення 100% курсу

    PDF-генерація через DOMPDF

    Завантаження в особистому кабінеті

📜 Приклади API
Метод	URL	Опис
POST	/api/register	Реєстрація користувача
POST	/api/login	Авторизація користувача
GET	/api/courses	Отримати всі курси
GET	/api/courses/{id}	Курс з уроками
POST	/api/courses	Створити курс (інструктор)
POST	/api/lessons	Створити урок
GET	/api/certificates	Список сертифікатів

## 🧠 Архітектура

- **SPA** клієнт (Vue) працює окремо через REST API
- Laravel API з поділом на `auth`, `courses`, `lessons`, `tests`, `certificates`
- Telegram бот працює як окремий Listener (через webhook або cron)

---

## 📦 Встановлення

🧾 Laravel Backend
```bash
# Встановити залежності
composer install

# Створити .env
cp .env.example .env
php artisan key:generate

# Міграції
php artisan migrate --seed

# Запустити сервер
php artisan serve

# Встановити залежності
npm install

# Запустити у dev-режимі
npm run dev
``` 

🧪 Тестування
```bash
# Laravel тестування
php artisan test

# Vue тестування
npm run test
```

# Доступ:
# Laravel backend — http://localhost:8000
# Vue frontend  — http://localhost:5173


🧑‍🏫 Автор

Назар Скринський
Fullstack Developer | PHP & Vue | 💻
Telegram: @kiyotakaAjanokoji

📃 Ліцензія

Цей проєкт є частиною дипломної роботи. Усі права захищені.
