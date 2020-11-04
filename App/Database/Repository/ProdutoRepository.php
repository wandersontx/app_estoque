<?php

namespace App\Database\Repository;

use App\Database\Connection;
use App\Model\Produto;

class ProdutoRepository 
{
    private  $conn;

    public function __construct()
    {
        $this->conn = Connection::getConnection();
       
    }
    
    public function save($dados)
    {
        if (isset($dados['codproduto'])) {
            $sql = "update produto set nome = :nome,";
            $sql.= "preco = :preco, estoque = :estoque, fk_prod_categoria = :idcategoria where codproduto = :codproduto";
        } else {
            $codproduto = $this->gerarcodproduto($dados['idcategoria']);
            $sql = "insert into produto (codproduto, nome, preco, estoque, fk_prod_categoria) ";
            $sql.= "values (:codproduto, :nome, :preco, :estoque, :idcategoria)";
        }

        $stmt = $this->conn->prepare($sql);
        
        if(isset($dados['codproduto'])) {
            $codproduto = $dados['codproduto'];
        }
        
        $stmt->bindValue(':codproduto', $codproduto);
        $stmt->bindValue(':nome', $dados['nome']);            
        $stmt->bindValue(':preco', $dados['preco']);            
        $stmt->bindValue(':estoque', $dados['estoque']);            
        $stmt->bindValue(':idcategoria', $dados['idcategoria']);            

        $stmt->execute();        
    }

    public function find($codproduto)
    {
        if($codproduto) {
            $sql  = "select codproduto, nome, preco, estoque, fk_prod_categoria as idcategoria from produto ";
            $sql .= "where codproduto = :codproduto";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':codproduto', $codproduto);
            $stmt->execute();
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        }
    }

    public function getAll()
    {
        $sql  = "select p.codproduto, p.nome, p.preco, p.estoque, c.nome as nome_categoria, created_at ";
        $sql .= "from produto p inner join categoria c ";
        $sql .= "on p.fk_prod_categoria = c.idcategoria ";
        $sql .= "order by created_at desc ";
        
        $result = $this->conn->query($sql);
        return  $result->fetchAll(\PDO::FETCH_CLASS, Produto::class);       
    }

    public function delete($codproduto)
    {
        if($codproduto) {
            $sql = "delete from produto where codproduto = :codproduto";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':codproduto', $codproduto);
            $stmt->execute();
        }
    }   


    public function ajustarEstoque($dados, $operacao = 'venda')
    {
       
        if($operacao == 'venda') {
            $sql = "update produto set estoque = (estoque - :quantidade) where codproduto = :codproduto";
        } else {
            $sql = "update produto set estoque = (estoque + :quantidade) where codproduto = :codproduto";
        } 

        $stmt = $this->conn->prepare($sql);       
        $stmt->bindValue(':quantidade', $dados['quantidade'] );             
        $stmt->bindValue(':codproduto', $dados['codproduto']); 
        $stmt->execute();            
    }

    public function getEstoqueAtual($codProduto)
    {
        $sql = "select estoque from produto where codproduto = :codproduto";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':codproduto', $codProduto);
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $result['estoque'];
    }


    public function getTotalProdutoPorCategoria($codCategoria):int
    {
        $sql = "select count(fk_prod_categoria) as qtdProduto from produto where fk_prod_categoria = :codcategoria";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':codcategoria', $codCategoria);
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $result['qtdProduto'];
    }

    private function gerarcodproduto($idcategoria):int
    {                  
        $codproduto = $idcategoria.'00';
        for($i=0; $i<4; $i++) {
            $codproduto .= (string) rand(0,9);
        }

        return $codproduto;
    }
  
}