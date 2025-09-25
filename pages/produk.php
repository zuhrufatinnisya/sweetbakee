<?php
session_start();


// Data produk flat dari menu.php (urutan global, nama, harga, gambar sama persis)
$products = [
  1 => ["name" => "Oreo", "price" => 27000, "img" => "mile_oreo.jpg", "desc" => "Mille Crepes Oreo dengan krim oreo lembut."],
  2 => ["name" => "Chocolate", "price" => 24000, "img" => "milecrepes_caramel.jpg", "desc" => "Mille Crepes Chocolate dengan coklat premium.", "old_price" => 27000],
  3 => ["name" => "Mango", "price" => 27000, "img" => "mile_mango.jpg", "desc" => "Mille Crepes Mango dengan mangga segar."],
  4 => ["name" => "Greentea", "price" => 23000, "img" => "mile_matcha.jpg", "desc" => "Mille Crepes Greentea dengan matcha premium.", "old_price" => 27000],
  5 => ["name" => "Regular Brown", "price" => 40000, "img" => "roll_coklat.jpg", "desc" => "Roll Cake coklat klasik lembut."],
  6 => ["name" => "Strawberry", "price" => 55000, "img" => "roll_strawberry.jpg", "desc" => "Roll Cake Strawberry dengan krim stroberi."],
  7 => ["name" => "Tres Leches", "price" => 55000, "img" => "soft_tres.jpg", "desc" => "Soft Cake Tres Leches lembut dan creamy."],
  8 => ["name" => "Castella", "price" => 34000, "img" => "soft_castella.jpg", "desc" => "Soft Cake Castella ringan dan lembut."],
  9 => ["name" => "Lotus Biscoff", "price" => 13000, "img" => "cookies_biscoff.jpg", "desc" => "Cookies Lotus Biscoff renyah dan manis.", "old_price" => 18000],
 10 => ["name" => "Red Velvet", "price" => 17000, "img" => "cookies_red.jpg", "desc" => "Cookies Red Velvet dengan aroma khas."],
 11 => ["name" => "Banana Cream Cheese", "price" => 14000, "img" => "cup_banana.jpg", "desc" => "Cupcake Banana Cream Cheese lembut."],
 12 => ["name" => "Mint Chocolate", "price" => 12000, "img" => "cup_mint.jpg", "desc" => "Cupcake Mint Chocolate segar dan lembut."],
 13 => ["name" => "Citrus Blast", "price" => 12000, "img" => "donat.png", "desc" => "Donut Citrus Blast dengan topping istimewa.", "old_price" => 16000],
 14 => ["name" => "Walnut Baklava", "price" => 45000, "img" => "pastry_baklava.jpg", "desc" => "Pastry Walnut Baklava dengan isi walnut premium."],
];


// Ambil ID dari URL

$id = $_GET['id'] ?? 0;
if (!isset($products[$id])) {
  echo "Produk tidak ditemukan!";
  exit;
}
$product = $products[$id];

function formatRupiah($angka) {
    return 'Rp ' . number_format($angka, 0, ',', '.');
}
?>

];

// Ambil ID dari URL
$id = $_GET['id'] ?? 0;

if (!isset($products[$id])) {
    echo "Produk tidak ditemukan!";
    exit;
}

$product = $products[$id];

function formatRupiah($angka) {
    return 'Rp ' . number_format($angka, 0, ',', '.');
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($product['nama_paket']) ?> - SweetBake</title>
  <link rel="stylesheet" href="../assets/css/stylelp.css">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: #fff8f5;
      margin: 0;
      padding: 0;
    }
    
    .navbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px 40px;
    background: linear-gradient(135deg, #FFE3D2 0%, #B27441 100%);
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    z-index: 1000;
    height: 85px;
}
  .logo img {
    width: 170px;
    height: auto;
    margin-right: 10px;
    filter: drop-shadow(0 2px 4px rgba(0,0,0,0.3));
}
  .nav-center {
    display: flex;
    gap: 30px;
    align-items: center;
}
  .nav-center a {
    text-decoration: none;
    color: #fff;
    font-size: 18px;
    font-weight: 600;
    text-shadow: 0 1px 3px rgba(0,0,0,0.5);
    transition: all 0.3s ease;
    position: relative;
}
  .nav-center a:hover {
    color: #FFE3D2;
    transform: translateY(-2px);
}
  .nav-center a::after {
    content: '';
    position: absolute;
    bottom: -5px;
    left: 0;
    width: 0;
    height: 2px;
    background: #FFE3D2;
    transition: width 0.3s ease;
}
  .nav-center a:hover::after,
  .nav-center a.active::after {
    width: 100%;
}
  .nav-right {
    display: flex;
    align-items: center;
    gap: 20px;
}
  .cart-icon {
    position: relative;
    cursor: pointer;
    padding: 8px;
    border-radius: 50%;
    transition: all 0.3s ease;
    color: #fff;
}
  .cart-icon:hover {
    background: rgba(255, 227, 210, 0.2);
    transform: scale(1.1);
}
  .cart-icon i {
    font-size: 24px;
}
  .cart-badge {
    position: absolute;
    top: -5px;
    right: -5px;
    background: #ff4757;
    color: white;
    border-radius: 50%;
    width: 20px;
    height: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    font-weight: bold;
    animation: pulse 2s infinite;
}

    .product-container {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      padding: 40px 60px;
      gap: 40px;
    }

    .product-info {
      max-width: 50%;
    }

    .product-info h1 {
      font-size: 32px;
      color: #8c4b23;
      margin-bottom: 15px;
    }

    .product-info p {
      font-size: 15px;
      color: #444;
      margin-bottom: 20px;
      line-height: 1.6;
    }

    .order-section {
      display: flex;
      align-items: center;
      gap: 15px;
    }

    .btn-order {
      background: #a0522d;
      color: white;
      padding: 10px 20px;
      border-radius: 20px;
      text-decoration: none;
      font-weight: 600;
    }

    .btn-order:hover {
      background: #7a3d21;
    }

    .product-price {
      font-size: 18px;
      font-weight: bold;
      color: #333;
    }

    .product-image img {
      width: 350px;
      border-radius: 10px;
      border: 1px solid #e0cfc2;
    }

    .nav-arrow {
      display: flex;
      justify-content: center;
      margin-top: 20px;
      gap: 10px;
    }
    .nav-arrow button {
      background: #f0f0f0;
      border: none;
      padding: 12px;
      border-radius: 50%;
      cursor: pointer;
    }
    .nav-arrow button:hover {
      background: #ddd;
    }
  </style>
