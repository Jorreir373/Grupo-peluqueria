<?php
include "../conexion.php";

// Datos que vienen desde AJAX
$id = $_POST["id"];
$cliente = $_POST["cliente"];
$servicio = $_POST["servicio"];
$fecha = $_POST["fecha"];
$hora = $_POST["hora"];

// Actualizamos el turno
$upd = mysqli_query($conexion,
"UPDATE turnos SET cliente='$cliente', servicio='$servicio', fecha='$fecha', hora='$hora'
 WHERE id=$id");

// Respondemos
echo $upd ? "Turno actualizado" : "Error al actualizar";
?>
