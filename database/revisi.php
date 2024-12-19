
<?php
session_start();

if (isset($_SESSION['Nidn'])) {
    $NIDN = $_SESSION['Nidn'];

    $host = "localhost";
    $port = 3308;
    $dbUsername = "root";
    $dbPass = "";
    $dbName = "MONITA";

    // Database connection
    $conn = new mysqli($host, $dbUsername, $dbPass, $dbName, $port);

    if ($conn->connect_error) {
        error_log("Connection failed: " . $conn->connect_error);
        die("Internal server error. Please try again later.");
    }

    // Fetch form data
    $nimMHS = $_POST['nim'];
    $pesan = $_POST['desc-ta'];
    $fileName = $_FILES['file-upload']['name'];
    $fileTmpName = $_FILES['file-upload']['tmp_name'];
    $fileData = file_get_contents($fileTmpName);

    // File upload handling
    $uploadDir = "/Applications/XAMPP/xamppfiles/htdocs/TA-RPL/revisi/";
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $filePath = $uploadDir . basename($fileName);

    if (move_uploaded_file($fileTmpName, $filePath)) {
        // Prepare the SQL query
        $query = "INSERT INTO Revisi (Nim, file_revisi, pesan) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($query);
        
        if ($stmt) {
            
            $stmt->bind_param("sss", $nimMHS, $fileData, $pesan);

            if ($stmt->execute()) {
                header("Location: ../dosen.php");
            } else {
                error_log("Error executing query: " . $stmt->error);
                echo "Failed to submit revisi. Please try again.";
            }

            $stmt->close();
        } else {
            
            error_log("Error preparing statement: " . $conn->error);
            echo "Failed to prepare the request. Please try again.";
        }
    } else {
        error_log("Failed to upload file: " . $fileName);
        echo "Failed to upload file. Please try again.";
    }

    $conn->close();
} else {
    die("You are not logged in. Please log in first.");
}
?>
