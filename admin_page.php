<?php

include "config.php";
session_start();

// It ensures that the user must log in before accessing the admin
// or user page
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
    <title>Página Admin</title>
    <link rel="stylesheet" href="style2.css">

    <link rel="stylesheet" type="text/css" media="All" href="./css/ejemploAjaxStyle.css" />  
	<link rel="shortcut icon" href="../img/iconos/favicon.ico">
		
	<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
	<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
		
	<script src="./js/ejemploAjaxScripts.js"></script>
</head>

<body style="background: #fff;">

		<div class="wrapContenido layout">
			<div>
				<nav>
					<ul id="menu">
						<li>
							<a class= "comLink" href="javascript:;" onclick="despliegaContenido(1, 'ejemplo1', 1);"><span class="menu_home">CONTENIDO 1</span></a>
							
						</li>
						<li>
							<a class= "comLink" href="javascript:;" onclick="despliegaContenido(2, 'ejemplo2', 2);"><span class="menu_home">CONTENIDO 2</span></a>
						</li>
						<li>
							<a class= "comLink" href="javascript:;" onclick="despliegaContenido(3, 'ejemplo3', 3);"><span class="menu_home">CONTENIDO 3</span></a>
						</li>
						<li>
							<a class= "comLink" href="javascript:;" onclick="despliegaContenido(4, 'ejemplo4', 4);"><span class="menu_home">CONTENIDO 4</span></a>
						</li>
						
					</ul>
				</nav>
			</div>
	
			<div id="contenido" class="contenido">
				
			</div>
		</div>

    <div class="box">
        <h1>Bienvenido, <span><?= $_SESSION['name']; ?></span></h1>
        <p>Esta es la <span>página</span> Admin</p>
        <button onclick="window.location.href='logout.php'">Cerrar sesión</button>
    </div>
</body>
</html>