
<div class="container">
<h2 class="text-primary text-center display-3">Funcionário</h2>
<form action="index.php">
        <input type="hidden" name="restrito" value="1">
        <input type="hidden" name="rota" value="funcionario">
        <input type="hidden" name="acao" value="salvar"> 
       
       <div class="row form-group">
       <div class="col-sm-12">
       <label>Nome</label>
        <input class="form-control" type="text" name="nome" id="nome" maxlength="100" >
       </div>
    </div>
    <div class="row form-group">
        <div class="col-sm-6">
            <label>Senha</label>
            <input class="form-control" type="password" name="senha" id="senha" maxlength="6" value="">
        </div>   
    </div>    
    <div class="row form-group">
        <div class="col-sm-12">
            <button class="btn btn-info btn-block">cadastrar</button>
        </div>
    </div>
</form>
</div>


<script>
$(document).ready(function(){

    $("form").submit(function(e){
				let erro = 0
				$("input").each(function(){
					let id = $(this).attr("id");				
					if($("#"+id).val() != undefined && id != 'matricula' && $("#"+id).val() == ''){
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