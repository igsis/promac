<?php

$con = bancoMysqli();
$idPj = $_SESSION['idUser'];
$pj = recuperaDados("pessoa_juridica","idPj",$idPj);
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


if(isset($_POST['atualizarJuridica']) and $_POST['numero'] and empty($endereço))
{
	$razaoSocial = addslashes($_POST['razaoSocial']);
	$telefone = $_POST['telefone'];
	$celular = $_POST['celular'];
	$email = $_POST['email'];
	$Endereco = $_POST['Endereco'];
	$Bairro = $_POST['Bairro'];
	$cidade = $_POST['cidade'];
	$estado = $_POST['estado'];
	$CEP = $_POST['cep'];
	$Numero = $_POST['numero'];
	$Complemento = $_POST['complemento'];
	$cooperativa = $_POST['cooperativa'];
	$idZona = $_POST['idZona'];
  	$idSubprefeitura = $_POST['idSubprefeitura'];
  	$idDistrito = $_POST['idDistrito'];

	$sql_atualiza_pj = "UPDATE pessoa_juridica SET
	`razaoSocial` = '$razaoSocial',
	`telefone` = '$telefone',
	`celular` = '$celular',
	`email` = '$email',
	`logradouro` = '$Endereco',
	`bairro` = '$Bairro',
	`cidade` = '$cidade',
	`estado` = '$estado',
	`cep` = '$CEP',
	`numero` = '$Numero',
	`complemento` = '$Complemento',
	`cooperativa` = '$cooperativa',
	`idZona` = '$idZona',
	`idSubprefeitura` = '$idSubprefeitura',
	`idDistrito` = '$idDistrito'
	WHERE `idPj` = '$idPj'";

	if(mysqli_query($con,$sql_atualiza_pj))
	{
		$mensagem = "<font color='#01DF3A'><strong>Atualizado com sucesso! Utilize o menu para avançar.</strong></font>";
		gravarLog($sql_atualiza_pj);
	}
	else
	{
		$mensagem = "<font color='#FF0000'><strong>Erro ao atualizar! Tente novamente.</strong></font>";
	}
};

