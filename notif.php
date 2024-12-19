

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
    <style>
        /* Global Styles */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
   
}

/* Header Styles */
.main-header {
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
.navigation{
    position: relative;
    font-size: 1.1em;
    color: white;
    text-decoration: none;
    font-size: 500;
    font-weight: 500;
    margin-left: 40px;
    text-decoration: none;
}
.navigation a {
    position: relative;
    font-size: 1.1em;
    color: white;
    text-decoration: none;
    font-size: 500;
    font-weight: 500;
    margin-left: 90px;
    text-decoration: none;
}

.profile {
    color: white;
    font-size: 1.5em;
}

/* Page Header */
.page-header {
    text-align: center;
    font-size: 2.5rem;
    margin: 50px 0 20px;
    color: black;
    padding-top: 50px;
}

/* Table Header */
.table-header {
    display: flex;
    justify-content: space-between;
    margin: 20px;
    background-color: #f5f5f5;
    padding: 10px;
    border-radius: 5px;
}

.title{
    display: flex;
    justify-content: center;
 
    margin-bottom: 10px;
    color: black;
    font-size: 130px;
    font-weight: bold;
    text-align: left; /* Aligns the text to the left */
}
.table-header h5 {
    flex: 1;
    text-align: center;
    font-weight: bold;
}

/* Notifications */
.notifications-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 20px;
    margin-top: 20px;
    transform: translateX(200px);
}

.notification {
    display: flex;
    align-items: center;
    justify-content: space-between;
    width: 900px;
    height: 100px;
    border-radius: 15px;
    padding: 10px 20px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.notification img.notif-icon {
    width: 80px;
    height: 80px;
}

.notification .notif-info {
    flex: 1;
    font-weight: bold;
    margin: 0 10px;
}

.notification .notif-message {
    flex: 2;
    margin: 0 20px;
}

.notification .notif-event {
    flex: 1;
    text-align: right;
}

.notification img.notif-status-icon {
    width: 90px;
    height: 90px;
}

.notification {
    border: 1px solid #ccc;
    padding: 20px;
    margin: 10px 0;
    border-radius: 5px;
}
.notification-pending {
    background-color: #fff9c4;
}
.notification-revision {
    background-color: #ffccbc;
}
.notification-approval {
    background-color: #c8e6c9;
}
.notification-meeting {
    background-color: #bbdefb;
}


/* Notification Types */
.notification-approval {
    background-color: rgb(215, 247, 215);
    border: 2px solid rgb(142, 236, 142);
}

.notification-revision {
    background-color: rgb(247, 215, 215);
    border: 2px solid rgb(236, 142, 142);
}

.notification .notification-pending {
    background-color: rgb(250, 242, 193);
    border: 2px solid rgb(236, 206, 142);
}

.notification-meeting {
    background-color: rgb(193, 224, 250);
    border: 2px solid rgb(142, 195, 236);
}

/* Event Styles */
.resolved {
    color: green;
}

.revision {
    color: red;
}

.reviewing {
    color: orange;
}

.reminder {
    color: rgb(0, 179, 255);
}
h2{
    font-weight: bold;
}

    </style>
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