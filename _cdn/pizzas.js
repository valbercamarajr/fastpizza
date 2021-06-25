$(function () {
    $('.j_list_pizza').on('click', '.j_delete', function () {
        var id = $(this).attr('rel');
        confirmation_box_open('ModalDelete', 'Excluir arquivo', 'Você deseja realmente excluir essa pizza? Os registros a ela relacionados irão ficar órfãos!', '', '');
        $('.wDeleteModal').on('click', function () {
            if ($(event.target).is("#sim")) {
                $.ajax({
                    url: './php/pizzas.jquery.php',
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

    $('.j_list_ingredients').on('click', '.j_ingridient_pizza', function () {
        var id_ingridient = $(this).attr('rel');
        $.ajax({
            url: './php/pizzas.jquery.php',
            data: {action: 'pizza_ingridient', id: id_ingridient},
            type: 'POST',
            dataType: 'json',
            success: function (data) {
                if (data.error) {
                    alert('Erro ao inlcuir o ingrediente. Favor recarregue a página!');
                } else {
                    if (data.insert){
                        $("div#"+id_ingridient).addClass("name_list_ingridient_item_active");
                        notification_box_open('Ok!','Ingrediente incluído com sucesso!', 'fa fa-check', 'success');
                    } else {
                        $("div#"+id_ingridient).removeClass("name_list_ingridient_item_active");
                        notification_box_open('Ok!', 'Ingrediente removido com sucesso!', 'fa fa-trash', 'danger');
                    }
                    $('form').find('input[name=price]').val(data.result);
                }
            }
        });
    });
});