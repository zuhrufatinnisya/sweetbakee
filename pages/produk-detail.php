<?php
session_start();
require_once("../config/database.php");

$title = "Detail Produk - SweetBake";
$location = "Ngaliyan, Semarang";

// Ambil ID produk dari URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Jika tidak ada ID, redirect ke halaman produk
if ($id <= 0) {
    header('Location: produk.php');
    exit;
}

// Data produk (dalam implementasi sebenarnya, ambil dari database)
$produk = [
    1 => [
        'id' => 1,
        'nama' => 'Caramel Mille Crepe',
        'deskripsi' => 'Made from a mixture of eggs, milk, flour, butter, which is stacked with custard and topped with sweet caramel sauce. The taste is soft, creamy, and sweet.',
        'harga' => 27000,
        'gambar' => 'caramel_mille_crepe.jpg',
        'kategori' => 'Mille Crepes'
    ],
    2 => [
        'id' => 2,
        'nama' => 'Chocolate Mille Crepe',
        'deskripsi' => 'Layers of thin chocolate crepes with rich chocolate cream in between. Perfect for chocolate lovers.',
        'harga' => 29000,
        'gambar' => 'chocolate_mille_crepe.jpg',
        'kategori' => 'Mille Crepes'
    ],
    3 => [
        'id' => 3,
        'nama' => 'Matcha Mille Crepe',
        'deskripsi' => 'Japanese-inspired dessert with layers of matcha-flavored crepes and light cream. A perfect balance of sweet and bitter.',
        'harga' => 30000,
        'gambar' => 'matcha_mille_crepe.jpg',
        'kategori' => 'Mille Crepes'
    ]
];

// Cek apakah produk dengan ID tersebut ada
if (!isset($produk[$id])) {
    header('Location: produk.php');
    exit;
}

$current_product = $produk[$id];

// Produk sebelumnya dan selanjutnya untuk navigasi
$prev_id = ($id > 1) ? $id - 1 : count($produk);
$next_id = ($id < count($produk)) ? $id + 1 : 1;

// Format harga ke format Rupiah
function formatRupiah($angka) {
    return 'Rp ' . number_format($angka, 0, ',', '.');
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        .product-detail-container {
            padding: 20px 0;
            background-color: var(--light-color);
            min-height: calc(100vh - 76px);
        }
        
        .product-card {
            background-color: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .product-image-container {
            position: relative;
            overflow: hidden;
            border-radius: 15px;
        }
        
        .product-image {
            width: 100%;
            height: auto;
            display: block;
        }
        
        .product-info {
            padding: 20px;
        }
        
        .product-category {
            color: var(--secondary-color);
            font-weight: 500;
            margin-bottom: 10px;
            display: block;
        }
        
        .product-title {
            color: var(--primary-color);
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 15px;
        }
        
        .product-description {
            color: var(--text-color);
            margin-bottom: 20px;
            line-height: 1.6;
        }
        
        .product-price {
            color: var(--primary-color);
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 20px;
        }
        
        .action-buttons {
            display: flex;
            gap: 10px;
        }
        
        .btn-order {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-weight: 600;
            flex-grow: 1;
        }
        
        .btn-order:hover {
            background-color: #6d4520;
        }
        
        .btn-wishlist {
            background-color: white;
            color: var(--text-color);
            border: 1px solid #ddd;
            width: 46px;
            height: 46px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .btn-wishlist:hover {
            background-color: #f8f9fa;
        }
        
        .back-button {
            color: var(--text-color);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 5px;
            margin-bottom: 20px;
        }
        
        .back-button:hover {
            color: var(--primary-color);
        }
        
        .navigation-buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
        }
        
        .nav-button {
            width: 40px;
            height: 40px;
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-color);
            text-decoration: none;
        }
        
        .nav-button:hover {
            background-color: #f8f9fa;
            color: var(--primary-color);
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="landingpage.php">SweetBake</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="landingpage.php">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="produk.php">Produk</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="tentang.php">Tentang Kami</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="kontak.php">Kontak</a>
                    </li>
                </ul>
                <div class="d-flex">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <a href="dashboard.php" class="btn btn-outline-primary me-2">Dashboard</a>
                        <a href="logout.php" class="btn btn-primary">Logout</a>
                    <?php else: ?>
                        <a href="login.php" class="btn btn-outline-primary me-2">Masuk</a>
                        <a href="signup.php" class="btn btn-primary">Daftar</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <!-- Product Detail -->
    <div class="product-detail-container">
        <div class="container">
            <a href="produk.php" class="back-button">
                <i class="bi bi-arrow-left"></i> <?= htmlspecialchars($current_product['kategori']) ?>
            </a>
            
            <div class="product-card">
                <div class="row g-0">
                    <div class="col-md-6">
                        <div class="product-image-container">
                            <img src="../assets/img/<?= htmlspecialchars($current_product['gambar']) ?>" alt="<?= htmlspecialchars($current_product['nama']) ?>" class="product-image">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="product-info">
                            <span class="product-category"><?= htmlspecialchars($current_product['kategori']) ?></span>
                            <h1 class="product-title"><?= htmlspecialchars($current_product['nama']) ?></h1>
                            <p class="product-description"><?= htmlspecialchars($current_product['deskripsi']) ?></p>
                            <div class="product-price"><?= formatRupiah($current_product['harga']) ?></div>
                            <div class="action-buttons">
                                <button class="btn-order">ORDER NOW</button>
                                <button class="btn-wishlist">
                                    <i class="bi bi-heart"></i>
                                </button>
                            </div>
                            
                            <div class="navigation-buttons">
                                <a href="produk-detail.php?id=<?= $prev_id ?>" class="nav-button">
                                    <i class="bi bi-chevron-left"></i>
                                </a>
                                <a href="produk-detail.php?id=<?= $next_id ?>" class="nav-button">
                                    <i class="bi bi-chevron-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <h5>SweetBake</h5>
                    <p>Toko kue dan bakery premium dengan berbagai pilihan kue dan roti berkualitas.</p>
                </div>
                <div class="col-md-4 mb-3">
                    <h5>Kontak</h5>
                    <p>
                        <i class="bi bi-geo-alt"></i> <?= htmlspecialchars($location) ?><br>
                        <i class="bi bi-telephone"></i> +62 123 4567 890<br>
                        <i class="bi bi-envelope"></i> info@sweetbake.com
                    </p>
                </div>
                <div class="col-md-4 mb-3">
                    <h5>Ikuti Kami</h5>
                    <div class="d-flex gap-3">
                        <a href="#" class="text-decoration-none">
                            <i class="bi bi-facebook fs-5"></i>
                        </a>
                        <a href="#" class="text-decoration-none">
                            <i class="bi bi-instagram fs-5"></i>
                        </a>
                        <a href="#" class="text-decoration-none">
                            <i class="bi bi-twitter fs-5"></i>
                        </a>
                    </div>
                </div>
            </div>
            <hr>
            <div class="text-center">
                <small>&copy; <?= date('Y') ?> SweetBake. All rights reserved.</small>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>