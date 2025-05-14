/*
 * @file agregar_ponente.php
 * @brief Página para registrar un nuevo ponente con sus datos profesionales mediante un formulario.
 * @date 14-05-2025
 * @author Atom Nava, Julen Franco
 */

<?php
session_start();
include "config.php";

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}

// Procesa los datos enviados por el formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Escapar los valores para prevenir inyección SQL
    $nombre = mysqli_real_escape_string($conn, $_POST['nombre']);
    $especializacion = mysqli_real_escape_string($conn, $_POST['especializacion']);
    $ocupacion = mysqli_real_escape_string($conn, $_POST['ocupacion']);

    // Insertar nuevo ponente en la base de datos
    $query = "INSERT INTO presentadores_pf (nombre, especializacion, ocupacion) 
              VALUES ('$nombre', '$especializacion', '$ocupacion')";
    
    // Redirige según el resultado del INSERT
    if (mysqli_query($conn, $query)) {
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
        <!-- Formulario de registro de ponente -->
        <form method="POST">
            <input type="text" name="nombre" placeholder="Nombre completo" required>
            <input type="text" name="especializacion" placeholder="Especialización" required>
            <input type="text" name="ocupacion" placeholder="Ocupación actual" required>
            <button type="submit">Registrar Ponente</button>
        </form>
    </div>
</body>
</html>
