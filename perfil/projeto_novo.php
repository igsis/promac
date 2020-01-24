<?php
$con = bancoMysqli();

if(isset($_POST['novoPj'])) //tipoePessoa = 2
{
	$idPj = $_SESSION['idUser'];
	$idAreaAtuacao = $_POST['idAreaAtuacao'];
	$nomeProjeto = addslashes($_POST['nomeProjeto']);
	$tags = $_POST['tags'];
	if(isset($_POST['contratoGestao']))
	{
		$contratoGestao = $_POST['contratoGestao'];
	}
	else
	{
		$contratoGestao = 0;
	}
	$sql_insere_projeto = "INSERT INTO projeto (idPj, contratoGestao, tipoPessoa, nomeProjeto, idAreaAtuacao, idEtapaProjeto, publicado) VALUES ('$idPj', '$contratoGestao', 2, '$nomeProjeto', '$idAreaAtuacao', 1, 1)";
	
	if(mysqli_query($con,$sql_insere_projeto))
	{
		//[Procedure mySql para trigger de update]
        pr_atualizaCampos();
		$sql_ultimo = "SELECT idProjeto FROM projeto ORDER BY idProjeto DESC LIMIT 0,1";
		$query_ultimo = mysqli_query($con,$sql_ultimo);
		$ultimoProjeto = mysqli_fetch_array($query_ultimo);
		$_SESSION['idProjeto']  = $idProjeto = $ultimoProjeto['idProjeto'];

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

        atualizaRelacionamento('projeto_tag', 'projeto_id', $idProjeto, 'tag_id', $tags);

        $mensagem = "<font color='#01DF3A'><strong>Gravado com sucesso! Aguarde...</strong></font>";
		gravarLog($sql_insere_projeto);
        if($idAreaAtuacao == 22){
            echo "<meta HTTP-EQUIV='refresh' CONTENT='0.5;URL=?perfil=projeto_edicao'>";
        }else{
            echo "<meta HTTP-EQUIV='refresh' CONTENT='0.5;URL=?perfil=projeto_2'>";  
        }

		
	}
	else
	{
		$mensagem = "<font color='#01DF3A'><strong>Erro ao gravar! Tente novamente.</strong></font> <br/>";
	}
}

