<?php
// tambah.php

include_once 'lib/Database.php';

$db = new Database();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Proses upload gambar
    $gambar = null;
    if ($_FILES['gambar']['error'] == 0) {
        $filename = str_replace(' ', '_', $_FILES['gambar']['name']);
        $destination = 'gambar/' . $filename;
        if (move_uploaded_file($_FILES['gambar']['tmp_name'], $destination)) {
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

    // Insert data ke database
    if ($db->insert('data_barang', $data)) {
        header('Location: index.php?success=add');
        exit;
    } else {
        $error = "Gagal menambahkan data!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tambah Barang - CRUD OOP</title>
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
            max-width: 1100px;
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
            grid-template-columns: 1.2fr 0.8fr;
            gap: 30px;
            margin-bottom: 30px;
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
            border-spacing: 0 12px;
        }
        
        .form-label {
            display: flex;
            align-items: center;
            gap: 10px;
            color: var(--dark);
            font-weight: 600;
            font-size: 0.95rem;
            min-width: 150px;
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
        
        /* ===== STOCK INDICATOR ===== */
        .stock-indicator {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
            margin-top: 8px;
        }
        
        .stock-high { background: #d4edda; color: #155724; }
        .stock-medium { background: #fff3cd; color: #856404; }
        .stock-low { background: #f8d7da; color: #721c24; }
        
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
            min-height: 250px;
        }
        
        .image-preview {
            width: 100%;
            max-width: 280px;
            height: 180px;
            border-radius: 12px;
            overflow: hidden;
            border: 4px solid white;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        
        .preview-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .no-preview {
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: white;
        }
        
        .no-preview i {
            font-size: 2.5rem;
            margin-bottom: 10px;
        }
        
        .no-preview span {
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
                <h1><i class="fas fa-plus-circle"></i> Tambah Barang Baru</h1>
                <p>Isi form berikut untuk menambahkan barang baru ke dalam sistem</p>
                
                <!-- Navigation -->
                <div class="nav">
                    <a href="index.php" class="nav-btn">
                        <i class="fas fa-arrow-left"></i>
                        <span>Kembali ke Daftar</span>
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

            <form method="post" action="tambah.php" enctype="multipart/form-data" id="productForm">
                <div class="form-layout">
                    <!-- Left: Form Inputs -->
                    <div class="form-section">
                        <div class="section-title">
                            <i class="fas fa-edit"></i>
                            <span>Informasi Barang</span>
                        </div>
                        
                        <table class="form-table">
                            <!-- Nama Barang -->
                            <tr>
                                <td style="width: 40%; vertical-align: top;">
                                    <div class="form-label">
                                        <i class="fas fa-tag"></i>
                                        <span>Nama Barang</span>
                                    </div>
                                </td>
                                <td>
                                    <input type="text" id="nama" name="nama" class="form-control" 
                                           placeholder="Masukkan nama barang" required>
                                    <small style="display: block; margin-top: 8px; color: #6c757d; font-size: 0.85rem;">
                                        <i class="fas fa-info-circle"></i> Contoh: HP Samsung Galaxy S23
                                    </small>
                                </td>
                            </tr>

                            <!-- Kategori -->
                            <tr>
                                <td style="vertical-align: top;">
                                    <div class="form-label">
                                        <i class="fas fa-list"></i>
                                        <span>Kategori</span>
                                    </div>
                                </td>
                                <td>
                                    <select id="kategori" name="kategori" class="form-control" required>
                                        <option value="">Pilih Kategori</option>
                                        <option value="Elektronik">📱 Elektronik</option>
                                        <option value="Komputer">💻 Komputer & Laptop</option>
                                        <option value="Hand Phone">📞 Hand Phone</option>
                                        <option value="Aksesoris">🎧 Aksesoris</option>
                                        <option value="Perangkat Kantor">🏢 Perangkat Kantor</option>
                                        <option value="Furniture">🪑 Furniture</option>
                                        <option value="Alat Tulis">✏️ Alat Tulis Kantor</option>
                                    </select>
                                </td>
                            </tr>

                            <!-- Harga Jual -->
                            <tr>
                                <td style="vertical-align: top;">
                                    <div class="form-label">
                                        <i class="fas fa-money-bill-wave"></i>
                                        <span>Harga Jual (Rp)</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="price-group">
                                        <span class="price-prefix">Rp</span>
                                        <input type="number" id="harga_jual" name="harga_jual" 
                                               class="form-control price-input" 
                                               placeholder="Contoh: 2400000" min="0" required>
                                    </div>
                                </td>
                            </tr>

                            <!-- Harga Beli -->
                            <tr>
                                <td style="vertical-align: top;">
                                    <div class="form-label">
                                        <i class="fas fa-shopping-cart"></i>
                                        <span>Harga Beli (Rp)</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="price-group">
                                        <span class="price-prefix">Rp</span>
                                        <input type="number" id="harga_beli" name="harga_beli" 
                                               class="form-control price-input" 
                                               placeholder="Contoh: 2000000" min="0" required>
                                    </div>
                                </td>
                            </tr>

                            <!-- Stok -->
                            <tr>
                                <td style="vertical-align: top;">
                                    <div class="form-label">
                                        <i class="fas fa-boxes"></i>
                                        <span>Stok Barang</span>
                                    </div>
                                </td>
                                <td>
                                    <input type="number" id="stok" name="stok" class="form-control" 
                                           placeholder="Jumlah stok yang tersedia" min="0" required>
                                    <div id="stockIndicator" class="stock-indicator stock-high">✅ Stok normal</div>
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
                                <span class="calc-label">Keuntungan/Rugi:</span>
                                <span class="calc-value" id="calcProfit">Rp 0</span>
                            </div>
                            <div class="calc-row">
                                <span class="calc-label">Margin Profit:</span>
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
                            <!-- Image Preview -->
                            <div class="image-preview">
                                <div class="no-preview" id="noPreview">
                                    <i class="fas fa-image"></i>
                                    <span>Belum ada gambar</span>
                                </div>
                                <img src="" class="preview-img" id="imagePreview" style="display: none;">
                            </div>
                            
                            <div class="image-info" id="imageInfo">
                                <p><i class="fas fa-info-circle"></i> Preview gambar akan muncul di sini</p>
                            </div>
                        </div>

                        <!-- File Upload -->
                        <div class="file-upload">
                            <label for="gambar" class="file-upload-btn">
                                <i class="fas fa-upload"></i>
                                <span>Pilih Gambar</span>
                            </label>
                            <input type="file" id="gambar" name="gambar" class="file-input" 
                                   accept="image/*" onchange="handleFileSelect(this)">
                            <p class="file-hint">
                                <i class="fas fa-info-circle"></i> 
                                Format: JPG, PNG, GIF | Maks: 2MB
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
                        <span>Simpan Barang</span>
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
        const imagePreview = document.getElementById('imagePreview');
        const noPreview = document.getElementById('noPreview');
        const imageInfo = document.getElementById('imageInfo');

        // Format currency to IDR
        function formatCurrency(amount) {
            return 'Rp ' + amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        // Format number with dots
        function formatNumber(num) {
            return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
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
                stockIndicator.textContent = '✅ Stok tinggi';
                stockIndicator.className = 'stock-indicator stock-high';
            } else if (stock >= 5) {
                stockIndicator.textContent = '⚠️ Stok normal';
                stockIndicator.className = 'stock-indicator stock-medium';
            } else if (stock > 0) {
                stockIndicator.textContent = '⚠️ Stok menipis';
                stockIndicator.className = 'stock-indicator stock-medium';
            } else {
                stockIndicator.textContent = '❌ Stok habis';
                stockIndicator.className = 'stock-indicator stock-low';
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
                
                // Show preview
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    imagePreview.style.display = 'block';
                    noPreview.style.display = 'none';
                    
                    // Update image info
                    const fileSize = (file.size / 1024).toFixed(2);
                    imageInfo.innerHTML = `
                        <p><i class="fas fa-file-image"></i> ${file.name}</p>
                        <p style="font-size: 0.8rem; color: #888;">Size: ${fileSize} KB | Type: ${file.type}</p>
                    `;
                };
                reader.readAsDataURL(file);
            } else {
                imagePreview.style.display = 'none';
                noPreview.style.display = 'flex';
                imageInfo.innerHTML = '<p><i class="fas fa-info-circle"></i> Preview gambar akan muncul di sini</p>';
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
                input.value = formatNumber(value);
            }
        }
        
        hargaJualInput.addEventListener('blur', () => formatPriceInput(hargaJualInput));
        hargaBeliInput.addEventListener('blur', () => formatPriceInput(hargaBeliInput));
        
        // Form validation
        document.getElementById('productForm').addEventListener('submit', function(e) {
            const nama = document.getElementById('nama').value.trim();
            const kategori = document.getElementById('kategori').value;
            
            if (!nama || !kategori) {
                e.preventDefault();
                alert('Harap isi semua field yang wajib diisi!');
                return;
            }
            
            // Show loading
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';
            submitBtn.disabled = true;
            
            // Reset button after 3 seconds if still submitting
            setTimeout(() => {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }, 3000);
        });

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            calculateProfit();
            updateStockIndicator();
            
            // Auto-focus first input
            document.getElementById('nama').focus();
            
            // Make file upload area clickable
            document.querySelector('.file-upload-btn').addEventListener('click', function() {
                fileInput.click();
            });
        });
    </script>
</body>
</html>