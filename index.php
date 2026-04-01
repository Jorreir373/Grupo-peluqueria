<!DOCTYPE html>
<html lang="es" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estilo Único | Iniciar Sesión</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    
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
            --bg-input: #0f172a;
        }

        body {
            background-color: var(--bg-fondo);
            color: var(--texto-principal);
            font-family: 'Inter', system-ui, sans-serif;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .login-card {
            background-color: var(--bg-tarjeta);
            border: 1px solid var(--borde);
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
            padding: 2.5rem;
        }

        .form-control {
            background-color: var(--bg-input);
            border: 1px solid var(--borde);
            color: var(--texto-principal);
            border-radius: 10px;
            padding: 0.75rem 1rem;
        }
        
        .form-control:focus {
            background-color: var(--bg-tarjeta);
            border-color: var(--color-acento);
            color: var(--texto-principal);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.2);
        }

        .btn-ingresar {
            background-color: var(--color-acento);
            color: white;
            border-radius: 10px;
            padding: 0.75rem;
            font-weight: 600;
            width: 100%;
            border: none;
            transition: all 0.3s;
        }

        .btn-ingresar:hover {
            filter: brightness(1.1);
            transform: translateY(-2px);
        }

        /* Botón de tema flotante */
        .btn-tema-flotante {
            position: absolute;
            top: 20px;
            right: 20px;
            background: var(--bg-tarjeta);
            border: 1px solid var(--borde);
            color: var(--texto-principal);
            border-radius: 50%;
            width: 45px;
            height: 45px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s;
        }
    </style>
</head>
<body>

    <button class="btn-tema-flotante" onclick="toggleTema()">
        <i class="bi bi-moon-stars-fill" id="icono-tema"></i>
    </button>

    <div class="login-card animate__animated animate__fadeInUp">
        <div class="text-center mb-4">
            <h2 class="fw-bold"><i class="bi bi-scissors" style="color: var(--color-acento);"></i> Estilo Único</h2>
            <p style="color: var(--texto-secundario);">Ingresá a tu cuenta</p>
        </div>

        <form action="backend/login_process.php" method="POST">
            <div class="mb-3">
                <label class="form-label small fw-bold" style="color: var(--texto-secundario);">USUARIO</label>
                <div class="input-group">
                    <span class="input-group-text border-end-0" style="background: var(--bg-input); border-color: var(--borde); color: var(--texto-secundario);"><i class="bi bi-person"></i></span>
                    <input type="text" name="usuario" class="form-control border-start-0 ps-0" placeholder="Nombre de usuario" required>
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label small fw-bold" style="color: var(--texto-secundario);">CONTRASEÑA</label>
                <div class="input-group">
                    <span class="input-group-text border-end-0" style="background: var(--bg-input); border-color: var(--borde); color: var(--texto-secundario);"><i class="bi bi-lock"></i></span>
                    <input type="password" name="password" class="form-control border-start-0 ps-0" placeholder="Contraseña" required>
                </div>
            </div>

            <button type="submit" class="btn-ingresar"><i class="bi bi-box-arrow-in-right me-2"></i> Ingresar al Sistema</button>
            
            <?php if(isset($_GET['error'])): ?>
                <div class="alert alert-danger mt-3 py-2 small text-center rounded-3 animate__animated animate__shakeX" role="alert">
                    Usuario o contraseña incorrectos.
                </div>
            <?php endif; ?>
        </form>
    </div>

    <script>
        // Lógica del modo oscuro
        if(localStorage.getItem('tema') === 'dark') {
            document.documentElement.setAttribute('data-theme', 'dark');
            document.getElementById("icono-tema").className = 'bi bi-sun-fill';
        }

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
    </script>
</body>
</html>