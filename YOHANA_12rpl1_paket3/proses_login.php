<?php
include 'koneksi.php';

if (isset($_POST['login'])) {
    $role     = $_POST['role'];
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = mysqli_real_escape_string($koneksi, $_POST['password']);

    if ($role == 'admin') {
        $query = "SELECT * FROM tb_admin WHERE username='$username' AND password='$password' AND status='Aktif'";
        $exec  = mysqli_query($koneksi, $query);

        if (mysqli_num_rows($exec) > 0) {
            $data = mysqli_fetch_assoc($exec);
            $_SESSION['role']       = 'admin';
            $_SESSION['id_admin']   = $data['id_admin'];
            $_SESSION['nama_admin'] = $data['nama_admin'];
            $_SESSION['level']      = $data['level'];
            header("Location: dashboard_admin.php");
            exit;
        } else {
            header("Location: login.php?pesan=Username / Password Admin salah atau tidak aktif!");
            exit;
        }
    } else if ($role == 'siswa') {
        $query = "SELECT * FROM tb_siswa WHERE (username='$username' OR nis='$username') AND password='$password'";
        $exec  = mysqli_query($koneksi, $query);

        if (mysqli_num_rows($exec) > 0) {
            $data = mysqli_fetch_assoc($exec);
            $_SESSION['role']       = 'siswa';
            $_SESSION['id_siswa']   = $data['id_siswa'];
            $_SESSION['nama_siswa'] = $data['nama_siswa'];
            $_SESSION['kelas']      = $data['kelas'];
            header("Location: dashboard_siswa.php");
            exit;
        } else {
            header("Location: login.php?pesan=NIS / Password Siswa salah!");
            exit;
        }
    }
}
?>