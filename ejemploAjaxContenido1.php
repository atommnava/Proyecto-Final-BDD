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
	$template->loadTemplatefile("./opcion1.html", true, true);
	
	$nombre = $_POST['nombre'];
	$numero = $_POST['numero'];

	$link = mysqli_connect($cfgServer['host'], $cfgServer['user'], $cfgServer['password']) or die('Could not connect: ' . mysqli_error($link)); 
	mysqli_select_db($link, $cfgServer['dbname']) or die("Could not select database"); 
	$query = "SELECT * FROM usuarios_pf"; 

                $template->addBlockfile("CONTENIDO", "USUARIOS", "tabla.html");                      
                                                                                                        
                $template->setCurrentBlock("USUARIOS");                                              
                $template->setVariable("MENSAJE_BIENVENIDA", "Eventos con más asistentes.");                           
                                                                                                        
                // Ejecutamos el query                                                                  
                $result = mysqli_query($link, $query) or die("Query 1 failed");  

				while($line = mysqli_fetch_assoc($result)){                                                                                                                            
																									
					// Fijamos el bloque con la informacion de cada presidente                      
					$template->setCurrentBlock("USUARIO"); 

					 // Desplegamos la informacion de cada presidentes                               
					 $template->setVariable("ID_USUARIO", $line['idUsuario']);                              
					 $template->setVariable("NOMBRE", $line['nombre']);                      
					 $template->setVariable("CORREO", $line['correo']);                      
					 $template->setVariable("CONTRASENIA", $line['contrasenia']);                              
					 $template->setVariable("TIPO", $line['tipo']);                              
					                                       
																									 
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