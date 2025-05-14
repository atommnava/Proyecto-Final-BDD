<?php
include "config.php";
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administrador</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" type="text/css" media="All" href="./css/ejemploAjaxStyle.css" />  
    <link rel="shortcut icon" href="../img/iconos/favicon.ico">
    <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
    <script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    <script src="./js/ejemploAjaxScripts.js"></script>
</head>

<body style="background: #f5f5f5;">
    <div class="admin-container">
        <div class="box" style="position: absolute; left: 50px; top: 1050px;">
            <h1>Bienvenido, <span><?= htmlspecialchars($_SESSION['name']); ?></span></h1>
            <p>Panel de <span>Administración</span></p>
            <button onclick="window.location.href='logout.php'">Cerrar sesión</button>
        </div>

        <div class="admin-section">
            <h2>Gestión de Eventos</h2>
            <div class="admin-actions">
                <button onclick="window.location.href='agregar_evento.php'">Agregar Evento</button>
            </div>
        </div>

        <div class="admin-section">
            <h2>Gestión de Participantes</h2>
            <div class="admin-actions">
                <button onclick="window.location.href='agregar_participante.php'">Agregar Participante</button>
            </div>
        </div>

        <div class="admin-section">
            <h2>Gestión de Ponentes</h2>
            <div class="admin-actions">
                <button onclick="window.location.href='agregar_ponente.php'">Agregar Ponente</button>
            </div>
        </div>

        <div class="admin-section">
            <h2>Gestión de Actividades</h2>
            <div class="admin-actions">
                <button onclick="window.location.href='agregar_actividad.php'">Agregar Actividad</button>
            </div>
        </div>

        <div class="admin-section">
            <h2>Registrar Asistencia</h2>
            <div class="admin-actions">
                <button onclick="window.location.href='registrar_asistencia.php'">Registrar Asistencia</button>
            </div>
        </div>

        <div class="consultas-container">
            <h2>Consultas Especiales</h2>
            <div class="wrapContenido layout">
                <div>
                    <nav>
                        <ul id="menu">
                            <li>
                                <a class="comLink" href="javascript:;" onclick="despliegaContenido(1, 'ejemplo1', 1);">
                                    <span class="menu_home">Consulta 1</span>
                                </a>
                            </li>
                            <li>
                                <a class="comLink" href="javascript:;" onclick="despliegaContenido(2, 'ejemplo2', 2);">
                                    <span class="menu_home">Consulta 2</span>
                                </a>
                            </li>
                            <li>
                                <a class="comLink" href="javascript:;" onclick="despliegaContenido(3, 'ejemplo3', 3);">
                                    <span class="menu_home">Consulta 3</span>
                                </a>
                            </li>
                            <li>
                                <a class="comLink" href="javascript:;" onclick="despliegaContenido(4, 'ejemplo4', 4);">
                                    <span class="menu_home">Consulta 4</span>
                                </a>
                            </li>
                            <li>
                                <a class="comLink" href="javascript:;" onclick="despliegaContenido(5, 'ejemplo5', 5);">
                                    <span class="menu_home">VER TODOS LOS EVENTOS</span>
                                </a>
                            </li>
                            
                        </ul>
                    </nav>
                </div>
                <div id="contenido" class="contenido"></div>
            </div>
        </div>

    </div>

    
</body>
</html>