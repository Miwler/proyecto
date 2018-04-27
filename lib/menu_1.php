<?php
	require ROOT_PATH."models/menu.php";
	//require ROOT_PATH."models/menu_perfil.php";
	//require ROOT_PATH."models/modulo.php";
	
	//$dtModulo=modulo::getModulosxUsuarioID($_SESSION['usuario_ID']);
	$dtMenu=menu::getMenuxUsuarioID($_SESSION['usuario_ID'],$_SESSION['modulo_ID'],0);
	//$dtMenu=menu::getGrid("mu.usuario_ID=".$_SESSION['usuario_ID']." and mn.modulo_ID=".$_SESSION['modulo_ID']." and mn.menu_ID=0",-1,-1,"mn.orden asc");
	obtenerMenuxModulo($dtMenu);

	function obtenerMenuxModulo($dtMenu){
           
		global $controlador;
		global $vista;
				
		//$dtMenuPrincipal=filtro($dtMenu,'menu_ID',0);
		$url_now='/'.$controlador.'/'.(strtolower($vista)=='index'?'':$vista);		
		
		$html='';
		foreach($dtMenu as $iMenu){
                        $dtMenu_Hijos=menu::getMenuxUsuarioID($_SESSION['usuario_ID'],$_SESSION['modulo_ID'],$iMenu['ID']);
                        $class_dow="";
                        $class_active="";
                        if(isset($_SESSION['menu_ID'])&& $_SESSION['menu_ID']==$iMenu['menu_ID']){
                          
                            $class_active="style='background:#000;'";
                        
                        }
                        
                        $class_doogle="";
                        $icono="";
                        if(count($dtMenu_Hijos)>0){
                            $class_dow='class="dropdown"';
                            $class_doogle='class="dropdown-toggle" data-toggle="dropdown"';
                            $icono='<span class="caret"></span>';
                        }
			$menu_active='';			
			if(strtolower($url_now)==strtolower($iMenu['url'])){
                            $menu_active='class="active"';
			}
			$html.='<li '.$class_dow.' >';
			$html.='<a id="'.$iMenu['ID'].'" href="'.$iMenu['url'].'" target="_self" '.$class_doogle.' '.$class_active.'>'.  $iMenu['nombre'].' '.$icono.'</a>';
			$html.=obtenerSubMenu($dtMenu_Hijos,$iMenu['ID'],$url_now);
			$html.='</li>';
		}
		//$html.='</ul>';
		echo utf8_encode($html);
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