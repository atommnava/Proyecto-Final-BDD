<?php
session_start();
include "config.php";

if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = mysqli_real_escape_string($link, $_POST['nombre']);
    $fechaInicio = mysqli_real_escape_string($link, $_POST['fecha_inicio']);
    $fechaFinal = mysqli_real_escape_string($link, $_POST['fecha_final']);
    $ubicacion = mysqli_real_escape_string($link, $_POST['ubicacion']);
    $descripcion = mysqli_real_escape_string($link, $_POST['descripcion']);

    $query = "INSERT INTO eventos_pf (nombre, fechaInicio, fechaFinal, ubicacion, descripcion) 
              VALUES ('$nombre', '$fechaInicio', '$fechaFinal', '$ubicacion', '$descripcion')";
    
    if (mysqli_query($link, $query)) {
        header("Location: admin_page.php?success=1");
    } else {
        header("Location: admin_page.php?error=1");
    }
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Agregar Evento</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="form-box active">
        <h2>Nuevo Evento</h2>
        <form method="POST">
            <input type="text" name="nombre" placeholder="Nombre del evento" required>
            <input type="date" name="fecha_inicio" required>
            <input type="date" name="fecha_final" required>
            <input type="text" name="ubicacion" placeholder="Ubicación" required>
            <textarea name="descripcion" placeholder="Descripción" required></textarea>
            <button type="submit">Guardar Evento</button>
        </form>
    </div>
</body>
</html>