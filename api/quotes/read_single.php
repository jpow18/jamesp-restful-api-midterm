<?php

  include_once "../../config/Database.php";
  include_once "../../models/Quote.php";

  // Instantiate DB and connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate Quote object
  $quote = new Quote($db);

  // Get ID
  $quote->id = ($_GET['id']);

  if (!empty($quote->id)) {
    // Get quote
    $quote->read_single();
  
    // Create array
    $quote_arr = array (
      'id' => $quote->id,
      'quote' => $quote->quote,
      'author' => $quote->author_id,
      'category' => $quote->category_id
    );
  
    if (!empty($quote_arr) && $quote_arr['quote'] !== null) {
      // Make JSON
      print_r(json_encode($quote_arr));
    } else {
    // No Quotes
    echo str_replace('"', "'", json_encode(
      array('message' => 'No Quotes Found'))
    );
    }
  } else {
    // No id parameter
    echo json_encode(
    array('message' => 'quote_id Not Found')
    );
  }
?>