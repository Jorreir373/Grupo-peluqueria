<?php
$servername = "localhost";
$database   = "turnos_peluqueria"; 
$username   = "root";
$password   = "";

$conexion = mysqli_connect($servername, $username, $password, $database);

if(!$conexion){
    die("Conexión falló: " . mysqli_connect_error());
}
?>