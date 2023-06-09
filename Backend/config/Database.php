<?php

class Database {
    private $host;
    private $dbUser;
    private $dbPassword;
    private $database;
    private $pdo;

    public function __construct() {
        $dbAccessFile = './config/dbaccess.php';
        if (file_exists($dbAccessFile)) {
            include $dbAccessFile;
            $this->host = $host;
            $this->dbUser = $dbUser;
            $this->dbPassword = $dbPassword;
            $this->database = $database;
            $this->connect();
        } else {
            die("Database access file not found.");
        }
    }

    private function connect() {
        try {
            $dsn = "mysql:host={$this->host};dbname={$this->database}";
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false
            ];
            $this->pdo = new PDO($dsn, $this->dbUser, $this->dbPassword, $options);
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
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
     *      $query = "SELECT * FROM products WHERE price > :price";
     *      $params = array(':price' => 10.54);
     *      $database->executeQuery($query, $params)
     */
    public function executeQuery(string $query, array $params = []): ?array
    {
        try {
            $stmt = $this->pdo->prepare($query);
            // Bind the named placeholders with their corresponding values
            foreach ($params as $placeholder => $value) {
                $stmt->bindValue($placeholder, $value);
            }
            $stmt->execute($params);
            return $stmt->fetchAll();
        } catch (Exception $e) {
            die("Query execution failed: " . $e->getMessage());
        }
    }

    /**
     * Retrieves the last inserted ID from the database connection.
     *
     * @return int|null The last inserted ID, or null if no ID is available.
     */
    public function getLastInsertedId(): ?int
    {
        return $this->pdo->lastInsertId();
    }

}