(function () {
    $.fn.notification_box_plugin = function (options) {
        //CONFIGURAÇÕES
        var defaults = {
            title: this.attr("data-title") || "Título da notificação",
            desc: this.attr("data-desc") || "Mensagem da notificação",
            icon: this.attr("data-icon") || "fa fa-check",
            type: this.attr("data-type") || "info",
            e_speed: 500
        };

        $.extend(defaults, options);
        //MÉTODOS
        var notification_box_plugin = {
            open: function () {
                notification_box_plugin.close();
                $("body").prepend("<div class='notification-box'><div class='icon " + defaults.type + "'>\n\
                                    <i class='" + defaults.icon + "'> </i></div>\n\
                                    <div class='text'><span><h2>" + defaults.title + "</h2>\n\
                                    <p>" + defaults.desc + "</p></span></div></div>");
                $(".notification-box").fadeIn(defaults.e_speed, function () {
                    setTimeout(function () {
                        $(".notification-box").stop().fadeOut(defaults.e_speed, function () {
                            $(this).remove();
                        });
                    }, defaults.e_speed * 3);
                }).css("display", "flex");
            },
            close: function () {
                $(".notification-box").stop().fadeOut(defaults.e_speed, function () {
                    $(this).remove();
                });
            }
        };

        //EXECUÇÕES
        this.stop().click(function (e) {
            e.preventDefault();
            notification_box_plugin.open();
        });

        return this;
    };
}(jQuery));