<?php
	require ROOT_PATH."models/menu.php";
        $menu=menu::getMenuxUsuarioIDHtml($_SESSION['usuario_ID'],$_SERVER["REQUEST_URI"]);
        echo utf8_encode($menu);
	//require ROOT_PATH."models/menu_perfil.php";
	//require ROOT_PATH."models/modulo.php";
	
	//$dtModulo=modulo::getModulosxUsuarioID($_SESSION['usuario_ID']);
	
        
        //$dtModulo=modulo::getModulosxUsuarioID($_SESSION['usuario_ID']);
	//$dtMenu=menu::getGrid("mu.usuario_ID=".$_SESSION['usuario_ID']." and mn.modulo_ID=".$_SESSION['modulo_ID']." and mn.menu_ID=0",-1,-1,"mn.orden asc");
	//obtenerMenuxModulo($dtModulo);

	/*function obtenerMenuxModulo($dtModulo){
           require ROOT_PATH."models/menu.php";
		global $controlador;
		global $vista;
				
		//$dtMenuPrincipal=filtro($dtMenu,'menu_ID',0);
		$url_now='/'.$controlador.'/'.(strtolower($vista)=='index'?'':$vista);		
		
		$html='';
                $ruta=$_SERVER["REQUEST_URI"];
		foreach($dtModulo as $iModulo){
                    $selec="";
                    $class_active="";
                    $dtMenu1=getMenu($ruta);
                    if(count($dtMenu1)>0){
                        if($dtMenu1[0]['modulo_ID']==$iModulo['ID']){
                             $selec='<span class="selected"></span>';
                             $class_active="active";
                        }
                    }
                    $html.='<li id="mod'.$iModulo['ID'].'" class="submenu '.$class_active.'">';
                    $html.='<a href="javascript:void(0);">';
                    $html.='<span class="icon"><i class="'.$iModulo['imagen'].'"></i></span>';
                    $html.='<span class="text">'.$iModulo['nombre_corto'].'</span>';
                    $html.='<span class="arrow"></span>'.$selec;
                    
                    
                   
                    $html.='</a>';
            
                    $dtMenu=menu::getMenuxUsuarioID($_SESSION['usuario_ID'],$iModulo['ID']);
                    if(count($dtMenu)>0){
                        $html.='<ul>';
                        
                        foreach($dtMenu as $iMenu){
                            $active="";
                            if(count($dtMenu1)>0){
                                if($dtMenu1[0]['ID']==$iMenu['ID']){
                                    
                                     $active='class="active"';
                                }
                            }
                            $html.='<li id="menu'.$iMenu['ID'].'" '.$active.'>';
                            $html.='<a id="'.$iMenu['ID'].'" href="'.$iMenu['url'].'">';
                            $html.=$iMenu['nombre'];
                            $html.='</a>';
                            $html.='</li>';
                       }
                        $html.='</ul>';
                    }
                    $html.='</li>'; 
                       
                        
                        
		}
		//$html.='</ul>';
		echo utf8_encode($html);
	}
	function obtenerMenu($dtMenu_Hijos,$menu_ID,$url_now)
	{
          
            $total_hijos=count($dtMenu_Hijos);
            $html='';
            if($total_hijos>0){
                $html='<ul class="dropdown-menu" style="'.$_SESSION['color'].'">';
                foreach($dtMenu_Hijos as $iSubmenu)
                {
                    $subMenu_Select='';			
                    if(strtolower($url_now)==strtolower($iSubmenu['url'])){
                            $subMenu_Select='subMenu-itemSel';
                    }
                    $html.='<li><a href="'.$iSubmenu['url'].'" target="_self">'.FormatTextView(strtoupper($iSubmenu['nombre'])).'</a></li>';
                   
                }
                $html.= '</ul>';
            }

            return utf8_encode($html);
	}
	function obtenerSubMenu($dtMenu_Hijos,$menu_ID,$url_now)
	{
          
            $total_hijos=count($dtMenu_Hijos);
            $html='';
            if($total_hijos>0){
                $html='<ul class="dropdown-menu" style="'.$_SESSION['color'].'">';
                foreach($dtMenu_Hijos as $iSubmenu)
                {
                    $subMenu_Select='';			
                    if(strtolower($url_now)==strtolower($iSubmenu['url'])){
                            $subMenu_Select='subMenu-itemSel';
                    }
                    $html.='<li><a href="'.$iSubmenu['url'].'" target="_self">'.FormatTextView(strtoupper($iSubmenu['nombre'])).'</a></li>';
                   
                }
                $html.= '</ul>';
            }

            return utf8_encode($html);
	}
	//--------------------------
	/*
	$menu=menu::getByUsuarioID($_SESSION['usuario_ID']);
	$menu_principal=filtro($menu,'menu_ID',0);
	
	$url_now='/'.$controlador.'/'.$vista;
	$oMenu=menu::getByUrl('/'.$controlador.'/');
	$_SESSION['menu_ID']=-1;
	
	$menu_select='<div class="menu-select-nombre">Principal</div>';
	
	if ($oMenu)
	{
		$_SESSION['menu_ID']=$oMenu->ID;
		$menu_select='<div class="menu-select-nombre">'.strtoupper($oMenu->nombre).'</div>';
	}	
	
	$menu_mostrar='<ul id="menu">';
	$menu_mostrar.='<li class="menu-noItem"><img title="Usuario" src="include/img/btn_menu/user.png"></br>'.ucfirst($_SESSION['usuario_nombre']).'<br/><b><u>'.$menu_select.'</u></b></li>';
	
	foreach($menu_principal as $item)
	{
			$class_sel='';
			if($_SESSION['menu_ID']==$item['ID']){
				$class_sel='menu-itemSel';
			}
			
			$menu_mostrar.='<li class="menu-item '.$class_sel.'"><a href="'.$item['url'].'" target="_self">';
			$menu_mostrar.= '<img title="'.utf8_encode($item['nombre']).'" src="include/img/btn_menu/'.$item['ID'].'.png" /><br />'.utf8_encode($item['nombre']).'</a>';		
			$menu_mostrar.=subMenu($menu,$item['ID'],$url_now);
			$menu_mostrar.= '</li>';
	}
	$menu_mostrar.= '<li class="menu-item"><a href="javascript:logout();"><img title="Salir del SIstema" src="include/img/btn_menu/exit_48x48.png" /><br />Salir</a></li>';
	$menu_mostrar.='</ul><div class="clear"></div> ';
	
	echo $menu_mostrar;
	
	/*Funcion para obtener los submenus*/
	/*
	function subMenu($menu,$menu_ID,$url_now)
	{
		$subMenu=filtro($menu,'menu_ID',$menu_ID);
		$menu_mostrar='<ul >';
		foreach($subMenu as $item)
		{
			$subMenu_Select='';			
			if(strtolower($url_now)==strtolower($item['url'])){
				$subMenu_Select='subMenu-itemSel';
			}
			
			$menu_mostrar.= '<li class="menu-item '.$subMenu_Select.'"><a href="'.$item['url'].'" target="_self">'.utf8_encode($item['nombre']).'</a>';		
			$menu_mostrar.=subMenu($menu,$item['ID'],$url_now);
			$menu_mostrar.= '</li>';
		}
		$menu_mostrar.= '</ul>';
		return $menu_mostrar;
	}
	*/
	
?>