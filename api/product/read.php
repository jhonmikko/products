<?php

//Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Product.php';

$database = new Database();
$db = $database->connect();

$product = new Product($db);

$result = $product->read();
$num = $result->rowCount();

if($num > 0) {
    $products_arr['data'] = array('products' => [], 'product_total' => '', 'item_total' => []);

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $product_item = array(
            'id' => $id,
            'product_name' => $product_name,
            'quantities' => (int)$quantities,
            'price' => (int)$price,
            'category' => $category
        );

        array_push($products_arr['data']['products'], $product_item);
        array_push($products_arr['data']['item_total'], $product_item['quantities']);
    }

    $products_arr['data']['product_total'] = count($products_arr['data']['products']);
    $products_arr['data']['item_total'] = array_sum($products_arr['data']['item_total']);

    echo json_encode($products_arr);

} else {

    echo json_encode(
        array('message' => 'No Product Found')
    );
}