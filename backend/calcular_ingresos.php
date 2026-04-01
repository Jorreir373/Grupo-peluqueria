<?php
session_start();
include "../conexion.php";

if(!isset($_SESSION['id_usuario']) || $_SESSION['rol'] != 'admin'){
    echo json_encode(['error' => 'No autorizado']);
    exit;
}

$consulta = mysqli_query($conexion, "
    SELECT SUM(s.precio) as total 
    FROM turnos t
    JOIN servicios s ON t.servicio = s.nombre
");

$resultado = mysqli_fetch_assoc($consulta);
$total = $resultado['total'] ?? 0;

$total_formateado = "$" . number_format($total, 0, ',', '.');

sleep(1);
echo json_encode(['ingresos' => $total_formateado]);
?>