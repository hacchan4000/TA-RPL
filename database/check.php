<?php
session_start();

//cek poin
if ($_SERVER['REQUEST_METHOD'] === "POST") {
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
            error_log("Connection failed: " . $conn->connect_error);
            die("Internal server error. Please try again later.");
        }

        // Reusable function for login validation
        function checkUser($conn, $query, $param, $role) {
            $stmt = $conn->prepare($query);
            $stmt->bind_param("s", $param);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows == 1) {
                $data = $result->fetch_assoc();
                $storedPassword = $data['Pass'];

                if (password_verify($_POST['myPassword'], $storedPassword)) {
                    session_regenerate_id(true);
                    $_SESSION['role'] = $role;

                    // Set session variables based on user role
                    if ($role === 'student') {
                        //check apakah kolom verif di tabel mahasiswa bernilai 0 
                        if ($data['verif'] == 1) {
                            $_SESSION['Nim'] = $data['Nim'];
                            $_SESSION['Username'] = $data['Username'];
                            header("Location: ../main-menu.php");
                        } else {
                            $_SESSION['Nim'] = $data['Nim'];
                            $_SESSION['Username'] = $data['Username'];
                            header("Location: ../profil.php");
                        }

                    } elseif ($role === 'admin') {
                        $_SESSION['id'] = $data['id'];
                        $_SESSION['Username'] = $data['Username'];
                        header("Location: ../admin.php");
                    }

                    $stmt->close();
                    exit();
                } else {
                    return "Password salah untuk $role.";
                }
            }
            $stmt->close();
            return false; // User not found
        }

        // Check student login
        $errorMessage = checkUser($conn, "SELECT * FROM mahasiswa WHERE Nim = ?", $nim, 'student');
        
        if (!$errorMessage) {
            // Check admin login
            $errorMessage = checkUser($conn, "SELECT * FROM myAdmin WHERE id = ?", $nim, 'admin');
        }

        $conn->close();

        // If no user found
        if ($errorMessage) {
            header("Location: ../login.php?error=" . urlencode($errorMessage));
        } else {
            header("Location: ../login.php?error=" . urlencode("Akun tidak ditemukan."));
        }
        exit();
    } else {
        $errorMessage = "Harap masukkan NIM dan password.";
        header("Location: ../login.php?error=" . urlencode($errorMessage));
        exit();
    }
} else {
    header("Location: ../login.php");
    exit();
}
?>
