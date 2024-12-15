<?php
    session_start();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (!isset($_SESSION['Nim'])) {
            header("Location: ../login.php");
            exit();
        }
    
        $nim = $_SESSION['Nim']; 


        $host = "localhost";
        $port = 3308;
        $dbUsername = "root";
        $dbPass = "";
        $dbName = "MONITA";

        $conn = new mysqli($host, $dbUsername, $dbPass, $dbName, $port);
        if (mysqli_connect_error()) { // check ada error g pas nyoba konek ke db
            die("Connect Error ('".mysqli_connect_errno()."'): ".mysqli_connect_error());//klo error bakal nunjukin pesan error
        }
        
        $judul = $_POST['judul-ta'];
        $tanggal = $_POST['tanggal'];
        $progress = $_POST['progress'];

    }
    

    
    
    
    

    if (!empty($nim) && !empty($judul) && !empty($tanggal) && !empty($progress)) {
        $fileName = $_FILES["file-upload"]["name"];
        $targetFile = 'file_mahasiswa/' . $fileName;
        $fileType = strtolower(pathinfo($targetFile,PATHINFO_EXTENSION));
        $userFile = "";

        if ($fileType != "pdf") {
            echo("pdf file please, thankyou!");
            die();
        }else{
            move_uploaded_file($_FILES["file-upload"]["tmp_name"], $targetFile);
        }

        if ($userFile = "") {
            echo("Upload file gagal");
            die();
        }
        
        $INSERT = "INSERT INTO Progress (NIM_MHS, {$progress}) VALUES(?,?)";
        $stmt = $conn->prepare($INSERT);
        $stmt->bind_param("ss", $nim, $targetFile);
        $stmt->execute();

        die();
    }else{

        echo("Maaf, Tidak Lengkap");
        die();
    }
?>
