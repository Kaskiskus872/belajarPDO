# Daftar Siswa — Penjelasan Kode

Dokumentasi singkat yang menjelaskan cara pakai dan cara kerja kode pada proyek ini.

File dalam folder:
- `koneksi.php`
- `students.php`
- `student.php`

**Cara Pakai**
- Letakkan folder proyek di webroot server (contoh: Laragon `www`).
- Pastikan layanan web (Apache/Nginx) dan MySQL berjalan.
- Sesuaikan konfigurasi koneksi di `koneksi.php` (variabel `$host`, `$dbname`, `$username`, `$password`).
- Buka di browser:
  - `http://localhost/<folder>/students.php` — menampilkan daftar semua siswa.
  - `http://localhost/<folder>/student.php?id=<id>` — menampilkan detail siswa dengan `id` tertentu.

**Cara Kerja**

`koneksi.php`
- Menyimpan konfigurasi koneksi database pada variabel: `$host`, `$dbname`, `$username`, `$password`.
- Membuat string DSN: `$dsn = "mysql:host=$host;dbname=$dbname;";`.
- Menginisialisasi koneksi PDO: `$pdo = new PDO($dsn, $username, $password);`.

`students.php`
- Memuat koneksi dengan `include 'koneksi.php';`.
- Menyiapkan statement SQL untuk mengambil semua baris: `SELECT * FROM STUDENTS`.
- Menjalankan statement dan mengambil semua hasil sebagai array asosiatif: `$datas = $stmt->fetchAll(PDO::FETCH_ASSOC);`.
- Melakukan iterasi terhadap `$datas` dan menampilkan setiap `name`, `email`, dan `telp` ke halaman.

`student.php`
- Memuat koneksi dengan `include 'koneksi.php';`.
- Mengambil parameter `id` dari query string: `$_GET['id']`.
- Menyiapkan statement parameterized untuk mengambil satu baris berdasarkan `id`: `SELECT * FROM STUDENTS WHERE id = ?`.
- Menjalankan statement dengan parameter `id` dan mengambil satu baris hasil dengan `$stmt->fetch(PDO::FETCH_ASSOC);`.
- Menampilkan kolom `name`, `email`, dan `telp` pada halaman.

**Contoh struktur tabel (SQL)**
```
CREATE TABLE STUDENTS (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  email VARCHAR(255),
  telp VARCHAR(50)
);
```
