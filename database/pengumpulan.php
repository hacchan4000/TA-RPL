<?php
    $host = "localhost";
    $port = 3306;
    $dbUsername = "root";
    $dbPass = "050714";
    $dbName = "monita";

    $conn = new mysqli($host, $dbUsername, $dbPass, $dbName, $port);
    if (mysqli_connect_error()) { // check ada error g pas nyoba konek ke db
        die("Connect Error ('".mysqli_connect_errno()."'): ".mysqli_connect_error());//klo error bakal nunjukin pesan error
    }
    
    session_start();
    $nim = $_SESSION['Nim'];
    $judul = $_POST['judul-ta'];
    $tanggal = $_POST['tanggal'];
    $progress = $_POST['progress'];

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
        echo("Galengkap tod");
        die();
    }
?>
