<?php
$servername = "localhost";
$database   = "turnos_peluqueria"; 
$username   = "root";
$password   = "";

// Conexión
$conexion = mysqli_connect($servername, $username, $password, $database);

// Verificación
if(!$conexion){
    die("Conexión falló: " . mysqli_connect_error());
}
?>