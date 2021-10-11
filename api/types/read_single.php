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

// Get ID
$type->id = isset($_GET['id']) ? $_GET['id'] : die();

// Get type
$type->read_single();

// Create array
$type_arr = array(
  'id' => $type->id,
  'name' => $type->name
);

// Make JSON
print_r(json_encode($type_arr));
