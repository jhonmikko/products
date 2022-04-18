<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Product.php';

$database = new Database();
$db = $database->connect();

$product = new Product($db);

$data = json_decode(file_get_contents("php://input"));

$product->id = $data->id;

$product->product_name = $data->product_name;
$product->quantities = $data->quantities;
$product->price = $data->price;
$product->category = $data->category;

if($product->update()){
    echo json_encode(array('message' => 'Product Updated'));
}else{
    echo json_encode(array('message' => 'Product Not Updated'));
}