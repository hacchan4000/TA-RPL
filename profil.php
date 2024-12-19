<?php
session_start();
if (isset($_SESSION['Username']) && isset($_SESSION['Nim'])) {
    $username = $_SESSION['Username'];
    $nim = $_SESSION['Nim'];

    // Database connection
    $host = "localhost";
    $port = 3308; // Use your MySQL port
    $dbUsername = "root";
    $dbPass = "";
    $dbName = "MONITA"; // Your database name

    $conn = new mysqli($host, $dbUsername, $dbPass, $dbName, $port);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Query Biodata table to fetch data for this user
    $stmt = $conn->prepare("SELECT gambar, telpon, alamat, fakultas, jurusan, semester, dosbing FROM Biodata WHERE Nim = ?");
    $stmt->bind_param("s", $nim);
    $stmt->execute();
    $result = $stmt->get_result();

    $stmt2 = $conn->prepare("SELECT verif FROM mahasiswa WHERE Nim = ?");
    $stmt2->bind_param("s", $nim);
    $stmt2->execute();
    $result2 = $stmt2->get_result();

    if ($result2->num_rows > 0) {
        $row2 = $result2->fetch_assoc();
        $verif = $row2['verif'];
    } else {
        $verif = 0; // Default to 0 if no result found
    }

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $gambar = $row['gambar'];
        $telpon = $row['telpon'];
        $alamat = $row['alamat'];
        $fakultas = $row['fakultas'];
        $jurusan = $row['jurusan'];
        $semester = $row['semester'];
        $dosbing = $row['dosbing'];
    } else {
        $gambar = "default.png"; // Use a default image
        $telpon = "N/A";
        $alamat = "N/A";
        $fakultas = "N/A";
        $jurusan = "N/A";
        $semester = "N/A";
        $dosbing = "N/A";
    }
    $stmt->close();

    // Query mahasiswa table to fetch Email for this user
    $stmt = $conn->prepare("SELECT Email FROM mahasiswa WHERE Nim = ?");
    $stmt->bind_param("s", $nim);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $email = $row['Email'];
    } else {
        $email = "N/A"; // Default value if email not found
    }
    $stmt->close();

    $conn->close();

    $profileImagePath = "gambar/foto-pfp/" . htmlspecialchars($gambar, ENT_QUOTES, 'UTF-8');
    if (!file_exists($profileImagePath) || empty($gambar)) {
        $profileImagePath = "/Applications/XAMPP/xamppfiles/htdocs/TA-RPL/gambar/icons/tennis.png";
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="styles/pages/profile.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
</head>
<body>
    <?php if ($verif == 1){ ?>
        <header class="mainHeader"> 
            <nav class="navigasi-mm">
                <a href="pengumpulan.html">PENGUMPULAN TA</a>
                <a href="status.html">STATUS TA</a>
                <a href="main-menu.php">HOME</a>
            </nav>
            <a class="profil" href="login.php"><ion-icon name="log-out-outline"></ion-icon></a>
        </header>
    <?php } ?>

    <div class="main-body">
        <div class="overlay"></div>
        <div class="foto-user">
            <div class="pfp">
                <img src="/Applications/XAMPP/xamppfiles/htdocs/TA-RPL/gambar/foto-pfp/2308561092_profile.png" alt="Profile Picture">
            </div>
           

            <div class="edit">
                <form action="edit-profil.php">
                    <button class="tombol-edit">EDIT PROFIL</button>
                </form>
                
            </div>

            <div class="desc" style="margin-top: 20px; width: 450px;">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Perspiciatis quaerat ullam, assumenda recusandae nihil ex esse, necessitatibus repudiandae explicabo expedita nam quam obcaecati sint quis a in quo voluptas reprehenderit.
            </div>

            <div class="verifikasi">
                <form action="database/update.php" method="POST" enctype="multipart/form-data">
                    <h1 style="font-weight: bold;">VERIFIKASI</h1>
                    untuk mengkases layanan MONITA, mohon penuhi syarat pengajuan proposal TA berikut:
                    <ul>1.⁠ ⁠Telah mengambil dan lulus mata kuliah sebanyak 100 SKS, dengan menyertakan bukti KHS terakhir. </ul>
                    <input type="file" name="verif1" id="verif1">
                    <ul>2.⁠ ⁠Telah mengikuti Workshop Tugas Akhir, dengan menyertakan bukti Sertifikat Workshop Tugas Akhir.</ul>
                    <input type="file"  name="verif2" id="verif2">
                    <ul>3.⁠ ⁠Telah menjual jiwa ke iblis .</ul>
                    <input type="file"  name="verif3" id="verif3">
                    <button style="margin: 10px;">Submit</button>
                </form>
                
            </div>
        </div>
        
        <div class="box-biodata">
            <div class="salam">
                <h1>Hello,</h1>
                <h1 style="font-weight: bold; font-size:60px"><?= htmlspecialchars($username, ENT_QUOTES, 'UTF-8') ?></h1>
            </div>

            <div class="konten">
            <div class="b1">
                <h3> NIM</h3>
                <h5><?= htmlspecialchars($nim, ENT_QUOTES, 'UTF-8') ?></h5>
                <h3> Email</h3>
                <h5><?= htmlspecialchars($email, ENT_QUOTES, 'UTF-8') ?></h5>
                <h3> Telpon</h3>
                <h5><?= htmlspecialchars($telpon, ENT_QUOTES, 'UTF-8') ?></h5>
                <h3> Alamat</h3>
                <h5><?= htmlspecialchars($alamat, ENT_QUOTES, 'UTF-8') ?></h5>
            </div>
                <div class="b2">
                    <h3> Fakultas</h3>
                    <h5><?= htmlspecialchars($fakultas, ENT_QUOTES, 'UTF-8') ?></h5>
                    <h3> Jurusan</h3>
                    <h5><?= htmlspecialchars($jurusan, ENT_QUOTES, 'UTF-8') ?></h5>
                    <h3> Semester</h3>
                    <h5><?= htmlspecialchars($semester, ENT_QUOTES, 'UTF-8') ?></h5>
                    <h3> Dosen Pembimbing</h3>
                    <h5><?= htmlspecialchars($dosbing, ENT_QUOTES, 'UTF-8') ?></h5>
                </div>
            </div>

        </div>
    </div>


    <div class="edit-profile-box" id="editProfileBox">
        <form action="database/update.php" method="POST" enctype="multipart/form-data">
            <h2 style="font-weight : bold;">Edit Profile</h2>
            <div class="form-group">
                <label for="pfp">Profile Picture:</label>
                <input type="file" name="pfp" id="pfp" >
            </div>

            <div class="form-group">
                <label for="nim">NIM:</label>
                <input type="text" name="nim" id="nim" value="<?= htmlspecialchars($nim, ENT_QUOTES, 'UTF-8') ?>">
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="text" name="email" id="email" value="<?= htmlspecialchars($email, ENT_QUOTES, 'UTF-8') ?>">
            </div>

            <div class="form-group">
                <label for="telpon">Telpon:</label>
                <input type="text" name="telpon" id="telpon" >
            </div>

            <div class="form-group">
                <label for="alamat">Alamat:</label>
                <input type="text" name="alamat" id="alamat" >
            </div>

            <div class="form-group">
                <label for="fakultas">Fakultas:</label>
                <input type="text" name="fakultas" id="fakultas" >
            </div>

            <div class="form-group">
                <label for="jurusan">Jurusan:</label>
                <input type="text" name="jurusan" id="jurusan" >
            </div>

            <div class="form-group">
                <label for="semester">Semester:</label>
                <input type="number" name="semester" id="semester" >
            </div>

            <div class="form-group">
                <label for="dosbing">Dosen Pembimbing:</label>
                <input type="text" name="dosbing" id="dosbing" >
            </div>

            <button type="submit" class="btn btn-primary">Save Changes</button>
        </form>
    </div>



    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script>
        document.querySelector(".tombol-edit").addEventListener("click", function (e) {
            e.preventDefault(); // Prevent default button behavior
            const editBox = document.querySelector(".edit-profile-box");
            const overlay = document.querySelector(".overlay");

            // Toggle the visibility of the edit box and overlay
            editBox.classList.toggle("show");
            overlay.classList.toggle("show");
        });

        document.querySelector(".overlay").addEventListener("click", function () {
            // Close the edit box when the overlay is clicked
            document.querySelector(".edit-profile-box").classList.remove("show");
            document.querySelector(".overlay").classList.remove("show");
        });
    </script>
</body>
</html>
<?php
} else {
    header("Location: ../TA-RPL/main-menu.php");
    exit();
}
?>
