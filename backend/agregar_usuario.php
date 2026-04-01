<?php
session_start();
include "../conexion.php";

if(!isset($_SESSION['id_usuario']) || $_SESSION['rol'] != 'admin'){
    die("Acceso denegado");
}

$nombre = $_POST['nombre'];
$usuario = $_POST['usuario'];
$password = $_POST['password'];
$rol = 'empleado';

$insertar = mysqli_query($conexion, 
    "INSERT INTO usuarios (nombre_completo, usuario, password, rol) 
     VALUES ('$nombre', '$usuario', '$password', '$rol')");

if($insertar){
    header("Location: ../admin.php?msj=usuario_creado");
} else {
    echo "Error al crear el usuario: " . mysqli_error($conexion);
}
?>