if(isset($_POST['insereAtuacao']))
{
	$idPf = $_SESSION['idUser'];
	$idAreaAtuacao = $_POST['idAreaAtuacao'];
	$nomeProjeto = $_POST['nomeProjeto'];
	$tags = $_POST['tags'];
	$sql_insere_projeto = "INSERT INTO projeto (idPf, tipoPessoa, nomeProjeto, idAreaAtuacao, idEtapaProjeto, publicado) VALUES ('$idPf', 1, '$nomeProjeto', '$idAreaAtuacao', 1, 1)";
	if(mysqli_query($con,$sql_insere_projeto))
	{
		$sql_ultimo = "SELECT idProjeto FROM projeto ORDER BY idProjeto DESC LIMIT 0,1";
		$query_ultimo = mysqli_query($con,$sql_ultimo);
		$ultimoProjeto = mysqli_fetch_array($query_ultimo);
		$_SESSION['idProjeto']  = $idProjeto = $ultimoProjeto['idProjeto'];

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

        atualizaRelacionamento('projeto_tag', 'projeto_id', $idProjeto, 'tag_id', $tags);

		$mensagem = "<font color='#01DF3A'><strong>Gravado com sucesso! Aguarde...</strong></font>";
		gravarLog($sql_insere_projeto);
		echo "<meta HTTP-EQUIV='refresh' CONTENT='0.5;URL=?perfil=projeto_edicao'>";
	}
	else
	{
		$mensagem = "<font color='#01DF3A'><strong>Erro ao gravar! Tente novamente.</strong></font> <br/>";
	}
}
?>
<section id="list_items" class="home-section bg-white">
    <div class="container">
        <?php
    if($_SESSION['tipoPessoa'] == 1)
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
            if($_SESSION['tipoPessoa'] == 2) //Pessoa Jurídica
            {
            ?>
                        <form method="POST" action="?perfil=projeto_novo" class="form-horizontal" role="form" enctype="multipart/form-data">
                            <div class="form-group">
                                <div class="col-md-offset-2 col-md-8">
                                    <strong>Possui Contrato de Gestão ou Termo de Colaboração com o Poder Público?* </strong>&nbsp;&nbsp;&nbsp;<input type="checkbox" name="contratoGestao" value="1">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-offset-2 col-md-8"><label>Nome do projeto</label>
                                    <input type="text" name="nomeProjeto" required class="form-control">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-offset-2 col-md-8">
                                    <label>Área de atuação *</label>
                                    <select class="form-control" name="idAreaAtuacao" required>
                                        <option value=""></option>
                                        <?php echo geraOpcao("area_atuacao","") ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-offset-2 col-md-8">
                                    <label>Foto do Projeto *</label>
                                    <div class="alert alert-warning">
                                        Aqui você deverá colocar uma foto para representar o projeto. O PROMAC está
                                        aprimorando seus mecanismos de busca e identificação dos projetos, por isso
                                        precisamos de uma imagem boa do seu projeto para deixá-lo mais ilustrativo
                                        para quem for consultá-lo. Se o projeto nunca tiver sido executado, você
                                        poderá colocar uma foto do artista ou do grupo em questão, ou de algum ensaio,
                                        ou mesmo uma imagem indiretamente relacionada ao projeto. O importante é que
                                        seja uma imagem representativa da ideia que você gostaria de expor com sua
                                        proposta e que você tenha direito de usar a foto. <br>
                                        <strong>Tamanho Máximo: 5Mb</strong>
                                    </div>
                                    <input type="file" name="arquivo[foto_proj]" required>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-offset-2 col-md-8">
                                    <label>Tags do Projeto *</label>
                                    <div class="alert alert-warning">
                                        Escolha até 3 (três) tags que você considera que tem mais relação com seu projeto. As tags são uma nova maneira de ajudar a identificar o seu projeto para além da linguagem ou segmento do qual ele faz parte.  Escolha, no máximo, 3 (três) palavras-chave.
                                    </div>
                                    <?php geraCheckbox('tags', 'projeto_tag', 'projeto_id'); ?>
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
            elseif($_SESSION['tipoPessoa'] == 1 && $cooperado == 1) //Pessoa Física Cooperado
            {
                if(!isset($_SESSION['idProjeto']))
                {
            ?>
                            <form method="POST" action="?perfil=projeto_novo" class="form-horizontal" role="form" enctype="multipart/form-data">
                                <div class="form-group">
                                    <div class="col-md-offset-2 col-md-8"><label>Nome do projeto</label>
                                        <input type="text" name="nomeProjeto" required class="form-control">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-offset-2 col-md-8">
                                        <label>Área de atuação *</label><br/>
                                        <select class="form-control" name="idAreaAtuacao" required>
                                            <option value=""></option>
                                            <?php echo geraOpcao("area_atuacao","") ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-offset-2 col-md-8">
                                        <label>Foto do Projeto *</label>
                                        <div class="alert alert-warning">
                                            Aqui você deverá colocar uma foto para representar o projeto. O PROMAC está
                                            aprimorando seus mecanismos de busca e identificação dos projetos, por isso
                                            precisamos de uma imagem boa do seu projeto para deixá-lo mais ilustrativo
                                            para quem for consultá-lo. Se o projeto nunca tiver sido executado, você
                                            poderá colocar uma foto do artista ou do grupo em questão, ou de algum ensaio,
                                            ou mesmo uma imagem indiretamente relacionada ao projeto. O importante é que
                                            seja uma imagem representativa da ideia que você gostaria de expor com sua
                                            proposta e que você tenha direito de usar a foto. <br>
                                            <strong>Tamanho Máximo: 5Mb</strong>
                                        </div>
                                        <input type="file" name="arquivo[foto_proj]" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-offset-2 col-md-8">
                                        <label>Tags do Projeto *</label>
                                        <div class="alert alert-warning">
                                            Escolha até 3 (três) tags que você considera que tem mais relação com seu projeto. As tags são uma nova maneira de ajudar a identificar o seu projeto para além da linguagem ou segmento do qual ele faz parte.  Escolha, no máximo, 3 (três) palavras-chave.
                                        </div>
                                        <?php geraCheckbox('tags', 'projeto_tag', 'projeto_id'); ?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-offset-2 col-md-8">
                                        <input type="submit" name="insereAtuacao" class="btn btn-theme btn-md btn-block" value="Inserir">
                                    </div>
                                </div>
                            </form>
                            <?php
                }
            }
            else
            {
                if($_SESSION['tipoPessoa'] == 1 && $cooperado == 0 && !isset($_SESSION['idProjeto'])) // pessoa fisica
                {
                ?>
                    <form method="POST" action="?perfil=projeto_novo" class="form-horizontal" role="form" enctype="multipart/form-data">
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8"><label>Nome do projeto</label>
                                <input type="text" name="nomeProjeto" required class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Área de atuação *</label><br/>
                                <select class="form-control" name="idAreaAtuacao" required>
                                    <option value=""></option>
                                    <?php echo geraAreaAtuacao("area_atuacao","1","") ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Foto do Projeto *</label>
                                <div class="alert alert-warning">
                                    Aqui você deverá colocar uma foto para representar o projeto. O PROMAC está
                                    aprimorando seus mecanismos de busca e identificação dos projetos, por isso
                                    precisamos de uma imagem boa do seu projeto para deixá-lo mais ilustrativo
                                    para quem for consultá-lo. Se o projeto nunca tiver sido executado, você
                                    poderá colocar uma foto do artista ou do grupo em questão, ou de algum ensaio,
                                    ou mesmo uma imagem indiretamente relacionada ao projeto. O importante é que
                                    seja uma imagem representativa da ideia que você gostaria de expor com sua
                                    proposta e que você tenha direito de usar a foto. <br>
                                    <strong>Tamanho Máximo: 5Mb</strong>
                                </div>
                                <input class="form-control" type="file" name="arquivo[foto_proj]" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Tags do Projeto *</label>
                                <div class="alert alert-warning">
                                    Escolha até 3 (três) tags que você considera que tem mais relação com seu projeto. As tags são uma nova maneira de ajudar a identificar o seu projeto para além da linguagem ou segmento do qual ele faz parte.  Escolha, no máximo, 3 (três) palavras-chave.
                                </div>
                                <?php geraCheckbox('tags', 'projeto_tag', 'projeto_id'); ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <input type="submit" name="insereAtuacao" class="btn btn-theme btn-md btn-block" value="Inserir">
                            </div>
                        </div>
                    </form>
                <?php
                }
                else
                {
                    echo "<meta HTTP-EQUIV='refresh' CONTENT='0.5;URL=?perfil=projeto_edicao'>";
                }
            }
            ?>
                </div>
            </div>
    </div>
</section>
<script>
    function travaCheckbox() {
        let checkboxes = $('input:checkbox');
        let qtdChecked = $('input:checkbox:checked').length;
        console.log(checkboxes);
        console.log(qtdChecked);

        // if (qtdChecked == 3) {
        //
        // }

        if (qtdChecked == 3){
            for (let x = 0; x < checkboxes.length; x++) {
                if (!checkboxes[x].checked) {
                    checkboxes[x].disabled = true;
                }
            }
        } else {
            for (let x = 0; x < checkboxes.length; x++) {
                checkboxes[x].disabled = false;
            }
        }
    }

    $('.tags').click(travaCheckbox);

    $(document).ready(travaCheckbox);
</script>