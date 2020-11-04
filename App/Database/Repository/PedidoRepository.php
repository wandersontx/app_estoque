<?php

namespace App\Database\Repository;

use App\Database\Connection;

class PedidoRepository 
{
    private $conn; 

    public function __construct()
    {
        $this->conn = Connection::getConnection();    
    }
    
    public function save($dados)
    {
        if(isset($dados) && is_array($dados)) {    
            $sql = "insert into pedido (codpedido,  total, data_pedido, id_cliente) ";
            $sql.= "values (:codpedido, :total, :data_pedido, :id_cliente)";
        
            $stmt = $this->conn->prepare($sql);    

            $stmt->bindValue(':codpedido', $dados['codpedido']);
            $stmt->bindValue(':total', $dados['total']);                       
            $stmt->bindValue(':data_pedido', $dados['data_pedido']);                       
            $stmt->bindValue(':id_cliente', $dados['id_cliente']);                       

            $stmt->execute();
            
        }
    }  

    
    public function getAll($id)
    {
      
        $sql = "select codpedido, total, date_format(data_pedido,'%d-%m-%Y %H:%i:%s') as data from pedido where id_cliente = :id_cliente";
    
        $stmt = $this->conn->prepare($sql);           
        $stmt->bindValue(':id_cliente',$id );         
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
            
        
    }  

    public function delete($codPedido)
    {       
        if(is_numeric($codPedido)) {
            $sql = "delete from pedido where codpedido = :codpedido";           
        
            $stmt = $this->conn->prepare($sql);          
            $stmt->bindValue(':codpedido', $codPedido);
            $stmt->execute(); 
        }        
    }

    public function verificarCodigoGerado($codPedido):bool
    {
        $sql = "select count(codpedido) as total from pedido where codpedido = :codpedido";
       
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':codpedido', $codPedido);
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);      
        if($result['total'] > 0) {
            return true;
        }
        return false;
    }
       
    
}