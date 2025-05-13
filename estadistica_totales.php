
<?php
session_start();
include "config.php";

if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}

$hoy = date("Y-m-d");

$query = "
    SELECT
        COUNT(*) AS total,
        SUM(CASE WHEN fechaEvento < '$hoy' THEN 1 ELSE 0 END) AS pasados,
        SUM(CASE WHEN fechaEvento >= '$hoy' THEN 1 ELSE 0 END) AS proximos
    FROM eventos_pf
";

$result = $conn->query($query);
$data = $result->fetch_assoc();

echo "<h2>Totales del sistema</h2><ul>";
echo "<li>Total de eventos registrados: " . $data['total'] . "</li>";
echo "<li>Eventos pasados: " . $data['pasados'] . "</li>";
echo "<li>Eventos próximos: " . $data['proximos'] . "</li>";
echo "</ul>";
?>
