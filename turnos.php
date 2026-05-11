<?php
session_start();
if(!isset($_SESSION['id_usuario'])){ header("Location: index.php"); exit; }
?>
<!DOCTYPE html>
<html lang="es" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estilo Único | Panel</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    
    <style>
        /* --- TEMA PRO REFINADO --- */
        :root {
            --bg-fondo: #f3f4f6; --bg-tarjeta: #ffffff; --bg-nav: #ffffff;
            --texto-principal: #111827; --texto-secundario: #6b7280;
            --borde: #e5e7eb; --bg-input: #ffffff; --color-acento: #4f46e5;
            --sombra-nav: 0 4px 20px rgba(0,0,0,0.03);
            --placeholder-color: #9ca3af;
        }
        [data-theme="dark"] {
            --bg-fondo: #0f172a; --bg-tarjeta: #1e293b; --bg-nav: #0b1120;
            --texto-principal: #f8fafc; --texto-secundario: #94a3b8;
            --borde: #334155; --bg-input: #0f172a; --color-acento: #6366f1;
            --sombra-nav: 0 4px 20px rgba(0,0,0,0.4);
            --placeholder-color: #64748b;
        }

        body {
            background-color: var(--bg-fondo); color: var(--texto-principal);
            font-family: 'Inter', system-ui, sans-serif; margin: 0; height: 100vh;
            display: flex; flex-direction: column; overflow: hidden; transition: background-color 0.4s ease;
        }

        h1, h2, h3, h4, h5, h6, label, span { color: var(--texto-principal) !important; transition: color 0.4s ease;}
        .text-muted { color: var(--texto-secundario) !important; }
        
        .navbar-app { background-color: var(--bg-nav); border-bottom: 1px solid var(--borde); box-shadow: var(--sombra-nav); padding: 1rem 2rem; z-index: 1000; transition: all 0.4s ease;}
        .workspace { display: flex; flex: 1; height: calc(100vh - 73px); overflow: hidden; }
        .panel { padding: 2rem; overflow-y: auto; scroll-behavior: smooth; }
        
        #panel-izquierdo { width: 340px; min-width: 320px; background-color: var(--bg-tarjeta); border-right: 1px solid var(--borde); transition: background-color 0.4s ease; }
        #panel-derecho { flex: 1; background-color: var(--bg-fondo); padding-left: 3rem; padding-right: 3rem; }

        ::placeholder { color: var(--placeholder-color) !important; opacity: 1 !important; font-weight: 400; }
        
        .form-control, .form-select { 
            border-radius: 12px; border: 1px solid var(--borde) !important; 
            padding: 0.8rem 1.2rem; background-color: var(--bg-input) !important; 
            color: var(--texto-principal) !important; font-weight: 500;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: inset 0 2px 4px rgba(0,0,0,0.02);
        }
        .form-control:focus, .form-select:focus { 
            border-color: var(--color-acento) !important; 
            box-shadow: 0 0 0 4px rgba(99,102,241,0.15) !important; 
            background-color: var(--bg-tarjeta) !important;
        }

        /* --- NUEVO BUSCADOR ANIMADO --- */
        .search-container {
            background-color: var(--bg-input);
            border-radius: 50px; /* Forma de píldora */
            padding: 0.2rem 0.5rem;
            border: 1px solid var(--borde);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            width: 260px; /* Ancho inicial */
            display: flex;
            align-items: center;
        }
        .search-container:focus-within {
            border-color: var(--color-acento);
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.15);
            width: 320px; /* ¡Se estira al hacer clic! */
            background-color: var(--bg-tarjeta);
        }
        .search-container input {
            background: transparent !important;
            border: none !important;
            box-shadow: none !important;
            padding-left: 0.5rem;
            color: var(--texto-principal);
            width: 100%;
        }
        .search-container input:focus { outline: none; }

        /* --- BOTONES DEL NAVBAR --- */
        .btn-nav-circle {
            background: var(--bg-input);
            border: 1px solid var(--borde);
            color: var(--texto-principal);
            border-radius: 50%;
            width: 42px;
            height: 42px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .btn-nav-circle:hover { transform: scale(1.08); background: var(--bg-tarjeta); box-shadow: 0 4px 10px rgba(0,0,0,0.05); }

        .btn-logout {
            background-color: rgba(239, 68, 68, 0.1);
            color: #ef4444 !important;
            border: 1px solid rgba(239, 68, 68, 0.2);
            border-radius: 50%;
            width: 42px; height: 42px;
            display: flex; align-items: center; justify-content: center;
            transition: all 0.3s ease;
        }
        .btn-logout:hover {
            background-color: #ef4444; color: white !important;
            transform: scale(1.08); box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
        }

        /* --- TABLA Y SPLITTER (Lo que ya andaba perfecto) --- */
        .table-custom { border-collapse: separate; border-spacing: 0 12px; color: var(--texto-principal); }
        .table-custom tr { background-color: var(--bg-tarjeta) !important; box-shadow: 0 4px 10px rgba(0,0,0,0.03); border-radius: 16px; transition: all 0.3s ease; border: 1px solid transparent; overflow: hidden; }
        .table-custom tr:hover { transform: translateY(-3px); box-shadow: 0 12px 25px rgba(0,0,0,0.08); z-index: 2; position: relative; border-color: var(--borde); }
        .table-custom th { color: var(--texto-secundario) !important; font-size: 0.75rem; letter-spacing: 1px; text-transform: uppercase; padding: 0 1.2rem; border: none; }
        .table-custom td { vertical-align: middle; padding: 14px 16px; border: none; }
        .table-custom td:first-child { border-top-left-radius: 16px; border-bottom-left-radius: 16px; }
        .table-custom td:last-child { border-top-right-radius: 16px; border-bottom-right-radius: 16px; }

        .fila-atendida { border-left: 5px solid #10b981 !important; background: linear-gradient(90deg, rgba(16,185,129,0.08) 0%, transparent 100%) !important; opacity: 0.85; }
        .fila-atendida .input-tabla { color: #10b981 !important; }
        .fila-atendida:hover { opacity: 1; }

        .input-tabla { border: 2px solid transparent !important; background: transparent !important; color: var(--texto-principal) !important; padding: 0.5rem 0.8rem; border-radius: 8px; font-size: 0.95rem; min-width: 120px; transition: all 0.2s; }
        .input-tabla:hover { background: var(--bg-fondo) !important; }
        .input-tabla:focus { background: var(--bg-input) !important; border-color: var(--color-acento) !important; }

        .btn-icono { width: 38px; height: 38px; border-radius: 10px; display: inline-flex; align-items: center; justify-content: center; transition: all 0.2s; }
        .btn-icono:hover { transform: scale(1.1); }
        .btn-guardar-oculto { display: none !important; }

        .btn-principal { background: linear-gradient(135deg, var(--color-acento) 0%, #4338ca 100%); color: white !important; border-radius: 12px; padding: 1rem; font-weight: 700; letter-spacing: 0.5px; border: none; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(99, 102, 241, 0.3); position: relative; overflow: hidden; }
        .btn-principal:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(99, 102, 241, 0.4); }
        .btn-principal::after { content: ''; position: absolute; top: 0; left: -100%; width: 50%; height: 100%; background: linear-gradient(to right, rgba(255,255,255,0) 0%, rgba(255,255,255,0.2) 50%, rgba(255,255,255,0) 100%); transform: skewX(-25deg); transition: all 0.7s ease; }
        .btn-principal:hover::after { left: 150%; }

        .resizer { width: 6px; background-color: var(--bg-tarjeta); border-right: 1px solid var(--borde); cursor: col-resize; position: relative; z-index: 10; transition: background-color 0.2s ease; }
        .resizer:hover, .resizer.resizing { background-color: var(--color-acento); }
        .resizer::after { content: "⋮"; color: var(--texto-secundario); position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); font-size: 1.2rem; }

        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background-color: var(--borde); border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background-color: var(--texto-secundario); }

        .swal2-popup { background-color: var(--bg-tarjeta) !important; color: var(--texto-principal) !important; border: 1px solid var(--borde); border-radius: 20px !important; }
        .swal2-title, .swal2-html-container { color: var(--texto-principal) !important; }

        @keyframes glowTemporal { 0% { box-shadow: 0 0 0 0 rgba(99, 102, 241, 0); border-color: transparent; } 50% { box-shadow: 0 0 25px 2px rgba(99, 102, 241, 0.4); border-color: var(--color-acento); } 100% { box-shadow: 0 0 0 0 rgba(99, 102, 241, 0); border-color: transparent; } }
        .resplandor-foco { animation: glowTemporal 2s ease-in-out 2; border-radius: 16px; padding: 10px; border: 1px solid transparent; transition: all 0.5s ease; }
    </style>
</head>

<body>

<nav class="navbar-app d-flex justify-content-between align-items-center animate__animated animate__fadeInDown">
    
    <div class="d-flex align-items-center gap-3">
        <div class="bg-primary bg-opacity-10 p-2 rounded-4 d-flex align-items-center justify-content-center shadow-sm" style="width: 48px; height: 48px;">
            <i class="bi bi-stars fs-4" style="color: var(--color-acento);"></i>
        </div>
        <div class="d-flex flex-column justify-content-center">
            <h4 class="fw-black m-0" style="letter-spacing: -0.5px; font-weight: 800;">Estilo Único</h4>
            <span class="text-muted fw-medium" style="font-size: 0.7rem; letter-spacing: 1px; margin-top: -2px;">v4.0</span>
        </div>
    </div>
    
    <div class="d-flex align-items-center gap-3">
        
        <div class="search-container d-none d-lg-flex me-2">
            <i class="bi bi-search ms-2 text-muted"></i>
            <input type="text" id="buscador" placeholder="Buscar cliente..." onkeyup="filtrarTurnos()">
        </div>

        <div style="height: 24px; width: 1px; background-color: var(--borde);" class="mx-1 d-none d-lg-block"></div>

        <button onclick="toggleTema()" class="btn-nav-circle" title="Cambiar Tema">
            <i class="bi bi-moon-stars-fill" id="icono-tema"></i>
        </button>

        <span class="fw-bold px-2 d-none d-md-block text-nowrap">
            <i class="bi bi-person-circle me-2" style="color: var(--color-acento);"></i><?php echo $_SESSION['nombre']; ?>
        </span>

        <a href="backend/logout.php" class="btn-logout ms-1" title="Cerrar Sesión">
            <i class="bi bi-power fs-5"></i>
        </a>
    </div>
</nav>

<div class="workspace">
    <div class="panel animate__animated animate__fadeInLeft" id="panel-izquierdo">
        <h5 class="fw-bold mb-4 d-flex align-items-center"><i class="bi bi-plus-circle-dotted me-2" style="color: var(--color-acento);"></i>Agendar Turno</h5>

        <div class="mb-4">
            <label class="form-label small fw-bold text-muted" style="letter-spacing: 0.5px;">NOMBRE DEL CLIENTE</label>
            <input type="text" id="cliente" class="form-control" placeholder="Ej: Juan Pérez">
        </div>
        
        <div class="mb-4">
            <label class="form-label small fw-bold text-muted" style="letter-spacing: 0.5px;">WHATSAPP</label>
            <div class="input-group">
                <span class="input-group-text border-0" style="background-color: var(--bg-input); color: var(--texto-secundario);"><i class="bi bi-whatsapp"></i></span>
                <input type="number" id="telefono" class="form-control border-start-0 ps-0" placeholder="Ej: 1123456789">
            </div>
        </div>

        <div class="mb-4">
            <label class="form-label small fw-bold text-muted" style="letter-spacing: 0.5px;">SERVICIO</label>
            <select id="servicio" class="form-select">
                <option value="" selected disabled>Seleccionar...</option>
                <?php 
                include "conexion.php";
                $query_s = mysqli_query($conexion, "SELECT * FROM servicios");
                while($s = mysqli_fetch_assoc($query_s)) echo "<option value='{$s['nombre']}'>{$s['nombre']} - $".number_format($s['precio'], 0, ',', '.')."</option>";
                ?>
            </select>
        </div>

        <div class="row g-3 mb-5">
            <div class="col-6"><label class="form-label small fw-bold text-muted">FECHA</label><input type="date" id="fecha" class="form-control"></div> 
            <div class="col-6"><label class="form-label small fw-bold text-muted">HORA</label><input type="time" id="hora" class="form-control"></div>
        </div>

        <button class="btn btn-principal w-100" onclick="agregar()"><i class="bi bi-send-fill me-2"></i>Confirmar y Notificar</button>
    </div>

    <div class="resizer" id="dragMe"></div>

    <div class="panel animate__animated animate__fadeInRight" id="panel-derecho">
        <div id="tabla_turnos" class="pb-5"></div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script>
    let alertaViejosMostrada = false;

    // --- SPLITTER ---
    document.addEventListener('DOMContentLoaded', function () {
        const resizer = document.getElementById('dragMe');
        const leftSide = resizer.previousElementSibling;
        let x = 0; let leftWidth = 0;

        const mouseDownHandler = function (e) {
            x = e.clientX; leftWidth = leftSide.getBoundingClientRect().width;
            document.body.style.userSelect = 'none'; document.body.style.pointerEvents = 'none';
            resizer.style.pointerEvents = 'auto';
            document.addEventListener('mousemove', mouseMoveHandler); document.addEventListener('mouseup', mouseUpHandler);
            resizer.classList.add('resizing');
        };

        const mouseMoveHandler = function (e) {
            const dx = e.clientX - x; const newLeftWidth = ((leftWidth + dx) * 100) / resizer.parentNode.getBoundingClientRect().width;
            if(newLeftWidth > 20 && newLeftWidth < 50) leftSide.style.width = `${newLeftWidth}%`;
        };

        const mouseUpHandler = function () {
            resizer.classList.remove('resizing');
            document.body.style.userSelect = ''; document.body.style.pointerEvents = '';
            document.removeEventListener('mousemove', mouseMoveHandler); document.removeEventListener('mouseup', mouseUpHandler);
        };
        resizer.addEventListener('mousedown', mouseDownHandler);
    });

    // --- CARGAR TABLA ---
    function cargarTabla(){ 
        $.ajax({ 
            url: "backend/listar.php", 
            success: function(resp){ 
                $("#tabla_turnos").html(resp); 
                
                if($("#hay_viejos_flag").val() == "1") {
                    $("#contenedor-viejos").slideDown(500);
                    if($("#btn-limpiar-viejos").length === 0) {
                        $("#contenedor-viejos h6").removeClass("mb-3").addClass("mb-4 d-flex justify-content-between align-items-center");
                        let btnLimpiar = `<button id="btn-limpiar-viejos" class="btn btn-danger btn-sm rounded-pill px-3 fw-bold shadow-sm" onclick="limpiarTodosViejos()"><i class="bi bi-trash3-fill me-1"></i> Limpiar Historial</button>`;
                        $("#contenedor-viejos h6").append(btnLimpiar);
                    }
                    if(!alertaViejosMostrada) {
                        alertaViejosMostrada = true; 
                        setTimeout(() => {
                            let panel = document.getElementById("panel-derecho");
                            panel.scrollTo({ top: panel.scrollHeight, behavior: 'smooth' });
                            $("#contenedor-viejos").addClass("resplandor-foco");
                            setTimeout(() => { $("#contenedor-viejos").removeClass("resplandor-foco"); }, 4000);
                        }, 800); 
                    }
                }
            } 
        }); 
    }

    // --- MARCAR COMO ATENDIDO ---
    function marcarAtendido(id) {
        Swal.fire({
            title: '¿Marcar como Atendido?',
            text: 'El cliente ya se realizó el servicio.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#10b981', 
            cancelButtonColor: 'var(--borde)',
            confirmButtonText: '<i class="bi bi-check-circle-fill me-1"></i> Sí, atendido',
            cancelButtonText: '<span style="color:var(--texto-principal)">Cancelar</span>',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                $("#fila-"+id).addClass("animate__animated animate__headShake");
                $.post("backend/atender.php", {id: id}, function() {
                    setTimeout(cargarTabla, 600);
                });
            }
        });
    }

    function limpiarTodosViejos() {
        Swal.fire({ title: '¿Limpiar historial?', html: 'Se van a borrar todos los turnos de días anteriores.', icon: 'warning', showCancelButton: true, confirmButtonColor: '#dc3545', cancelButtonColor: 'var(--borde)', confirmButtonText: 'Sí, borrar', cancelButtonText: '<span style="color:var(--texto-principal)">Cancelar</span>', reverseButtons: true }).then((r) => {
            if (r.isConfirmed) $.post("backend/eliminar_viejos.php", function() { cargarTabla(); });
        });
    }

    function mostrarGuardar(id) { $("#btn-guardar-"+id).removeClass("btn-guardar-oculto").addClass("animate__animated animate__zoomIn"); }

    function agregar(){
        let d = { cliente: $("#cliente").val(), telefono: $("#telefono").val(), servicio: $("#servicio").val(), fecha: $("#fecha").val(), hora: $("#hora").val() };
        if(Object.values(d).includes("")) return Swal.fire({ icon: 'warning', title: 'Faltan datos' });

        $.post("backend/agregar.php", d, function(r){
            if(r.includes("⚠")) return Swal.fire({ icon: 'error', title: 'Horario ocupado' });
            let msg = `¡Hola ${d.cliente}! ✂️ Te confirmamos tu turno en *Estilo Único* para el servicio de *${d.servicio}*. Te esperamos el día ${d.fecha} a las ${d.hora} hs.`;
            window.open(`https://api.whatsapp.com/send?phone=${d.telefono}&text=${encodeURIComponent(msg)}`, '_blank'); 
            Swal.fire({ icon: 'success', title: 'Guardado', timer: 1500, showConfirmButton: false });
            $("#cliente, #telefono, #servicio, #fecha, #hora").val(''); 
            cargarTabla();
        });
    }

    function borrar(id){
        Swal.fire({ title: '¿Borrar turno?', icon: 'warning', showCancelButton: true, confirmButtonColor: '#dc3545', cancelButtonColor: 'var(--borde)', cancelButtonText: '<span style="color:var(--texto-principal)">Cancelar</span>' }).then((r) => {
            if (r.isConfirmed) $.post("backend/eliminar.php", {id}, function(){ cargarTabla(); });
        });
    }

    function editar(id){
        let d = { id, cliente: $("#c"+id).val(), telefono: $("#e"+id).val(), servicio: $("#s"+id).val(), fecha: $("#f"+id).val(), hora: $("#h"+id).val() };
        $.post("backend/editar.php", d, function(){ Swal.fire({ icon: 'success', title: 'Actualizado', timer: 1000, showConfirmButton: false }); cargarTabla(); });
    }

    function filtrarTurnos() {
        let f = $("#buscador").val().toLowerCase();
        $("#tabla_turnos tbody tr").each(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(f) > -1);
        });
    }

    $(document).ready(function() { 
        cargarTabla();
        if(localStorage.getItem('tema') === 'light') { document.documentElement.setAttribute('data-theme', 'light'); document.getElementById("icono-tema").className = 'bi bi-moon-stars-fill'; }
    });

    function toggleTema() {
        let h = document.documentElement; let n = h.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
        h.setAttribute('data-theme', n); localStorage.setItem('tema', n);
        document.getElementById("icono-tema").className = n === 'dark' ? 'bi bi-sun-fill' : 'bi bi-moon-stars-fill';
    }
</script>
</body>
</html>