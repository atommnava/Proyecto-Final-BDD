<?php
/*
 * @file logout.php
 * @brief Termina la sesión actual del usuario y redirige al inicio.
 * @date 12-05-2025
 * @author Atom Nava, Julen Franco
 *
 * Este script realiza las siguientes acciones:
 * 1. Inicia o continúa la sesión actual.
 * 2. Elimina todas las variables de sesión.
 * 3. Destruye completamente la sesión en el servidor.
 * 4. Redirige al usuario a la página principal (index.php).
 */

// 1. Iniciar o continuar la sesión actual
session_start();                

// 2. Eliminar todas las variables de sesión
session_unset();                

// 3. Destruir la sesión actual (borra los datos en el servidor)
session_destroy();              

// 4. Redireccionar al usuario al inicio del sitio
header("Location: index.php");  

// Asegura que no se ejecute más código después de la redirección
exit();                         

?>
