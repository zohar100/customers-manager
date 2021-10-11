<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization,X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Type.php';
// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate type object
$type = new Type($db);

// Get raw posted data
$data = json_decode(file_get_contents("php://input"));

// Set ID to UPDATE
$type->id = $data->id;

$type->name = $data->name;

// Update type
if ($type->update()) {
  echo json_encode(
    array(
      'message' => 'Type Updated',
      'status' => true
    )
  );
} else {
  echo json_encode(
    array(
      'message' => 'Type not updated',
      'status' => false
    )
  );
}
