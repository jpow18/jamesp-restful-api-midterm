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

    // Get single quote
    public function read_single() {
      // Create query
      $query = 'SELECT q.id, q.quote, a.author as author_name,
        c.category as category_name 
          FROM quotes q 
          LEFT JOIN authors a ON q.author_id = a.id 
          LEFT JOIN categories c ON q.category_id = c.id
          WHERE q.id = :id';

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
        $this->quote = $row['quote'];
        $this->author_id = $row['author_name'];
        $this->category_id = $row['category_name'];
      }
    }
  }
?>