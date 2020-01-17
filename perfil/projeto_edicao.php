<?php
$con = bancoMysqli();
//[Procedure mySql para trigger de update]
pr_atualizaCampos(); 


if(isset($_POST['carregar']))
{
	$_SESSION['idProjeto'] = $_POST['carregar'];
}

$idProjeto = $_SESSION['idProjeto'];

if(isset($_POST['novoPj'])) //tipoePessoa = 2
{
	$usuario = recuperaDados("pessoa_juridica","idPj",$idPj);
      $usuarioLogado = addslashes($usuario['razaoSocial'].' [ID='.$usuario['idPj'].']');

	$idPj = $_SESSION['idUser'];
	$nomeProjeto = addslashes($_POST['nomeProjeto']);
	$idAreaAtuacao = $_POST['idAreaAtuacao'];
    if(isset($_POST['segmento'])){
        $segmento = $_POST['segmento'];
    }else{
        $segmento = null;
    }
    
	if(isset($_POST['contratoGestao']))
	{
		$contratoGestao = $_POST['contratoGestao'];
	}
	else
	{
		$contratoGestao = 0;
	}
	$sql_insere_projeto = "UPDATE `projeto` SET
		`contratoGestao` = '$contratoGestao',
		`nomeProjeto` = '$nomeProjeto',
		`idAreaAtuacao` = '$idAreaAtuacao',
        `segmento` = '$segmento',
		`alteradoPor`   = '$usuarioLogado'
		WHERE `idProjeto` = '$idProjeto'";
	if(mysqli_query($con,$sql_insere_projeto))
	{
        $sql_arquivos = "SELECT * FROM lista_documento WHERE idTipoUpload = '7'";
        $query_arquivos = mysqli_query($con,$sql_arquivos);
        while($arq = mysqli_fetch_array($query_arquivos))
        {
            $y = $arq['idListaDocumento'];
            $x = $arq['sigla'];
            $nome_arquivo = isset($_FILES['arquivo']['name'][$x]) ? $_FILES['arquivo']['name'][$x] : null;
            $f_size = isset($_FILES['arquivo']['size'][$x]) ? $_FILES['arquivo']['size'][$x] : null;

            if($f_size > 5242880) // 5MB em bytes
            {
                $mensagem = "<font color='#FF0000'><strong>Erro! Tamanho de arquivo excedido! Tamanho máximo permitido: 05 MB.</strong></font>";
            }
            else
            {
                if($nome_arquivo != "")
                {
                    $nome_temporario = $_FILES['arquivo']['tmp_name'][$x];
                    $new_name = date("YmdHis")."_".semAcento($nome_arquivo); //Definindo um novo nome para o arquivo
                    $hoje = date("Y-m-d H:i:s");
                    $dir = '../uploadsdocs/'; //Diretório para uploads

                    if (move_uploaded_file($nome_temporario, $dir . $new_name)) {
                        $sql_insere_arquivo = "INSERT INTO `upload_arquivo` (`idTipo`, `idPessoa`, `idListaDocumento`, `arquivo`, `dataEnvio`, `publicado`) VALUES ('7', '$idProjeto', '$y', '$new_name', '$hoje', '1'); ";
                        $query = mysqli_query($con, $sql_insere_arquivo);
                        if ($query) {
                            $mensagem = "<font color='#01DF3A'><strong>Arquivo recebido com sucesso!</strong></font>";
                            gravarLog($sql_insere_arquivo);
                        } else {
                            $mensagem = "<font color='#FF0000'><strong>Erro ao gravar no banco.</strong></font>";
                        }
                    } else {
                        $mensagem = "<font color='#FF0000'><strong>Erro no upload! Tente novamente.</strong></font>";
                    }
                }
            }
        }

		$mensagem = "<font color='#01DF3A'><strong>Gravado com sucesso!</strong></font>";
		gravarLog($sql_insere_projeto);
	}
	else
	{
		$mensagem = "<font color='#01DF3A'><strong>Erro ao gravar! Tente novamente.</strong></font>";
	}
}

