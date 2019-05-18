<?php		
	require ROOT_PATH . "views/shared/content-float-modal-hijo.php";	
?>	
<?php function fncTitle(){?>Registrar Cotización<?php } ?>

<?php function fncHead(){?>
	<script type="text/javascript" src="include/js/jForm.js"></script>
        <style>
            #datatable-ajax td{
                font-size:12px;
            }
        </style>

<?php } ?>

<?php function fncTitleHead(){ ?>Registrar Cotización<?php } ?>

<?php function fncMenu(){?>
<?php } ?>

<?php function fncPage(){?>



<?php if(!isset($GLOBALS['resultado'])||$GLOBALS['resultado']==-1){ ?>
<form id="form" method="POST" action="#"  class="form-horizontal" onsubmit="return validar();" >
    <div class="form-body">
        <div class="form-group">
            <label class="control-label col-sm-1">Periodo:</label>
            <div class="col-sm-2 col-xs-2">
                <select id="selPeriodo" name="selPeriodo" class="form-control">
                    <option value="0">Todos</option>
                    <?php for($i=periodo_inicio;$i<=date("Y");$i++){?>
                    <option value="<?php echo $i?>" <?php echo (($i==date("Y"))?"selected":"de");?>><?php echo $i?></option>
                    <?php } ?>
                </select>
               
            </div>
            <label class="control-label col-sm-1 col-xs-1">Serie:</label>
            <div class="col-sm-2 col-xs-2">
                <input type="text" id="txtSerie" name="txtSerie" autocomplete="off" class="form-control">
            </div>
            <label class="control-label col-sm-1">Número</label>
            <div class="col-sm-2">
                <input type="text" id="txtNumero" name="txtNumero" autocomplete="off" class="form-control">
            </div>
            <div class="col-sm-2">
                <div class="ckbox ckbox-theme">
                    <input id="ck_electronico" name="ck_electronico" checked="checked" type="checkbox">
                    <label for="ck_electronico">Electrónicos</label>
                </div>
            </div>
            <div class="col-sm-1 col-xs-1">
                <button type="button" class="btn btn-success" onclick="fngetData();"><i class="fa fa-search"></i></button>
            </div>
        </div>
        <div class="form-group"  style="height: 370;overflow:auto;">
            <table id="datatable-ajax" class="table table-primary  table-middle table-striped table-bordered table-condensed dt-responsive nowrap">
                <thead>
                    <tr>
                        <th>N°</th>
                        <th>Fact.</th>
   
                        <th>Fecha</th>
                        <th>Cliente</th>
                        <th>Total</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <!--tbody section is required-->
                <tbody></tbody>
                <!--tfoot section is optional-->
                
            </table>
        </div>
    </div>
    
</form>
<script type="text/javascript">
    var myTable;
    function fngetData() {
        block_ui(function(){
                var myObject = new Object();
                
                 enviarAjax('Salida/ajaxFacturas_Emitidas', 'form', myObject, function (res) {
                    
                    var jsonObject = $.parseJSON(res);
                   
                    var result = jsonObject.map(function (item) {
                         
                        var result = [];
                        result.push(item.num);
                        result.push(item.comprobante);
                        result.push(item.fecha_emision);
                        result.push(item.cliente);
                        result.push(item.total);
                        result.push(item.accion);
                        result.push("");
                         $.unblockUI();
                        return result;
                    });
                    
                    myTable.rows().remove();
                    myTable.rows.add(result);
                    myTable.draw();
                   $.unblockUI();
                });
            });
    }
    function fnGridCSS() {
        try {
            var shadows =
                [

                    { "width": "5%", "targets": 0,"className":"text-center" },
                    { "width": "5%", "targets": 1,"className":"text-center"},
                    { "width": "10%", "targets": 2,"className":"text-center" },
                    { "width": "80%", "targets": 3 },
                    { 'targets': [5], 'orderable': false, 'searchable': false, "width": "10%","className":"text-center" }
                ];

            myTable = build_data_table($('#datatable-ajax'), shadows, [[0, "asc"]]);

        } catch (e) {
            //alert(e.message);
            mensaje.error('Error', e.message);
        }
    }
   
    var fncSeleccionar=function(ID){
        parent.windos_float_save_modal_hijo(ID);
    }
    $(document).ready(function(){
       fnGridCSS();
        fngetData();
                
        
    });
    
</script>   
<?php }?>
            
<?php if(isset($GLOBALS['resultado'])&&$GLOBALS['resultado']==-1){ ?>

    <script type="text/javascript">
        $(document).ready(function () {
            mensaje.error('MENSAJE DE RESULTADO','<?php echo $GLOBALS['mensaje']; ?>');
        });
    </script>
<?php } ?>
<?php if(isset($GLOBALS['resultado'])&&$GLOBALS['resultado']==1){ ?>
<script type="text/javascript">
    $(document).ready(function () {
       toastem.success('<?php echo $GLOBALS['mensaje']; ?>');
    });
    setTimeout('parent.windos_float_save_modal_hijo(<?php echo json_encode($GLOBALS['obj']);?>);', 1000);
    
   //ampliarVentanaVertical(750,'form');
    //fncCargar_Detalle_Cotizacion();
</script>

<?php } ?>

<?php if(isset($GLOBALS['resultado'])&&$GLOBALS['resultado']==0){ ?>
     <div class="float-mensaje">
          <?php  echo $GLOBALS['mensaje']; ?>
     </div>
     <div class="group-btn">
         <input type="button" onclick ="redireccionar_parent('/');" value ="Iniciar Sesión"/>
     </div>
 <?php } ?>

	     
<?php }?>        