<?php

namespace App\Database\Repository;

use App\Database\Connection;
use App\Model\Categoria;

class CategoriaRepository 
{
    private  $conn;

    public function __construct()
    {
        $this->conn = Connection::getConnection();
    }
    
    public function save($nome)
    {
        if($nome) {      
            $sql = "insert into categoria (nome) values (:nome)";
        }

        $stmt = $this->conn->prepare($sql);       
          
        $stmt->bindValue(':nome', $nome);         
        $stmt->execute();        
    }

    public function find($id)
    {
        if($id) {
            $sql = "select idcategoria, nome from categoria where idcategoria = idcategoria";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':idcategoria', $id);
            $stmt->execute();
            return $stmt->fetch(\PDO::FETCH_CLASS, Produto::class);
        }
    }

    public function delete($id)
    {
        if($id) {
            $sql = "delete from categoria where idcategoria = :idcategoria";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':idcategoria', $id);
            $stmt->execute();
        }
    }

    public function getAll()
    {
        $sql = "select idcategoria, nome from categoria";
        $result = $this->conn->query($sql);
        return $result->fetchAll(\PDO::FETCH_CLASS, Categoria::class);       
    }

}