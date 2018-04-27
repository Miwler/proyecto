var jDate = function (inputResult) {
    this.Input_Result = document.getElementById(inputResult);
    this.div_content = document.createElement('div');
    this.content_parent = this.Input_Result.parentNode;
    this.calendar=null;
    this.calendar_close = false;

    /*-------------Fecha Actual-----------------*/
    this.day = 0;
    this.month= 0;
    this.year = 0;

    /*-------------Fecha Anterior-----------------*/
    this.dayPrevious = 0;
    this.monthPrevious = 0;
    this.yearPrevious = 0;
    this.countDaysPreviousView = 0;

    /*-------------Fecha Siguiente-----------------*/
    this.dayNext = 0;
    this.monthNext= 0;
    this.yearNext= 0;
    this.countDaysNextView = 0;

    this.next = false;
    this.previous = false;

    this.div_content.id = 'calendar-' + inputResult;
    this.div_content.className = 'jDate-divContent';    
    
    /*Defino las coordenadas donde aparecerá el calendario*/    
    this.div_content.style.top = (this.Input_Result.offsetHeight+3) + 'px';
    this.div_content.style.margin_left = (this.Input_Result.offsetLeft - this.Input_Result.parentNode.offsetLeft) + 'px';
    
    this.content_parent.style.position = 'relative';
    this.content_parent.insertBefore(this.div_content, this.Input_Result);

    var obj = this;
    
    /*-------------Eventos del calendario------------*/
    this.seleccionado = function () {
    }

    this.date_select = function (date) {
        date_select(this, date);
    }    

    this.getDate = function () {
        return getDate(obj);
    }

    this.getDatehNext = function () {
        return getDateNext(obj);
    }

    this.getDatePrevious = function () {
        return getDatePrevious(obj);
    }

    /*-----Agrego los eventos----------------*/
    this.div_content.onmouseover = function () {
        obj.calendar_close = false;
    }

    this.div_content.onmouseleave = function () {        
        obj.calendar_close = true;
    }
    
    this.Input_Result.onclick = function () {
        obj.calendar_close = true;
        create_calendar(obj);
        $(obj.div_content).css('display', 'block');       
    }

    this.Input_Result.ondblclick = function () {
        calendar_destroy(obj);
    }
            
    this.Input_Result.addEventListener('blur', function () {
        if (obj.calendar_close) {                        
            calendar_destroy(obj);
        }
    });

    this.Input_Result.addEventListener('keyup', function () {
        if (validarFecha(obj.Input_Result.value)) {
            create_calendar(obj);
        }
    });
}

