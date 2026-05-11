<?php
include "../conexion.php";
$id = $_POST['id'];
$estado = $_POST['estado']; // Recibe 1 (Completado) o 0 (Pendiente)

mysqli_query($conexion, "UPDATE turnos SET estado = '$estado' WHERE id = '$id'");
echo "ok";
?>