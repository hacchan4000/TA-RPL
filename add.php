<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $progress = isset($_POST['progress']) ? trim($_POST['progress']) : '';
    $file_tugas_akhir = isset($_POST['file_tugas_akhir']) ? trim($_POST['file_tugas_akhir']) : '';
    $keterangan_status = isset($_POST['keterangan_status']) ? trim($_POST['keterangan_status']) : '';
    $tanggal_update = date('Y-m-d H:i:s'); // Menyimpan waktu saat ini

    // Validasi input
    if (empty($progress) || empty($file_tugas_akhir) || empty($keterangan_status)) {
        echo "Semua kolom harus diisi!";
    } else {
        // Query untuk menyimpan data ke database
        $stmt = $conn->prepare("INSERT INTO status_tugas_akhir (Progress, file_tugas_akhir, keterangan_status, tanggal_update) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $progress, $file_tugas_akhir, $keterangan_status, $tanggal_update);

        if ($stmt->execute()) {
            echo "Data berhasil disimpan.";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }
}

$conn->close();
?>
