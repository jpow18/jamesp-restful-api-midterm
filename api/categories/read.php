<?php

  include_once "../../config/Database.php";
  include_once "../../models/Category.php";

  // Instantiate DB and connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate Category object
  $categories = new Category($db);

  // Read Category query
  $result = $categories->read();
  // Get row count
  $num = $result->rowCount();

  // check if any categoriess
  if ($num > 0) {
    // Category array
    $categories_arr = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $categories_item = array(
          'id' => $id,
          'categories' => $categories
        );

        // Push to "data"
        array_push($categories_arr, $categories_item);
      }
      // Turn to JSON and output
      echo json_encode($categories_arr);
  } else {
    // No Categories
    echo json_encode(
      array('message' => 'categories_id Not Found')
    );
  }
