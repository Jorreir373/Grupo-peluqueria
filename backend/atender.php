<?php
include "../conexion.php";
$id = $_POST['id'];
// Cambia el estado de ese turno a 'atendido'
mysqli_query($conexion, "UPDATE turnos SET estado = 'atendido' WHERE id = '$id'");
echo "ok";
?>