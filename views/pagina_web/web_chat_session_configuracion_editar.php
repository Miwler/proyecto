<?php
require ROOT_PATH . "views/shared/content-float-modal.php";

?>	
<?php

function fncTitle() { ?>Chat<?php } ?>

<?php

function fncHead() { ?>
    
   <!--<script src="../../fileinput/js/fileinput.js" type="text/javascript"></script>
    <link href="../../fileinput/css/fileinput.css" rel="stylesheet" type="text/css"/>-->
    <script src="../../include/js/jForm.js" type="text/javascript"></script>

    
<?php } ?>

<?php

function fncTitleHead() { ?><span class="glyphicon glyphicon-comment"></span> Chat<?php } ?>

<?php

function fncMenu() { ?>
<?php } ?>

<?php

function fncPage() { ?>

<?php if (!isset($GLOBALS['resultado']) || $GLOBALS['resultado'] == -1) { ?>
    <form id="form"  method="POST"  class="form-horizontal"  action="/Pagina_Web/Mensaje_Configuracion_Editar/<?php echo $GLOBALS['oWeb_chat_Session']->ID;?>" >
        <div class="form-group">
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                <label>Invitado :</label>
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                <input type="text" class="form-control" autocomplete="off" disabled value="<?php echo FormatTextView($GLOBALS['oWeb_chat_Session']->nombre_visitante);?>" >
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                <label>Usuario atención :</label>
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                <input type="text"  class="form-control" autocomplete="off" disabled value="<?php echo FormatTextView($GLOBALS['oWeb_chat_Session']->usuario_receptor);?>">
                <input name="txtUsuario_receptor_ID" id="txtUsuario_receptor_ID" value="<?php echo $GLOBALS['oWeb_chat_Session']->usuario_receptor_ID;?>" style="display:none;">
                <input name="txtWeb_Chat_Session_ID" id="txtWeb_Chat_Session_ID" value="<?php echo $GLOBALS['oWeb_chat_Session']->ID;?>" style="display:none;">
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="panel panel-primary">
        
                    <div id="chat_header" class="panel-heading">

                        <span class="glyphicon glyphicon-comment"></span> Chat online 
                    </div>
                    <div id="chat_body" class="panel-body">


                    </div>
                    <div id="chat_footer" class="panel-footer">
                        <div id="conversacion" class="row" >
                            <textarea name="texto" id="texto" row="5" class="col-md-8 col-xs-8"  style="resize: none;height: 55px;padding:1px;"></textarea>
                            <div class="col-md-4 col-xs-4">
                                <div class="row">
                                    <button type="button" class="btn btn-success col-xs-12" title="Enviar" onclick="fncEnviarChat();" style="margin-top:0px;margin-bottom:0px; padding-top:2px;padding-bottom:2px;">Enviar</button>
                                    <button type="button" class="btn btn-danger col-xs-12" onclick="fncLogout();" style="margin-top:2px;margin-bottom:2px;padding-top:2px;padding-bottom:2px;">Desconectar</button>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
        <div class="row botones">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                
                 <button  id="btnCancelar" name="btnCancelar" class="btn btn-danger" title="Guardar" type="button" onclick="window_float_save_modal();" >
                    <img  alt="" src="/include/img/boton/cancel_14x14.png">
                Cerrar
                </button>
            </div>  
        </div>
  
    </form>
<?php } ?>
<script type="text/javascript">
    var validar=function(){
        var texto=$.trim($('#texto').val());
        if(texto==""){
            toastem.error('Debe escribir alguna respuesta.');
            $('#texto').focus();
            return false;
        }
    }
    var desactivar=function(){
        $('#texto').prop('desabled',true);
        $('#texto').prop('desabled',true);
    }
    var fncEnviarChat=function(){
        var texto=$.trim($('#texto').val());
        if(texto==""){
            toastem.error('Debe escribir alguna respuesta.');
            $('#texto').focus();
           
        }else{
            cargarFormularios('pagina_web/ajaxEnviarChat','form',validar,function(resultado){
            if(resultado.resultado==1){
                $('#texto').val('');
                fnvMostrarChat();
            }
        });
        }
        
        
        
    }
    var fnvMostrarChat=function(){
        var web_chat_session_ID=<?php echo $GLOBALS['oWeb_chat_Session']->ID;?>;
        cargarValores('pagina_web/ajaxMostrarChat',web_chat_session_ID,function(resultado){
            $('#chat_body').html(resultado.resultado);
            $("#chat_body").animate({ scrollTop: $('#chat_body')[0].scrollHeight}, 1000);
        });
    }
    var fncLogout=function(){
        var web_chat_session_ID=<?php echo $GLOBALS['oWeb_chat_Session']->ID;?>;
        cargarValores('pagina_web/ajaxLogout',web_chat_session_ID,function(resultado){
            if(resultado.resultado==1){
                toastem.info(resultado.mensaje);
                $('#conversacion').find('input,textarea,button,select').each(function(e){
                    $(this).prop('disabled',true);
                });   
            }
        });
    }
    $('#texto').keypress(function(e){
        if(e.keyCode==13){
            fncEnviarChat();
        }
    });
    $(document).on('ready',function(){
        fnvMostrarChat();
        
    });
    setInterval(fnvMostrarChat, 1000);
</script>
<style>
    
    #chat_body{
         height: 300px;
         overflow:auto;
    }
    
    #frmLogin .row{
        margin-right: 0;
        margin-left:0;
        margin-bottom:15px;
    }
    #chat_footer input[type='text'],#chat_footer input[type='email'],#chat_footer textArea{
    display: block;
    /*width: 100%;*/
    height: 25px;
    /*padding: 6px 12px;*/
    font-size: 14px;
    line-height: 1.42857143;
    color: #555;
    background-color: #fff;
    background-image: none;
    border: 1px solid #ccc;
    border-radius: 4px;
    -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
    box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
    -webkit-transition: border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;
    -o-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
    transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
}
#conversacion.row,#login.row{
    margin-right: 0;
    margin-left: 0;
}
.text_chat_invitado{
    text-align:left;
    width: 100%;
    display: inline-block;
}
.text_chat_invitado p{
    float:right;
    -webkit-box-shadow: 2px 2px 2px 1px rgba(176,173,173,1);
-moz-box-shadow: 2px 2px 2px 1px rgba(176,173,173,1);
box-shadow: 2px 2px 2px 1px rgba(176,173,173,1);
    background: rgba(102, 255, 255,0.8);
    
    border-radius: 5px 5px 0 0;
    padding: 3px 2px;
}
.text_chat_operador{
    
    text-align:right;
}
#chat_body{
    text-align:right;
}
.text_chat_operador p{
    background: #FFF;
    -webkit-box-shadow: 2px 2px 2px 1px rgba(176,173,173,1);
-moz-box-shadow: 2px 2px 2px 1px rgba(176,173,173,1);
box-shadow: 2px 2px 2px 1px rgba(176,173,173,1);
    border-radius: 5px 5px 0 5px;
    padding: 3px 2px;
    color: #000; 
    display:inline-block;
    float:left;
}
.usuario_chat{
    font-weight: bold;
}
.fecha{
    font-size:11px;
}
</style>
    <?php if (isset($GLOBALS['resultado']) && $GLOBALS['resultado'] == 1) { ?>
       
        <script type="text/javascript">
            $(document).on('ready',function(){
                toastem.success('<?php echo $GLOBALS['mensaje'];?>');
            });
            //setTimeout('window_float_save();', 1000);
        </script>
    <?php } ?>
 <?php if (isset($GLOBALS['resultado']) && $GLOBALS['resultado'] == -1) { ?>
        <div class="float-mensaje">
            <?php echo $GLOBALS['mensaje']; ?>
        </div>
        <script type="text/javascript">

            $(document).on('ready',function(){
                toastem.error('<?php echo $GLOBALS['mensaje'];?>');
            });
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
