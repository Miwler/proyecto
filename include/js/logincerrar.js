

function fncLogout()
{    
    $.ajax({
        type: "post",
        url: "/Acceso/Logout",
        data: { usuario:"1"          
        },
        datatype: "json",
        success: function (respuesta) {            
            var respuesta = $.parseJSON(respuesta);
            if (respuesta.resultado == -1) {
                alert(respuesta.mensaje);
            } else {
                window.location = "/";
            }
        },
		error:function(){
			location.reload();
		}
    });    
}

