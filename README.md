# Daftar Siswa — Penjelasan Kode

Dokumentasi singkat untuk proyek kecil ini. File utama yang ada di folder:
- `koneksi.php`
- `student.php`
- `students.php`

**Tujuan proyek**: Menampilkan daftar siswa dan detail per siswa menggunakan koneksi database via PDO.

**Cara pakai singkat**:
- Letakkan folder di dalam webroot (mis. `www` pada Laragon).
- Pastikan database MySQL berjalan.
- Sesuaikan konfigurasi koneksi di `koneksi.php` (host, dbname, username, password).
- Akses `http://localhost/<folder>/students.php` untuk melihat semua siswa.
- Akses `http://localhost/<folder>/student.php?id=1` untuk melihat detail siswa dengan `id=1`.

**Penjelasan file**

**`koneksi.php`**:
- **Fungsi**: Membuat objek PDO untuk koneksi ke database MySQL.
- **Baris penting**:
  - ` $dsn = "mysql:host=$host;dbname=$dbname;";` : string DSN untuk PDO.
  - ` $pdo = new PDO($dsn, $username, $password);` : membuat koneksi PDO.
- **Catatan**: Saat ini koneksi dibuat secara sederhana. Disarankan menambahkan pengaturan error mode, mis.:
  ```php
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  ```
  dan menangani exception dengan `try { ... } catch (PDOException $e) { ... }`.

**`students.php`**:
- **Fungsi**: Mengambil semua baris dari tabel `STUDENTS` dan menampilkan nama serta detail singkat (email, telp) untuk setiap siswa.
- **Ringkas alur**:
  1. `include 'koneksi.php';` — memuat koneksi PDO dari `koneksi.php`.
  2. Menyiapkan query: `$stmt = $pdo->prepare("SELECT * FROM STUDENTS");` dan mengeksekusi: `$stmt->execute();`.
  3. Mengambil semua hasil sebagai array asosatif: `$datas = $stmt->fetchAll(PDO::FETCH_ASSOC);`.
  4. Melakukan `foreach` pada hasil dan mencetak `name`, `email`, `telp`.
- **Perhatian keamanan & kualitas**:
  - Kode menampilkan data langsung ke HTML tanpa escaping. Gunakan `htmlspecialchars()` saat menampilkan data agar aman terhadap XSS, contohnya:
    ```php
    echo '<h3>' . htmlspecialchars($data['name']) . '</h3>';
    ```
  - Gunakan struktur HTML yang lebih rapih (daftar atau tabel) untuk aksesibilitas.

**`student.php`**:
- **Fungsi**: Menampilkan detail satu siswa berdasarkan parameter query `id` (GET).
- **Ringkas alur**:
  1. `include 'koneksi.php';` — memuat koneksi.
  2. Mengambil `id` dari `$_GET['id']`.
  3. Menyiapkan query parameterized: `$stmt = $pdo->prepare("SELECT * FROM STUDENTS WHERE id = ?");` lalu `execute([$id]);`.
  4. Mengambil satu baris dengan `fetch(PDO::FETCH_ASSOC)` dan menampilkan `name`, `email`, `telp`.
- **Perhatian & perbaikan yang disarankan**:
  - Validasi input: pastikan `id` ada dan bertipe numerik sebelum dipakai.
    ```php
    if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
        // tangani error, redirect, atau tampilkan pesan
    }
    $id = (int) $_GET['id'];
    ```
  - Periksa apakah query mengembalikan hasil (tidak `false`) sebelum menampilkan data.
  - Escape output dengan `htmlspecialchars()` untuk mencegah XSS.

**Skema tabel (contoh SQL)**
- Berdasarkan kode, tabel harus minimal memiliki kolom `id`, `name`, `email`, dan `telp`. Contoh pembuatan tabel:
```sql
CREATE TABLE STUDENTS (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  email VARCHAR(255),
  telp VARCHAR(50)
);
```

**Rekomendasi perbaikan**
- Tambahkan error handling di `koneksi.php` (atur `ERRMODE_EXCEPTION` dan bungkus pembuatan PDO di `try/catch`).
- Escape semua output yang dicetak ke HTML dengan `htmlspecialchars()`.
- Validasi dan sanitasi input `$_GET['id']` di `student.php`.
- Jangan menampilkan pesan error database ke pengguna; log kesalahan pada server.
- Pertimbangkan menggunakan template sederhana atau komponen HTML untuk konsistensi tampilan.

**Contoh perubahan kecil (saran cepat untuk `student.php`)**
```php
include 'koneksi.php';

if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
    echo 'ID tidak valid.';
    exit;
}
$id = (int)$_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM STUDENTS WHERE id = ?");
$stmt->execute([$id]);

$data = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$data) {
    echo 'Data tidak ditemukan.';
    exit;
}

echo '<h3>' . htmlspecialchars($data['name']) . '</h3>';
// dst...
```

Jika Anda mau, saya bisa:
- Membuat versi yang lebih aman dari file `student.php` dan `students.php` secara langsung.
- Menambahkan layout HTML minimal agar tampilan lebih rapi.
- Membuat skrip instalasi database atau contoh data (INSERT statements).

---
File `README.md` berhasil dibuat di folder proyek. Jika mau, saya langsung perbarui file PHP sesuai rekomendasi.
