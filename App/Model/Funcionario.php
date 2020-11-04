<?php

namespace App\Model;

use App\Database\Repository\FuncionarioRepository;

class Funcionario
{
    private $nome;
    private $matricula;
    private $senha;

    private $funcRepository;

    public function __construct()
    {
        $this->funcRepository = new FuncionarioRepository;
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
            $matricula = $this->funcRepository->save($dados);
            return $matricula;
        }
    }

    public function find($matricula)
    {
        return $this->funcRepository->find($matricula);
    }  

    public function verificarAutenticacao($dados)
    {
        if(isset($dados) && is_array($dados)) {
            $dadosLogin = [
                'matricula' => $dados['matricula'],               
                'senha'     => md5($dados['senha']),
            ];
            return $this->funcRepository->login($dadosLogin);
        }
    }

  

}