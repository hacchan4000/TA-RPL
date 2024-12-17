

<?php 
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $NIDN = $_POST['myNim'];
    $pass = $_POST['myPassword'];

    if (!empty($NIDN) && !empty($pass)) {
        $host = "localhost"; // Correct hostname
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

        // Prepare statement to retrieve NIMs from Bimbingan table
        $stmt = $conn->prepare("SELECT NIM FROM Bimbingan WHERE NIDN = ?");
        if (!$stmt) {
            error_log("Prepare failed: " . $conn->error);
            die("Query preparation failed.");
        }
        $stmt->bind_param("s", $NIDN);
        $stmt->execute();
        $result = $stmt->get_result();

        // Array to store NIMs
        $nimList = [];
        while ($row = $result->fetch_assoc()) {
            $nimList[] = $row['NIM'];
        }
        $stmt->close();

        // If NIMs found, fetch corresponding Mahasiswa names
        $students = [];
        if (!empty($nimList)) {
            // Create placeholders dynamically
            $placeholders = rtrim(str_repeat('?,', count($nimList)), ',');
            $query = "SELECT Nim, Username AS Nama FROM mahasiswa WHERE Nim IN ($placeholders)";

            $stmt = $conn->prepare($query);
            if (!$stmt) {
                error_log("Prepare failed: " . $conn->error);
                die("Query preparation failed.");
            }

            $types = str_repeat('s', count($nimList)); // 's' for string
            $stmt->bind_param($types, ...$nimList);
            $stmt->execute();
            $result = $stmt->get_result();

            // Store results in an associative array
            while ($row = $result->fetch_assoc()) {
                $students[] = $row;
            }
            $stmt->close();
        }

        $conn->close();
    } else {
        die("NIDN and Password are required.");
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dosen</title>
    <link rel="stylesheet" href="styles/pages/dosen.css">
</head>
</body>
    <header> 
        <nav class="navigasi-mm">
            <a href="jadwal-bimbingan.html">Jadwal Bimbingan</a>
            <a href="notif.html">NOTIFICATION</a>
            <a href="#">CONTACTS</a>
            
        </nav>
       
       
    </header> 
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

    <div class="container">
        <div class="content">
            <div class="cards">
                <div class="card">
                    <div class="box">
                        <h1>21894</h1>
                        <h3>Students</h3>
                    </div>
                    <div class="icon-case">
                        <img src="students.png" alt="">
                    </div>
                </div>
                <div class="card">
                    <div class="box">
                        <h1>21894</h1>
                        <h3>Students</h3>
                    </div>
                    <div class="icon-case">
                        <img src="students.png" alt="">
                    </div>
                </div>
                <div class="card">
                    <div class="box">
                        <h1>21894</h1>
                        <h3>Students</h3>
                    </div>
                    <div class="icon-case">
                        <img src="students.png" alt="">
                    </div>
                </div>
                <div class="card">
                    <div class="box">
                        <h1>21894</h1>
                        <h3>Students</h3>
                    </div>
                    <div class="icon-case">
                        <img src="students.png" alt="">
                    </div>
                </div>
            </div>
            <div class="content-2">
            <div class="recent-update">
                <div class="title">
                    <h2>Recent Updates</h2>
                    <a href="#" class="btn">View All</a>
                </div>
                <table>
                    <tr>
                        <th>Nama</th>
                        <th>NIM</th>
                        <th>Status</th>
                        <th>Keterangan</th>
                    </tr>
                    <tr>
                        <td>John Doe</td>
                        <td>2308561045</td>
                        <td>Updated</td>
                        <td><a href="#" class="btn">View </a></td>
                    </tr>
                    </tr>
                </table>
            </div>
            <div class="new-students">
                <div class="title">
                    <h2>Students</h2>
                    <a href="#" class="btn">View All</a>
                </div>
                <table>
                    <tr>
                        <th>NIM</th>
                        <th>Nama</th>
                    </tr>
                    <?php if (!empty($students)): ?>
                        <?php foreach ($students as $student): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($student['NIM']); ?></td>
                                <td><?php echo htmlspecialchars($student['Nama']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="2">No students found.</td>
                        </tr>
                    <?php endif; ?>
                </table>
</div>

            </div>
        </div>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>
