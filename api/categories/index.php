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
    if (isset($_GET['id'])) {
      include_once "./read_single.php";
    } else {
      include_once "./read.php";
    }
  } else if ($method === 'POST') {
      include_once "./create.php";
  } else if ($method === 'PUT') {
      include_once "./update.php";
  } else if ($method === 'DELETE') {
      include_once "./delete.php";
  } else {
      // If $db is null, there was an error connecting to the database
      echo json_encode(
        array('message' => 'Database connection error')
      );
  }
?>