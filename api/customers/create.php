<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Customer.php';

// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate customer object
$customer = new Customer($db);

// Get raw customer data
$data = json_decode(file_get_contents("php://input"));

// echo json_encode(file_get_contents("php://input"));
$favorites = implode(",", $data->fav_products);

$customer->type_id = $data->type;
$customer->name = $data->name;
$customer->phone = $data->phone;
$customer->email = $data->email;
$customer->fav_products = $favorites;
$customer->address = $data->address;
$customer->gender = $data->gender;

// Create customer
if ($customer->create()) {
  echo json_encode(
    array(
      'message' => 'Customer Created',
      'status' => true
    )
  );
} else {
  echo json_encode(
    array(
      'message' => 'Customer Not Created',
      'status' => false
    )
  );
}
