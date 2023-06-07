<?php

class Database {
    private $host;
    private $dbUser;
    private $dbPassword;
    private $database;
    private $db_obj;

    public function __construct() {
        $dbAccessFile = './config/dbaccess.php';
        if (file_exists($dbAccessFile)) {
            include $dbAccessFile;
            $this->host = $host;
            $this->dbUser = $dbUser;
            $this->dbPassword = $dbPassword;
            $this->database = $database;
            $this->createNewDBObject();
        } else {
            die("Database access file not found.");
        }
    }

    private function createNewDBObject() {
        $this->db_obj = new mysqli($this->host, $this->dbUser, $this->dbPassword, $this->database);
        if ($this->db_obj->connect_error) {
            die("Database connection failed: " . $this->db_obj->connect_error);
        }
    }

    /**
     * Executes a SQL query using prepared statements and returns the result set.
     *
     * @param string $query The SQL query to execute.
     * @param array $params (optional) An array of parameters to bind to the query placeholders.
     * (E.g.: ['ssi', 'Max', 'Mustermann', 43]
     * @return array|null Returns an array containing the fetched result set, or null if no results found.
     * @throws Exception If the query execution fails.
     *
     * Example 1:
     *     $query = "SELECT * FROM products";
     *     $database->executeQuery($query)
     *
     * Example 2:
     *      $query = "SELECT * FROM products WHERE price > ?";
     *      $params = ['d', 10.57];
     *      $database->executeQuery($query, $params)
     *
     * Example 3:
     *      $query = "INSERT INTO users (user, email, password) VALUES (?, ?, ?)";
     *      $params = ['sss', 'test', 'test', '{passwordHash}']
     *      $database->executeQuery($query, $params)
     */
    public function executeQuery(string $query, array $params = []): ?array
    {
        try {
            $stmt = $this->db_obj->prepare($query);
            // Bind the named placeholders with their corresponding values
            foreach ($params as $placeholder => $value) {
                $stmt->bind_param($placeholder, $value);
            }
            $stmt->execute();
            $result = $stmt->get_result();
            $data = $result->fetch_all(MYSQLI_ASSOC);
            $stmt->close();
            return $data;
        } catch (Exception $e) {
            die("Query execution failed: " . $e->getMessage());
        }
    }
}