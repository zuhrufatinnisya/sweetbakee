<?php
session_start();
$location = "Ngaliyan, Semarang";
$title = "SweetBake";

// Data promo
$promos = [
    [
        'id' => 1,
        'kode_promo' => 'MATCHA01',
        'nama_paket' => 'Matcha Special',
        'harga_normal' => 27000,
        'harga_promo' => 23000,
        'image' => 'matcha.png',
        'alt' => 'Paket Matcha Special'
    ],
    [
        'id' => 2,
        'kode_promo' => 'DONAT01',
        'nama_paket' => 'Donat Deluxe',
        'harga_normal' => 27000,
        'harga_promo' => 23000,
        'image' => 'donat.png',
        'alt' => 'Paket Donat Deluxe'
    ],
    [
        'id' => 3,
        'kode_promo' => 'LOTUS01',
        'nama_paket' => 'Lotus Premium',
        'harga_normal' => 27000,
        'harga_promo' => 23000,
        'image' => 'lotus.png',
        'alt' => 'Paket Lotus Premium'
    ],
    [
        'id' => 4,
        'kode_promo' => 'SOFTCAKE01',
        'nama_paket' => 'Tiramisu',
        'harga_normal' => 53000,
        'harga_promo' => 50000,
        'image' => 'sctiramisu.png',
        'alt' => 'Paket Coffee Blend'
    ],
    [
        'id' => 5,
        'kode_promo' => 'MUFFIN01',
        'nama_paket' => 'Chocolate Chips',
        'harga_normal' => 12000,
        'harga_promo' => 11000,
        'image' => 'cchips.png',
        'alt' => 'Paket Cake Spesial'
    ]
];

function formatRupiah($angka) {
    return 'Rp ' . number_format($angka, 0, ',', '.');
}

function generatePromoCard($promo) {
    $discountPercent = round((($promo['harga_normal'] - $promo['harga_promo']) / $promo['harga_normal']) * 100);

    // Path gambar promo dari ../asset/img/
    return '
    <div class="promo-card" data-promo-id="' . $promo['id'] . '">
        <span class="badge">Promo</span>
        <img src="../assets/img/' . htmlspecialchars($promo['image']) . '" alt="' . htmlspecialchars($promo['alt']) . '" loading="lazy">
        <div>
            <h2 class="text-center">' . htmlspecialchars($promo['nama_paket']) . '</h2>
            <div class="price text-center">
                <span class="price-discount">' . formatRupiah($promo['harga_normal']) . '</span>
                <span class="price-final">' . formatRupiah($promo['harga_promo']) . '</span>
            </div>
            <div class="flex justify-center">
                <button onclick="addToCart(\'' . htmlspecialchars($promo['kode_promo']) . '\', \'' . htmlspecialchars($promo['nama_paket']) . '\', ' . $promo['harga_promo'] . ', \'' . htmlspecialchars($promo['image']) . '\')">
                    <i class="bi bi-cart3"></i>
                    <span>Tambah</span>
                </button>
            </div>
        </div>
    </div>';
}

// User session checking
$isLoggedIn = isset($_SESSION['user_id']);
$userData = $isLoggedIn ? [
    'name' => $_SESSION['user_name'] ?? 'John Doe',
    'avatar' => $_SESSION['user_avatar'] ?? 'https://via.placeholder.com/30x30/666/FFF?text=U',
    'id' => $_SESSION['user_id'] ?? null
] : null;

