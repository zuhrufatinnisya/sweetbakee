<?php
$host = "localhost";        
$user = "root";             
$pass = "";                 
$db   = "sweetbake";       

// Membuat koneksi ke database
$conn = mysqli_connect($host, $user, $pass);

// Cek koneksi
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Cek apakah database sudah ada, jika belum maka buat
$sql = "CREATE DATABASE IF NOT EXISTS `$db`";
if (mysqli_query($conn, $sql)) {
    // Pilih database
    mysqli_select_db($conn, $db);
    
    // Cek apakah tabel users sudah ada
    $result = mysqli_query($conn, "SHOW TABLES LIKE 'users'");
    if (mysqli_num_rows($result) == 0) {
        // Buat tabel users jika belum ada
        $sql = "CREATE TABLE `users` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `username` varchar(50) NOT NULL,
            `password` varchar(255) NOT NULL,
            `email` varchar(100) DEFAULT NULL,
            `nama_lengkap` varchar(100) DEFAULT NULL,
            `alamat` text DEFAULT NULL,
            `no_telp` varchar(15) DEFAULT NULL,
            `role` enum('admin','user') NOT NULL DEFAULT 'user',
            `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
            PRIMARY KEY (`id`),
            UNIQUE KEY `username` (`username`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
        mysqli_query($conn, $sql);
        
        // Tambahkan admin default
        $admin_password = password_hash('admin123', PASSWORD_DEFAULT);
        $sql = "INSERT INTO `users` (`username`, `password`, `email`, `nama_lengkap`, `role`) VALUES
                ('admin', '$admin_password', 'admin@sweetbake.com', 'Administrator', 'admin')";
        mysqli_query($conn, $sql);
    }
} else {
    die("Error creating database: " . mysqli_error($conn));
}
?>