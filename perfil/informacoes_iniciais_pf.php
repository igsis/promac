<?php
require_once('../funcoes/funcoesGerais.php');  

$con = bancoMysqli();
$idPf = $_SESSION['idUser'];
$pf = recuperaDados("pessoa_fisica","idPf",$idPf); 
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

if(isset($_POST['atualizarFisica']) and $_POST['numero'] and empty($endereço)):  

  $nome = addslashes($_POST['nome']);
  $rg = $_POST['rg'];
  $telefone = $_POST['telefone'];
  $celular = $_POST['celular'];
  $email = $_POST['email'];
  $Endereco = $_POST['Endereco'];
  $Bairro = $_POST['Bairro'];
  $Cidade = $_POST['cidade'];
  $Estado = $_POST['estado'];
  $cep = $_POST['cep'];
  $Numero = $_POST['numero'];
  $Complemento = $_POST['complemento'];
  $cooperado = $_POST['cooperado'];

  $sql_atualiza_pf = 
    "UPDATE pessoa_fisica SET
      `nome` = '$nome',
	  `rg` = '$rg',
	  `telefone` = '$telefone',
	  `celular` = '$celular',
	  `email` = '$email',
	  `logradouro` = '$Endereco',
	  `bairro` = '$Bairro',
	  `cidade` = '$Cidade',
	  `estado` = '$Estado',
	  `cep` = '$cep',
	  `numero` = '$Numero',
	  `complemento` = '$Complemento',
	  `cooperado` = '$cooperado'
	WHERE `idPf` = '$idPf'";

	if(mysqli_query($con,$sql_atualiza_pf)):	
	  if($habilitaCampo != true):
	   $mensagem = "<font color='#01DF3A'><strong>Atualizado com sucesso!</strong></font>";
	   gravarLog($sql_atualiza_pf);
	  endif;  
	else:
	  $mensagem = "<font color='#01DF3A'><strong>Erro ao atualizar! Tente novamente.
	              </strong></font> <br/>".$sql_atualiza_pf;	
    endif;	
endif;    

if($pf['liberado'] == 3):
  echo "<div class='alert alert-warning'>
  <strong>Aviso!</strong> Seus dados já foram aceitos, portanto, não podem ser alterados.</div>";

  include 'resumo_usuario.php';
