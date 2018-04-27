<?php
require ROOT_PATH . "views/shared/content-float.php";

?>	
<?php

function fncTitle() { ?>Nuevo Banner<?php } ?>

<?php

function fncHead() { ?>
    
  
    <script src="../../include/js/jForm.js" type="text/javascript"></script>
   
    
    
<?php } ?>

<?php

function fncTitleHead() { ?><span class='glyphicon glyphicon-picture'></span> Imagenes de banner<?php } ?>

<?php

function fncMenu() { ?>
<?php } ?>

<?php

function fncPage() { ?>
<style type="text/css">
    .borde-dropzone{
      border: 2px dashed #47a447 !important;
      border-radius: 5px !important;
      background: white !important;
     }
</style>
<?php if (!isset($GLOBALS['resultado']) || $GLOBALS['resultado'] == -1) { ?>

    <div class="container" >
        <form id='frm1' style='min-width:750px;width:80%; height: 700px;padding: 10px;overflow:auto;' method='post' action='pagina_web/Web_Banner_Configuracion_Imagen/<?php echo $GLOBALS['oWeb_Banner']->ID;?>' >
            <div class="row">
                <div class="col-md-12 ">
                  <div class="panel panel-default">
                    <div class="panel-heading" id="divContenedor">
                        <div class="row">
                            <div class="col-xs-12 col-md-12"><h4>Información de la imagén</h4></div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 col-md-4 col-xs-4">
                                <label>Nombre: </label><input id="txtWeb_Banner_ID"  name="txtWeb_Banner_ID" value="<?php echo $GLOBALS['oWeb_Banner']->ID;?>" style="display:none;">
                                <input id="txtID"  name="txtID"  style="display:none;">
                            </div>
                            <div class="col-md-8 col-md-8 col-xs-8"  class="form-group has-error">
                                <input type='text' id='txtNombre' name='txtNombre' autocomplete="off" class="form-control" style='width:170px;'>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 col-md-4 col-xs-4">
                                <label>Título: </label>
                            </div>
                            <div class="col-md-8 col-md-8 col-xs-8">
                                <input type='text' id='txtTitulo' name='txtTitulo' autocomplete="off" class="form-control" style='width:170px;'>
                            </div>
                         </div>
                        <div class="row">
                            <div class="col-md-4 col-md-4 col-xs-4">
                                <label>Resumen: </label>
                            </div>
                            <div class="col-md-8 col-md-8 col-xs-8">
                                <textarea id='txtResumen' name='txtResumen' dropzone="true"  class="form-control" style='width:170px;height: 40px;'></textarea>
                            </div>
                         </div>
                        <div class="row">
                            <div class="col-md-4 col-md-4 col-xs-4">
                                <label>Link ver más: </label>
                            </div>
                            <div class="col-md-8 col-md-8 col-xs-8">
                                <input type='text' id='txtRuta_Ver_Mas' name='txtRuta_Ver_Mas' autocomplete="off" class="form-control" style='width:170px;'>
                            </div>
                         </div>
                        <div class="row">
                            <div class="col-md-4 col-md-4 col-xs-4">
                                <label>Orden: </label>
                            </div>
                            <div class="col-md-8 col-md-8 col-xs-8">
                                <input type='number' id='txtOrden' name='txtOrden' style='width:170px;' class="form-control" value="0">
                            </div>
                         </div>
                        <div class="row">
                            <div class="col-md-4 col-md-4 col-xs-4">
                                <label>Estado: </label>
                            </div>
                            <div class="col-md-8 col-md-8 col-xs-8">
                                <select id="selEstado_ID" name="selEstado_ID" class="form-control" style='width:170px;'>
                                    <?php foreach($GLOBALS['dtEstado'] as $item){?>
                                    <option value="<?php echo $item['ID']?>"><?php echo $item['nombre']?></option>
                                    <?php } ?>
                                </select>
                                <script type="text/javascript">
                                    $('#selEstado_ID').val(63);
                                </script>
                                
                            </div>
                         </div>
                        <div class="row" style="margin-top:10px;">
                            <div class="col-md-4 col-md-4 col-xs-4">
                                <button class="btn btn-success noedicion" type='button' title='Subi imagenes' onclick="fncGrabarImagen();" ><span class='glyphicon glyphicon-plus'></span> Agregar imagenes</button>
                            </div>
                            <div class="col-md-2 col-md-2 col-xs-2">
                                <button class="btn btn-success edicion" type='button' title='Grabar cambios' onclick="fncGrabarInformacion();" style="display:none;"><span class='glyphicon glyphicon-floppy-disk'></span> Grabar</button>
                            </div>
                            <div class="col-md-6 col-md-6 col-xs-6">
                                <button class="btn btn-danger edicion" type='button' title='Cancelar edicicón' onclick="fncCancelar();" style="display:none;" ><span class='glyphicon glyphicon-remove'></span> Cancelar</button>
                            </div>
                        </div>
                        
                    </div>
                    <div class="panel-body text-center" >
                        <div class="row" id="divMostrarArchivos"></div>
                    </div>
                  </div> <!-- Fin del panel panel-default -->
                </div>
              </div>
        </form>
     
       
        <!-- Fin del Row --> 
       <!-- Modal -->
        <div id="mdlArchivos" class="modal fade" data-backdrop="static">
            <div class="modal-dialog" style="width: 96%;">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Subir Archivos</h4>
                  </div>
                  <div class="modal-body" id="divInformación">
                      <div class="row">
                         <div class="col-md-12" id="formDropZone"></div>
                      </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                  </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
      </div><!-- /.modal -->      
     </div> <!-- Fin del Container -->
     
<?php } ?>
<script>
    var fncGrabarImagen=function(){
        var nombre=$.trim($('#txtNombre').val());
        if(nombre==""){
            toastem.error("Debe ingresar un nombre");
            $('#txtNombre').focus();
            return false;
        }
        $(function () {
            $('#mdlArchivos').modal('toggle');
         });
    }
    var limpiar=function(){
       $('#txtID').val('');
       $('#txtNombre').val('');
       $('#txtTitulo').val('');
       $('#txtResumen').val('');
       $('#txtRuta_Ver_Mas').val('');
       $('#txtOrden').val(0);
       $('#selEstado_ID').val(64);
    }
    var fncEliminar=function(id){
        cargarValores('pagina_web/ajaxElminarWeb_Banner_Imagen',id,function(resultado){
            if(resultado.resultado==1){
                toastem.info(resultado.mensaje);
                getArchivos();
            }else{
                toastem.error(resultado.mensaje);
            }
        });
    }
    var fncDesactivar=function(id){
        cargarValores('pagina_web/ajaxDesactivarWeb_Banner_Imagen',id,function(resultado){
            if(resultado.resultado==1){
                toastem.info(resultado.mensaje);
                getArchivos();
            }else{
                toastem.error(resultado.mensaje);
            }
        });
    }
    var fncEditar=function(id){
        cargarValores('pagina_web/ajaxExtraerInfoWeb_Banner_Imagen',id,function(resultado){
            $('#txtID').val(resultado.ID);
            $('#txtNombre').val(resultado.nombre);
            $('#txtTitulo').val(resultado.titulo);
            $('#txtResumen').val(resultado.resumen);
            $('#txtRuta_Ver_Mas').val(resultado.ruta_ver_mas);
            $('#txtOrden').val(resultado.orden);
            $('#selEstado_ID').val(resultado.estado_ID);
            $('.edicion').css('display','');
            $('.noedicion').css('display','none');
        });
        $('#divContenedor').get(0).scrollIntoView(true);
        $('#txtNombre').focus();
        
    }
    var fncGrabarInformacion=function(){
        var nombre=$.trim($('#txtNombre').val());
        if(nombre==""){
            toastem.error("Debe ingresar un nombre");
            $('#txtNombre').focus();
            return false;
        }
        cargarFormularios('pagina_web/ajaxUpdateWeb_Banner_Configuracion_Imagen','divContenedor',null,function(resultado){
            if(resultado.resultado==1){
                toastem.success(resultado.mensaje);
                limpiar();
            }else{
                toastem.success(resultado.mensaje);
            }
        });
    }
    var fncCancelar=function(){
        limpiar();
        $('.edicion').css('display','none');
        $('.noedicion').css('display','');
    }
 $(document).on("ready", function() {
  getArchivos();
});
$('#mdlArchivos').on('show.bs.modal', function (event) {
    $("#formDropZone").append("<form id='dZUpload' class='dropzone borde-dropzone' style='cursor: pointer;'>"+
 	                         "<div class='dz-default dz-message text-center'>"+
 	                           "<span><h2>Arrastra los archivos aquí</h2></span><br>"+
 	                         "<p>(o Clic para seleccionar)</p></div></form>");
    
    
        myAwesomeDropzone = {
            
            url: "/pagina_web/ajaxInsertWeb_Banner_Configuracion_Imagen",
            addRemoveLinks: true,
            paramName: "archivo",
            maxFilesize: 4, // MB
            dictRemoveFile: "Remover",
            parallelUploads:1,
            params: {
                txtWeb_Banner_ID:$('#txtWeb_Banner_ID').val(),
                txtNombre:$('#txtNombre').val(),
                txtTitulo:$('#txtTitulo').val(),
                txtResumen:$('#txtResumen').val(),
                txtRuta_Ver_Mas:$('#txtRuta_Ver_Mas').val(),
                txtOrden:$('#txtOrden').val(),
                selEstado_ID:$('#selEstado_ID').val()
            },
            success: function (file, response) {
                var respuesta = $.parseJSON(response); 
                if(respuesta.resultado==1){
                     toastem.success(respuesta.mensaje);
                     limpiar();
                     $(function () {
                        $('#mdlArchivos').modal('toggle');
                     });
                }else{
                    toastem.error(respuesta.mensaje);
                }
                
                
                
                //var imgName = response;
                //file.previewElement.classList.add("dz-success");
                //console.log("Successfully uploaded :" + imgName);
            },
            error: function (file, response) {
              file.previewElement.classList.add("dz-error");
            }
        } // FIN myAwesomeDropzone
    
   
    var myDropzone = new Dropzone("#dZUpload", myAwesomeDropzone); 
        
         myDropzone.on("complete", function(file,response) {

       });
     
  
});
$('#mdlArchivos').on('hidden.bs.modal', function (event) {
  $("#formDropZone").empty();
  getArchivos();
});

function getArchivos() {
    $('#fondo_espera').css('display','block');
    var web_banner_ID='<?php echo $GLOBALS['oWeb_Banner']->ID;?>';
    
    cargarValores('/pagina_web/ajaxWeb_Banner_Configuracion_Imagen',web_banner_ID,function(resultado){
        $('#fondo_espera').css('display','none');
        $("#divMostrarArchivos").html("");
        $("#divMostrarArchivos").html(resultado.html);
    });
    
}  
</script>
    <?php if (isset($GLOBALS['resultado']) && $GLOBALS['resultado'] == 1) { ?>
        <div class="float-mensaje">
            <?php echo $GLOBALS['mensaje']; ?>
        </div>
        <script type="text/javascript">

            setTimeout('window_float_save();', 1000);
        </script>
    <?php } ?>

    <?php if (isset($GLOBALS['resultado']) && $GLOBALS['resultado'] == 0) { ?>
        <div class="float-mensaje">
            <?php echo $GLOBALS['mensaje']; ?>
        </div>
        <div class="group-btn">
            <input type="button" onclick ="redireccionar_parent('/');" value ="Iniciar Sesión"/>
        </div>
    <?php } ?>
<?php } ?>
