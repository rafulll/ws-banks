<?php
namespace Dao;

use PDO; // Ao se trabalhar com namespaces será preciso referenciar explicitamente a chamada do PDO.

class DBConnection {
    
    private static $dbConnection;
    private $conn;
    
    private function __construct(string $host, string $dbName, string $user, string $password, string $port) {
        try {
            $this->conn = new PDO("mysql:host=$host;port=$port;dbname=$dbName;charset=utf8", $user, $password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
    
    public static function getInstance(string $host, string $dbName, string $user, string $password, string $port) {
        if (empty(self::$dbConnection)) {
            self::$dbConnection = new DBConnection($host, $dbName, $user, $password,$port);
        }
        return self::$dbConnection;
    }
    
    public function getConn() {
        return $this->conn;
    }
}