</head>
<body>



  <?php
  // Cart count dummy, bisa diganti dengan session jika ada
  $cartCount = isset($_SESSION['cart_count']) ? $_SESSION['cart_count'] : 0;
  ?>

<nav class="navbar">
    <div class="logo">
        <img src="../assets/img/logo.png" alt="SweetBake Logo" />
    </div>
    <div class="nav-center">
        <a href="landingpage.php">Home</a>
        <a href="menu.php">Menu</a>
        <a href="kontak.php">Contact</a>
    </div>
    <div class="nav-right">
        <div class="cart-icon" onclick="goToCart()">
            <i class="bi bi-bag"></i>
            <?php if ($cartCount > 0): ?>
                <span class="cart-badge" id="cartBadge"><?php echo $cartCount; ?></span>
            <?php endif; ?>
        </div>
    </div>
</nav>

  <script>
    function goToCart() {
      window.location.href = "cart.php";
    }
    // Highlight menu aktif
    document.querySelectorAll('.nav-center a').forEach(function(link) {
      if (link.href === window.location.href) {
        link.classList.add('active');
      }
    });
  </script>



  <div class="product-container" style="display:flex;flex-wrap:wrap;align-items:flex-end;justify-content:space-between;gap:60px;padding-top:120px;">
    <div style="flex:1 1 500px;max-width:600px;padding-left:30px;">
      <h1 style="color:#8B5A2B;font-size:3.2em;font-weight:800;margin-bottom:28px;"><?= htmlspecialchars($product['name']) ?></h1>
      <p style="color:#6d4520;font-size:1.45em;line-height:1.7;margin-bottom:32px;max-width:520px;">
        <?= htmlspecialchars($product['desc']) ?>
      </p>
      <div style="display:flex;align-items:center;gap:22px;">
        <button class="btn-order" id="orderNowBtn" style="background:#B27441;color:#fff;padding:14px 32px;border-radius:10px;font-weight:700;font-size:1.08em;">ORDER NOW</button>
        <?php if(isset($product['old_price'])): ?>
          <span class="product-price" style="color:#b0a7a7;font-size:1.1em;font-weight:600;text-decoration:line-through;margin-right:10px;">Rp <?= number_format($product['old_price'],0,',','.') ?></span>
        <?php endif; ?>
        <span class="product-price" style="color:#8B5A2B;font-size:1.3em;font-weight:800;">Rp <?= number_format($product['price'],0,',','.') ?></span>
      </div>
    </div>
    <div style="flex:1 1 600px;max-width:700px;text-align:right;display:flex;justify-content:flex-end;align-items:flex-end;">
  <img src="../assets/img/<?= htmlspecialchars($product['img']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" style="width:90%;max-width:540px;border-radius:22px;box-shadow:0 2px 18px #f3d1b3;margin-top:60px;object-fit:cover;">
</div>
<script>
// ORDER NOW button: add to cart (localStorage) and redirect
document.addEventListener('DOMContentLoaded', function() {
  var orderBtn = document.getElementById('orderNowBtn');
  if(orderBtn) {
    orderBtn.addEventListener('click', function() {
      var item = {
        name: <?= json_encode($product['name']) ?>,
        price: <?= json_encode($product['price']) ?>,
        img: '../assets/img/<?= htmlspecialchars($product['img']) ?>',
        quantity: 1
      };
      let cart = JSON.parse(localStorage.getItem('cart')) || [];
      let existing = cart.find(c => c.name === item.name);
      if (existing) {
        existing.quantity += 1;
      } else {
        cart.push(item);
      }
      localStorage.setItem('cart', JSON.stringify(cart));
      alert(item.name + ' ditambahkan ke keranjang!');
            window.location.href = 'keranjang.php';
          });
        }
      });
      </script>
      </body>
      </html>