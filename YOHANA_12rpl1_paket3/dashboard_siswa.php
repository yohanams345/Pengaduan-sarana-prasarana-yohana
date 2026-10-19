<?php
include 'koneksi.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'siswa') {
    header("Location: login.php?pesan=Silahkan login sebagai Siswa!");
    exit;
}

$id_siswa = $_SESSION['id_siswa'];

if (isset($_POST['kirim_aspirasi'])) {
    $id_kategori  = $_POST['id_kategori'];
    $judul        = mysqli_real_escape_string($koneksi, $_POST['judul']);
    $isi_aspirasi = mysqli_real_escape_string($koneksi, $_POST['isi_aspirasi']);
    $tanggal      = date('Y-m-d');
    $status       = 'Menunggu';

    $query = "INSERT INTO tb_aspirasi (id_siswa, id_kategori, judul, isi_aspirasi, tanggal, status) 
              VALUES ('$id_siswa', '$id_kategori', '$judul', '$isi_aspirasi', '$tanggal', '$status')";
    mysqli_query($koneksi, $query);
    header("Location: dashboard_siswa.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Siswa</title>
</head>
<body>
    <h1>Selamat Datang, <?= $_SESSION['nama_siswa']; ?> (Kelas: <?= $_SESSION['kelas']; ?>)</h1>
    <a href="logout.php" onclick="return confirm('Yakin ingin logout?')">Logout</a>
    <hr>

    <h3>Kirim Aspirasi Baru</h3>
    <form method="POST">
        <p>Kategori Barang/Fasilitas:<br>
            <select name="id_kategori" required>
                <option value="">-- Pilih Kategori --</option>
                <?php
                $kat = mysqli_query($koneksi, "SELECT * FROM tb_kategori WHERE status='Aktif'");
                while ($k = mysqli_fetch_assoc($kat)) {
                    echo "<option value='".$k['id_kategori']."'>".$k['nama_kategori']." (Lokasi: ".$k['lokasi'].")</option>";
                }
                ?>
            </select>
        </p>
        <p>Judul Aspirasi:<br>
            <input type="text" name="judul" required style="width: 300px;">
        </p>
        <p>Isi Aspirasi:<br>
            <textarea name="isi_aspirasi" rows="4" cols="40" required></textarea>
        </p>
        <button type="submit" name="kirim_aspirasi">Kirim Aspirasi</button>
    </form>

    <hr>
    <h3>Riwayat & Status Aspirasi Saya</h3>
    <table border="1" cellpadding="8" cellspacing="0">
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Kategori</th>
            <th>Judul</th>
            <th>Isi Aspirasi</th>
            <th>Status</th>
            <th>Tanggapan Admin</th>
        </tr>
        <?php
        $no = 1;
        $q_asp = "SELECT a.*, k.nama_kategori, i.tanggapan, ad.nama_admin 
                  FROM tb_aspirasi a 
                  JOIN tb_kategori k ON a.id_kategori = k.id_kategori 
                  LEFT JOIN tb_input i ON a.id_aspirasi = i.id_aspirasi 
                  LEFT JOIN tb_admin ad ON i.id_admin = ad.id_admin 
                  WHERE a.id_siswa = '$id_siswa' 
                  ORDER BY a.id_aspirasi DESC";
        $res = mysqli_query($koneksi, $q_asp);

        while ($d = mysqli_fetch_assoc($res)) {
        ?>
        <tr>
            <td><?= $no++; ?></td>
            <td><?= $d['tanggal']; ?></td>
            <td><?= $d['nama_kategori']; ?></td>
            <td><?= $d['judul']; ?></td>
            <td><?= $d['isi_aspirasi']; ?></td>
            <td><b><?= $d['status']; ?></b></td>
            <td>
                <?= $d['tanggapan'] ? $d['tanggapan']." <i>(Oleh: ".$d['nama_admin'].")</i>" : "<i>Belum ada tanggapan</i>"; ?>
            </td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>