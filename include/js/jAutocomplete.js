var textAutocompletar = function (input) {
    this.input = document.getElementById(input);
    this.input_send = document.createElement('input');
    this.input_send.name = 'txt_autocomplete';
    this.input_send.style.display = 'none';
    document.body.appendChild(this.input_send);

    this.divAutocomplete = document.createElement('div');
    this.divAutocomplete.className = 'div_autocomplete';
    this.divAutocomplete.style.marginTop = ($(this.input).height()+5) + 'px';
    this.divAutocomplete.style.width = $(this.input).width() + 'px';
    this.divAutocomplete.style.display= 'none';

    this.vDesplazamiento = 0;

    this.input.parentNode.insertBefore(this.divAutocomplete, this.input);
    this.input.parentNode.appendChild(this.input_send);

    this.sel = 0;
    this.sel_old = -1;

    this.listActivo = false;

    this.seleccionar = fncDivSeleccionar;

    var obj = this;

    this.divAutocomplete.onmouseover = function () {
        obj.listActivo = true;
    }

    this.divAutocomplete.onmouseleave= function () {
        obj.listActivo = false;
    }
    
    this.input.onkeyup = function (e) {
        if (e.which == 40) {
            var movido=obj.seleccionar(obj.sel + 1);

            if (movido == 1) {
                var height_content = $(obj.divAutocomplete).height();
                var height_item = $('#divAutocomplete-item' + (obj.sel)).height();                
                var positionTop = $('#divAutocomplete-item' + (obj.sel)).position().top + height_item;

                if (positionTop > height_content) {
                    obj.vDesplazamiento = obj.vDesplazamiento + height_item;                    
                    $(obj.divAutocomplete).scrollTop(obj.vDesplazamiento);
                }
            }
            return false;
        }

        if (e.which == 38) {
            var movido=obj.seleccionar(obj.sel - 1);

            if (movido == 1) {
                var height_content = $(obj.divAutocomplete).height();
                var height_item = $('#divAutocomplete-item' + (obj.sel)).height();
                var positionTop = $('#divAutocomplete-item' + (obj.sel)).position().top;
                
                if (positionTop -height_item < 0) {                    
                    obj.vDesplazamiento = obj.vDesplazamiento - height_item;
                    obj.vDesplazamiento = obj.vDesplazamiento < 0 ? 0 : obj.vDesplazamiento;
                    $(obj.divAutocomplete).scrollTop(obj.vDesplazamiento);
                }
            }
            return false;
        }

        
        if ($.trim($(this).val()) != '') {
            fncAutocomplete(obj);
        } else {
            obj.divAutocomplete.style.display = 'none';
        }
    }

    this.input.onchange = function () {
        obj.input_send.value = this.value;
    }

    this.input.onblur = function () {
        if (!obj.listActivo) {
            obj.divAutocomplete.style.display = 'none';
        }
    }
    
}

var fncAutocomplete = function (obj) {    
    $.ajax({
        type: 'post',
        url: '/Inventario/ajaxAutocompletar',
        data: {
            texto: obj.input.value
        },
        datatype: "json",
        success: function (respuesta) {
            var respuesta = $.parseJSON(respuesta);
            var rows = respuesta.autocompletar.length;

            obj.divAutocomplete.innerHTML = '';

            for (i = 0; i < rows; i++) {
                var div = document.createElement('div');
                div.id = 'divAutocomplete-item' + (i + 1);
                div.className = 'divAutocomplete-item';
                div.innerHTML = respuesta.autocompletar[i].texto;
                div.onclick = function () {                    
                    obj.input.value = $(this).html();
                    obj.input.onchange();
                    obj.divAutocomplete.style.display = 'none';
                }
                $(obj.divAutocomplete).append(div);
            }

            if (rows > 0) {
                obj.divAutocomplete.style.display = 'block';
            } else {
                obj.divAutocomplete.style.display = 'none';
            }
            
            obj.sel = 0;
            obj.sel_old = -1;
            obj.vDesplazamiento = 0;
            $(obj.divAutocomplete).scrollTop(obj.vDesplazamiento);

        },
        error: function () {
            obj.divAutocomplete.style.display = 'none';
        },
    });
}

var fncDivSeleccionar = function (divSel) {    
    if (this.divAutocomplete.style.display != 'none') {
        if (document.getElementById('divAutocomplete-item' + divSel) != null) {
            this.sel_old = this.sel;
            this.sel = divSel;

            $('#divAutocomplete-item' + this.sel_old).removeClass('divSeleccionado');
            $('#divAutocomplete-item' + this.sel).addClass('divSeleccionado');
            this.input.value = $('#divAutocomplete-item' + this.sel).html();
            this.input.onchange();
            return 1;
        }
    }
    return 0;
}