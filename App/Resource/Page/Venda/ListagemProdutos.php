
<?php

use App\Model\Produto;

$obj = new Produto;
$lista = $obj->getAll();

?>

<div class="container" style="margin-top: 20px;">


<?php if(isset($lista)){ ?>
    <?php foreach($lista as $produto){?>
<form action="" >
<div class="row align-center">
    <div class="col-sm-9 mb-3">
        <div class="card w-100">
            <div class="card-body">
                <h5 class="card-title"><?= $produto->__get('nome') ?></h5>
                <h6 class="card-title">cat: <?= $produto->__get('nome_categoria') ?></h6>
                <p class="card-text">R$ <?= $produto->__get('preco') ?></p>
                <input type="hidden" name="cliente" value="carrinho">
                <input type="hidden" name="preco" value="<?= $produto->__get('preco') ?>">
                <input type="hidden" name="codproduto" value="<?= $produto->__get('codproduto') ?>">
                <input type="hidden" name="nome" value="<?= $produto->__get('nome') ?>">               
                <div class="row">
                <div class="col-sm-4">
                <select name="quantidade" id="" class="form-control">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                    <option value="9">9</option>
                    <option value="10">10</option>
                </select>                    
                </div>
                <div class="col-sm-4">
                    <button class="btn btn-primary btn-block">comprar</button>                    
                </div>
                </div>               
            </div>
        </div>
    </div>       
</div>
</form>
    <?php }?>

<?php } else { ?>
 <h2 class="text-info">Não há produtos para listar.</h2>

<?php  } ?>
</div>