<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include "config.php";

if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}

$query = "SELECT u.nombre AS usuario, a.nombre AS actividad, a.fecha AS fecha_actividad, 
                 a.sala, asi.fechaAsistencia
          FROM asistencias_pf asi
          JOIN usuarios_pf u ON asi.idUsuario = u.idUsuario
          JOIN actividades_pf a ON asi.idActividad = a.idActividad
          ORDER BY asi.fechaAsistencia DESC";

$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Asistencias</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4 bg-light">
<div class="container">
    <h2 class="mb-4">📋 Lista de Asistencias Registradas</h2>
    <a href="admin_page.php" class="btn btn-secondary mb-3">⬅ Volver al Panel</a>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Usuario</th>
                <th>Actividad</th>
                <th>Fecha Actividad</th>
                <th>Sala</th>
                <th>Fecha de Asistencia</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['usuario']) ?></td>
                        <td><?= htmlspecialchars($row['actividad']) ?></td>
                        <td><?= $row['fecha_actividad'] ?></td>
                        <td><?= htmlspecialchars($row['sala']) ?></td>
                        <td><?= $row['fechaAsistencia'] ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="text-center">No hay asistencias registradas.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>