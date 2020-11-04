<?php

use App\Model\Item;
use App\Model\Pedido;
use App\Model\Produto;

if(isset($_COOKIE['carrinho'])){
    $carrinho = unserialize($_COOKIE['carrinho']);  



    $itens = array();
    foreach($carrinho as $item) {
        //instancia produtos
        $produto = new Produto;
        $produto->__set('codproduto',$item['codproduto']);
        $produto->__set('nome',$item['nome']);
        $produto->__set('preco',$item['preco']);


        //instancia itens
        $itens [] = new Item($produto, $item['quantidade']);


        //passar para um array



    }

    $idCliente = $_COOKIE['idcliente'];

    $pedido = new Pedido($itens,$idCliente);
    $pedido->cadastrarPedido();

}