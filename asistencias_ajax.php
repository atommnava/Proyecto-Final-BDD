
<?php
session_start();
include "config.php";

if (!isset($_SESSION['idUsuario'])) {
    echo "<div class='alert alert-warning'>Sesión no válida.</div>";
    exit();
}

$user_id = $_SESSION['idUsuario'];
$desde = $_POST['desde'] ?? '';
$hasta = $_POST['hasta'] ?? '';
$actividad = $_POST['actividad'] ?? '';

$query = "SELECT a.nombre AS actividad, e.nombre AS evento, a.fecha, a.hora, a.sala
          FROM asistencias_pf asi
          JOIN actividades_pf a ON asi.idActividad = a.idActividad
          JOIN eventos_pf e ON a.idEvento = e.idEvento
          WHERE asi.idUsuario = ?";

$params = [$user_id];
$types = "i";

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

$stmt = $conn->prepare($query);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();

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
    echo "<div class='alert alert-warning'>No se encontraron asistencias con esos filtros.</div>";
}
?>
