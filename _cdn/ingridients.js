$(function () {
    $('.j_list_ingridient').on('click', '.j_delete', function () {
        var id = $(this).attr('rel');
        confirmation_box_open('ModalDelete', 'Excluir arquivo', 'Você deseja realmente excluir esse ingrediente?', '', '');
        $('.wDeleteModal').on('click', function () {
            if ($(event.target).is("#sim")) {
                $.ajax({
                    url: './php/ingridients.jquery.php',
                    data: {action: 'delete', id: id},
                    type: 'POST',
                    dataType: 'json',
                    success: function (data) {
                        if (data.error) {
                            alert('Erro ao deletar. Favor recarregue a página!');
                        } else {
                            $('#' + id).fadeOut(600, function () {
                                $(this).remove();
                            });
                        }
                    }
                });
                $('.wDeleteModal').remove();
                confirmation_box_close('ModalDelete');
            } else {
                confirmation_box_close('ModalDelete');
            }
        });
    });
});