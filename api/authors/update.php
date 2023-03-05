<?php

  include_once "../../config/Database.php";
  include_once "../../models/Author.php";

  // Instantiate DB and connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate Author object
  $author = new Author($db);

  // Get raw posted data
  $data = json_decode(file_get_contents("php://input"));

  // Check if 'author' and 'id' parameters exist in the JSON data
  if (!$data || !isset($data->author) || !isset($data->id)) {
    echo json_encode(
      array('message' => 'Missing Required Parameters')
    );
  } else {
    $author->author = $data->author;
    $author->id = $data->id;
    // Update author
    if ($author->update()) {
      echo 'updated author (' . $author->id . ', ' . $author->author . ')';
    } else {
      echo json_encode(
        array('message' => 'author_id not found')
      );
    }
  }

?>