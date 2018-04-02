<?php

$con = bancoMysqli();
$idPf = $_SESSION['idUser'];
$pf = recuperaDados("incentivador_pessoafisica","idPf",$idPf); 
$estados = formataDados(listaEstados());
$cidades = formataDados(listaCidades());
$habilitaCampo = false;

if(isset($_POST['cep'])):          
  $enderecos = retornaEndereco($_POST['cep']);  
  
  if(isset($enderecos)):
    $endereco  = configuraEndereco($enderecos); 
    $uf = implode("",retornaUf($_POST['cep']));     
  endif;  
endif;  

if(isset($_POST['cep']) and empty($enderecos)):  $habilitaCampo = true; ?>
  <div class="alert alert-warning">
  	<p>O cep: <b><?=$_POST['cep']?></b> não foi localizado. Informe manualmente</p>
  </div>  
<?php endif;

if(isset($_POST['cadastraNovoPf'])):  
  $nome = addslashes($_POST['nome']);
  $rg = $_POST['rg'];
  $telefone = $_POST['telefone'];
  $celular = $_POST['celular'];
  $email = $_POST['email'];
  $Endereco = $_POST['Endereco'];
  $Bairro = $_POST['Bairro'];
  $Cidade = $_POST['Cidade'];
  $Estado = $_POST['Estado'];
  $CEP = $_POST['CEP'];
  $Numero = $_POST['Numero'];
  $Complemento = $_POST['Complemento'];

  $sql_atualiza_pf = "UPDATE incentivador_pessoafisica SET
    `nome` = '$nome',
	`rg` = '$rg',
	`telefone` = '$telefone',
	`celular` = '$celular',
	`email` = '$email',
	`logradouro` = '$Endereco',
	`bairro` = '$Bairro',
	`cidade` = '$Cidade',
	`estado` = '$Estado',
	`cep` = '$CEP',
	`numero` = '$Numero',
	`complemento` = '$Complemento'
  WHERE `idPf` = '$idPf'";

  if(mysqli_query($con,$sql_atualiza_pf)):     
    $mensagem = "<font color='#01DF3A'><strong>Atualizado com sucesso! Utilize o menu para 
                 vançar.</strong></font>";
    gravarLog($sql_atualiza_pf);
  else:
    $mensagem = "<font color='#01DF3A'><strong>Erro ao atualizar! Tente novamente.</strong>
                </font> <br/>".$sql_atualiza_pf;
  endif;
endif; ?>


  <section id="contact" class="home-section bg-white">
    <div class="container"><?php include 'includes/menu_interno_pf.php'; ?>
	  <div class="form-group">
	    <h4>Cadastro de Incentivador<br>
		  <small>Pessoa Física</small>
		</h4>		
		<h4><?php if(isset($mensagem)){echo $mensagem;};?></h4>
	  </div>
	  <div class="row">
	    <div class="col-md-offset-1 col-md-10">
		  <form class="form-horizontal" role="form" 
		        action="?perfil=cadastro_incentivador_pf" method="post" id="frmCad">
		    <div class="form-group">
			  <div class="col-md-offset-2 col-md-8"><strong>Nome *:</strong><br/>
			    <input type="text" class="form-control" name="nome" placeholder="Nome" 
			           value="<?php echo $pf['nome']; ?>" required>
			  </div>
			</div>

			<div class="form-group">
			  <div class="col-md-offset-2 col-md-6"><strong>CPF *:</strong><br/>
			    <input type="text" readonly class="form-control" id="cpf" 
			           name="cpf" placeholder="CPF" 
			           value="<?php echo $pf['cpf']; ?>" required>
			  </div>
			  <div class="col-md-6"><strong>RG ou RNE *:</strong><br/>
			    <input type="text" class="form-control" name="rg" 
			           placeholder="Número do Documento" value="<?php echo $pf['rg']; ?>" required>
			  </div>
			</div>

			<div class="form-group">
			  <div class="col-md-offset-2 col-md-8"><strong>E-mail *:</strong><br/>
			    <input type="email" class="form-control" name="email" 
			           placeholder="E-mail" value="<?php echo $pf['email']; ?>" required>
			  </div>
			</div>

			<div class="form-group">
			  <div class="col-md-offset-2 col-md-6"><strong>Telefone :</strong><br/>
			    <input type="text" class="form-control" name="telefone" id="telefone" 
			           onkeyup="mascara( this, mtel );" maxlength="15" 
			           placeholder="Exemplo: (11) 98765-4321" 
			           value="<?php echo $pf['telefone']; ?>">
			  </div>
			  <div class="col-md-6"><strong>Celular:</strong><br/>
			    <input type="text" class="form-control" name="celular" id="telefone" 
			           onkeyup="mascara( this, mtel );" maxlength="15" 
			           placeholder="Exemplo: (11) 98765-4321" 
			           value="<?php echo $pf['celular']; ?>">
			  </div>
			</div>

			<div class="form-group">
			  <div class="col-md-offset-2 col-md-8"><hr/></div>
			</div>

			<div class="form-group">
			  <div class="col-md-offset-2 col-md-6"><strong>CEP *:</strong><br/>
			    <input type="text" class="form-control" id="CEP" name="CEP" 
			           placeholder="CEP" value="<?php echo $pf['cep']; ?>" required>
			  </div>
			  <div class="col-md-6" align="left">
			  	<i>Clique no número do CEP e pressione a tecla Tab para carregar</i>
			  </div>
			</div>

			<div class="form-group">
			  <div class="col-md-offset-2 col-md-8"><strong>Endereço:</strong><br/>
	            <input type="text" readonly class="form-control" id="Endereco" 
	                   name="Endereco" placeholder="Endereço" 
	                   value="<?php echo $pf['logradouro']; ?>">
			  </div>
			</div>

			<div class="form-group">
			  <div class="col-md-offset-2 col-md-6"><strong>Número *:</strong><br/>
	  		    <input type="text" class="form-control" id="Numero" name="Numero" 
	  		           placeholder="Numero" required value="<?php echo $pf['numero']; ?>">
			  </div>
			  <div class=" col-md-6"><strong>Complemento:</strong><br/>
			    <input type="text" class="form-control" id="Complemento" name="Complemento" placeholder="Complemento" value="<?php echo $pf['complemento']; ?>">
			  </div>
			</div>

			<div class="form-group">
			  <div class="col-md-offset-2 col-md-8"><strong>Bairro:</strong><br/>
			    <input type="text" readonly class="form-control" id="Bairro" 
			           name="Bairro" placeholder="Bairro" 
			           value="<?php echo $pf['bairro']; ?>">
			  </div>
			</div>

			<div class="form-group">
			  <div class="col-md-offset-2 col-md-6"><strong>Cidade:</strong><br/>
			    <input type="text" readonly class="form-control" id="Cidade" 
			           name="Cidade" placeholder="Cidade" 
			           value="<?php echo $pf['cidade']; ?>">
			  </div>
			  <div class="col-md-6"><strong>Estado:</strong><br/>
			    <input type="text" readonly class="form-control" id="Estado" 
			           name="Estado" placeholder="Estado" 
			           value="<?php echo $pf['estado']; ?>">
			  </div>
			</div>

			<!-- Botão para Gravar -->
			<div class="form-group">
			  <div class="col-md-offset-2 col-md-8">
			    <input type="hidden" value="<?php echo $busca ?>">
				<input type="hidden" name="cadastraNovoPf">
				<input type="submit" value="Enviar" class="btn btn-theme btn-lg btn-block">
			  </div>
			</div>
		  </form>
	  	</div>
	  </div>
	</div>
  </section>
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