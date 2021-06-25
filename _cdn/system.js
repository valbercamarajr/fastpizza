$(function () {

    $("#menu-toggle").click(function (e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });

    if ($(window).outerWidth() < '950') {
        $("#wrapper").removeClass("toggled");
    }

    //-- Notification Box

    //-- How to use
    $(".j_notification_box_plugin_open").click(function (e) {
        e.preventDefault();
        notification_box_open('title', 'Este é um teste para o notification', 'fa fa-check', 'info');
    });

    $("body").on("click", ".notification-box", function (e) {
        e.preventDefault();
        notification_box_close(".notification-box");
    });

    //-- Modal
    var btn_modal_open = $(".modal-open");
    var btn_modal_close = document.getElementsByClassName("modal-close")[0];

    $('.modal-open').click(
            function () {
                var modal_id = $(this).data('modal');
                var modal = document.getElementById(modal_id);
                modal.style.display = "block";
            }
    )

    $('.modal-close').on("click", function () {
        var modal_id = $(this).parent().parent().parent().attr('id');
        var modal = document.getElementById(modal_id);
        modal.style.display = "none";
    })

    //-- Modal End

    //--JQuery Mask

    $('.date').mask('00/00/0000', {placeholder: "__/__/____"});
    $('.time').mask('00:00:00', {placeholder: "__:__:__"});
    $('.date_time').mask('00/00/0000 00:00:00', {placeholder: "__/__/____ __:__:__"});
    $('.cep').mask('00000-000', {placeholder: "_____-___"});
    $('.phone').mask('0000-0000');
    $('.phone_with_ddd').mask('(00) 00000-0000', {placeholder: "(__) ____-____"});
    $('.celular_with_ddd').mask('(00) 00000-0000', {placeholder: "(__) _____-____"});
    $('.cpf').mask('000.000.000-00', {reverse: true});
    $('.cnpj').mask('00.000.000/0000-00', {reverse: true});
    $('.money').mask('000.000.000.000.000,00', {reverse: true});
    $('.money2').mask("#.##0,00", {reverse: true});

    //--Toggle Form
    $('.j_open').click(function (e) {
        e.preventDefault();
        $(this).toggleClass('close');
        $('.' + $(this).attr('rel')).slideToggle();
    });

    $(".form-create").submit(function (e) {
        e.preventDefault();
        var form = $(this);
        var form_url = form.attr("name") + '.jquery.php';
        //var form_data = form.serialize();

        form.ajaxSubmit({
            url: "./php/" + form_url,
            type: "POST",
            //data: form_data,
            dataType: "JSON",
            beforeSend: function (xhr) {
                form.find("button").after("<span class='load'>Aguarde, carregando...</span>");
                $(".error, .success").fadeOut(400, function () {
                    $(this).remove();
                });
            },
            success: function (response, textStatus, jqXHR) {
                if (response.error) {
                    notification_box_open('Ooops!', response.error, 'fa fa-close', 'danger');
                } else {
                    notification_box_open('Ok!', response.success, 'fa fa-check', 'success');
                }

                if (response.result) {
                    $(response.result).prependTo($('.' + response.target));
                }

                if (response.redirect) {
                    setTimeout(function () {
                        window.location.href = response.redirect;
                    }, 3000);
                }
            },
            error: function (jqXHR, textStatus, errorThrow) {
                form.prepend("<span class='error'>Desculpe, erro ao processar: " + errorThrow + "</span>");
            },
            complete: function (jqXHR, textStatus) {
                form.find(".load").fadeOut(function () {
                    $(this).remove();
                });
            }
        });
    });

    $(".form-upload").submit(function (e) {
        e.preventDefault();
        var form = $(this);
        var form_url = form.attr("name") + '.jquery.php';

        form.ajaxSubmit({
            url: "./php/" + form_url,
            dataType: "JSON",
            beforeSubmit: function () {
                $(".success, .load").fadeOut(function () {
                    $(this).remove();
                });
            },
            uploadProgress: function (event, position, total, percent) {
                form.find('.j_progress').fadeIn();
                $('.j_progress .bar').text(percent + "%").width(percent + "%");
                if (form.find(".load").length) {
                    form.find(".load b").text(percent + "%");
                } else {
                    form.find("button").after("<span class='load'><b>" + percent + "%</b> - Aguarde Enviando Arquivo!</span>");
                }
            },
            success: function (response, textStatus, jqXHR) {
                console.log(response.success);
                form.find('.j_progress').fadeOut();
                form.find(".load").fadeOut(function () {
                    $(this).remove();
                });

                //form.trigger("reset");

                if (response.error) {
                    notification_box_open('Ooops!', response.error, 'fa fa-close', 'danger');
                } else {
                    notification_box_open('Ok!', response.success, 'fa fa-check', 'success');
                }

                if (response.result) {
                    $(response.result).prependTo($('.' + response.target));
                }

                if (response.redirect) {
                    setTimeout(function () {
                        window.location.href = response.redirect;
                    }, 3000);
                }
            }
        });
    });

    // Consulta Cep VIACEP

    $.fn.viacep = function (target, callback) {
        var input = this;
        input.on("keyup", function (e) {
            e.preventDefault();
            var cep = input.val();
            var len = cep.length;
            var url = "https://viacep.com.br/ws/" + cep + "/json";

            if (len === 8) {
                var form = input.closest('form');
                $(target).html("<span style='padding-left: 20px;' class='form_load'></span>");
                $.getJSON(url, function (response) {
                    if (!response.erro) {
                        form.find('.viacep_logradouro').val(response.logradouro);
                        form.find('.viacep_bairro').val(response.bairro);
                        form.find('.viacep_cidade').val(response.localidade);
                        form.find('.viacep_uf').val(response.uf);

                        $(".form_load").fadeOut(200, function () {
                            $(this).remove();
                            //$(target).html(viacep);
                        });
                        callback(response);
                    } else {
                        if ($(".form_load").length) {
                            $(".form_load").fadeOut(200, function () {
                                $(this).remove();
                                $(target).html("<span>Erro ao consultar o endereço!</span>");
                            });
                        } else {
                            $(target).html("<span>Erro ao consultar o endereço!</span>");
                        }
                        callback({
                            erro: "Endereço não encontrado!"
                        });
                    }
                });
            }
        });
        return this;
    };

    $(".viacep").viacep(".result", function (data) {
        $.each(data, function (i, e) {
            //console.log(i + ": " + e);
        });
    });

});