<?php

  include_once "../../config/Database.php";
  include_once "../../models/Quote.php";

  // Instantiate DB and connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate Author object
  $quote = new Quote($db);

  // Read Author query
  $result = $quote->read();
  // Get row count
  $num = $result->rowCount();

  // check if any authors
  if ($num > 0) {
    // Author array
    $quote_arr = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $quote_item = array(
          'id' => $id,
          'quote' => $quote,
          'author_id' => $author_id,
          'category_id' => $category_id
        );

        // Push to "data"
        array_push($quote_arr, $quote_item);
      }
      // Turn to JSON and output
      echo json_encode($quote_arr);
  } else {
    // No Quotes
    echo json_encode(
      array('message' => 'quote_id Not Found')
    );
  }
?>