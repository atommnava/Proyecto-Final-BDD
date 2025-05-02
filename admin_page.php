<?php


session_start();

// It ensures that the user must log in before accessing the admin
// or user page
if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <link rel="stylesheet" href="style2.css">
</head>

<body style="background: #fff;">
    <div class="box">
        <h1>Welcome, <span><?= $_SESSION['name']; ?></span></h1>
        <p>This is an <span>admin</span> page</p>
        <button onclick="window.location.href='logout.php'">Logout</button>
    </div>
</body>
</html>