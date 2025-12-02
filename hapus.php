<?php
// hapus.php

include_once 'lib/Database.php';

$db = new Database();

// Ambil ID dari URL
$id = $_GET['id'] ?? 0;

if ($id) {
    // Ambil data barang untuk hapus gambar
    $barang = $db->get('data_barang', "id_barang = $id");
    
    // Hapus gambar jika ada
    if ($barang && $barang['gambar'] && file_exists('gambar/' . $barang['gambar'])) {
        unlink('gambar/' . $barang['gambar']);
    }
    
    // Hapus data dari database
    if ($db->delete('data_barang', "id_barang = $id")) {
        header('Location: index.php');
        exit;
    } else {
        echo "Gagal menghapus data!";
    }
} else {
    echo "ID tidak valid!";
}
?>