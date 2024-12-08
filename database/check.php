<?php
session_start(); //session itu gunna untuk nyimpen data

if ($_SERVER['REQUEST_METHOD'] === "POST") { //
    $nim = $_POST['myNim'];
    $pass = $_POST['myPassword'];

    if (!empty($nim) && !empty($pass)) {
        $host = "localhost";
        $port = 3308;
        $dbUsername = "root";
        $dbPass = "";
        $dbName = "MONITA";

        $conn = new mysqli($host, $dbUsername, $dbPass, $dbName, $port);

        if ($conn->connect_error) {
            error_log("Connection failed: ".$conn->connect_error);
            die("Internal server error. Please try again later.");
        } else {
            $SELECT = "SELECT * FROM mahasiswa WHERE Nim = ?";
            $stmt = $conn->prepare($SELECT);
            $stmt->bind_param("s", $nim);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows == 1) {
                $data = $result->fetch_assoc();
                $storedPassword = $data['Pass'];

                if (password_verify($pass, $storedPassword)) {
                    session_regenerate_id(true);
                    $_SESSION['Nim'] = $data['Nim'];
                    $_SESSION['Username'] = $data['Username'];
                    header("Location: ../main-menu.php");

                    $stmt->close();
                    $conn->close();
                    
                    exit();
                } else {
                    $errorMessage = "Password atau NIM salah.";
                    header("Location: ../login.php?error=$errorMessage");
                    exit();
                }
            } else {
                $errorMessage = "Akun tidak ditemukan.";
                //header("Location: login.php?error=" . urlencode($errorMessage));
                header("Location: ../login.php?error=$errorMessage");
                exit();
            }
        }
    } else {
        $errorMessage = "Harap masukkan NIM dan password.";
        //header("Location: login.php?error=" . urlencode($errorMessage));
        header("Location: ../main-menu.php");
        exit();
    }
} else {
    //header("Location: login.php");
    header("Location: ../main-menu.php");
    exit();
}
?>
