<?php
// Activar errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include "config.php";

if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}

// Inicializar variables
$error = '';
$success = '';

// Obtener listas para los select
$eventos = $conn->query("SELECT idEvento, nombre FROM eventos_pf ORDER BY nombre ASC");
$ponentes = $conn->query("SELECT idPresentador, nombre FROM presentadores_pf ORDER BY nombre ASC");

// Procesar formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = mysqli_real_escape_string($conn, $_POST['nombre'] ?? '');
    $fecha = mysqli_real_escape_string($conn, $_POST['fecha'] ?? '');
    $hora = mysqli_real_escape_string($conn, $_POST['hora'] ?? '');
    $sala = mysqli_real_escape_string($conn, $_POST['sala'] ?? '');
    $idEvento = intval($_POST['evento'] ?? 0);
    $idPresentador = intval($_POST['ponente'] ?? 0);

    if ($nombre && $fecha && $hora && $sala && $idEvento && $idPresentador) {
        $stmt = $conn->prepare("SELECT * FROM actividades_pf WHERE fecha = ? AND hora = ? AND sala = ?");
        $stmt->bind_param("sss", $fecha, $hora, $sala);
        $stmt->execute();
        $conflictos = $stmt->get_result();

        if ($conflictos->num_rows > 0) {
            $error = "⚠ Ya existe una actividad en esa sala, fecha y hora.";
        } else {
            $stmt = $conn->prepare("INSERT INTO actividades_pf (nombre, fecha, hora, sala, idEvento)
                                    VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssi", $nombre, $fecha, $hora, $sala, $idEvento);
            if ($stmt->execute()) {
                $idActividad = $conn->insert_id;

                $stmt2 = $conn->prepare("INSERT INTO actividades_presentadores_pf (idActividad, idPresentador)
                                         VALUES (?, ?)");
                $stmt2->bind_param("ii", $idActividad, $idPresentador);
                if ($stmt2->execute()) {
                    $success = "✅";
                } else {
                    $error = "❌";
                }
            } else {
                $error = "❌ Error al registrar la actividad: " . $stmt->error;
            }
        }
    } else {
        $error = "❌ Todos los campos son obligatorios.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Agregar Actividad</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4 bg-light">
<div class="container" style="max-width: 700px;">
    <h2 class="mb-3">Agregar Nueva Actividad</h2>

    <form method="POST" class="border rounded p-4 bg-white shadow">
        <div class="mb-3">
            <label class="form-label">Nombre de la actividad</label>
            <input type="text" name="nombre" class="form-control" required>
        </div>
        <div class="row mb-3">
            <div class="col">
                <label class="form-label">Fecha</label>
                <input type="date" name="fecha" class="form-control" required>
            </div>
            <div class="col">
                <label class="form-label">Hora</label>
                <input type="time" name="hora" class="form-control" required>
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">Sala</label>
            <input type="text" name="sala" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Evento</label>
            <select name="evento" class="form-select" required>
                <option value="">Selecciona un evento</option>
                <?php while ($row = $eventos->fetch_assoc()): ?>
                    <option value="<?= $row['idEvento'] ?>"><?= $row['nombre'] ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Ponente</label>
            <select name="ponente" class="form-select" required>
                <option value="">Selecciona un ponente</option>
                <?php while ($row = $ponentes->fetch_assoc()): ?>
                    <option value="<?= $row['idPresentador'] ?>"><?= $row['nombre'] ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Guardar Actividad</button>
    </form>
</div>
</body>
</html>