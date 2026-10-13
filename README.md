# Portal Digital Sekolah

Portal informasi dan layanan akademik sekolah berbasis web. Siswa dan guru dapat mengakses layanan sesuai perannya, sementara admin dan tata usaha mengelola data serta kegiatan sekolah dari satu aplikasi.

---

## Masalah

Kegiatan akademik dan administrasi sekolah melibatkan banyak jenis informasi dan pengguna. Ketika prosesnya tersebar di buku, pesan pribadi, atau file yang berbeda, beberapa kendala dapat muncul:

- **Informasi sulit ditemukan.** Siswa dan guru harus mencari jadwal, pengumuman, nilai, atau informasi sekolah dari beberapa tempat. Informasi terbaru juga berisiko terlewat ketika hanya dibagikan lewat pesan.
- **Data sekolah tersebar.** Data siswa, guru, kelas, mata pelajaran, dan jadwal yang disimpan terpisah lebih sulit diperbarui dan dicocokkan. Perubahan data bisa tidak tersampaikan ke pihak yang membutuhkannya.
- **Pekerjaan administrasi berulang.** Admin dan tata usaha perlu mengelola data serta membuat rekap secara manual. Proses ini memakan waktu dan meningkatkan kemungkinan kesalahan saat menyalin atau memperbarui data.
- **Pemantauan akademik tidak praktis.** Guru membutuhkan cara yang terpusat untuk mengelola absensi dan nilai siswa, sementara siswa perlu cara mudah untuk melihat hasil belajar serta jadwalnya.
- **Layanan belum sesuai kebutuhan tiap pengguna.** Admin, tata usaha, guru, dan siswa memiliki tugas berbeda. Tanpa pembagian akses, pengguna bisa kesulitan menemukan layanan yang relevan atau mengakses data yang bukan bagiannya.
- **Absensi perlu mengikuti aturan sekolah.** Pencatatan kehadiran perlu mengikuti waktu dan ketentuan jaringan yang ditetapkan sekolah agar pelaksanaannya lebih teratur.

## Solusi

Portal Digital Sekolah menyediakan satu aplikasi untuk informasi publik dan layanan akademik. Aplikasi mengelompokkan fitur berdasarkan peran agar setiap pengguna dapat menjalankan tugasnya dari dashboard yang sesuai.

- **Satu sumber informasi sekolah.** Beranda menampilkan informasi, pengumuman, profil, kontak, dan struktur sekolah sehingga mudah ditemukan oleh pengunjung maupun warga sekolah.
- **Data terkelola dalam satu portal.** Admin dan tata usaha dapat mengelola data siswa, guru, kelas, mata pelajaran, jadwal, pengumuman, serta struktur sekolah melalui fitur administrasi.
- **Akses berdasarkan peran.** Admin, tata usaha, guru, dan siswa memperoleh dashboard serta hak akses yang berbeda. Pengelolaan khusus, seperti pengaturan situs, dibatasi untuk admin.
- **Dukungan kegiatan belajar.** Guru dapat mengelola absensi dan nilai siswa; siswa dapat melihat jadwal, absensi, nilai, dan pengumuman melalui akunnya.
- **Absensi dengan aturan sekolah.** Waktu absensi dan rentang IP jaringan yang diizinkan dapat disesuaikan melalui konfigurasi aplikasi.
- **Informasi sekolah mudah diperbarui.** Admin dapat memperbarui informasi sekolah serta latar visual hero beranda, termasuk dengan mengunggah gambar atau memasukkan tautan gambar.
- **Bantuan informasi otomatis.** Chatbot berbasis Gemini dapat menjawab pertanyaan terkait informasi sekolah setelah API key dikonfigurasi.

Dengan alur yang terpusat ini, pengguna dapat menemukan layanan yang dibutuhkan dengan lebih mudah, sedangkan sekolah memiliki tempat yang konsisten untuk mengelola dan menyampaikan informasi.

## Fitur Utama

**Pengunjung**

- Beranda berisi informasi sekolah, statistik, pengumuman, dan struktur sekolah
- Profil dan kontak sekolah
- Pendaftaran akun guru atau siswa dengan domain email yang diizinkan
- Chatbot informasi sekolah berbasis Google Gemini (opsional, membutuhkan API key)

**Admin dan Tata Usaha**

- Dashboard ringkasan data sekolah
- Kelola data siswa, guru, kelas, dan mata pelajaran
- Kelola jadwal pelajaran, pengumuman, dan struktur sekolah
- Kelola nilai dan permohonan cuti
- Ekspor data siswa dan guru
- Pengaturan informasi sekolah; pengaturan situs tertentu hanya untuk admin

