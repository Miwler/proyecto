/*$(function () {
    $('.menu').hover(function ()
    {
       // alert(this);
    });
});*/

var tr = '';
$(document).ready(function () {
    //Ocultamos el menú al cargar la página
    $("#menu_mouse_right").hide();

    /* mostramos el menú si hacemos click derecho
    con el ratón */
    $('.Grid-content').bind("contextmenu", function (e) {
        if (e == null) {
            e = window.event;
        }

        tr = e.target.parentNode;
        $(tr).click();
        $("#menu_mouse_right").css({ 'display': 'block', 'left': e.pageX, 'top': e.pageY});
        return false;
    });


    //cuando hagamos click, el menú desaparecerá
    $(document).click(function (e) {
        if (e.button == 0) {
            $("#menu_mouse_right").css("display", "none");
        }
    });

    //si pulsamos escape, el menú desaparecerá
    $(document).keydown(function (e) {
        if (e.keyCode == 27) {
            $("#menu_mouse_right").css("display", "none");
        }
    });

    $('#img-mostrar-ocultar').click(function () {
        if ($('#ulMenu-acceso-directo').css('display') == 'none') {
            $('#ulMenu-acceso-directo').css('display', 'inline-block');
        } else {
            $('#ulMenu-acceso-directo').css('display', 'none');
        }
    });
});