<?php
error_reporting(0);
session_start();
include "../conexion.php";

$usuario = $_POST['usuario'];
$password = $_POST['password'];

$query = mysqli_query($conexion, "SELECT * FROM usuarios WHERE usuario = '$usuario' AND password = '$password'");

if(mysqli_num_rows($query) > 0){
    $datos = mysqli_fetch_assoc($query);
    $_SESSION['id_usuario'] = $datos['id'];
    $_SESSION['nombre'] = $datos['nombre'];
    $_SESSION['rol'] = $datos['rol'];
    
    // AQUÍ ESTÁ LA LÓGICA DE REDIRECCIÓN:
    if($datos['rol'] == 'admin') {
        echo "admin.php"; // Si es admin, le decimos que vaya a admin.php
    } else {
        echo "turnos.php"; // Si es empleado (o cualquier otro), va a turnos.php
    }
} else {
    echo "error"; // Si los datos están mal
}
exit();
?>