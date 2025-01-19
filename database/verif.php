<?php
session_start();
if (isset($_SESSION['id'])) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nim = $_POST['nim'] ?? '';
        $action = $_POST['action'] ?? '';

        if ($action === 'acc' && !empty($nim)) {
            $host = "localhost";
            $port = 3308;
            $dbUsername = "root";
            $dbPass = "";
            $dbName = "MONITA";

            $conn = new mysqli($host, $dbUsername, $dbPass, $dbName, $port);

            if ($conn->connect_error) {
                echo json_encode(['success' => false, 'message' => 'Database connection failed.']);
                exit;
            }

            $query = "UPDATE mahasiswa SET verif = 1 WHERE Nim = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("s", $nim);

            if ($stmt->execute()) {
                echo json_encode(['success' => true, 'message' => 'Verification updated successfully.']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to update verification.']);
            }

            $stmt->close();
            $conn->close();
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid request parameters.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Unauthorized access.']);
}
?>
