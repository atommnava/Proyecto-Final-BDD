<?php
session_start();
include "config.php";

if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Estadísticas del Sistema</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            background: #f4f4f4;
        }
        h1 {
            color: #444;
        }
        .button-container {
            margin-bottom: 20px;
        }
        button {
            background-color: #006699;
            color: white;
            border: none;
            padding: 12px 20px;
            margin: 5px;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.3s;
        }
        button:hover {
            background-color: #004466;
        }
        #contenido {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
    </style>
    <script>
        function cargarContenido(archivo) {
            const xhr = new XMLHttpRequest();
            xhr.open("GET", archivo, true);
            xhr.onload = function () {
                if (xhr.status === 200) {
                    document.getElementById("contenido").innerHTML = xhr.responseText;
                } else {
                    document.getElementById("contenido").innerHTML = "<p>Error al cargar estadísticas.</p>";
                }
            };
            xhr.send();
        }
    </script>
</head>
<body>
    <h1>Estadísticas del Sistema</h1>
    <div class="button-container">
        <button onclick="cargarContenido('estadistica_eventos_asistentes.php')">Eventos con más asistentes</button>
        <button onclick="cargarContenido('estadistica_usuarios_eventos.php')">Usuarios con más eventos</button>
        <button onclick="cargarContenido('estadistica_eventos_actividades.php')">Eventos con más actividades</button>
        <button onclick="cargarContenido('estadistica_totales.php')">Totales del sistema</button>
    </div>
    <div id="contenido">
        <p>Selecciona una opción para mostrar los datos.</p>
    </div>
</body>
</html>
