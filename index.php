<?php
session_start();
if(isset($_SESSION['id_usuario'])){
    header("Location: turnos.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estilo Único | Acceso</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        
        /* --- VARIABLES TEMA CLARO --- */
        :root {
            --bg-body: #f3f4f6;
            --bg-panel: #ffffff;
            --texto-principal: #111827;
            --texto-secundario: #6b7280;
            --borde: #e5e7eb;
            --bg-input: #f9fafb;
            --color-acento: #4f46e5;
            --brand-bg: linear-gradient(135deg, #312e81 0%, #1e1b4b 100%);
        }

        /* --- VARIABLES TEMA OSCURO --- */
        [data-theme="dark"] {
            --bg-body: #030712;
            --bg-panel: #111827;
            --texto-principal: #f9fafb;
            --texto-secundario: #9ca3af;
            --borde: #1f2937;
            --bg-input: #1f2937;
            --color-acento: #6366f1;
            --brand-bg: linear-gradient(135deg, #0f172a 0%, #020617 100%);
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-body);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            overflow: hidden;
            transition: background-color 0.4s ease;
        }

        h1, h2, h3, h4, h5, h6, label, span, p { transition: color 0.4s ease; }
        .text-muted { color: var(--texto-secundario) !important; }

        .login-wrapper {
            width: 100%;
            max-width: 1000px;
            height: 600px;
            background: var(--bg-panel);
            border: 1px solid var(--borde);
            border-radius: 24px;
            box-shadow: 0 25px 50px rgba(0,0,0,0.15);
            display: flex;
            overflow: hidden;
            position: relative;
            transition: all 0.4s ease;
        }

        /* --- PANEL IZQUIERDO: FORMULARIOS --- */
        .form-side {
            width: 50%;
            padding: 4rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
        }

        .btn-tema-login {
            position: absolute;
            top: 1.5rem;
            left: 1.5rem;
            background: var(--bg-input);
            border: 1px solid var(--borde);
            color: var(--texto-principal);
            border-radius: 50%;
            width: 40px; height: 40px;
            display: flex; align-items: center; justify-content: center;
            cursor: pointer; transition: all 0.3s ease;
            z-index: 50;
        }
        .btn-tema-login:hover { transform: scale(1.1); }

        .form-container {
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            position: absolute;
            width: calc(100% - 8rem); 
        }

        #form-registro { opacity: 0; pointer-events: none; transform: translateX(50px) scale(0.95); }

        /* --- INPUTS MEJORADOS Y OJITO FLOTANTE --- */
        .form-control {
            background-color: var(--bg-input) !important;
            border: 2px solid var(--borde) !important;
            color: var(--texto-principal) !important;
            border-radius: 12px;
            padding: 0.8rem 1rem;
            font-weight: 500;
            transition: all 0.3s ease;
            box-shadow: none !important;
        }
        .form-control:focus {
            border-color: var(--color-acento) !important;
            background-color: var(--bg-panel) !important;
            transform: translateY(-1px);
        }
        ::placeholder { color: var(--texto-secundario) !important; opacity: 0.6; font-weight: 400;}

        /* Contenedor relativo para el ojito */
        .password-wrapper { position: relative; display: flex; align-items: center; }
        
        .password-wrapper input { padding-right: 2.5rem; }
        
        .password-eye {
            position: absolute;
            right: 15px;
            cursor: pointer;
            color: var(--texto-secundario);
            font-size: 1.1rem;
            transition: all 0.2s ease;
        }
        .password-eye:hover { color: var(--color-acento); }

        .btn-principal {
            background: linear-gradient(135deg, var(--color-acento) 0%, #4338ca 100%);
            color: white !important;
            border: none; border-radius: 12px; padding: 0.9rem; font-weight: 700;
            width: 100%; transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(99, 102, 241, 0.3);
            position: relative; overflow: hidden;
        }
        .btn-principal:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(99, 102, 241, 0.4); }

        .toggle-link { color: var(--color-acento); font-weight: 600; cursor: pointer; text-decoration: none; transition: all 0.2s;}
        .toggle-link:hover { filter: brightness(1.2); }

        /* --- PANEL DERECHO: MARCA Y CARRUSEL --- */
        .brand-side {
            width: 50%;
            background: var(--brand-bg);
            display: flex; flex-direction: column; align-items: center; justify-content: center;
            padding: 3rem; text-align: center; position: relative; overflow: hidden;
        }
        
        @keyframes pulseGlow {
            0% { transform: scale(1) translate(0, 0); opacity: 0.3; }
            50% { transform: scale(1.2) translate(10px, -10px); opacity: 0.5; }
            100% { transform: scale(1) translate(0, 0); opacity: 0.3; }
        }
        .glowing-orb { position: absolute; border-radius: 50%; filter: blur(60px); animation: pulseGlow 8s infinite alternate; z-index: 0; }
        .orb-1 { width: 300px; height: 300px; background: #4f46e5; top: -50px; right: -50px; }
        .orb-2 { width: 250px; height: 250px; background: #ec4899; bottom: -50px; left: -50px; }

        .z-10 { z-index: 10; position: relative; }

        /* Estilos del Carrusel Dinámico */
        #slider-container { min-height: 110px; display: flex; flex-direction: column; justify-content: flex-start; }
        
        .slider-dot {
            width: 8px; height: 8px; border-radius: 50%;
            background-color: white; opacity: 0.2;
            transition: all 0.3s ease;
        }
        .slider-dot.active {
            opacity: 1; transform: scale(1.4); background-color: var(--color-acento);
        }

        .swal2-popup { background-color: var(--bg-panel) !important; color: var(--texto-principal) !important; border: 1px solid var(--borde); border-radius: 20px !important; }
        .swal2-title, .swal2-html-container { color: var(--texto-principal) !important; }

        @media (max-width: 768px) {
            .brand-side { display: none; }
            .form-side { width: 100%; padding: 2rem; }
            .form-container { width: calc(100% - 4rem); }
        }
    </style>
</head>
<body>

<div class="login-wrapper animate__animated animate__zoomIn">
    
    <div class="form-side">
        
        <button class="btn-tema-login" onclick="toggleTema()" title="Cambiar Tema">
            <i class="bi bi-moon-stars-fill" id="icono-tema"></i>
        </button>

        <div class="form-container" id="form-login">
            <h2 class="fw-bold mb-1" style="color: var(--texto-principal);">¡Hola de nuevo! 👋</h2>
            <p class="text-muted mb-4 small">Ingresá tus credenciales para acceder al sistema.</p>

            <div class="mb-3">
                <label class="form-label small fw-bold text-muted" style="letter-spacing: 0.5px;">USUARIO</label>
                <input type="text" id="log_usuario" class="form-control" placeholder="Ej: admin">
            </div>

            <div class="mb-4">
                <label class="form-label small fw-bold text-muted" style="letter-spacing: 0.5px;">CONTRASEÑA</label>
                <div class="password-wrapper">
                    <input type="password" id="log_password" class="form-control w-100" placeholder="••••••••">
                    <i class="bi bi-eye password-eye" id="icono-ojito-log" onclick="togglePassword('log_password', 'icono-ojito-log')"></i>
                </div>
            </div>

            <button class="btn-principal mb-4" onclick="iniciarSesion()">Ingresar al Panel <i class="bi bi-arrow-right ms-2"></i></button>

            <div style="background: var(--bg-input); border: 1px dashed var(--borde); border-radius: 12px; padding: 1rem; margin-top: 1.5rem; text-align: center;">
                <small class="text-muted fw-bold d-block mb-2 text-uppercase" style="font-size: 0.65rem; letter-spacing: 1px;">Cuentas de prueba:</small>
                <div class="row g-2">
                    <div class="col-6">
                        <code class="d-block text-primary small" style="font-size: 0.8rem;">admin</code>
                        <small class="text-muted" style="font-size: 0.7rem;">/ 123456</small>
                    </div>
                    <div class="col-6">
                        <code class="d-block text-success small" style="font-size: 0.8rem;">empleado</code>
                        <small class="text-muted" style="font-size: 0.7rem;">/ 123456</small>
                    </div>
                </div>
            </div>

            <p class="text-center text-muted small">
                ¿No tenés una cuenta? <span class="toggle-link" onclick="cambiarFormulario('registro')">Registrate acá</span>
            </p>
        </div>

        <div class="form-container" id="form-registro">
            <h2 class="fw-bold mb-1" style="color: var(--texto-principal);">Crear Cuenta 🚀</h2>
            <p class="text-muted mb-4 small">Registrá un nuevo empleado en el sistema.</p>

            <div class="mb-3">
                <label class="form-label small fw-bold text-muted" style="letter-spacing: 0.5px;">NOMBRE COMPLETO</label>
                <input type="text" id="reg_nombre" class="form-control" placeholder="Ej: Juan Pérez">
            </div>

            <div class="mb-3">
                <label class="form-label small fw-bold text-muted" style="letter-spacing: 0.5px;">NUEVO USUARIO</label>
                <input type="text" id="reg_usuario" class="form-control" placeholder="Ej: jperez">
            </div>

            <div class="mb-4">
                <label class="form-label small fw-bold text-muted" style="letter-spacing: 0.5px;">CONTRASEÑA</label>
                <div class="password-wrapper">
                    <input type="password" id="reg_password" class="form-control w-100" placeholder="Crear contraseña">
                    <i class="bi bi-eye password-eye" id="icono-ojito-reg" onclick="togglePassword('reg_password', 'icono-ojito-reg')"></i>
                </div>
            </div>

            <button class="btn-principal mb-4" onclick="registrarUsuario()">Registrar Usuario <i class="bi bi-person-plus ms-2"></i></button>

            <p class="text-center text-muted small">
                ¿Ya tenés cuenta? <span class="toggle-link" onclick="cambiarFormulario('login')">Iniciá sesión</span>
            </p>
        </div>

    </div>

    <div class="brand-side">
        <div class="glowing-orb orb-1"></div>
        <div class="glowing-orb orb-2"></div>
        
        <div class="z-10 d-flex flex-column align-items-center justify-content-center h-100 w-100 px-4">
            <div class="bg-white bg-opacity-10 p-4 rounded-4 mb-4 d-flex align-items-center justify-content-center shadow animate__animated animate__pulse animate__infinite animate__slower" style="width: 85px; height: 85px; backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.2);">
                <i class="bi bi-scissors text-white" style="font-size: 2.5rem;"></i>
            </div>
            
            <h1 class="fw-bold mb-5 text-white" style="letter-spacing: -1px; font-size: 3.2rem;">Estilo Único</h1>
            
            <div id="slider-container" class="animate__animated animate__fadeInUp">
                <h4 id="slider-title" class="text-white fw-bold mb-2 d-flex align-items-center justify-content-center">
                    <i id="slider-icon" class="bi bi-calendar2-check me-2" style="color: #6366f1;"></i> 
                    <span id="slider-title-text">Agenda Inteligente</span>
                </h4>
                <p id="slider-desc" class="text-white-50 mb-0 mx-auto" style="max-width: 320px; font-size: 1.05rem; line-height: 1.6;">
                    Organiza todos tus turnos sin complicaciones y en tiempo real.
                </p>
            </div>

            <div class="d-flex gap-2 mt-4 justify-content-center" id="slider-dots">
                <div class="slider-dot active"></div>
                <div class="slider-dot"></div>
                <div class="slider-dot"></div>
            </div>
        </div>
    </div>

</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    // --- LÓGICA DEL CARRUSEL DE CARACTERÍSTICAS ---
    const features = [
        { icon: 'bi-whatsapp', title: 'Avisos por WhatsApp', desc: 'Confirmá turnos con un solo clic directamente a tus clientes.' },
        { icon: 'bi-graph-up-arrow', title: 'Control Total', desc: 'Llevá el registro exacto de clientes atendidos e historial.' },
        { icon: 'bi-moon-stars', title: 'Modo Oscuro', desc: 'Interfaz fluida con modo oscuro para cuidar tu vista.' }
    ];
    let currentSlide = 0;

    function rotateFeatures() {
        const container = document.getElementById('slider-container');
        const icon = document.getElementById('slider-icon');
        const title = document.getElementById('slider-title-text');
        const desc = document.getElementById('slider-desc');
        const dots = document.querySelectorAll('.slider-dot');

        // Animación de salida (se va para arriba suave)
        container.classList.remove('animate__fadeInUp');
        container.classList.add('animate__fadeOutUp');

        setTimeout(() => {
            // Cambiamos el contenido mientras es invisible
            currentSlide = (currentSlide + 1) % features.length;
            
            icon.className = `bi ${features[currentSlide].icon} me-2`;
            title.innerText = features[currentSlide].title;
            desc.innerText = features[currentSlide].desc;

            // Actualizamos los puntitos
            dots.forEach((dot, index) => {
                if(index === currentSlide) {
                    dot.classList.add('active');
                } else {
                    dot.classList.remove('active');
                }
            });

            // Animación de entrada (aparece desde abajo)
            container.classList.remove('animate__fadeOutUp');
            container.classList.add('animate__fadeInUp');
            
        }, 500); // Esperamos medio segundo a que termine la animación de salida
    }

    // Ejecutamos la rotación cada 4.5 segundos
    setInterval(rotateFeatures, 4500);


    // --- LÓGICA DEL TEMA OSCURO/CLARO ---
    $(document).ready(function() {
        if(localStorage.getItem('tema') === 'light') {
            document.documentElement.setAttribute('data-theme', 'light');
            document.getElementById("icono-tema").className = 'bi bi-moon-stars-fill';
        }
    });

    function toggleTema() {
        let h = document.documentElement;
        let n = h.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
        h.setAttribute('data-theme', n);
        localStorage.setItem('tema', n);
        document.getElementById("icono-tema").className = n === 'dark' ? 'bi bi-sun-fill' : 'bi bi-moon-stars-fill';
    }

    // --- FUNCIÓN DEL OJITO PARA LA CONTRASEÑA ---
    function togglePassword(inputId, iconId) {
        let input = document.getElementById(inputId);
        let icon = document.getElementById(iconId);
        
        if (input.type === "password") {
            input.type = "text";
            icon.classList.remove("bi-eye");
            icon.classList.add("bi-eye-slash");
            icon.style.color = "var(--color-acento)";
        } else {
            input.type = "password";
            icon.classList.remove("bi-eye-slash");
            icon.classList.add("bi-eye");
            icon.style.color = "var(--texto-secundario)";
        }
    }

    // --- ANIMACIÓN PARA CAMBIAR ENTRE LOGIN Y REGISTRO ---
    function cambiarFormulario(destino) {
        let formLogin = document.getElementById('form-login');
        let formRegistro = document.getElementById('form-registro');

        if (destino === 'registro') {
            formLogin.style.opacity = '0';
            formLogin.style.transform = 'translateX(-50px) scale(0.95)';
            formLogin.style.pointerEvents = 'none';

            setTimeout(() => {
                formRegistro.style.opacity = '1';
                formRegistro.style.transform = 'translateX(0) scale(1)';
                formRegistro.style.pointerEvents = 'auto';
            }, 300);
        } else {
            formRegistro.style.opacity = '0';
            formRegistro.style.transform = 'translateX(50px) scale(0.95)';
            formRegistro.style.pointerEvents = 'none';

            setTimeout(() => {
                formLogin.style.opacity = '1';
                formLogin.style.transform = 'translateX(0) scale(1)';
                formLogin.style.pointerEvents = 'auto';
            }, 300);
        }
    }

    // --- AJAX: INICIAR SESIÓN ---
function iniciarSesion() {
    let usuario = $("#log_usuario").val();
    let password = $("#log_password").val();

    if (usuario === "" || password === "") {
        return Swal.fire({ icon: 'warning', title: 'Faltan datos', text: 'Completá usuario y contraseña.' });
    }

    $.post("backend/login_process.php", { usuario: usuario, password: password }, function(respuesta) {
        let destino = respuesta.trim();

        // Verificamos si la respuesta es una página válida (admin.php o turnos.php)
        if (destino === "admin.php" || destino === "turnos.php") {
            window.location.href = destino; // Redirige a donde dijo el servidor
        } else if (destino === "error") {
            Swal.fire({ icon: 'error', title: 'Acceso Denegado', text: 'Usuario o contraseña incorrectos.' });
        } else {
            Swal.fire({ icon: 'error', title: 'Error', text: 'Respuesta inesperada del servidor.' });
        }
    });
}

    // --- AJAX: REGISTRAR USUARIO ---
    function registrarUsuario() {
        let nombre = $("#reg_nombre").val();
        let usuario = $("#reg_usuario").val();
        let password = $("#reg_password").val();

        if (nombre === "" || usuario === "" || password === "") {
            return Swal.fire({ icon: 'warning', title: 'Faltan datos', text: 'Completá todos los campos para registrarte.' });
        }

        $.post("backend/registro_process.php", { nombre: nombre, usuario: usuario, password: password }, function(respuesta) {
            if (respuesta.trim() === "ok") {
                Swal.fire({ 
                    icon: 'success', 
                    title: '¡Cuenta Creada!', 
                    text: 'Ya podés iniciar sesión.',
                    timer: 2000,
                    showConfirmButton: false
                }).then(() => {
                    $("#reg_nombre, #reg_usuario, #reg_password").val("");
                    cambiarFormulario('login');
                    $("#log_usuario").val(usuario);
                });
            } else if (respuesta.trim() === "existe") {
                Swal.fire({ icon: 'error', title: 'Uy...', text: 'Ese nombre de usuario ya está en uso. Elegí otro.' });
            } else {
                Swal.fire({ icon: 'error', title: 'Error del servidor', text: 'Hubo un problema al crear la cuenta.' });
            }
        });
    }

    $('#log_password').keypress(function (e) { if (e.which == 13) iniciarSesion(); });
    $('#reg_password').keypress(function (e) { if (e.which == 13) registrarUsuario(); });
</script>

</body>
</html>