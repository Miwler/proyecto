<?php		
	require ROOT_PATH."views/shared/content-home.php";
?>	
<?php function fncTitle(){?>
		EMPRESAS
<?php } ?>
<?php function fncHead(){?>
                <!--<script src="../../include/js/jNotificacion.js" type="text/javascript"></script>-->
<?php } ?>
<?php function fncMenu(){?>
<?php } ?>
                
<?php function fncTituloCabecera(){?>
    SISTEMA INTEGRADO PARA EMPRESAS (SIEM)
<?php } ?>
<?php function fncPage(){?>
        <!-- Start body content -->
      
            <div class="row">
                
            <?php foreach($GLOBALS['dtEmpresa_Usuario'] as $item){?>
                
                <div class="col-ld-4 col-md-4 col-sm-6 col-xs-12">
                    <div class="mini-stat-type-6 <?php echo $item['stilo_fondo_tabs'];?> shadow">
                        <div class="inner">
                            <h4>
                                <?php echo strtoupper($item['razon_social']);?>
                            </h4>
                        </div>
                        <div class="icon">
                            <i class="<?php echo $item['icono']?>"></i>
                        </div>
                        <a  href="/home/main/<?php echo $item['ID'];?>" class="small-box-footer">
                            <?php echo strtoupper($item['nombre']);?> <i class="fa fa-arrow-circle-right"></i>
                        </a>

                    </div>
                </div>
            <?php } ?>
            </div>
          
        
        <!--/ End body content -->
        

<?php } ?>