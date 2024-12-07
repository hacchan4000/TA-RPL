<?php

$username = $_POST['username'];
$nim = $_POST['NIM'];
$email = $_POST['Email'];
$pass = $_POST['password'];

if (!empty($username) || !empty($nim) || !empty($email) || !empty($pass)) { //check apakah dari var" diatas ada yang kosong ndak
    //variabel di bawah nyimpen string" untuk konek ke db
    $host = "localhost";
    $port = 3308;
    $dbUsername = "root";
    $dbPass = "";
    $dbName = "MONITA"; //nama database

    $conn = new mysqli($host, $dbUsername, $dbPass, $dbName, $port);

    if (mysqli_connect_error()) { // check ada error g pas nyoba konek ke db
        die("Connect Error ('".mysqli_connect_errno()."'): ".mysqli_connect_error());//klo error bakal nunjukin pesan error
    }else { //kalo gaad error bakal di update tabel mahasiswa di db nya
        //enkripsi password
        $pass = password_hash($pass, PASSWORD_DEFAULT);

        $SELECT ="SELECT Nim FROM mahasiswa WHERE Nim = ? LIMIT 1"; //variabel SELECT bakal nyimpen query untuk milih kolom Nim dari tabel mahasiswa dimana nim hrs ber jmlh 1
        $INSERT = "INSERT INTO mahasiswa (Username,Nim,Email,Pass) VALUES(?,?,?,?)"; // masukkan values ke tabel mahasiswa

        //prepare statement buat query select
        $stmt = $conn->prepare($SELECT);
        $stmt->bind_param("s",$nim);// nanti tanda ? di query select bakal digantiin sama $nim, tipe $nim itu string (s)
        $stmt->execute();
        $stmt->bind_result($nim); // kita retrieve data dari kolom nim
        $stmt->store_result();
        $rnum = $stmt->num_rows;// di var ini kt nyimpen brp banya baris yang disimpen dr proses select kt

        if ($rnum == 0) {
            $stmt->close();

            $stmt = $conn->prepare($INSERT);
            $stmt->bind_param("ssss",$username, $nim, $email, $pass);
            $stmt->execute();

            $berhasil ="Sign Up berhasil, Silahkan login";
            header("Location: ../login.php?error=$berhasil");
        } else {
            $terdaftar ="Nim tersebut sudah terdaftar";
            header("Location: ../login.php?error=$terdaftar");

            echo "Nim yang barusan diinput sudah terdaftar";
        }
        $stmt->close();
        $conn->close();
    }
} else {
    echo "Data belum lengkap";
    die();
}
?>
