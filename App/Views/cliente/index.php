<!--Usando o Html Components-->
<?php use App\Views\Layouts\HtmlComponents\Modal;?>

<style type="text/css">
	.desativado {
		color:#cc0033;
	}
</style>

<div class="row">

	<div class="card col-lg-12 content-div">
		<div class="card-body">
	        <h5 class="card-title"><i class="fas fa-user-tie" style="color:#ad54da"></i> Clientes</h5>
	    </div>

		<table id="example" class="table tabela-ajustada table-striped" style="width:100%">
	        <thead>
	            <tr>
	                <th>Nome</th>
	                <th>Email</th>
	                <th>Designação</th>
	                <th>Segmento</th>
	                <th>Status</th>
	                <th style="text-align:right;padding-right:0">
	                	<?php $rota = BASEURL.'/cliente/modalFormulario';?>
	                	<button onclick="modalFormularioClientes('<?php echo $rota;?>', null);" 
	                		class="btn btn-sm btn-success">
	                	    <i class="fas fa-plus"></i>
	                        Novo
	                    </button>
	                </th>
	            </tr>
	        </thead>
	        <tbody>
	        	<?php foreach ($clientes as $cliente):?>
		            <tr>
		            	<td><?php echo $cliente->nome;?></td>
		            	<td><?php echo $cliente->email;?></td>
		            	<td><?php echo $cliente->descricaoClienteTipo;?></td>
		             
		            	<td>
		            		<?php
		            		echo ! is_null($cliente->descricaoSegmento) ? 
		            		$cliente->descricaoSegmento : "<small>Não consta</small>"; 
		            		?>
		            	</td>

		            	<td class="<?php echo (is_null($cliente->deleted_at)) ? 'ativo' : 'desativado';?>">
		            		<?php echo (is_null($cliente->deleted_at)) ? 'Ativo' : 'Desativado';?>
		            	</td>

		                <td style="text-align:right">
		                	<div class="btn-group" role="group">
							    <button id="btnGroupDrop1" type="button" class="btn btn-sm btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							      <i class="fas fa-cogs"></i>
							    </button>
							    <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">

							    	<button class="dropdown-item" href="#" 
								      onclick="modalFormularioClientes('<?php echo $rota;?>', '<?php echo $cliente->id;?>')">
								      	<i class="fas fa-edit"></i> Editar
								    </button>
                                    
                                    <?php if (is_null($cliente->deleted_at)):?>
									    <button class="dropdown-item" href="#" 
									      onclick="modalAtivarEdesativarCliente('<?php echo $cliente->id;?>', '<?php echo $cliente->nome;?>', 'desativar')">
									      	<i class="fas fa-window-close"></i> Desativar
									    </button>
								    <?php else:?>
								    	<button class="dropdown-item" href="#" 
									      onclick="modalAtivarEdesativarCliente('<?php echo $cliente->id;?>', '<?php echo $cliente->nome;?>', 'ativar')">
									      	<i class="fas fa-square"></i> Ativar
									    </button>
								    <?php endif;?>

							        <a class="dropdown-item"  
							        href="<?php echo BASEURL;?>/clienteEndereco/index/<?php echo in64($cliente->id);?>">
							        	<i class="fas fa-map-marker-alt"></i> Endereços
							        </a>

							    </div>
							  </div>
		                </td>
		            </tr>
	            <?php endforeach;?>
	        <tfoot></tfoot>
	    </table>

    <br>
	
   </div>
</div>

<?php Modal::start([
    'id' => 'modalClientes', 
    'width' => 'modal-lg',
    'title' => 'Cadastrar Clientes'
]);?>

<div id="formulario"></div>

<?php Modal::stop();?>

<?php Modal::start([
    'id' => 'modalDesativarCliente', 
    'width' => 'modal-sm',
    'title' => '<i class="fas fa-user-tie" style="color:#ad54da"></i>'
]);?>

<div id="modalConteudo">
	<p id="nomeCliente"></p>
	
	<center>
		<set-modal-button class="set-modal-button"></set-modal-button>
	    <button class="btn btn-sm btn-default" data-dismiss="modal">
	    	<i class="fas fa-window-close"></i> Não
	    </button>
	</center>
</div>

<?php Modal::stop();?>

<script>
	function modalFormularioClientes(rota, id) {
        var url = "";
      
        if (id) {
            url = rota + "/" + id;
        } else {
            url = rota;
        }
        
        $("#formulario").html("<center><h3>Carregando...</h3></center>");
        $("#modalClientes").modal({backdrop: 'static'});
        $("#formulario").load(url);
    }

    function modalAtivarEdesativarCliente(id, nome, operacao) {
    	if (operacao == 'desativar') {
    		$("#nomeCliente").html('Tem certeza que deseja desativar o cliente ' + nome +'?');
    		$("set-modal-button").html('<button class="btn btn-sm btn-success" id="buttonDesativarCliente" data-id-cliente="" onclick="desativarCliente(this)"><i class="far fa-check-circle"></i> Sim</button>');

    	} else if (operacao == 'ativar') {
    		$("set-modal-button").html('<button class="btn btn-sm btn-success" id="buttonDesativarCliente" data-id-cliente="" onclick="ativarCliente(this)"><i class="far fa-check-circle"></i> Sim</button>');
    		$("#nomeCliente").html('Você deseja ativar o cliente ' + nome +'?');
    	}
    	
        $("#modalDesativarCliente").modal({backdrop: 'static'});
        document.querySelector("#buttonDesativarCliente").dataset.idCliente = id;
    }

    function desativarCliente(elemento) {
        modalValidacao('Validação', 'Desativando Cliente...');
        id = elemento.dataset.idCliente;

        var rota = getDomain()+"/cliente/desativarCliente/"+id;
	    $.get(rota, function(data, status) {
	    	var dados = JSON.parse(data);
	    	if (dados.status == true) {
	    		location.reload();
	    		//$("#modalDesativarCliente .close").click();
	    	}
	    });
    }

    function ativarCliente(elemento) {
        modalValidacao('Validação', 'Ativando Cliente...');
        id = elemento.dataset.idCliente;

        var rota = getDomain()+"/cliente/ativarCliente/"+id;
	    $.get(rota, function(data, status) {
	    	var dados = JSON.parse(data);
	    	if (dados.status == true) {
	    		location.reload();
	    		//$("#modalDesativarCliente .close").click();
	    	}
	    });
    }
</script>