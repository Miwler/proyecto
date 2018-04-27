
    var cuadros = (function ($) {
        
        var barra = function (arrayLabels,array_principal) {
            var arraydatasets={};
           for(var i=0;i<array_principal.length;i++){
              
               var dataset={type:array_principal[i][0],
                            label:array_principal[i][1],
                            backgroundColor: color(window.chartColors.blue).alpha(0.2).rgbString(),
                            borderColor: window.chartColors.blue,
                            data:array_principal[i][3]
                        }
                arraydatasets=arraydatasets,dataset;
                          
                    
            }
            var barChartData = {
                
                     labels:arrayLabels ,
                     datasets: [ arraydatasets]
                 };
                 return barChartData;
        };



        var success = function (content) {
            // alert(content);
            var item = $('<div class="notification success"><span>' + content + '</span></div>');
            $("#toastem").append($(item));
            $(item).animate({ "right": "1px" }, "fast");
            setInterval(function () {
                $(item).animate({ "right": "-400px" }, function () {
                    $(item).remove();
                });
            }, 4000);
        };


        var error = function (content) {
            //alert(content);
            var item = $('<div class="notification error"><span>' + content + '</span></div>');
            $("#toastem").append($(item));
            $(item).animate({ "right": "1px" }, "fast");
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
            $(item).animate({ "right": "1px" }, "fast");
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
            $(item).animate({ "right": "1px" }, "fast");
            setInterval(function () {
                $(item).animate({ "right": "-400px" }, function () {
                    $(item).remove();
                });
            }, 4000);
        };
        /*
        $(document).on('click', '.notification', function () {
            $(this).fadeOut(400, function () {
                $(this).remove();
            });
        });*/
        
        Chart.plugins.register({
            afterDatasetsDraw: function(chartInstance, easing) {
                // To only draw at the end of animation, check for easing === 1
                var ctx = chartInstance.chart.ctx;

                chartInstance.data.datasets.forEach(function (dataset, i) {
                    var meta = chartInstance.getDatasetMeta(i);
                    if (!meta.hidden) {
                        meta.data.forEach(function(element, index) {
                            // Draw the text in black, with the specified font
                            ctx.fillStyle = 'rgb(0, 0, 0)';

                            var fontSize = 16;
                            var fontStyle = 'normal';
                            var fontFamily = 'Helvetica Neue';
                            ctx.font = Chart.helpers.fontString(fontSize, fontStyle, fontFamily);

                            // Just naively convert to string for now
                            var dataString = dataset.data[index].toString();

                            // Make sure alignment settings are correct
                            ctx.textAlign = 'center';
                            ctx.textBaseline = 'middle';

                            var padding = 5;
                            var position = element.tooltipPosition();
                            ctx.fillText(dataString, position.x, position.y - (fontSize / 2) - padding);
                        });
                    }
                });
            }
        });
        
       

        return {
            barra: barra,
            error: error,
            info: info,
            advertencia: advertencia
        };

    })(jQuery);
  