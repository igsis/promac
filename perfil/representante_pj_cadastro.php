<?php
$con = bancoMysqli();
$idPj = $_SESSION['idUser'];
$estados = formataDados(listaEstados());
$cidades = formataDados(listaCidades());
$habilitaCampo = false;
$representante1 = recuperaDados("representante_legal","idRepresentanteLegal",$pj['idRepresentanteLegal']);


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


if(isset($_POST['cadastraRepresentante']) || isset($_POST['editaRepresentante'])) 
   
{
	$nome = addslashes($_POST['nome']);
	$rg = $_POST['rg'];
	$cpf = $_POST['cpf'];
	$telefone = $_POST['telefone'];
	$celular = $_POST['celular'];
	$email = $_POST['email'];
	$Endereco = $_POST['Endereco'];
	$Bairro = $_POST['Bairro'];
	$Cidade = $_POST['cidade'];
	$Estado = $_POST['estado'];
	$CEP = $_POST['cep'];
	$Numero = $_POST['Numero'];
	$Complemento = $_POST['Complemento'];
}

// Cadastro um representante que não existe
if(isset($_POST['cadastraRepresentante']))
{		
	if($rg == '' OR $nome == '')
	{
		$mensagem = "<font color='#FF0000'><strong>Por favor, preencha todos os campos obrigatórios!</strong></font>";
	}
	else
	{
		$sql_insere_rep1 = "INSERT INTO representante_legal (nome, rg, cpf, telefone, celular, email, logradouro, bairro, cidade, estado, cep, numero, complemento) VALUES ('$nome', '$rg', '$cpf', '$telefone', '$celular', '$email', '$Endereco', '$Bairro', '$Cidade', '$Estado', '$CEP', '$Numero', '$Complemento') ";

		if(mysqli_query($con,$sql_insere_rep1))
		{
			$mensagem = "<font color='#01DF3A'><strong>Cadastrado com sucesso! Utilize o menu para avançar.</strong></font><br/>";
			$idrep1 = recuperaUltimo("representante_legal");
			$sql_representante1_empresa = "UPDATE pessoa_juridica SET idRepresentanteLegal = '$idrep1' WHERE idPj = '$idPj'";
			if(mysqli_query($con,$sql_representante1_empresa))
			{
				$mensagem .= "<font color='#01DF3A'><strong>Representante inserido com sucesso na empresa!</strong></font>";
				gravarLog($sql_representante1_empresa);
			}
			else
			{
				$mensagem = "<font color='#FF0000'><strong>Erro ao inserir o representante na empresa! Tente novamente.</strong></font>";
			}
		}
		else
		{
			if(!empty($representante1)):
			  $mensagem = "<font color='#FF0000'><strong>Erro ao cadastrar! Tente novamente.</strong></font>";
			endif;  
		}
	}
}

// Insere um Representante que foi pesquisado
if(isset($_POST['insereRepresentante']))
{
	$idrep1 = $_POST['insereRepresentante'];
	$sql_representante1_empresa = "UPDATE pessoa_juridica SET idRepresentanteLegal = '$idrep1' WHERE idPj = '$idPj'";
	if(mysqli_query($con,$sql_representante1_empresa))
	{
		$mensagem = "<font color='#01DF3A'><strong>Inserido com sucesso!</strong></font>";
		gravarLog($sql_representante1_empresa);
	}
	else
	{
		$mensagem = "<font color='#FF0000'><strong>Erro ao inserir representante.</strong></font>";
	}
}

