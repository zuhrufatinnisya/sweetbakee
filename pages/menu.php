<?php
// Contoh data dari backend (nanti diganti query MySQL)
$menus = [
  "Mille Crepes" => [
    ["name" => "Oreo", "price" => 27000, "img" => "../assets/img/mile_oreo.jpg"],
    ["name" => "Chocolate", "price" => 24000, "img" => "../assets/img/milecrepes_caramel.jpg"],
    ["name" => "Mango", "price" => 27000, "img" => "../assets/img/mile_mango.jpg"],
    ["name" => "Greentea", "price" => 23000, "old_price" => 27000, "img" => "../assets/img/mile_matcha.jpg"],
  ],
  "Roll Cake" => [
    ["name" => "Regular Brown", "price" => 40000, "img" => "../assets/img/roll_coklat.jpg"],
    ["name" => "Strawberry", "price" => 55000, "img" => "../assets/img/roll_strawberry.jpg"],
  ],
  "Soft Cake" => [
    ["name" => "Tres Leches", "price" => 55000, "img" => "../assets/img/soft_tres.jpg"],
    ["name" => "Castella", "price" => 34000, "img" => "../assets/img/soft_castella.jpg"],
  ],
  "Cookies" => [
    ["name" => "Lotus Biscoff", "price" => 13000, "old_price" => 18000, "img" => "../assets/img/cookies_biscoff.jpg"],
    ["name" => "Red Velvet", "price" => 17000, "img" => "../assets/img/cookies_red.jpg"],
  ],
  "Cupcake and Muffin" => [
    ["name" => "Banana Cream Cheese", "price" => 14000, "img" => "../assets/img/cup_banana.jpg"],
    ["name" => "Mint Chocolate", "price" => 12000, "img" => "../assets/img/cup_mint.jpg"],
  ],
  "Donut and Pastry" => [
    ["name" => "Citrus Blast", "price" => 12000, "old_price" => 16000, "img" => "../assets/img/donat.png"],
    ["name" => "Walnut Baklava", "price" => 45000, "img" => "../assets/img/pastry_baklava.jpg"],
  ]
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>SweetBake Menu</title>
  <link rel="stylesheet" href="../assets/css/menu.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body>
  <!-- Hamburger Menu -->
    <div class="overlay" id="overlay" onclick="closeMenu()"></div>

    <div class="navbar">
        <div class="hamburger" onclick="toggleMenu()">☰ Menu</div>
        <div class="logo">
          <img src="../assets/img/logo.png" alt="SweetBake Logo" />
        </div>
        <ul id="menuList" class="sidemenu hidden">
            <!-- Header dengan logo -->
            <div class="sidemenu-header">
                <div class="sidemenu-logo">
                    <div class="logo">
                        <img src="../assets/img/logo.png" alt="SweetBake Logo" />
                    </div>
                </div>
                <div class="sidemenu-title">Menu Kategori</div>
            </div>
            
            <!-- Container untuk list menu dengan background -->
            <div class="menu-list-container">
                <?php foreach($menus as $category => $items): ?>
                    <li onclick="filterMenu('<?php echo $category; ?>')">
                        <?php 
                        echo $icons[$category] ?? '🍴';
                        ?> <?php echo $category; ?>
                    </li>
                <?php endforeach; ?>
            </div>
        </ul>
    </div>



  <!-- Menu Items -->
  <div id="menuContainer">
    <?php foreach($menus as $category => $items): ?>
      <div class="menu-category" data-category="<?php echo $category; ?>">
        <h2><?php echo $category; ?></h2>
        <div class="grid">
          <?php 
          // Hitung index global produk untuk id detail
          static $globalIdx = 1;
          foreach($items as $item): 
          ?>
            <div class="card" onclick="window.location.href='produk.php?id=<?= $globalIdx ?>'" style="cursor:pointer;box-shadow:0 2px 8px #e3c6a2;transition:box-shadow .2s,transform .2s;">
              <img src="<?php echo $item['img']; ?>" alt="" style="width:100%;height:170px;object-fit:cover;border-radius:12px 12px 0 0;">
              <div class="card-info">
                <h3 class="card-title"><?php echo $item['name']; ?></h3>
                <p class="price">Rp <?php echo number_format($item['price'],0,",","."); ?></p>
                <button class="add-cart" onclick="event.stopPropagation();"><i class='bi bi-cart'></i>Tambah</button>
              </div>
            </div>
          <?php $globalIdx++; endforeach; ?>
        </div>
      </div>
    <?php endforeach; ?>
  </div>

  
  <!-- Cart & Checkout -->
  <div class="bottom-buttons">
    <!-- Tombol Back di sebelah KIRI -->
    <a href="landingpage.php" class="btn"><i class="bi bi-arrow-left"></i> Back</a>
    
    <!-- Tombol Keranjang dan Checkout di sebelah KANAN -->
    <div class="cart-checkout-group">
      <a href="keranjang.php" class="btn"><i class="bi bi-bag"></i> Keranjang</a>
      <a href="order.php" class="btn"><i class="bi bi-bag-check"></i> Checkout</a>
    </div>
  </div>

<script>
// Slide Menu
function toggleMenu() {
    const menu = document.getElementById("menuList");
    const overlay = document.getElementById("overlay");
    
    menu.classList.toggle("active");
    overlay.classList.toggle("active");
}

/**
 * Close menu
 */
function closeMenu() {
    const menu = document.getElementById("menuList");
    const overlay = document.getElementById("overlay");
    
    menu.classList.remove("active");
    overlay.classList.remove("active");
}

/**
 * Filter menu berdasarkan kategori
 * @param {string} category - Kategori menu yang dipilih
 */
function filterMenu(category) {
    console.log('Filter kategori:', category);
    
    // Ambil data menu berdasarkan kategori
    const items = menuData[category] || [];
    
    // Tampilkan hasil filter
    displayFilteredItems(category, items);
    
    // Close menu setelah selection
    closeMenu();
}

/**
 * Menampilkan hasil filter menu
 * @param {string} category - Kategori yang dipilih
 * @param {Array} items - Array item menu
 */
function displayFilteredItems(category, items) {
    const resultDiv = document.getElementById('menuResult');
    const filteredItemsDiv = document.getElementById('filteredItems');
    
    if (items.length > 0) {
        let itemsHTML = `<h3 style="color: #8b4513; margin-bottom: 15px;">${category}</h3>`;
        itemsHTML += '<ul style="text-align: left; max-width: 400px; margin: 0 auto;">';
        
        items.forEach(item => {
            itemsHTML += `<li style="padding: 8px 0; border-bottom: 1px solid rgba(255,255,255,0.2); color: white;">${item}</li>`;
        });
        
        itemsHTML += '</ul>';
        filteredItemsDiv.innerHTML = itemsHTML;
        resultDiv.style.display = 'block';
        
        // Smooth scroll ke hasil
        resultDiv.scrollIntoView({ behavior: 'smooth' });
    } else {
        filteredItemsDiv.innerHTML = `<p style="color: white;">Tidak ada item di kategori ${category}</p>`;
        resultDiv.style.display = 'block';
    }
}

/**
 * Close menu ketika klik di luar menu
 */
document.addEventListener('click', function(event) {
    const menu = document.getElementById("menuList");
    const hamburger = document.querySelector(".hamburger");
    
    if (!menu.contains(event.target) && !hamburger.contains(event.target)) {
        closeMenu();
    }
});

/**
 * Handle keyboard navigation (ESC untuk close menu)
 */
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeMenu();
    }
});

