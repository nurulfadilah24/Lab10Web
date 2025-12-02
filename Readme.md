## Nama        : Nurul Fadilah
## NIM         : 312410689
## Kelas       : TI.24.A3
## Mata Kuliah : Pemrograman Web 1
## Dosen       : Agung Nugroho, S.Kom., M.Kom.
## Universitas : Pelita Bangsa, Bekasi

# 🛒 Sistem Manajemen Barang - PHP OOP

##  Deskripsi
Sistem manajemen barang dengan CRUD (Create, Read, Update, Delete) menggunakan PHP OOP. Aplikasi web untuk mengelola data barang dengan upload gambar.

##  Fitur Utama

✔️ CRUD lengkap (Tambah, Lihat, Ubah, Hapus)

✔️ Upload gambar dengan preview

✔️ Kalkulator keuntungan otomatis

✔️ Design responsif & modern

✔️ Validasi form real-time

✔️ Class library OOP (Database & Form)

##  Struktur Folder

lab10_php_oop/

├── index.php        # Halaman utama

├── tambah.php       # Form tambah

├── ubah.php         # Form ubah

├── hapus.php        # Proses hapus

├── style.css        # CSS styling

├── gambar/          # Folder upload

├── lib/              # Class library
│   ├── Database.php
│   └── Form.php

└── config/           # Konfigurasi
    └── config.php

1. Setup Database
   ```html
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
```

2. Konfigurasi
```html
<?php
$config = [
    'host' => 'localhost',
    'username' => 'root',
    'password' => '',
    'db_name' => 'latihan1'
];
?>
```

Class Library

Database Class

```html
$db = new Database();
$db->insert('table', $data);
$db->update('table', $data, $where);
$db->delete('table', $where);
```

Form Class

```html
$form = new Form('action.php', 'Submit');
$form->addField('nama', 'Nama Barang');
$form->displayForm();
```

Cara Pakai
 ## Halaman Utama (index.php)

Tampil semua barang

Tombol Tambah / Ubah / Hapus

## Tambah Barang (tambah.php)

Form input dengan validasi

Upload gambar + preview

Kalkulator keuntungan

## Ubah Barang (ubah.php)

Edit data yang sudah ada

Preview gambar lama

Hitung profit otomatis

## Hapus Barang

Konfirmasi sebelum hapus

Hapus gambar dari server

## Screenshot

## index.php
<img src="docs/<img width="1005" height="642" alt="index" src="https://github.com/user-attachments/assets/99e210b2-e064-4fc3-8f02-6405cad0a8e5" />
.png" width="450">

## Tambah
<img src="docs/<img width="557" height="633" alt="tambah barang" src="https://github.com/user-attachments/assets/cc1a8fc4-4fc3-4a49-949d-8d8311149c10" />
.png" width="450">

## Ubah
<img src="docs/<img width="494" height="622" alt="ubah barang" src="https://github.com/user-attachments/assets/a9e729bc-8e29-4322-bcef-0a1a8ae34c5b" />
.png" width="450">

## Hapus
<img src="docs/<img width="475" height="144" alt="hapus barang 1" src="https://github.com/user-attachments/assets/93c87179-d785-4a8b-b065-12795d1aab45" />
.png" width="450">

<img src="docs/<img width="858" height="499" alt="hapus barang 2" src="https://github.com/user-attachments/assets/bc7701ec-efef-4a25-a279-b2b2fb6d4c44" />
.png" width="450">

## Kesimpulan
Praktikum PHP OOP berhasil dilaksanakan dengan baik.
Sistem manajemen barang yang dibangun telah mengimplementasikan semua konsep OOP yang dipelajari.

Aplikasi ini memiliki:

Arsitektur yang baik

Pemisahan logic melalui class library

Tampilan user-friendly

Fitur CRUD lengkap dan modern



Praktikum PHP OOP berhasil dilaksanakan dengan baik. Sistem manajemen barang yang dibangun telah mengimplementasikan semua konsep OOP yang dipelajari. Aplikasi ini memiliki arsitektur yang baik dengan separasi logic menggunakan class library, interface yang user-friendly, dan fitur-fitur lengkap untuk operasi CRUD
