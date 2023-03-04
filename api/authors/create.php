<?php

include_once "../../config/Database.php";
include_once "../../models/Author.php";

// Instantiate DB and connect
$database = new Database();
$db = $database->connect();

if (isset($_POST['author'])) {
  echo json_encode(
    array('message' => 'Missing Required Parameters')
  );
}

// Instantiate Author object
$author = new Author($db);

// Get raw posted data
$data = json_decode(file_get_contents("php://input"));

$author->author = $data->author;

// Create author
if($author->create()) {
  echo 'created author (' . $author->id . ', ' . $author->author . ')';
} else {
  echo json_encode(
    array('message' => 'author_id not found')
  );
}

?>