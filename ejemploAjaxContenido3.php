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
	$template->loadTemplatefile("./opcion3.html", true, true);
	
	$nombre = $_POST['nombre'];
	$numero = $_POST['numero'];

	$link = mysqli_connect($cfgServer['host'], $cfgServer['user'], $cfgServer['password']) or die('Could not connect: ' . mysqli_error($link)); 
	mysqli_select_db($link, $cfgServer['dbname']) or die("Could not select database"); 
	$query = "SELECT idEvento, COUNT(idActividad) AS total FROM actividades_pf JOIN eventos_pf USING(idEvento)
	GROUP BY idEvento ORDER BY total DESC LIMIT 3"; 

                $template->addBlockfile("CONTENIDO", "USUARIOS", "tabla3.html");                      
                                                                                                        
                $template->setCurrentBlock("USUARIOS");                                              
                $template->setVariable("MENSAJE_BIENVENIDA", "Eventos con más actividades.");                           
                                                                                                        
                // Ejecutamos el query                                                                  
                $result = mysqli_query($link, $query) or die("Query 1 failed");  

				while($line = mysqli_fetch_assoc($result)){                                                                                                                            
																									
					// Fijamos el bloque con la informacion de cada presidente                      
					$template->setCurrentBlock("USUARIO"); 

					 // Desplegamos la informacion de cada presidentes                               
					 $template->setVariable("ID_EVENTO", $line['idEvento']);                              
					 $template->setVariable("TOTAL", $line['total']);                      																				 
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