else: ?>  
  <section id="list_items" class="home-section bg-white">
    <div class="container"><?php include 'includes/menu_interno_pf.php'; ?>
	  <div class="form-group">
	    <h4>Proponente</h4>
		<h5><?php if(isset($mensagem)){echo $mensagem;};?></h5>
	  </div>
	  <div class="row">
	    <div class="col-md-offset-1 col-md-10">
		  <form class="form-horizontal" role="form" 
		        action="?perfil=informacoes_iniciais_pf" method="post" id="frmCad">
		    <div class="form-group">
			  <div class="col-md-offset-2 col-md-8"><strong>Nome *:</strong><br/>
			    <input type="text" class="form-control" name="nome" 
			           placeholder="Nome" value="<?=$pf['nome']?>" required>
			  </div>
			</div>

			<div class="form-group">
			  <div class="col-md-offset-2 col-md-6"><strong>CPF *:</strong><br/>
			    <input type="text" readonly class="form-control" id="cpf" 
				       name="cpf" placeholder="CPF" value="<?=$pf['cpf']?>" required>
			   </div>
			   <div class="col-md-6"><strong>RG ou RNE *:</strong><br/>
			     <input type="text" class="form-control" name="rg" 
				        placeholder="Número do Documento" 
				        required
				        value="<?php 
				          if(!empty($_POST['rg'])):				            
				            echo $_POST['rg'];
				          elseif(!empty($pf['rg'])):
				            echo $pf['rg'];
				          else:
				            echo '';
				          endif
				        ?>"> 
			   </div>
			</div>

			<div class="form-group">
			  <div class="col-md-offset-2 col-md-8"><strong>E-mail *:</strong><br/>
			    <input type="email" class="form-control" name="email" 
				       placeholder="E-mail" value="<?=$pf['email']?>" required>
			  </div>
			</div>

			<div class="form-group">
			  <div class="col-md-offset-2 col-md-6"><strong>Telefone :</strong><br/>
			    <input type="text" class="form-control" name="telefone" id="telefone"       onkeyup="mascara( this, mtel );" maxlength="15" 
				       placeholder="Exemplo: (11) 98765-4321" 
				       value="<?php 
				          if(!empty($_POST['telefone'])):				            
				            echo $_POST['telefone'];
				          elseif(!empty($pf['telefone'])):
				            echo $pf['telefone'];
				          else:
				            echo '';
				          endif
				        ?>"> 
			  </div>
			  <div class="col-md-6"><strong>Celular:</strong><br/>
			    <input type="text" class="form-control" name="celular" id="celular"  
				       onkeyup="mascara( this, mtel );" maxlength="15" 
				       placeholder="Exemplo: (11) 98765-4321" 
				       value="<?php 
				          if(!empty($_POST['celular'])):				            
				            echo $_POST['celular'];
				          elseif(!empty($pf['celular'])):
				            echo $pf['celular'];
				          else:
				            echo '';
				          endif
				        ?>"> 
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
				          elseif(!empty($pf['cep'])):
				            echo $pf['cep'];
				          else:
				            echo '';
				          endif
				        ?>"> 
			  </div>
			  <div class="col-md-6" align="left">
			    <i>Clique no número do CEP e pressione a tecla Tab para carregar</i>
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
				         value="<?php echo '';?>">	
				<?php endif ?>         
			  </div>
			</div>

			<div class="form-group">
			  <div class="col-md-offset-2 col-md-6"><strong>Número *:</strong><br/>
			    <input type="text" class="form-control" id="numero" 
			           name="numero" placeholder="Numero"
			           required
			           value="<?php 
				          if(!empty($_POST['numero'])):				            
				            echo $_POST['numero'];
				          elseif(!empty($pf['numero'])):
				            echo $pf['numero'];
				          else:
				            echo '';
				          endif
				        ?>"> 
			  </div>
			  <div class=" col-md-6"><strong>Complemento:</strong><br/>
			    <input type="text" class="form-control" id="complemento" 
			           name="complemento" placeholder="complemento" 
			           value="<?php 
				          if(!empty($_POST['complemento'])):				            
				            echo $_POST['complemento'];
				          elseif(!empty($pf['complemento'])):
				            echo $pf['complemento'];
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
				         value="<?php echo '';?>">	
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
				              elseif(!empty($pf['cidade'])):
				                echo $pf['cidade'];	
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
				              elseif(!empty($pf['estado'])):
				                echo $pf['estado'];				               
				              elseif(!empty($endereco['estado'])):
				              	echo $endereco['estado'];				                
				              else:
				                echo '';
				              endif?>"> 
				   <?php endif ?>          
			   </div>			   
			</div>

			<div class="form-group">
			  <div class="col-md-offset-4 col-md-2">
			    <strong>É cooperado? *</strong>
			  </div>
			  <div class="col-md-2">
			    <select class="form-control" name="cooperado">
                  <?php $tipos = ['Não', 'Sim'];
                    foreach($tipos as $chave => $tipo):
	                      $selected = $_POST['cooperado'] == $chave ?
	                                  "selected='selected'" : ""; ?>

  					  <option value="<?=$chave?>" <?=$selected?>>
  					    <?=$tipo?>
                      </option>                                 
                  <?php endforeach ?>  
                </select>
			  </div>
			</div>					
				
			<!-- Botão para Gravar -->
			<div class="form-group">
			  <div class="col-md-offset-2 col-md-8">			    				
				<input type="hidden" name="atualizarFisica" value="<?php echo $idPf ?>">
				<input type="submit" value="GRAVAR" class="btn btn-theme btn-lg btn-block">
			  </div>
			</div>
		  </form>
		</div>
	  </div>
    </div>
  </section>
<?php endif; ?>  
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
