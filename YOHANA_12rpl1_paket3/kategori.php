<?php
include 'koneksi.php';

// Keamanan: Cek apakah user adalah Admin
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php?pesan=Silahkan login sebagai Admin!");
    exit;
}

// ------------------- PROSES SIMPAN (TAMBAH DATA) -------------------
if (isset($_POST['tambah'])) {
    $nama_kategori = mysqli_real_escape_string($koneksi, $_POST['nama_kategori']);
    $keterangan    = mysqli_real_escape_string($koneksi, $_POST['keterangan']);
    $lokasi        = mysqli_real_escape_string($koneksi, $_POST['lokasi']);
    $kondisi       = $_POST['kondisi'];
    $status        = $_POST['status'];

    $query = "INSERT INTO tb_kategori (nama_kategori, keterangan, lokasi, kondisi, status) 
              VALUES ('$nama_kategori', '$keterangan', '$lokasi', '$kondisi', '$status')";
    
    if (mysqli_query($koneksi, $query)) {
        header("Location: kategori.php?pesan=Data berhasil ditambahkan!");
        exit;
    }
}

// ------------------- PROSES UPDATE (EDIT DATA) -------------------
if (isset($_POST['edit'])) {
    $id_kategori   = $_POST['id_kategori'];
    $nama_kategori = mysqli_real_escape_string($koneksi, $_POST['nama_kategori']);
    $keterangan    = mysqli_real_escape_string($koneksi, $_POST['keterangan']);
    $lokasi        = mysqli_real_escape_string($koneksi, $_POST['lokasi']);
    $kondisi       = $_POST['kondisi'];
    $status        = $_POST['status'];

    $query = "UPDATE tb_kategori SET 
              nama_kategori='$nama_kategori', 
              keterangan='$keterangan', 
              lokasi='$lokasi', 
              kondisi='$kondisi', 
              status='$status' 
              WHERE id_kategori='$id_kategori'";
              
    if (mysqli_query($koneksi, $query)) {
        header("Location: kategori.php?pesan=Data berhasil diperbarui!");
        exit;
    }
}

// ------------------- PROSES HAPUS DATA -------------------
if (isset($_GET['hapus'])) {
    $id_kategori = $_GET['hapus'];
    mysqli_query($koneksi, "DELETE FROM tb_kategori WHERE id_kategori='$id_kategori'");
    header("Location: kategori.php?pesan=Data berhasil dihapus!");
    exit;
}

// ------------------- AMBIL DATA UNTUK FORM EDIT -------------------
$data_edit = null;
if (isset($_GET['edit_id'])) {
    $id_kategori = $_GET['edit_id'];
    $res = mysqli_query($koneksi, "SELECT * FROM tb_kategori WHERE id_kategori='$id_kategori'");
    $data_edit = mysqli_fetch_assoc($res);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Kelola Data Kategori - Admin</title>
</head>
<body>
    <h2>Kelola Data Kategori Sarpras</h2>
    <a href="dashboard_admin.php">Kembali ke Dashboard</a>
    <hr>

    <!-- Notifikasi Pesan -->
    <?php if(isset($_GET['pesan'])): ?>
        <p style="color: green; font-weight: bold;"><?= htmlspecialchars($_GET['pesan']); ?></p>
    <?php endif; ?>

    <!-- FORM TAMBAH / EDIT KATEGORI -->
    <h3><?= $data_edit ? 'Edit Kategori' : 'Tambah Kategori Baru' ?></h3>
    <form method="POST">
        <input type="hidden" name="id_kategori" value="<?= $data_edit['id_kategori'] ?? '' ?>">
        
        <p>
            <label>Nama Kategori:</label><br>
            <input type="text" name="nama_kategori" value="<?= $data_edit['nama_kategori'] ?? '' ?>" placeholder="Contoh: Proyektor" required>
        </p>
        
        <p>
            <label>Keterangan:</label><br>
            <textarea name="keterangan" rows="3" cols="30" placeholder="Keterangan singkat..."><?= $data_edit['keterangan'] ?? '' ?></textarea>
        </p>
        
        <p>
            <label>Lokasi Barang/Fasilitas:</label><br>
            <input type="text" name="lokasi" value="<?= $data_edit['lokasi'] ?? '' ?>" placeholder="Contoh: Lab RPL" required>
        </p>
        
        <p>
            <label>Kondisi Saat Ini:</label><br>
            <select name="kondisi" required>
                <option value="Baik" <?= isset($data_edit) && $data_edit['kondisi'] == 'Baik' ? 'selected' : '' ?>>Baik</option>
                <option value="Rusak" <?= isset($data_edit) && $data_edit['kondisi'] == 'Rusak' ? 'selected' : '' ?>>Rusak</option>
            </select>
        </p>
        
        <p>
            <label>Status Kategori:</label><br>
            <select name="status" required>
                <option value="Aktif" <?= isset($data_edit) && $data_edit['status'] == 'Aktif' ? 'selected' : '' ?>>Aktif</option>
                <option value="Tidak Aktif" <?= isset($data_edit) && $data_edit['status'] == 'Tidak Aktif' ? 'selected' : '' ?>>Tidak Aktif</option>
            </select>
        </p>
        
        <button type="submit" name="<?= $data_edit ? 'edit' : 'tambah' ?>">
            <?= $data_edit ? 'Update Kategori' : 'Simpan Kategori' ?>
        </button>
        
        <?php if ($data_edit): ?>
            <a href="kategori.php">Batal Edit</a>
        <?php endif; ?>
    </form>

    <hr>

    <!-- TABEL TAMPIL DATA KATEGORI -->
    <h3>Daftar Kategori Sarana Prasarana</h3>
    <table border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr bgcolor="#f2f2f2">
                <th>No</th>
                <th>Nama Kategori</th>
                <th>Keterangan</th>
                <th>Lokasi</th>
                <th>Kondisi</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            $data = mysqli_query($koneksi, "SELECT * FROM tb_kategori ORDER BY id_kategori DESC");
            if (mysqli_num_rows($data) > 0) {
                while ($d = mysqli_fetch_assoc($data)) {
            ?>
            <tr>
                <td align="center"><?= $no++; ?></td>
                <td><b><?= $d['nama_kategori']; ?></b></td>
                <td><?= $d['keterangan'] ?? '-'; ?></td>
                <td><?= $d['lokasi']; ?></td>
                <td align="center"><?= $d['kondisi']; ?></td>
                <td align="center"><?= $d['status']; ?></td>
                <td align="center">
                    <a href="kategori.php?edit_id=<?= $d['id_kategori']; ?>">Edit</a> | 
                    <a href="kategori.php?hapus=<?= $d['id_kategori']; ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')">Hapus</a>
                </td>
            </tr>
            <?php 
                }
            } else {
                echo "<tr><td colspan='7' align='center'>Belum ada data kategori.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>