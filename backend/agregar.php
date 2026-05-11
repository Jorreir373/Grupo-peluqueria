<?php
session_start();
include "../conexion.php";

// Recibimos los datos de JavaScript
$cliente = $_POST['cliente'];
$telefono = $_POST['telefono']; // Actualizado a teléfono
$servicio = $_POST['servicio'];
$fecha = $_POST['fecha'];
$hora = $_POST['hora'];
$id_usuario = $_SESSION['id_usuario'];

// Validamos que no haya un turno ocupado a esa misma hora y fecha
$check = mysqli_query($conexion, "SELECT * FROM turnos WHERE fecha='$fecha' AND hora='$hora'");
if(mysqli_num_rows($check) > 0){
    echo "⚠"; // Símbolo de error para que JavaScript lo detecte
    exit;
}

// Insertamos el turno
$insert = mysqli_query($conexion, "INSERT INTO turnos (cliente, telefono, servicio, fecha, hora, id_usuario) VALUES ('$cliente', '$telefono', '$servicio', '$fecha', '$hora', '$id_usuario')");

echo $insert ? "Turno guardado" : "Error al guardar";
?>