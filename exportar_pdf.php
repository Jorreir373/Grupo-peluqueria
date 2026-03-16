<?php
require 'conexion.php';//incluye el archivo donde está la conexión a la base de datos. Si no existe, da error y detiene el script.
require 'dompdf/autoload.inc.php';//carga automáticamente las clases necesarias de Dompdf.

use Dompdf\Dompdf;//indica que vamos a usar la clase Dompdf del paquete

// Se crea un nuevo objeto Dompdf, que es el motor encargado de convertir HTML --> PDF.
$dompdf = new Dompdf();

// Obtiene turnos
$result = mysqli_query($conexion, "SELECT * FROM turnos ORDER BY fecha, hora");

// Construimos el HTML
$html = '
<h2 style="text-align:center; margin-bottom:20px;">Peluquería Estilo Único<br>Listado de Turnos</h2>

<table border="1" width="100%" cellpadding="8" cellspacing="0">
<thead>
<tr style="background:#eee; font-weight:bold;">
<th>ID</th>
<th>Cliente</th>
<th>Servicio</th>
<th>Fecha</th>
<th>Hora</th>
</tr>
</thead>
<tbody>
';

while($fila = mysqli_fetch_assoc($result)) {

    
    $fecha_es = date("d/m/Y", strtotime($fila['fecha']));

    $html .= '
    <tr>
        <td>'.$fila['id'].'</td>
        <td>'.$fila['cliente'].'</td>
        <td>'.$fila['servicio'].'</td>
        <td>'.$fecha_es.'</td>
        <td>'.$fila['hora'].'</td>
    </tr>';
}


$html .= '
</tbody>
</table>
';

// Cargar HTML
$dompdf->loadHtml($html);

// Configurar tamaño de hoja
$dompdf->setPaper('A4', 'portrait');

// Renderizar PDF
$dompdf->render();

// Descargar archivo
$dompdf->stream("turnos_peluqueria.pdf", ["Attachment" => true]);
?>
