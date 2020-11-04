<?php

use App\Model\Produto;

$obj = new Produto;
$listaProdutos = $obj->getAll();

?>

<div class="container">
    <h2 class="text-info display-3">Produtos</h2>
    <table class="table table-hover">
        <thead>
            <tr>
                <td>#</td>
                <td>nome</td>
                <td>preco R$</td>
                <td>estoque</td>
                <td>categoria</td>
                <td>Ação</td>
            </tr>
        </thead>
        <tbody>
            <?php
                foreach($listaProdutos as $produto){ ?>
                    
            <tr>
                <td>
                    <?= $produto->__get('codproduto')?>
                </td>
                <td>
                    <?= $produto->__get('nome') ?>
                </td>
                <td>
                    <?= $produto->__get('preco') ?>
                </td>
                <td>
                    <?= $produto->__get('estoque') ?>
                </td>
                <td>
                    <?= $produto->__get('nome_categoria') ?>
                </td>
                <td>
                    <a class="btn btn-info" href="index.php?restrito=1&rota=produto&acao=cadastrar&codproduto=<?=$produto->__get('codproduto')?>">editar</a>
                    <a class="btn btn-outline-danger" href="index.php?restrito=1&rota=produto&acao=remover&codproduto=<?=$produto->__get('codproduto')?>">remover</a>
                </td>
            </tr>

            <?php  } ?>
        </tbody>
    </table>
</div>