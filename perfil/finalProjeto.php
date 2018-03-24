<?php

$con = bancoMysqli();
$idUsuario = $_SESSION['idUser'];
$tipoPessoa = $_SESSION['tipoPessoa'];
if ($tipoPessoa == "1")
{
	$pf = recuperaDados("pessoa_fisica","idPf",$idPf);
}
else
{
	$pj = recuperaDados("pessoa_juridica","idPj",$idUsuario);
}
$idProjeto = $_SESSION['idProjeto'];
$alterar = 0;

/**Campos Obrigatórios**/
if(isset($idProjeto)):        
  require_once('validacaoCamposObrigatorios.php');
endif;  

/**Arquivos Obrigatórios**/
if(isset($tipoPessoa) && isset($idProjeto)):  
  require_once('validacaoArquivosObrigatorios.php');	
endif;	

$select = "SELECT idStatus FROM projeto WHERE idProjeto='$idProjeto' AND publicado='1'";
$send = mysqli_query($con, $select);
$row = mysqli_fetch_array($send);

if($row['idStatus'] == 6)
	$alterar = 1;

?>
<section id="list_items" class="home-section bg-white">
	<div class="container">
		<?php
    	if($_SESSION['tipoPessoa'] == 1)
		{
			$idPf= $_SESSION['idUser'];
			include '../perfil/includes/menu_interno_pf.php';
		}
		else
		{
			$idPj= $_SESSION['idUser'];
			include '../perfil/includes/menu_interno_pj.php';
		}
    	?>
		<div class="form-group">

			<h4>Resumo do Projeto</h4>
			<div class="alert alert-warning">
				<strong>Atenção!</strong> Confirme atentamente se os dados abaixo estão corretos!
			</div>
		</div>
		 <div class = "page-header">
		 	<h5>Informações legais</h5>
		 	<br>
		 </div>

		 <?php
		 	if ($tipoPessoa == "1") // Se Pessoa Fisica
				{
					$query = "SELECT * FROM projeto WHERE idPf='$idUsuario' AND publicado='1' AND idProjeto='$idProjeto'";
				}
				else // Se Pessoa Juridica
				{
					$query = "SELECT * FROM projeto WHERE idPj='$idUsuario' AND publicado='1' AND idProjeto='$idProjeto'";
				}
			 $en = mysqli_query($con, $query);
			 while($row = mysqli_fetch_array($en, MYSQLI_ASSOC)){
		 ?>
		 <div class="well">
			<p align="justify"><strong>Referência:</strong> <?php echo $row['idProjeto']; ?></p>
			<p align="justify"><strong>Nome do Projeto:</strong> <?php echo isset($row['nomeProjeto']) ? $row['nomeProjeto'] : null; ?></p>
			<p align="justify"><strong>Valor do projeto:</strong> <?php echo isset($row['valorProjeto']) ? $row['valorProjeto'] : null; ?></p>
			<p align="justify"><strong>Valor do incentivo:</strong> <?php echo isset($row['valorIncentivo']) ? $row['valorIncentivo'] : null; ?><p>
			<p align="justify"><strong>Valor do financiamento:</strong> <?php echo isset($row['valorFinanciamento']) ? $row['valorFinanciamento'] : null; ?><p>
			<p align="justify"><strong>Marca:</strong> <?php echo isset($row['exposicaoMarca']) ? $row['exposicaoMarca'] : null; ?><p>
		</div>

		<div class = "page-header">
		 	<h5>Informações gerais do projeto</h5>
		 	<br>
		 </div>

		  <div class="well">
			<p align="justify"><strong>Resumo do projeto:</strong> <?php echo isset($row['resumoProjeto']) ? $row['resumoProjeto'] : null; ?></p>
			<p align="justify"><strong>Currículo:</strong> <?php echo isset($row['curriculo']) ? $row['curriculo'] : null; ?></p>
			<p align="justify"><strong>Descrição:</strong> <?php echo isset($row['descricao']) ? $row['descricao'] : null; ?></p>
			<p align="justify"><strong>Justificativa:</strong> <?php echo isset($row['justificativa']) ? $row['justificativa'] : null; ?></p>
			<p align="justify"><strong>Objetivo:</strong> <?php echo isset($row['objetivo']) ? $row['objetivo'] : null; ?></p>
			<p align="justify"><strong>Metodologia:</strong> <?php echo isset($row['metodologia']) ? $row['metodologia'] : null; ?></p>
			<p align="justify"><strong>Contrapartida:</strong> <?php echo isset($row['contrapartida']) ? $row['contrapartida'] : null; ?></p>
		 </div>

		 <div class = "page-header">
		 	<h5>Detalhamento</h5>
		 	<br>
		 </div>

		 <div class="well">
		 	<p align="justify"><strong>Público alvo:</strong> <?php echo isset($row['publicoAlvo']) ? $row['publicoAlvo'] : null; ?></p>
		 	<p align="justify"><strong>Plano de divulgação:</strong> <?php echo isset($row['planoDivulgacao']) ? $row['planoDivulgacao'] : null; ?></p>
		 	<p align="justify"><strong>Início do cronograma:</strong> <?php echo isset($row['inicioCronograma']) ? $row['inicioCronograma'] : null; ?></p>
		 	<p align="justify"><strong>Fim do cronograma:</strong> <?php echo isset($row['fimCronograma']) ? $row['fimCronograma'] : null; ?></p>
		 </div>

		 <div class = "page-header">
		 	<h5>Informações sobre custos</h5>
		 	<br>
		 </div>

		 <div class="well">
		 	<p align="justify"><strong>Pré-produção:</strong> <?php echo isset($row['totalPreProducao']) ? $row['totalPreProducao'] : null; ?></p>
		 	<p align="justify"><strong>Produção:</strong> <?php echo isset($row['totalProducao']) ? $row['totalProducao'] : null; ?></p>
		 	<p align="justify"><strong>Imprensa:</strong> <?php echo isset($row['totalImprensa']) ? $row['totalImprensa'] : null; ?></p>
		 	<p align="justify"><strong>Administrativos:</strong> <?php echo isset($row['totalCustosAdministrativos']) ? $row['totalCustosAdministrativos'] : null; ?></p>
		 	<p align="justify"><strong>Impostos:</strong> <?php echo isset($row['totalImpostos']) ? $row['totalImpostos'] : null; ?></p>
		 	<p align="justify"><strong>Agenciamento:</strong> <?php echo isset($row['totalAgenciamento']) ? $row['totalAgenciamento'] : null; ?></p>
		 	<p align="justify"><strong>Outros financiamentos:</strong> <?php echo isset($row['totalOutrosFinanciamentos']) ? $row['totalOutrosFinanciamentos'] : null; ?></p>
		 </div>

		 <div class = "page-header">
		 	<h5>Mídias sociais</h5>
		 	<br>
		 </div>

		 <div class="well">
		 	<p align="justify"><strong>Vídeo 1:</strong> <?php echo isset($row['video1']) ? $row['video1'] : null; ?></p>
		 	<p align="justify"><strong>Vídeo 2:</strong> <?php echo isset($row['video2']) ? $row['video2'] : null; ?></p>
		 	<p align="justify"><strong>Vídeo 3:</strong> <?php echo isset($row['video3']) ? $row['video3'] : null; ?></p>
		 </div>

		 <?php
		 if($row['idPj'] != NULL)
		 {

		 ?>
		  <div class = "page-header">
		 	<h5>Informações da cooperativa</h5>
		 	<br>
		 </div>

		 <div class="well">
			 <?php
			 $pj = $row['idPj'];
			 $query = "SELECT * FROM pessoa_juridica WHERE idPj='$pj'";
			 $send = mysqli_query($con, $query);
			 while($rowPJ = mysqli_fetch_array($send, MYSQLI_ASSOC)){?>
		 	<p align="justify"><strong>Referência:</strong> <?php echo isset($row['idPj']) ?? null; ?></p>
		 	<p align="justify"><strong>Razão social:</strong> <?php echo isset($rowPJ['razaoSocial']) ? $rowPJ['razaoSocial'] : null; ?></p>
		 	<p align="justify"><strong>CNPJ:</strong> <?php echo isset($rowPJ['cnpj']) ? $rowPJ['cnpj'] : null; ?></p>
			<p align="justify"><strong>CCM:</strong> <?php echo isset($rowPJ['ccm']) ? $rowPJ['ccm'] : null; ?></p>
			<p align="justify"><strong>Logradouro:</strong> <?php echo isset($rowPJ['logradouro']) ? $rowPJ['logradouro'] : null; ?></p>
			<p align="justify"><strong>Bairro:</strong> <?php echo isset($rowPJ['bairro']) ? $rowPJ['bairro'] : null; ?></p>
			<p align="justify"><strong>Cidade:</strong> <?php echo isset($rowPJ['cidade']) ? $rowPJ['cidade'] : null; ?></p>
			<p align="justify"><strong>Estado:</strong> <?php echo isset($rowPJ['estado']) ? $rowPJ['estado'] : null; ?></p>
			<p align="justify"><strong>CEP:</strong> <?php echo isset($rowPJ['cep']) ? $rowPJ['cep'] : null; ?></p>
			<p align="justify"><strong>Número:</strong> <?php echo isset($rowPJ['numero']) ? $rowPJ['numero'] : null; ?></p>
			<p align="justify"><strong>Telefone:</strong> <?php echo isset($rowPJ['telefone']) ? $rowPJ['telefone'] : null; ?></p>
			<p align="justify"><strong>Celular:</strong> <?php echo isset($rowPJ['celular']) ? $rowPJ['celular'] : null; ?></p>
			<p align="justify"><strong>Email:</strong> <?php echo isset($rowPJ['email']) ? $rowPJ['email'] : null; ?></p>
		 </div>
		 <?php }
	 }
	 }?>
	</div>	    
    <!--Inicio do termo do contrato-->	      
    <?php if(sizeof($erros) == 0 && sizeof($arqPendentes) == 0) : ?>      
      <div>
        <a href="#">    
          <div class="termoContrato">
            <input type="hidden" name="termos" id="termo" 
                   value="false">           	            
            <a href="#" data-toggle="modal" data-target="#myModal">
              Click aqui, para ler os termos do contrato.	
            </a>                        
          </div>  
        </a>
        <div class="modal fade" id="myModal" role="dialog">
          <div class="modal-dialog">          
            <div class="modal-content">                      
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Termos do acordo</h4>
              </div>
          
              <div class="modal-body">
                <p>Aqui deve ser incluso o texto dos termos</p>
              </div>
          
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" 
                        data-dismiss="modal" id="btnRejeitar">Rejeitar
                </button>
                <button type="button" class="btn btn-success" 
                        data-dismiss="modal" id="btnAceitar">Aceitar
                </button>        
              </div>
            </div>      
          </div>
        </div>
      </div> 
    <?php endif ?>  
    <!--Fim do termo do contrato-->
    </div>    
    <!-- Botão para Prosseguir -->	  
	  <div class="form-group">
	    <div class="col-md-offset-5 col-md-2">
		  <form class="form-horizontal" role="form" action="?perfil=informacoes_administrativas" method="post">
		   <?php 
		     if($alterar == 1){ ?>
			    <input type="hidden" name="alterar" value="<?php echo $alterar; ?>">
		    <?php } ?>
			<input type="hidden" value="Enviar" id="inptEnviar" 
			       class="btn btn-theme btn-lg btn-block">
		  </form>
		</div>
	  </div>
</section>



