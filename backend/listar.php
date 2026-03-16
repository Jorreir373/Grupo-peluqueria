<?php
include "../conexion.php";

// Se selecciona todos los turnos ordenados por fecha y hora
$consulta = mysqli_query($conexion, "SELECT * FROM turnos ORDER BY fecha, hora");

// Armamos la tabla HTML
echo "<table class='table table-bordered table-striped'>
        <tr>
            <th>Cliente</th>
            <th>Servicio</th>
            <th>Fecha</th>
            <th>Hora</th>
            <th>Acciones</th>
        </tr>";

// Recorremos los resultados y los mostramos en la tabla
while($fila = mysqli_fetch_assoc($consulta)){
    echo "<tr>
        <td><input id='c{$fila['id']}' class='form-control' value='{$fila['cliente']}'></td>
        <td><input id='s{$fila['id']}' class='form-control' value='{$fila['servicio']}'></td>
        <td><input id='f{$fila['id']}' type='date' class='form-control' value='{$fila['fecha']}'></td>
        <td><input id='h{$fila['id']}' type='time' class='form-control' value='{$fila['hora']}'></td>

        <td>
            <button class='btn btn-success btn-sm' onclick='editar({$fila['id']})'>Guardar</button>
            <button class='btn btn-danger btn-sm' onclick='borrar({$fila['id']})'>Eliminar</button>
        </td>
    </tr>";
}
echo "</table>";
?>
