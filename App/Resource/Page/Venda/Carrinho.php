<?php

if(isset($_GET['codproduto'])) {
    $produto = array( [
        'codproduto' => $_GET['codproduto'],
        'nome'       => $_GET['nome'],
        'quantidade' => $_GET['quantidade'],
        'preco' => $_GET['preco'],
    ]);
    
    if(isset($_COOKIE['carrinho'])) {
        $item = [
            'codproduto' => $_GET['codproduto'],
            'nome'       => $_GET['nome'],
            'quantidade' => $_GET['quantidade'],
            'preco' => $_GET['preco'],
        ];
        $arr = unserialize($_COOKIE['carrinho']);
        array_push($arr,$item);
        $lista = serialize($arr);
        setcookie('carrinho', $lista);
    
    } else {
    
        $lista = serialize($produto);
        setcookie('carrinho', $lista);
    }
}



if(isset($_COOKIE['carrinho'])){
    $carrinho = unserialize($_COOKIE['carrinho']);  
    
}
$total = 0;
//setcookie('carrinho');
?>

<div class="container" style="margin-top: 20px;">
<div class="row">
<a href="index.php?cliente" class="btn btn-success btn-sm">continuar comprando...</a>
</div>
<h5 class="text-info display-4 text-center">meu carrinho</h5>
<?php if(isset($carrinho)){ ?>
<table class="table table-striped">
    <thead >
        <tr>
            <th>Código</th>
            <th>nome</th>
            <th>preço</th>
            <th>quantidade</th>
            <th>sub-total</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        foreach($carrinho as $key => $value){  
            $total += ($value['preco'] *  $value['quantidade']);
            ?>
        <tr>
            <td><?= $value['codproduto'] ?></td>
            <td><?= $value['nome'] ?></td>
            <td><?= $value['preco']?></td>
            <td><?= $value['quantidade'] ?></td>
            <td><?= number_format(($value['preco'] *  $value['quantidade']), 2, ',', ' '); ?></td>
        </tr>
        <?php          
        }
        ?>
        <tr>
           <td></td>
           <td></td>
           <td></td>
           <td></td>
           <td>
            <div class="card-body">
              <strong>  Total :  <?= number_format($total, 2, ',', ' '); ?> </strong>
            </div>
            </td>
        </tr>
       
    </tbody>
    <div class="card">
  
</div>
</table>
    <div class="row">
        <div class="col-sm-6 ">
            <a href="index.php?cliente=cancelarCarrinho" class="btn btn-outline-danger btn-block">cancelar carrinho</a>
        </div>
        <div class="col-sm-6">
            <a href="index.php?cliente=fecharvenda" class="btn btn-primary btn-block">fechar comprar</a>
        </div>
    </div>
    <?php }?>

</div>

