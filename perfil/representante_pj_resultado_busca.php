<?php
$con = bancoMysqli();
$idPj = $_SESSION['idUser'];
$pj = recuperaDados("pessoa_juridica","idPj",$idPj);

if(isset($_POST['busca'])):
  //validação
  $validacao = validaCPF($_POST['busca']);
  if($validacao == false):
    echo "<meta HTTP-EQUIV='refresh' CONTENT='0;URL=?perfil=erros&p=erro_representante1'>";
  else:	
     
     $busca = $_POST['busca'];
	 $sql_busca = "SELECT * FROM representante_legal WHERE cpf = '$busca' ORDER BY nome";
	 
	 $query_busca = mysqli_query($con,$sql_busca);
	 $num_busca = mysqli_num_rows($query_busca);
  endif;	
endif;

// Se exisitr, lista a resposta. 
if($num_busca > 0): ?>
  <section id="list_items" class="home-section bg-white">
    <div class="container"><?php include 'includes/menu_interno_pj.php'; ?>
	  <div class="form-group">
	    <h4>Representante Legal</h4>
		<h5><?php if(isset($mensagem)){echo $mensagem;}; ?></h5>
	  </div>
	  <div class="row">
	    <div class="col-md-offset-1 col-md-10">
		  <div class="table-responsive list_info">
		    <table class="table table-condensed">
			  <thead>
			    <tr class="list_menu">
				  <td>Nome</td>
				  <td>CPF</td>
				  <td width="15%"></td>
				</tr>
			  </thead>
			  <tbody>
			    <?php
				  while($descricao = mysqli_fetch_array($query_busca))
				  {
				     echo "
					    <tr>
						   <td class='list_description'><b>".$descricao['nome']."</b></td>
						   <td class='list_description'>".$descricao['cpf']."
							</td>
							<td class='list_description'>
							  <form method='POST' action='?perfil=representante_pj_cadastro'>
							     <input type='hidden' name='insereRepresentante' 
							     value='".$descricao['idRepresentanteLegal']."'>
							      <input type ='submit' class='btn btn-theme btn-md btn-block' value='escolher'>
					          </form>
							</td>
						</tr>";
				   	}?>
			  	</tbody>
			</table>
		  </div>
    	  <div class="form-group">
		    <div class="col-md-offset-2 col-md-8">
			  <a href="?perfil=representante_pj"><input type="submit" 
			  	 value="Inserir outro representante" class="btn btn-theme btn-block"></a>
			</div>
		  </div>
		</div>
	  </div>
 </section>

<!--se não existir o cpf, imprime um formulário.-->
<?php else: ?>
  <section id="contact" class="home-section bg-white">
    <div class="container"><?php include 'includes/menu_interno_pj.php'; ?>
	  <div class="form-group">
	    <h4>Representante Legal</h4>
		<h5><?php if(isset($mensagem)){echo $mensagem;};?></h5>
	  </div>
	  <div class="row">
	    <div class="col-md-offset-1 col-md-10">
		  <form class="form-horizontal" role="form" 
		        action="?perfil=representante_pj_cadastro" method="post" id="frmCad">
		    <div class="form-group">
			  <div class="col-md-offset-2 col-md-8"><strong>Nome: *</strong><br/>
			    <input type="text" class="form-control" name="nome" required
			           placeholder="Nome completo">
			  </div>
			</div>

			<div class="form-group">
			  <div class="col-md-offset-2 col-md-6">
			    <strong>RG/RNE/PASSAPORTE: *</strong><br/>
			    <input type="text" class="form-control" name="rg" placeholder="RG" 
			           required>
			  </div>
			  <div class="col-md-6"><strong>CPF: *</strong><br/>
			    <input type="text" readonly class="form-control" name="cpf" 
			           value="<?php echo $busca ?>" placeholder="CPF" required>
			   </div>
			</div>

			<div class="form-group">
			  <div class="col-md-offset-2 col-md-8"><strong>E-mail *:</strong><br/>
			    <input type="text" class="form-control" name="email" 
			           placeholder="E-mail" required>
			  </div>
			</div>

			<div class="form-group">
			  <div class="col-md-offset-2 col-md-6"><strong>Telefone :</strong><br/>
			    <input type="text" class="form-control" name="telefone" 
			           id="telefone" onkeyup="mascara( this, mtel );" 
			           maxlength="15" placeholder="Exemplo: (11) 98765-4321" >
			  </div>
			  <div class="col-md-6"><strong>Celular:</strong><br/>
			    <input type="text" class="form-control" name="celular" 
			           id="telefone" onkeyup="mascara( this, mtel );" 
			           maxlength="15" placeholder="Exemplo: (11) 98765-4321">
			  </div>
			</div>

			<div class="form-group">
			  <div class="col-md-offset-2 col-md-8"><hr/></div>
			</div>

			<div class="form-group">
			  <div class="col-md-offset-2 col-md-6"><strong>CEP *:</strong><br/>
			    <input type="text" class="form-control" id="CEP" name="cep" 
			           placeholder="CEP" required>
			  </div>
			  <div class="col-md-6" align="left">
			    <i>Clique no número do CEP e pressione a tecla Tab para carregar</i>
			  </div>
			</div>

			<div class="form-group">
			  <div class="col-md-offset-2 col-md-8"><strong>Endereço:</strong><br/>
			    <input type="text" readonly class="form-control" id="Endereco" 
			           name="Endereco" placeholder="Endereço">
			  </div>
			</div>

			<div class="form-group">
			  <div class="col-md-offset-2 col-md-6"><strong>Número *:</strong><br/>
			    <input type="text" class="form-control" id="Numero" name="Numero" 	
			           placeholder="Numero" required>
			  </div>
			  <div class=" col-md-6"><strong>Complemento:</strong><br/>
			    <input type="text" class="form-control" id="Complemento" 
			           name="Complemento" placeholder="Complemento">
			  </div>
			</div>

			<div class="form-group">
			  <div class="col-md-offset-2 col-md-8"><strong>Bairro:</strong><br/>
			     <input type="text" readonly class="form-control" id="Bairro" 
			            name="Bairro" placeholder="Bairro">
			  </div>
			</div>

			<div class="form-group">
			  <div class="col-md-offset-2 col-md-6"><strong>Cidade:</strong><br/>
			    <input type="text" readonly class="form-control" id="Cidade" 
			           name="cidade" placeholder="Cidade">
			  </div>
			  <div class="col-md-6"><strong>Estado:</strong><br/>
			    <input type="text" readonly class="form-control" id="Estado" name="estado">
			  </div>
			</div>

			<!-- Botão para Gravar -->
			<div class="form-group">
			  <div class="col-md-offset-2 col-md-8">
			    <input type="hidden" name="cadastraRepresentante">
				<input type="submit" value="GRAVAR" class="btn btn-theme btn-lg btn-block">
			  </div>
			</div>
	  	  </form>
	    </div>
      </div>
    </div>
  </section>
<?php endif?>
<script language="JavaScript" type="text/javascript">
  var cep = document.querySelector('#cep'); 

  $(function(){
	pegaCep();
  });

  function pegaCep()
  {
    cep.addEventListener('focusout', function(){
      form = document.querySelector('#frmCad');    
      form.submit();        
    });    	
  }
</script>