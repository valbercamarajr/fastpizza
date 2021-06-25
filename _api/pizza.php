<?php
require('../_app/Config.inc.php');
$getPost = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$post = array_map("strip_tags", $getPost);

$action = $post['action'];
$jSon = array();
unset($post['action']);

if ($action):
    $Read = new Read;
endif;

switch ($action) {
    case 'get_row':
        $Read->readFull("SELECT * FROM pizzas WHERE id = '{$post['id']}'");
        $pizza = ($Read->getResult() ? $Read->getResult()[0] : null);
        if (!empty($pizza)) {
            $jSon = [
                "id"        => $pizza['id'],
                "name"      => $pizza['name'],
                "image"     => $pizza['image'],
                "price"     => $pizza['price'],
            ];

            $Read->readFull("SELECT i.id, i.name, i.price FROM ingridients i 
                                   LEFT JOIN pizza_ingridients p ON p.id_ingridient = i.id  
                                   WHERE p.id_pizza={$post['id']}");

            $pizza_ingridients = ($Read->getResult() ? $Read->getResult() : null);
            if (!empty($pizza_ingridients)){
                foreach ($pizza_ingridients as $pizza_ingridient){
                    $jSon["ingridients"][] = [
                        "id_ingridient"     => $pizza_ingridient['id'],
                        "name_ingridient"   => $pizza_ingridient['name'],
                        "price_ingridient"  => $pizza_ingridient['price'],
                        "status_ingridient" => "S"
                    ];
                }
            }

            $Read->readFull("SELECT i.id, i.name, i.price FROM ingridients i 
                                    WHERE i.id NOT IN (SELECT id_ingridient FROM pizza_ingridients 
                                    WHERE id_pizza = {$post['id']})");

            $ingridients = ($Read->getResult() ? $Read->getResult() : null);
            if (!empty($ingridients)){
                foreach ($ingridients as $ingridient){
                    $jSon["ingridients"][] = [
                        "id_ingridient"     => $ingridient['id'],
                        "name_ingridient"   => $ingridient['name'],
                        "price_ingridient"  => $ingridient['price'],
                        "status_ingridient" => "N"
                    ];
                }
            }

            //$jSon["success"] = "A pizza foi localizada!";
        } else {
            $jSon["error"] = "Não foi encontrada nenhuma pizza com esse código! Tente outro!";
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