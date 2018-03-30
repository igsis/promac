<?php 
$con = bancoMysqli();

if(isset($_POST[])):  
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
	  `cep` = '$CEP',
	  `numero` = '$Numero',
	  `complemento` = '$Complemento',
	  `cooperado` = '$cooperado'
	WHERE `idPf` = '$idPf'";

	if(mysqli_query($con,$sql_atualiza_pf)):	
	  $mensagem = "<font color='#01DF3A'><strong>Atualizado com sucesso!</strong></font>";
	  gravarLog($sql_atualiza_pf);
	else:	
	  $mensagem = "<font color='#01DF3A'><strong>Erro ao atualizar! Tente novamente.
	              </strong></font> <br/>".$sql_atualiza_pf;
	endif;
endif;