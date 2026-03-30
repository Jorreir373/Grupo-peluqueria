<?php
include "../conexion.php";

$consulta = mysqli_query($conexion, "SELECT * FROM turnos ORDER BY fecha, hora");

echo "<table class='table table-borderless align-middle w-100'>
        <thead>
            <tr>
                <th>Cliente</th>
                <th>Email</th>
                <th>Servicio</th>
                <th>Fecha</th>
                <th>Hora</th>
                <th class='text-center'>Acciones</th>
            </tr>
        </thead>
        <tbody>";

while($fila = mysqli_fetch_assoc($consulta)){
    echo "<tr id='fila-{$fila['id']}'>
        <td><input id='c{$fila['id']}' class='form-control input-tabla' value='{$fila['cliente']}' oninput='mostrarGuardar({$fila['id']})'></td>
        
        <td><input id='e{$fila['id']}' type='email' class='form-control input-tabla' value='{$fila['email']}' oninput='mostrarGuardar({$fila['id']})'></td>
        
        <td>
            <select id='s{$fila['id']}' class='form-select input-tabla' onchange='mostrarGuardar({$fila['id']})'>
                <option value='Corte de pelo' ".($fila['servicio']=='Corte de pelo'?'selected':'').">Corte de pelo</option>
                <option value='Tinte / Coloración' ".($fila['servicio']=='Tinte / Coloración'?'selected':'').">Tinte / Coloración</option>
                <option value='Peinado' ".($fila['servicio']=='Peinado'?'selected':'').">Peinado</option>
                <option value='Barbería' ".($fila['servicio']=='Barbería'?'selected':'').">Barbería</option>
            </select>
        </td>
        
        <td><input id='f{$fila['id']}' type='date' class='form-control input-tabla' value='{$fila['fecha']}' onchange='mostrarGuardar({$fila['id']})'></td>
        <td><input id='h{$fila['id']}' type='time' class='form-control input-tabla' value='{$fila['hora']}' oninput='mostrarGuardar({$fila['id']})'></td>

        <td class='text-center'>
            <div class='d-flex justify-content-center gap-2'>
                <button id='btn-guardar-{$fila['id']}' class='btn btn-success btn-icono btn-guardar-oculto' onclick='editar({$fila['id']})' title='Guardar cambios'>
                    <i class='bi bi-check-lg'></i>
                </button>
                <button class='btn btn-outline-danger btn-icono border-0' onclick='borrar({$fila['id']})' title='Eliminar turno'>
                    <i class='bi bi-trash3'></i>
                </button>
            </div>
        </td>
    </tr>";
}
echo "</tbody></table>";
?>