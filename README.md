# danialtub

**danialtub** یک اکوسیستم قدرتمند برای اشتراک‌گذاری ویدیو و پلتفرم آموزشی است که برای عملکرد بالا و تجربه‌ کاربری مدرن طراحی شده است. این پروژه به عنوان یک راهکار جامع شامل یک API هدلس لاراول برای اپلیکیشن‌های موبایل، یک رابط کاربری وب کامل برای دانشجویان، و یک داشبورد مدیریتی پیشرفته برای مدرسان و مدیران عمل می‌کند.

<p align="center">
  <img src="img/danialtub.png" width="200" alt="danialtub Logo">
</p>

## 🚀 معماری و تکنولوژی‌های مورد استفاده

این پروژه از یک معماری کدنویسی مدرن و تمیز پیروی می‌کند تا قابلیت مقیاس‌پذیری و نگهداری را تضمین کند.

- **بک‌اند:** [Laravel 8](https://laravel.com/) (Headless API + Blade Views)
- **پایگاه داده:** SQLite (محلی) / MySQL (عملیاتی)
- **پنل مدیریت:** [TCG Voyager](https://voyager-docs.dev/) (مدرن‌سازی شده با Tailwind CSS)
- **CSS فرانت‌اند:** [Tailwind CSS](https://tailwindcss.com/) با پشتیبانی از RTL
- **تایپوگرافی:** فونت فارسی [وزیرمتن](https://github.com/rastikerdar/vazirmatn)
- **نمودارها:** [Chart.js](https://www.chartjs.org/) برای آنالیزهای پیشرفته
- **احراز هویت:** Laravel Sanctum (مبتنی بر توکن برای اپلیکیشن اندروید)

## 🖼️ اسکرین‌شات‌ها

### صفحه اصلی پلتفرم وب
![Web Platform Homepage](img/homepage.png)

### صفحه پخش ویدیو سفارشی
![Custom Video Player Page](img/course_player.png)

### داشبورد پنل مدیریت
![Admin Panel Dashboard](img/admin_dashboard.png)

## 🛠️ راهنمای نصب و راه‌اندازی

برای اجرای پروژه به صورت محلی، مراحل زیر را دنبال کنید:

### ۱. کلون کردن مخزن و نصب وابستگی‌های PHP
```bash
composer install
```

### ۲. نصب وابستگی‌های فرانت‌اند و بیلد کردن دارایی‌ها
```bash
npm install
npm run dev
```

### ۳. پیکربندی محیط (Environment)
فایل نمونه محیط را کپی کرده و کلید اپلیکیشن را تولید کنید:
```bash
cp .env.example .env
php artisan key:generate
```
*نکته: اطمینان حاصل کنید که `DB_CONNECTION` روی `sqlite` تنظیم شده و `DB_DATABASE` به مسیر مطلق فایل SQLite شما اشاره می‌کند.*

### ۴. راه‌اندازی و سیدینگ پایگاه داده
پایگاه داده را ایجاد کنید، مهاجرت‌ها (migrations) را اجرا کنید و داده‌های واقعی فارسی را وارد کنید:
```bash
touch database/database.sqlite
php artisan migrate --force
php artisan db:seed --class=RealisticDataSeeder
```

### ۵. اجرای اپلیکیشن
```bash
php artisan serve
```

## 📱 مستندات API موبایل (اندروید)

**بسیار مهم:** نقاط انتهایی (endpoints) API که در `routes/api.php` قرار دارند، منحصراً برای **اپلیکیشن اندروید danialtub** رزرو شده‌اند.

- **بازنویسی داخلی:** کنترلرها بازنویسی شده و کوئری‌ها برای عملکرد بهتر بهینه شده‌اند، اما ساختار پاسخ‌های JSON برای حفظ سازگاری یکسان باقی مانده است.
- **هشدار:** از تغییر نام، حذف یا اصلاح کلیدهای API یا ساختارهای پاسخ موجود خودداری کنید، زیرا باعث اختلال در اتصال اپلیکیشن موبایل خواهد شد.

## 📄 لایسنس

پروژه danialtub یک نرم‌افزار متن‌باز است که تحت [لایسنس MIT](https://opensource.org/licenses/MIT) منتشر شده است.

---

# danialtub

**danialtub** is a robust video-sharing and educational platform ecosystem designed for high performance and modern user experiences. It serves as a comprehensive solution featuring a headless Laravel API for mobile applications, a complete Web UI for students, and an advanced management dashboard for creators and administrators.

<p align="center">
  <img src="img/danialtub.png" width="200" alt="danialtub Logo">
</p>

## 🚀 Architecture & Tech Stack

The project follows a modern, clean code architecture to ensure scalability and maintainability.

- **Backend:** [Laravel 8](https://laravel.com/) (Headless API + Blade Views)
- **Database:** SQLite (Local) / MySQL (Production)
- **Admin Panel:** [TCG Voyager](https://voyager-docs.dev/) (Modernized with Tailwind CSS)
- **Frontend CSS:** [Tailwind CSS](https://tailwindcss.com/) with RTL support
- **Typography:** [Vazirmatn](https://github.com/rastikerdar/vazirmatn) Persian font
- **Charts:** [Chart.js](https://www.chartjs.org/) for advanced analytics
- **Authentication:** Laravel Sanctum (Token-based for Android App)


## 🖼️ Screenshots

### Web Platform Homepage
![Web Platform Homepage](img/homepage.png)

### Custom Video Player Page
![Custom Video Player Page](img/course_player.png)

### Admin Panel Dashboard
![Admin Panel Dashboard](img/admin_dashboard.png)

## 🛠️ Setup & Installation Guide

Follow these steps to get the project running locally:

### 1. Clone the repository and install PHP dependencies
```bash
composer install
```

### 2. Install Frontend dependencies and build assets
```bash
npm install
npm run dev
```

### 3. Environment Configuration
Copy the example environment file and generate the application key:
```bash
cp .env.example .env
php artisan key:generate
```
*Note: Ensure `DB_CONNECTION` is set to `sqlite` and `DB_DATABASE` points to your absolute path for the SQLite file.*

### 4. Database Setup & Seeding
Initialize the database, run migrations, and populate with realistic Persian data:
```bash
touch database/database.sqlite
php artisan migrate --force
php artisan db:seed --class=RealisticDataSeeder
```

### 5. Start the Application
```bash
php artisan serve
```

## 📱 Mobile API Documentation (Android)

**CRITICAL:** The API endpoints located in `routes/api.php` are strictly reserved for the **danialtub Android Application**.

- **Internal Refactoring:** The controllers have been refactored and queries optimized for performance, but the JSON response structures remain identical to preserve compatibility.
- **Warning:** Do not modify, rename, or delete existing API keys or response structures, as it will break the mobile application integration.


## License

The danialtub project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
