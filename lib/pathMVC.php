<?php
function pathMVC(&$c,&$v,&$id)
{
    if (isset($_GET['c']))
    {
            $c=$_GET['c'];
            $v=$_GET['v'];

            if(isset($_GET['id'])){
                    $id=$_GET['id'];
            }
    }else
    {
            $replace=Array('/',basename(ROOT_PATH));
            $c=str_replace($replace,'',$_SERVER['REQUEST_URI']);			
    }	
}

?>