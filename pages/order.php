<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order - Keranjang Belanja</title>
    <link rel="stylesheet" href="../assets/css/order.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <button class="back-btn" onclick="history.back()">‹</button>
            <h1>Order</h1>
        </div>

        <div class="delivery-tabs">
            <div class="tab active" onclick="switchTab(this, 'deliver')">Deliver</div>
            <div class="tab" onclick="switchTab(this, 'pickup')">Pick up</div>
        </div>

        <div class="address-section">
            <div class="address-header">
                <span class="address-title">Delivery Address</span>
            </div>
            <div class="address-name" id="addressName">Kos Putri</div>
            <div class="address-text" id="addressText">Jl. Nusa Indah I No. 15, Tambak Aji, Ngaliyan</div>
            <div class="address-actions">
                <span class="address-action" onclick="openEditAddress()">Edit Address</span>
                <span class="address-action" onclick="openAddNotes()">Add Notes</span>
            </div>
            <div class="address-notes" id="addressNotes" style="margin-top: 10px; color: #666; font-size: 12px; font-style: italic; display: none;"></div>
        </div>

        <!-- <div class="product-item">
            <div class="product-image">MC</div>
            <div class="product-info">
                <div class="product-name">Mille Crepe</div>
                <div class="product-desc">with Caramel</div>
            </div>
            <div class="quantity-controls">
                <button class="quantity-btn" onclick="decreaseQuantity()">−</button>
                <span class="quantity" id="quantity">1</span>
                <button class="quantity-btn" onclick="increaseQuantity()">+</button>
            </div>
        </div> -->

        <div id="productList"></div>


        <div class="discount-badge">
            <div class="discount-icon">%</div>
            <span>1 Discount is applied</span>
        </div>

        <div class="payment-summary">
            <div class="summary-title">Payment Summary</div>
            
            <div class="summary-row">
                <span class="summary-label">Price</span>
                <span class="summary-value" id="priceTotal">Rp 0</span>
            </div>
            
            <div class="summary-row">
                <span class="summary-label">Delivery Fee</span>
                <div>
                    <span class="summary-value crossed">Rp 15.000</span>
                    <span class="summary-value" id="deliveryFee">Rp 10.000</span>
                </div>
            </div>
            
            <div class="summary-row total-row">
                <span class="total-label">Total Payment</span>
                <span class="total-value" id="totalPayment">Rp 0</span>
            </div>
        </div>

        <div class="payment-methods">
            <div class="payment-title">Metode Pembayaran</div>
            
            <div class="payment-method active" onclick="selectPayment(this, 'cash')">
                <div class="payment-icon">💳</div>
                <span>Cash</span>
                <span style="margin-left: auto; font-weight: 600; margin-right: 10px;" id="cashAmount">Rp 0</span>
                <div class="payment-radio"></div>
            </div>

            <div class="payment-method" onclick="selectPayment(this, 'qris')">
                <div class="payment-icon qris">QR</div>
                <span>QRIS</span>
                <span style="margin-left: auto; font-weight: 600; margin-right: 10px;" id="qrisAmount">Rp 0</span>
                <div class="payment-radio"></div>
            </div>
        </div>

        
        <button class="order-btn" onclick="placeOrder()">Order</button>
    </div>

    <!-- Modal Edit Address -->
    <div class="modal" id="editAddressModal">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title">Edit Address</span>
                <button class="close-btn" onclick="closeModal('editAddressModal')">&times;</button>
            </div>
            <form id="addressForm">
                <div class="form-group">
                    <label class="form-label">Nama Tempat</label>
                    <input type="text" class="form-input" id="editAddressName" placeholder="Contoh: Rumah, Kantor, Kos">
                </div>
                <div class="form-group">
                    <label class="form-label">Alamat Lengkap</label>
                    <textarea class="form-input form-textarea" id="editAddressText" placeholder="Masukkan alamat lengkap..."></textarea>
                </div>
                <div class="modal-buttons">
                    <button type="button" class="btn-cancel" onclick="closeModal('editAddressModal')">Batal</button>
                    <button type="button" class="btn-save" onclick="saveAddress()">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Add Notes -->
    <div class="modal" id="addNotesModal">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title">Add Notes</span>
                <button class="close-btn" onclick="closeModal('addNotesModal')">&times;</button>
            </div>
            <form id="notesForm">
                <div class="form-group">
                    <label class="form-label">Catatan Pengiriman</label>
                    <textarea class="form-input form-textarea" id="deliveryNotes" placeholder="Contoh: Rumah cat hijau, dekat warung bu siti, hubungi sebelum sampai..."></textarea>
                </div>
                <div class="modal-buttons">
                    <button type="button" class="btn-cancel" onclick="closeModal('addNotesModal')">Batal</button>
                    <button type="button" class="btn-save" onclick="saveNotes()">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Ambil item yang dipilih untuk checkout dari localStorage
        let checkedItems = JSON.parse(localStorage.getItem("checkoutItems")) || [];

        const baseDeliveryFee = 10000;
        let selectedPayment = 'cash';
        let deliveryNotesText = '';

        function openEditAddress() {
            const modal = document.getElementById('editAddressModal');
            const nameInput = document.getElementById('editAddressName');
            const textInput = document.getElementById('editAddressText');
            
            // Fill with current values
            nameInput.value = document.getElementById('addressName').textContent;
            textInput.value = document.getElementById('addressText').textContent;
            
            modal.classList.add('show');
            nameInput.focus();
        }

        function openAddNotes() {
            const modal = document.getElementById('addNotesModal');
            const notesInput = document.getElementById('deliveryNotes');
            
            // Fill with current notes if any
            notesInput.value = deliveryNotesText;
            
            modal.classList.add('show');
            notesInput.focus();
        }

        function closeModal(modalId) {
            const modal = document.getElementById(modalId);
            modal.classList.remove('show');
        }

        function saveAddress() {
            const nameInput = document.getElementById('editAddressName');
            const textInput = document.getElementById('editAddressText');
            
            if (nameInput.value.trim() && textInput.value.trim()) {
                document.getElementById('addressName').textContent = nameInput.value.trim();
                document.getElementById('addressText').textContent = textInput.value.trim();
                closeModal('editAddressModal');
                
                // Show success feedback
                showToast('Alamat berhasil diperbarui!');
            } else {
                alert('Mohon isi semua field yang diperlukan.');
            }
        }

        function saveNotes() {
            const notesInput = document.getElementById('deliveryNotes');
            const notesDisplay = document.getElementById('addressNotes');
            
            deliveryNotesText = notesInput.value.trim();
            
            if (deliveryNotesText) {
                notesDisplay.textContent = 'Catatan: ' + deliveryNotesText;
                notesDisplay.style.display = 'block';
                showToast('Catatan berhasil ditambahkan!');
            } else {
                notesDisplay.style.display = 'none';
            }
            
            closeModal('addNotesModal');
        }

        function showToast(message) {
            // Create toast notification
            const toast = document.createElement('div');
            toast.style.cssText = `
                position: fixed;
                top: 20px;
                left: 50%;
                transform: translateX(-50%);
                background: #27ae60;
                color: white;
                padding: 10px 20px;
                border-radius: 20px;
                font-size: 14px;
                z-index: 2000;
                animation: slideDown 0.3s ease;
            `;
            toast.textContent = message;
            
            document.body.appendChild(toast);
            
            // Remove toast after 3 seconds
            setTimeout(() => {
                toast.style.animation = 'slideUp 0.3s ease';
                setTimeout(() => {
                    document.body.removeChild(toast);
                }, 300);
            }, 3000);
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            const modals = document.querySelectorAll('.modal');
            modals.forEach(modal => {
                if (event.target === modal) {
                    modal.classList.remove('show');
                }
            });
        }

        function selectPayment(element, paymentType) {
            // Remove active class from all payment methods
            document.querySelectorAll('.payment-method').forEach(method => {
                method.classList.remove('active');
            });
            
            // Add active class to selected payment
            element.classList.add('active');
            selectedPayment = paymentType;
        }

        function switchTab(element, type) {
            // Remove active class from all tabs
            document.querySelectorAll('.tab').forEach(tab => {
                tab.classList.remove('active');
            });
            
            // Add active class to clicked tab
            element.classList.add('active');
            
            // Update delivery fee based on tab
            if (type === 'pickup') {
                document.getElementById('deliveryFee').textContent = 'Rp 0';
            } else {
                document.getElementById('deliveryFee').textContent = formatCurrency(baseDeliveryFee);
            }
            updateTotal(); // TAMBAH LINE INI
        }

        // function increaseQuantity() {
        //     currentQuantity++;
        //     updateQuantityDisplay();
        //     updatePrices();
        // }

        // function decreaseQuantity() {
        //     if (currentQuantity > 1) {
        //         currentQuantity--;
        //         updateQuantityDisplay();
        //         updatePrices();
        //     }
        // }

        // function updateQuantityDisplay() {
        //     document.getElementById('quantity').textContent = currentQuantity;
        // }

        // function updatePrices() {
        //     const totalPrice = basePrice * currentQuantity;
        //     document.getElementById('price').textContent = formatCurrency(totalPrice);
        //     updateTotal();
        // }

        // function updateTotal() {
        //     const price = basePrice * currentQuantity;
        //     const delivery = document.querySelector('.tab.active').textContent === 'Pick up' ? 0 : deliveryFee;
        //     const total = price + delivery;
            
        //     document.getElementById('totalPayment').textContent = formatCurrency(total);
        //     document.getElementById('cashAmount').textContent = formatCurrency(total);
        //     document.getElementById('qrisAmount').textContent = formatCurrency(total);
        // }

        // ganti versi lama dengan ini
        function increaseQuantity(id) {
            const item = checkedItems.find(i => i.id === id);
            if (item) {
                item.quantity++;
                renderOrderItems();
                updateTotal();
            }
        }

        function decreaseQuantity(id) {
            const itemIndex = checkedItems.findIndex(i => i.id === id);
            if (itemIndex !== -1) {
                if (checkedItems[itemIndex].quantity > 1) {
                    checkedItems[itemIndex].quantity--;
                } else {
                    checkedItems.splice(itemIndex, 1); // hapus kalau qty 0
                }
                renderOrderItems();
                updateTotal();
            }
        }

        function updatePrices() {
            checkedItems.forEach(item => {
                const totalPrice = item.price * item.quantity;
                const priceElement = document.querySelector(`#item-${item.id} .item-price`);
                if (priceElement) {
                    priceElement.innerText = formatCurrency(totalPrice);
                }
            });
        }

        function updateTotal() {
            const itemsTotal = checkedItems.reduce((sum, item) => sum + (item.price * item.quantity), 0);
            const isPickup = document.querySelector('.tab.active').textContent.trim() === 'Pick up';
            const deliveryFee = isPickup ? 0 : baseDeliveryFee;
            const grandTotal = itemsTotal + deliveryFee;
            
            // Update display
            document.getElementById('priceTotal').textContent = formatCurrency(itemsTotal);
            document.getElementById('totalPayment').textContent = formatCurrency(grandTotal);
            document.getElementById('cashAmount').textContent = formatCurrency(grandTotal);
            document.getElementById('qrisAmount').textContent = formatCurrency(grandTotal);
        }

        function renderOrderItems() {
            // ...fungsi renderOrderItems yang benar sudah ada di atas, hapus duplikat ini...
        }

        function formatCurrency(amount) {
            return 'Rp ' + amount.toLocaleString('id-ID');
        }

        function placeOrder() {
            if (checkedItems.length === 0) {
                alert('Tidak ada item untuk dipesan!');
                return;
            }

            // Animate button
            const btn = document.querySelector('.order-btn');
            btn.style.transform = 'scale(0.95)';
            btn.textContent = 'Processing...';
            
            setTimeout(() => {
                btn.style.transform = 'scale(1)';
                btn.textContent = 'Order Placed! ✓';
                btn.style.background = '#27ae60';
                
                setTimeout(() => {
                    const paymentText = selectedPayment === 'cash' ? 'Cash' : 'QRIS';
                    const addressName = document.getElementById('addressName').textContent;
                    const addressText = document.getElementById('addressText').textContent;
                    const notesText = deliveryNotesText ? '\n- Catatan: ' + deliveryNotesText : '';
                    
                    // Generate order summary
                    let itemSummary = '';
                    checkedItems.forEach(item => {
                        itemSummary += `- ${item.quantity}x ${item.name} (${item.variant}): ${formatCurrency(item.price * item.quantity)}\n`;
                    });
                    
                    alert(`Pesanan Anda telah berhasil ditempatkan!\n\nDetail Pesanan:\n${itemSummary}\n- Total: ${document.getElementById('totalPayment').textContent}\n- Metode Pembayaran: ${paymentText}\n- Alamat: ${addressName}, ${addressText}${notesText}\n\nTerima kasih telah berbelanja!`);
                    
                    // Optional: Clear checkout items after successful order
                    localStorage.removeItem("checkoutItems");
                }, 500);
            }, 1000);
        }

        // Initialize page
        function initializePage() {
            if (checkedItems.length === 0) {
                console.log('No checkout items found');
            }
            renderOrderItems();
            updateTotal();
        }

        // GANTI bagian initialize terakhir dengan ini:
        initializePage();

        // Fungsi render ulang daftar item yang dipilih
        function renderOrderItems() {
            const productList = document.getElementById('productList');
            
            if (checkedItems.length === 0) {
                productList.innerHTML = `
                    <div class="empty-order">
                        <p>Tidak ada item untuk dipesan</p>
                        <button onclick="window.location.href='keranjang.php'" class="back-to-cart-btn">
                        Kembali ke Keranjang
                        </button>

                    </div>
                `;
                return;
            }

            productList.innerHTML = checkedItems.map(item => {
                let filename = '';
                if (item.img) {
                    filename = item.img.split('/').pop();
                } else if (item.image) {
                    filename = item.image.split('/').pop();
                }
                let imgSrc = filename ? `/sweetbakee/assets/img/${filename}` : '';
                let imageTag = imgSrc
                    ? `<img src="${imgSrc}" alt="${item.name}" onerror="this.style.display='none';this.parentNode.innerHTML=getMenuIcon('${item.name}');" />`
                    : getMenuIcon(item.name);
                return `
                <div class="product-item">
                    <div class="menu-item">
                        <div class="menu-image">
                            ${imageTag}
                        </div>
                        <div class="menu-info">
                            <div class="menu-name">${item.name || '-'}</div>
                            <div class="menu-variant">${item.variant || 'Original'}</div>
                            <div class="menu-price">${formatCurrency(item.price || 0)}</div>
                        </div>
                        <div class="menu-quantity">
                            <button class="qty-btn minus" onclick="decreaseQuantity(${item.id})">−</button>
                            <span class="qty-display">${item.quantity || 1}</span>
                            <button class="qty-btn plus" onclick="increaseQuantity(${item.id})">+</button>
                        </div>
                    </div>
                </div>
                `;
            }).join('');
        }


        function getMenuIcon(menuName) {
            // Generate icon berdasarkan nama menu
            const name = menuName.toLowerCase();
            
            if (name.includes('walnut') || name.includes('baklava')) return 'WB';
            if (name.includes('banana') || name.includes('cream')) return 'BC';
            if (name.includes('chocolate')) return 'CH';
            if (name.includes('mille') || name.includes('crepe')) return 'MC';
            if (name.includes('coffee') || name.includes('kopi')) return 'CF';
            if (name.includes('tea') || name.includes('teh')) return 'TE';
            
            // Default: ambil 2 huruf pertama dari nama
            return menuName.substring(0, 2).toUpperCase();
        }
    </script>
</body>
</html>