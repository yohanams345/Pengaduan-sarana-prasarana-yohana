<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Login - Pengaduan Sarpras</title>
</head>
<body>
    <h2>Form Login System</h2>
    <?php if(isset($_GET['pesan'])) { echo "<p style='color:red;'>".htmlspecialchars($_GET['pesan'])."</p>"; } ?>
    
    <form action="proses_login.php" method="POST">
        <p>
            <label>Login Sebagai:</label><br>
            <input type="radio" name="role" value="admin" checked> Admin / Petugas
            <input type="radio" name="role" value="siswa"> Siswa
        </p>
        <p>
            <label>Username / NIS:</label><br>
            <input type="text" name="username" required>
        </p>
        <p>
            <label>Password:</label><br>
            <input type="password" name="password" required>
        </p>
        <button type="submit" name="login">Login</button>
    </form>
</body>
</html>