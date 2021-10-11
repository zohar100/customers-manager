<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization,X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Product.php';
// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate Product object
$product = new Product($db);

// Get raw posted data
$data = json_decode(file_get_contents("php://input"));

$product->name = $data->name;

// Create Product
if ($product->create()) {
  echo json_encode(
    array(
      'message' => 'Product Created',
      'status' => true
    )
  );
} else {
  echo json_encode(
    array(
      'message' => 'Product Not Created',
      'status' => false
    )
  );
}
