<?php

class menu_usuario {

    private $ID;
    private $usuario_ID;
    private $menu_ID;
    private $usuario_id_creacion;
    private $usuario_mod_id;
    private $getMessage;

    public function __set($var, $valor) {
        // convierte a minúsculas toda una cadena la función strtolower
        $temporal = $var;

        // Verifica que la propiedad exista, en este caso el nombre es la cadena en "$temporal"		
        if (property_exists('menu_usuario', $temporal)) {
            $this->$temporal = $valor;
        } else {
            echo $var . " No existe.";
        }
    }

    public function __get($var) {
        $temporal = $var;

        // Verifica que exista
        if (property_exists('menu_usuario', $temporal)) {
            return $this->$temporal;
        }

        // Retorna nulo si no existe
        return null;
    }

    function insertar() {
        $cn = new connect();
        $retornar = -1;
        try {
            $q = 'SET @maxrow:=(select ifnull(max(ID),0) from menu_usuario);';
            $cn->transa($q);

            $q = 'INSERT INTO menu_usuario (ID,usuario_ID, menu_ID, usuario_id_creacion)';
            $q.='VALUES ((select @maxrow:=@maxrow+1),' . $this->usuario_ID . ',' . $this->menu_ID . ',' . $this->usuario_id_creacion . ');';
            //echo $q;
            $retornar = $cn->transa($q);

            $this->getMessage = 'Se guardó correctamente.';
            return $retornar;
        } catch (Exception $ex) {
            throw new Exception($q);
        }
    }

    function actualizar() {
        $cn = new connect();
        $retornar = -1;
        try {

            $q = 'UPDATE menu_perfil SET menu_ID=' . $this->menu_ID . ',perfil_ID=' . $this->perfil_ID . ',usuario_mod_id=' . $this->usuario_mod_id . ', fdm=Now()';
            $q.=' WHERE ID=' . $this->ID;

            $retornar = $cn->transa($q);

            $this->getMessage = 'Se guardó correctamente.';
            return $retornar;
        } catch (Exception $ex) {
            throw new Exception("Ocurrio un Error en la consulta");
        }
    }

    function eliminar() {
        $cn = new connect();
        $retornar = -1;
        try {

            $q = 'UPDATE menu_usuario SET del=1,usuario_mod_id=' . $this->usuario_mod_id . ', fdm=Now()';
            $q.=' WHERE del=0 and usuario_ID=' . $this->usuario_ID.' and menu_ID='.$this->menu_ID;

            $retornar = $cn->transa($q);

            $this->getMessage = 'Se eliminó correctamente.';
            return $retornar;
        } catch (Exception $ex) {
            throw new Exception("Ocurrio un Error en la consulta");
        }
    }

    static function getByID($ID) {
        $cn = new connect();
        try {
            $q = 'Select ID,menu_ID,perfil_ID,usuario_id,ifnull(usuario_mod_id,0) as usuario_mod_id';
            $q.='from menu_perfil ';
            $q.='where ID=' . $ID;

            $dt = $cn->getGrid($q);
            $oMenu_perfil = null;

            foreach ($dt as $item) {
                $oMenu_perfil = new menu();

                $oMenu_perfil->ID = $item['ID'];
                $oMenu_perfil->menu_ID = $item['menu_ID'];
                $oMenu_perfil->perfil_ID = $item['perfil_ID'];
                $oMenu_perfil->usuario_id = $item['usuario_id'];
                $oMenu_perfil->usuario_mod_id = $item['usuario_mod_id'];
            }
            return $oMenu_perfiloMenu_perfil;
        } catch (Exeption $ex) {
            throw new Exception("Ocurrio un Error en la consulta");
        }
    }

    function verificarDuplicado() {
        $cn = new connect();
        $retornar = -1;
        try {

            //Verifico que no exista registrado un mismo menú para un mismo perfil
            $q = 'SELECT count(ID) FROM menu_perfil';
            $q.=' WHERE del=0 and menu_ID=' . $this->menu_ID . ' and perfil_ID=' . $this->perfil_ID;

            if ($this->ID != '') {
                $q.=' and ID<>' . $this->ID;
            }

            $retornar = $cn->getData($q);

            if ($retornar > 0) {
                $this->getMessage = 'Ya existe un menu realicionado con este perfil.';
                return $retornar;
            }

            return $retornar;
        } catch (Exception $ex) {
            throw new Exception("Ocurrio un Error en la consulta");
        }
    }

    static function getCount($filtro = '') {
        $cn = new connect();
        try {
            $q = 'select count(ID) ';
            $q.=' FROM menu_usuario';
            $q.=' where del=0 ';

            if ($filtro != '') {
                $q.=' and ' . $filtro;
            }

            $resultado = $cn->getData($q);

            return $resultado;
        } catch (Exception $ex) {
            throw new Exception($q);
        }
    }

    static function getGrid($filtro = '', $desde = -1, $hasta = -1, $order = 'ID asc') {
        $cn = new connect();
        try {
            $q = 'select ID, menu_ID from menu_usuario';
           $q.=' where  del=0';

            if ($filtro != '') {
                $q.=' and ' . $filtro;
            }

            $q.=' Order By ' . $order;

            if ($desde != -1 && $hasta != -1) {
                $q.=' Limit ' . $desde . ',' . $hasta;
            }

            $dt = $cn->getGrid($q);
            return $dt;
        } catch (Exception $ex) {
            throw new Exception('Ocurrio un Error en la consulta');
        }
    }
    static function getGridUsuario_Empresa($filtro = '', $desde = -1, $hasta = -1, $order = 'em.ID asc') {
        $cn = new connect_new();
        try {
            $q = 'select em.ID, em.nombre';
            $q.=' from menu_usuario mu,menu me,modulo_empresa moe,empresa em';
            $q.=' where mu.menu_ID=me.ID and me.modulo_ID=moe.modulo_ID and moe.empresa_ID=em.ID and me.del=0 and mu.del=0 ';
            $q.=' and moe.del=0 and em.del=0';
            
            if ($filtro != '') {
                $q.=' and ' . $filtro;
            }
            $q.=' group by em.ID, em.nombre';
            
            $q.=' Order By ' . $order;

            if ($desde != -1 && $hasta != -1) {
                $q.=' Limit ' . $desde . ',' . $hasta;
            }
            //echo $q;
            $dt = $cn->getGrid($q);
            return $dt;
        } catch (Exception $ex) {
            throw new Exception('Ocurrio un Error en la consulta');
        }
    }
    static function getGridLista() {
        $cn = new connect();
        try {
           // $q='SELECT ID, usuario_ID, menu_ID, usuario_id_creacion, fdc, fdm, usuario_mod_id, del FROM menu_usuario '
             //   . 'inner join menu on menu.ID=menu_ID WHERE usuario_ID='.$id;
            
            $q='select me.ID, me.nombre as menu, mo.nombre as modulo';
            $q.=' from menu me, modulo mo';
            $q.=' where me.modulo_ID=mo.ID and me.del=0 and mo.del=0 order by mo.orden,me.orden';
//echo $q;
            $dt = $cn->getGrid($q);
            return $dt;
        } catch (Exception $ex) {
            throw new Exception('Ocurrio un Error en la consulta');
        }
    }
function verificarExistencia(){
    $cn = new connect();
        try {
           
            $q='select count(ID) from menu_usuario';
            $q.=' where del=0 and usuario_ID='.$this->usuario_ID.' and menu_ID='.$this->menu_ID;
            
//echo $q;
            $retorna = $cn->getData($q);
            return $retorna;
        } catch (Exception $ex) {
            throw new Exception($q);
        }
}
}

?>