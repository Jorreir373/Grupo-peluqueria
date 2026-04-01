<?php
session_start();
include "../conexion.php";

$usuario = $_POST['usuario'];
$password = $_POST['password'];

$consulta = mysqli_query($conexion, "SELECT * FROM usuarios WHERE usuario='$usuario' AND password='$password'");

if(mysqli_num_rows($consulta) > 0){
    $datos_usuario = mysqli_fetch_assoc($consulta);

    $_SESSION['id_usuario'] = $datos_usuario['id'];
    $_SESSION['usuario'] = $datos_usuario['usuario'];
    $_SESSION['nombre'] = $datos_usuario['nombre_completo'];
    $_SESSION['rol'] = $datos_usuario['rol'];
    
    // Redirigimos dependiendo el rol
    if($datos_usuario['rol'] == 'admin'){
        header("Location: ../admin.php");
    } else {
        header("Location: ../turnos.php");
    }
    
} else {
    header("Location: ../index.php?error=1");
}
?>