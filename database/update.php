
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

    // Section 1: Update Profile Information
    if (isset($_POST['telpon']) || isset($_POST['alamat']) || isset($_POST['fakultas']) || isset($_POST['jurusan']) || isset($_POST['semester']) || isset($_POST['dosbing'])) {
        $telpon = $conn->real_escape_string($_POST['telpon'] ?? '');
        $alamat = $conn->real_escape_string($_POST['alamat'] ?? '');
        $fakultas = $conn->real_escape_string($_POST['fakultas'] ?? '');
        $jurusan = $conn->real_escape_string($_POST['jurusan'] ?? '');
        $semester = (int) ($_POST['semester'] ?? 0);
        $dosbing = $conn->real_escape_string($_POST['dosbing'] ?? '');

        $query = "UPDATE Biodata 
                  SET telpon = ?, alamat = ?, fakultas = ?, jurusan = ?, semester = ?, dosbing = ? 
                  WHERE Nim = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssssiss", $telpon, $alamat, $fakultas, $jurusan, $semester, $dosbing, $nim);

        if ($stmt->execute()) {
            echo "Profile information updated successfully.";
        } else {
            echo "Error updating profile information: " . $stmt->error;
        }
        $stmt->close();
    }

    // Section 2: Update Profile Picture
    if (isset($_FILES['pfp']) && $_FILES['pfp']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['pfp']['tmp_name'];
        $fileName = basename($_FILES['pfp']['name']);
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($fileExtension, $allowedExtensions)) {
            $newFileName = $nim . "_profile." . $fileExtension;
            $uploadPath = '/Applications/XAMPP/xamppfiles/htdocs/TA-RPL/gambar/foto-pfp/' . $newFileName;

            if (move_uploaded_file($fileTmpPath, $uploadPath)) {
                $query = "UPDATE Biodata SET gambar = ? WHERE Nim = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("ss", $newFileName, $nim);

                if ($stmt->execute()) {
                    
                    header("Location: ../profil.php");
                } else {
                    echo "Error updating profile picture: " . $stmt->error;
                }
                $stmt->close();
            } else {
                echo "Error uploading the profile picture.";
                exit();
            }
        } else {
            echo "Invalid file type for profile picture. Only JPG, JPEG, PNG, and GIF files are allowed.";
            exit();
        }
    }

    // Section 3: Update Verification Files
    $uploadDir = '/Applications/XAMPP/xamppfiles/htdocs/TA-RPL/verif/';
    $verifFiles = ['verif1' => null, 'verif2' => null, 'verif3' => null];

    foreach ($verifFiles as $key => &$filePath) {
        if (isset($_FILES[$key]) && $_FILES[$key]['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES[$key]['tmp_name'];
            $fileName = basename($_FILES[$key]['name']);
            $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'pdf'];

            if (in_array($fileExtension, $allowedExtensions)) {
                $newFileName = $nim . "_{$key}." . $fileExtension;
                $uploadPath = $uploadDir . $newFileName;

                if (move_uploaded_file($fileTmpPath, $uploadPath)) {
                    $filePath = $newFileName;
                } else {
                    echo "Error uploading $key.";
                    exit();
                }
            } else {
                echo "Invalid file type for $key. Only JPG, JPEG, PNG, and PDF files are allowed.";
                exit();
            }
        }
    }

    $query = "UPDATE Biodata SET veriffikasi1 = ?, veriffikasi2 = ?, veriffikasi3 = ? WHERE Nim = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssss", $verifFiles['verif1'], $verifFiles['verif2'], $verifFiles['verif3'], $nim);

    if ($stmt->execute()) {
        echo "Verification files updated successfully.";
    } else {
        echo "Error updating verification files: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
    header("Location: ../profil.php");
    exit();
} else {
    header("Location: ../profil.php");
    exit();
}
