
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include "config.php";

// Verificar sesión
if (!isset($_SESSION['email'])) {
    die("Sesión no válida. Por favor, inicia sesión nuevamente.");
}

$user_id = $_SESSION['idUsuario'];
$user_email = $_SESSION['email'];
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Depuración Estadísticas</title>
    <style>
        body { font-family: Arial; margin: 20px; background: #fff; }
        .debug-box { background: #f0f0f0; border-left: 5px solid #3366cc; padding: 15px; margin: 15px 0; }
        pre { background: #e8e8e8; padding: 10px; }
    </style>
</head>
<body>
    <h1>Debug - Página de Usuario</h1>
    <div class="debug-box">
        <strong>Usuario:</strong> <?php echo htmlspecialchars($user_email); ?> <br>
        <strong>ID de sesión:</strong> <?php echo $user_id; ?>
    </div>

    <div class="debug-box">
        <h2>Consulta: Eventos Registrados</h2>
        <?php
        $query = "SELECT e.nombre, e.fechaInicio, e.ubicacion 
                  FROM eventos_pf e
                  JOIN inscripciones_pf i ON e.idEvento = i.idEvento
                  WHERE i.idUsuario = ?
                  ORDER BY e.fechaInicio DESC";
        $stmt = $conn->prepare($query);
        if (!$stmt) die("Error en prepare(): " . $conn->error);
        $stmt->bind_param("i", $user_id);
        if (!$stmt->execute()) die("Error en execute(): " . $stmt->error);
        $result = $stmt->get_result();

        echo "<pre>";
        while ($row = $result->fetch_assoc()) {
            print_r($row);
        }
        echo "</pre>";
        ?>
    </div>

    <div class="debug-box">
        <h2>Consulta: Asistencias Registradas</h2>
        <?php
        $query = "SELECT a.nombre AS actividad, e.nombre AS evento, a.fecha, a.hora, a.sala
                  FROM asistencias_pf asi
                  JOIN actividades_pf a ON asi.idActividad = a.idActividad
                  JOIN eventos_pf e ON a.idEvento = e.idEvento
                  WHERE asi.idUsuario = ?
                  ORDER BY a.fecha DESC, a.hora DESC";
        $stmt = $conn->prepare($query);
        if (!$stmt) die("Error en prepare(): " . $conn->error);
        $stmt->bind_param("i", $user_id);
        if (!$stmt->execute()) die("Error en execute(): " . $stmt->error);
        $result = $stmt->get_result();

        echo "<pre>";
        while ($row = $result->fetch_assoc()) {
            print_r($row);
        }
        echo "</pre>";
        ?>
    </div>
</body>
</html>
