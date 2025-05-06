<?php
/*
 * @Author Atom Alexander M. Nava
 * @brief Archivo de configuración para la conexión a la base de datos
 *        Contiene las credenciales y establece la conexión.
 * @date 
 */

 // Configuración a la base de datos.
$host = "localhost";
$user = "";
$password = "";
$database = "";

// Crear conexión
$conn = new mysqli($host, $user, $password, $database);

// Verificar conexión
if ($conn -> connect_error) {
    die("Conn failed: ". $conn->connect_error);
}
?>