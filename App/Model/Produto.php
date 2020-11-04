<?php

namespace App\Model;

use App\Database\Repository\ItemRepository;
use App\Database\Repository\ProdutoRepository;

class Produto
{
    
    private $prodRepository;
    private $itemRepository;

    private $codproduto;
    private $nome;
    private $preco;
    private $estoque;
    private $idcategoria;

    public function __construct()
    {
        $this->prodRepository = new ProdutoRepository;   
        $this->itemRepository = new ItemRepository; 
    }
    

    public function __get($atributo)
    {
        return $this->$atributo;
    }

    public function __set($atributo, $valor)
    {
        $this->$atributo = $valor;
    }

    public function salvar($dados)
    {
        if (isset($dados)) {
            $this->prodRepository->save($dados);
            return true;
        }
    }

    public function find($codProduto)
    {
        return $this->prodRepository->find($codProduto);
    }

    public function getAll()
    {
        return $this->prodRepository->getAll();
    }   

    public function remover($codproduto)
    {       
       $produtosPedido = $this->itemRepository->verificarProdutosPedido($codproduto);
       if($produtosPedido < 1) {
           $this->prodRepository->delete($codproduto);
        return true;
       } else {
          return false;
       }
    }

   
    
}