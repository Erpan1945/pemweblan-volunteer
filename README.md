## 🌟 Volunteer Web App (Pemweblan)

Proyek ini adalah aplikasi web volunteering yang dikembangkan menggunakan Laravel dengan MySQL sebagai basis data.
Aplikasi ini mempertemukan relawan dengan penyelenggara kegiatan sosial seperti mengajar, bakti sosial, lingkungan, dan aktivitas bermanfaat lainnya.

### 🔧 Alat Pengembangan
1. Backend Framework : Laravel 10 (PHP 8+)
2. Database : MySQL
3. Package Manager : Composer & NPM (untuk asset build jika diperlukan)

### 🚀 Fitur Utama
1. Registrasi & Login (Relawan, Penyelenggara, Admin)
2. Profile (kelola data diri user)
3. Permohonan Kegiatan (penyelenggara mengajukan kegiatan baru → diverifikasi admin)
4. Publikasi Kegiatan (kegiatan yang disetujui admin ditampilkan ke publik)
5. Pendaftaran Kegiatan (relawan bisa daftar / batal)
6. Review Kegiatan (rating & komentar dari relawan)
7. Ikuti Penyelenggara (relawan bisa follow penyelenggara tertentu)
8. Manajemen Daftar Kegiatan (relawan bisa membuat list/favorit kegiatan)

### ⚙️ Instalasi

#### 1. Clone repo:
    git clone https://github.com/username/pemweblan-volunteer.git
    cd pemweblan-volunteer


#### 2. Install dependensi:
   ````
    composer install
   ````

#### 4. Buat file .env, lalu isi konfigurasi dasar.
````
APP_NAME=Volunteer
APP_ENV=local
APP_KEY=...
APP_DEBUG=true
APP_URL=http://localhost

````

#### 5. Generate APP_KEY:
   ````
    php artisan key:generate
   ````
#### 6. Migrasi database & seed data dummy:
   ````
    php artisan migrate:fresh --seed
   ````
#### 7. Jalankan server Laravel:
   ````
    php artisan serve
   ````
Akses di: http://localhost:8000

#### 👨‍💻 Kontribusi
Fork atau clone repo ini
Buat branch baru untuk fitur / bugfix
Pull request ke branch main
