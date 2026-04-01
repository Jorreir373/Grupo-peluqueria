<?php
include "../conexion.php";

$id = $_POST["id"];
$cliente = $_POST["cliente"];
$email = $_POST["email"];
$servicio = $_POST["servicio"];
$fecha = $_POST["fecha"];
$hora = $_POST["hora"];

$upd = mysqli_query($conexion,
"UPDATE turnos SET cliente='$cliente', email='$email', servicio='$servicio', fecha='$fecha', hora='$hora'
 WHERE id=$id");

echo $upd ? "Turno actualizado" : "Error al actualizar";
?>