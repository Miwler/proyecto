var objReloj = function (hours_now24,format24H, oContent) {
    var patron = /^(0[0-9]|1\d|2[0-3]):([0-5]\d):([0-5]\d)$/;

    this.oContent = oContent;
    
    if (!patron.test(hours_now24)) {
        this.oContent.innerHTML = '--:--:--';
        return;
    }

    var aHours = hours_now24.split(':');
    this.hours24 = redondear(aHours[0], 2);
    this.hours12 = redondear(aHours[0], 2);
    this.minutes = redondear(aHours[1],2);
    this.seconds = redondear(aHours[2], 2);
    this.meridian = '';
    this.format24H = format24H;

    this.clock_start = function () {
        clock_start(this);
    }

    this.getResult = function () {}
    this.clock_start();
}

var clock_start = function (obj) {
    obj.seconds++;

    /*----Verifico la hora en formato de 12-----------*/
    if (obj.hours12==0) {
        obj.hours12 = 12;
    }

    if (obj.hours12 > 12) {
        obj.hours12 = obj.hours12 - 12;
    }
    /*---------------------*/

    if (obj.seconds == 60) {
        obj.seconds = 0;
        obj.minutes++;

        if (obj.minutes == 60) {
            obj.minutes = 0;
            obj.hours24++;
            obj.hours12++;
            
            if (obj.hours24 == 24) {
                obj.hours24 = 0;
            }
                   
            if (obj.hours12 == 13) {
                obj.hours12 = 1;
            }
           
        }
    }

    obj.meridian = 'a.m.';
    if (obj.hours24 >= 12) {
        obj.meridian = 'p.m.';
    }
    

    var vHours24 = '00' + obj.hours24;
    var vHours12 = '00' + obj.hours12;
    var vMinutes = '00' + obj.minutes;
    var vSeconds = '00' + obj.seconds;

    if (obj.oContent != null) {
        if (obj.format24H) {
            obj.oContent.innerHTML = vHours24.substring(vHours24.length - 2, vHours24.length) + ':' + vMinutes.substring(vMinutes.length - 2, vMinutes.length) + ':' + vSeconds.substring(vSeconds.length - 2, vSeconds.length);
        } else {
            obj.oContent.innerHTML = vHours12.substring(vHours12.length - 2, vHours12.length) + ':' + vMinutes.substring(vMinutes.length - 2, vMinutes.length) + ' ' + obj.meridian;
        }
    }
    
    obj.getResult();

    /*-----------Ejecuto el reloj cada segundo----------------*/
    setTimeout(function(){
        obj.clock_start();
    }, 995.5);
    /*-------------------------------------------------------*/
}  