$cartCount = isset($_SESSION['cart_count']) ? $_SESSION['cart_count'] : 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title) ?></title>
    <!-- Path CSS -->
    <link rel="stylesheet" href="../assets/css/stylelp.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar">
        <div class="logo">
            <img src="../assets/img/logo.png" alt="SweetBake Logo" />
        </div>
        <div class="nav-center">
            <a href="landingpage.php">Home</a>
            <a href="menu.php">Menu</a>
            <a href="contact.php">Contact</a>
        </div>
        <div class="nav-right">
            <div class="cart-icon" onclick="goToCart()">
                <i class="bi bi-bag"></i>
                <?php if ($cartCount > 0): ?>
                    <span class="cart-badge" id="cartBadge"><?php echo $cartCount; ?></span>
                <?php endif; ?>
            </div>
            <?php if ($isLoggedIn): ?>
                <div class="profile-dropdown" id="profileDropdown">
                    <div class="profile-btn" onclick="toggleDropdown()">
                        <img src="<?php echo htmlspecialchars($userData['avatar']); ?>" alt="Profile">
                        <span><?php echo htmlspecialchars($userData['name']); ?></span>
                        <i class="bi bi-chevron-down"></i>
                    </div>
                    <div class="dropdown-menu" id="dropdownMenu">
                        <a href="#profile" class="dropdown-item"><i class="bi bi-person"></i> My Profile</a>
                        <a href="#orders" class="dropdown-item"><i class="bi bi-bag-check"></i> My Orders</a>
                        <a href="#settings" class="dropdown-item"><i class="bi bi-gear"></i> Settings</a>
                        <a href="#logout" class="dropdown-item" onclick="logout()"><i class="bi bi-box-arrow-right"></i> Logout</a>
                    </div>
                </div>
            <?php else: ?>
                <div class="auth-buttons" id="authButtons">
                    <a href="login.php" class="login-btn">Login</a>
                    <a href="signup.php" class="signup-btn">Sign Up</a>
                </div>
            <?php endif; ?>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <img src="../assets/img/bglanding.jpg" alt="Bread Background" class="hero-img">

        <div class="top-bar">
            <div class="location">
                <small>Location</small><br>
                <strong><?= htmlspecialchars($location) ?></strong>
            </div>
        </div>

        <div class="search-box">
            <i class="bi bi-search"></i>
            <input type="text" placeholder="Search">
            <button><span><i class="bi bi-list"></i></span></button>
        </div>

        <div class="hero-text">
            <h1>Selamat Datang di SweetBake!</h1>
            <p>Toko roti, kue, dan pastry segar setiap hari di Semarang!</p>
        </div>
    </section>

    <br>
    <br>
    <br>
    <!-- Promo Section -->
    <section class="promo-section" id="promo">
        <div class="container">
            <h1 class="section-heading">Promo Hari Ini</h1>
            <div class="slider">
                <button class="nav-btn prev-btn" id="prevBtn">&lt;</button>
                <div class="promo-slider" id="promoSlider">
                    <?php foreach ($promos as $promo) echo generatePromoCard($promo); ?>
                </div>
                <button class="nav-btn next-btn" id="nextBtn">&gt;</button>
            </div>
        </div>
    </section>

    <footer style="text-align:center; padding:20px 0; background:#FFE3D2;">
        &copy; <?= date('Y') ?> SweetBake. All rights reserved.
    </footer>

    <script>
        // Simple promo slider
        const promoSlider = document.getElementById('promoSlider');
        const nextPromoBtn = document.getElementById('nextBtn');
        const prevPromoBtn = document.getElementById('prevBtn');

        nextPromoBtn && nextPromoBtn.addEventListener('click', () => {
            promoSlider.scrollBy({ left: 300, behavior: 'smooth' });
        });
        prevPromoBtn && prevPromoBtn.addEventListener('click', () => {
            promoSlider.scrollBy({ left: -300, behavior: 'smooth' });
        });

        function addToCart(kodePromo, namaPromo, harga, image = '') {
            alert(`${namaPromo} berhasil ditambahkan ke keranjang!`);
        }

        function toggleDropdown() {
            const dropdownMenu = document.getElementById('dropdownMenu');
            dropdownMenu.classList.toggle('show');
        }
        function goToCart() {
            // Pindah ke halaman cart
        }
        function logout() {
            // Proses logout
        }

        document.addEventListener('click', function(event) {
            const profileDropdown = document.getElementById('profileDropdown');
            const dropdownMenu = document.getElementById('dropdownMenu');
            if (profileDropdown && !profileDropdown.contains(event.target)) {
                dropdownMenu.classList.remove('show');
            }
        });
    </script>
</body>
</html>
