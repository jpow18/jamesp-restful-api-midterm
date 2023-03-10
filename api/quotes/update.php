<?php

include_once "../../config/Database.php";
include_once "../../models/Quote.php";

// Instantiate DB and connect
$database = new Database();
$db = $database->connect();

// Instantiate Quote object
$quote = new Quote($db);

// Get raw posted data
$data = json_decode(file_get_contents("php://input"));

// Check if 'quote', 'id', 'author_id', and 'category_id'
// parameters exist in the JSON data
if (!$data || !isset($data->quote) || !isset($data->id)
  || !isset($data->author_id) || !isset($data->category_id)) {
  echo json_encode(
    array('message' => 'Missing Required Parameters')
  );
} else {
  $quote->quote = $data->quote;
  $quote->author_id = $data->author_id;
  $quote->category_id = $data->category_id;
  $quote->id = $data->id;
  // Create quote
  try {
    if ($quote->update()) {
      echo json_encode(
        array(
          'id' => $quote->id,
          'quote' => $quote->quote,
          'author_id' => $quote->author_id,
          'category_id' => $quote->category_id
        )
      );
    } else {
      echo json_encode(
        array('message' => 'No Quotes Found')
      );
    }
  } catch (PDOException $e) {
    if ($e->getCode() == '23503') {
      // Get the key value that caused the error
      $key_value = substr($e->getMessage(), strpos($e->getMessage(), '(') + 1, strpos($e->getMessage(), ')') - strpos($e->getMessage(), '(') - 1);

      // check if author_id or category_id is not found
      if ($key_value === 'author_id') {
        echo json_encode(
          array('message' => 'author_id Not Found')
        );
      } else {
        echo json_encode(
          array('message' => 'category_id Not Found')
        );
      }
    } 
  }
}
