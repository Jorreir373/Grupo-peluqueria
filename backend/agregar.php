<?php
include "../conexion.php";

// Recibimos los datos enviados desde AJAX
$cliente = $_POST["cliente"];
$servicio = $_POST["servicio"];
$fecha = $_POST["fecha"];
$hora = $_POST["hora"];

// Verificamos si ya existe un turno en el mismo horario
$duplicado = mysqli_query($conexion, 
"SELECT * FROM turnos WHERE fecha='$fecha' AND hora='$hora'");

if(mysqli_num_rows($duplicado) > 0){
    echo "⚠ Ya hay un turno registrado para ese horario";
    exit;
}

// Insertar turno nuevo
$insert = mysqli_query($conexion,
"INSERT INTO turnos(cliente,servicio,fecha,hora)
 VALUES('$cliente','$servicio','$fecha','$hora')");

// Mensaje de respuesta
echo $insert ? "Turno registrado correctamente" : "Error al registrar turno";
?>
