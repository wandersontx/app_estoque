<?php

namespace App\Database\Repository;

use App\Database\Connection;

class ItemRepository 
{
    private  $conn;

    public function __construct()
    {
        $this->conn = Connection::getConnection();
    }
    
    public function save($dados)
    {
        if(isset($dados) && is_array($dados)) {    
            $sql = "insert into item (fk_item_pedido, fk_item_produto, quantidade) ";
            $sql.= "values (:fk_item_pedido, :fk_item_produto, :quantidade)";
        
            $stmt = $this->conn->prepare($sql);           
           
            $stmt->bindValue(':fk_item_pedido', $dados['fk_item_pedido']);
            $stmt->bindValue(':fk_item_produto', $dados['fk_item_produto']);            
            $stmt->bindValue(':quantidade', $dados['quantidade']);                       

            $stmt->execute();
            
        }
    }
    
    public function buscarItensPorPedido($codPedido)
    {
        if($codPedido) {
            $sql  = "select fk_item_produto, quantidade from item where fk_item_pedido = :codpedido ";
           
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(':codpedido', $codPedido);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
    }

    public function verificarProdutosPedido($codProduto)
    {
        $sql = "select count(fk_item_produto) as total from item where fk_item_produto = :codproduto";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':codproduto', $codProduto);
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $result['total'];
    }
   
}