function create_calendar(obj) {
    /*---------Defino las coordenadas donde aparecerá el calendario--------*/
    _position(obj);
    obj.getDate();   
    
    var existe = obj.calendar;
    
    if (existe != null) {
        $(existe).remove();
    }
    
    var calendar = document.createElement('div');
    
    var calendarHeader = document.createElement('div');
    calendarHeader.className = 'calendar-header';
    calendarHeader.style.textAlign = 'center';
    calendarHeader.innerHTML = getNameMonth(obj.month-1)+ ' - ' + obj.year;
    calendarHeader.style.position = 'relative';

    var imgNext = document.createElement('img');
    imgNext.src = '/include/img/boton/calendar/calendar-arrow-rigth_16x16.png';
    imgNext.className='calendar-arrow';
    imgNext.style.cssFloat = 'right';
    imgNext.onclick = function () {
        obj.next = true;
        create_calendar(obj);
        $(obj.Input_Result).focus();
    }
    calendarHeader.appendChild(imgNext);

    var imgPrevious = document.createElement('img');
    imgPrevious.src = '/include/img/boton/calendar/calendar-arrow-left_16x16.png';
    imgPrevious.className = 'calendar-arrow';
    imgPrevious.style.cssFloat = 'left';
    imgPrevious.onclick = function () {
        obj.previous = true;
        create_calendar(obj);
        $(obj.Input_Result).focus();
    }
    calendarHeader.appendChild(imgPrevious);

    var calendartb = document.createElement('table');
    calendartb.className = 'tbCalendar';
    var rowCount = calendartb.rows.length;
    var rheader = calendartb.insertRow(rowCount);
    
    /*--------------Genero la fila de los 7 días-------------*/
    for (i = 1; i <= 7; i++) {        
        var ndia = (i == 7) ? 0 : i;
        var cellth = document.createElement('th');
        cellth.innerHTML = getNameDay(ndia);
        rheader.appendChild(cellth);
    }
    /*------------------------------------------------------*/
    
    /*--------------Genero el calendario-------------*/    
    var nDay = 1;
    d = obj.day;
    m = obj.month;
    y = obj.year;

    var nDayPrev = 0;
    var nDayNow = -1;
    var nDayNext = -1;

    var countDaysNow = getMonthDays(obj.month-1,obj.year);
    var countDaysNext = getMonthDays(obj.monthNext - 1, obj.yearNext);
    var countDaysPrevious = getMonthDays(obj.monthPrevious - 1, obj.yearPrevious);
    
    for (i = 0; i < 6; i++) {
        rowCount = calendartb.rows.length;
        var row = calendartb.insertRow(rowCount);

        for (j = 1; j <= 7 ; j++) {
            var date = new Date(m + '/' + nDay + '/' + y);
            var date_save = '';
            var html = '';            
            var nDay_comparate = j + 1;
            var day_class = '';
            var test_date = '';

            if (nDay_comparate == 7) {
                nDay_comparate = 0;
            }
            
            /*----------Días del mes Anterior-------------------*/
            if (nDayNow == -1 && nDayPrev <= countDaysPrevious) {                
                if (nDayPrev == 0) {
                    if (date.getDay() == 1) {
                        nDayPrev = countDaysPrevious - 6;
                    } else {
                        if (date.getDay() == 0) {
                            nDayPrev = countDaysPrevious - 5;
                        } else {
                            nDayPrev = countDaysPrevious - (date.getDay() - 2);
                        }
                    }                    
                }

                if (nDayPrev == countDaysPrevious) {
                    nDayNow = 0;
                }

                nDay = nDayPrev;
                m = obj.monthPrevious;
                y = obj.yearPrevious;
               
                nDayPrev++;
                day_class = 'date-previous';
            }           
            
            /*-------Días del mes actual-------------------*/
            if (nDayNow >= 0 && nDayNext == -1 && nDayNow <= countDaysNow) {
                day_class = 'date-previous';

                if (nDayNow > 0) {
                    nDay = nDayNow;
                    m = obj.month;
                    y = obj.year;
                    day_class = 'date-now';
                }

                if (nDayNow == countDaysNow) {
                    nDayNext = 0;
                }
                nDayNow++;                
            }

            /*-------Días del mes siguiente-------------------*/
            if (nDayNext >= 0 && nDayNext <= countDaysNext) {
                day_class = 'date-now';
                if (nDayNext > 0) {
                    nDay = nDayNext;
                    m = obj.monthNext;
                    y = obj.yearNext;
                    day_class = 'date-next';
                }
                nDayNext++;               
            }

            /*----------------------Armo el calendario-----------------*/           
            html = nDay;
            day_save = '0' + nDay;
            month_save = '0' + m;
            year_save = '0000' + y;

            date_save = day_save.substring(day_save.length - 2, day_save.length) + '/' + month_save.substring(month_save.length - 2, month_save.length) + '/' + year_save.substring(year_save.length - 4, year_save.length);

            if (nDay == d && m==obj.month && y==obj.year) {
                obj.day = nDay;
                day_class =day_class + ' day_sel';
            }            

            var cell = row.insertCell(j-1);
            cell.id = 'td-' +date_save;
            cell.className = day_class;
            cell.innerHTML = html; 
            cell.onclick = function () {                
                obj.date_select(this);
            }

            cell.ondblclick = function () {
                obj.date_select(this);
                calendar_destroy(obj);
            }

        }
    }

    /*------------------------------------------------------*/
    var img_close = document.createElement('img');
    img_close.className = 'calendar-close';
    img_close.src = '/include/img/boton/calendar/calendar-close.png';
    img_close.onclick = function () {
        calendar_destroy(obj);
    }

    calendar.appendChild(calendarHeader);
    calendar.appendChild(calendartb);
    calendar.appendChild(img_close);

    
    obj.calendar = calendar;
    obj.next = false;
    obj.previous= false;
    obj.div_content.appendChild(calendar);
}

