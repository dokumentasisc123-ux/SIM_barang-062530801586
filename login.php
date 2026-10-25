<?php
session_start();

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST["username"] ?? "";
    $password = $_POST["password"] ?? "";

    if ($username == "M Wildan Rafi Amri" &&
        $password == "gemayel150308") {

        session_regenerate_id(true);

        $_SESSION["user"] = $username;

        header("Location: index.php");
        exit;

    } else {
        $error = "Username atau password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login SIM-Barang</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="login-container">

    <h2>SIM-Barang</h2>
    <p>Sistem Inventaris Barang Jurusan</p>

    <?php if ($error != ""): ?>
        <p style="color:red;">
            <?= htmlspecialchars($error) ?>
        </p>
    <?php endif; ?>

    <form method="POST">

        <label>Username</label>
        <input type="text"
               name="username"
               placeholder="Masukkan username"
               required>

        <label>Password</label>
        <input type="password"
               name="password"
               placeholder="Masukkan password"
               required>

        <button type="submit">Login</button>

    </form>

    <p>Username: M Wildan Rafi Amri</p>
    <p>Password: gemayel150308</p>

</div>

</body>
</html>