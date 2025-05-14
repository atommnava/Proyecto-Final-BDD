
<?php
session_start();
include "config.php";

if (!isset($_SESSION['idUsuario'])) {
    die("Sesión no válida. Por favor, inicia sesión nuevamente.");
}

$user_id = $_SESSION['idUsuario'];
$user_email = $_SESSION['email'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Estadísticas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; padding-top: 40px; }
        .container { max-width: 900px; }
        .card-header { background-color: #003366; color: white; }
        .list-group-item { background-color: #f1f1f1; }
        .toggle-btn { margin-bottom: 15px; }
        .sublist { margin-left: 20px; font-size: 0.95em; color: #333; }
    </style>
</head>
<body>
<div class="container">
    <h2 class="mb-3">Bienvenido, <?php echo htmlspecialchars($user_email); ?></h2>

    <!-- Botón para compartir eventos -->
    <div class="mb-3">
        <a href="compartir_eventos.php" class="btn btn-outline-primary">📤 Compartir mis eventos con contactos</a>
    </div>

    <!-- Botones de secciones -->
    <div class="d-flex flex-wrap gap-2 mb-3">
        <button class="btn btn-primary toggle-btn" onclick="toggleSection('eventos')">📅 Eventos Registrados</button>
        <button class="btn btn-success toggle-btn" onclick="toggleSection('asistencias')">✅ Asistencias Registradas</button>
        <button class="btn btn-info toggle-btn" onclick="toggleSection('participantes')">👥 Participantes Registrados</button>
        <button class="btn btn-warning toggle-btn" onclick="toggleSection('compartidos')">🔗 Eventos Compartidos Conmigo</button>
    </div>

    <!-- Secciones existentes (omitidas para brevedad)... -->

    <!-- Eventos Compartidos Conmigo -->
    <div id="compartidos" class="card mb-4" style="display: none;">
        <div class="card-header">🔗 Eventos que te han compartido</div>
        <ul class="list-group list-group-flush">
            <?php
            $stmt = $conn->prepare("
                SELECT e.nombre, e.fechaInicio, e.ubicacion, u.nombre AS emisor
                FROM eventos_compartidos_pf ec
                JOIN eventos_pf e ON ec.idEvento = e.idEvento
                JOIN usuarios_pf u ON ec.idUsuarioEmisor = u.idUsuario
                WHERE ec.idUsuarioReceptor = ?
                ORDER BY ec.fechaCompartido DESC
            ");
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<li class='list-group-item'>
                            <strong>{$row['nombre']}</strong><br>
                            🗓️ " . date('d/m/Y', strtotime($row['fechaInicio'])) . " | 📍 {$row['ubicacion']}<br>
                            🙋 Compartido por: {$row['emisor']}
                          </li>";
                }
            } else {
                echo "<li class='list-group-item'>Ningún usuario te ha compartido eventos aún.</li>";
            }
            ?>
        </ul>
    </div>
</div>

<script>
function toggleSection(id) {
    const section = document.getElementById(id);
    section.style.display = section.style.display === "none" ? "block" : "none";
}
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
