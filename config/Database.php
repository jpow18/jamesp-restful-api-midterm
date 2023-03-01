<?php

  class Database {
    private $conn;
    private $host;
    private $port;
    private $dbname;
    private $username;
    private $password;

    

    public function connect() {
      // Check if connection already exists
      if ($this->conn) {
        // connection already exists, return it
        return $this->conn;
      } else {

        $dsn = "postgres://{$this->username}:{$this->password}@{$this->host}" . 
        ".oregon-postgres.render.com/{$this->dbname};";

        try {
          $this->conn = new PDO($dsn, $this->username, $this->password);
          $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
          echo 'Connection Error: ' . $e->getMessage();
        }
      }
    }
  }

?>