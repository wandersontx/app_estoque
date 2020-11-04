<?php

namespace App\Model;

class Item
{
    private $quantidade;
    private $produto;

    public function __construct(Produto $produto, int $quantidade)
    {
        $this->produto    = $produto;
        $this->quantidade = $quantidade;
    }
    

    public function getProduto()
    {
        return $this->produto;
    }

    public function setProduto(Produto $produto)
    {
        return $this->produto = $produto;
    }

    public function getQuantidade()
    {
        return $this->quantidade;
    }

    public function setQuantidade(int $quantidade)
    {
        return $this->produto = $quantidade;
    }
}