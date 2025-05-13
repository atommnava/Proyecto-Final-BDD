
<?php
session_start();
include "config.php";

if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}

$query = "
    SELECT u.nombre, COUNT(r.idEvento) AS total_eventos
    FROM usuarios_pf u
    JOIN registros r ON u.idUsuario = r.idUsuario
    GROUP BY u.idUsuario
    ORDER BY total_eventos DESC
    LIMIT 5
";

$result = $conn->query($query);
echo "<h2>Usuarios con más eventos registrados</h2><ul>";
while ($row = $result->fetch_assoc()) {
    echo "<li>" . htmlspecialchars($row['nombre']) . " - " . $row['total_eventos'] . " eventos</li>";
}
echo "</ul>";
?>
