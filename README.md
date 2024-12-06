# Laravel Asessment

Asessment laravel List pegawai menggunakan jquery ajax, datatable, select2, daterangepicker, dropzone.js, dan sweetalert2

## Tech Stack

**Client:** jQuery, Bootstrap

**Server:** Laravel 11, MySQL, PHP 8.2+

## Instalasi

clone repository

```bash
  git clone https://github.com/Luthfiahmad12/laravel-assessment
  cd laravel-assessment
```

install dependency

```bash
  composer install
  npm install
  cp .env.example .env
```

Jalankan aplikasi

```bash
  npm run build
  php artisan migrate --seed
  php artisan key:generate
  php artisan serve
```

## API Reference

#### Ambil semua data

```http
  GET /api/employees
```

#### Ambil data by ID

```http
  GET /api/employees/${id}
```
