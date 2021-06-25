$(document).ready(function (){
    var formPizza = $("#formPizza");
    var tbodyPizza = formPizza.find(".tbody");
    var totalOrder = formPizza.find(".totalOrder");
    var totalDescount = formPizza.find(".totalDescount");
    var totalOrderWithDescount = formPizza.find(".totalOrderWithDescount");
    var pizzaTotalPrice = 0;
    var pizzaDescountPrice = 0;
    var pizzaWithDescount = 0;
    var orderIngridients = [];
    var allIngridients = [];
    var catupiryPrice = 0;

    function showModal(content, pizzaPrice, pizzaDescountPrice, pizzaWithDescount){

        var id="#pizzaModal";

        tbodyPizza.html(content);
        totalOrder.html('<p class="total_order_pizza">O valor da pizza é de: R$ ' + pizzaPrice+'</p>');
        totalDescount.html('<p class="total_order_pizza">O valor do desconto é de: R$ ' + pizzaDescountPrice+'</p>');
        totalOrderWithDescount.html('<p class="total_order_pizza">O valor da total é de: R$ ' + pizzaWithDescount+'</p>');

        var heightScreen = $(document).height();
        var widthScreen = $(window).width();

        $('#backgroundModal').css({'width':widthScreen, 'height':heightScreen});
        $('#backgroundModal').fadeIn(1000);
        $('#backgroundModal').fadeTo("fast", 0.4);

        var top = ($(window).height() / 2) - ($(id).height() / 2);
        var left = ($(window).width() / 2) - ($(id).width() / 2);

        $(id).css({'left':left, 'top':top});
        $(id).show();
    }

    function getDescount(catupiryPrice){
        let descount = 0;
        let descountCatupiry = 0;
        let Calabresa, Catupiry, Bacon, Abobrinha = false;

        for (let i = 0; i < orderIngridients.length; i++){
            if(orderIngridients[i].name_ingridient == 'Calabresa'){
                Calabresa = true;
            }
            if(orderIngridients[i].name_ingridient == 'Catupiry'){
                Catupiry = true;
            }
            if(orderIngridients[i].name_ingridient == 'Abobrinha'){
                Abobrinha = true;
            }
            if(orderIngridients[i].name_ingridient == 'Bacon'){
                Bacon = true;
            }
        }

        if (Calabresa && Catupiry){
            console.log("Desconto de 50% no catupiry");
            descountCatupiry = catupiryPrice/2;
        }

        if (!Calabresa && !Catupiry && !Bacon && Abobrinha){
            console.log("Desconto light de 10%");
            descount = 10;
        }

        if (orderIngridients.length > 4){
            console.log("Acrescenta um desconto de 5%");
            descount += 5;
        }

        return [descount, descountCatupiry];
    }

    // Choose Pizza Modal
    $("a[rel=modal]").click(function (ev){
        ev.preventDefault();
        var idPizza = $(this).attr("data-id");
        var html = "";

        $.ajax({
            url: '_api/pizza.php',
            data: 'id=' + idPizza +'&action=get_row',
            type: 'post',
            beforeSend: function(){

            },
            error: function(data_error){
                alert(data_error.responseText);
            },
            success: function(data){
                var json = $.parseJSON(data);
                total = json["price"];
                pizzaTotalPrice = parseFloat(json["price"]);
                html += "<div class='img_choose_pizza'><img src='admin/uploads/"+json["image"]+"' width='150' height='150'/></div>";
                html += "<h3 class='title_choose_pizza'>" + json["name"] + "</h3>";

                orderIngridients = [];
                allIngridients = [];

                for (var i = 0; i< json["ingridients"].length; i++){
                    if (json["ingridients"][i].status_ingridient == 'S'){
                        orderIngridients.push(json["ingridients"][i]);
                    }

                    if (json["ingridients"][i].name_ingridient == 'Catupiry'){
                        catupiryPrice = json["ingridients"][i].price_ingridient;
                    }
                    
                    allIngridients.push(json["ingridients"][i]);

                    let isActive = '';

                    if (json["ingridients"][i].status_ingridient == 'S'){
                        isActive = 'item_pizza_ingridient_active';
                    } else {
                        isActive = '';
                    }
                    
                    html += "<p id='"+ json["ingridients"][i].id_ingridient +"' class='item_pizza_ingridients " + isActive + "'><span class='item_pizza_ingridient_name'>" + json["ingridients"][i].name_ingridient
                            + "</span><span class='item_pizza_ingridient_price'> " + json["ingridients"][i].price_ingridient
                            + "</span><span class='status_ingridient item_pizza_ingridient_status' data-indice='"+ i +"' data-id='"+ json["ingridients"][i].id_ingridient +"' data-price='"+ json["ingridients"][i].price_ingridient +"' data-status='"+ json["ingridients"][i].status_ingridient +"'>" + json["ingridients"][i].status_ingridient + "</span></p>";
                }
                //console.log(orderIngridients);
                let pizzaDescount = [];
                pizzaDescount = getDescount(catupiryPrice);

                console.log(pizzaDescount)

                if (pizzaDescount[0] > 0 || pizzaDescount[1] > 0){
                    if (pizzaDescount[0] > 0){
                        pizzaDescountPrice = (pizzaTotalPrice * pizzaDescount[0])/100;
                        pizzaWithDescount = pizzaTotalPrice - pizzaDescountPrice;
                    }
                    if (pizzaDescount[1] > 0){
                        pizzaDescountPrice += pizzaDescount[1]
                        pizzaWithDescount = pizzaTotalPrice - pizzaDescountPrice;
                    }
                } else {
                    pizzaDescountPrice = 0;
                    pizzaWithDescount = pizzaTotalPrice;
                }

                showModal(html, pizzaTotalPrice, pizzaDescountPrice, pizzaWithDescount);
            }
        });
    });

    formPizza.on('click', '.status_ingridient', function (){
        var id_ingridient = $(this).attr('data-id');
        var indice = $(this).attr('data-indice');

        var status_ingridient = $(this).attr('data-status');
        var price_ingridient = parseFloat($(this).attr('data-price'));

        let total = 0;

        if(status_ingridient == 'S'){
            $(this).attr('data-status', 'N');
            $(this).html('N');
            pizzaTotalPrice = pizzaTotalPrice - price_ingridient;

            let removeItem = '';
            console.log(id_ingridient);
            for (let item = 0;  item < orderIngridients.length; item++){
                console.log(orderIngridients[item].id_ingridient)
                if(orderIngridients[item].id_ingridient == id_ingridient){
                    console.log("Encontro o item para excouir do array, e o seu índice é: " + item);
                    removeItem = item;
                }
            }
            $("p#"+id_ingridient).removeClass("item_pizza_ingridient_active");
            orderIngridients.splice(removeItem,1);

            console.log("New array with removed item is " + orderIngridients);

            console.log(orderIngridients);

            totalOrder.html('<p class="total_order_pizza">O valor da pizza é de: R$ ' + parseFloat(pizzaTotalPrice).toFixed(2)+'</p>');
        } else {
            $(this).attr('data-status', 'S');
            $(this).html('S');
            pizzaTotalPrice = pizzaTotalPrice + price_ingridient;

            orderIngridients.push(allIngridients[indice]);
            $("p#"+id_ingridient).addClass("item_pizza_ingridient_active");
            console.log(orderIngridients);

            totalOrder.html('<p class="total_order_pizza">O valor da pizza é de: R$ ' + parseFloat(pizzaTotalPrice).toFixed(2) + '</p>');
        }

        let pizzaDescount = [];
        pizzaDescount = getDescount(catupiryPrice);

        console.log(pizzaDescount)

        if (pizzaDescount[0] > 0 || pizzaDescount[1] > 0){
            if (pizzaDescount[0] > 0){
                pizzaDescountPrice = (pizzaTotalPrice * pizzaDescount[0])/100;
                pizzaWithDescount = pizzaTotalPrice - pizzaDescountPrice;
            }
            if (pizzaDescount[1] > 0){
                pizzaDescountPrice += pizzaDescount[1]
                pizzaWithDescount = pizzaTotalPrice - pizzaDescountPrice;
            }
        } else {
            pizzaDescountPrice = 0;
            pizzaWithDescount = pizzaTotalPrice;
        }

        totalDescount.html('<p class="total_order_pizza">O valor do desconto é de: R$ ' + parseFloat(pizzaDescountPrice).toFixed(2)+'</p>');
        totalOrderWithDescount.html('<p class="total_order_pizza">O valor da total é de: R$ ' + parseFloat(pizzaWithDescount).toFixed(2)+'</p>');

    });

    $('#backgroundModal').click(function (){
        $(this).fadeOut("slow");
        $('.window').fadeOut("slow");
    });

   $('.close').click(function (ev){
      ev.preventDefault();
      $('#backgroundModal').fadeOut('1000', "linear");
      $('.window').fadeOut('1000', "linear");
   });
   // End Choose Pizza Modal
});