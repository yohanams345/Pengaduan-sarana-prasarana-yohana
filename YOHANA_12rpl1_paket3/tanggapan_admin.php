<?php
include 'koneksi.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit;
}

// Simpan atau Update Tanggapan
if (isset($_POST['simpan_tanggapan'])) {
    $id_aspirasi   = $_POST['id_aspirasi'];
    $id_admin      = $_SESSION['id_admin'];
    $tanggapan     = mysqli_real_escape_string($koneksi, $_POST['tanggapan']);
    $status        = $_POST['status'];
    $tanggal_input = date('Y-m-d');

    // Update status di tb_aspirasi
    mysqli_query($koneksi, "UPDATE tb_aspirasi SET status='$status' WHERE id_aspirasi='$id_aspirasi'");

    // Cek apakah tanggapan sudah ada di tb_input
    $cek = mysqli_query($koneksi, "SELECT * FROM tb_input WHERE id_aspirasi='$id_aspirasi'");
    if (mysqli_num_rows($cek) > 0) {
        $q_inp = "UPDATE tb_input SET id_admin='$id_admin', tanggapan='$tanggapan', tanggal_input='$tanggal_input', status='$status' WHERE id_aspirasi='$id_aspirasi'";
    } else {
        $q_inp = "INSERT INTO tb_input (id_aspirasi, id_admin, tanggapan, tanggal_input, status) VALUES ('$id_aspirasi', '$id_admin', '$tanggapan', '$tanggal_input', '$status')";
    }
    mysqli_query($koneksi, $q_inp);
    header("Location: tanggapan_admin.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Kelola Tanggapan Aspirasi</title>
</head>
<body>
    <h2>Kelola Tanggapan Aspirasi Siswa</h2>
    <a href="dashboard_admin.php">Kembali ke Dashboard</a>
    <hr>

    <table border="1" cellpadding="8" cellspacing="0">
        <tr>
            <th>ID</th>
            <th>Nama Siswa</th>
            <th>Tanggal</th>
            <th>Kategori</th>
            <th>Judul</th>
            <th>Isi Aspirasi</th>
            <th>Status</th>
            <th>Tanggapan Sekarang</th>
            <th>Aksi / Form Tanggapan</th>
        </tr>
        <?php
        $query = "SELECT a.*, s.nama_siswa, k.nama_kategori, i.tanggapan 
                  FROM tb_aspirasi a 
                  JOIN tb_siswa s ON a.id_siswa = s.id_siswa 
                  JOIN tb_kategori k ON a.id_kategori = k.id_kategori 
                  LEFT JOIN tb_input i ON a.id_aspirasi = i.id_aspirasi 
                  ORDER BY a.id_aspirasi DESC";
        $data = mysqli_query($koneksi, $query);

        while ($d = mysqli_fetch_assoc($data)) {
        ?>
        <tr>
            <td><?= $d['id_aspirasi']; ?></td>
            <td><?= $d['nama_siswa']; ?></td>
            <td><?= $d['tanggal']; ?></td>
            <td><?= $d['nama_kategori']; ?></td>
            <td><?= $d['judul']; ?></td>
            <td><?= $d['isi_aspirasi']; ?></td>
            <td><b><?= $d['status']; ?></b></td>
            <td><?= $d['tanggapan'] ?? '<i>Belum ada</i>'; ?></td>
            <td>
                <form method="POST">
                    <input type="hidden" name="id_aspirasi" value="<?= $d['id_aspirasi']; ?>">
                    <textarea name="tanggapan" placeholder="Isi tanggapan..." required><?= $d['tanggapan'] ?? ''; ?></textarea><br>
                    Status: 
                    <select name="status">
                        <option value="Menunggu" <?= $d['status'] == 'Menunggu' ? 'selected' : ''; ?>>Menunggu</option>
                        <option value="Diproses" <?= $d['status'] == 'Diproses' ? 'selected' : ''; ?>>Diproses</option>
                        <option value="Selesai" <?= $d['status'] == 'Selesai' ? 'selected' : ''; ?>>Selesai</option>
                    </select>
                    <button type="submit" name="simpan_tanggapan">Simpan</button>
                </form>
            </td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>