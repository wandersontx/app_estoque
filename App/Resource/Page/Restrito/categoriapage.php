<?php

use App\Model\Categoria;
$obj = new Categoria;
$categorias = $obj->getCategorias();

?>
<div class="container">
    
        <h2 class="text-primary text-center display-3">Categorias</h2>
   
    <div class="row">   
        <div class="col-sm-6">
            <form action="index.php" method="get">
                <div class="row form-group">
                    <label class="text-info">Nome</label>
                    <input type="hidden" name="restrito" value="1">
                    <input type="hidden" name="rota" value="categoria">
                    <input type="hidden" name="acao" value="salvar">
                    <input class="form-control" maxlength="100" type="text" name="nome" id="nome">
                </div>
                <div class="row form-group">
                    <button type="submit" class="btn btn-info btn-block">cadastrar</button>
                </div>
            </form>
        </div>
        <div class="col-sm-6">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <td>nome</td>
                        <td>ação</td>
                    </tr>
                </thead>
               
                <tbody>
                <?php if($categorias){
                    foreach($categorias as $categoria) { ?>
                    <tr>
                        <td><?= $categoria->getNome() ?></td>
                        <td>
                        <a href="index.php?restrito=1&rota=categoria&acao=remover&idcategoria=<?= $categoria->getIdcategoria() ?>" class="btn btn-danger">remover </a>
                    </td>
                    </tr>
                    
                    
                <?php } } ?>
                </tbody>
            </table>
        </div>    
    </div>
</div>    

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
					$('#titlemodal').html('Campo obrigatório não preenchido')
					$('#msgerro').html('<p>Favor informar o nome da categoria.</p>')
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