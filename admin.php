<?php
session_start();
include "conexion.php";

if(!isset($_SESSION['id_usuario']) || $_SESSION['rol'] != 'admin'){
    header("Location: index.php"); 
    exit;
}

$q_turnos = mysqli_query($conexion, "SELECT COUNT(*) as total FROM turnos");
$total_turnos = mysqli_fetch_assoc($q_turnos)['total'];

$q_empleados = mysqli_query($conexion, "SELECT COUNT(*) as total FROM usuarios WHERE rol='empleado'");
$total_empleados = mysqli_fetch_assoc($q_empleados)['total'];

$lista_personal = mysqli_query($conexion, "SELECT * FROM usuarios WHERE rol='empleado' ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="es" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estilo Único | Admin Dashboard</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    
    <style>
        :root {
            --bg-fondo: #f4f6f9; 
            --bg-tarjeta: #ffffff;
            --texto-principal: #111827;
            --texto-secundario: #6b7280;
            --borde: #e5e7eb;
            --bg-input: #f9fafb;
            --color-acento: #4f46e5;
        }

        [data-theme="dark"] {
            --bg-fondo: #0f172a; 
            --bg-tarjeta: #1e293b;
            --texto-principal: #f8fafc;
            --texto-secundario: #94a3b8;
            --borde: #334155;
            --bg-input: #0b1120;
        }

        body {
            background-color: var(--bg-fondo);
            color: var(--texto-principal);
            font-family: 'Inter', system-ui, sans-serif;
            transition: all 0.3s ease;
            padding-bottom: 3rem;
        }
        
        h1, h2, h3, h4, h5, h6, label, span { color: var(--texto-principal) !important; }
        .text-muted { color: var(--texto-secundario) !important; }

        .card-custom {
            border: 1px solid var(--borde);
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            background-color: var(--bg-tarjeta) !important;
        }

        .form-control, .form-select {
            border-radius: 10px;
            border: 1px solid var(--borde) !important;
            background-color: var(--bg-input) !important;
            color: var(--texto-principal) !important;
            padding: 0.75rem 1rem;
        }
        
        .form-control:focus, .form-select:focus {
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.2);
            border-color: var(--color-acento) !important;
        }

        ::-webkit-input-placeholder { color: #9ca3af !important; opacity: 1 !important; }
        ::placeholder { color: #9ca3af !important; opacity: 1 !important; }

        .btn-principal {
            background-color: var(--color-acento);
            color: white !important;
            border-radius: 10px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            border: none;
            transition: all 0.3s;
        }
        .btn-principal:hover { transform: translateY(-2px); filter: brightness(1.1); }

        .navbar-custom {
            background-color: var(--bg-tarjeta);
            border-bottom: 1px solid var(--borde);
            padding: 1rem 2rem;
        }

        /* --- ARREGLO DE LA TABLA --- */
        .table-custom {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 8px;
        }
        .table-custom tr { background-color: var(--bg-input); }
        .table-custom th { color: var(--texto-secundario); font-size: 0.85rem; text-transform: uppercase; padding: 1rem; border: none; text-align: left;}
        .table-custom td { color: var(--texto-principal); padding: 1rem; vertical-align: middle; border: none; }
        .table-custom td:first-child { border-top-left-radius: 10px; border-bottom-left-radius: 10px; }
        .table-custom td:last-child { border-top-right-radius: 10px; border-bottom-right-radius: 10px; }
        
        #btn-tema { background: transparent; border: 1px solid var(--borde); color: var(--texto-principal); border-radius: 50%; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.3s; }
        #btn-tema:hover { background-color: var(--bg-input); }

        /* --- ARREGLO SWEETALERT2 MODO OSCURO --- */
        .swal2-popup {
            background-color: var(--bg-tarjeta) !important;
            color: var(--texto-principal) !important;
            border: 1px solid var(--borde);
            border-radius: 16px !important;
        }
        .swal2-title, .swal2-html-container {
            color: var(--texto-principal) !important;
        }
        .swal2-success-circular-line-left, 
        .swal2-success-circular-line-right, 
        .swal2-success-fix {
            background-color: var(--bg-tarjeta) !important;
        }
    </style>
</head>
<body>

    <nav class="navbar-custom d-flex justify-content-between align-items-center mb-5 animate__animated animate__fadeInDown">
        <h4 class="m-0 fw-bold"><i class="bi bi-shield-lock text-primary me-2"></i>Panel de Control</h4>
        <div class="d-flex align-items-center gap-3">
            <button id="btn-tema" onclick="toggleTema()" title="Cambiar Tema"><i class="bi bi-sun-fill" id="icono-tema"></i></button>
            <span class="fw-bold d-none d-md-block"><i class="bi bi-person-circle me-1"></i> Hola, <?php echo $_SESSION['nombre']; ?></span>
            <a href="turnos.php" class="btn btn-outline-primary btn-sm rounded-pill px-3">Ir a Turnos</a>
            <a href="backend/logout.php" class="btn btn-outline-danger btn-sm rounded-pill px-3"><i class="bi bi-box-arrow-right"></i></a>
        </div>
    </nav>

    <div class="container" style="max-width: 1100px;">
        
        <div class="row g-4 mb-4 animate__animated animate__fadeInUp">
            
            <div class="col-lg-4 col-md-6">
                <div class="card card-custom p-4 d-flex flex-row align-items-center h-100">
                    <div class="bg-primary bg-opacity-10 p-3 rounded-4 me-3 h3 m-0" style="color: var(--color-acento);"><i class="bi bi-calendar-check"></i></div>
                    <div>
                        <h6 class="text-muted m-0 text-uppercase fw-bold" style="font-size: 0.75rem;">Turnos Totales</h6>
                        <h2 class="fw-bold m-0 fs-2"><?php echo $total_turnos; ?></h2>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="card card-custom p-4 d-flex flex-row align-items-center h-100">
                    <div class="bg-success bg-opacity-10 p-3 rounded-4 me-3 h3 m-0 text-success"><i class="bi bi-people"></i></div>
                    <div>
                        <h6 class="text-muted m-0 text-uppercase fw-bold" style="font-size: 0.75rem;">Empleados Activos</h6>
                        <h2 class="fw-bold m-0 fs-2"><?php echo $total_empleados; ?></h2>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-12">
                <div class="card card-custom p-4 d-flex flex-row align-items-center h-100">
                    <div class="bg-warning bg-opacity-10 p-3 rounded-4 me-3 h3 m-0 text-warning"><i class="bi bi-cash-coin"></i></div>
                    <div>
                        <h6 class="text-muted m-0 text-uppercase fw-bold" style="font-size: 0.75rem;">Ingresos Estimados</h6>
                        
                        <div id="loader-ingresos" class="d-flex align-items-center mt-1">
                            <div class="spinner-border spinner-border-sm text-warning me-2" role="status"></div>
                            <span class="small text-muted animate__animated animate__pulse animate__infinite">Calculando...</span>
                        </div>
                        
                        <h2 id="valor-ingresos" class="fw-bold m-0 fs-2 text-warning d-none animate__animated animate__flipInX"></h2>
                    </div>
                </div>
            </div>

        </div>

        <div class="card card-custom p-4 mb-4 animate__animated animate__fadeInUp" style="animation-delay: 0.1s;">
            <h5 class="fw-bold mb-4"><i class="bi bi-person-plus me-2 text-primary"></i>Registrar Nuevo Personal</h5>
            
            <form action="backend/agregar_usuario.php" method="POST">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label small fw-bold text-muted">NOMBRE COMPLETO</label>
                        <input type="text" name="nombre" class="form-control" required placeholder="Ej: Carlos Gómez">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small fw-bold text-muted">NUEVO USUARIO</label>
                        <input type="text" name="usuario" class="form-control" required placeholder="Ej: cgomez">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small fw-bold text-muted">CONTRASEÑA TEMPORAL</label>
                        <input type="password" name="password" class="form-control" required placeholder="Mínimo 6 caracteres">
                    </div>
                </div>
                <div class="mt-4 text-end">
                    <button type="submit" class="btn-principal"><i class="bi bi-check2-circle me-1"></i> Crear Cuenta</button>
                </div>
            </form>
        </div>

        <div class="card card-custom p-4 mb-4 animate__animated animate__fadeInUp" style="animation-delay: 0.2s;">
            <h5 class="fw-bold mb-3"><i class="bi bi-card-list me-2 text-primary"></i>Equipo de Trabajo</h5>
            
            <div class="table-responsive">
                <table class="table-custom">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre Completo</th>
                            <th>Usuario de Ingreso</th>
                            <th>Rol</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        if(mysqli_num_rows($lista_personal) > 0){
                            while($emp = mysqli_fetch_assoc($lista_personal)){
                                echo "<tr>
                                        <td><span class='badge bg-secondary bg-opacity-25 text-secondary border border-secondary'>#{$emp['id']}</span></td>
                                        <td class='fw-bold'>{$emp['nombre_completo']}</td>
                                        <td><code>@{$emp['usuario']}</code></td>
                                        <td><span class='badge bg-primary bg-opacity-25 text-primary border border-primary'>Empleado</span></td>
                                      </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='4' class='text-center text-muted py-4'>Aún no hay empleados registrados.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card card-custom p-4 animate__animated animate__fadeInUp" style="animation-delay: 0.3s;">
            <h5 class="fw-bold mb-3"><i class="bi bi-tag me-2 text-primary"></i>Gestión de Precios de Servicios</h5>
            <div class="table-responsive">
                <table class="table-custom">
                    <thead>
                        <tr>
                            <th>Servicio</th>
                            <th>Precio Actual</th>
                            <th class="text-end">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $servs = mysqli_query($conexion, "SELECT * FROM servicios");
                        while($s = mysqli_fetch_assoc($servs)){
                            echo "<tr>
                                    <td class='fw-bold'>{$s['nombre']}</td>
                                    <td>
                                        <div class='input-group' style='max-width: 200px;'>
                                            <span class='input-group-text bg-transparent border-0'>$</span>
                                            <input type='number' id='precio-{$s['id']}' class='form-control' value='{$s['precio']}'>
                                        </div>
                                    </td>
                                    <td class='text-end'>
                                        <button class='btn btn-success btn-sm px-3' onclick='actualizarPrecio({$s['id']})'>
                                            <i class='bi bi-save'></i> Actualizar
                                        </button>
                                    </td>
                                </tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <script>

const Toast = Swal.mixin({
    toast: true,
    position: 'bottom-end',
    showConfirmButton: false,
    timer: 4000,
    timerProgressBar: true,
    background: 'var(--bg-tarjeta)',
    color: 'var(--texto-principal)',
    iconColor: '#4f46e5',
    didOpen: (toast) => {
        toast.onmouseenter = Swal.stopTimer;
        toast.onmouseleave = Swal.resumeTimer;
    }
});

function toggleTema() {
    let html = document.documentElement;
    let icono = document.getElementById("icono-tema");
    if (html.getAttribute('data-theme') === 'dark') {
        html.setAttribute('data-theme', 'light');
        localStorage.setItem('tema', 'light');
        icono.className = 'bi bi-moon-stars-fill';
    } else {
        html.setAttribute('data-theme', 'dark');
        localStorage.setItem('tema', 'dark');
        icono.className = 'bi bi-sun-fill';
    }
}

function actualizarPrecio(id) {
    let nuevoPrecio = $("#precio-" + id).val();
    
    $.post("backend/editar_precio.php", {id: id, precio: nuevoPrecio}, function(resp) {
        if(resp.includes("actualizado")) {
            Swal.fire({ icon: 'success', title: 'Precio actualizado', timer: 1000, showConfirmButton: false });
            cargarIngresos(); 
        }
    });
}

function cargarIngresos() {
    $("#valor-ingresos").addClass('d-none');
    $("#loader-ingresos").removeClass('d-none');
    
    $.getJSON('backend/calcular_ingresos.php', function(res) {
        if(res.ingresos) {
            setTimeout(function() {
                $("#loader-ingresos").addClass('d-none');
                $("#valor-ingresos").text(res.ingresos).removeClass('d-none');
            }, 3500);
        }
    });
}

$(document).ready(function() {
    Toast.fire({
        icon: 'info',
        title: 'Sincronizando datos',
        text: 'Cargando información, por favor espere...'
    });

    cargarIngresos();

    if(localStorage.getItem('tema') === 'light') {
        document.documentElement.setAttribute('data-theme', 'light');
        document.getElementById("icono-tema").className = 'bi bi-moon-stars-fill';
    }

    const urlParams = new URLSearchParams(window.location.search);
    if(urlParams.get('msj') === 'usuario_creado') {
        Swal.fire({
            icon: 'success',
            title: '¡Excelente!',
            text: 'La cuenta del empleado fue creada con éxito.',
            confirmButtonColor: '#4f46e5'
        }).then(() => {
            window.history.replaceState({}, document.title, "admin.php");
        });
    }
});
    </script>
</body>
</html>