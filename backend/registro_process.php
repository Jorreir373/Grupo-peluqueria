<?php
include "../conexion.php";

$nombre = $_POST['nombre'];
$usuario = $_POST['usuario'];
$password = $_POST['password']; // Se guarda en texto plano por ahora

// 1. Verificamos si el usuario ya existe para no duplicar
$check = mysqli_query($conexion, "SELECT * FROM usuarios WHERE usuario = '$usuario'");

if(mysqli_num_rows($check) > 0){
    echo "existe"; // Le avisamos a SweetAlert que ya está en uso
    exit;
}

// 2. Si no existe, lo insertamos. Le asignamos el rol de 'empleado' por defecto
$insertar = mysqli_query($conexion, "INSERT INTO usuarios (nombre, usuario, password, rol) VALUES ('$nombre', '$usuario', '$password', 'empleado')");

if($insertar){
    echo "ok";
} else {
    echo "error";
}
?>