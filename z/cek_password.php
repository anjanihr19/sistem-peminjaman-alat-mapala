<?php
// Ambil password dari database langsung
$conn = mysqli_connect('localhost', 'root', '', 'db_inventaris');

$result = mysqli_query($conn, "SELECT username, password FROM users WHERE role='Admin'");
$user = mysqli_fetch_object($result);

echo "Username: " . $user->username . "<br>";
echo "Password di DB: " . $user->password . "<br>";
echo "<hr>";

// Test password_verify
$password_yang_dicoba = 'admin'; // ganti dengan password yang Anda coba
echo "Test password_verify: ";
echo password_verify($password_yang_dicoba, $user->password) ? '✅ COCOK' : '❌ TIDAK COCOK';
echo "<br><hr>";

// Cek apakah password di DB adalah plain text atau hash
echo "Apakah hash bcrypt: ";
echo (substr($user->password, 0, 4) == '$2y$') ? '✅ YA (hash)' : '❌ TIDAK (masih plain text)';
?>
```

Akses di browser:
```
http://localhost/SIMV/cek_password.php