$(document).ready(function(){
    cargarTabla();
    
    const opciones = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
    $("#fecha-hoy").text(new Date().toLocaleDateString('es-ES', opciones));

    if(localStorage.getItem('tema') === 'dark') {
        document.documentElement.setAttribute('data-theme', 'dark');
        $("#icono-tema").removeClass('bi-moon-stars-fill').addClass('bi-sun-fill');
    }
});

function toggleTema() {
    let htmlTag = document.documentElement;
    let icono = $("#icono-tema");
    
    if (htmlTag.getAttribute('data-theme') === 'dark') {
        htmlTag.removeAttribute('data-theme');
        localStorage.setItem('tema', 'light');
        icono.removeClass('bi-sun-fill').addClass('bi-moon-stars-fill');
    } else {
        htmlTag.setAttribute('data-theme', 'dark');
        localStorage.setItem('tema', 'dark');
        icono.removeClass('bi-moon-stars-fill').addClass('bi-sun-fill');
    }
}

function cargarTabla(){
    $.ajax({
        url: "backend/listar.php", 
        success: function(resp){
            $("#tabla_turnos").html(resp); 
        }
    });
}

function mostrarGuardar(id) {
    let boton = $("#btn-guardar-" + id);
    boton.removeClass("btn-guardar-oculto");
    boton.addClass("animate__animated animate__bounceIn");
}

function agregar(){
    let cliente = $("#cliente").val();
    let email = $("#email").val(); 
    let servicio = $("#servicio").val();
    let fecha = $("#fecha").val();
    let hora = $("#hora").val();

    if(cliente=="" || email=="" || servicio=="" || fecha=="" || hora==""){
        Swal.fire({ icon: 'warning', title: 'Faltan datos', text: 'Completá todos los campos, incluyendo el email.' });
        return;
    }

    $.post("backend/agregar.php", {cliente, email, servicio, fecha, hora}, function(resp){
        if(resp.includes("⚠")){
            Swal.fire({ icon: 'error', title: 'Horario ocupado', text: 'Ya existe un turno en ese horario.' });
        } else {
            $.post("http://localhost:3000/enviar-correo", {cliente, email, servicio, fecha, hora})
                .done(function() {
                    // Todo salió perfecto
                    Swal.fire({ 
                        icon: 'success', 
                        title: '¡Guardado!', 
                        text: 'Turno agendado y correo enviado.', 
                        timer: 2500, 
                        showConfirmButton: false 
                    });
                })
                .fail(function() {
                    Swal.fire({ 
                        icon: 'warning', 
                        title: 'Aviso', 
                        text: 'Turno guardado, pero falló el envío del correo.' 
                    });
                });

            $("#cliente, #email, #servicio, #fecha, #hora").val(''); 
            cargarTabla();
        }
    });
}

function borrar(id){
    Swal.fire({
        title: '¿Eliminar turno?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Borrar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            $.post("backend/eliminar.php", {id}, function(resp){
                cargarTabla();
            });
        }
    });
}

function editar(id){
    let cliente = $("#c"+id).val();
    let email = $("#e"+id).val();
    let servicio = $("#s"+id).val();
    let fecha = $("#f"+id).val();
    let hora = $("#h"+id).val();

    $.post("backend/editar.php", {id, cliente, email, servicio, fecha, hora}, function(resp){
        Swal.fire({ icon: 'success', title: '¡Modificado!', timer: 1500, showConfirmButton: false });
        cargarTabla();
    });
}

function filtrarTurnos() {
    let filtro = $("#buscador").val().toLowerCase();
    $("#tabla_turnos tbody tr").each(function() {
        let textoCliente = $(this).find("td:first-child input").val().toLowerCase();
        $(this).toggle(textoCliente.indexOf(filtro) > -1);
    });
}