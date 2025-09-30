# KarBin

KarBin یک سیستم مدیریت وظایف تحت وب است که با استفاده از فریم‌ورک Laravel توسعه داده شده است. این پروژه به شما امکان می‌دهد وظایف را بر اساس اولویت، مسئول، وضعیت، و زمان‌بندی مدیریت کنید.

## ویژگی‌ها

* مدیریت کاربران و احراز هویت
* ساخت، مشاهده، ویرایش و حذف وظایف (CRUD)
* دسته‌بندی پروژه‌ها و وظایف
* تعیین وضعیت و اولویت برای هر تسک
* رابط کاربری ساده و قابل توسعه

## تکنولوژی‌ها

* PHP 8+
* Laravel 12
* MySQL
* Blade (یا Angular در صورت استفاده)
* Bootstrap/Tailwind (در صورت استفاده)

## نصب و اجرا

### پیش‌نیازها

* PHP 8.1 یا بالاتر
* Composer
* MySQL
* Node.js و NPM (در صورت استفاده از فرانت‌اند با JS)

### مراحل نصب

#### نصب JWT

برای استفاده از JWT در این پروژه، ابتدا پکیج `tymon/jwt-auth` را نصب کنید:

```bash
composer require tymon/jwt-auth
```

سپس پکیج را پابلیش کنید:

```bash
php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider"
```

و کلید secret را بسازید:

```bash
php artisan jwt:secret
```

این کلید در فایل `.env` به صورت `JWT_SECRET` ذخیره خواهد شد.

```bash
git clone https://github.com/smmhnp/KarBin.git
cd KarBin
composer install
cp .env.example .env
php artisan key:generate
```

سپس فایل `.env` را ویرایش کرده و اطلاعات دیتابیس را وارد کنید:

```env
DB_DATABASE=karbin
DB_USERNAME=root
DB_PASSWORD=yourpassword
```

### ساخت جداول و داده نمونه:

```bash
php artisan migrate
php artisan db:seed
php artisan db:seed TitleSeeder
php artisan db:seed TaskSeeder
```

### اجرای برنامه

```bash
php artisan serve
```

پروژه روی `http://localhost:8000` قابل دسترسی خواهد بود.


برای استفاده از برنامه با داکر کافیه برانامه را روی سیستم pull کرده و در دایرکتور اصلی برنامه درستورات زیر را وارد کنید:
```bash
docker compose up -d
docker exec -it karbin-app php artisn migrate
docker exec -it karbin-app php artisn db:seed
docker exec -it karbin-app php artisn db:seed TitleSeeder
docker exec -it karbin-app php artisn db:seed TaskSeeder
```

سپس برنامه اصلی در ادرس `http://localhost:8000` اجرا شده و phpmyadmin در ادرس `http://localhost:8080` اجرا خواهد شد.


نام کاربری و رمز عبور برای ورود به برنامه:
```bash
email: admin@example.com
password: password
```


## توسعه‌دهنده
* [smmhnp](https://github.com/smmhnp)