// Edita os dados do representante
if(isset($_POST['editaRepresentante']))
{
	if($rg == '' OR $nome == '')
	{
		$mensagem = "<font color='#FF0000'><strong>Por favor, preencha todos os campos obrigatórios!</strong></font>";
	}
	else
	{
		$idrep1 = $_POST['editaRepresentante'];

		$sql_atualiza_rep1 = "UPDATE `representante_legal` SET
		`nome` = '$nome',
		`rg` = '$rg',
		`cpf` = '$cpf',
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
		WHERE `idRepresentanteLegal` = '$idrep1'";

		if(mysqli_query($con,$sql_atualiza_rep1))
		{
			$mensagem = "<font color='#01DF3A'><strong>Atualizado com sucesso!</strong></font><br/>";
			$sql_representante1_empresa = "UPDATE pessoa_juridica SET idRepresentanteLegal = '$idrep1' WHERE idPj = '$idPj'";
			if(mysqli_query($con,$sql_representante1_empresa))
			{
				$mensagem .= "<font color='#01DF3A'><strong>Representante inserido com sucesso na empresa!</strong></font>";
				gravarLog($sql_representante1_empresa);
			}
			else
			{
				$mensagem = "<font color='#FF0000'><strong>Erro ao inserir o representante na empresa! Tente novamente.</strong></font>";
			}
		}
		else
		{
			if(!empty($representante1)):
			  $mensagem = "<font color='#FF0000'><strong>Erro ao atualizar! Tente novamente.</strong></font>".$sql_atualiza_rep1;
			endif;  
		}
	}
}

$pj = recuperaDados("pessoa_juridica","idPj",$idPj);
$representante1 = recuperaDados("representante_legal","idRepresentanteLegal",$pj['idRepresentanteLegal']);

