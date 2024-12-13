<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if user is logged in
    if (!isset($_SESSION['Nim'])) {
        header("Location: ../login.php");
        exit();
    }

    $nim = $_SESSION['Nim']; // Logged-in user's NIM

    // Database connection
    $host = "localhost";
    $port = 3308; // Use your MySQL port
    $dbUsername = "root";
    $dbPass = "";
    $dbName = "MONITA";

    $conn = new mysqli($host, $dbUsername, $dbPass, $dbName, $port);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Retrieve form data
    $telpon = $conn->real_escape_string($_POST['telpon']);
    $alamat = $conn->real_escape_string($_POST['alamat']);
    $fakultas = $conn->real_escape_string($_POST['fakultas']);
    $jurusan = $conn->real_escape_string($_POST['jurusan']);
    $semester = (int) $_POST['semester'];
    $dosbing = $conn->real_escape_string($_POST['dosbing']);

    // Handle profile picture upload
    if (isset($_FILES['pfp']) && $_FILES['pfp']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '/Applications/XAMPP/xamppfiles/htdocs/TA-RPL/gambar/foto-pfp/';
        $fileTmpPath = $_FILES['pfp']['tmp_name'];
        $fileName = basename($_FILES['pfp']['name']);
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($fileExtension, $allowedExtensions)) {
            $newFileName = $nim . "_profile." . $fileExtension;
            $uploadPath = $uploadDir . $newFileName;

            if (move_uploaded_file($fileTmpPath, $uploadPath)) {
                $gambar = $newFileName;
            } else {
                echo "Error uploading the file.";
                exit();
            }
        } else {
            echo "Invalid file type. Only JPG, JPEG, PNG, and GIF files are allowed.";
            exit();
        }
    } else {
        $gambar = null; // No file uploaded, retain existing image
    }

    // Prepare SQL query to update Biodata table
    $query = "UPDATE Biodata SET telpon = ?, alamat = ?, fakultas = ?, jurusan = ?, semester = ?, dosbing = ?";
    $params = [$telpon, $alamat, $fakultas, $jurusan, $semester, $dosbing];

    if ($gambar) {
        $query .= ", gambar = ?";
        $params[] = $gambar;
    }

    $query .= " WHERE Nim = ?";
    $params[] = $nim;

    $stmt = $conn->prepare($query);
    $stmt->bind_param(str_repeat("s", count($params) - 1) . "s", ...$params);

    if ($stmt->execute()) {
        echo "Profile updated successfully.";
        header("Location: ../profil.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: ../profil.php");
    exit();
}
?>
