<?php
session_start();
if (isset($_SESSION['id'])) {
    $host = "localhost";
    $port = 3308;
    $dbUsername = "root";
    $dbPass = "";
    $dbName = "MONITA";

    $conn = new mysqli($host, $dbUsername, $dbPass, $dbName, $port);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch unverified students
    $query = "SELECT Nim, Username, verif FROM mahasiswa WHERE verif = 0";
    $res = $conn->query($query);

    if (!$res) {
        die("Query failed: " . $conn->error);
    }
    ?>

    <!DOCTYPE html>
    <html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin</title>
        <link rel="stylesheet" href="styles/pages/admin.css">
    </head>
    <body>
        <div class="wrapper">
            <nav class="menu">
                <ul>
                    <li>Dashboard</li>
                    <li>Mahasiswa</li>
                    <li>Dosen</li>
                    <li>Settings</li>
                </ul>
            </nav>
            <div class="content">
                <header>
                    <h1>Monitoring Tugas Akhir Mahasiswa</h1>
                </header>
                <main>
                    <table>
                        <thead>
                            <tr>
                                <th>NIM</th>
                                <th>Nama Mahasiswa</th>
                                <th>Status Verifikasi</th>
                                <th>Tindakan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($res->num_rows > 0): ?>
                                <?php while ($row = $res->fetch_assoc()): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($row['Nim']); ?></td>
                                        <td><?php echo htmlspecialchars($row['Username']); ?></td>
                                        <td><?php echo $row['verif'] == 0 ? "Belum Verifikasi" : "Terverifikasi"; ?></td>
                                        <td>
                                            <button onclick="updateVerification('<?php echo $row['Nim']; ?>', 'acc')">Acc</button>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4">Tidak ada mahasiswa yang perlu diverifikasi.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </main>
                <h1>ADD DOSEN</h1>
            </div>
        </div>


        
        <script>
            function updateVerification(nim, action) {
                const xhr = new XMLHttpRequest();
                xhr.open("POST", "database/verif.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        const response = JSON.parse(xhr.responseText);
                        if (response.success) {
                            document.getElementById(`status-${nim}`).innerText = "Terverifikasi";
                            document.getElementById(`row-${nim}`).style.backgroundColor = "#d4edda"; // Optional: highlight the row
                        } else {
                            alert(response.message);
                        }
                    }
                };
                xhr.send(`nim=${nim}&action=${action}`);
            }
        </script>

    </body>
    </html>

    <?php
    $conn->close();
} else {
    header("Location: ../TA-RPL/login.php");
    exit;
}
?>
