<?php

namespace App\Model;

use App\Database\Repository\CategoriaRepository;
use App\Database\Repository\ProdutoRepository;

class Categoria
{
    private $catRepository;
    private $prodRepository;

    private $idcategoria;
    private $nome;

    
    public function __construct()
    {
        $this->catRepository  = new CategoriaRepository;
        $this->prodRepository = new ProdutoRepository;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function setNome($nome)
    {
        $this->nome = $nome;
    }

    public function getIdcategoria()
    {
        return $this->idcategoria;
    }

    

    public function save($nome)
    {       
        if($nome) {
            $this->catRepository->save($nome);
        }
    }   

    public function getCategorias()
    {
        return $this->catRepository->getAll();
    }

    public function remove($codCategoria)
    {
        $qtdProdutos = $this->prodRepository->getTotalProdutoPorCategoria($codCategoria);
        if ($qtdProdutos < 1) {
            $this->catRepository->delete($codCategoria);
            return true;
        } else {
            return false;
        }        
    }
}