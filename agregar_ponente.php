<?php
session_start();
include "config.php";

if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = mysqli_real_escape_string($link, $_POST['nombre']);
    $especializacion = mysqli_real_escape_string($link, $_POST['especializacion']);
    $ocupacion = mysqli_real_escape_string($link, $_POST['ocupacion']);

    $query = "INSERT INTO presentadores_pf (nombre, especializacion, ocupacion) 
              VALUES ('$nombre', '$especializacion', '$ocupacion')";
    
    if (mysqli_query($link, $query)) {
        header("Location: admin_page.php?success=3");
    } else {
        header("Location: admin_page.php?error=3");
    }
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Agregar Ponente</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="form-box active">
        <h2>Nuevo Ponente</h2>
        <form method="POST">
            <input type="text" name="nombre" placeholder="Nombre completo" required>
            <input type="text" name="especializacion" placeholder="Especialización" required>
            <input type="text" name="ocupacion" placeholder="Ocupación actual" required>
            <button type="submit">Registrar Ponente</button>
        </form>
    </div>
</body>
</html>