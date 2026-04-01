<?php
include "../conexion.php";

$id = $_POST["id"];
$del = mysqli_query($conexion, "DELETE FROM turnos WHERE id=$id");

// Respondemos
echo $del ? "Turno eliminado" : "Error al eliminar turno";
?>
