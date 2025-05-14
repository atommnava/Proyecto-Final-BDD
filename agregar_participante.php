/*
 * @file agregar_participante.php
 * @brief Página para registrar un nuevo participante (usuario tipo 'u') mediante un formulario.
 * @date 12-05-2025
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

// Procesar los datos del formulario cuando se envía por POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Escapar datos del formulario para evitar inyecciones SQL
    $nombre = mysqli_real_escape_string($conn, $_POST['nombre']);
    $correo = mysqli_real_escape_string($conn, $_POST['correo']);
    // Encriptar contraseña
    $contrasenia = password_hash($_POST['contrasenia'], PASSWORD_DEFAULT);

    // Insertar el nuevo usuario con tipo 'u' (participante)
    $query = "INSERT INTO usuarios_pf (nombre, correo, contrasenia, tipo) 
              VALUES ('$nombre', '$correo', '$contrasenia', 'u')";
    
    // Redirigir según el resultado de la operación
    if (mysqli_query($conn, $query)) {
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
        <!-- Formulario de registro de participante -->
        <form method="POST">
            <input type="text" name="nombre" placeholder="Nombre completo" required>
            <input type="email" name="correo" placeholder="Correo electrónico" required>
            <input type="password" name="contrasenia" placeholder="Contraseña" required>
            <button type="submit">Registrar Participante</button>
        </form>
    </div>
</body>
</html>
