<?php
require('../../_app/Config.inc.php');
$getPost = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$post = array_map("strip_tags", $getPost);

$action = $post['action'];
$jSon = array();
unset($post['action']);
usleep(400000);

if ($action):
    $Read = new Read;
    $Create = new Create;
    $Update = new Update;
    $Delete = new Delete;
endif;

switch ($action) {
    case 'update':
            $update_pizza = [
                'name'  => $post['name'],
                'price' => str_replace(',', '.', $post['price'])
            ];

            $Update->update('ingridients', $update_pizza, " WHERE id = :id", "id={$post['id']}");
            $jSon['success'] = "Cadastro do <b>{$post['name']}</b> foi atualizado com sucesso!";
            $jSon['redirect'] = "painel.php?exe=ingridients/index";
        break;

    case 'get_row':
        $Read->readFull("SELECT * FROM ingridients WHERE id = '{$post['id']}'");
        $ingridient = ($Read->getResult() ? $Read->getResult()[0] : null);
        if (!empty($ingridient)) {
            $jSon["id"] = $ingridient['id'];
            $jSon["name"]      = $ingridient['name'];
            $jSon["price"]      = number_format($ingridient['price'], 2, ',', '.');
            $jSon["success"] = "O ingrediente foi localizado!";
        } else {
            $jSon["error"] = "Não foi encontrado nenhum ingridiente com esse código! Tente outro!";
        }
        break;

    case 'delete':
        $Delete->delete('ingridients', "WHERE id = :id", "id={$post['id']}");
        if (!$Delete->getRowCount()) {
            $jSon['error'] = true;
        } else {
            $jSon['success'] = "Ingrediente excluído com sucesso!";
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