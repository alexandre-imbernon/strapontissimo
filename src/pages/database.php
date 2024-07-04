<?php
// DataBase.php
class DataBase {
    private $connection;
    private $host = 'localhost';
    private $dbname = 'strapontissimo';
    private $username = 'root';
    private $password = '';

    public function __construct() {
        $this->connect();
    }

    public function connect() {
        try {
            $this->connection = new PDO("mysql:host={$this->host};dbname={$this->dbname}", $this->username, $this->password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->connection->exec("SET NAMES 'utf8mb4'");
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
            exit;
        }
    }

    public function getConnection() {
        return $this->connection;
    }
}
?>