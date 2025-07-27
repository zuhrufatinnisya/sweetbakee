<?php
$host = "localhost";        
$user = "root";             
$pass = "";                 
$db   = "sweetbake";       

// Membuat koneksi ke database
$conn = mysqli_connect($host, $user, $pass, $db);

// Cek koneksi
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>