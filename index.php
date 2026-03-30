<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estilo Único | Panel de Turnos</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    
    <style>
/* --- Variables de Tema (Claro por defecto) --- */
        :root {
            --bg-fondo: #f4f6f9; 
            --bg-tarjeta: #ffffff;
            --texto-principal: #111827;
            --texto-secundario: #6b7280;
            --borde: #e5e7eb;
            --bg-input: #f9fafb;
            --color-acento: #111827;
            --color-btn-texto: #ffffff;
        }

        /* --- Variables de Tema Oscuro --- */
        [data-theme="dark"] {
            --bg-fondo: #0f172a; /* Un poco más azulado y profundo */
            --bg-tarjeta: #1e293b;
            --texto-principal: #f8fafc;
            --texto-secundario: #94a3b8;
            --borde: #334155;
            --bg-input: #0f172a;
            --color-acento: #4f46e5;
            --color-btn-texto: #ffffff;
        }

        body {
            background-color: var(--bg-fondo);
            color: var(--texto-principal);
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        /* Forzar color de textos sobre Bootstrap */
        h1, h2, h3, h4, h5, h6, label, span {
            color: var(--texto-principal) !important;
        }
        .text-muted {
            color: var(--texto-secundario) !important;
        }

        /* --- Tarjetas (Cards) --- */
        .card-custom {
            border: 1px solid var(--borde);
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
            background-color: var(--bg-tarjeta) !important;
            transition: all 0.3s ease;
        }

        /* --- Formularios --- */
        .form-control, .form-select {
            border-radius: 10px;
            border: 1px solid var(--borde) !important;
            padding: 0.6rem 1rem;
            background-color: var(--bg-input) !important;
            color: var(--texto-principal) !important;
            transition: all 0.3s ease;
        }
        .form-control:focus, .form-select:focus {
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.2);
            border-color: #4f46e5 !important;
            background-color: var(--bg-tarjeta) !important;
        }
        ::placeholder {
            color: var(--texto-secundario) !important;
            opacity: 0.7;
        }
        
        /* Corregir color de las opciones del select en modo oscuro */
        select option {
            background-color: var(--bg-tarjeta);
            color: var(--texto-principal);
        }

        /* --- Botones --- */
        .btn-principal {
            background-color: var(--color-acento);
            color: var(--color-btn-texto) !important;
            border-radius: 10px;
            padding: 0.7rem;
            font-weight: 600;
            transition: all 0.3s;
            border: none;
        }
        .btn-principal:hover {
            filter: brightness(1.2);
            transform: translateY(-2px);
        }
        
        #btn-tema {
            background: transparent;
            border: 1px solid var(--borde);
            color: var(--texto-principal);
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        #btn-tema:hover {
            background-color: var(--bg-input);
        }

        /* --- Estilos Tabla (Acá estaba el bug visual) --- */
        #tabla_turnos table {
            border-collapse: separate;
            border-spacing: 0 8px;
            color: var(--texto-principal);
            --bs-table-bg: transparent; /* Anula el fondo blanco de Bootstrap */
            --bs-table-color: var(--texto-principal);
        }
        #tabla_turnos tr {
            background-color: var(--bg-tarjeta) !important;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            border-radius: 12px;
        }
        #tabla_turnos th {
            color: var(--texto-secundario) !important;
            font-size: 0.85rem;
            text-transform: uppercase;
            padding: 1rem;
            border: none;
            background-color: transparent !important;
        }
        #tabla_turnos td {
            vertical-align: middle;
            padding: 0.5rem 1rem;
            border: none;
            background-color: transparent !important;
        }
        .input-tabla {
            border: 1px solid transparent !important;
            background: transparent !important;
            color: var(--texto-principal) !important;
            padding: 0.4rem;
        }
        .input-tabla:focus {
            background: var(--bg-input) !important;
            border: 1px solid #4f46e5 !important;
        }
        .btn-icono {
            width: 35px; height: 35px;
            border-radius: 50%;
            display: inline-flex; align-items: center; justify-content: center;
        }
        .btn-guardar-oculto { display: none !important; }
    </style>
</head>

<body>

<div class="container py-4 px-lg-4">
    
    <div class="row mb-4 animate__animated animate__fadeInDown">
        <div class="col-12 d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold m-0"><i class="bi bi-scissors text-primary me-2"></i>Estilo Único</h3>
            <div class="d-flex align-items-center gap-3">
                <div class="text-muted d-none d-md-block"><i class="bi bi-calendar-event me-1"></i> <span id="fecha-hoy"></span></div>
                <button id="btn-tema" onclick="toggleTema()" title="Cambiar Tema">
                    <i class="bi bi-moon-stars-fill" id="icono-tema"></i>
                </button>
            </div>
        </div>

        <div class="col-12">
            <div class="card card-custom p-3 d-flex flex-row justify-content-between align-items-center">
                <div>
                    <h6 class="m-0 small text-uppercase fw-bold" style="color: var(--texto-secundario);">Buscador Rápido</h6>
                </div>
                <div class="input-group" style="max-width: 300px;">
                    <span class="input-group-text border-0" style="background-color: var(--bg-input); color: var(--texto-secundario);"><i class="bi bi-search"></i></span>
                    <input type="text" id="buscador" class="form-control border-0" placeholder="Buscar cliente..." onkeyup="filtrarTurnos()">
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-4 animate__animated animate__fadeInLeft">
            <div class="card card-custom p-4 sticky-top" style="top: 20px;">
                <h5 class="fw-bold mb-4">Agendar Turno</h5>

                <div class="mb-3">
                    <label class="form-label small fw-bold" style="color: var(--texto-secundario);">CLIENTE</label>
                    <input type="text" id="cliente" class="form-control" placeholder="Ej: Juan Pérez">
                </div>
                
                <div class="mb-3">
                    <label class="form-label small fw-bold" style="color: var(--texto-secundario);">EMAIL NOTIFICACIÓN</label>
                    <input type="email" id="email" class="form-control" placeholder="correo@ejemplo.com">
                </div>

                <div class="mb-3">
                    <label class="form-label small fw-bold" style="color: var(--texto-secundario);">SERVICIO</label>
                    <select id="servicio" class="form-select">
                        <option value="" selected disabled>Seleccionar...</option>
                        <option value="Corte de pelo">Corte de pelo</option>
                        <option value="Tinte / Coloración">Tinte / Coloración</option>
                        <option value="Peinado">Peinado</option>
                        <option value="Barbería">Barbería</option>
                    </select>
                </div>

                <div class="row mb-4">
                    <div class="col-6">
                        <label class="form-label small fw-bold" style="color: var(--texto-secundario);">FECHA</label>
                        <input type="date" id="fecha" class="form-control">
                    </div> 
                    <div class="col-6">
                        <label class="form-label small fw-bold" style="color: var(--texto-secundario);">HORA</label>
                        <input type="time" id="hora" class="form-control">
                    </div>
                </div>

                <button class="btn btn-principal w-100" onclick="agregar()">
                    <i class="bi bi-check2-circle me-1"></i> Guardar y Notificar
                </button>
            </div>
        </div>

        <div class="col-lg-8 animate__animated animate__fadeInRight">
            <div id="tabla_turnos" class="table-responsive">
                </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="js/funciones.js"></script>

</body>
</html>