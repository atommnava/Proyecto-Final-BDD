<?php
session_start();
include "config.php";

// Validar sesión
if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['idUsuario'];
$user_email = $_SESSION['email'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Mis Estadísticas</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .stats-container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background: #f9f9f9;
            border-radius: 8px;
        }
        .stats-card {
            background: white;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .stats-card h3 {
            color: #1D5477;
            margin-top: 0;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }
        .stats-list {
            list-style-type: none;
            padding: 0;
        }
        .stats-list li {
            padding: 8px 0;
            border-bottom: 1px dashed #eee;
        }
    </style>
</head>
<body>
    <h1>Mis Estadísticas</h1>
    <p>Usuario: <?php echo htmlspecialchars($user_email); ?> (ID: <?php echo $user_id; ?>)</p>
    
    <div class="stats-container">
        <!-- Eventos Registrados -->
        <div class="stats-card">
            <h3>📅 Eventos Registrados</h3>
            <?php
            $query = "SELECT e.nombre, e.fechaInicio, e.ubicacion 
                      FROM eventos_pf e
                      JOIN inscripciones_pf i ON e.idEvento = i.idEvento
                      WHERE i.idUsuario = ?
                      ORDER BY e.fechaInicio DESC";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                echo '<ul class="stats-list">';
                while ($row = $result->fetch_assoc()) {
                    echo "<li>
                            <strong>{$row['nombre']}</strong><br>
                            📍 {$row['ubicacion']}<br>
                            🗓️ " . date('d/m/Y', strtotime($row['fechaInicio'])) . "
                          </li>";
                }
                echo "</ul>";
            } else {
                echo "<p>No tienes eventos registrados.</p>";
            }
            ?>
        </div>
        
        <!-- Asistencias a Actividades -->
        <div class="stats-card">
            <h3>✅ Asistencias Registradas</h3>
            <?php
            $query = "SELECT a.nombre AS actividad, e.nombre AS evento, 
                             a.fecha, a.hora, a.sala
                      FROM asistencias_pf asi
                      JOIN actividades_pf a ON asi.idActividad = a.idActividad
                      JOIN eventos_pf e ON a.idEvento = e.idEvento
                      WHERE asi.idUsuario = ?
                      ORDER BY a.fecha DESC, a.hora DESC";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                echo '<ul class="stats-list">';
                while ($row = $result->fetch_assoc()) {
                    echo "<li>
                            <strong>{$row['actividad']}</strong><br>
                            🏷️ Evento: {$row['evento']}<br>
                            🗓️ " . date('d/m/Y', strtotime($row['fecha'])) . "
                            ⏰ " . date('H:i', strtotime($row['hora'])) . "
                            🏠 Sala: {$row['sala']}
                          </li>";
                }
                echo "</ul>";
            } else {
                echo "<p>No tienes asistencias registradas.</p>";
            }
            ?>
        </div>
        
        <!-- Resumen Estadístico -->
        <div class="stats-card">
            <h3>📊 Resumen de Participación</h3>
            <?php
            // Total eventos
            $query = "SELECT COUNT(*) AS total FROM inscripciones_pf WHERE idUsuario = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $total_eventos = $stmt->get_result()->fetch_assoc()['total'];
            
            // Total asistencias
            $query = "SELECT COUNT(*) AS total FROM asistencias_pf WHERE idUsuario = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $total_asistencias = $stmt->get_result()->fetch_assoc()['total'];
            
            // Próximo evento
            $query = "SELECT e.nombre, e.fechaInicio 
                      FROM eventos_pf e
                      JOIN inscripciones_pf i ON e.idEvento = i.idEvento
                      WHERE i.idUsuario = ? AND e.fechaInicio >= CURDATE()
                      ORDER BY e.fechaInicio ASC
                      LIMIT 1";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $user_id);
            $stmt->execute();

            if (!$stmt) {
                echo "<p style='color:red;'>Error en la consulta: " . $conn->error . "</p>";
            }

            $proximo_evento = $stmt->get_result()->fetch_assoc();
            
            echo "<p>🔢 <strong>Total Eventos:</strong> $total_eventos</p>";
            echo "<p>✔️ <strong>Asistencias:</strong> $total_asistencias</p>";
            
            if ($proximo_evento) {
                echo "<p>🔜 <strong>Próximo Evento:</strong> {$proximo_evento['nombre']} " . 
                     "(" . date('d/m/Y', strtotime($proximo_evento['fechaInicio'])) . ")</p>";
            }
            ?>
        </div>
    </div>
</body>
</html>