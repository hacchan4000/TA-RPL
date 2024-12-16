

<?php
session_start();
if (isset($_SESSION['Username']) && isset($_SESSION['Nim'])) {
    $nim = $_SESSION['Nim'];
    
    // Database connection
    $host = "localhost";
    $port = 3308;
    $dbUsername = "root";
    $dbPass = "";
    $dbName = "MONITA";

    $conn = new mysqli($host, $dbUsername, $dbPass, $dbName, $port);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch notifications for the user
    $notifQuery = "SELECT message, source, timestamp FROM Notifications WHERE nim = ? ORDER BY timestamp DESC";
    $notifStmt = $conn->prepare($notifQuery);
    $notifStmt->bind_param("s", $nim);
    $notifStmt->execute();
    $result = $notifStmt->get_result();

    $notifications = [];
    while ($row = $result->fetch_assoc()) {
        $notifications[] = $row;
    }

    $notifStmt->close();
    $conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifications</title>
    <link rel="stylesheet" href="styles/pages/notif.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap-theme.min.css">
</head>
<body>
    <header class="main-header">
        <nav class="navigation">
            <a href="pengumpulan.html">PENGUMPULAN TA</a>
            <a href="status.html">STATUS TA</a>
            <a href="main-menu.php">HOME</a>
        </nav>
        <a class="profile" href="profil.php"><ion-icon name="person-circle-outline"></ion-icon></a>
    </header>

    <div class="main-content">
        <div class="page-header">
            <h1 class="title">NOTIFICATIONS</h1>
        </div>
        <div class="table-header">
            <h5>Timestamp</h5>
            <h5>Source</h5>
            <h5>Description</h5>
            <h5>Events</h5>
        </div>

        <div class="elemen-utama">
            <?php foreach ($notifications as $notif): ?>
                <div class="time" style="transform: translateY(70px); margin-left: 80px;">
                    <p>Time: <?php echo htmlspecialchars($notif['timestamp']); ?></p>
                </div>
                <div class="notifications-container">

                    <!-- Notification: Pending -->
                    <div class="notification notification-<?php echo strtolower($notif['message']); ?>">
                        <?php if ($notif['message'] === "submitted"): ?>
                            <img src="gambar/icons/tennis.png" alt="Icon" class="notif-icon">
                            <div class="notif-info">
                                <p>Submitted by:</p>
                                <p><?php echo htmlspecialchars($notif['source']); ?></p>
                            </div>
                            <div class="notif-message">
                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Rem iste dignissimos veritatis sint. Corporis ipsum odit.</p>
                            </div>
                            <div class="notif-event reviewing">
                        
                                <h2 style="font-weight: bold;">REVIEWING</h2>
                                <h6>The assignment you submitted is under review.</h6>
                            </div>
                            <img src="gambar/icons/ledger.png" alt="Ledger Icon" class="notif-status-icon">
                        <?php elseif ($notif['message'] === "approved"): ?>
                            <img src="gambar/icons/tennis.png" alt="Icon" class="notif-icon">
                        
                            <div class="notif-info">
                                <p>Approved by:</p>
                                <p>I Wayan Supriana, S.Si., M.Cs.</p>
                            </div>
                            <div class="notif-message">
                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Rem iste dignissimos veritatis sint. Corporis ipsum odit.</p>
                            </div>
                            <div class="notif-event resolved">
                                <h2 style="font-weight: bold;">RESOLVED</h2>
                                <h6 style="margin-right: 5px;">Congratulations, your assignment has been accepted, Proceed.</h6>
                            </div>
                            <img src="gambar/icons/white_check_mark.png" alt="Check Icon" class="notif-status-icon">
                        <?php elseif ($notif['message'] === "revision"): ?>
                            <img src="gambar/icons/tennis.png" alt="Icon" class="notif-icon">
                            <div class="notif-info">
                                <p>Reviewed by:</p>
                                <p>I Wayan Supriana, S.Si., M.Cs.</p>
                            </div>
                            <div class="notif-message">
                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Rem iste dignissimos veritatis sint. Corporis ipsum odit.</p>
                            </div>
                            <div class="notif-event revision">
                                <h2 style="font-weight: bold;">REVISION</h2>
                                <h6>Your assignment requires revisions.</h6>
                            </div>
                            <img src="gambar/icons/anger.png" alt="Anger Icon" class="notif-status-icon">
                        <?php elseif ($notif['message'] === "meeting"): ?>
                            <img src="gambar/icons/tennis.png" alt="Icon" class="notif-icon">
                            <div class="notif-info">
                                <p>Submitted by:</p>
                                <p><?php echo htmlspecialchars($notif['source']); ?></p>
                            </div>
                            <div class="notif-message">
                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Rem iste dignissimos veritatis sint. Corporis ipsum odit.</p>
                            </div>
                            <div class="notif-event reminder">
                                <h2 style="font-weight: bold;">REMINDER</h2>
                                <h6>You have a scheduled meeting with your lecturer.</h6>
                            </div>
                            <img src="gambar/icons/necktie.png" alt="Necktie Icon" class="notif-status-icon">
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
       
    </div>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>

<?php  } else {
    header("Location: ../TA-RPL/login.php");
    //header("Location: ../main-menu.php");
    exit;
}