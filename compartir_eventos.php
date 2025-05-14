/*
 * @file compartir_eventos.php
 * @brief Página que permite a un usuario compartir los eventos en los que está inscrito con otros usuarios del sistema.
 * @date 11-05-2025
 * @author Atom Nava, Julen Franco
 */

<?php
session_start();
include "config.php";

// Verificar que el usuario ha iniciado sesión
if (!isset($_SESSION['idUsuario'])) {
    die("Sesión no válida.");
}

$user_id = $_SESSION['idUsuario'];
$user_email = $_SESSION['email'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Compartir Mis Eventos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; padding: 30px; }
        .container { max-width: 900px; }
    </style>
</head>
<body>
<div class="container">
    <h2 class="mb-4">Compartir Eventos Registrados</h2>
    <!-- Formulario para seleccionar eventos y usuarios con los que compartir -->
    <form action="procesar_compartir.php" method="POST">

        <!-- Sección para seleccionar eventos -->
        <div class="mb-3">
            <label for="eventos" class="form-label">Selecciona eventos:</label>
            <div class="form-check">
                <?php
                // Obtener eventos en los que el usuario está inscrito
                $stmt = $conn->prepare("SELECT e.idEvento, e.nombre 
                                        FROM eventos_pf e
                                        JOIN inscripciones_pf i ON e.idEvento = i.idEvento
                                        WHERE i.idUsuario = ?");
                $stmt->bind_param("i", $user_id);
                $stmt->execute();
                $result = $stmt->get_result();

                // Mostrar los eventos como checkboxes
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<div class='form-check'>
                                <input class='form-check-input' type='checkbox' name='eventos[]' value='{$row['idEvento']}' id='evento{$row['idEvento']}'>
                                <label class='form-check-label' for='evento{$row['idEvento']}'>{$row['nombre']}</label>
                              </div>";
                    }
                } else {
                    echo "<p class='text-muted'>No estás inscrito en ningún evento.</p>";
                }
                ?>
            </div>
        </div>

        <!-- Sección para seleccionar usuarios para compartir -->
        <div class="mb-3">
            <label for="usuarios" class="form-label">Selecciona contactos para compartir:</label>
            <div class="form-check">
                <?php
                // Obtener otros usuarios registrados (excepto el actual)
                $stmt = $conn->prepare("SELECT idUsuario, nombre, correo FROM usuarios_pf WHERE tipo = 'u' AND idUsuario != ?");
                $stmt->bind_param("i", $user_id);
                $stmt->execute();
                $result = $stmt->get_result();

                // Mostrar los usuarios como checkboxes
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<div class='form-check'>
                                <input class='form-check-input' type='checkbox' name='usuarios[]' value='{$row['idUsuario']}' id='usuario{$row['idUsuario']}'>
                                <label class='form-check-label' for='usuario{$row['idUsuario']}'>{$row['nombre']} ({$row['correo']})</label>
                              </div>";
                    }
                } else {
                    echo "<p class='text-muted'>No hay otros usuarios disponibles.</p>";
                }
                ?>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Compartir Eventos</button>
    </form>
</div>
</body>
</html>
