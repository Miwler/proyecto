
 var modal = (function ($) {
    this.valor=false;
    var confirmacion = function (content,titulo,funcion,parametro) {

        $("#dialog-confirm").attr('title',titulo);
        $("#dialog-confirm").html(content);
        $( "#dialog-confirm" ).dialog({
            autoOpen: true,
            resizable: false,
            height: 'auto',
            width: 400,
            modal: true,
            buttons: {
              "Aceptar": function() {

                $( this ).dialog( "close" );
               
                
                if(parametro){
                    funcion.call(this,parametro);
                }else {
                    funcion.apply();
                }
               
              },
              Cancel: function() {
                $( this ).dialog( "close" );

              }
            }
          });
    };
    var advertencia = function (content,titulo) {

        $("#dialog-confirm").attr('title',titulo);
        $("#dialog-confirm").html(content);
        $( "#dialog-confirm" ).dialog({
            autoOpen: true,
            resizable: false,
            height: 'auto',
            width: 400,
            modal: true,
            buttons: {
              "Aceptar": function() {
                $( this ).dialog( "close" );
               }
            },
              Cancel: function() {
                $( this ).dialog( "close" );

              }
          });
    };
    return {
        confirmacion: confirmacion,
        advertencia: advertencia
       
    };

    })(jQuery);
$('#dialog-confirm').on('dialogclose', function(event) { alert('closed'); }); 