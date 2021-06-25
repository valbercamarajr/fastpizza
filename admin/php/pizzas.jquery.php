<?php
require('../../_app/Config.inc.php');
$getPost = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$post = array_map("strip_tags", $getPost);
$getFile = $_FILES;

$action = $post['action'];
$jSon = array();
unset($post['action']);
usleep(400000);

if ($action):
    $Read = new Read;
    $Create = new Create;
    $Update = new Update;
    $Delete = new Delete;
    $Upload = new Upload;
endif;

switch ($action) {
    case 'update':
            $update_pizza = [
                'name'  => $post['name'],
                'price' => str_replace(',', '.', $post['price'])
            ];

        if ($getFile) {
            $Upload->Image($getFile['image'], $getFile['image']['name'], 'images');
            $update_pizza['image'] = $Upload->getResult();
            unset($getFile);
        }

            $Update->update('pizzas', $update_pizza, "WHERE id = :id", "id={$post['id']}");
            $jSon['success'] = "Cadastro da <b>{$post['name']}</b> foi atualizada com sucesso!";
            $jSon['redirect'] = "painel.php?exe=pizzas/index";
        break;

    case 'get_row':
        $Read->readFull("SELECT * FROM pizzas WHERE id = '{$post['id']}'");
        $pizza = ($Read->getResult() ? $Read->getResult()[0] : null);
        if (!empty($pizza)) {
            $jSon["id"]     = $pizza['id'];
            $jSon["name"]   = $pizza['name'];
            $jSon["price"]   = $pizza['price'];
            $jSon["image"]   = $pizza['image'];
            $jSon["success"] = "A pizza foi localizada!";
        } else {
            $jSon["error"] = "Não foi encontrada nenhuma pizza com esse código! Tente outro!";
        }
        break;

    case 'pizza_ingridient':
        $var = explode('_', $post['id']);
        $pizza = $var[0];
        $ingridient = $var[1];

        $Read->readFull("SELECT * FROM  pizza_ingridients WHERE id_pizza ='{$pizza}' AND id_ingridient = {$ingridient}");

        if ($Read->getResult()){
            $Delete->delete('pizza_ingridients', "WHERE id = :id", "id={$Read->getResult()[0]['id']}");
            $jSon['success'] = "Ingrediente removido com sucesso!";
            $jSon['insert'] = false;
        } else {
            $Read->read('ingridients', "WHERE id = :id", "id={$ingridient}");
            $ingridientRead = $Read->getResult()[0];

            $createPizzaIngridient = [
                "id_pizza" => $pizza,
                "id_ingridient" => $ingridient,
                "price" => $ingridientRead['price']
            ];
            $Create->create("pizza_ingridients", $createPizzaIngridient);
            $jSon['success'] = "Ingrediente incluído com sucesso!";
            $jSon['insert'] = true;
        }

        $Read->readFull("SELECT SUM(price) AS price FROM pizza_ingridients WHERE id_pizza = {$pizza}");
        $pizzaPrice = $Read->getResult()[0];
        $jSon['result'] = number_format($pizzaPrice['price'], 2, ',', '.');

        break;

    case 'delete':
        $Delete->delete('pizzas', "WHERE id = :id", "id={$post['id']}");
        if (!$Delete->getRowCount()) {
            $jSon['error'] = true;
        } else {
            $jSon['success'] = "Pizza excluída com sucesso!";
        }
        break;
}

if (!empty($jSon)) {
    echo json_encode($jSon);
} else {
    $jSon["error"] = true;
    $jSon["errorMsg"] = "501 - Erro ao processar requisição.";
    echo json_encode($jSon);
}