/*
 * @file asistenciasajax.php
 * @brief Filtra y muestra la lista de asistencias del usuario autenticado según los filtros enviados por POST.
 * @date 13-05-2025
 * @author Atom Nava, Julen Franco
 */

<?php
session_start();
include "config.php";

// Verificar que el usuario esté autenticado
if (!isset($_SESSION['idUsuario'])) {
    exit();
}

$user_id = $_SESSION['idUsuario'];
$desde = $_POST['desde'] ?? '';
$hasta = $_POST['hasta'] ?? '';
$actividad = $_POST['actividad'] ?? '';

// Consulta base para obtener asistencias del usuario
$query = "SELECT a.nombre AS actividad, e.nombre AS evento, a.fecha, a.hora, a.sala
          FROM asistencias_pf asi
          JOIN actividades_pf a ON asi.idActividad = a.idActividad
          JOIN eventos_pf e ON a.idEvento = e.idEvento
          WHERE asi.idUsuario = ?";

$params = [$user_id];
$types = "i";

// Agregar filtros dinámicamente si se especificaron
if (!empty($desde)) {
    $query .= " AND a.fecha >= ?";
    $params[] = $desde;
    $types .= "s";
}
if (!empty($hasta)) {
    $query .= " AND a.fecha <= ?";
    $params[] = $hasta;
    $types .= "s";
}
if (!empty($actividad)) {
    $query .= " AND a.nombre LIKE ?";
    $params[] = "%" . $actividad . "%";
    $types .= "s";
}

$query .= " ORDER BY a.fecha DESC, a.hora DESC";

// Preparar y ejecutar la consulta
$stmt = $conn->prepare($query);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();

// Mostrar resultados si hay coincidencias
if ($result->num_rows > 0) {
    echo "<ul class='list-group'>";
    while ($row = $result->fetch_assoc()) {
        echo "<li class='list-group-item'>
                <strong>{$row['actividad']}</strong><br>
                🏷️ Evento: {$row['evento']}<br>
                🗓️ " . date('d/m/Y', strtotime($row['fecha'])) . "
                ⏰ " . date('H:i', strtotime($row['hora'])) . "<br>
                🏠 Sala: {$row['sala']}
              </li>";
    }
    echo "</ul>";
} else {
    // Si no se encuentran registros
    echo "<div class='alert alert-warning'>No se encontraron asistencias con esos filtros.</div>";
}
?>
