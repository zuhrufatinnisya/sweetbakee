<?php
session_start();

// Konfigurasi database
$host = 'localhost';
$dbname = 'bakery_db';
$username = 'root';
$password = '';

// Variabel untuk pesan
$message = '';
$message_type = '';

// Proses form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars($_POST['name'] ?? '');
    $email = htmlspecialchars($_POST['email'] ?? '');
    $phone = htmlspecialchars($_POST['phone'] ?? '');
    $subject = htmlspecialchars($_POST['subject'] ?? '');
    $msg = htmlspecialchars($_POST['message'] ?? '');
    
    // Validasi input
    if (empty($name) || empty($email) || empty($msg)) {
        $message = 'Nama, email, dan pesan wajib diisi!';
        $message_type = 'error';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = 'Format email tidak valid!';
        $message_type = 'error';
    } else {
        try {
            // Koneksi ke database (opsional)
            /*
            $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $stmt = $pdo->prepare("INSERT INTO contacts (name, email, phone, subject, message, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
            $stmt->execute([$name, $email, $phone, $subject, $msg]);
            */
            
            // Kirim email (simulasi - gunakan PHPMailer untuk implementasi nyata)
            $to = 'info@sweetdreamsbakery.com';
            $email_subject = 'Pesan Baru dari Website: ' . ($subject ?: 'Umum');
            $email_body = "
                Nama: $name
                Email: $email
                Telepon: $phone
                Jenis Pesanan: $subject
                
                Pesan:
                $msg
                
                Dikirim pada: " . date('Y-m-d H:i:s');
            
            $headers = "From: $email\r\n";
            $headers .= "Reply-To: $email\r\n";
            $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
            
            // mail($to, $email_subject, $email_body, $headers); // Uncomment untuk mengirim email
            
            $message = 'Terima kasih! Pesan Anda telah terkirim. Kami akan segera menghubungi Anda.';
            $message_type = 'success';
            
            // Reset form data
            $_POST = array();
            
        } catch (Exception $e) {
            $message = 'Terjadi kesalahan. Silakan coba lagi.';
            $message_type = 'error';
            error_log($e->getMessage());
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kontak - SweetBake</title>
    <link rel="stylesheet" href="../assets/css/stylelp.css">
    <link rel="stylesheet" href="../assets/css/kontak.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body>
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
                <?php if (isset($cartCount) && $cartCount > 0): ?>
                    <span class="cart-badge" id="cartBadge"><?php echo $cartCount; ?></span>
                <?php endif; ?>
            </div>
        </div>
    </nav>
<script>
function goToCart() {
    window.location.href = 'keranjang.php';
}
</script>

    <div class="container">
        <div class="page-header">
            <h1><i class="fas fa-phone-alt"></i> Hubungi Kami</h1>
            <p>Kami siap membantu mewujudkan kue impian terbaik untuk Anda!</p>
        </div>

        <?php if (!empty($message)): ?>
            <div class="alert <?php echo $message_type; ?>">
                <i class="fas <?php echo $message_type === 'success' ? 'fa-check-circle' : 'fa-exclamation-triangle'; ?>"></i>
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <div class="contact-section">
            <div class="contact-form">
                <h2><i class="fas fa-envelope"></i> Kirim Pesan</h2>
                <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" id="contactForm">
                    <div class="form-group">
                        <label for="name">Nama Lengkap <span class="required">*</span></label>
                        <input type="text" id="name" name="name" required 
                               value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Email <span class="required">*</span></label>
                        <input type="email" id="email" name="email" required 
                               value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="phone">Nomor Telepon / WhatsApp</label>
                        <input type="tel" id="phone" name="phone" placeholder="+62 812-3456-7890"
                               value="<?php echo htmlspecialchars($_POST['phone'] ?? ''); ?>">
                    </div>
                    
                    <div class="form-group">
                        <label for="subject">Jenis Pesanan</label>
                        <select id="subject" name="subject">
                            <option value="">-- Pilih jenis pesanan --</option>
                            <option value="
                            " <?php echo (($_POST['subject'] ?? '') === 'mile-crepes') ? 'selected' : ''; ?>>Mille Crepes</option>
                            <option value="roll-cake" <?php echo (($_POST['subject'] ?? '') === 'roll-cake') ? 'selected' : ''; ?>>Roll Cake</option>
                            <option value="soft-cake" <?php echo (($_POST['subject'] ?? '') === 'soft-cake') ? 'selected' : ''; ?>>Soft Cake</option>
                            <option value="cookies" <?php echo (($_POST['subject'] ?? '') === 'cookies') ? 'selected' : ''; ?>>Cookies</option>
                            <option value="cupcake-muffin" <?php echo (($_POST['subject'] ?? '') === 'cupcake-muffin') ? 'selected' : ''; ?>>Cupcake and Muffin</option>
                            <option value="donut-pastry" <?php echo (($_POST['subject'] ?? '') === 'donut-pastry') ? 'selected' : ''; ?>>Donut and Pastry</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="message">Pesan / Detail Pesanan <span class="required">*</span></label>
                        <textarea id="message" name="message" required 
                                  placeholder="Ceritakan detail kue impian Anda: ukuran, rasa, tema, tanggal acara, jumlah porsi, dan preferensi lainnya..."><?php echo htmlspecialchars($_POST['message'] ?? ''); ?></textarea>
                    </div>
                    
                    <button type="submit" class="submit-btn" id="submitBtn">
                        <i class="fas fa-paper-plane"></i>
                        <span>Kirim Pesan</span>
                    </button>
                </form>
            </div>

            <div class="contact-info">
                <h2><i class="fas fa-info-circle"></i> Informasi Kontak</h2>
                
                <div class="info-item">
                    <i class="fas fa-map-marker-alt"></i>
                    <div>
                        <strong>Alamat Toko</strong>
                        <span>Jl. Prof. Hamka 123<br>Kelurahan Tambakaji, Ngaliyan<br>Semarang Barat</span>
                    </div>
                </div>
                
                <div class="info-item">
                    <i class="fas fa-phone"></i>
                    <div>
                        <strong>Telepon Toko</strong>
                        <span><a href="tel:+62295123456">(0295) 123-456</a></span>
                    </div>
                </div>
                
                <div class="info-item">
                    <i class="fab fa-whatsapp"></i>
                    <div>
                        <strong>WhatsApp</strong>
                        <span><a href="https://wa.me/6281234567890" target="_blank">+62 812-3456-7890</a><br>
                        <small>Klik untuk chat langsung</small></span>
                    </div>
                </div>
                
                <div class="info-item">
                    <i class="fas fa-envelope"></i>
                    <div>
                        <strong>Email</strong>
                        <span><a href="mailto:info@sweetdreamsbakery.com">info@sweetdreamsbakery.com</a><br>
                        <a href="mailto:order@sweetdreamsbakery.com">order@sweetdreamsbakery.com</a></span>
                    </div>
                </div>

                <div class="business-hours">
                    <h4><i class="fas fa-clock"></i> Jam Operasional</h4>
                    <div class="hours-grid">
                        <span>Senin - Jumat:</span>
                        <span>07:00 - 21:00</span>
                        <span>Sabtu:</span>
                        <span>07:00 - 22:00</span>
                        <span>Minggu:</span>
                        <span>08:00 - 20:00</span>
                    </div>
                    <small style="color: #636e72; margin-top: 0.5rem; display: block;">
                        <i class="fas fa-info-circle"></i> Untuk pesanan khusus, hubungi H-3 sebelum acara
                    </small>
                </div>

                <div class="social-links">
                    <a href="#" title="Facebook" target="_blank">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" title="Instagram" target="_blank">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="https://wa.me/6281234567890" title="WhatsApp" target="_blank">
                        <i class="fab fa-whatsapp"></i>
                    </a>
                    <a href="#" title="TikTok" target="_blank">
                        <i class="fab fa-tiktok"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="map-section">
            <h2><i class="fas fa-map"></i> Lokasi Toko</h2>
            <div class="map-container">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3955.9296919522173!2d110.35324121480031!3d-7.023119594858269!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7088d5532ae6f7%3A0x810ed2a3fbd4689c!2sNgaliyan%2C%20Semarang%2C%20Central%20Java%20Indonesia!5e0!3m2!1sen!2sid!4v1700000000000!5m2!1sen!2sid" 
                    width="600" 
                    height="450" 
                    style="border:0;" 
                    allowfullscreen="" 
                    loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
            <div class="map-info">
                <span><i class="fas fa-car"></i> Parkir tersedia</span>
                <span><i class="fas fa-motorcycle"></i> Akses mudah motor</span>
                <span><i class="fas fa-wheelchair"></i> Ramah disabilitas</span>
                <span><i class="fas fa-credit-card"></i> Cash & Non-tunai</span>
            </div>
        </div>
    </div>

    <script>
        // Form submission with loading state
        document.getElementById('contactForm').addEventListener('submit', function() {
            const submitBtn = document.getElementById('submitBtn');
            const originalContent = submitBtn.innerHTML;
            
            submitBtn.innerHTML = '<div class="spinner"></div> Mengirim...';
            submitBtn.disabled = true;
            
            // Re-enable button after form submission (if there's an error)
            setTimeout(() => {
                if (submitBtn.disabled) {
                    submitBtn.innerHTML = originalContent;
                    submitBtn.disabled = false;
                }
            }, 10000);
        });

        // Auto-format phone number
        document.getElementById('phone').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            
            if (value.startsWith('0')) {
                value = '62' + value.substring(1);
            }
            
            if (value.startsWith('62')) {
                value = '+' + value;
            } else if (value && !value.startsWith('+')) {
                value = '+62' + value;
            }
            
            // Format: +62 812-3456-7890
            if (value.length > 3) {
                value = value.substring(0, 3) + ' ' + value.substring(3);
            }
            if (value.length > 7) {
                value = value.substring(0, 7) + '-' + value.substring(7);
            }
            if (value.length > 12) {
                value = value.substring(0, 12) + '-' + value.substring(12, 16);
            }
            
            e.target.value = value;
        });

        // Auto-hide alert after 5 seconds
        const alert = document.querySelector('.alert');
        if (alert) {
            setTimeout(() => {
                alert.style.opacity = '0';
                alert.style.transform = 'translateY(-20px)';
                setTimeout(() => alert.remove(), 300);
            }, 5000);
        }

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Character counter for message textarea
        const messageTextarea = document.getElementById('message');
        const maxLength = 1000;
        
        messageTextarea.addEventListener('input', function() {
            const currentLength = this.value.length;
            
            if (!document.querySelector('.char-counter')) {
                const counter = document.createElement('small');
                counter.className = 'char-counter';
                counter.style.cssText = 'color: #636e72; float: right; margin-top: 0.5rem;';
                this.parentNode.appendChild(counter);
            }
            
            const counter = document.querySelector('.char-counter');
            counter.textContent = `${currentLength}/${maxLength} karakter`;
            
            if (currentLength > maxLength * 0.8) {
                counter.style.color = currentLength >= maxLength ? '#e74c3c' : '#f39c12';
            } else {
                counter.style.color = '#636e72';
            }
        });
    </script>
</body>
</html>