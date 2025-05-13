<?php
session_start();
include "config.php";

if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = mysqli_real_escape_string($link, $_POST['nombre']);
    $correo = mysqli_real_escape_string($link, $_POST['correo']);
    $contrasenia = password_hash($_POST['contrasenia'], PASSWORD_DEFAULT);

    $query = "INSERT INTO usuarios_pf (nombre, correo, contrasenia, tipo) 
              VALUES ('$nombre', '$correo', '$contrasenia', 'u')";
    
    if (mysqli_query($link, $query)) {
        header("Location: admin_page.php?success=2");
    } else {
        header("Location: admin_page.php?error=2");
    }
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Agregar Participante</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="form-box active">
        <h2>Nuevo Participante</h2>
        <form method="POST">
            <input type="text" name="nombre" placeholder="Nombre completo" required>
            <input type="email" name="correo" placeholder="Correo electrónico" required>
            <input type="password" name="contrasenia" placeholder="Contraseña" required>
            <button type="submit">Registrar Participante</button>
        </form>
    </div>
</body>
</html>