<?php

  class Author {
    // DB stuff
    private $conn;
    private $table = 'authors';

    // Author Properties
    public $id;
    public $author;

    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }

    // Get Authors
    public function read() {
      // Create query
      $query = 'SELECT * FROM ' . $this->table;

      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Execute query
      $stmt->execute();

      return $stmt;
    }

    // Get Single author
    public function read_single() {
      // Create query
      $query = 'SELECT * FROM ' . 
        $this->table . 
          ' WHERE id = ?';

      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Bind ID
      $stmt->bindParam(1, $this->id);

      // Execute query
      $stmt->execute();

      $row = $stmt->fetch(PDO::FETCH_ASSOC);

      if ($row > 0) {
        // Set properties
        $this->id = $row['id'];
        $this->author = $row['author'];
      }
    }

    // Create Author
    public function create() {
      // Check if author field is present
      if (!isset($this->author)) {
        return false;
      }

      // query
      $query = 'INSERT INTO ' . $this->table . ' (author)
        VALUES (:author)';

      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Clean data
      $this->author = htmlspecialchars(strip_tags($this->author));

      // Bind data
      $stmt->bindParam(':author', $this->author);

      // Execute query
      if ($stmt->execute()) {
        // Get ID of the newly created author
        $this->id = $this->conn->lastInsertId();
        return true;
      }

      // Print error if something goes wrong
      printf("Error: %s.\n", $stmt->error);

      return false;
    }
  }
?>