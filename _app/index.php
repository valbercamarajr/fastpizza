<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
header('Content-Type: application/json; charset=utf-8');

require('Config.inc.php');

$Read = new Read;

$Read->read("pizzas");
$pizzas = $Read->getResult();

$jSon['results'] = $pizzas;

echo json_encode($jSon);