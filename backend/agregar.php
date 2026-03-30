<?php
include "../conexion.php";

$cliente = $_POST["cliente"];
$email = $_POST["email"]; // Recibimos el email
$servicio = $_POST["servicio"];
$fecha = $_POST["fecha"];
$hora = $_POST["hora"];

$duplicado = mysqli_query($conexion, "SELECT * FROM turnos WHERE fecha='$fecha' AND hora='$hora'");

if(mysqli_num_rows($duplicado) > 0){
    echo "⚠ Ya hay un turno registrado para ese horario";
    exit;
}

// Insertamos incluyendo el email
$insert = mysqli_query($conexion,
"INSERT INTO turnos(cliente, email, servicio, fecha, hora)
 VALUES('$cliente', '$email', '$servicio', '$fecha', '$hora')");

if($insert){
    // --- LÓGICA DE ENVÍO DE EMAIL ---
    $destinatario = $email;
    $asunto = "Confirmacion de Turno - Estilo Unico";
    
    // Cuerpo del correo
    $mensaje = "Hola $cliente,\n\n";
    $mensaje .= "Tu turno ha sido confirmado con éxito.\n\n";
    $mensaje .= "Detalles del turno:\n";
    $mensaje .= "- Servicio: $servicio\n";
    $mensaje .= "- Fecha: $fecha\n";
    $mensaje .= "- Hora: $hora\n\n";
    $mensaje .= "¡Te esperamos en Estilo Único!";
    
    // Headers del correo
    $headers = "From: no-reply@estilounico.com\r\n";
    $headers .= "Reply-To: contacto@estilounico.com\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion();

    // El @ suprime errores visuales en localhost si no tenés configurado el servidor SMTP de PHP
    @mail($destinatario, $asunto, $mensaje, $headers);

    echo "Turno registrado correctamente";
} else {
    echo "Error al registrar turno";
}
?>