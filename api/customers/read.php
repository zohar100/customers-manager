<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Customer.php';
include_once '../../models/Product.php';

// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate customer object
$customer = new Customer($db);
// Instantiate product object
$product = new Product($db);

//Fetch products with array of id's
function getProducts($arr, $product)
{
  $product_arr = array();
  $res = $product->read_many($arr);

  while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
    extract($row);

    $product_item = array(
      'id' => $id,
      'name' => $name
    );

    array_push($product_arr, $product_item);
  }

  return $product_arr;
};

// Customer query
$result = $customer->read();
// Get row count
$num = $result->rowCount();

// Check if any customers
if ($num > 0) {
  // Customers array
  $customers_arr = array();
  $customers_arr['data'] = array();

  while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    extract($row);

    $customer_item = array(
      'id' => $id,
      'type_id' => $type_id,
      'type_name' => $type_name,
      'name' => $name,
      'phone' => $phone,
      'email' => $email,
      'fav_products' => getProducts(array_map('intval', explode(',', $fav_products)), $product),
      'address' => $address,
      'gender' => $gender,
      'image' => $image,
      'created_at' => $created_at
    );

    // Push to "data"
    array_push($customers_arr['data'], $customer_item);
  }

  // Turn to JSON & output
  echo json_encode($customers_arr);
} else {
  // No Customers
  echo json_encode(
    array(
      'message' => 'No Customers Found',
      'status' => false
    )
  );
}
