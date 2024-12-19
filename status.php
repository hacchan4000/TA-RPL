

<?php
session_start();
if (isset($_SESSION['Username']) && isset($_SESSION['Nim'])) {
    $nim = $_SESSION['Nim'];

    // Database configuration
    $host = "localhost";
    $port = 3308;
    $dbUsername = "root";
    $dbPass = "";
    $dbName = "MONITA";

    // Connect to the database
    $conn = new mysqli($host, $dbUsername, $dbPass, $dbName, $port);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch data from Revisi table for the logged-in user
    $query = "SELECT id, file_revisi, pesan FROM Revisi WHERE Nim = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $nim);
    $stmt->execute();
    $result = $stmt->get_result();

    // Close the statement if no data is retrieved
    if ($result->num_rows === 0) {
        $dataAvailable = false;
    } else {
        $dataAvailable = true;
    }

    $stmt->close();
    $conn->close();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Tugas Akhir</title>
    <link rel="stylesheet" href="styles/pages/status.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
</head>
<body>
    <header> 
        <nav class="navigasi-mm">
            <a href="pengumpulan.html">PENGUMPULAN TA</a>
            <a href="main-menu.php">HOME</a>
            <a href="notif.php">NOTIFICATION</a>
        </nav>
        <a class="profil" href="profil.php"><ion-icon name="person-circle-outline"></ion-icon></a>
    </header>

    <div class="container">
        <h1 style="font-weight: bold;">Status Tugas Akhir</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>File Revisi</th>
                    <th>Pesan</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($dataAvailable): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['id']); ?></td>
                            <td>
                                <?php if (!empty($row['file_revisi'])): ?>
                                    <a href="file_mahasiswa/<?= htmlspecialchars($row['file_revisi']); ?>" target="_blank">Lihat File</a>
                                <?php else: ?>
                                    Tidak ada file
                                <?php endif; ?>
                            </td>
                            <td><?= htmlspecialchars($row['pesan']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3">Tidak ada data.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>

<?php
} else {
    header("Location: ../TA-RPL/login.php");
    exit;
}
?>
