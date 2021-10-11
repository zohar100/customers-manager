<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Customer.php';

// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate customer object
$customer = new Customer($db);

// Get raw posted data
$data = json_decode(file_get_contents("php://input"));

// Set ID to update
$customer->id = $data->id;

// Delete post
if ($customer->delete()) {
  echo json_encode(
    array(
      'message' => 'Customer Deleted',
      'status' => true
    )
  );
} else {
  // http_response_code(404);
  echo json_encode(
    array(
      'message' => 'Customer Not Deleted',
      'status' => false
    )
  );
}
