# 📚 Presensi Mahasiswa

Sistem manajemen presensi berbasis web untuk mahasiswa dan dosen. Proyek ini dibangun menggunakan PHP dan MariaDB, dirancang untuk memudahkan pencatatan kehadiran di lingkungan akademik.

## 🚀 Fitur Utama

* **Manajemen Pengguna**: Admin, Dosen, dan Mahasiswa dengan autentikasi terpisah.
* **Presensi Kelas**: Dosen dapat membuka dan menutup sesi presensi berdasarkan jadwal.
* **Rekap Kehadiran**: Mahasiswa dapat melihat riwayat kehadiran mereka.
* **Keamanan**: Password disimpan menggunakan enkripsi (misalnya, bcrypt).

## 💠 Teknologi yang Digunakan

* **Backend**: PHP
* **Database**: MariaDB
* **Frontend**: HTML, CSS, JavaScript (jika ada)
* **Lainnya**: Apache/Nginx sebagai web server

## 🧱 Struktur Database

Proyek ini menggunakan database `presensi_db` dengan tabel-tabel berikut:

* `admin`: Menyimpan data administrator.
* `mahasiswa`: Menyimpan data mahasiswa.
* `dosen`: Menyimpan data dosen.
* `class`: Menyimpan informasi kelas, termasuk jadwal dan dosen pengajar.
* `attendance`: Menyimpan data kehadiran mahasiswa.

## 🛆 Instalasi

1. **Clone Repository**

   ```bash
   git clone https://github.com/AndreasTopuh/presensi.git
   cd presensi
   ```

2. **Konfigurasi Database**

   * Buat database `presensi_db` di MariaDB.
   * Import struktur tabel dan data awal (jika tersedia) menggunakan file SQL yang disediakan.

3. **Konfigurasi Aplikasi**

   * Sesuaikan file konfigurasi (misalnya, `config.php`) dengan informasi database Anda.

4. **Menjalankan Aplikasi**

   * Pastikan web server dan database berjalan.
   * Akses aplikasi melalui browser di `http://localhost/presensi`.

## 📄 Lisensi

Proyek ini dilisensikan di bawah MIT License. Silakan lihat file [LICENSE](LICENSE) untuk informasi lebih lanjut.

## 🤝 Kontribusi

Kontribusi sangat dihargai! Jika Anda memiliki saran atau perbaikan, silakan buka issue atau pull request.
