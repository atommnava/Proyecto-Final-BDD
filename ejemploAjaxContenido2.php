<?php
	require_once "HTML/Template/ITX.php";
	include "config.php";
	
	// ========================================================================
	//
	// 	Cargamos el template y desplegamos la pagina 
	// 	del staff
	// 
	// ========================================================================
	$template = new HTML_Template_ITX('./templates');
	$template->loadTemplatefile("./opcion2.html", true, true);
	
	$nombre = $_POST['nombre'];
	$numero = $_POST['numero'];

	$link = mysqli_connect($cfgServer['host'], $cfgServer['user'], $cfgServer['password']) or die('Could not connect: ' . mysqli_error($link)); 
	mysqli_select_db($link, $cfgServer['dbname']) or die("Could not select database"); 
	$query = "SELECT      u.idUsuario,     u.nombre,     COUNT(a.idActividad) AS total_eventos FROM      usuarios_pf u JOIN      asistencias_pf a ON u.idUsuario = a.idUsuario GROUP BY      u.idUsuario, u.nombre ORDER BY      total_eventos DESC;"; 

                $template->addBlockfile("CONTENIDO", "USUARIOS", "tabla2.html");                      
                                                                                                        
                $template->setCurrentBlock("USUARIOS");                                              
                $template->setVariable("MENSAJE_BIENVENIDA", "Hola Usuario");                           
                                                                                                        
                // Ejecutamos el query                                                                  
                $result = mysqli_query($link, $query) or die("Query 1 failed");  

				while($line = mysqli_fetch_assoc($result)){                                                                                                                            
																									
					// Fijamos el bloque con la informacion de cada presidente                      
					$template->setCurrentBlock("USUARIO"); 

					 // Desplegamos la informacion de cada presidentes                               
					 $template->setVariable("ID_USUARIO", $line['idUsuario']);                              
					 $template->setVariable("NOMBRE", $line['nombre']);                      
					 $template->setVariable("TOTAL_EVENTOS", $line['total_eventos']);                                 
					                                       
																									 
					 $template->parseCurrentBlock("USUARIO");                                     
			  }// while                                                                              
																									 
																									 
			 $template->parseCurrentBlock("USUARIOS");                                            
			 // Liberamos memoria                                                                    
			 mysqli_free_result($result);                                                            
																									 
			 // Cerramos la conexion                                                                 
			 @mysqli_close($link);                                                                   
			         

	//$template->setVariable("ETIQUETA", " ");
	
	$template->parseCurrentBlock();
	
	$template->show();
?>