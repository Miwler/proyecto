
function cronometro(){
    var tiempo_avanzado=$('.cronometro').val();
    if(tiempo_avanzado==""){
        var tiempo = {
        hora: 0,
        minuto: 0,
        segundo: 0
    };
    } else{
        var tiempo_cronometro=tiempo_avanzado.split(":");
        var tiempo = {
        hora: parseInt(tiempo_cronometro[0],10),
        minuto: parseInt(tiempo_cronometro[1],10),
        segundo: parseInt(tiempo_cronometro[2],10)
    };
    }
    

    var tiempo_corriendo = null;

        
            //$(this).text('Detener');                        
            tiempo_corriendo = setInterval(function(){
                // Segundos
                tiempo.segundo++;
                if(tiempo.segundo >= 60)
                {
                    tiempo.segundo = 0;
                    tiempo.minuto++;
                }      

                // Minutos
                if(tiempo.minuto >= 60)
                {
                    tiempo.minuto = 0;
                    tiempo.hora++;
                }
                var horaa=tiempo.hora < 10 ? '0' + tiempo.hora : tiempo.hora;
                var minutoa=tiempo.minuto < 10 ? '0' + tiempo.minuto : tiempo.minuto;
                var segundoa=tiempo.segundo < 10 ? '0' + tiempo.segundo : tiempo.segundo;
                var tiempoAvance=horaa+":"+minutoa+":"+segundoa;
                $('.cronometro').val(tiempoAvance);
               /* $("#hour").text(horaa);
                $("#minute").text();
                $("#second").text(segundoa);*/
            }, 1000);
  
}