<?php
namespace Config;

use Dao\DBConnection;

final class Database {

    public static function getConn() {
       // return DBConnection::getInstance("ec2-54-235-66-1.compute-1.amazonaws.com", "d6ctj2e0r61k88", "tcitzqtugeryls","902b0d4c129b638943a6a74b35eabac8219421177218f4bd2b64b63ee3f6a4d1", "5432")->getConn(); 
        return DBConnection::getInstance("db4free.net", "clientesv9xx", "rafulv9xx","867675ra", "3306")->getConn(); 

    }
}