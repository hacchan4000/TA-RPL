<?php
$host = 'localhost';
$user = 'root'; 
$password = ''; 
$database = 'monitoring_tugas_akhir';

// Buat koneksi ke database menggunakan MySQLi
$conn = new mysqli($host, $user, $password, $database);

// Periksa apakah koneksi berhasil
if ($conn->connect_error) {
    // Menampilkan pesan error jika koneksi gagal
    die("Koneksi gagal: " . $conn->connect_error);
} else {
    // echo "Koneksi berhasil!";
}
?>
