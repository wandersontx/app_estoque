<?php

namespace App\Database;

use PDO;


class Connection
{

    private function __construct() {}

    public static function getConnection()
    {   
        $conn = new PDO("mysql:host=localhost;dbname=db_estoque", "root", "");

        //defini para que o PDO lance exceções na ocorrência de erros
         $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
         return $conn;
     
    }
}