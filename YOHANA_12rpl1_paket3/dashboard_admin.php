<?php
include 'koneksi.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php?pesan=Silahkan login sebagai Admin!");
    exit;
}

// Menghitung statistik
$tot_aspirasi = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM tb_aspirasi"));
$tot_pending  = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM tb_aspirasi WHERE status='Menunggu'"));
$tot_proses   = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM tb_aspirasi WHERE status='Diproses'"));
$tot_selesai  = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM tb_aspirasi WHERE status='Selesai'"));
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Admin</title>
</head>
<body>
    <h1>Selamat Datang, <?= $_SESSION['nama_admin']; ?> (Admin)</h1>
    <p>Level: <?= $_SESSION['level']; ?></p>
    
    <nav>
        <a href="dashboard_admin.php">Dashboard</a> | 
        <a href="kategori.php">Kelola Kategori</a> | 
        <a href="admin.php">Kelola Admin</a> | 
        <a href="tanggapan_admin.php">Kelola Tanggapan & Aspirasi</a> | 
        <a href="logout.php" onclick="return confirm('Yakin ingin logout?')">Logout</a>
    </nav>
    <hr>

    <h3>Statistik Aspirasi</h3>
    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>Total Aspirasi</th>
            <th>Menunggu</th>
            <th>Diproses</th>
            <th>Selesai</th>
        </tr>
        <tr>
            <td align="center"><?= $tot_aspirasi; ?></td>
            <td align="center"><?= $tot_pending; ?></td>
            <td align="center"><?= $tot_proses; ?></td>
            <td align="center"><?= $tot_selesai; ?></td>
        </tr>
    </table>
</body>
</html>