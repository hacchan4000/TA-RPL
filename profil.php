<?php
session_start();
if (isset($_SESSION['Username']) && isset($_SESSION['Nim'])) {
    $username = $_SESSION['Username'];
    $nim = $_SESSION['Nim'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="styles/pages/profile.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
</head>
<body>
<header class="mainHeader"> 
    <nav class="navigasi-mm">
        <a href="pengumpulan.html">PENGUMPULAN TA</a>
        <a href="status.html">STATUS TA</a>
        <a href="main-menu.php">HOME</a>
        <a href="#">CONTACTS</a>
    </nav>
    <a class="profil" href="login.php"><ion-icon name="log-out-outline"></ion-icon></a>
</header>

<div class="main-body">
    <div class="foto-user">
        <img src="gambar/icons/tennis.png" alt="" class="foto-user">

        <div class="edit">
            <button class="tombol-edit">EDIT PROFIL</button>
        </div>

        <div class="desc" style="margin-top: 20px; width: 450px;">
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Perspiciatis quaerat ullam, assumenda recusandae nihil ex esse, necessitatibus repudiandae explicabo expedita nam quam obcaecati sint quis a in quo voluptas reprehenderit.
        </div>

        <div class="verifikasi">
            <h1 style="font-weight: bold;">VERIFIKASI</h1>
            Silahkan upload file-file berikut untuk mengkases layanan MONITA
            <li>Sertifikat A</li>
            <input type="file">
            <li>Sertifikat B</li>
            <input type="file">
            <li>Sertifikat C</li>
            <input type="file">
            <li>Sertifikat D</li>
            <input type="file">
        </div>
    </div>
    
    <div class="box-biodata">
        <div class="salam">
            <h1>Hello,</h1>
            <h1 style="font-weight: bold; font-size:60px"><?= htmlspecialchars($username, ENT_QUOTES, 'UTF-8') ?></h1>
        </div>

        <div class="konten">
            <div class="b1">
                <h3> NIM</h3>
                <h5><?= htmlspecialchars($nim, ENT_QUOTES, 'UTF-8') ?></h5>
                <h3> EMAIL</h3>
                <h5> nugraha.2308561092@gmail.com</h5>
                <h3> Telpon</h3>
                <h5> 0869696969</h5>
                <h3> Alamat</h3>
                <h5> jl pacar keling II</h5>
            </div>
            <div class="b2">
                <h3> Fakultas</h3>
                <h5> MIPA</h5>
                <h3> Jurusan</h3>
                <h5> Informatika</h5>
                <h3> Semester</h3>
                <h5> 6</h5>
                <h3> Dosen Pembimbing</h3>
                <h5> I Gusti Ngurah Anom Cahyadi Putra</h5>
            </div>
        </div>
    </div>
</div>

<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>
<?php
} else {
    header("Location: ../TA-RPL/main-menu.php");
    exit();
}
?>
