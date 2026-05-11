<?php
include "../conexion.php";
// Borra todos los turnos cuya fecha sea menor al día de hoy
mysqli_query($conexion, "DELETE FROM turnos WHERE fecha < CURDATE()");
echo "ok";
?>