**Guru**

- Dashboard, jadwal, dan informasi kelas
- Kelola absensi siswa sesuai kelas yang diampu
- Kelola nilai siswa
- Ajukan cuti
- Lihat pengumuman

**Siswa**

- Dashboard siswa
- Akses absensi sesuai aturan sekolah
- Lihat jadwal pelajaran, nilai, dan pengumuman
- Lengkapi biodata

**Pengelolaan situs**

- Atur informasi sekolah
- Atur latar visual hero beranda dengan mengunggah gambar atau memasukkan URL gambar

## Tech Stack

- PHP 8.3+
- Laravel 13
- Blade, Bootstrap 5, CSS, dan JavaScript
- Alpine.js dan Bootstrap Icons
- Vite dan npm
- SQLite (default) atau MySQL
- Google Gemini API untuk chatbot (opsional)

## Demo

Aplikasi dapat dijalankan secara lokal. Seeder menyediakan akun contoh untuk admin, tata usaha, guru, dan siswa. Kata sandi awal semua akun demo adalah `password`.

| Peran | Email | Kata sandi |
| --- | --- | --- |
| Admin | `admin@sekolah.sch.id` | `password` |
| Tata Usaha | `tu@sekolah.sch.id` | `password` |
| Guru | `budi@sekolah.sch.id` | `password` |
| Siswa | `andi.pratama@siswa.sch.id` | `password` |

Ganti kata sandi demo sebelum aplikasi dipakai di lingkungan nyata.

## Instalasi

### Persyaratan

- PHP 8.3 atau lebih baru beserta ekstensi yang dibutuhkan Laravel
- Composer
- Node.js dan npm
- SQLite atau MySQL

### Langkah instalasi (Windows PowerShell)

```powershell
git clone <URL-REPOSITORY>
cd portal-sekolah
composer install
Copy-Item .env.example .env
php artisan key:generate
```

Jika file `.env` sudah tersedia, jangan menimpanya. Jalankan `php artisan key:generate` hanya jika `APP_KEY` belum terisi.

Konfigurasi default menggunakan SQLite. Buat file database bila belum ada, lalu jalankan migrasi dan seeder:

```powershell
if (-not (Test-Path database/database.sqlite)) { New-Item database/database.sqlite -ItemType File }
php artisan migrate --seed
```

Untuk menggunakan MySQL, buat database lalu atur koneksi pada `.env`:

```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=portal_sekolah
DB_USERNAME=root
DB_PASSWORD=
```

Kemudian pasang dan build aset frontend, buat tautan penyimpanan publik, dan jalankan aplikasi:

```powershell
npm install
npm run build
php artisan storage:link
php artisan serve
```

Buka `http://127.0.0.1:8000`. Saat mengembangkan frontend, jalankan `npm run dev` di terminal terpisah. Untuk macOS/Linux, gunakan `cp .env.example .env` sebagai pengganti `Copy-Item`.

## Konfigurasi

Atur nilai berikut di `.env` sesuai kebutuhan sekolah:

- `SCHOOL_NAME`, `SCHOOL_ADDRESS`, `SCHOOL_PHONE`, `SCHOOL_EMAIL`, `SCHOOL_HOURS` — informasi sekolah
- `SCHOOL_EMAIL_DOMAINS` — domain email yang boleh mendaftar, dipisahkan koma
- `SCHOOL_WIFI_IPS` — alamat IP atau rentang CIDR Wi-Fi sekolah untuk pembatasan absensi
- `ABSENSI_JAM_MULAI`, `ABSENSI_JAM_SELESAI` — rentang waktu absensi
- `GEMINI_API_KEY`, `GEMINI_MODEL` — konfigurasi chatbot AI (opsional)

Setelah mengubah konfigurasi, jalankan `php artisan config:clear` jika nilai lama masih terbaca. Jangan simpan API key atau kredensial produksi ke repository.

## Perintah Berguna

```bash
php artisan serve       # Jalankan server Laravel
npm run dev             # Jalankan Vite untuk pengembangan frontend
npm run build           # Build aset untuk deployment
php artisan test        # Jalankan test suite
```

## Deployment

- Atur `APP_ENV=production`, `APP_DEBUG=false`, dan `APP_URL` sesuai alamat aplikasi.
- Arahkan document root web server ke direktori `public`.
- Pastikan `storage` dan `bootstrap/cache` dapat ditulis oleh web server.
- Gunakan kredensial database dan API key khusus untuk lingkungan produksi.

---

**Portal Digital Sekolah** — informasi dan layanan akademik sekolah dalam satu portal.
