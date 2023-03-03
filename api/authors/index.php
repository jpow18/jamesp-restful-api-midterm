<?php
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  $method = $_SERVER['REQUEST_METHOD'];

  if ($method === 'OPTIONS') {
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
    header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With');
    exit();
  } 

  include_once "../../config/Database.php";
  include_once "../../models/Author.php";

  // Instantiate DB and connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate Author object
  $author = new Author($db);

  // Get HTTP method
  $method = $_SERVER['REQUEST_METHOD'];

  echo $method;

?>