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
  if (!$data || !isset($data->category) || !isset($data->id)) {
    echo json_encode(
      array('message' => 'Missing Required Parameters')
    );
  } else {
    $category->category = $data->category;
    $category->id = $data->id;
    // Update category
    if ($category->update()) {
      echo 'updated category (' . $category->id . ', ' . $category->category . ')';
    } else {
      echo json_encode(
        array('message' => 'category_id not found')
      );
    }
  }
