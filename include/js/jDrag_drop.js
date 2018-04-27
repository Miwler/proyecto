var ddPosicion = 0;
var ddObjMovimiento = null;
var ddObjSel = 0;

/*-----------------------Para elementos dentro del Document parent-------------------------*/
function evitaEventos(event) {
    // Funcion que evita que se ejecuten eventos adicionales
    event.preventDefault();
}

function comienzoMovimiento(event, obj) {
    objMovimiento = obj;

    // Obtengo la posicion del cursor
    cursorComienzoX = event.clientX + document.documentElement.scrollLeft + document.body.scrollLeft;
    cursorComienzoY = event.clientY + document.documentElement.scrollTop + document.body.scrollTop;

    document.addEventListener("mousemove", enMovimiento, true);
    document.addEventListener("mouseup", finMovimiento, true);

    // Actualizo el posicion del elemento
    objMovimiento.style.zIndex = ++ddPosicion;
    evitaEventos(event);
}

function enMovimiento(event) {
    var xActual, yActual;

    xActual = event.clientX + document.documentElement.scrollLeft + document.body.scrollLeft;
    yActual = event.clientY + document.documentElement.scrollTop + document.body.scrollTop;    

    objMovimiento.style.left = (elComienzoX + xActual - cursorComienzoX) + "px";
    objMovimiento.style.top = (elComienzoY + yActual - cursorComienzoY) + "px";

    evitaEventos(event);
}

function finMovimiento() {   
    document.removeEventListener("mousemove", enMovimiento, true);
    document.removeEventListener("mouseup", finMovimiento, true);
}

function newDrag_Drop(obj) {
    obj.onmouseover = function () {
        this.style.cursor = 'move'
    }

    obj.onmousedown = comienzoMovimiento;
}
/*------------------------------------------------*/

/*------------Funciones para los Iframe---------*/

function comienzoMovimiento_frame(event, obj) {
    ddObjSel = 1;
    ddObjMovimiento = obj;
    
    cursorComienzoX = event.clientX + document.documentElement.scrollLeft + document.body.scrollLeft;
    cursorComienzoY = event.clientY + document.documentElement.scrollTop + document.body.scrollTop;
    
    document.addEventListener("mousemove", enMovimiento_frame, true);
    document.addEventListener("mouseup", finMovimiento_frame, true);
    //document.addEventListener("mouseover", verificar, true);	

    elComienzoX = parseInt(ddObjMovimiento.style.left);
    elComienzoY = parseInt(ddObjMovimiento.style.top);
    // Actualizo el posicion del elemento
    ddObjMovimiento.style.zIndex = ++ddPosicion;

    evitaEventos(event);
}

function enMovimiento_frame(event) {
    var xActual, yActual;

    xActual = event.clientX + document.documentElement.scrollLeft + document.body.scrollLeft;
    yActual = event.clientY + document.documentElement.scrollTop + document.body.scrollTop;
    //console.log(xActual + ' - ' + yActual);

    ddObjMovimiento.style.left = (xActual - cursorComienzoX) + "px";
    ddObjMovimiento.style.top = (yActual - cursorComienzoY) + "px";

    evitaEventos(event);
}

function finMovimiento_frame() {
    document.removeEventListener("mousemove", enMovimiento_frame, true);
    document.removeEventListener("mouseup", finMovimiento_frame, true);    
    ddObjSel = 0;
}

/*----------------*/