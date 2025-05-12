<?php

$cfgServer['host'] = 'localhost';
$cfgServer['user'] = 'ict23amn';
$cfgServer['password'] = '258927';
$cfgServer['dbname'] = 'ict23amn';
/*
 * @Author Atom Alexander M. Nava
 * @brief Archivo de configuración para la conexión a la base de datos
 *        Contiene las credenciales y establece la conexión.
 * @date 
 */

 // Configuración a la base de datos.
$host = "localhost";
$user = "ict23amn";
$password = "258927";
$database = "ict23amn";

// Crear conexión
$conn = new mysqli($host, $user, $password, $database);

// Verificar conexión
if ($conn -> connect_error) {
    die("Conn failed: ". $conn->connect_error);
}
?>