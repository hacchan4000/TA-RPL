

<?php 
session_start(); // Start the session

// Check if session variables are set (i.e., the user has logged in)
if (isset($_SESSION['Nidn'])) {
    $NIDN = $_SESSION['Nidn']; // Use the session variable

    // You can now remove the part where you are fetching NIDN from POST
    // and directly use $NIDN for further queries
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

    // Fetching NIMs associated with the lecturer (NIDN)
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

    // Fetching students data
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

    // Fetching recent updates from Progress table
    $recentUpdate = [];
    if (!empty($nimList)) {
        $query3 = "SELECT * FROM Progress WHERE NIM_MHS IN ($nimListStr)";
        $result3 = $conn->query($query3);
        if ($result3->num_rows > 0) {
            while ($baris = $result3->fetch_assoc()) {
                // Only include columns that are not empty strings
                $recentUpdate[] = array_filter($baris, function($value) {
                    return !empty($value); // Filter out empty values
                });
            }
        }
    }

    $conn->close();
} else {
    die("You are not logged in. Please log in first.");
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

                    <?php if (!empty($recentUpdate)): ?>
                    <table>
                        <tr>
                            <th>Nama</th>
                            <th>NIM</th>
                            <th>Status</th>
                            <th>Keterangan</th>
                            <th>Action</th>
                        </tr>
                        <?php $Columns = ['proposal', 'progressAwal', 'BAB1', 'BAB2', 'BAB3', 'BAB4', 'BAB5'];
                        foreach ($recentUpdate as $update): 
                        ?>
                            <tr>
                                <td><?php echo htmlspecialchars($students['Nama'] ?? 'N/A'); ?></td>
                                <td><?php echo htmlspecialchars($update['NIM_MHS'] ?? 'N/A'); ?></td>
                                <td><?php echo !empty($update['proposal']) ? 'Updated' : 'No Update'; ?></td>
                                
                                <td>
                                <form method="POST" action="database/action.php">
                                    <select name="progress" required>
                                        <option value="proposal">Proposal</option>
                                        <option value="progressAwal">Progres Awal</option>
                                        <option value="BAB1">BAB I</option>
                                        <option value="BAB2">BAB II</option>
                                        <option value="BAB3">BAB III</option>
                                        <option value="BAB4">BAB IV</option>
                                        <option value="BAB5">BAB V</option>
                                    </select>
                            </td>
                            <td>
                                    <input type="hidden" name="nim" value="<?php echo htmlspecialchars($update['NIM_MHS']); ?>">
                                    <button type="submit" name="action" value="Review" class="aksi" style="background-color: rgb(250, 242, 193); border: 2px solid rgb(236, 206, 142); padding: 10px; border-radius: 10px;" >Review</button>
                                    <button type="submit" name="action" value="Accept" class="aksi" style="background-color: rgb(215, 247, 215); border: 2px solid rgb(142, 236, 142); padding: 10px; border-radius: 10px;">Accept</button>
                                    <button type="submit" name="action" value="Revisi" class="aksi" style="background-color: rgb(247, 215, 215); border: 2px solid rgb(236, 142, 142); padding: 10px; border-radius: 10px;" onclick="">Revisi</button>
                                    <button type="submit" name="action" value="Meet" class="aksi" style="background-color: rgb(193, 224, 250); border: 2px solid rgb(142, 195, 236); padding: 10px; border-radius: 10px;" onclick="window.open('jadwal-bimbingan.html', '_blank');">Meet</button>
                                </form>
                            </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                    <?php else: ?>
                        <p>No recent updates available.</p>
                    <?php endif; ?>
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

        <div class="sub-revisi" style="width: 500px; height: 400px; background-color: pink; border-radius: 20px;">
            
        </div>
        <div class="sub-meet">

        </div>
        </div>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

   
</body>
</html>
