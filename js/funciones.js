// Cuando se carga la página, ejecuta la función cargarTabla
$(document).ready(function(){
    cargarTabla();
});

// Carga de la tabla desde listar.php
function cargarTabla(){
    $.ajax({
        url: "backend/listar.php", // Archivo que devuelve la tabla
        success: function(resp){
            $("#tabla_turnos").html(resp); // La mostramos en el div
        }
    });
}

// Función para AGREGAR un turno
function agregar(){
    // Tomamos los valores del formulario
    let cliente = $("#cliente").val();
    let servicio = $("#servicio").val();
    let fecha = $("#fecha").val();
    let hora = $("#hora").val();

    if(cliente=="" || servicio=="" || fecha=="" || hora==""){
        alert("Completa todos los campos para registrar un turno");
        return;
    }

    // Enviamos los datos a agregar.php usando AJAX
    $.post("backend/agregar.php",
        {cliente, servicio, fecha, hora},
        function(resp){
            alert(resp);
            cargarTabla();
        }
    );
}

// Función para BORRAR un turno
function borrar(id){
    $.post("backend/eliminar.php", {id}, function(resp){
        alert(resp);
        cargarTabla();
    });
}

// Función para EDITAR un turno
function editar(id){
    // Tomamos los valores editados en los inputs de la tabla
    let cliente = $("#c"+id).val();
    let servicio = $("#s"+id).val();
    let fecha = $("#f"+id).val();
    let hora = $("#h"+id).val();

    // Enviamos a editar.php
    $.post("backend/editar.php",
        {id, cliente, servicio, fecha, hora},
        function(resp){
            alert(resp);
            cargarTabla(); // Actualizamos la tabla
        }
    );
}