if($pj['liberado'] != 3)
{
?>
<section id="list_items" class="home-section bg-white">
	<div class="container"><?php include 'includes/menu_interno_pj.php'; ?>
		<div class="form-group">
			<h4>Representante Legal</h4>
			<h5><?php if(isset($mensagem)){echo $mensagem;};?></h5>
		</div>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<form class="form-horizontal" role="form" action="?perfil=representante_pj_cadastro" method="post" id="frmCad">
					<div class="form-group">
						<div class="col-md-offset-2 col-md-8"><strong>Nome: *</strong><br/>
							<input type="text" class="form-control" name="nome" 
							       placeholder="Nome completo" required 
							       value="<?php 
				                   if(!empty($_POST['nome'])):				
				                     echo $_POST['nome'];
				          		   elseif(!empty($representante1['nome'])):
				            	     echo $representante1['nome'];
				                   else:
				                     echo '';
				                   endif ?>"> 
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-6"><strong>RG/RNE/PASSAPORTE: *</strong><br/>
							<input type="text" class="form-control" name="rg" 
							       placeholder="RG/RNE/PASSAPORTE" required 
							       value="<?php 
				                   if(!empty($_POST['rg'])):				
				                     echo $_POST['rg'];
				          		   elseif(!empty($representante1['rg'])):
				            	     echo $representante1['rg'];
				                   else:
				                     echo '';
				                   endif ?>"> 
						</div>
						<div class="col-md-6"><strong>CPF: *</strong><br/>
							<input type="text" class="form-control" name="cpf" 
							       placeholder="CPF" required 
							       value="<?php 
				                   if(!empty($_POST['cpf'])):				
				                     echo $_POST['cpf'];
				          		   elseif(!empty($representante1['cpf'])):
				            	     echo $representante1['cpf'];
				                   else:
				                     echo '';
				                   endif ?>"> 
						</div>
					</div>

					<div class="form-group">
					  <div class="col-md-offset-2 col-md-8"><strong>Email *:</strong><br/>
					    <input type="email" class="form-control" name="email" 
					           placeholder="E-mail" required
					           value="<?php 
				               if(!empty($_POST['email'])):				
				                 echo $_POST['email'];
				          	    elseif(!empty($representante1['email'])):
				            	 echo $representante1['email'];
				                else:
				                  echo '';
				                endif ?>"> 
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-6"><strong>Telefone :</strong><br/>
							<input type="text" class="form-control" name="telefone" 
							       id="telefone" 
							       onkeyup="mascara( this, mtel );" 
							       maxlength="15" placeholder="Exemplo: (11) 98765-4321" value="<?php 
				                   if(!empty($_POST['telefone'])):				
				                     echo $_POST['telefone'];
				          		   elseif(!empty($representante1['telefone'])):
				            	     echo $representante1['telefone'];
				                   else:
				                     echo '';
				                   endif ?>"> 
						</div>
						<div class="col-md-6"><strong>Celular:</strong><br/>
							<input type="text" class="form-control" name="celular" id="telefone" onkeyup="mascara( this, mtel );" maxlength="15" placeholder="Exemplo: (11) 98765-4321" 
							value="<?php 
				                   if(!empty($_POST['celular'])):				
				                     echo $_POST['celular'];
				          		   elseif(!empty($representante1['celular'])):
				            	     echo $representante1['celular'];
				                   else:
				                     echo '';
				                   endif ?>"> 
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-8"><hr/></div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-6"><strong>CEP *:</strong><br/>
							<input type="text" class="form-control" id="CEP" name="cep" placeholder="CEP" require 
							value="<?php 
				          if(!empty($_POST['cep'])):				            
				            echo $_POST['cep'];				          
				          elseif(!empty($representante1['cep'])):
                             echo $representante1['cep'];  
				          else:
				            echo '';
				          endif
				        ?>"> 
						</div>
						<div class="col-md-6" align="left"><i>Clique no número do CEP e pressione a tecla Tab para carregar</i>
						</div>
					</div>

					<div class="form-group">
					  <div class="col-md-offset-2 col-md-8"><strong>Endereço:</strong><br/>
					    <?php if(!empty($endereco['logradouro'])): ?>
			              <input type="text" class="form-control" id="Endereco" 
				                 name="Endereco" placeholder="Endereço" 
				                 <?=$habilitaCampo ? '' : 'readonly'?> 
				         	  	 required
				         		 value="<?php echo $endereco['logradouro'];?>">
						<?php elseif(!empty($_POST['Endereco'])): ?>
				  		  <input type="text" class="form-control" id="Endereco" 
				           name="Endereco" placeholder="Endereço" 
				           <?=$habilitaCampo ? '' : 'readonly'?> 
				           required
				           value="<?php echo $_POST['Endereco'];?>">
						<?php else: ?>         	
				  		  <input type="text" class="form-control" id="Endereco" 
				           name="Endereco" placeholder="Endereço" 
				           <?=$habilitaCampo ? '' : 'readonly'?> 
				           required
				           value="<?php echo $representante1['logradouro'];?>">	
					    <?php endif ?>         
					  </div>
					</div>

					<div class="form-group">
					  <div class="col-md-offset-2 col-md-6"><strong>Número *:</strong><br/>
					    <input type="text" class="form-control" id="numero" 
					           name="Numero" placeholder="Numero" required 
					           value="<?php 
				               if(!empty($_POST['numero'])):				            
				                 echo $_POST['numero'];
				               elseif(!empty($representante1['numero'])):
				                 echo $representante1['numero'];
				               else:
				                 echo '';
				               endif ?>"> 
					  </div>
					  <div class=" col-md-6"><strong>Complemento:</strong><br/>
					    <input type="text" class="form-control" id="Complemento" 
						       name="Complemento" placeholder="Complemento" 
						       value="<?php 
				               if(!empty($_POST['Complemento'])):				
				                 echo $_POST['Complemento'];
				               elseif(!empty($representante1['Complemento'])):
				                 echo $representante1['Complemento'];
				               else:
				                 echo '';
				               endif ?>"> 
					  </div>
					</div>

					<div class="form-group">
					  <div class="col-md-offset-2 col-md-8"><strong>Bairro:</strong><br/>
					    <?php if(!empty($endereco['bairro'])): ?>
			      		  <input type="text" class="form-control" id="Bairro" 
				                 name="Bairro" placeholder="Bairro" 
				         		<?=$habilitaCampo ? '' : 'readonly'?> 
				         	    required
				         		value="<?php echo $endereco['bairro'];?>">
						<?php elseif(!empty($_POST['Bairro'])): ?>
				  		  <input type="text" class="form-control" id="Bairro" 
				                 name="Bairro" placeholder="Bairro" 
				                 <?=$habilitaCampo ? '' : 'readonly'?> 
				                 required
				                 value="<?php echo $_POST['Bairro'];?>">
					    <?php else: ?>         	
				          <input type="text" class="form-control" id="Bairro" 
				                 name="Bairro" placeholder="Bairro" 
				                 <?=$habilitaCampo ? '' : 'readonly'?> 
				                 required
				                 value="<?php echo $representante1['bairro'];?>">	
					   <?php endif ?>            	
					  </div>
					</div>

					<div class="form-group">
					  <div class="col-md-offset-2 col-md-6"><strong>Cidade:</strong><br/>
					    <?php 
					      if($habilitaCampo): ?>
			                <select class="form-control" name="cidade" id="cidade">
			                  <?php 
			                  foreach($cidades as $cidade): 
			                    $selected = $_POST['cidade'] == $cidade ?
	                                        "selected='selected'" : ""; ?>			
			       	            <option value="<?=$cidade?>"<?=$selected?>><?=$cidade?>
			       	            </option>
			       	          <?php endforeach ?>  
			                </select>  			 
			            <?php else: ?>  
			              <input type="text" class="form-control" id="cidade" 
				                 name="cidade" required
				                 <?=$habilitaCampo ? '' : 'readonly'?> 
				                 value="<?php 
				                 if(!empty($endereco['cidade'])):				           
				                   echo $endereco['cidade'];				
				                 elseif(!empty($representante1['cidade'])):
				                   echo $representante1['cidade'];	
				                 elseif(!empty($_POST['cidade'])):  
				                   echo $_POST['cidade'];	  			               
				                 else:
				                    echo '';
				                 endif?>"> 
				        <?php endif ?>           
					  </div>
					  <div class="col-md-6"><strong>Estado:</strong><br/>
					    <?php 
			              if($habilitaCampo): ?>
			                <select class="form-control" name="estado" id="estado">
			                  <?php foreach($estados as $estado): 
  					            $selected = $_POST['estado'] == $estado ?
	                                       "selected='selected'" : ""; ?>			
			       	            <option value="<?=$estado?>" <?=$selected?>>
			       	              <?=$estado?>			       	          	
			       	            </option>
			       	          <?php endforeach ?>  
			                </select>  			 
			            <?php else: ?>  
			            <input type="text" class="form-control" id="estado"  
			                  name="estado"  
				              <?=$habilitaCampo ? '' : 'readonly'?>
				              value="<?php 
				              if(!empty($uf)):				           
				                echo $uf;				                
				              elseif(!empty($representante1['estado'])):
				                echo $representante1['estado'];				               
				              elseif(!empty($endereco['estado'])):
				              	echo $endereco['estado'];				                
				              else:
				                echo '';
				              endif?>"> 
				        <?php endif ?>          	 
					  </div>
					</div>

					<!-- Botão para Gravar -->
					<?php if(empty($representante1)): ?>
					  <div class="form-group">
					    <div class="col-md-offset-2 col-md-8">							
					      <input type="hidden" name="cadastraRepresentante">
						  <input type="submit" value="GRAVAR" 
						         class="btn btn-theme btn-lg btn-block">
					    </div>
					  </div>
					<?php endif ?>  
					<?php if(!empty($representante1)): ?>
					  <div class="form-group">
					    <div class="col-md-offset-2 col-md-8">							
					      <input type="hidden" name="editaRepresentante"
					             value="<?php echo $representante1['idRepresentanteLegal'] ?>">
						  <input type="submit" value="ATUALIZAR" 
						         class="btn btn-theme btn-lg btn-block">
					    </div>
					  </div>
					<?php endif ?>  
				</form>

				<div class="form-group">
					<div class="col-md-offset-2 col-md-8"><hr/><br/></div>
				</div>

				<!-- Botão para Trocar o Representante -->
				<div class="form-group">
					<div class="col-md-offset-2 col-md-8">
						<form method='POST' action='?perfil=representante_pj'>
							<input type="hidden" name="apagaRepresentante" value="<?php echo $idPj ?>">
							<input type="submit" value="Trocar o Representante" class="btn btn-theme btn-lg btn-block">
						</form>
					</div>
				</div>
				<?php }
				if($pj['liberado'] == 3){
					include 'includes/menu_interno_pj.php'; 
					echo "<div class='alert alert-warning'>
				  	<strong>Aviso!</strong> Seus dados já foram aceitos, portanto, não podem ser alterados.</div>";

				  	include 'resumo_representante_legal.php';
				}
				?>

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