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

// Check if 'quote' and 'id' parameters exist in the JSON data
if (!$data || !isset($data->quote) || !isset($data->id)) {
  echo json_encode(
    array('message' => 'Missing Required Parameters')
  );
} else {
  $quote->quote = $data->quote;
  $quote->author_id = $data->author_id;
  $quote->category_id = $data->category_id;
  $quote->id = $data->id;
  // Update quote
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
      array('message' => 'quote_id not found')
    );
  }
}
