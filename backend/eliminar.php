<?php
include "../conexion.php";

// Recibimos el id del turno
$id = $_POST["id"];

// Eliminamos el registro
$del = mysqli_query($conexion, "DELETE FROM turnos WHERE id=$id");

// Respondemos
echo $del ? "Turno eliminado" : "Error al eliminar turno";
?>
