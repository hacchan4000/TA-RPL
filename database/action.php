<?php
session_start();

// Check if session variables are set (i.e., the user has logged in)
if (isset($_SESSION['Nidn'])) {
    $NIDN = $_SESSION['Nidn'];

    // Database configuration
    $host = "localhost";
    $port = 3308;
    $dbUsername = "root";
    $dbPass = "";
    $dbName = "MONITA";

    // Connect to the database
    $conn = new mysqli($host, $dbUsername, $dbPass, $dbName, $port);

    if ($conn->connect_error) {
        error_log("Connection failed: " . $conn->connect_error);
        die("Internal server error. Please try again later.");
    }

    // Check if form data is received
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $action = $_POST['action'] ?? '';
        $nim = $conn->real_escape_string($_POST['nim'] ?? '');
        $progressField = $conn->real_escape_string($_POST['progress'] ?? '');

        // Validate inputs
        if (empty($nim) || empty($progressField)) {
            echo "Invalid input. Please go back and try again.";
            exit;
        }

        // Process action
        switch ($action) {
            case 'Review':
                // Query the Progress table for the selected NIM and progress field
                $query = "SELECT $progressField FROM Progress WHERE NIM_MHS = '$nim'";
                $result = $conn->query($query);

                if ($result && $result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $filePath = $row[$progressField] ?? null;

                    if (!empty($filePath)) {
                        echo "<h2>File for $progressField:</h2>";
                        echo "<a href='/Applications/XAMPP/xamppfiles/htdocs/TA-RPL/file_mahasiswa/$filePath' target='_blank'>$filePath</a>";
                    } else {
                        echo "No file available for the selected progress.";
                    }
                } else {
                    echo "No progress record found for the selected NIM.";
                }
                break;

            case 'Accept':
            case 'Revisi':
                
            case 'Meet':
                // Insert notification for action
                $notificationMessage = match ($action) {
                    'Accept' => 'approved',
                    'Revisi' => 'revision',
                    'Meet' => 'meeting',
                    default => '',
                };
                $source = "Assignment Submission";
                $timestamp = date("Y-m-d H:i:s");

                $notifQuery = "INSERT INTO Notifications (nim, message, source, timestamp) VALUES (?, ?, ?, ?)";
                $notifStmt = $conn->prepare($notifQuery);

                if ($notifStmt) {
                    $notifStmt->bind_param("ssss", $nim, $notificationMessage, $source, $timestamp);
                    if ($notifStmt->execute()) {
                        echo ucfirst($action) . " notification sent successfully.";
                    } else {
                        echo "Failed to send notification: " . $notifStmt->error;
                    }
                    $notifStmt->close();
                } else {
                    echo "Failed to prepare notification query: " . $conn->error;
                }
                break;

            default:
                echo "Invalid action.";
                break;
        }
    } else {
        echo "Invalid request method.";
    }

    $conn->close();
} else {
    die("You are not logged in. Please log in first.");
}
?>
