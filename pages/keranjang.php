<?php
session_start();

// Simpan total harga yang sudah dicentang
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['checkout'])) {
    $_SESSION['checkout_total'] = $_POST['total_price']; // ambil dari input hidden
    header("Location: order.php");
    exit();
}
?>



<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Saya</title>
    <link rel="stylesheet" href="../assets/css/keranjang.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <button class="back-btn" onclick="goBack()">←</button>
            <span class="header-title">Keranjang Saya (<span id="cartCount">5</span>)</span>
        </div>

        <div class="cart-items" id="cartItems">
            <!-- Items will be populated by JavaScript -->
        </div>

        <div class="footer">
            <div class="select-all" onclick="toggleSelectAll()">
                <div class="select-all-checkbox" id="selectAllCheckbox"></div>
                <span class="select-all-text">Semua</span>
            </div>
            
            <div class="checkout-section">
            <div class="total-price" id="totalPrice">Rp0</div>
            <form method="POST" action="keranjang.php">
                <input type="hidden" name="total_price" id="total_price" value="">
                <button type="submit" name="checkout" class="checkout-btn">Checkout</button>
            </form>
            </div>

        </div>
    </div>

    <script>
        // Sample cart data
        // Ambil data keranjang dari localStorage (kalau kosong, bikin array kosong)
        let cart = JSON.parse(localStorage.getItem("cart")) || [];


        function renderCartItems() {
            const container = document.getElementById('cartItems');
            
            if (cart.length === 0) {
                container.innerHTML = `
                    <div class="empty-state">
                        <div class="empty-icon">🛒</div>
                        <div class="empty-text">Keranjang Anda kosong</div>
                        <div class="empty-subtext">Tambahkan produk ke keranjang untuk melanjutkan</div>
                    </div>
                `;
                return;
            }

            container.innerHTML = cart.map((item, idx) => `
                <div class="cart-item">
                    <div class="item-checkbox ${item.checked ? 'checked' : ''}" onclick="toggleItem(${idx})"></div>
                    <img src="${item.img || item.image || ''}" alt="${item.name}" class="item-image" />
                    <div class="item-info">
                        <div class="item-name">${item.name}</div>
                        <div class="item-variant">${item.variant ? item.variant : ''}</div>
                        <div class="item-price">Rp ${item.price.toLocaleString('id-ID')}</div>
                    </div>
                    <div class="quantity-controls">
                        <button class="quantity-btn" onclick="decreaseQuantity(${item.id})">−</button>
                        <span class="quantity">${item.quantity}</span>
                        <button class="quantity-btn orange" onclick="increaseQuantity(${item.id})">+</button>
                    </div>
                </div>
            `).join('');

        }

        // Toggle checklist for single item
        function toggleItem(idx) {
            cart[idx].checked = !cart[idx].checked;
            localStorage.setItem("cart", JSON.stringify(cart));
            renderCartItems();
            updateFooter();
        }

        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            if (form) {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    proceedToCheckout();
                });
            }
        });


        function toggleSelectAll() {
            const allChecked = cart.length > 0 && cart.every(item => item.checked);
            cart.forEach(item => {
                item.checked = !allChecked;
            });
            localStorage.setItem("cart", JSON.stringify(cart));
            renderCartItems();
            updateFooter();
        }

        function toggleSelectAll() {
            const allChecked = cart.every(item => item.checked);
            cart.forEach(item => {
                item.checked = !allChecked;
            });
            renderCartItems();
            updateFooter();
        }

        function increaseQuantity(id) {
            const item = cart.find(item => item.id === id);
            if (item) {
                item.quantity++;
                localStorage.setItem("cart", JSON.stringify(cart));
                renderCartItems();
                updateFooter();
            }
        }

        function decreaseQuantity(id) {
            const itemIndex = cart.findIndex(item => item.id === id);
            if (itemIndex !== -1) {
                if (cart[itemIndex].quantity > 1) {
                    cart[itemIndex].quantity--;
                } else {
                    // kalau quantity sudah 1, hapus item dari cart
                    cart.splice(itemIndex, 1);
                }
                localStorage.setItem("cart", JSON.stringify(cart));
                renderCartItems();
                updateFooter();
            }
        }


        function updateFooter() {
            const cartCount = cart.length;
            const checkedItems = cart.filter(item => item.checked);
            const totalPrice = checkedItems.reduce((sum, item) => sum + (item.price * item.quantity), 0);
            const allChecked = cart.length > 0 && cart.every(item => item.checked);

            document.getElementById('cartCount').textContent = cartCount;
            document.getElementById('totalPrice').textContent = `Rp${totalPrice.toLocaleString('id-ID')}`;
            // Pastikan tombol checkout ada sebelum akses
            const checkoutBtn = document.getElementById('checkoutBtn') || document.querySelector('.checkout-btn');
            if (checkoutBtn) checkoutBtn.disabled = checkedItems.length === 0;
            document.getElementById('total_price').value = totalPrice;

            const selectAllCheckbox = document.getElementById('selectAllCheckbox');
            if (allChecked) {
                selectAllCheckbox.classList.add('checked');
            } else {
                selectAllCheckbox.classList.remove('checked');
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            if (form) {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    proceedToCheckout();
                });
            }
        });

        function proceedToCheckout() {
            const checkedItems = cart.filter(item => item.checked);
            if (checkedItems.length === 0) {
                alert('Pilih minimal satu item untuk checkout');
                return;
            }

            // Simpan item yang dicentang ke localStorage untuk dibaca di order.php
            localStorage.setItem("checkoutItems", JSON.stringify(checkedItems));
            
            // Redirect ke order.php
            window.location.href = 'order.php';
        }

        function goBack() {
            window.history.back();
        }

        // Initialize
        renderCartItems();
        updateFooter();

        function updateTotal() {
            let total = 0;
            document.querySelectorAll(".cart-item input[type=checkbox]:checked").forEach(item => {
                let price = parseInt(item.dataset.price);
                let qty = parseInt(item.dataset.qty);
                total += price * qty;
            });
            document.getElementById("total_price").value = total;
        }

        document.querySelectorAll(".cart-item input[type=checkbox]").forEach(chk => {
            chk.addEventListener("change", updateTotal);
        });

        updateTotal();
    </script>
</body>
</html>