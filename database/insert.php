<?php
// Code to handle user sign-up and insert data into multiple tables

$username = $_POST['username'];
$nim = $_POST['NIM'];
$email = $_POST['Email'];
$pass = $_POST['password'];

// Ensure no field is empty
if (!empty($username) && !empty($nim) && !empty($email) && !empty($pass)) {
    // Database connection parameters
    $host = "localhost";
    $port = 3308;
    $dbUsername = "root";
    $dbPass = "";
    $dbName = "MONITA";

    // Establish connection to the database
    $conn = new mysqli($host, $dbUsername, $dbPass, $dbName, $port);

    if ($conn->connect_error) { // Check for connection error
        die("Connection failed: " . $conn->connect_error);
    } else {
        // Hash the password for security
        $pass = password_hash($pass, PASSWORD_DEFAULT);

        // Queries
        $SELECT = "SELECT Nim FROM mahasiswa WHERE Nim = ? LIMIT 1";
        $INSERT1 = "INSERT INTO mahasiswa (Username, Nim, Email, Pass, verif) VALUES (?, ?, ?, ?, 0)";
        $INSERT2 = "INSERT INTO Biodata (Nim, gambar, telpon, alamat, veriffikasi1, veriffikasi2, veriffikasi3, fakultas, jurusan, semester, dosbing) 
                    VALUES (?, '', '...', '...', '', '', '', '...', '...', 0, '...')";
        $INSERT3 = "INSERT INTO Progress (NIM_MHS, waktu, file_path, progressAwal, BAB1, BAB2, BAB3, BAB4, BAB5, Akhir) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        // Check if the NIM already exists
        $stmt = $conn->prepare($SELECT);
        $stmt->bind_param("s", $nim);
        $stmt->execute();
        $stmt->bind_result($nim);
        $stmt->store_result();
        $rnum = $stmt->num_rows;
        $stmt->close();

        if ($rnum == 0) { // If NIM does not exist, proceed with insertion
            // Insert into `mahasiswa` table
            $stmt = $conn->prepare($INSERT1);
            $stmt->bind_param("ssss", $username, $nim, $email, $pass);
            if (!$stmt->execute()) {
                die("Error inserting into mahasiswa: " . $stmt->error);
            }
            $stmt->close();

            // Insert into `Biodata` table
            $stmt = $conn->prepare($INSERT2);
            $stmt->bind_param("s", $nim);
            if (!$stmt->execute()) {
                die("Error inserting into Biodata: " . $stmt->error);
            }
            $stmt->close();

            // Insert into `Progress` table
            $currentDateTime = date("Y-m-d H:i:s"); // Current date and time
            $emptyBlob = ""; // Placeholder for BLOB columns

            $stmt = $conn->prepare($INSERT3);
            $stmt->bind_param(
                "ssssssssss",
                $nim,
                $currentDateTime,
                $emptyBlob, // file_path
                $emptyBlob, // progressAwal
                $emptyBlob, // BAB1
                $emptyBlob, // BAB2
                $emptyBlob, // BAB3
                $emptyBlob, // BAB4
                $emptyBlob, // BAB5
                $emptyBlob  // Akhir
            );
            if (!$stmt->execute()) {
                die("Error inserting into Progress: " . $stmt->error);
            }
            $stmt->close();

            // Redirect to login page with a success message
            $berhasil = "Sign Up berhasil, Silahkan login";
            header("Location: ../login.php?error=$berhasil");
        } else {
            // If NIM already exists, redirect with an error message
            $terdaftar = "Nim tersebut sudah terdaftar";
            header("Location: ../login.php?error=$terdaftar");
        }

        // Close database connection
        $conn->close();
    }
} else {
    echo "Data belum lengkap";
    die();
}
?>
