<?php
session_start();
include "config.php";

if (!isset($_SESSION['idUsuario'])) {
    die("Sesión no válida.");
}

$idEmisor = $_SESSION['idUsuario'];
$eventos = $_POST['eventos'] ?? [];
$usuarios = $_POST['usuarios'] ?? [];

if (!empty($eventos) && !empty($usuarios)) {
    $stmt = $conn->prepare("INSERT INTO eventos_compartidos_pf (idUsuarioEmisor, idUsuarioReceptor, idEvento) VALUES (?, ?, ?)");
    foreach ($usuarios as $idReceptor) {
        foreach ($eventos as $idEvento) {
            $stmt->bind_param("iii", $idEmisor, $idReceptor, $idEvento);
            $stmt->execute();
        }
    }
    echo "<script>alert('Eventos compartidos exitosamente.'); window.location.href='compartir_eventos.php';</script>";
} else {
    echo "<script>alert('Debes seleccionar al menos un evento y un usuario.'); window.location.href='compartir_eventos.php';</script>";
}
?>