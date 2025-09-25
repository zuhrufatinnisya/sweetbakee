<?php
session_start();
require_once("../config/database.php");

$error = '';
$title = "Login - SweetBake";
$location = "Ngaliyan, Semarang";

// Redirect jika sudah login


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $stmt = mysqli_prepare($conn, "SELECT id, username, password, role FROM users WHERE username = ?");
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['role'] = $row['role'];
            
            // Redirect berdasarkan role
            if ($row['role'] === 'admin') {
                header('Location: ../admin/index.php');
            } else {
                header('Location: landingpage.php');
            }
            exit;
        } else {
            $error = 'Username atau password salah!';
        }
    } else {
        $error = 'Username atau password salah!';
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title) ?></title>
    <link rel="stylesheet" href="../assets/css/stylelp.css">
    <link rel="stylesheet" href="../assets/css/auth.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-color: #8B5A2B;
            --secondary-color: #D2B48C;
            --accent-color: #F5DEB3;
            --text-color: #4A3728;
            --light-color: #FFF8E7;
        }
        
        .navbar {
            background-color: var(--light-color);
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .navbar-brand {
            color: var(--primary-color);
            font-weight: bold;
            font-size: 1.5rem;
        }
        
        .nav-link {
            color: var(--text-color);
            font-weight: 500;
        }
        
        .nav-link:hover {
            color: var(--primary-color);
        }
        
        .auth-container {
            display: flex;
            height: calc(100vh - 76px);
            background-color: var(--light-color);
        }
        
        .auth-card {
            background-color: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
            margin: auto;
        }
        
        .auth-card h2 {
            color: var(--primary-color);
            margin-bottom: 1rem;
            text-align: center;
        }
        
        .subtitle {
            text-align: center;
            margin-bottom: 1.5rem;
            color: var(--text-color);
        }
        
        .brand {
            color: var(--primary-color);
            font-weight: bold;
        }
        
        .alert {
            background-color: #f8d7da;
            color: #721c24;
            padding: 0.75rem;
            border-radius: 5px;
            margin-bottom: 1rem;
        }
        
        .success {
            background-color: #d4edda;
            color: #155724;
            padding: 0.75rem;
            border-radius: 5px;
            margin-bottom: 1rem;
        }
        
        form input {
            width: 100%;
            padding: 0.75rem;
            margin-bottom: 1rem;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        
        form button {
            width: 100%;
            padding: 0.75rem;
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            transition: background-color 0.3s;
        }
        
        form button:hover {
            background-color: #6d4520;
        }
        
        .option {
            text-align: center;
            margin-top: 1rem;
        }
        
        .option a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
        }
        
        .option a:hover {
            text-decoration: underline;
        }
        
        .auth-image {
            display: none;
        }
        
        @media (min-width: 768px) {
            .auth-container {
                padding: 2rem;
            }
            
            .auth-card {
                max-width: 400px;
            }
        }
        
        @media (min-width: 992px) {
            .auth-container {
                display: flex;
                justify-content: space-between;
                padding: 0;
            }
            
            .auth-card {
                width: 45%;
                margin: auto 0 auto 5%;
                max-width: 450px;
            }
            
            .auth-image {
                display: block;
                width: 50%;
                position: relative;
                overflow: hidden;
            }
            
            .auth-image img {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }
            
            .text-overlay {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0,0,0,0.2);
                display: flex;
                flex-direction: column;
                justify-content: center;
                padding: 2rem;
                color: white;
            }
        }
    </style>
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
            <a href="kontak.php">Contact</a>
        </div>
        <div class="nav-right">
            <div class="cart-icon" onclick="window.location.href='keranjang.php'">
                <i class="bi bi-bag"></i>
            </div>
        </div>
    </nav>

    <!-- Login Form -->
    <div class="auth-container" style="display:flex;align-items:center;justify-content:center;min-height:80vh;background:transparent;">
        <div class="auth-card" style="background:rgba(255,255,255,0.97);padding:2.5rem 2rem;border-radius:18px;box-shadow:0 8px 32px rgba(178,116,65,0.12);max-width:370px;width:100%;margin:80px auto 0 auto;">
            <h2 style="color:#B27441;text-align:center;margin-bottom:1rem;">Login</h2>
            <p class="subtitle" style="text-align:center;margin-bottom:1.5rem;color:#B27441;">Masuk ke akun <span class="brand">SweetBake</span> kamu</p>
            <?php if (!empty($error)): ?>
                <div class="alert" style="background:#ffe3d2;color:#b27441;border-left:4px solid #b27441;"> <?php echo htmlspecialchars($error); ?> </div>
            <?php endif; ?>
            <form method="post" autocomplete="off">
                <input type="text" name="username" placeholder="Username" required style="padding:0.9rem 1rem;margin-bottom:1rem;border-radius:10px;border:1.5px solid #e3c6a2;font-size:1rem;">
                <input type="password" name="password" placeholder="Password" required style="padding:0.9rem 1rem;margin-bottom:1rem;border-radius:10px;border:1.5px solid #e3c6a2;font-size:1rem;">
                <button type="submit" id="loginBtn" style="width:100%;padding:0.9rem 1rem;background:#B27441;color:#fff;font-weight:600;border:1.5px solid #e3c6a2;border-radius:10px;font-size:1.1rem;box-shadow:0 4px 16px 0 #e3c6a2,0 1.5px 0 #fff inset;transition:background 0.2s,box-shadow 0.2s,transform 0.1s;">Login</button>
</script>
<script>
// Button hover effect for login
const loginBtn = document.getElementById('loginBtn');
if(loginBtn) {
    loginBtn.onmouseover = function(){ this.style.background='#d49a6a'; this.style.boxShadow='0 8px 24px 0 #e3c6a2,0 1.5px 0 #fff inset'; this.style.transform='translateY(-2px) scale(1.03)'; };
    loginBtn.onmouseout = function(){ this.style.background='#B27441'; this.style.boxShadow='0 4px 16px 0 #e3c6a2,0 1.5px 0 #fff inset'; this.style.transform='none'; };
    loginBtn.onmousedown = function(){ this.style.transform='scale(0.98)'; };
    loginBtn.onmouseup = function(){ this.style.transform='translateY(-2px) scale(1.03)'; };
}
</script>
                <p class="option" style="text-align:center;margin-top:1.2rem;">Belum punya akun? <a href="signup.php" style="color:#B27441;font-weight:600;">Daftar di sini</a></p>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
