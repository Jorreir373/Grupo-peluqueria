<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Peluquería Estilo Único – Gestión de Turnos</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>

<body class="bg-light">

<div class="container mt-4">
    <div class="p-3 mb-4 text-center text-white rounded" style="background: #6f42c1;">
        <h2 class="m-0">💈 Peluquería Estilo Único</h2>
    </div>
    <h4 class="text-center mb-4">Gestión de Turnos</h4>

    <!-- FORMULARIO -->
    <div class="card p-3 mb-4">
        <h5>Registrar un turno nuevo</h5>

        <div class="row g-2">
            <div class="col-md-3">
                <input id="cliente" class="form-control" placeholder="Nombre del cliente">
            </div>

            <div class="col-md-3">
                <select id="servicio" class="form-control">
                    <option value="">Seleccione servicio</option>
                    <option value="Corte de pelo">Corte de pelo</option>
                    <option value="Tinte / Coloración">Tinte / Coloración</option>
                    <option value="Peinado">Peinado</option>
                    <option value="Barbería">Barbería</option>
                </select>
            </div>

            <div class="col-md-3">
                <input type="date" id="fecha" class="form-control">
            </div> 
            <div class="col-md-3">
                <input type="time" id="hora" class="form-control">
            </div>
        </div>

         <!-- Botón que llama a AJAX para guardar -->
        <button class="btn btn-primary mt-3" onclick="agregar()">Guardar turno</button>
        <br>
        <a href="exportar_pdf.php" class="btn btn-danger mb-3">📄 Exportar a PDF</a>

    </div>

    <!-- TABLA que se carga mediante AJAX -->
    <div id="tabla_turnos"></div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="js/funciones.js"></script>

</body>
</html>
