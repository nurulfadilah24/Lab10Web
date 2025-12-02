<?php
// ubah.php

include_once 'lib/Database.php';

$db = new Database();

// Ambil ID dari URL
$id = $_GET['id'] ?? 0;

// Ambil data barang berdasarkan ID
$barang = $db->get('data_barang', "id_barang = $id");

if (!$barang) {
    die("<div style='padding: 50px; text-align: center;'>
        <h2 style='color: #dc3545;'><i class='fas fa-exclamation-triangle'></i> Data tidak ditemukan!</h2>
        <a href='index.php' style='display: inline-block; margin-top: 20px;'>Kembali ke Daftar Barang</a>
    </div>");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Proses upload gambar jika ada
    $gambar = $barang['gambar']; // default gambar lama
    if ($_FILES['gambar']['error'] == 0) {
        $filename = str_replace(' ', '_', $_FILES['gambar']['name']);
        $destination = 'gambar/' . $filename;
        if (move_uploaded_file($_FILES['gambar']['tmp_name'], $destination)) {
            // Hapus gambar lama jika ada
            if ($gambar && file_exists('gambar/' . $gambar)) {
                unlink('gambar/' . $gambar);
            }
            $gambar = $filename;
        }
    }

    $data = [
        'nama'        => $_POST['nama'],
        'kategori'    => $_POST['kategori'],
        'harga_jual'  => $_POST['harga_jual'],
        'harga_beli'  => $_POST['harga_beli'],
        'stok'        => $_POST['stok'],
        'gambar'      => $gambar
    ];

    // Update data
    if ($db->update('data_barang', $data, "id_barang = $id")) {
        header('Location: index.php?success=edit');
        exit;
    } else {
        $error = "Gagal mengupdate data!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ubah Barang - CRUD OOP</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #4A00E0;
            --secondary: #8E2DE2;
            --success: #28a745;
            --danger: #dc3545;
            --warning: #ffc107;
            --info: #17a2b8;
            --light: #f8f9fa;
            --dark: #343a40;
            --gradient: linear-gradient(135deg, #4A00E0 0%, #8E2DE2 100%);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            color: #333;
        }
        
        .container {
            width: 100%;
            max-width: 1000px;
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
            overflow: hidden;
            animation: fadeIn 0.6s ease-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        /* ===== HEADER ===== */
        .header {
            background: var(--gradient);
            color: white;
            padding: 30px 40px;
            position: relative;
            overflow: hidden;
        }
        
        .header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: rgba(255, 255, 255, 0.1);
            transform: rotate(45deg);
        }
        
        .header-content {
            position: relative;
            z-index: 1;
        }
        
        .header h1 {
            font-size: 2.2rem;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .header h1 i {
            background: rgba(255, 255, 255, 0.2);
            padding: 15px;
            border-radius: 12px;
        }
        
        .header p {
            opacity: 0.9;
            margin-bottom: 15px;
        }
        
        /* ===== NAVIGATION ===== */
        .nav {
            display: flex;
            gap: 10px;
            margin-top: 15px;
        }
        
        .nav-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            background: rgba(255, 255, 255, 0.15);
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.2);
            font-size: 0.9rem;
        }
        
        .nav-btn:hover {
            background: rgba(255, 255, 255, 0.25);
            transform: translateY(-2px);
        }
        
        /* ===== CONTENT ===== */
        .content {
            padding: 40px;
        }
        
        /* ===== FORM LAYOUT ===== */
        .form-layout {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 30px;
        }
        
        .form-section {
            background: #f8f9fa;
            border-radius: 15px;
            padding: 25px;
            border: 1px solid #eaeaea;
        }
        
        .section-title {
            color: var(--primary);
            font-size: 1.3rem;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #eaeaea;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .section-title i {
            color: var(--primary);
        }
        
        /* ===== FORM TABLE ===== */
        .form-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 15px;
        }
        
        .form-row {
            margin-bottom: 15px;
        }
        
        .form-label {
            display: flex;
            align-items: center;
            gap: 10px;
            color: var(--dark);
            font-weight: 600;
            font-size: 0.95rem;
            margin-bottom: 8px;
        }
        
        .form-label i {
            color: var(--primary);
            width: 20px;
            text-align: center;
        }
        
        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e1e5e9;
            border-radius: 8px;
            font-size: 1rem;
            font-family: 'Poppins', sans-serif;
            transition: all 0.3s ease;
            background: white;
            color: #495057;
        }
        
        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(74, 0, 224, 0.1);
        }
        
        select.form-control {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%234A00E0' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14L2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 15px center;
            background-size: 14px;
            padding-right: 40px;
        }
        
        /* ===== PRICE INPUT ===== */
        .price-group {
            position: relative;
        }
        
        .price-prefix {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--success);
            font-weight: bold;
            font-size: 1rem;
        }
        
        .price-input {
            padding-left: 50px !important;
        }
        
        /* ===== IMAGE SECTION ===== */
        .image-section {
            display: flex;
            flex-direction: column;
            height: 100%;
        }
        
        .image-container {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 300px;
        }
        
        .current-image {
            width: 100%;
            max-width: 250px;
            height: 200px;
            border-radius: 12px;
            overflow: hidden;
            border: 4px solid white;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        
        .current-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .no-image {
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: white;
        }
        
        .no-image i {
            font-size: 2.5rem;
            margin-bottom: 10px;
        }
        
        .no-image span {
            font-size: 0.9rem;
            opacity: 0.9;
        }
        
        .image-info {
            text-align: center;
            margin-top: 10px;
            color: #666;
            font-size: 0.9rem;
        }
        
        /* ===== FILE UPLOAD ===== */
        .file-upload {
            margin-top: 20px;
            border-top: 1px solid #eaeaea;
            padding-top: 20px;
        }
        
        .file-upload-btn {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 12px 20px;
            background: var(--gradient);
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
            justify-content: center;
        }
        
        .file-upload-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(74, 0, 224, 0.2);
        }
        
        .file-input {
            display: none;
        }
        
        .file-hint {
            margin-top: 10px;
            color: #6c757d;
            font-size: 0.85rem;
            text-align: center;
        }
        
        /* ===== CALCULATOR ===== */
        .calculator {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 12px;
            padding: 20px;
            margin: 20px 0;
            border: 2px solid #dee2e6;
        }
        
        .calc-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 1px dashed #ced4da;
        }
        
        .calc-row:last-child {
            margin-bottom: 0;
            padding-bottom: 0;
            border-bottom: none;
        }
        
        .calc-label {
            color: #495057;
            font-weight: 500;
            font-size: 0.9rem;
        }
        
        .calc-value {
            font-weight: bold;
            font-size: 1rem;
        }
        
        .calc-profit {
            color: var(--success);
        }
        
        .calc-loss {
            color: var(--danger);
        }
        
        /* ===== BUTTONS ===== */
        .button-group {
            display: flex;
            gap: 15px;
            margin-top: 30px;
            padding-top: 25px;
            border-top: 1px solid #eaeaea;
        }
        
        .btn {
            flex: 1;
            padding: 14px;
            border: none;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            text-decoration: none;
        }
        
        .btn-primary {
            background: var(--gradient);
            color: white;
            box-shadow: 0 5px 15px rgba(74, 0, 224, 0.2);
        }
        
        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(74, 0, 224, 0.3);
        }
        
        .btn-secondary {
            background: #6c757d;
            color: white;
        }
        
        .btn-secondary:hover {
            background: #5a6268;
            transform: translateY(-2px);
        }
        
        /* ===== ERROR MESSAGE ===== */
        .alert {
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 25px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 12px;
            animation: slideIn 0.5s ease-out;
        }
        
        @keyframes slideIn {
            from { opacity: 0; transform: translateX(-20px); }
            to { opacity: 1; transform: translateX(0); }
        }
        
        .alert-danger {
            background: #f8d7da;
            color: #721c24;
            border: 2px solid #f5c6cb;
        }
        
        .alert-danger i {
            color: #dc3545;
        }
        
        /* ===== FOOTER ===== */
        .footer {
            background: var(--light);
            padding: 20px;
            text-align: center;
            color: #6c757d;
            border-top: 1px solid #eaeaea;
            margin-top: 30px;
            font-size: 0.9rem;
        }
        
        /* ===== RESPONSIVE ===== */
        @media (max-width: 992px) {
            .form-layout {
                grid-template-columns: 1fr;
                gap: 20px;
            }
            
            .container {
                max-width: 95%;
            }
        }
        
        @media (max-width: 768px) {
            .header {
                padding: 25px;
            }
            
            .header h1 {
                font-size: 1.8rem;
            }
            
            .content {
                padding: 25px;
            }
            
            .button-group {
                flex-direction: column;
            }
            
            .nav {
                flex-wrap: wrap;
            }
        }
        
        @media (max-width: 480px) {
            .header h1 {
                font-size: 1.5rem;
            }
            
            .form-control {
                padding: 10px 12px;
            }
            
            .btn {
                padding: 12px;
                font-size: 0.95rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="header-content">
                <h1><i class="fas fa-edit"></i> Ubah Barang</h1>
                <p>Perbarui informasi barang yang ada di inventori</p>
                
                <!-- Navigation -->
                <div class="nav">
                    <a href="index.php" class="nav-btn">
                        <i class="fas fa-arrow-left"></i>
                        <span>Kembali</span>
                    </a>
                    <a href="#" class="nav-btn">
                        <i class="fas fa-home"></i>
                        <span>Dashboard</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="content">
            <?php if (isset($error)): ?>
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle"></i>
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <form method="post" action="ubah.php?id=<?php echo $id; ?>" enctype="multipart/form-data" id="updateForm">
                <div class="form-layout">
                    <!-- Left: Form Inputs -->
                    <div class="form-section">
                        <div class="section-title">
                            <i class="fas fa-edit"></i>
                            <span>Informasi Barang</span>
                        </div>
                        
                        <table class="form-table">
                            <!-- Nama Barang -->
                            <tr class="form-row">
                                <td style="width: 40%;">
                                    <div class="form-label">
                                        <i class="fas fa-tag"></i>
                                        <span>Nama Barang</span>
                                    </div>
                                </td>
                                <td>
                                    <input type="text" id="nama" name="nama" class="form-control" 
                                           value="<?php echo htmlspecialchars($barang['nama']); ?>" 
                                           placeholder="Masukkan nama barang" required>
                                </td>
                            </tr>

                            <!-- Kategori -->
                            <tr class="form-row">
                                <td>
                                    <div class="form-label">
                                        <i class="fas fa-list"></i>
                                        <span>Kategori</span>
                                    </div>
                                </td>
                                <td>
                                    <select id="kategori" name="kategori" class="form-control" required>
                                        <option value="">Pilih Kategori</option>
                                        <option value="Elektronik" <?php echo $barang['kategori'] == 'Elektronik' ? 'selected' : ''; ?>>
                                            Elektronik
                                        </option>
                                        <option value="Komputer" <?php echo $barang['kategori'] == 'Komputer' ? 'selected' : ''; ?>>
                                            Komputer
                                        </option>
                                        <option value="Hand Phone" <?php echo $barang['kategori'] == 'Hand Phone' ? 'selected' : ''; ?>>
                                            Hand Phone
                                        </option>
                                        <option value="Aksesoris" <?php echo $barang['kategori'] == 'Aksesoris' ? 'selected' : ''; ?>>
                                            Aksesoris
                                        </option>
                                    </select>
                                </td>
                            </tr>

                            <!-- Harga Jual -->
                            <tr class="form-row">
                                <td>
                                    <div class="form-label">
                                        <i class="fas fa-money-bill-wave"></i>
                                        <span>Harga Jual</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="price-group">
                                        <span class="price-prefix">Rp</span>
                                        <input type="number" id="harga_jual" name="harga_jual" 
                                               class="form-control price-input" 
                                               value="<?php echo $barang['harga_jual']; ?>" 
                                               placeholder="Harga jual" min="0" required>
                                    </div>
                                </td>
                            </tr>

                            <!-- Harga Beli -->
                            <tr class="form-row">
                                <td>
                                    <div class="form-label">
                                        <i class="fas fa-shopping-cart"></i>
                                        <span>Harga Beli</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="price-group">
                                        <span class="price-prefix">Rp</span>
                                        <input type="number" id="harga_beli" name="harga_beli" 
                                               class="form-control price-input" 
                                               value="<?php echo $barang['harga_beli']; ?>" 
                                               placeholder="Harga beli" min="0" required>
                                    </div>
                                </td>
                            </tr>

                            <!-- Stok -->
                            <tr class="form-row">
                                <td>
                                    <div class="form-label">
                                        <i class="fas fa-boxes"></i>
                                        <span>Stok Barang</span>
                                    </div>
                                </td>
                                <td>
                                    <input type="number" id="stok" name="stok" class="form-control" 
                                           value="<?php echo $barang['stok']; ?>" 
                                           placeholder="Jumlah stok" min="0" required>
                                    <div id="stockIndicator" style="margin-top: 8px; font-size: 0.85rem;">
                                        <?php 
                                        if ($barang['stok'] >= 20) {
                                            echo '<span style="color: #28a745;">✅ Stok tinggi</span>';
                                        } elseif ($barang['stok'] >= 5) {
                                            echo '<span style="color: #ffc107;">⚠️ Stok normal</span>';
                                        } else {
                                            echo '<span style="color: #dc3545;">❌ Stok menipis</span>';
                                        }
                                        ?>
                                    </div>
                                </td>
                            </tr>
                        </table>

                        <!-- Calculator -->
                        <div class="calculator" id="calculator" style="display: none;">
                            <div class="calc-row">
                                <span class="calc-label">Harga Beli:</span>
                                <span class="calc-value" id="calcBeli">Rp 0</span>
                            </div>
                            <div class="calc-row">
                                <span class="calc-label">Harga Jual:</span>
                                <span class="calc-value" id="calcJual">Rp 0</span>
                            </div>
                            <div class="calc-row">
                                <span class="calc-label">Keuntungan:</span>
                                <span class="calc-value" id="calcProfit">Rp 0</span>
                            </div>
                            <div class="calc-row">
                                <span class="calc-label">Margin:</span>
                                <span class="calc-value" id="calcMargin">0%</span>
                            </div>
                        </div>
                    </div>

                    <!-- Right: Image Section -->
                    <div class="form-section image-section">
                        <div class="section-title">
                            <i class="fas fa-image"></i>
                            <span>Gambar Barang</span>
                        </div>
                        
                        <div class="image-container">
                            <!-- Current Image Preview -->
                            <div class="current-image">
                                <?php if (!empty($barang['gambar']) && file_exists('gambar/' . $barang['gambar'])): ?>
                                    <img src="gambar/<?php echo $barang['gambar']; ?>" 
                                         alt="<?php echo htmlspecialchars($barang['nama']); ?>"
                                         onerror="this.src='https://via.placeholder.com/250x200/4A00E0/ffffff?text=Gambar+Tidak+Tersedia'">
                                <?php else: ?>
                                    <div class="no-image">
                                        <i class="fas fa-image"></i>
                                        <span>Tidak ada gambar</span>
                                    </div>
                                <?php endif; ?>
                            </div>
                            
                            <div class="image-info">
                                <?php if (!empty($barang['gambar'])): ?>
                                    <p><i class="fas fa-file-image"></i> <?php echo $barang['gambar']; ?></p>
                                <?php else: ?>
                                    <p><i class="fas fa-info-circle"></i> Belum ada gambar</p>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- File Upload -->
                        <div class="file-upload">
                            <label for="gambar" class="file-upload-btn">
                                <i class="fas fa-upload"></i>
                                <span>Ubah Gambar</span>
                            </label>
                            <input type="file" id="gambar" name="gambar" class="file-input" 
                                   accept="image/*" onchange="handleFileSelect(this)">
                            <p class="file-hint">
                                <i class="fas fa-info-circle"></i> 
                                Kosongkan jika tidak ingin mengubah gambar
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="button-group">
                    <a href="index.php" class="btn btn-secondary">
                        <i class="fas fa-times"></i>
                        <span>Batal</span>
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i>
                        <span>Update Barang</span>
                    </button>
                </div>
            </form>
            
            <!-- Footer -->
            <div class="footer">
                <p><i class="fas fa-copyright"></i> <?php echo date('Y'); ?> Sistem Manajemen Barang | Universitas Pelita Bangsa</p>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        // DOM Elements
        const hargaJualInput = document.getElementById('harga_jual');
        const hargaBeliInput = document.getElementById('harga_beli');
        const stokInput = document.getElementById('stok');
        const stockIndicator = document.getElementById('stockIndicator');
        const calculator = document.getElementById('calculator');
        const calcBeli = document.getElementById('calcBeli');
        const calcJual = document.getElementById('calcJual');
        const calcProfit = document.getElementById('calcProfit');
        const calcMargin = document.getElementById('calcMargin');
        const fileInput = document.getElementById('gambar');

        // Format currency to IDR
        function formatCurrency(amount) {
            return 'Rp ' + amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        // Calculate profit and update display
        function calculateProfit() {
            const hargaJual = parseInt(hargaJualInput.value) || 0;
            const hargaBeli = parseInt(hargaBeliInput.value) || 0;
            
            if (hargaJual > 0 || hargaBeli > 0) {
                calculator.style.display = 'block';
                
                // Update calculator display
                calcBeli.textContent = formatCurrency(hargaBeli);
                calcJual.textContent = formatCurrency(hargaJual);
                
                const profit = hargaJual - hargaBeli;
                const margin = hargaBeli > 0 ? ((profit / hargaBeli) * 100).toFixed(1) : 0;
                
                // Update profit display
                if (profit > 0) {
                    calcProfit.textContent = '+' + formatCurrency(profit);
                    calcProfit.className = 'calc-value calc-profit';
                } else if (profit < 0) {
                    calcProfit.textContent = '-' + formatCurrency(Math.abs(profit));
                    calcProfit.className = 'calc-value calc-loss';
                } else {
                    calcProfit.textContent = formatCurrency(0);
                    calcProfit.className = 'calc-value';
                }
                
                // Update margin display
                if (margin > 0) {
                    calcMargin.textContent = `+${margin}%`;
                    calcMargin.className = 'calc-value calc-profit';
                } else if (margin < 0) {
                    calcMargin.textContent = `${margin}%`;
                    calcMargin.className = 'calc-value calc-loss';
                } else {
                    calcMargin.textContent = '0%';
                    calcMargin.className = 'calc-value';
                }
            } else {
                calculator.style.display = 'none';
            }
        }

        // Update stock indicator
        function updateStockIndicator() {
            const stock = parseInt(stokInput.value) || 0;
            
            if (stock >= 20) {
                stockIndicator.innerHTML = '<span style="color: #28a745;">✅ Stok tinggi</span>';
            } else if (stock >= 5) {
                stockIndicator.innerHTML = '<span style="color: #ffc107;">⚠️ Stok normal</span>';
            } else if (stock > 0) {
                stockIndicator.innerHTML = '<span style="color: #ffc107;">⚠️ Stok menipis</span>';
            } else {
                stockIndicator.innerHTML = '<span style="color: #dc3545;">❌ Stok habis</span>';
            }
        }

        // Handle file selection
        function handleFileSelect(input) {
            const file = input.files[0];
            
            if (file) {
                // Check file size (max 2MB)
                if (file.size > 2 * 1024 * 1024) {
                    alert('File terlalu besar! Maksimum 2MB.');
                    input.value = '';
                    return;
                }
                
                // Check file type
                if (!file.type.match('image.*')) {
                    alert('Hanya file gambar yang diperbolehkan!');
                    input.value = '';
                    return;
                }
                
                // Preview image
                const reader = new FileReader();
                reader.onload = function(e) {
                    const imageContainer = document.querySelector('.current-image');
                    imageContainer.innerHTML = `<img src="${e.target.result}" alt="Preview" style="width:100%;height:100%;object-fit:cover;">`;
                    
                    // Update image info
                    const imageInfo = document.querySelector('.image-info');
                    const fileSize = (file.size / 1024).toFixed(2);
                    imageInfo.innerHTML = `<p><i class="fas fa-file-image"></i> ${file.name} (${fileSize} KB)</p>`;
                };
                reader.readAsDataURL(file);
            }
        }

        // Event Listeners
        hargaJualInput.addEventListener('input', calculateProfit);
        hargaBeliInput.addEventListener('input', calculateProfit);
        stokInput.addEventListener('input', updateStockIndicator);
        
        // Format price inputs on blur
        function formatPriceInput(input) {
            const value = parseInt(input.value.replace(/\D/g, ''));
            if (!isNaN(value)) {
                input.value = value.toLocaleString('id-ID');
            }
        }
        
        hargaJualInput.addEventListener('blur', () => formatPriceInput(hargaJualInput));
        hargaBeliInput.addEventListener('blur', () => formatPriceInput(hargaBeliInput));
        
        // Form validation
        document.getElementById('updateForm').addEventListener('submit', function(e) {
            const nama = document.getElementById('nama').value.trim();
            const kategori = document.getElementById('kategori').value;
            
            if (!nama || !kategori) {
                e.preventDefault();
                alert('Harap isi semua field yang wajib diisi!');
                return;
            }
            
            // Show loading
            const submitBtn = this.querySelector('button[type="submit"]');
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';
            submitBtn.disabled = true;
        });

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            calculateProfit();
            updateStockIndicator();
            
            // Auto-focus first input
            document.getElementById('nama').focus();
        });
    </script>
</body>
</html>