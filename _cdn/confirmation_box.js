function confirmation_box_open(element_id, title, desc, icon, type) {
    
    var element_id = element_id;
    var title = title;
    var desc = desc;
    //var icon = icon;
    //var type = type;

    confirmation_box_close(element_id);
    $("body").prepend("<div id='" + element_id + "' class='modal wDeleteModal'><div class='modal-content modal-delete'>\n\
                <div class='modal-header'><span class='modal-close'>&times;</span><h2>" + title + "</h2>\n\
                </div><div class='modal-body'><span class='modal-icon'><i class='fa fa-trash fa-2x icon-red circle-icon'></i></span><p>" + desc + "</p></div>\n\
                <div class='modal-footer al-right'>\n\
                <button id='sim' class='btn btn-icon btn-sm btn-red radius'><i class='fa fa-check'></i>Sim</button>\n\
                <button id='cancelar' class='btn btn-icon btn-sm btn-yelow radius'><i class='fa fa-exclamation-circle'></i>Cancelar</button>\n\
                </div></div></div>");
    $('.wDeleteModal').fadeIn('slow');
}

function confirmation_box_close(element) {
    $('#'+element).stop().fadeOut(1000, function () {
        $('#'+element).remove();
    });
}