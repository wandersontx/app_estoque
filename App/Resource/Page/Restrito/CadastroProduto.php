<?php

use App\Model\Categoria;
use App\Model\Produto;

$obj = new Categoria;
$categorias = $obj->getCategorias();

if(isset($_GET['codproduto'])){
    $produto = new Produto;
    $dados = $produto->find($_GET['codproduto']);
}

?>

<div class="container">
<h2 class="text-primary text-center display-3">Produtos</h2>
<form action="index.php">
        <input type="hidden" name="restrito" value="1">
        <input type="hidden" name="rota" value="produto">
        <input type="hidden" name="acao" value="salvar">
    <div class="row form-group">
        <div class="col-sm-6">
            <label>Codigo</label>
            <input class="form-control" type="text" name="codproduto" value="<?= $dados['codproduto'] ?? '' ?>" readonly>
        </div>
        <div class="col-sm-6">
            <label>Categoria</label>
            <select class="form-control" name="idcategoria" id="">               
                <?php foreach($categorias as $categoria){ ?>
                    <option value="<?= $categoria->getIdCategoria() ?>" <?= isset($dados['idcategoria']) && $dados['idcategoria'] == $categoria->getIdCategoria()? 'selected' : '' ?>>
                        <?= $categoria->getNome()?>
                    </option>
                <?php } ?>
            </select>
        </div>
    </div>
    <div class="row form-group">
       <div class="col-sm-12">
       <label>Nome</label>
        <input class="form-control" type="text" name="nome" id="nome" maxlength="100" value="<?= $dados['nome'] ?? '' ?>">
       </div>
    </div>
    <div class="row form-group">
        <div class="col-sm-6">
            <label>Preço</label>
            <input class="form-control" type="text" onkeyup="validarPreco()" name="preco" id="preco" maxlength="8" value="<?= $dados['preco'] ?? '' ?>">
        </div>
        <div class="col-sm-6">
            <label>Estoque</label>
            <input class="form-control" type="text" onkeyup="validaestoque()" name="estoque" id="estoque" maxlength="5" minlength="1" value="<?= $dados['estoque'] ?? '' ?>">
        </div>
    </div>
    <div class="row form-group">
        <div class="col-sm-12">
            <button class="btn btn-info btn-block">Cadastrar</button>
        </div>
    </div>
</form>
</div>

<script>

   function  validaestoque(){
    value = document.getElementById('estoque').value  
    if(isNaN(value))
    value = document.getElementById('estoque').value = ''
   }

   function  validarPreco(){
    value = document.getElementById('preco').value  
    if(isNaN(value) || value == ',')
    value = document.getElementById('preco').value = ''
   }
</script>


<script>
$(document).ready(function(){

    $("form").submit(function(e){
				let erro = 0
				$("input").each(function(){
					let id = $(this).attr("id");				
					if($("#"+id).val() != undefined && id != 'id' && $("#"+id).val() == ''){
						$('#'+id).addClass('is-invalid')
						erro++
					}				
				})
				if(erro > 0){
				var msg = erro > 1 ? erro : ''
					$('#titlemodal').html('Campos obrigatórios não preenchidos')
					$('#msgerro').html('<p>Favor preencher o(s) campo(s) em destaque vermelho.</p>')
					$('#modalerro').modal('show');
				return false
				}
				return;				
				e.preventDefault()
			})
});
</script>

<div class="modal" tabindex="-1" id="modalerro">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-danger" id="titlemodal"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p id="msgerro"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>