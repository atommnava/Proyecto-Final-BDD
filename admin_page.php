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
    <link rel="stylesheet" href="style2.css">
    <link rel="stylesheet" type="text/css" media="All" href="./css/ejemploAjaxStyle.css" />  
    <link rel="shortcut icon" href="../img/iconos/favicon.ico">
    <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
    <script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    <script src="./js/ejemploAjaxScripts.js"></script>
    <style>
        .admin-container {
            display: flex;
            flex-direction: column;
            width: 100%;
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
        }
        .admin-section {
            background: white;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .admin-section h2 {
            color: #1D5477;
            border-bottom: 2px solid #7494ec;
            padding-bottom: 10px;
        }
        .admin-actions {
            display: flex;
            gap: 10px;
            margin-top: 15px;
        }
        .admin-actions button {
            padding: 8px 15px;
            background: #7494ec;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        .consultas-container {
            margin-top: 30px;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
    </style>
</head>

<body style="background: #f5f5f5;">
    <div class="admin-container">
        <div class="box">
            <h1>Bienvenido, <span><?= htmlspecialchars($_SESSION['name']); ?></span></h1>
            <p>Panel de <span>Administración</span></p>
            <button onclick="window.location.href='logout.php'">Cerrar sesión</button>
        </div>

        <div class="admin-section">
            <h2>Gestión de Eventos</h2>
            <div class="admin-actions">
                <button onclick="window.location.href='agregar_evento.php'">Agregar Evento</button>
                <button onclick="cargarContenido('eventos')">Ver Todos</button>
            </div>
            <div id="eventos-content"></div>
        </div>

        <div class="admin-section">
            <h2>Gestión de Participantes</h2>
            <div class="admin-actions">
                <button onclick="window.location.href='agregar_participante.php'">Agregar Participante</button>
                <button onclick="cargarContenido('participantes')">Ver Todos</button>
            </div>
            <div id="participantes-content"></div>
        </div>

        <div class="admin-section">
            <h2>Gestión de Ponentes</h2>
            <div class="admin-actions">
                <button onclick="window.location.href='agregar_ponente.php'">Agregar Ponente</button>
                <button onclick="cargarContenido('ponentes')">Ver Todos</button>
            </div>
            <div id="ponentes-content"></div>
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
                        </ul>
                    </nav>
                </div>
                <div id="contenido" class="contenido"></div>
            </div>
        </div>

    </div>

    <script>
    function cargarContenido(tipo) {
        $.ajax({
            url: 'cargar_'+tipo+'.php',
            method: 'GET',
            success: function(response) {
                $('#'+tipo+'-content').html(response);
            },
            error: function(xhr) {
                alert('Error al cargar '+tipo+': ' + xhr.responseText);
            }
        });
    }
    </script>
</body>
</html>