if(isset($_POST['insereAtuacao']))
{
	$usuario = recuperaDados("pessoa_fisica","idPf",$idPf);
    $usuarioLogado = 
      $usuario['nome'].' [ID='.$usuario['idPf'].']';
	
	$idPf = $_SESSION['idUser'];
	$nomeProjeto = $_POST['nomeProjeto'];
	$idAreaAtuacao = $_POST['idAreaAtuacao'];
	$sql_insere_projeto = "UPDATE projeto SET
		nomeProjeto = '$nomeProjeto',
		idAreaAtuacao = '$idAreaAtuacao',
		alteradoPor   = '$usuarioLogado' 
		WHERE idProjeto = '$idProjeto'";
	if(mysqli_query($con,$sql_insere_projeto))
	{
        $sql_arquivos = "SELECT * FROM lista_documento WHERE idTipoUpload = '7'";
        $query_arquivos = mysqli_query($con,$sql_arquivos);
        while($arq = mysqli_fetch_array($query_arquivos))
        {
            $y = $arq['idListaDocumento'];
            $x = $arq['sigla'];
            $nome_arquivo = isset($_FILES['arquivo']['name'][$x]) ? $_FILES['arquivo']['name'][$x] : null;
            $f_size = isset($_FILES['arquivo']['size'][$x]) ? $_FILES['arquivo']['size'][$x] : null;

            if($f_size > 5242880) // 5MB em bytes
            {
                $mensagem = "<font color='#FF0000'><strong>Erro! Tamanho de arquivo excedido! Tamanho máximo permitido: 05 MB.</strong></font>";
            }
            else
            {
                if($nome_arquivo != "")
                {
                    $nome_temporario = $_FILES['arquivo']['tmp_name'][$x];
                    $new_name = date("YmdHis")."_".semAcento($nome_arquivo); //Definindo um novo nome para o arquivo
                    $hoje = date("Y-m-d H:i:s");
                    $dir = '../uploadsdocs/'; //Diretório para uploads

                    if (move_uploaded_file($nome_temporario, $dir . $new_name)) {
                        $sql_insere_arquivo = "INSERT INTO `upload_arquivo` (`idTipo`, `idPessoa`, `idListaDocumento`, `arquivo`, `dataEnvio`, `publicado`) VALUES ('7', '$idProjeto', '$y', '$new_name', '$hoje', '1'); ";
                        $query = mysqli_query($con, $sql_insere_arquivo);
                        if ($query) {
                            $mensagem = "<font color='#01DF3A'><strong>Arquivo recebido com sucesso!</strong></font>";
                            gravarLog($sql_insere_arquivo);
                        } else {
                            $mensagem = "<font color='#FF0000'><strong>Erro ao gravar no banco.</strong></font>";
                        }
                    } else {
                        $mensagem = "<font color='#FF0000'><strong>Erro no upload! Tente novamente.</strong></font>";
                    }
                }
            }
        }

		$mensagem = "<font color='#01DF3A'><strong>Gravado com sucesso!</strong></font>";
		gravarLog($sql_insere_projeto);
	}
	else
	{
		$mensagem = "<font color='#01DF3A'><strong>Erro ao gravar! Tente novamente.</strong></font>";
	}
}

