# 🛒 Sistem Manajemen Barang - PHP OOP

##  Deskripsi
Sistem manajemen barang dengan CRUD (Create, Read, Update, Delete) menggunakan PHP OOP. Aplikasi web untuk mengelola data barang dengan upload gambar.

##  Fitur Utama
- **CRUD lengkap** (Tambah, Lihat, Ubah, Hapus)
-  **Upload gambar** dengan preview
-  **Kalkulator keuntungan** otomatis
-  **Design responsif** & modern
-  **Validasi form** real-time
-  **Class library** untuk database dan form

##  Struktur Folder
lab10_php_oop/
├── index.php # Halaman utama
├── tambah.php # Form tambah
├── ubah.php # Form ubah
├── hapus.php # Proses hapus
├── style.css # CSS styling
├── gambar/ # Folder upload
├── lib/ # Class library
│ ├── Database.php
│ └── Form.php
└── config/ # Konfigurasi
└── config.php

text

## ⚙️ Instalasi Cepat

### 1. Setup Database
```sql
CREATE DATABASE latihan1;
USE latihan1;

CREATE TABLE data_barang (
    id_barang INT AUTO_INCREMENT PRIMARY KEY,
    kategori VARCHAR(30),
    nama VARCHAR(30),
    gambar VARCHAR(100),
    harga_beli DECIMAL(10,0),
    harga_jual DECIMAL(10,0),
    stok INT(4)
);
2. Konfigurasi
Edit config/config.php:

php
<?php
$config = [
    'host' => 'localhost',
    'username' => 'root',
    'password' => '',
    'db_name' => 'latihan1'
];
?>
3. Jalankan Aplikasi
text
http://localhost/lab10_php_oop/
🔧 Class Library
Database Class
php
$db = new Database();
$db->insert('table', $data);
$db->update('table', $data, $where);
$db->delete('table', $where);
Form Class
php
$form = new Form('action.php', 'Submit');
$form->addField('nama', 'Nama Barang');
$form->displayForm();

 Cara Penggunaan

 Halaman Utama (index.php)
Tampilkan semua barang

Tombol Tambah/Ubah/Hapus

Tambah Barang (tambah.php)
Form input dengan validasi

Upload gambar + preview

Kalkulator keuntungan

 Ubah Barang (ubah.php)
Edit data yang sudah ada

Preview gambar lama

Hitung profit otomatis

 Hapus Barang
Konfirmasi sebelum hapus

Hapus gambar dari server

 Teknologi
Backend: PHP 7.4+, MySQL, OOP

Frontend: HTML5, CSS3, JavaScript

Icons: Font Awesome

Fonts: Google Fonts (Poppins)

 Responsive Design
Desktop: Layout 2 kolom

Tablet: Single column

Mobile: Form stacking

 Troubleshooting
Masalah Umum:
Database error → Cek config.php

Upload gagal → Cek permission folder gambar/

CSS tidak load → Cek path file CSS

JavaScript error → Buka console F12

📸 Screenshot
1. Halaman Utama (index.php)
https://docs/index.png

2. Form Tambah Barang
https://docs/tambah barang.png

3. Form Ubah Barang
https://docs/ubah barang.png

4. Konfirmasi Hapus
https://docs/hapus barang 1.png
https://docs/hapus barang 2.png

 Developer
Nama: Nurul Fadilah

NIM: 312410689

Kelas: TI.24.A3

Mata Kuliah: Pemrograman Web 1

Dosen: Agung Nugroho, S.Kom., M.Kom.

Universitas: Pelita Bangsa, Bekasi

 Kesimpulan
Praktikum PHP OOP berhasil dilaksanakan dengan baik. Sistem manajemen barang yang dibangun telah mengimplementasikan semua konsep OOP yang dipelajari. Aplikasi ini memiliki arsitektur yang baik dengan separasi logic menggunakan class library, interface yang user-friendly, dan fitur-fitur lengkap untuk operasi CRUD