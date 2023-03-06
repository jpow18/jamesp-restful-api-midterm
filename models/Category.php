<?php

  class Category {
    // DB stuff
    private $conn;
    private $table = 'categories';

    // category Properties
    public $id;
    public $category;

    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }

    // Get categorys
    public function read() {
      // Create query
      $query = 'SELECT * FROM ' . $this->table;

      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Execute query
      $stmt->execute();

      return $stmt;
    }

    // Get Single category
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
        $this->category = $row['category'];
      }
    }

    // Create category
    public function create() {
      // query
      $query = 'INSERT INTO ' . $this->table . ' (category)
        VALUES (:category) RETURNING id';

      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Clean data
      $this->category = htmlspecialchars(strip_tags($this->category));

      // Bind data
      $stmt->bindParam(':category', $this->category);

      // Execute query
      if ($stmt->execute()) {
        // Get ID of the newly created category
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->id = $row['id'];
        return true;
      }

      // Print error if something goes wrong
      printf("Error: %s.\n", $stmt->error);

      return false;
    }

  // Update category
  public function update()
  {
    // query
    $query = 'UPDATE ' . $this->table . ' 
      SET
        category = :category
      WHERE
        id = :id';

    // Prepare statement
    $stmt = $this->conn->prepare($query);

    // Clean data
    $this->category = htmlspecialchars(strip_tags($this->category));

    // Bind data
    $stmt->bindParam(':category', $this->category);
    $stmt->bindParam(':id', $this->id);

    // Execute query
    if ($stmt->execute()) {
      return true;
    }

    // Print error if something goes wrong
    printf("Error: %s.\n", $stmt->error);

    return false;
    }

    // Delete category
    public function delete() {
      // Query
      $query = 'DELETE FROM ' . $this->table . 
      ' WHERE id = :id';

      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Clean id
      $this->id = htmlspecialchars(strip_tags($this->id));

      // Bind data
      $stmt->bindParam(':id', $this->id);

      // Execute query
      if ($stmt->execute()) {
        return true;
      }
      
      // Print error if something goes wrong
      printf("Error: %s.\n", $stmt->error);

      return false;
    }
  }
