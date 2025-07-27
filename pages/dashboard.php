<?php
$judul = "SweetBake";
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title><?php echo htmlspecialchars($judul); ?></title>
    <!-- Perbaiki path CSS ke asset/css jika perlu -->
    <link rel="stylesheet" href="../assets/css/styledash.css" />
    <style>
      .hero-section::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 60px;
        background: url('../img/heroafter.png') bottom center / cover no-repeat;
        z-index: 2;
      }
    </style>
  </head>
  <body>
    <nav class="navbar">
      <div class="logo">
        <img src="../img/logo.png" alt="SweetBake Logo" />
      </div>
      <ul class="nav-links">
        <li><a href="dashboard.php">Home</a></li>
        <li><a href="contact.php">Contact</a></li>
        <li><a href="login.php" class="login-btn">Login</a></li>
        <li><a href="signup.php" class="signup-btn">Sign Up</a></li>
      </ul>
    </nav>
    <header class="hero-section">
      <div class="hero-text">
        <h1>The Sweetness in <br />Every Bite!</h1>
        <p>Every bite you eat will give you the same sweet taste,<br /> because your teeth also need sweet intake.</p>
        <div class="hero-buttons">
          <a href="landingpage.php" class="order-btn">Order Now</a>
          <a href="#about" class="learn-more">Learn More</a>
        </div>
      </div>
    </header>
  </body>
</html>