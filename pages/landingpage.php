<?php
session_start();
$location = "Ngaliyan, Semarang";
$title = "SweetBake";

// Data promo
$promos = [
    [
        'id' => 4, // ID sama dengan produk.php (Greentea)
        'kode_promo' => 'MATCHA01',
        'nama_paket' => 'Greentea',
        'harga_normal' => 27000,
        'harga_promo' => 23000,
        'image' => 'mile_matcha.jpg',
        'alt' => 'Mille Crepes Greentea'
    ],
    [
        'id' => 13, // ID sama dengan produk.php (Citrus Blast)
        'kode_promo' => 'DONAT01',
        'nama_paket' => 'Citrus Blast',
        'harga_normal' => 16000,
        'harga_promo' => 12000,
        'image' => 'donat.png',
        'alt' => 'Donut Citrus Blast'
    ],
    [
        'id' => 9, // ID sama dengan produk.php (Lotus Biscoff)
        'kode_promo' => 'LOTUS01',
        'nama_paket' => 'Lotus Biscoff',
        'harga_normal' => 18000,
        'harga_promo' => 13000,
        'image' => 'cookies_biscoff.jpg',
        'alt' => 'Cookies Lotus Biscoff'
    ],
    [
        'id' => 7, // ID sama dengan produk.php (Tres Leches)
        'kode_promo' => 'SOFTCAKE01',
        'nama_paket' => 'Tres Leches',
        'harga_normal' => 55000,
        'harga_promo' => 50000,
        'image' => 'soft_tres.jpg',
        'alt' => 'Soft Cake Tres Leches'
    ],
    [
        'id' => 5, // ID sama dengan produk.php (Regular Brown/Chocolate Chips)
        'kode_promo' => 'MUFFIN01',
        'nama_paket' => 'Regular Brown',
        'harga_normal' => 40000,
        'harga_promo' => 34000,
        'image' => 'roll_coklat.jpg',
        'alt' => 'Roll Cake Coklat'
    ]
];

function formatRupiah($angka) {
    return 'Rp ' . number_format($angka, 0, ',', '.');
}

function generatePromoCard($promo) {
    $discountPercent = round((($promo['harga_normal'] - $promo['harga_promo']) / $promo['harga_normal']) * 100);

    // Path gambar promo dari ../assets/img/
   return '
    <div class="promo-card" data-promo-id="' . $promo['id'] . '" onclick="openProductDetail(' . $promo['id'] . ')">
        <span class="badge">Promo</span>
        <img src="../assets/img/' . htmlspecialchars($promo['image']) . '" alt="' . htmlspecialchars($promo['alt']) . '" loading="lazy">
        <div>
            <h2 class="text-center product-title">' . htmlspecialchars($promo['nama_paket']) . '</h2>
        </div>
        <div class="price text-center">
            <span class="price-discount">' . formatRupiah($promo['harga_normal']) . '</span>
            <span class="price-final">' . formatRupiah($promo['harga_promo']) . '</span>
        </div>
        <div class="flex justify-center">
            <button onclick="event.stopPropagation(); addToCart(\'' . htmlspecialchars($promo['kode_promo']) . '\', \'' . htmlspecialchars($promo['nama_paket']) . '\', ' . $promo['harga_promo'] . ', \'' . htmlspecialchars($promo['image']) . '\')">
                <i class="bi bi-cart3"></i>
                <span>Tambah</span>
            </button>
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
                <div class="auth-buttons" id="authButtons">
                    <a href="login.php" class="login-btn">Login</a>
                    <a href="signup.php" class="signup-btn">Sign Up</a>
                </div>
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
            <input type="text" placeholder="Search" id="searchInput">
        </div>

        <div class="hero-text">
            <h1>Selamat Datang di SweetBake!</h1>
            <p>Toko roti, kue, dan pastry segar setiap hari di Semarang!</p>
        </div>
    </section>


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
        // Live search for promo cards
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const promoSlider = document.getElementById('promoSlider');
            searchInput.addEventListener('input', function() {
                const query = searchInput.value.toLowerCase();
                const cards = promoSlider.querySelectorAll('.promo-card');
                cards.forEach(card => {
                    const title = card.querySelector('.product-title').innerText.toLowerCase();
                    if (title.includes(query)) {
                        card.style.display = '';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        });
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

       function addToCart(kodePromo, namaPromo, harga, image = '', id = null) {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    let existing = cart.find(item => item.kodePromo === kodePromo);
    if (existing) {
        existing.quantity += 1;
    } else {
        cart.push({
            id: id || Date.now(),
            kodePromo,
            name: namaPromo,
            price: harga,
            img: image,
            quantity: 1
        });
    }
    localStorage.setItem('cart', JSON.stringify(cart));
    alert(`${namaPromo} berhasil ditambahkan ke keranjang!`);
}

        function toggleDropdown() {
            const dropdownMenu = document.getElementById('dropdownMenu');
            dropdownMenu.classList.toggle('show');
        }
        function goToCart() {
            window.location.href = 'keranjang.php';
        }
        function logout() {
            // Proses logout
        }
        function openProductDetail(id) {
        window.location.href = "produk.php?id=" + id;
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