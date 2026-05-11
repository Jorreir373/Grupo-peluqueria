<?php
include "../conexion.php"; 
$hoy = date('Y-m-d');

// 1. Buscamos los turnos PENDIENTES (Hoy o futuro, y que NO estén atendidos)
$query_pendientes = mysqli_query($conexion, "SELECT * FROM turnos WHERE fecha >= '$hoy' AND (estado = 'pendiente' OR estado IS NULL) ORDER BY fecha ASC, hora ASC");

// 2. Buscamos los turnos ATENDIDOS (Hoy o futuro, y que SÍ estén atendidos)
$query_atendidos = mysqli_query($conexion, "SELECT * FROM turnos WHERE fecha >= '$hoy' AND estado = 'atendido' ORDER BY fecha ASC, hora ASC");

// 3. Buscamos los turnos VIEJOS
$query_viejos = mysqli_query($conexion, "SELECT * FROM turnos WHERE fecha < '$hoy' ORDER BY fecha DESC, hora DESC");
$hay_viejos = mysqli_num_rows($query_viejos) > 0 ? 1 : 0;

echo "<input type='hidden' id='hay_viejos_flag' value='{$hay_viejos}'>";

// -----------------------------------------------------------------
// TABLA 1: TURNOS PENDIENTES (Los que faltan venir)
// -----------------------------------------------------------------
echo '<div class="mb-5">
        <h6 class="fw-bold mb-3" style="color: var(--color-acento);"><i class="bi bi-calendar2-check me-2"></i>Turnos Pendientes</h6>';

if(mysqli_num_rows($query_pendientes) > 0){
    echo '<table class="table-custom w-100">
            <thead>
                <tr>
                    <th>Cliente</th>
                    <th>WhatsApp</th>
                    <th>Servicio</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th class="text-end">Acciones</th>
                </tr>
            </thead>
            <tbody>';
    
    $delay = 0;
    while($row = mysqli_fetch_assoc($query_pendientes)){
        $id = $row['id'];
        
        echo "<tr id='fila-{$id}' class='animate__animated animate__fadeInUp' style='animation-delay: {$delay}s;'>
                <td class='p-3'><input type='text' id='c{$id}' class='form-control input-tabla fw-bold' value='{$row['cliente']}' onchange='mostrarGuardar({$id})'></td>
                <td class='p-3'><input type='number' id='e{$id}' class='form-control input-tabla' value='{$row['telefono']}' onchange='mostrarGuardar({$id})'></td>
                <td class='p-3'><input type='text' id='s{$id}' class='form-control input-tabla text-primary' value='{$row['servicio']}' onchange='mostrarGuardar({$id})'></td>
                <td class='p-3'><input type='date' id='f{$id}' class='form-control input-tabla' value='{$row['fecha']}' onchange='mostrarGuardar({$id})'></td>
                <td class='p-3'><input type='time' id='h{$id}' class='form-control input-tabla' value='{$row['hora']}' onchange='mostrarGuardar({$id})'></td>
                <td class='p-3 text-end text-nowrap'>
                    <button id='btn-guardar-{$id}' class='btn btn-success btn-sm btn-icono btn-guardar-oculto me-1 shadow-sm' onclick='editar({$id})' title='Guardar cambios'><i class='bi bi-check2-all'></i></button>
                    
                    <button class='btn btn-outline-success btn-sm btn-icono shadow-sm me-1' onclick='marcarAtendido({$id})' title='Marcar como Atendido'><i class='bi bi-person-check-fill'></i></button>
                    
                    <button class='btn btn-outline-danger btn-sm btn-icono shadow-sm' onclick='borrar({$id})' title='Eliminar turno'><i class='bi bi-trash3-fill'></i></button>
                </td>
              </tr>";
        $delay += 0.05;
    }
    echo '</tbody></table></div>';
} else {
    echo '<div class="alert text-center rounded-4 border-0 p-4" style="background-color: var(--bg-input); color: var(--texto-secundario);">
            <i class="bi bi-calendar2-x fs-1 d-block mb-3 animate__animated animate__pulse animate__infinite"></i>
            <h6 class="fw-bold m-0">No hay turnos pendientes</h6>
            <small>¡Excelente! Ya atendiste a todos por hoy.</small>
          </div></div>';
}

// -----------------------------------------------------------------
// TABLA 2: CLIENTES ATENDIDOS (Tu nueva idea, la lista verde)
// -----------------------------------------------------------------
if(mysqli_num_rows($query_atendidos) > 0){
    echo '<div class="mb-5 animate__animated animate__fadeIn">
            <h6 class="fw-bold mb-3 text-success"><i class="bi bi-check-circle-fill me-2"></i>Clientes Atendidos</h6>
            <table class="table-custom w-100">
                <thead>
                    <tr><th>Cliente</th><th>Servicio</th><th>Fecha</th><th>Hora</th><th class="text-end">Limpiar</th></tr>
                </thead>
                <tbody>';
    while($row = mysqli_fetch_assoc($query_atendidos)){
        $id = $row['id'];
        echo "<tr id='fila-{$id}' class='fila-atendida'>
                <td class='p-3 fw-bold'>
                    <i class='bi bi-check2-all me-2 text-success'></i>{$row['cliente']}
                </td>
                <td class='p-3'>{$row['servicio']}</td>
                <td class='p-3'>{$row['fecha']}</td>
                <td class='p-3'>{$row['hora']}</td>
                <td class='p-3 text-end'>
                    <button class='btn btn-outline-danger btn-sm btn-icono shadow-sm' onclick='borrar({$id})' title='Eliminar registro'><i class='bi bi-trash3-fill'></i></button>
                </td>
              </tr>";
    }
    echo '</tbody></table></div>';
}

// -----------------------------------------------------------------
// TABLA 3: TURNOS VIEJOS (Historial silencioso)
// -----------------------------------------------------------------
if($hay_viejos){
    echo '<div id="contenedor-viejos" style="display: none;" class="mt-5 pt-4 border-top">
            <h6 class="fw-bold mb-3 text-danger"><i class="bi bi-clock-history me-2"></i>Historial de Turnos Pasados</h6>
            <table class="table-custom w-100 opacity-75">
                <thead>
                    <tr><th>Cliente</th><th>Servicio</th><th>Fecha</th><th>Hora</th><th class="text-end">Limpiar</th></tr>
                </thead>
                <tbody>';
    while($row = mysqli_fetch_assoc($query_viejos)){
        $id = $row['id'];
        $estado = isset($row['estado']) ? $row['estado'] : 'pendiente';
        $badge = ($estado == 'atendido') ? "<span class='badge bg-success ms-2'>Atendido</span>" : "";
        
        echo "<tr id='fila-{$id}'>
                <td class='p-3 fw-bold'>{$row['cliente']} {$badge}</td>
                <td class='p-3'>{$row['servicio']}</td>
                <td class='p-3'>{$row['fecha']}</td>
                <td class='p-3'>{$row['hora']}</td>
                <td class='p-3 text-end'>
                    <button class='btn btn-danger btn-sm btn-icono' onclick='borrar({$id})'><i class='bi bi-trash'></i></button>
                </td>
              </tr>";
    }
    echo '</tbody></table></div>';
}
?>