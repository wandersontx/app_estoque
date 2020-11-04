<?php

namespace App\Model;

use App\Database\Repository\ItemRepository;
use App\Database\Repository\PedidoRepository;
use App\Database\Repository\ProdutoRepository;

class Pedido
{
    private $codpedido;
    private $data_pedido;
    private $itens = array();
    private $total;
    private $id_cliente;

    private $pedRepository;
    private $prodRepository;
    private $itemRepository;


    public function __construct($itens = null, int $id_cliente)
    {
        $this->pedRepository  = new PedidoRepository;
        $this->prodRepository = new ProdutoRepository;
        $this->itemRepository = new ItemRepository;
        $this->itens[] = $itens;       
        $this->id_cliente = $id_cliente;        
    }


    public function __get($atributo)
    {
        return $this->$atributo;
    }

    public function __set($atributo, $valor)
    {
        $this->$atributo = $valor;
    }

    public function cadastrarPedido()
    {

        $this->codpedido = $this->gerarCodPedido();
        $this->data_pedido = date('Y-m-d H:i:s');
        $this->total = $this->calcularTotalPedido($this->itens);
        $dadosPedido = [
            'codpedido'   => $this->codpedido,
            'total'       => $this->total,
            'data_pedido' => $this->data_pedido,
            'id_cliente'  => $this->id_cliente,
        ];
       $this->pedRepository->save($dadosPedido);
       $this->cadastarItens();           
    }

    
    public function cancelarPedido($codPedido)
    {
        $dadosProduto = $this->itemRepository->buscarItensPorPedido($codPedido);
        
        foreach($dadosProduto as $key => $produto) {
           $this->ajustarEstoque($produto, 'cancelamento');
        }
        $this->pedRepository->delete($codPedido);
    }

    private function cadastarItens()
    {
        foreach($this->itens as $key => $value) {
            foreach($value as $iten) {
                $dadosItem = [
                    'fk_item_pedido'   => $this->codpedido,
                    'fk_item_produto' => $iten->getProduto()->__get('codproduto'),
                    'quantidade' => $iten->getQuantidade(),
                ];

                $this->itemRepository->save($dadosItem);
               
                $this->ajustarEstoque($dadosItem);              
            }            
        }
    }

    public function getAll()
    {
        return $this->pedRepository->getAll($this->id_cliente);
    }

    public function ajustarEstoque($item, $operacao = 'venda')
    {   
        $dadosProduto = [
            'codproduto' => $item['fk_item_produto'],
            'quantidade' => $item['quantidade'],
        ];
        $this->prodRepository->ajustarEstoque($dadosProduto, $operacao);
    }

    private function calcularTotalPedido($arrItens)
    {
        $total = 0.0;
        foreach($arrItens as $key => $value) {
            foreach($value as $iten) {
                $total += $iten->getQuantidade() * $iten->getProduto()->__get('preco');

            }
            
        }
        return $total;
    }


    private function gerarCodPedido():int
    {   
        $prefixo = str_replace('-','',date('y-m'));
        $codpedido = (string)$prefixo;
        for($i=0; $i<6; $i++) {
            $codpedido .= (string) rand(0,9);
        }

        $numCadastrado =  $this->pedRepository->verificarCodigoGerado($codpedido);

        if(!$numCadastrado) {
            return $codpedido;
        } 
        $this->gerarCodPedido();        
    }
}