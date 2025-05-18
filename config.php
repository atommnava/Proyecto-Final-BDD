<?php

// Configuración de parámetros del servidor

$cfgServer['host'] = '';
$cfgServer['user'] = '';
$cfgServer['password'] = '';
$cfgServer['dbname'] = '';

// Parámetros de conexión a la base de datos
$host = "";
$user = "";
$password = "";
$database = "";

// Crear conexión con MySQL utilizando mysqli
$conn = new mysqli($host, $user, $password, $database);

// Verificar si la conexión tuvo éxito
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
?>
