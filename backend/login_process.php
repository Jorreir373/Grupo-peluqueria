<?php
session_start();
include "../conexion.php";

$usuario = $_POST['usuario'];
$password = $_POST['password']; // Lectura en texto plano

$query = mysqli_query($conexion, "SELECT * FROM usuarios WHERE usuario = '$usuario' AND password = '$password'");

if(mysqli_num_rows($query) > 0){
    // Si los datos coinciden, iniciamos la sesión
    $datos = mysqli_fetch_assoc($query);
    $_SESSION['id_usuario'] = $datos['id'];
    $_SESSION['nombre'] = $datos['nombre'];
    $_SESSION['rol'] = $datos['rol'];
    
    echo "ok"; // Respuesta de éxito para el AJAX
}else{
    echo "error"; // Respuesta de fallo
}
?>