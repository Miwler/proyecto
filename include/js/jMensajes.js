
    var mensaje = (function ($) {

        var normal = function (titulo,content,itemsfocus) {

             BootstrapDialog.show({
                title: titulo,
                message: content,
                type: BootstrapDialog.TYPE_DEFAULT,
                buttons: [{
                    label: 'Cerrar',
                    action: function(dialog) {
                        dialog.close();
                        if(itemsfocus){
                            $('#'+itemsfocus).focus();
                        }
                    }
                }]
            });
        };
        var success = function (titulo,content,itemsfocus) {
            // alert(content);
             BootstrapDialog.show({
                title: "<span class='glyphicon glyphicon-ok-circle'></span> "+titulo,
                message: content,
                type: BootstrapDialog.TYPE_SUCCESS,
                buttons: [{
                    label: 'Cerrar',
                    action: function(dialog) {
                        dialog.close();
                        if(itemsfocus){
                            $('#'+itemsfocus).focus();
                        }
                        
                    }
                }]
            });
        };
        var error = function (titulo,content,itemsfocus) {

            BootstrapDialog.show({
                title: "<span class='glyphicon glyphicon-minus-sign'></span> "+titulo,
                message: content,
                type: BootstrapDialog.TYPE_DANGER,
                buttons: [{
                    label: 'Cerrar',
                    action: function(dialog) {
                        
                        dialog.close();
                        if(itemsfocus){
                            $('#'+itemsfocus).focus();
                        }
                        
                    }
                }]
            });
       
        };
        var info = function (titulo,content,itemsfocus) {
            //alert(content);
             BootstrapDialog.show({
                title: titulo,
                message: content,
                type: BootstrapDialog.TYPE_INFO,
                buttons: [{
                    label: 'Cerrar',
                    action: function(dialog) {
                        dialog.close();
                        if(itemsfocus){
                            $('#'+itemsfocus).focus();
                        }
                    }
                }]
            });
        };
        var advertencia = function (titulo,content,itemsfocus) {
            //alert(content);
           BootstrapDialog.show({
                title: "<i class='fa fa-warning'></i> "+titulo,
                message: content,
                type: BootstrapDialog.TYPE_WARNING,
                buttons: [{
                    label: 'Cerrar',
                    action: function(dialog) {
                        dialog.close();
                        if(itemsfocus){
                            $('#'+itemsfocus).focus();
                        }
                    }
                }]
            });
        };
       
        /*$(document).on('click', '.notification', function () {
            $(this).fadeOut(400, function () {
                $(this).remove();
            });
        });*/

        return {
            normal: normal,
            success: success,
            error: error,
            info: info,
            advertencia: advertencia
        };

    })(jQuery);
   