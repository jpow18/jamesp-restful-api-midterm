<?php
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  $method = $_SERVER['REQUEST_METHOD'];

  if ($method === 'OPTIONS') {
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
    header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With');
    exit();
  } 

  // check if $db is not null before instantiating the Author object
  if ($method === 'GET') {
    include_once "./read.php";

  } else {
    // If $db is null, there was an error connecting to the database
    echo json_encode(
      array('message' => 'Database connection error')
    );
  }

?>