<?php
session_start();
include "config.php";

// Validar sesión
if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['idUsuario']; // Asegúrate que esto coincide con tu variable de sesión

// Obtener eventos en los que está registrado el usuario
$query = "SELECT e.idEvento, e.nombre AS nombreEvento, e.fechaInicio AS fechaEvento, e.ubicacion AS lugar
          FROM eventos_pf e
          JOIN inscripciones_pf i ON e.idEvento = i.idEvento
          WHERE i.idUsuario = ?";
$stmt = $conn->prepare($query);

if ($stmt === false) {
    die("Error en la preparación de la consulta: " . $conn->error);
}

$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Verificar si hay resultados
if ($result->num_rows === 0) {
    $no_events = true;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Mis Eventos</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .event-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        .event-card {
            background: white;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .share-btn {
            background-color: #1D5477;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 10px;
        }
        .no-events {
            text-align: center;
            padding: 20px;
            font-size: 1.2em;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="event-container">
        <h1>Eventos en los que estás registrado</h1>
        
        <?php if (isset($no_events)): ?>
            <div class="no-events">
                No estás registrado en ningún evento actualmente.
            </div>
        <?php else: ?>
            <div class="event-list">
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="event-card">
                        <h2><?= htmlspecialchars($row['nombreEvento']) ?></h2>
                        <p><strong>Fecha:</strong> <?= htmlspecialchars($row['fechaEvento']) ?></p>
                        <p><strong>Lugar:</strong> <?= htmlspecialchars($row['lugar']) ?></p>
                        <button class="share-btn" onclick="shareEvent('<?= htmlspecialchars($row['nombreEvento']) ?>', '<?= htmlspecialchars($row['fechaEvento']) ?>')">
                            Compartir Evento
                        </button>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php endif; ?>
    </div>

    <script>
    function shareEvent(eventName, eventDate) {
        if (navigator.share) {
            navigator.share({
                title: 'Evento: ' + eventName,
                text: eventName + ' - ' + eventDate,
                url: window.location.href
            }).catch(err => {
                console.log('Error al compartir:', err);
                alert('No se pudo compartir el evento. Intenta copiar el enlace manualmente.');
            });
        } else {
            // Fallback para navegadores que no soportan Web Share API
            alert('Tu navegador no soporta la función de compartir. Copia esta información:\n\n' + 
                  'Evento: ' + eventName + '\nFecha: ' + eventDate + '\nURL: ' + window.location.href);
        }
    }
    </script>
</body>
</html>