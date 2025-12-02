<?php
// index.php
include_once 'lib/Database.php';

$db = new Database();
$result = $db->query("SELECT * FROM data_barang");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Data Barang - CRUD OOP</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- CSS Local -->
    <link href="style.css" rel="stylesheet" type="text/css">
    <style>
        /* Inline CSS sebagai fallback */
        .temp-style {
            font-family: 'Poppins', sans-serif;
            background: #f5f5f5;
            padding: 20px;
        }
        .temp-container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }
        .temp-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 25px;
            border-radius: 10px 10px 0 0;
            margin-bottom: 30px;
        }
        .temp-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        .temp-table th {
            background: #4A00E0;
            color: white;
            padding: 15px;
            text-align: left;
        }
        .temp-table td {
            padding: 12px 15px;
            border-bottom: 1px solid #eee;
        }
        .temp-table tr:hover {
            background: #f8f9ff;
        }
        .btn {
            padding: 8px 15px;
            border-radius: 5px;
            text-decoration: none;
            display: inline-block;
            margin: 2px;
            font-size: 14px;
        }
        .btn-primary {
            background: #4A00E0;
            color: white;
        }
        .btn-warning {
            background: #ffc107;
            color: #333;
        }
        .btn-danger {
            background: #dc3545;
            color: white;
        }
    </style>
</head>
<body class="temp-style">
    <div class="temp-container">
        <!-- Header -->
        <div class="temp-header">
            <h1><i class="fas fa-boxes"></i> Data Barang</h1>
            <p>Sistem Manajemen Inventori dengan PHP OOP</p>
        </div>

        <!-- Navigation -->
        <div style="margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center;">
            <a href="tambah.php" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Barang Baru
            </a>
            <span style="color: #666;">
                <i class="fas fa-database"></i> Total Data: <?php echo $result->num_rows; ?>
            </span>
        </div>

        <!-- Data Table -->
        <table class="temp-table">
            <thead>
                <tr>
                    <th><i class="fas fa-image"></i> Gambar</th>
                    <th><i class="fas fa-tag"></i> Nama Barang</th>
                    <th><i class="fas fa-list"></i> Kategori</th>
                    <th><i class="fas fa-money-bill-wave"></i> Harga Jual</th>
                    <th><i class="fas fa-shopping-cart"></i> Harga Beli</th>
                    <th><i class="fas fa-box"></i> Stok</th>
                    <th><i class="fas fa-cogs"></i> Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result && $result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td>
                            <?php if (!empty($row['gambar'])): ?>
                                <img src="gambar/<?= $row['gambar'] ?>" alt="<?= $row['nama'] ?>" 
                                     style="width: 80px; height: 80px; object-fit: cover; border-radius: 5px; border: 2px solid #eee;">
                            <?php else: ?>
                                <div style="width: 80px; height: 80px; background: #f0f0f0; border-radius: 5px; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-image" style="color: #ccc; font-size: 24px;"></i>
                                </div>
                            <?php endif; ?>
                        </td>
                        <td><strong><?= htmlspecialchars($row['nama']) ?></strong></td>
                        <td>
                            <span style="background: #e9ecef; padding: 5px 10px; border-radius: 20px; font-size: 12px;">
                                <?= $row['kategori'] ?>
                            </span>
                        </td>
                        <td style="color: #28a745; font-weight: bold;">
                            Rp <?= number_format($row['harga_jual'], 0, ',', '.') ?>
                        </td>
                        <td style="color: #dc3545; font-weight: bold;">
                            Rp <?= number_format($row['harga_beli'], 0, ',', '.') ?>
                        </td>
                        <td>
                            <span style="background: <?= $row['stok'] > 0 ? '#d4edda' : '#f8d7da' ?>; 
                                  color: <?= $row['stok'] > 0 ? '#155724' : '#721c24' ?>;
                                  padding: 5px 10px; border-radius: 5px; font-weight: bold;">
                                <?= $row['stok'] ?>
                            </span>
                        </td>
                        <td>
                            <a href="ubah.php?id=<?= $row['id_barang'] ?>" class="btn btn-warning">
                                <i class="fas fa-edit"></i> Ubah
                            </a>
                            <a href="hapus.php?id=<?= $row['id_barang'] ?>" 
                               class="btn btn-danger"
                               onclick="return confirm('Yakin ingin menghapus <?= $row['nama'] ?>?')">
                                <i class="fas fa-trash"></i> Hapus
                            </a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 40px; color: #666;">
                            <i class="fas fa-box-open" style="font-size: 48px; color: #ddd; margin-bottom: 15px;"></i><br>
                            Belum ada data barang. <a href="tambah.php">Tambah barang pertama</a>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- Footer -->
        <div style="margin-top: 40px; padding-top: 20px; border-top: 1px solid #eee; text-align: center; color: #666;">
            <p>
                <i class="fas fa-info-circle"></i> 
                Sistem CRUD dengan PHP OOP | Praktikum 10 | Universitas Pelita Bangsa
            </p>
        </div>
    </div>

    <!-- JavaScript untuk konfirmasi -->
    <script>
        // Confirmation untuk delete
        document.querySelectorAll('.btn-danger').forEach(link => {
            link.addEventListener('click', function(e) {
                if (!confirm('Yakin ingin menghapus data ini?')) {
                    e.preventDefault();
                }
            });
        });
    </script>
</body>
</html>