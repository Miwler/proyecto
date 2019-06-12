
    var pdf = (function ($) {

        var descargar = function (url) {
           //console.log(url);
            var i=0;
            $('#pdf').each(function(){
                i++;
            });
            if(i==0){
                $('body').append('<div id="pdf" style="display: none;"></div>');
            }
         
            var iframe = document.createElement('iframe');
           iframe.id='pdfImprimir';
            iframe.src =url+'?empresa_ID='+getParameterByName('empresa_ID');
            $('#pdf').html(iframe);
           
        };



        var mostrar = function (url) {
            
            var i=0;
            $('#pdf').each(function(){
                i++;
            });
            if(i==0){
                $('body').append('<div id="pdf" ></div>');
                var iframe = document.createElement('iframe');
                iframe.id='pdfImprimir';
                iframe.src =url+'?empresa_ID='+getParameterByName('empresa_ID');
                $('#pdf').html(iframe);
            }else {
                
                $('#pdf').prop('src',url);
            }
         
            
           
        };


        var error = function (content) {
            //alert(content);
            var item = $('<div class="notification error"><span>' + content + '</span></div>');
            $("#toastem").append($(item));
            $(item).animate({ "right": "12px" }, "fast");
            setInterval(function () {
                $(item).animate({ "right": "-400px" }, function () {
                    $(item).remove();
                });
            }, 4000);
        };
        var info = function (content) {
            //alert(content);
            var item = $('<div class="notification info"><span>' + content + '</span></div>');
            $("#toastem").append($(item));
            $(item).animate({ "right": "12px" }, "fast");
            setInterval(function () {
                $(item).animate({ "right": "-400px" }, function () {
                    $(item).remove();
                });
            }, 4000);
        };
        var advertencia = function (content) {
            //alert(content);
            var item = $('<div class="notification advertencia"><span>' + content + '</span></div>');
            $("#toastem").append($(item));
            $(item).animate({ "right": "12px" }, "fast");
            setInterval(function () {
                $(item).animate({ "right": "-400px" }, function () {
                    $(item).remove();
                });
            }, 4000);
        };
        

        return {
            descargar: descargar,
            mostrar: mostrar,
            error: error,
            info: info,
            advertencia: advertencia
        };

    })(jQuery);
