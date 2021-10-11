<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization,X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Product.php';
// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate product object
$product = new Product($db);

// Get raw posted data
$data = json_decode(file_get_contents("php://input"));

// Set ID to UPDATE
$product->id = $data->id;

$product->name = $data->name;

// Update product
if ($product->update()) {
  echo json_encode(
    array(
      'message' => 'Product Updated',
      'status' => true
    )
  );
} else {
  echo json_encode(
    array(
      'message' => 'Product not updated',
      'status' => false
    )
  );
}
