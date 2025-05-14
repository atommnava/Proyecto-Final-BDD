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

$error = '';
$success = '';
$hoy = date('Y-m-d');

// Obtener listas de usuarios y actividades
$usuarios = $conn->query("SELECT idUsuario, nombre FROM usuarios_pf WHERE tipo = 'u' ORDER BY nombre ASC");
$actividades = $conn->query("SELECT a.idActividad, a.nombre AS actividad, e.nombre AS evento
                             FROM actividades_pf a
                             JOIN eventos_pf e ON a.idEvento = e.idEvento
                             ORDER BY e.nombre, a.fecha, a.hora");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idUsuario = intval($_POST['usuario'] ?? 0);
    $idActividad = intval($_POST['actividad'] ?? 0);
    $fechaAsistencia = $_POST['fecha'] ?? $hoy;

    if ($idUsuario && $idActividad && $fechaAsistencia) {
        $stmt = $conn->prepare("INSERT INTO asistencias_pf (idUsuario, idActividad, fechaAsistencia) 
                                VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $idUsuario, $idActividad, $fechaAsistencia);
        if ($stmt->execute()) {
            $success = "✅ Asistencia registrada correctamente.";
        } else {
            $error = "❌ Error al registrar asistencia: " . $stmt->error;
        }
    } else {
        $error = "❌ Todos los campos son obligatorios.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registrar Asistencia</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4 bg-light">
<div class="container" style="max-width: 700px;">
    <h2 class="mb-3">Registrar Asistencia</h2>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php elseif ($success): ?>
        <div class="alert alert-success"><?= $success ?></div>
    <?php endif; ?>

    <form method="POST" class="border rounded p-4 bg-white shadow">
        <div class="mb-3">
            <label class="form-label">Participante</label>
            <select name="usuario" class="form-select" required>
                <option value="">Selecciona un participante</option>
                <?php while ($row = $usuarios->fetch_assoc()): ?>
                    <option value="<?= $row['idUsuario'] ?>"><?= $row['nombre'] ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Actividad</label>
            <select name="actividad" class="form-select" required>
                <option value="">Selecciona una actividad</option>
                <?php while ($row = $actividades->fetch_assoc()): ?>
                    <option value="<?= $row['idActividad'] ?>">
                        <?= $row['evento'] ?> - <?= $row['actividad'] ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Fecha de asistencia</label>
            <input type="date" name="fecha" class="form-control" value="<?= $hoy ?>" required>
        </div>

        <button type="submit" class="btn btn-primary">Guardar Asistencia</button>
    </form>
</div>
</body>
</html>