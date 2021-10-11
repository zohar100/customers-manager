<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Customer.php';

// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate customer object
$customer = new Customer($db);

// Get ID
$customer->id = isset($_GET['id']) ? $_GET['id'] : die();

// Get customer
$customer->read_single();

// Create array
$customer_arr = array(
  'id' => $customer->id,
  'type_id' => $customer->type_id,
  'type_name' => $customer->type_name,
  'name' => $customer->name,
  'phone' => $customer->phone,
  'email' => $customer->email,
  'fav_products' => $customer->fav_products,
  'address' => $customer->address,
  'gender' => $customer->gender,
  'image' => $customer->image,
  'created_at' => $customer->created_at
);

// Make JSON
print_r(json_encode($customer_arr));
