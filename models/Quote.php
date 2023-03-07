<?php
  class Quote {
    // DB stuff
    private $conn;
    private $table = 'quotes';

    // Quote properties
    public $id;
    public $quote;
    public $author_id;
    public $category_id;

    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }

    // Get quotes
    public function read() {
      // Create query
      $query = 'SELECT q.id, q.quote, a.author as author_name,
       c.category as category_name 
        FROM quotes q 
        LEFT JOIN authors a ON q.author_id = a.id 
        LEFT JOIN categories c ON q.category_id = c.id
        ORDER BY q.id ASC';

      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Execute query
      $stmt->execute();

      return $stmt;
    }
  }
?>