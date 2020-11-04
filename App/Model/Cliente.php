<?php

namespace App\Model;

use App\Database\Repository\ClienteRepository;

class Cliente
{
    

    private $clienteRepository;

    public function __construct()
    {
        $this->clienteRepository = new ClienteRepository;
    }

   

    public function salvar($dados)
    {
        if (isset($dados)) {
           $this->clienteRepository->save($dados);           
        }
    }


    public function verificarAutenticacao($dados)
    {
        if(isset($dados) && is_array($dados)) {
            $dadosLogin = [
                'email' => $dados['email'],               
                'senha' => $dados['senha'],
            ];
            return $this->clienteRepository->login($dadosLogin);
        }
    }

  

}