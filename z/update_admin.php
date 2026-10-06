<?php
$conn = mysqli_connect('localhost', 'root', '', 'db_inventaris');

// Ganti 'password_baru' dengan password yang Anda inginkan
$password_baru = 'admin';
$hash = password_hash($password_baru, PASSWORD_DEFAULT);

mysqli_query($conn, "UPDATE users SET password='$hash' WHERE role='Admin'");

echo "Password berhasil direset!<br>";
echo "Silakan login dengan password: <b>" . $password_baru . "</b>";
?>
