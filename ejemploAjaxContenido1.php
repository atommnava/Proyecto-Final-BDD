<?php
	require_once "HTML/Template/ITX.php";
	include "config.php";

	// ========================================================================
	// 	Cargamos el template y desplegamos la página de eventos con más asistentes
	// ========================================================================
	$template = new HTML_Template_ITX('./templates');
	$template->loadTemplatefile("./opcion1.html", true, true);

	// Conexión a la base de datos
	$link = mysqli_connect($cfgServer['host'], $cfgServer['user'], $cfgServer['password']) 
		or die('No se pudo conectar: ' . mysqli_error($link)); 
	mysqli_select_db($link, $cfgServer['dbname']) or die("No se pudo seleccionar la base de datos");

	// Consulta: eventos con más asistentes
	$query = "
		SELECT e.idEvento, e.nombre AS nombreEvento, COUNT(i.idUsuario) AS totalAsistentes
		FROM eventos_pf e
		LEFT JOIN inscripciones_pf i ON e.idEvento = i.idEvento
		GROUP BY e.idEvento
		ORDER BY totalAsistentes DESC
	";

	// Cargar plantilla de tabla
	$template->addBlockfile("CONTENIDO", "USUARIOS", "tabla.html");                      
	$template->setCurrentBlock("USUARIOS");                                              
	$template->setVariable("MENSAJE_BIENVENIDA", "Eventos con más asistentes.");                           

	// Ejecutar consulta
	$result = mysqli_query($link, $query) or die("Consulta fallida");

	while ($line = mysqli_fetch_assoc($result)) {                                                                                                                            
		$template->setCurrentBlock("USUARIO");

		$template->setVariable("ID_EVENTO", $line['idEvento']);                              
		$template->setVariable("NOMBRE_EVENTO", $line['nombreEvento']);                      
		$template->setVariable("TOTAL_ASISTENTES", $line['totalAsistentes']);                      
		$template->parseCurrentBlock("USUARIO");                                     
	}

	$template->parseCurrentBlock("USUARIOS");                                            
	mysqli_free_result($result);                                                            
	@mysqli_close($link);                                                                   

	$template->parseCurrentBlock();
	$template->show();
?>