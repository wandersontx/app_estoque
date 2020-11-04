<?php

use App\Database\Repository\PedidoRepository;

$pedRepository = new PedidoRepository;

$listaPedidos = $pedRepository->getAll($_COOKIE['idcliente']);

?>

<?php if(isset($listaPedidos)) { ?>

<div class="container" style="margin-top:20px;">
<h5 class="text-info display-4">Meus pedidos</h5>
<?php foreach($listaPedidos as $pedido) { ?>
<div class="card w-75 mt-3">
  <div class="card-body">
    <h5 class="card-title"><strong>Nº:&nbsp;</strong><?= $pedido['codpedido'] ?></h5>
    <p class="card-text"><strong>Data do pedido:&nbsp;</strong><?= $pedido['data'] ?></p>
    <p class="card-text"><strong>Total R$:&nbsp;</strong><?= $pedido['total'] ?></p>
    <a href="index.php?cliente=cancelarpedido&codpedido=" class="btn btn-danger">cancelar</a>
  </div>
</div>
<?php } ?>
<?php } else { ?>
<h6 class="text-info">Vocẽ ainda não possui pedidos realizados</h6>
<?php }?>
</div>