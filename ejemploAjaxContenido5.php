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
	$template->loadTemplatefile("./opcion5.html", true, true);
	
	$nombre = $_POST['nombre'];
	$numero = $_POST['numero'];

	$link = mysqli_connect($cfgServer['host'], $cfgServer['user'], $cfgServer['password']) or die('Could not connect: ' . mysqli_error($link)); 
	mysqli_select_db($link, $cfgServer['dbname']) or die("Could not select database"); 
	$query = "SELECT * FROM eventos_pf"; 

                $template->addBlockfile("CONTENIDO", "EVENTOS", "tabla5.html");                      
                                                                                                        
                $template->setCurrentBlock("EVENTOS");                                              
                $template->setVariable("MENSAJE_BIENVENIDA", "EVENTOS");                           
                                                                                                        
                // Ejecutamos el query                                                                  
                $result = mysqli_query($link, $query) or die("Query 1 failed");  

				while($line = mysqli_fetch_assoc($result)){                                                                                                                            
																									
					// Fijamos el bloque con la informacion de cada presidente                      
					$template->setCurrentBlock("EVENTO"); 

					 // Desplegamos la informacion de cada presidentes                               
					 $template->setVariable("ID_EVENTO", $line['idEvento']);                              
					 $template->setVariable("NOMBRE", $line['nombre']);                      																				 
					 $template->setVariable("FECHA_INICIO", $line['fechaInicio']);                      																				 
					 $template->setVariable("FECHA_FINAL", $line['fechaFinal']);                      																				 
					 $template->setVariable("UBICACION", $line['ubicacion']);                      																				 
					 $template->setVariable("DESCRIPCION", $line['descripcion']);                      																				 
					 $template->parseCurrentBlock("EVENTO");                                     
			  }// while                                                                              
																									 
																									 
			 $template->parseCurrentBlock("EVENTOS");                                            
			 // Liberamos memoria                                                                    
			 mysqli_free_result($result);                                                            
																									 
			 // Cerramos la conexion                                                                 
			 @mysqli_close($link);                                                                   
			         

	//$template->setVariable("ETIQUETA", " ");
	
	$template->parseCurrentBlock();
	
	$template->show();
?>