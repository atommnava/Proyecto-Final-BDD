<?php
session_start();
include "config.php";

if (!isset($_SESSION['email'])) {
    die("Acceso no autorizado");
}

$user_id = $_POST['user_id'];
$tipo_consulta = $_POST['tipo_consulta'];

switch($tipo_consulta) {
    case 'eventos_inscritos':
        mostrarEventosInscritos($user_id);
        break;
    case 'asistencias':
        mostrarAsistencias($user_id);
        break;
    case 'proximos_eventos':
        mostrarProximosEventos($user_id);
        break;
    case 'historial':
        mostrarHistorialCompleto($user_id);
        break;
    default:
        echo "<p>Seleccione una opción válida</p>";
}

function mostrarEventosInscritos($user_id) {
    global $link;
    
    $query = "SELECT e.idEvento, e.nombre, e.fechaInicio, e.fechaFinal, e.ubicacion 
              FROM eventos_pf e
              JOIN inscripciones_pf i ON e.idEvento = i.idEvento
              WHERE i.idUsuario = ?
              ORDER BY e.fechaInicio DESC";
              
    $stmt = $link->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    echo '<h3>Mis Eventos Inscritos</h3>';
    echo '<table class="tabla-datos">
            <tr>
                <th>Evento</th>
                <th>Fecha Inicio</th>
                <th>Fecha Fin</th>
                <th>Ubicación</th>
            </tr>';
    
    while ($row = $result->fetch_assoc()) {
        echo '<tr>
                <td>'.$row['nombre'].'</td>
                <td>'.$row['fechaInicio'].'</td>
                <td>'.$row['fechaFinal'].'</td>
                <td>'.$row['ubicacion'].'</td>
              </tr>';
    }
    
    echo '</table>';
}

function mostrarAsistencias($user_id) {
    global $link;
    
    $query = "SELECT a.fechaAsistencia, e.nombre AS evento, ac.nombre AS actividad
              FROM asistencias_pf a
              JOIN actividades_pf ac ON a.idActividad = ac.idActividad
              JOIN eventos_pf e ON ac.idEvento = e.idEvento
              WHERE a.idUsuario = ?
              ORDER BY a.fechaAsistencia DESC";
              
    $stmt = $link->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    echo '<h3>Mis Asistencias Registradas</h3>';
    echo '<table class="tabla-datos">
            <tr>
                <th>Fecha</th>
                <th>Evento</th>
                <th>Actividad</th>
            </tr>';
    
    while ($row = $result->fetch_assoc()) {
        echo '<tr>
                <td>'.$row['fechaAsistencia'].'</td>
                <td>'.$row['evento'].'</td>
                <td>'.$row['actividad'].'</td>
              </tr>';
    }
    
    echo '</table>';
}

function mostrarProximosEventos($user_id) {
    global $link;
    
    $query = "SELECT e.nombre, e.fechaInicio, e.ubicacion 
              FROM eventos_pf e
              JOIN inscripciones_pf i ON e.idEvento = i.idEvento
              WHERE i.idUsuario = ? AND e.fechaInicio > NOW()
              ORDER BY e.fechaInicio ASC";
              
    $stmt = $link->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    echo '<h3>Mis Próximos Eventos</h3>';
    
    if ($result->num_rows > 0) {
        echo '<table class="tabla-datos">
                <tr>
                    <th>Evento</th>
                    <th>Fecha</th>
                    <th>Ubicación</th>
                </tr>';
        
        while ($row = $result->fetch_assoc()) {
            echo '<tr>
                    <td>'.$row['nombre'].'</td>
                    <td>'.$row['fechaInicio'].'</td>
                    <td>'.$row['ubicacion'].'</td>
                  </tr>';
        }
        
        echo '</table>';
    } else {
        echo '<p>No tienes eventos próximos</p>';
    }
}

function mostrarHistorialCompleto($user_id) {
    global $link;
    
    $query = "SELECT e.nombre AS evento, 
                     COUNT(a.idAsistencia) AS asistencias,
                     MIN(a.fechaAsistencia) AS primera_asistencia,
                     MAX(a.fechaAsistencia) AS ultima_asistencia
              FROM inscripciones_pf i
              JOIN eventos_pf e ON i.idEvento = e.idEvento
              LEFT JOIN actividades_pf ac ON e.idEvento = ac.idEvento
              LEFT JOIN asistencias_pf a ON (ac.idActividad = a.idActividad AND a.idUsuario = i.idUsuario)
              WHERE i.idUsuario = ?
              GROUP BY e.idEvento
              ORDER BY MAX(a.fechaAsistencia) DESC";
              
    $stmt = $link->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    echo '<h3>Mi Historial Completo</h3>';
    echo '<table class="tabla-datos">
            <tr>
                <th>Evento</th>
                <th>Asistencias</th>
                <th>Primera Asistencia</th>
                <th>Última Asistencia</th>
            </tr>';
    
    while ($row = $result->fetch_assoc()) {
        echo '<tr>
                <td>'.$row['evento'].'</td>
                <td>'.$row['asistencias'].'</td>
                <td>'.($row['primera_asistencia'] ? $row['primera_asistencia'] : 'N/A').'</td>
                <td>'.($row['ultima_asistencia'] ? $row['ultima_asistencia'] : 'N/A').'</td>
              </tr>';
    }
    
    echo '</table>';
}
?>