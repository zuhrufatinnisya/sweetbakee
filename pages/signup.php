<?php
require_once("../config/database.php");

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($username && $password) {
        $stmt = mysqli_prepare($conn, "SELECT id FROM users WHERE username = ?");
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) > 0) {
            $error = 'Username sudah terdaftar!';
        } else {
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = mysqli_prepare($conn, "INSERT INTO users (username, password) VALUES (?, ?)");
            mysqli_stmt_bind_param($stmt, "ss", $username, $password_hash);
            if (mysqli_stmt_execute($stmt)) {
                $success = 'Registrasi berhasil! <a href="login.php">Login sekarang</a>.';
            } else {
                $error = 'Registrasi gagal!';
            }
        }
        mysqli_stmt_close($stmt);
    } else {
        $error = 'Semua kolom wajib diisi!';
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar - SweetBake</title>
    <link rel="stylesheet" href="../assets/css/auth.css">
</head>
<body>
    <div class="auth-container">
        <div class="auth-card">
            <h2>Buat Akun Baru 🎉</h2>
            <p class="subtitle">Gabung sekarang di <span class="brand">SweetBake</span></p>
            <?php if (!empty($error)): ?>
                <div class="alert"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            <?php if (!empty($success)): ?>
                <div class="success"><?php echo $success; ?></div>
            <?php endif; ?>
            <form method="post">
                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit">Daftar</button>
                <p class="option">Sudah punya akun? <a href="login.php">Login di sini</a></p>
            </form>
        </div>
        <div class="auth-image">
            <img src="../assets/img/bg3.jpg" alt="SweetBake Promo">
            <div class="text-overlay">
                <p>Bikin akunmu & cicipi roti terenak hari ini 🍞</p>
            </div>
        </div>
    </div>
</body>
</html>
