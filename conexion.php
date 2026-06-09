<?php
$host = "localhost";      
$user = "root";          
$password = "";          
$database = "tienda_abarrotes"; 

// Crear la conexión de forma segura
$conexion = new mysqli($host, $user, $password, $database);

// Comprobar si hubo un error al conectarse
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}


$conexion->set_charset("utf8");
?>