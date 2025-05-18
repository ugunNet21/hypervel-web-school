# Hyper Web School - Sistem Manajemen Sekolah Modern

![Admin CMS](public/backend/images/admin-cms.png)

![landingpage](https://github.com/user-attachments/assets/7b7b1029-03ba-48f6-8e17-34e4722047c1)

## Tentang Aplikasi

Hyper Web School adalah platform manajemen sekolah berbasis web dengan fitur lengkap untuk administrasi, pembelajaran, dan operasional sekolah modern.

## 🚀 Kontribusi

[![PRs Welcome](https://img.shields.io/badge/PRs-welcome-brightgreen.svg)](https://github.com/ugunNet21/hypervel-web-school/blob/master/CONTRIBUTING.md)

Lihat [panduan kontribusi](CONTRIBUTING.md) untuk memulai.

[![Join Discussion](https://img.shields.io/badge/Discussions-Join%20Now-brightgreen)](https://github.com/ugunNet21/hypervel-web-school/discussions)


## 📺 Video Tutorial

Pelajari cara penggunaan melalui seri video tutorial kami:

▶️ [Tonton Playlist Lengkap](https://www.youtube.com/playlist?list=PLusb1og4k-lpv17w2wJO1z5CBXqa8FRw-)


# 🛠 Panduan Instalasi Hyper Web School

## Prasyarat
- PHP 8.2+
- Composer 2.5+
- MySQL 8+
- Node.js 18+
- Git

## 🚀 Clone & Setup Awal

```bash
# Clone repository
git clone https://github.com/ugunNet21/hypervel-web-school.git
cd hypervel-web-school

# Install dependencies
composer install
npm install

# Setup environment
cp .env.example .env
php artisan key:generate
```

- Referensi Docker untuk hypervel: [hypervel-base-docker-app](https://github.com/ugunNet21/hypervel-base-docker-app)

### Backlog Pengembangan Sidebar Navigation

#### Fase 1: Core Functionality (Prioritas Tinggi)
1. **[Dashboard] Membuat tampilan dashboard utama sekolah**
   - Overview sekolah (statistik singkat)
   - Analytics dasar
   - Quick actions

2. **[Manajemen Sekolah] Sistem manajemen data sekolah dasar**
   - Data siswa (CRUD)
   - Data guru & staff (CRUD)
   - Data kelas (CRUD)
   - Mata pelajaran (CRUD)

3. **[PPDB Online] Sistem pendaftaran siswa baru**
   - Form pendaftaran online
   - Verifikasi dokumen
   - Pengumuman hasil

#### Fase 2: Academic Tools (Prioritas Menengah)
4. **[E-Learning] Platform pembelajaran dasar**
   - Kelas virtual
   - Materi pembelajaran
   - Tugas & quiz sederhana

5. **[E-Raport] Sistem penilaian dasar**
   - Input nilai oleh guru
   - Generate raport sederhana
   - Portofolio siswa dasar

6. **[Ujian Online] Sistem ujian dasar**
   - Bank soal
   - UTS/UAS online
   - Analisis hasil sederhana

#### Fase 3: Supporting Systems (Prioritas Menengah)
7. **[Perpustakaan] Sistem perpustakaan digital**
   - Katalog buku
   - Peminjaman online
   - E-book management

8. **[Portal Orang Tua] Monitoring untuk orang tua**
   - Tracking nilai anak
   - Pembayaran sekolah
   - Komunikasi dengan guru

9. **[Laporan] Sistem reporting dasar**
   - Laporan kehadiran
   - Laporan akademik
   - Custom report sederhana

#### Fase 4: Advanced Features (Prioritas Rendah)
10. **[AI Assistant] Fitur AI pembelajaran**
    - Tutor virtual dasar
    - Rekomendasi materi

11. **[Career Development] Pengembangan karir**
    - Psikotes online
    - Analisis bakat dasar

12. **[Monetisasi] Sistem pendapatan**
    - Marketplace sekolah dasar
    - Sistem donasi

#### Fase 5: Administration (Prioritas Tinggi Tapi Belakangan)
13. **[Admin] Sistem administrasi**
    - Manajemen user
    - Pengaturan sistem
    - Backup data
    - Integrasi API dasar

#### Fase 6: Fitur Premium/Pro
14. **[AI Advanced] Fitur AI lanjutan**
    - Penilaian esai otomatis
    - Pembuatan materi otomatis

15. **[Ujian Pro] Fitur ujian lanjutan**
    - Proctoring system
    - UNBK simulasi lengkap

16. **[Monetisasi Advanced] Fitur pendapatan lanjutan**
    - Kursus premium
    - Sponsorship system

## Struktur Project

```bash

app/
├── Console/
├── Events/
├── Exceptions/
├── Exports/
├── Helpers/
├── Http/
│ ├── Controllers/
│ │ ├── AbstractController.php
│ │ ├── admin/ # Controller untuk Administrasi Sistem
│ │ ├── AIAssistant/ # Controller untuk AI Learning Assistant
│ │ ├── Analytics/ # Controller untuk Laporan & Analytics
│ │ ├── CareerDevelopment/ # Controller untuk Career Development
│ │ ├── core/ # Controller untuk Core System
│ │ ├── DigitalLibrary/ # Controller untuk Perpustakaan Digital
│ │ ├── ELearning/ # Controller untuk E-Learning
│ │ ├── ERaport/ # Controller untuk E-Raport & Penilaian
│ │ ├── IndexController.php # Controller untuk Dashboard Utama
│ │ ├── Monetization/ # Controller untuk Sistem Monetisasi
│ │ ├── OnlineExam/ # Controller untuk Ujian Online
│ │ ├── ParentPortal/ # Controller untuk Portal Orang Tua
│ │ ├── PPDB/ # Controller untuk PPDB Online
│ │ └── SchoolManagement/ # Controller untuk Manajemen Sekolah
│ ├── Kernel.php
│ ├── Middleware/
│ └── Requests/
│ ├── AIAssistant/ # Form Request untuk AI Assistant
│ ├── Analytics/ # Form Request untuk Analytics
│ ├── CareerDevelopment/ # Form Request untuk Career Development
│ ├── DigitalLibrary/ # Form Request untuk Digital Library
│ ├── ELearning/ # Form Request untuk E-Learning
│ ├── ERaport/ # Form Request untuk E-Raport
│ ├── Monetization/ # Form Request untuk Monetization
│ ├── OnlineExam/ # Form Request untuk Online Exam
│ ├── ParentPortal/ # Form Request untuk Parent Portal
│ ├── PPDB/ # Form Request untuk PPDB
│ └── SchoolManagement/ # Form Request untuk School Management
├── Imports/
├── Libraries/
├── Listeners/
├── Mail/
├── Models/
│ ├── AIAssistant/ # Model untuk AI Assistant
│ ├── Analytics/ # Model untuk Analytics
│ ├── CareerDevelopment/ # Model untuk Career Development
│ ├── DigitalLibrary/ # Model untuk Digital Library
│ ├── ELearning/ # Model untuk E-Learning
│ ├── ERaport/ # Model untuk E-Raport
│ ├── Monetization/ # Model untuk Monetization
│ ├── OnlineExam/ # Model untuk Online Exam
│ ├── ParentPortal/ # Model untuk Parent Portal
│ ├── PPDB/ # Model untuk PPDB
│ ├── SchoolManagement/ # Model untuk School Management
│ ├── Model.php
│ └── User.php
├── Providers/
├── Repositories/
│ ├── AIAssistant/ # Repository untuk AI Assistant
│ ├── Analytics/ # Repository untuk Analytics
│ ├── CareerDevelopment/ # Repository untuk Career Development
│ ├── DigitalLibrary/ # Repository untuk Digital Library
│ ├── ELearning/ # Repository untuk E-Learning
│ ├── ERaport/ # Repository untuk E-Raport
│ ├── Monetization/ # Repository untuk Monetization
│ ├── OnlineExam/ # Repository untuk Online Exam
│ ├── ParentPortal/ # Repository untuk Parent Portal
│ ├── PPDB/ # Repository untuk PPDB
│ └── SchoolManagement/ # Repository untuk School Management
├── Services/
│ ├── AIAssistant/ # Service untuk AI Assistant
│ ├── Analytics/ # Service untuk Analytics
│ ├── CareerDevelopment/ # Service untuk Career Development
│ ├── DigitalLibrary/ # Service untuk Digital Library
│ ├── ELearning/ # Service untuk E-Learning
│ ├── ERaport/ # Service untuk E-Raport
│ ├── Monetization/ # Service untuk Monetization
│ ├── OnlineExam/ # Service untuk Online Exam
│ ├── ParentPortal/ # Service untuk Parent Portal
│ ├── PPDB/ # Service untuk PPDB
│ └── SchoolManagement/ # Service untuk School Management
├── Traits/
└── Utils/

database/
├── factories/
│   ├── AIAssistant/                # Factory untuk AI Assistant
│   ├── Analytics/                  # Factory untuk Analytics
│   ├── CareerDevelopment/          # Factory untuk Career Development
│   ├── DigitalLibrary/             # Factory untuk Digital Library
│   ├── ELearning/                  # Factory untuk E-Learning
│   ├── ERaport/                    # Factory untuk E-Raport
│   ├── Monetization/               # Factory untuk Monetization
│   ├── OnlineExam/                 # Factory untuk Online Exam
│   ├── ParentPortal/               # Factory untuk Parent Portal
│   ├── PPDB/                       # Factory untuk PPDB
│   ├── SchoolManagement/           # Factory untuk School Management
│   └── UserFactory.php
├── migrations/
└── seeders/
    ├── AIAssistant/                # Seeder untuk AI Assistant
    ├── Analytics/                  # Seeder untuk Analytics
    ├── CareerDevelopment/          # Seeder untuk Career Development
    ├── DigitalLibrary/             # Seeder untuk Digital Library
    ├── ELearning/                  # Seeder untuk E-Learning
    ├── ERaport/                    # Seeder untuk E-Raport
    ├── Monetization/               # Seeder untuk Monetization
    ├── OnlineExam/                 # Seeder untuk Online Exam
    ├── ParentPortal/               # Seeder untuk Parent Portal
    ├── PPDB/                       # Seeder untuk PPDB
    ├── SchoolManagement/           # Seeder untuk School Management
    └── DatabaseSeeder.php

resources/views/
├── admin/
│   ├── includes/                   # File include untuk admin
│   ├── layouts/                    # Layout admin
│   ├── partials/                   # Partial views admin
│   └── pages/
│       ├── AIAssistant/            # View untuk AI Assistant
│       ├── Analytics/              # View untuk Analytics
│       ├── CareerDevelopment/      # View untuk Career Development
│       ├── DigitalLibrary/         # View untuk Digital Library
│       ├── ELearning/              # View untuk E-Learning
│       ├── ERaport/                # View untuk E-Raport
│       ├── Monetization/           # View untuk Monetization
│       ├── OnlineExam/             # View untuk Online Exam
│       ├── ParentPortal/           # View untuk Parent Portal
│       ├── PPDB/                   # View untuk PPDB
│       └── SchoolManagement/       # View untuk School Management
└── home.blade.php                  # Homepage utama

routes/
├── api.php                         # API Routes
├── channels.php                    # Broadcast Channels
├── console.php                     # Artisan Commands
└── web.php                         # Web Routes

```
## Teknologi yang Digunakan

### Backend
- [Hypervel Framework](https://hypervel.org) - Laravel-style PHP framework dengan coroutine support
- PHP 8.2+
- MySQL 8
- Sqlite
- Redis

### Frontend
- Bootstrap 5
- Javascript

## Package Penting

```json
{
  "require": {
    "hypervel/framework": "^0.1",
    "ext-redis": "*"
  },
  "require-dev": {
    "hyperf/testing": "~3.1.0",
    "phpunit/phpunit": "10.5.45"
  }
}
```

## Making

```bash
- Model
- Migrations
- Controller
- Repositories
- Request
- Livwire
- Middleware
- Route
- Modules

```
## Install package

````
- Spatie permission
- Laravolt
- Nwimodules
- Laravel UI
- Laravel Passport

````

```php

Available commands for the "make" namespace:
  make:amqp-consumer        [gen:amqp-consumer] Create a new amqp consumer class
  make:amqp-producer        [gen:amqp-producer] Create a new amqp producer class
  make:aspect               [gen:aspect] Create a new aspect class
  make:channel              Create a new channel class
  make:class                [gen:class] Create a new class
  make:command              Create a new Artisan command
  make:component            Create a new view component class
  make:constant             [gen:constant] Create a new constant class
  make:controller           [gen:controller] Create a new controller class
  make:event                Create a new event class
  make:factory              Create a new model factory
  make:job                  Create a new job class
  make:kafka-consumer       [gen:kafka-consumer] Create a new kafka consumer class
  make:listener             Create a new event listener class
  make:mail                 Create a new email class
  make:middleware           [gen:middleware] Create a new middleware class
  make:migration            [gen:migration] Generate a new migration file
  make:model                Create a new Eloquent model class
  make:nats-consumer        [gen:nats-consumer] Create a new nats consumer class
  make:notification         Create a new notification class
  make:notifications-table  [notifications:table] Create a migration for the notifications table
  make:nsq-consumer         [gen:nsq-consumer] Create a new nsq consumer class
  make:observer             Create a new model observer class
  make:policy               Create a new policy class
  make:process              [gen:process] Create a new process class
  make:provider             Create a new service provider class
  make:queue-batches-table  [queue:batches-table] Create a migration for the batches database table
  make:queue-failed-table   [queue:failed-table] Create a migration for the failed queue jobs database table
  make:queue-table          [queue:table] Create a migration for the queue jobs database table
  make:request              Create a new form request class
  make:resource             [gen:resource] create a new resource
  make:rule                 Create a new validation rule
  make:seeder               Create a new seeder class
  make:session-table        [session:table] Create a migration for the session database table
  make:test                 Create a new test class

```

# Create base table like spatie

```php
php artisan make:model Role -m
# → Migration: 2025_05_17_154027_create_roles_table

php artisan make:model Permission -m
# → Migration: 2025_05_17_154203_create_permissions_table

php artisan make:model ModelHasRole -m
# → Migration: 2025_05_17_154248_create_model_has_roles_table

php artisan make:model ModelHasPermission -m
# → Migration: 2025_05_17_154400_create_model_has_permissions_table

php artisan make:model RoleHasPermission -m
# → Migration: 2025_05_17_154437_create_role_has_permissions_table

```


> See [this issue](https://github.com/laravel/octane/issues/765) for more discussions.

## Documentation

[https://hypervel.org/docs](https://hypervel.org/docs)

Hypervel provides comprehensive and user-friendly documentation that allows you to quickly get started. From this documentation, you can learn how to use various components in Hypervel and understand the differences between this framework and Laravel.

> Most of the content in this documentation is referenced from the official Laravel documentation. We appreciate the Laravel community's contributions.

## License

The Hypervel framework is open-sourced software licensed under the [MIT](https://opensource.org/licenses/MIT) license.
