<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if user is logged in
    if (!isset($_SESSION['Nim'])) {
        header("Location: ../login.php");
        exit();
    }

    // Get logged-in user's NIM
    $nim = $_SESSION['Nim'];

    // Database connection parameters
    $host = "localhost";
    $port = 3308;
    $dbUsername = "root";
    $dbPass = "";
    $dbName = "MONITA";

    // Establish database connection
    $conn = new mysqli($host, $dbUsername, $dbPass, $dbName, $port);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Retrieve form inputs
    $judul = trim($_POST['judul-ta']);
    $tanggal = trim($_POST['tanggal']);
    $progress = trim($_POST['progress']);  // This will be the column name like 'BAB1', 'BAB2', etc.

    // Validate progress column (ensure it's a valid column name in the database)
    $allowedColumns = ['proposal', 'progressAwal', 'BAB1', 'BAB2', 'BAB3', 'BAB4', 'BAB5'];
    if (!in_array($progress, $allowedColumns, true)) {
        die("Invalid progress type specified.");
    }

    // Validate and handle file upload
    $targetDirectory = '/Applications/XAMPP/xamppfiles/htdocs/TA-RPL/file_mahasiswa/';
    if (!is_dir($targetDirectory)) {
        mkdir($targetDirectory, 0777, true);
    }

    $fileName = basename($_FILES['file-upload']['name']);
    $targetFile = $targetDirectory . $fileName;
    $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Allow only PDF files
    if ($fileType !== 'pdf') {
        echo "Please upload a valid PDF file.";
        exit();
    }

    // Check if the file uploaded correctly
    if ($_FILES['file-upload']['error'] != UPLOAD_ERR_OK) {
        die("File upload error: " . $_FILES['file-upload']['error']);
    }

    // Move uploaded file
    if (!move_uploaded_file($_FILES['file-upload']['tmp_name'], $targetFile)) {
        echo "File upload failed!";
        exit();
    }

    // Check if there's a matching record in the database
    $checkQuery = "SELECT * FROM Progress WHERE NIM_MHS = ?";
    $checkStmt = $conn->prepare($checkQuery);
    $checkStmt->bind_param("s", $nim);
    $checkStmt->execute();
    $result = $checkStmt->get_result();

    if ($result->num_rows == 0) {
        die("No progress record found for NIM: $nim");
    }

    // Dynamic update query
    $UPDATE = "UPDATE Progress 
               SET waktu = ?, $progress = ?, file_path = ? 
               WHERE NIM_MHS = ?";
    // Note: $progress is now being used to select the dynamic column name.

    // Debugging: Log the query and check for execution
    

    $stmt = $conn->prepare($UPDATE);

    if (!$stmt) {
        die("Failed to prepare statement: " . $conn->error);
    }

    // Bind parameters
    if (!$stmt->bind_param("ssss", $tanggal, $fileName, $targetFile, $nim)) {
        die("Failed to bind parameters: " . $stmt->error);
    }

    // Execute the query
    // After successful assignment submission
    if ($stmt->execute()) {
        // Add notification to the database
        $notificationMessage = "submitted";
        $source = "Assignment Submission";
        $timestamp = date("Y-m-d H:i:s"); // Current timestamp
        
        $notifQuery = "INSERT INTO Notifications (nim, message, source, timestamp) VALUES (?, ?, ?, ?)";
        $notifStmt = $conn->prepare($notifQuery);
        $notifStmt->bind_param("ssss", $nim, $notificationMessage, $source, $timestamp);
        $notifStmt->execute();
        $notifStmt->close();
        
        header("Location: ../notif.php");
    } else {
        echo "Error updating progress: " . $stmt->error;
    }

    

    // Close resources
    $stmt->close();
    $checkStmt->close();
    $conn->close();
} else {
    echo "Invalid request method.";
}
?>
