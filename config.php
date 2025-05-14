<?php

// Configuración de parámetros del servidor

$cfgServer['host'] = 'localhost';
$cfgServer['user'] = 'ict23amn';
$cfgServer['password'] = '258927';
$cfgServer['dbname'] = 'ict23amn';

// Parámetros de conexión a la base de datos
$host = "localhost";
$user = "ict23amn";
$password = "258927";
$database = "ict23amn";

// Crear conexión con MySQL utilizando mysqli
$conn = new mysqli($host, $user, $password, $database);

// Verificar si la conexión tuvo éxito
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
?>
