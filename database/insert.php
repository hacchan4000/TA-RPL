<?php
$username = $_POST['username'];
$nim = $_POST['NIM'];
$email = $_POST['Email'];
$pass = $_POST['password'];

$host = "localhost";
$dbUsername = "root";
$dbPass = "";
$dbName = "apkPeminjaman";

$conn = new mysqli($host, $username, $password,$dbName);
if (mysqli_connect_error()) {
    die(`Connect Error('.mysqli_connect_errorno().')`. mysqli_connect_error());
}else {
    $SELECT ="SELECT NIM from record Where NIM = ? Limit 1";
    $INSERT .= "INSERT Into record (username,nim,email,pass) values(?,?,?,?)";


}

