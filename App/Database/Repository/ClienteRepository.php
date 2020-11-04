<?php

namespace App\Database\Repository;

use App\Database\Connection;

class ClienteRepository 
{
    private  $conn;

    public function __construct()
    {
        $this->conn = Connection::getConnection();
    }
    
    public function save($dados)
    {
        $sql = "insert into cliente (nome, email, senha) values (:nome, :email, :senha)";
        
        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(':nome', $dados['nome']);            
        $stmt->bindValue(':email', $dados['email']);            
        $stmt->bindValue(':senha', $dados['senha']);            

        $stmt->execute();
        
    }

    public function login($dados)
    {
        $sql = "select idcliente, nome from cliente where email = :email and senha = :senha";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':email', $dados['email']);
        $stmt->bindValue(':senha', $dados['senha']);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
        
    }


    public function delete($id)
    {
        if($id) {
            $sql = "delete from cliente where idcliente = :idcliente";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':idcliente', $id);
            $stmt->execute();
        }
    }


    public function getAll()
    {
        $sql = "select idcliente, nome, email, senha from cliente";
        $result = $this->conn->query($sql);
        return $result->fetchAll(\PDO::FETCH_CLASS, Produto::class);       
    }

}