<?php
session_start();
include "../conexion.php";

if(!isset($_SESSION['id_usuario']) || $_SESSION['rol'] != 'admin'){
    die("No autorizado");
}

$id = $_POST['id'];
$precio = $_POST['precio'];

$upd = mysqli_query($conexion, "UPDATE servicios SET precio = $precio WHERE id = $id");

echo $upd ? "Precio actualizado" : "Error";
?>