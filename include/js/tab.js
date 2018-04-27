var tabs = function (div_content) {
    this.tab = $(div_content).find('.tab');
    this.title = $('.tab > .title');
    this.content = this.tab.find('.content');
    this.width = '';
    this.sel = 0;
    this.selPrevious = -1;
    this.tab.find('content').css('display','none');    
    
    var oTabs = this;

    this.width = function () {
        $(div_content).css('width', '100%');
    }
    this.change = function () { }
    this.seleccionar = function (sel) {
        tabSeleccionar(oTabs, sel);
    }
    
    this.title.each(function (key, obj) {        
        $(this).click(function () {
            oTabs.seleccionar(key);
            
            /*Si el tab seleccionado es diferente al tab anterior*/
            if (oTabs.sel != oTabs.selPrevious) {
                oTabs.change();
            }
        });
    });

    $(oTabs.title[0]).click();
}

var tabSeleccionar = function (oTabs, sel) {
    oTabs.selPrevious = oTabs.sel;
    oTabs.sel = sel;
    
    $(oTabs.title[oTabs.selPrevious]).removeClass('tabSel');
    $(oTabs.content[oTabs.selPrevious]).css('display', 'none');

    $(oTabs.title[oTabs.sel]).addClass('tabSel');
    $(oTabs.content[oTabs.sel]).css('display', 'block');
}