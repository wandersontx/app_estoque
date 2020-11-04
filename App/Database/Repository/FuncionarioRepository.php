<?php

namespace App\Database\Repository;

use App\Database\Connection;

class FuncionarioRepository 
{
    private  $conn;

    public function __construct()
    {
        $this->conn = Connection::getConnection();
    }
    
    public function save($dados)
    {
      
        $matricula = $this->gerarNumMatricula();
        $sql = "insert into funcionario (matricula, nome, senha) values (:matricula ,:nome, :senha)";

        $stmt = $this->conn->prepare($sql);       
        $stmt->bindValue(':matricula', $matricula);
        $stmt->bindValue(':nome', $dados['nome']);            
        $stmt->bindValue(':senha', $dados['senha']);          
        $stmt->execute();
        return $matricula;        
    }

    public function find($matricula)
    {
        if($matricula) {
            $sql = "select matricula, nome, senha from funcionario where matricula = :matricula";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':matricula', $matricula);
            $stmt->execute();
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        }
    }

    public function login($dados)
    {
        $sql = "select matricula, nome, senha from funcionario where matricula = :matricula and senha = :senha";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':matricula', $dados['matricula']);
        $stmt->bindValue(':senha', $dados['senha']);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
        
    }

    private function gerarNumMatricula():int
    {   
        $matricula = '45';
        for($i=0; $i<6; $i++) {
            $matricula .= (string) rand(0,9);
        }

        return $matricula;
    }

}