<?php

  include_once "../../config/Database.php";
  include_once "../../models/Category.php";

  // Instantiate DB and connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate Category object
  $category = new Category($db);

  // Get raw posted data
  $data = json_decode(file_get_contents("php://input"));

// Check if 'category' and 'id' parameters exist in the JSON data
  $response = array();

  if (!$data || !isset($data->id)) {
    $response['message'] = 'Missing Required Parameters';
  } else {
    $category->id = $data->id;
    // Delete category
    if ($category->delete()) {
      $response['id'] = $category->id;
    } else {
      $response['message'] = 'category_id not found';
    }
  }

  echo json_encode($response);
?>
