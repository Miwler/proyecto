$(document).on("ready",function(){
	$('input:submit, button').click(function (){
			return false;
	});
	
	$('#txtUsuario,#txtContrasena,#captcha,#txtUsuario_float,#txtContrasena_float,#captcha_float').keypress(function(e){
		
		if(e.which==13){
				login();	
		}
	});
});


function login()
{			
	var nombre=$.trim($('#txtUsuario').val());
	var contrasena = $.trim($('#txtContrasena').val());
	var captcha=document.getElementById('captcha');
	
	if(nombre=='' || contrasena==''){
		$('#lg-message').css('display','block');
		$('#lg-message').html('El usuario y la contrasena son requeridos');
		$('#txtUsuario').focus();
		return;
	}
	
	if(captcha!=null){			
            if($.trim($(captcha).val())==''){
                $('#lg-message').css('display','block');
                $('#lg-message').html('Ingrese el codigo que se muestra en la imagen');
                $('#captcha').focus();
                return;
            }
	}
	
	$('#lg-message').html('');
	
	$('#imgLoading').css('display','');
	$('#btnEnviar').css('display','none');
	
	var url='Acceso/login';
	$.ajax({
			type:'POST',
			url:url.toLowerCase(),
			data:$('#login').serialize(),
			success:function(respuesta){
				respuesta=JSON.parse(respuesta);		

				$('#lg-message').css('display','none');
				$('#lg-message').html('');
				$('#imgLoading').css('display','none');
				$('#btnEnviar').css('display','');

				if(respuesta.resultado==0)
				{
					$('#lg-message').css('display','block');
					$('#lg-message').html(respuesta.mensaje);
					$('#captcha').val('');
					$('#captcha').focus();
					$('#imgCaptcha').attr('src','lib/captcha.php?newCaptcha='+Math.random());
					$('#txtContrasena').val('');
					$('#txtUsuario').focus();
					return false;				
				}
				
				window.location.reload();
			},
			error:function(){
				$('#lg-message').css('display','block');
				$('#lg-message').html('Ocurri� un error al conectars con el servidor');
				$('#captcha').val('');
				$('#captcha').focus();
				$('#imgCaptcha').attr('src','lib/captcha.php?newCaptcha='+Math.random());
				$('#txtContrasena').val('');
				$('#txtUsuario').focus();
				
			}			
		});	
}