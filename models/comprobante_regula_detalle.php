<?php

class comprobante_regula_detalle {
    public $ID;
    public $producto_ID;
    public $comprobante_regula_ID;
    public $descripcion;
    public $cantidad;
    public $precio_unitario;
    public $subtotal;
    public $total;
    public $igv;
    public $vigv;
    public $impuestos_tipo_ID;
    public $porcentaje_descuento;
    public $otros_cargos;
    private $factura_venta_detalle_ID ;
    public $usuario_id;
    public $usuario_mod_id;
    private $getMessage;
    public $producto;


  public function __set($var, $valor)
    {
// convierte a minúsculas toda una cadena la función strtolower
          $temporal = $var;

          // Verifica que la propiedad exista, en este caso el nombre es la cadena en "$temporal"
          if (property_exists('comprobante_regula_detalle',$temporal))
           {
                  $this->$temporal = $valor;
           }
           else
           {
                  echo $var . " No existe.";
           }
    }
    public function __get($var)
    {
        $temporal = $var;

        // Verifica que exista
        if (property_exists('comprobante_regula_detalle', $temporal))
         {
                return $this->$temporal;
         }

        // Retorna nulo si no existe
        return null;
    }
    function insertar()
    {
        
        $retornar=-1;
        try{
            
            $q='select ifnull(max(ID),0)+1 as ID from comprobante_regula_detalle;';
            $cn =new connect_new();
            $ID=$cn->getData($q);
            $q='INSERT INTO comprobante_regula_detalle(ID,producto_ID,comprobante_regula_ID,descripcion,cantidad,precio_unitario,subtotal,total,igv,vigv,impuestos_tipo_ID,factura_venta_detalle_ID,usuario_id) ';
            $q.='VALUES ('.$ID.','.$this->producto_ID.','.$this->comprobante_regula_ID.',"'.FormatTextSave($this->descripcion).'",'.$this->cantidad.','.$this->precio_unitario.','.$this->subtotal.','.$this->total.','.$this->igv;
            $q.=','.$this->vigv.','.$this->impuestos_tipo_ID.','.$this->factura_venta_detalle_ID.','.$this->usuario_id.');';
            //echo $q;
            $cn =new connect_new();
            $retornar=$cn->transa($q);

            $this->ID=$ID;
            $this->getMessage='Se guardó correctamente';

            return $retornar;

        } catch (Exception $ex) {

            throw new Exception($q);
        }
    }



    static function getGrid($comprobante_regula_ID)
    {
        $cn =new connect_new();
        try
        {
            $dt=$cn->store_procedure_getGrid("sp_comprobante_regula_detalle_getGrid",
            array("icomprobante_regula_ID"=>$comprobante_regula_ID));
            
            return $dt;
        }catch(Exception $ex)
        {
            throw new Exception($ex->getMessage());
        }
    }
        

  }


?>
