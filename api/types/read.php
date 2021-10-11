<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Type.php';

// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate type object
$type = new Type($db);

// Category read query
$result = $type->read();

// Get row count
$num = $result->rowCount();

// Check if any types
if ($num > 0) {
  // Cat array
  $type_arr = array();
  $type_arr['data'] = array();

  while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    extract($row);

    $type_item = array(
      'id' => $id,
      'name' => $name
    );

    // Push to "data"
    array_push($type_arr['data'], $type_item);
  }

  // Turn to JSON & output
  echo json_encode($type_arr);
} else {
  // No Types
  echo json_encode(
    array('message' => 'No Types Found')
  );
}
