
    var toastem = (function ($) {

        var normal = function (content) {

            var item = $('<div class="notification normal"><span>' + content + '</span></div>');
            $("#toastem").append($(item));
            $(item).animate({ "right": "1px" }, "fast");
            setInterval(function () {
                $(item).animate({ "right": "-400px" }, function () {
                    $(item).remove();
                });
            }, 4000);
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
        $(document).on('click', '.notification', function () {
            $(this).fadeOut(400, function () {
                $(this).remove();
            });
        });

        return {
            normal: normal,
            success: success,
            error: error,
            info: info,
            advertencia: advertencia
        };

    })(jQuery);
