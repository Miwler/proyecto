var ddPosicion_Float = 0;
var ddObjMovimiento_Float = null;

function evitaEventos(event) {
    // Funcion que evita que se ejecuten eventos adicionales
    event.preventDefault();
}

function comienzoMovimiento(event, obj) {
    parent.ddObjSel = 1;
    ddObjMovimiento_Float = obj;
    
    // Obtengo la posicion del cursor
    cursorComienzoX = event.clientX + document.documentElement.scrollLeft + document.body.scrollLeft;
    cursorComienzoY = event.clientY + document.documentElement.scrollTop + document.body.scrollTop;

    document.addEventListener("mousemove", enMovimiento, true);
    document.addEventListener("mouseup", finMovimiento, true);

    // Actualizo el posicion del elemento
    ddObjMovimiento_Float.style.zIndex = ++ddPosicion_Float;

    evitaEventos(event);
}

function enMovimiento(event) {
    var xActual, yActual;

    elComienzoX = parseInt((ddObjMovimiento_Float.style.left == '') ? 0 : ddObjMovimiento_Float.style.left);
    elComienzoY = parseInt((ddObjMovimiento_Float.style.top == '') ? 0 : ddObjMovimiento_Float.style.top);

    xActual = event.clientX + document.documentElement.scrollLeft + document.body.scrollLeft;
    yActual = event.clientY + document.documentElement.scrollTop + document.body.scrollTop;    
    //console.log(elComienzoX + ' - ' + elComienzoY);
    
    ddObjMovimiento_Float.style.left = (elComienzoX + xActual - cursorComienzoX) + "px";
    ddObjMovimiento_Float.style.top = (elComienzoY + yActual - cursorComienzoY) + "px";

    evitaEventos(event);
}

function finMovimiento() {
    document.removeEventListener("mousemove", enMovimiento, true);
    document.removeEventListener("mouseup", finMovimiento, true);
    parent.finMovimiento_frame();
}

function newDrag_drop_float(obj_in,obj_out) {
    obj_in.onmouseover = function () {
        this.style.cursor = 'move'
    }

    obj_in.onmousedown = function (event) {        
        var iframe = obj_out;
        comienzoMovimiento(event, iframe);
        parent.comienzoMovimiento_frame(event, iframe);
        document.addEventListener("mousemove", enMovimiento, true);
        document.addEventListener("mouseup", finMovimiento, true);
        document.addEventListener("mouseover", verificar, true);
    }
    
}

function verificar() {
    if (parent.ddObjSel == 0) {
        finMovimiento();
    }
}