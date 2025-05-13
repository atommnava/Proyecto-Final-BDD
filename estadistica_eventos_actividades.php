
<?php
session_start();
include "config.php";

if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}

$query = "
    SELECT e.nombreEvento, COUNT(r.idUsuario) AS total_asistentes
    FROM eventos_pf e
    JOIN registros r ON e.idEvento = r.idEvento
    GROUP BY e.idEvento
    ORDER BY total_asistentes DESC
    LIMIT 5
";

$result = $conn->query($query);
echo "<h2>Eventos con más asistentes</h2><ul>";
while ($row = $result->fetch_assoc()) {
    echo "<li>" . htmlspecialchars($row['nombreEvento']) . " - " . $row['total_asistentes'] . " asistentes</li>";
}
echo "</ul>";
?>
