<?php
namespace Dao;

use Config\Database;

abstract class Dao {

    protected $pdo; // Conexão com o banco de dados

    public function __construct() {
        $this->pdo = Database::getConn();
    }

    public abstract function insert($obj);
    public abstract function read(int $idObj);
    public abstract function readAll();
    public abstract function update($obj);
    public abstract function delete(int $idObj);
} 