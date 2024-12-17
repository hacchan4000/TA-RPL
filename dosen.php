

<?php 
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $NIDN = trim($_POST['myNim']);
    $pass = trim($_POST['myPassword']);

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

        // Debugging NIM retrieval
        $nimList = [];
        $query1 = "SELECT NIM FROM Bimbingan WHERE NIDN = '$NIDN'";
        $result1 = $conn->query($query1);

        if ($result1->num_rows > 0) {
            while ($row = $result1->fetch_assoc()) {
                $nimList[] = $row['NIM'];
            }
            error_log("Retrieved NIMs: " . implode(", ", $nimList));
        } else {
            echo ("No NIMs found for NIDN: $NIDN");
        }

        // Debugging students retrieval
        $students = [];
        if (!empty($nimList)) {
            $nimListStr = "'" . implode("','", $nimList) . "'";
            $query2 = "SELECT Nim, Username AS Nama FROM mahasiswa WHERE Nim IN ($nimListStr)";
            $result2 = $conn->query($query2);

            if ($result2->num_rows > 0) {
                while ($row = $result2->fetch_assoc()) {
                    $students[] = $row;
                }
                error_log("Retrieved students: " . print_r($students, true));
            } else {
                error_log("No students found for NIMs: $nimListStr");
            }
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
                        
                    </div>
                </div>
                <div class="card">
                    <div class="box">
                        <h1>21894</h1>
                        <h3>Students</h3>
                    </div>
                    <div class="icon-case">
                       
                    </div>
                </div>
                <div class="card">
                    <div class="box">
                        <h1>21894</h1>
                        <h3>Students</h3>
                    </div>
                    <div class="icon-case">
                        
                    </div>
                </div>
                <div class="card">
                    <div class="box">
                        <h1>21894</h1>
                        <h3>Students</h3>
                    </div>
                    <div class="icon-case">
                        
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
                                <td><?php echo htmlspecialchars($student['Nim']); ?></td>
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
