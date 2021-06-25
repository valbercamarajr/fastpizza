function notification_box_open(title, desc, icon, type) {
    //CONFIGURAÇÕES
    var title = title;
    var desc = desc;
    var icon = icon;
    var type = type;
    var e_speed = 1000;

    notification_box_close();
    $("body").prepend("<div class='notification-box'><div class='icon " + type + "'>\n\
                                    <i class='" + icon + "'> </i></div>\n\
                                    <div class='text'><span><h2>" + title + "</h2>\n\
                                    <p>" + desc + "</p></span></div></div>");
    $(".notification-box").fadeIn(e_speed, function () {
        setTimeout(function () {
            $(".notification-box").stop().fadeOut(e_speed, function () {
                $(this).remove();
            });
        }, e_speed * 4);
    }).css("display", "flex");
}

function notification_box_close(element) {
    $(element).stop().fadeOut(1000, function () {
        $(element).remove();
    });
}