/**
 * Prevent scroll saat menu terbuka (opsional)
 */
function preventBodyScroll() {
    const menu = document.getElementById("menuList");
    const body = document.body;
    
    if (menu.classList.contains('active')) {
        body.style.overflow = 'hidden';
    } else {
        body.style.overflow = 'auto';
    }
}

// Initialize
document.addEventListener('DOMContentLoaded', function() {
    console.log('Menu Filter System loaded successfully!');
    
    // Anda bisa menambahkan inisialisasi lain di sini
    // Misalnya: load data dari server, set default values, dll
});

function filterMenu(category){
  let categories = document.querySelectorAll(".menu-category");
  categories.forEach(cat => {
    if(cat.dataset.category === category){
      cat.style.display = "block";
    } else {
      cat.style.display = "none";
    }
  });
}

// CHANGE: Script untuk menambahkan item ke keranjang (localStorage)

// Script untuk menambahkan item ke keranjang (localStorage) - HANYA SEKALI
document.querySelectorAll(".add-cart").forEach((button) => {
  button.addEventListener("click", () => {
    const card = button.closest(".card");
    const item = {
      name: card.querySelector("h3").innerText,
      price: parseInt(card.querySelector(".price").innerText.replace(/[^\d]/g, "")),
      img: card.querySelector("img").src,
      quantity: 1
    };

    // Ambil keranjang lama
    let cart = JSON.parse(localStorage.getItem("cart")) || [];

    // Cek kalau item sudah ada → tambah quantity
    let existing = cart.find(c => c.name === item.name);
    if (existing) {
      existing.quantity += 1;
    } else {
      cart.push(item);
    }

    // Simpan ke localStorage
    localStorage.setItem("cart", JSON.stringify(cart));
    alert(item.name + " ditambahkan ke keranjang!");
  });
});


</script>
</body>
</html>