if($pj['liberado'] == 3)
{
	echo "<div class='alert alert-warning'>
	<strong>Aviso!</strong> Seus dados já foram aceitos, portanto, não podem ser alterados.</div>";
	include 'resumo_usuario.php';
}
else
{
	$pj = recuperaDados("pessoa_juridica","idPj",$idPj);
?>
	<section id="list_items" class="home-section bg-white">
		<div class="container"><?php include 'includes/menu_interno_pj.php'; ?>
			<div class="form-group">
				<h4>Proponente</h4>
				<h5><?php if(isset($mensagem)){echo $mensagem;};?></h5>
			</div>
			<div class="row">
				<div class="col-md-offset-1 col-md-10">
					<form class="form-horizontal" role="form" action="?perfil=informacoes_iniciais_pj" method="post" id="frmCad">
					<div class="form-group">
						<div class="col-md-offset-2 col-md-8"><strong>Razão Social *:</strong><br/>
							<input type="text" class="form-control" name="razaoSocial" placeholder="Razão Social" required value="<?=$pj['razaoSocial']?>">
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-6"><strong>CNPJ *:</strong><br/>
							<input type="text" readonly class="form-control" id="cnpj" name="cnpj" placeholder="CNPJ" value="<?php echo $pj['cnpj']; ?>" required>
						</div>
						<div class="col-md-6"><strong>Email *:</strong><br/>
							<input type="text" class="form-control" name="email" placeholder="E-mail" maxlength="50" required value="<?=$pj['email'];?>">
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-6"><strong>Telefone :</strong><br/>
							<input type="text" class="form-control" name="telefone" id="telefone" onkeyup="mascara( this, mtel );" maxlength="15" placeholder="Exemplo: (11) 98765-4321" value="<?=$pj['telefone']?>">
						</div>
						<div class="col-md-6"><strong>Celular *:</strong><br/>
							<input required type="text" class="form-control" name="celular" id="telefone" onkeyup="mascara( this, mtel );" maxlength="15" placeholder="Exemplo: (11) 98765-4321" value="<?=$pj['celular']?>">
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-8"><hr/></div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-6"><strong>CEP *:</strong><br/>
							<input type="text" class="form-control" id="CEP" name="cep" 
							placeholder="CEP" required
							value="<?php 
							if(!empty($_POST['cep'])):
								echo $_POST['cep'];
							elseif(!empty($pj['cep'])):
								echo $pj['cep'];
							else:
								echo '';
							endif
							?>"> 
						</div>
						<div class="col-md-6" align="left"><br/>
							<i>Pressione a tecla Tab para carregar</i>
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
								value="<?php echo $pj['logradouro'];?>">	
							<?php endif ?>         
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-6"><strong>Número *:</strong><br/>
							<input type="text" class="form-control" id="numero" name="numero" 
							placeholder="Número" required
							value="<?php 
							if(!empty($_POST['numero'])):				            
								echo $_POST['numero'];
							elseif(!empty($pj['numero'])):
								echo $pj['numero'];
							else:
								echo '';
							endif
							?>">  
						</div>
						<div class=" col-md-6"><strong>Complemento:</strong><br/>
							<input type="text" class="form-control" id="complemento" 
							name="complemento" placeholder="Complemento" 
							value="<?php 
							if(!empty($_POST['complemento'])):				            
								echo $_POST['complemento'];
							elseif(!empty($pj['complemento'])):
								echo $pj['complemento'];
							else:
								echo '';
							endif
							?>"> 
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
								value="<?php echo $pj['bairro'];?>">	
							<?php endif ?>   
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-6"><strong>Cidade:</strong><br/>
							<?php 
							if($habilitaCampo): ?>
							<select class="form-control" name="cidade" id="cidade">
								<?php foreach($cidades as $cidade): 
								$selected = $_POST['cidade'] == $cidade ?
								"selected='selected'" : ""; ?>			           
								<option value="<?=$cidade?>"<?=$selected?>><?=$cidade?></option>
							<?php endforeach ?>  
						</select>  			 
							<?php else: ?>  
								<input type="text" class="form-control" id="cidade" 
								name="cidade" required
								<?=$habilitaCampo ? '' : 'readonly'?> 
								value="<?php 
								if(!empty($endereco['cidade'])):				           
									echo $endereco['cidade'];				                
								elseif(!empty($pj['cidade'])):
									echo $pj['cidade'];	
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
									<option value="<?=$estado?>" <?=$selected?>><?=$estado?></option>
								<?php endforeach ?>  
							</select>  			 
						<?php else: ?>  
							<input type="text" class="form-control" id="estado"  
							name="estado"  
							<?=$habilitaCampo ? '' : 'readonly'?>
							value="<?php 
							if(!empty($uf)):				           
								echo $uf;
							elseif(!empty($pj['estado'])):
								echo $pj['estado'];				               
							elseif(!empty($endereco['estado'])):
								echo $endereco['estado'];				                
							else:
								echo '';
								endif?>"> 
							<?php endif ?>          
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-6"><strong>Zona *:</strong><br/>
							<select class="form-control" name="idZona" required>
								<option value="0"></option>
								<?php echo geraOpcao("zona", $pj['idZona']) ?>
							</select>
						</div>
						<div class="col-md-6"><strong>Prefeitura Regional *: <a href="../pdf/lista_distritos.html" target="_blank"><i class="fa fa-info-circle"></i></a></strong><br/>
							<select class="form-control" name="idSubprefeitura" required>
								<option value="0"></option>
								<?php echo geraOpcao("subprefeitura",$pj['idSubprefeitura']) ?>
							</select>
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-6"><strong>Distrito *: <a href="../pdf/lista_distritos.html" target="_blank"><i class="fa fa-info-circle"></i></a></strong><br/>
							<select class="form-control" name="idDistrito" required>
								<option value="0"></option>
								<?php echo geraOpcao("distrito",$pj['idDistrito']) ?>
							</select>
						</div>
						<div class="col-md-6"><strong>É cooperativa? *:</strong><br/>
							<select class="form-control" name="cooperativa">
							<?php
								$tipos = ['Não', 'Sim'];
								foreach($tipos as $chave => $tipo):
									$selected = $_POST['cooperativa'] == $chave ?
									"selected='selected'" : "";
							?>
								<option value="<?=$chave?>" <?=$selected?>>	<?=$tipo?> </option>
							<?php endforeach ?>
							</select>
						</div>
					</div>

					<!-- Botão para Gravar -->
					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
							<input type="hidden" name="atualizarJuridica" value="<?php echo $idPj ?>">
							<input type="submit" value="GRAVAR" class="btn btn-theme btn-lg btn-block">
						</div>
					</div>
					</form>
				</div>
			</div>
		</div>
	</section>
<?php
}
?>
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