$projeto = recuperaDados("projeto","idProjeto",$idProjeto);
?>
    <section id="list_items" class="home-section bg-white">
        <div class="container">
            <?php
    	if($projeto['tipoPessoa'] == 1)
		{
			$idPf= $_SESSION['idUser'];
			include '../perfil/includes/menu_interno_pf.php';
			$pf = recuperaDados("pessoa_fisica","idPf",$idPf);
			$cooperado = $pf['cooperado'];
		}
		else
		{
			$idPj= $_SESSION['idUser'];
			include '../perfil/includes/menu_interno_pj.php';
		}
    	?>
                <div class="form-group">
                    <h4>Cadastro de Projeto</h4>
                    <p><strong><?php if(isset($mensagem)){echo $mensagem;} ?></strong></p>
                </div>
                <div class="row">
                    <div class="col-md-offset-1 col-md-10">

                        <?php
				if($projeto['tipoPessoa'] == 2) //Pessoa Jurídica
				{
				?>
                            <form method="POST" action="?perfil=projeto_edicao" class="form-horizontal" role="form" enctype="multipart/form-data">
                                <div class="form-group">
                                    <div class="col-md-offset-2 col-md-8">
                                        <strong>Possui Contrato de Gestão ou Termo de Colaboração com o Poder Público?* </strong>&nbsp;&nbsp;&nbsp;<input type="checkbox" name="contratoGestao" value="1" <?php checar($projeto[ 'contratoGestao']) ?>>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-offset-2 col-md-8"><label>Nome do projeto</label>
                                        <input type="text" name="nomeProjeto" required class="form-control" value="<?= $projeto['nomeProjeto'] ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-offset-2 col-md-8">
                                        <label>Área de atuação *</label>
                                        <select class="form-control" name="idAreaAtuacao">
									<option value="1"></option>
									<?php echo geraOpcao("area_atuacao",$projeto['idAreaAtuacao']) ?>
								</select>
                                    </div>
                                </div>
                                <?php if($projeto['idAreaAtuacao'] == 22) { ?>
                                    <div class="form-group">
                                        <div class="col-md-offset-2 col-md-8">
                                            <label>Segmento *</label>
                                            <input type="text" name="segmento" maxlength="80" class="form-control" value="<?= isset($projeto['segmento']) ? $projeto['segmento'] : null ?>">
                                        </div>
                                    </div>
                                <?php } ?>

                                    <div class="form-group">
                                        <div class="col-md-offset-2 col-md-8">
                                            <?php if (verificaArquivosExistentesPF($idProjeto, 58)): ?>
                                                <div class="alert alert-success">A Foto do Projeto já foi enviada</div>
                                            <?php else: ?>
                                                <label>Foto do Projeto *</label>
                                                <input type="file" name="arquivo[foto_proj]">
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-md-offset-2 col-md-8">
                                            <input type="submit" name="novoPj" class="btn btn-theme btn-md btn-block" value="gravar">
                                        </div>
                                    </div>
                            </form>
                            <?php
				}
				if($projeto['tipoPessoa'] == 1) //Pessoa Física
				{
				?>
                                <form method="POST" action="?perfil=projeto_edicao" class="form-horizontal" role="form" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <div class="col-md-offset-2 col-md-8"><label>Nome do projeto</label>
                                            <input type="text" name="nomeProjeto" required class="form-control" value="<?= $projeto['nomeProjeto'] ?>">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-md-offset-2 col-md-8">
                                            <label>Área de atuação *</label><br/>
                                            <select class="form-control" name="idAreaAtuacao">
                                                <?php
                                                if($cooperado == 1)
                                                {
                                                    echo geraAreaAtuacao("area_atuacao","1,2",$projeto['idAreaAtuacao']);
                                                }
                                                else
                                                {
                                                    echo geraAreaAtuacao("area_atuacao","1",$projeto['idAreaAtuacao']);
                                                }
                                                ?>
								            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-md-offset-2 col-md-8">
                                            <?php if (verificaArquivosExistentesPF($idProjeto, 58)): ?>
                                                <div class="alert alert-success">A Foto do Projeto já foi enviada</div>
                                            <?php else: ?>
                                                <label>Foto do Projeto *</label>
                                                <input type="file" name="arquivo[foto_proj]">
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-md-offset-2 col-md-8">
                                            <input type="submit" name="insereAtuacao" class="btn btn-theme btn-md btn-block" value="Inserir">
                                        </div>
                                    </div>
                                </form>
                                <?php
					if($cooperado == 1)
					{
						$pj= recuperaDados("pessoa_juridica", "idPj",$projeto['idPj']);
					?>
                                    <div class="form-group">
                                        <div class="col-md-offset-2 col-md-8">
                                            <hr/>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-md-offset-2 col-md-8" align="left">
                                            <strong>Cooperativa:</strong>
                                            <?php echo $pj['razaoSocial'] ?>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-md-offset-2 col-md-8"><br/></div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-md-offset-2 col-md-8">
                                            <strong>Insira o CNPJ da Cooperativa: </strong>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <form method="POST" action="?perfil=cooperativa_resultado_busca" class="form-horizontal" role="form">
                                            <div class="col-md-offset-4 col-md-3">
                                                <input type="text" name="busca" class="form-control" placeholder="CNPJ" id="cnpj">
                                            </div>
                                            <div class="col-md-2">
                                                <input type="submit" name="pesquisar" class="btn btn-theme btn-md btn-block" value="Pesquisar">
                                            </div>
                                        </form>
                                    </div>
                                    <?php
					}
				}
				?>
                    </div>
                </div>
        </div>
    </section>
