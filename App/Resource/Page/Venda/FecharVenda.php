<?php

use App\Model\Item;
use App\Model\Pedido;
use App\Model\Produto;

if(isset($_COOKIE['carrinho'])) {
    $carrinho = unserialize($_COOKIE['carrinho']);  

    $itens = array();
    foreach($carrinho as $item) {
        $produto = new Produto;
        $produto->__set('codproduto',$item['codproduto']);
        $produto->__set('nome',$item['nome']);
        $produto->__set('preco',$item['preco']);

        $itens [] = new Item($produto, $item['quantidade']);

    }

    $idCliente = $_COOKIE['idcliente'];

    $pedido = new Pedido($itens,$idCliente);
    $pedido->cadastrarPedido();
}