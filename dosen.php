

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
    $showRevisiForm = isset($_GET['revisi-form']);
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
    <style>
        * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    text-align: center;
    font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
    color: rgb(0, 0, 0);
}
header {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    padding: 20px 100px;
    background-color: transparent;
    display: flex;
    justify-content: space-between;
    align-items: center;
    z-index: 99;
    font-weight: 30px;
    background-color: rgba(0, 0, 0, 0.778);  
}

.profil {
    position: absolute; /* Allow precise positioning */
    top: 20px; /* Adjust the vertical position */
    right: 20px; /* Adjust the horizontal position */
    color: white; /* Ensure the text/icon is visible */
    font-size: 1.5em; /* Adjust the size if necessary */
    text-decoration: none; /* Remove underline from the link */
    z-index: 100; /* Ensure it appears above other elements */
}
.navigasi-mm{
    position: relative;
    font-size: 1.1em;
    color: white;
    text-decoration: none;
    font-size: 500;
    font-weight: 500;
    margin-left: 40px;
    text-decoration: none;
}
.navigasi-mm a{
    position: relative;
    font-size: 1.1em;
    color: white;
    text-decoration: none;
    font-size: 500;
    font-weight: 500;
    margin-left: 90px;
    text-decoration: none;
}
body{
    background: #eae9e9;
}
.container .content{
    position: relative;
    margin-top: 10vh;
    min-height: 90vh;
}
.container .content .cards{
    padding: 20px 15px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
}
.container .content .cards .card{
    width: 250px;
    height: 150px;
    background: rgb(255, 255, 255);
    margin: 20px 10px;
    display: flex;
    align-items: center;
    justify-content: space-around;
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19)
}
h3{
    color: #999;
}
.container .content .content-2{
    min-height: 60vh;
    display: flex;
    justify-content: space-around;
    align-items: flex-start;
    flex-wrap: wrap;
}
.container .content .content-2 .recent-update{
    min-height: 50vh;
    flex: 5;
    background: rgb(255, 255, 255);
    margin: 0 25px 25px 25px;
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
    display: flex;
    flex-direction: column;
}
.container .content .content-2 .new-students{
    flex: 2;
    background: rgb(255, 255, 255);
    min-height: 50vh;
    margin: 0 25px;
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
    display: flex;
    flex-direction: column;
}
.title{
    display: flex;
    align-items: center;
    justify-content: space-around;
    padding: 15px 10px;
    border-bottom: 2px solid #999;
}
table{
    padding: 10px;
}
th,td{
    text-align: left;
    padding: 8px;
}
.aksi{
    padding: 20px;
    border: none;
}


/* Forms */
.sub-revisi,
.sub-meet {
    display: inline-block;
    padding: 20px;
    margin: 10px;
    border-radius: 20px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.sub-revisi {
    background-color: pink;
    color: rgb(236, 142, 142);
    width: 400px;
    height: auto;
    
    display: none; /* Hide the form initially */
    position: fixed;
    top: -100%; /* Place it above the viewport */
    left: 50%;
    transform: translateX(-50%);
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: top 0.5s ease-in-out; /* Smooth sliding effect */
    z-index: 1000;
}
.sub-revisi.show {
    display: block;
    top: 20%; /* Adjust as needed to position the form in view */
}
.sub-meet {
    background-color: rgb(193, 224, 250);
    color: rgb(142, 195, 236);
    width: 400px;
    height: auto;

    display: none; /* Hide the form initially */
    position: fixed;
    top: -100%; /* Place it above the viewport */
    left: 50%;
    transform: translateX(-50%);
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: top 0.5s ease-in-out; /* Smooth sliding effect */
    z-index: 1000;
}

.sub-meet.show {
    display: block;
    top: 20%; /* Adjust as needed to position the form in view */
}

.sub-revisi h1,
.sub-meet h1 {
    font-size: 1.5rem;
    margin-bottom: 20px;
    text-align: center;
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
    font-size: 14px;
    color: #333;
}

.form-group input[type="text"],
.form-group input[type="date"],
.form-group input[type="file"],
.form-group select {
    width: calc(100% - 20px);
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    margin-bottom: 10px;
    font-size: 14px;
    box-sizing: border-box;
}

.upload-area {
    border: 2px dashed #ccc;
    border-radius: 10px;
    padding: 20px;
    text-align: center;
}

.upload-area img {
    width: 50px;
    margin-bottom: 10px;
}

.upload-area p {
    font-size: 14px;
    color: #666;
}

button {
    background-color: #007bff;
   
    border: none;
    border-radius: 5px;
    font-size: 14px;
    cursor: pointer;
}

button:hover {
    background-color: #0056b3;
}
    </style>
</head>
</body>
    
 
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

        <div class="sub-revisi <?php echo $showRevisiForm ? 'show' : ''; ?>">
            
            <h1>FORM REVISI</h1>
            <form action="database/revisi.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <input type="hidden" name="nim" value="<?php echo htmlspecialchars($update['NIM_MHS']); ?>">
                    <label for="judul-ta">Judul TA</label>
                    <input type="text" id="judul-ta" name="judul-ta" placeholder="Masukkan judul Tugas Akhir Anda" required>

                    <label for="desc-ta">Deskripsi</label>
                    <textarea id="desc-ta" name="desc-ta" placeholder="Masukkan Deskripsi Tugas Anda" required></textarea>

                    <div class="upload-area">
                        <input type="file" id="file-upload" name="file-upload" accept=".pdf" required>
                        <label for="file-upload">Upload File</label>
                    </div>

                    <button type="submit">Submit</button>
                   
                </div>
            </form>
        </div>

        <!-- Form Meeting -->
        <div class="sub-meet">
            <h1>FORM MEETING</h1>
            <form action="database/meet.php" method="POST">
                <div class="form-group">
                    <label for="tanggal">Pilih Tanggal Bimbingan</label>
                    <input type="date" id="tanggal" name="tanggal" required>

                    <label for="msg">Pesan</label>
                    <textarea id="msg" name="msg" placeholder="Tambahkan pesan..."></textarea>

                    <button type="submit">Kirim Permintaan</button>
                </div>
            </form>
        </div>
        </div>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const revisiButton = document.querySelectorAll("button[value='Revisi']");
            const meetButton = document.querySelectorAll("button[value='Meet']");
            const revisiForm = document.querySelector(".sub-revisi");
            const meetForm = document.querySelector(".sub-meet");

            revisiButton.forEach((button) => {
                button.addEventListener("click", (e) => {
                    revisiForm.classList.toggle("show");
                });
            });

            meetButton.forEach((button) => {
                button.addEventListener("click", (e) => {
                    meetForm.classList.toggle("show");
                });
            });
    });

    </script>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

   
</body>
</html>