function _position(obj) {
    /*Defino las coordenadas donde aparecerá el calendario*/
    obj.div_content.style.top = (obj.Input_Result.offsetHeight + 3) + 'px';
    obj.div_content.style.margin_left = (obj.Input_Result.offsetLeft - obj.Input_Result.parentNode.offsetLeft) + 'px';
}

function getDate(obj) {
    var date = '';

    if (obj.next) {
        obj.month = obj.monthNext;
        obj.year = obj.yearNext;
        obj.getDatePrevious();
        obj.getDatehNext();
        return;
    }
    
    if (obj.previous) {
        obj.month = obj.monthPrevious;
        obj.year = obj.yearPrevious;
        obj.getDatePrevious();
        obj.getDatehNext();
        return;
    }

    var aDate = new Date();
    obj.day= aDate.getDate();
    obj.month = aDate.getMonth() + 1;
    obj.year= aDate.getFullYear();       

    if (validarFecha(obj.Input_Result.value)) {
        date = obj.Input_Result.value.split('/');
        obj.day = redondear(date[0], 0);
        obj.month = redondear(date[1],0);
        obj.year = redondear(date[2],0);
    }

    obj.getDatePrevious();
    obj.getDatehNext();

}

function getDatePrevious(obj) {
    obj.dayPrevious=0;
    obj.monthPrevious = obj.month - 1;
    obj.yearPrevious=obj.year;

    if (obj.monthPrevious == 0) {
        obj.monthPrevious = 12;
        obj.yearPrevious = obj.year - 1;
    }
}

function getDateNext(obj) {
    obj.dayNext=-1;
    obj.monthNext=obj.month + 1; 
    obj.yearNext=obj.year;
    
    if (obj.monthNext == 13) {
        obj.monthNext = 1;
        obj.yearNext=obj.year+1;
    }
}


function getMonthDays(month, year) {
    var monthBisiesto = 28;
        
    monthBisiesto = (year % 4 == 0 || (year % 100 != 0 && year % 400 == 0)) ? 29 : monthBisiesto;

    var countDay = new Array(31, monthBisiesto, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
    
    return countDay[month];
}

function getNameDay(day) {
    var weekDay = new Array("Do","Lu", "Ma", "Mi", "Ju", "Vi", "Sá");
    return weekDay[day];
}

function getNameMonth(month) {
    var monthName = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
    return monthName[month];
}

function date_select(obj, tdObj) {
    $('.day_sel').removeClass('day_sel');
    tdObj.className = tdObj.className + ' day_sel';
    var date = tdObj.id.replace('td-', '');
    
    if (date != '') {
        obj.day = redondear(date.split('/')[0], 0);
        obj.Input_Result.value = date;
        $(obj.Input_Result).focus();
        obj.seleccionado();
    }
}

function calendar_destroy(obj) {
    $(obj.calendar).remove();
    obj.calendar = null;
    obj.month = 0;
    obj.year = 0;
    $(obj.div_content).css('display', 'none');
}

/*Funcion para cargar los calendarios automaticamente*/
function loadDate() {
    var elements = document.getElementsByClassName('date');
    var count = elements.length;
    var aDate = new Array();
    for (i = 0; i < count; i++) {
        aDate[i] = new jDate(elements[i].id);
    }
}

$(function () {
    loadDate();
})
