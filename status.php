<?php
include 'db.php'; 

// Ambil data dari database dengan prepared statement
$sql = "SELECT Progress, file_tugas_akhir, keterangan_status, tanggal_update FROM status_tugas_akhir";
$stmt = $conn->prepare($sql);
$stmt->execute();

// Ambil hasil query
$result = $stmt->get_result();

// Periksa apakah ada data atau tidak
if ($result === false) {
    die("Error: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Monitoring Tugas Akhir</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Status Monitoring Tugas Akhir</h1>
        <table>
            <thead>
                <tr>
                    <th>Progress</th>
                    <th>File Tugas Akhir</th>
                    <th>Status</th>
                    <th>Tanggal Update</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['Progress'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td>
                                <a href="<?= htmlspecialchars($row['file_tugas_akhir'], ENT_QUOTES, 'UTF-8') ?>" target="_blank">Lihat File</a>
                            </td>
                            <td><?= htmlspecialchars($row['keterangan_status'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td><?= htmlspecialchars($row['tanggal_update'], ENT_QUOTES, 'UTF-8') ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4">Tidak ada data.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <a href="add.php" class="btn">Tambah Data</a>
    </div>
</body>
</html>

<?php
// Tutup koneksi
$stmt->close();
$conn->close();
?>
