<?php
include "config.php";
session_start();

$query = "SELECT * FROM eventos_pf ORDER BY fechaInicio DESC";
$result = mysqli_query($link, $query);

echo '<table>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Fecha Inicio</th>
            <th>Fecha Fin</th>
            <th>Acciones</th>
        </tr>';

while ($evento = mysqli_fetch_assoc($result)) {
    echo '<tr>
            <td>'.$evento['idEvento'].'</td>
            <td>'.$evento['nombre'].'</td>
            <td>'.$evento['fechaInicio'].'</td>
            <td>'.$evento['fechaFinal'].'</td>
            <td>
                <a href="editar_evento.php?id='.$evento['idEvento'].'">Editar</a> | 
                <a href="eliminar_evento.php?id='.$evento['idEvento'].'" onclick="return confirm(\'¿Eliminar este evento?\')">Eliminar</a>
            </td>
        </tr>';
}

echo '</table>';
?>