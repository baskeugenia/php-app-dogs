<?php
class Database
{
    #private $dbServer = '127.0.0.1:3306';
    private $dbServer = '172.19.0.2';
    private $dbUser = 'root';
    private $dbPassword = 'root';
    private $dbName = 'dogsdb';
    protected $conn;

    public function __construct()
    {
        try {
            $dsn = "mysql:host={$this->dbServer}; dbname={$this->dbName}; charset=utf8";
            $options = array(PDO::ATTR_PERSISTENT);
            $this->conn = new PDO($dsn, $this->dbUser, $this->dbPassword, $options);
        } catch (PDOException $e) {
            echo "Connection Error: " . $e->getMessage();
        }

    }
}
