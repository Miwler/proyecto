$(document).ready(function(){
    $(".grabar").html('<span class="glyphicon glyphicon-floppy-disk"></span> Guardar');
    $(".grabar").attr('title','Guardar registro');
    $(".grabar").addClass("btn btn-success");
    
    $(".cancelar").html('<span class="glyphicon glyphicon-ban-circle"></span> Cancelar');
    $(".cancelar").attr('title','Cancelar');
    $(".cancelar").addClass("btn btn-danger");
     
    $(".cerrar").html('<span class="glyphicon glyphicon-remove-circle"></span> Cerrar');
    $(".cerrar").attr('title','Cerrar ventana');
    $(".cerrar").addClass("btn btn-danger");
    
    $(".agregar").html('<span class="glyphicon glyphicon-plus-sign"></span> Agregar');
    $(".agregar").attr('title','Agregar registro');
    $(".agregar").addClass("btn btn-success");
    
    $(".salir").html('<span class="glyphicon glyphicon-arrow-left"></span> Salir');
    $(".salir").attr('title','Salir');
    $(".salir").addClass("btn btn-danger");
    
    $(".importar").html('<span class="glyphicon glyphicon-cloud-download"></span> Importar');
    $(".importar").attr('title','Importar');
    $(".importar").addClass("btn btn-lilac");

});
   
    