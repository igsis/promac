<?php
$con = bancoMysqli();
//[Procedure mySql para trigger de update]
pr_atualizaCampos();

function exibeFotoProjeto($idPessoa, $tipoPessoa, $pagina)
{
    $con = bancoMysqli();
    $sql = "SELECT *
			FROM lista_documento as list
			INNER JOIN upload_arquivo as arq ON arq.idListaDocumento = list.idListaDocumento
			WHERE arq.idPessoa = '$idPessoa'
			AND arq.idTipo = '$tipoPessoa'
			AND arq.publicado = '1'";
    $query = mysqli_query($con, $sql);
    $linhas = mysqli_num_rows($query);

    if ($linhas > 0) {
        echo "
		<table class='table table-condensed'>
			<thead>
				<tr class='list_menu'>
					<td>Tipo de arquivo</td>
					<td>Nome do arquivo</td>
					<td width='15%'></td>
				</tr>
			</thead>
			<tbody>";
        while ($arquivo = mysqli_fetch_array($query)) {
            echo "<tr>";
            echo "<td class='list_description'>(" . $arquivo['documento'] . ")</td>";
            echo "<td class='list_description'><a href='../uploadsdocs/" . $arquivo['arquivo'] . "' target='_blank'>" . mb_strimwidth($arquivo['arquivo'], 15, 25, "...") . "</a></td>";
            echo "<td class='list_description'><button class='btn btn-theme' type='button' id='btnRemover' data-toggle='modal' data-target='#confirmApagar' data-id='{$arquivo['idUploadArquivo']}'>Remover
								</button></td>";
            echo "</tr>";
        }
        echo "
		</tbody>
		</table>";
    } else {
        echo "<p>Não há arquivo(s) inserido(s).<p/><br/>";
    }
}


if (isset($_POST['carregar'])) {
    $_SESSION['idProjeto'] = $_POST['carregar'];
}

$idProjeto = $_SESSION['idProjeto'];

if (isset($_POST['novoPj'])) //tipoePessoa = 2
{
    $usuario = recuperaDados("pessoa_juridica", "idPj", $idPj);
    $usuarioLogado = addslashes($usuario['razaoSocial'] . ' [ID=' . $usuario['idPj'] . ']');

    $idPj = $_SESSION['idUser'];
    $nomeProjeto = addslashes($_POST['nomeProjeto']);
    $idAreaAtuacao = $_POST['idAreaAtuacao'];
    $tags = $_POST['tags'];
    $avaliaProjeto = $_POST['avaliaProjeto'];
    if (isset($_POST['segmento'])) {
        $segmento = $_POST['segmento'];
    } else {
        $segmento = null;
    }

    if (isset($_POST['contratoGestao'])) {
        $contratoGestao = $_POST['contratoGestao'];
    } else {
        $contratoGestao = 0;
    }
    $sql_insere_projeto = "UPDATE `projeto` SET
		`contratoGestao` = '$contratoGestao',
		`nomeProjeto` = '$nomeProjeto',
		`idAreaAtuacao` = '$idAreaAtuacao',
        `segmento` = '$segmento',
		`alteradoPor`   = '$usuarioLogado',
		`avaliaProjeto` = '$avaliaProjeto'
		WHERE `idProjeto` = '$idProjeto'";
    if (mysqli_query($con, $sql_insere_projeto)) {
        if (count($_FILES) > 0) {
            $sql_arquivos = "SELECT * FROM lista_documento WHERE idTipoUpload = '7'";
            $query_arquivos = mysqli_query($con, $sql_arquivos);
            while ($arq = mysqli_fetch_array($query_arquivos)) {
                $y = $arq['idListaDocumento'];
                $x = $arq['sigla'];
                $nome_arquivo = isset($_FILES['arquivo']['name'][$x]) ? $_FILES['arquivo']['name'][$x] : null;
                $f_size = isset($_FILES['arquivo']['size'][$x]) ? $_FILES['arquivo']['size'][$x] : null;

                if ($f_size > 5242880) // 5MB em bytes
                {
                    $mensagem = "<font color='#FF0000'><strong>Erro! Tamanho de arquivo excedido! Tamanho máximo permitido: 05 MB.</strong></font>";
                } else {
                    if ($nome_arquivo != "") {
                        $nome_temporario = $_FILES['arquivo']['tmp_name'][$x];
                        $new_name = date("YmdHis") . "_" . semAcento($nome_arquivo); //Definindo um novo nome para o arquivo
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
        }

        atualizaRelacionamento('projeto_tag', 'projeto_id', $idProjeto, 'tag_id', $tags);

        $mensagem = "<font color='#01DF3A'><strong>Gravado com sucesso!</strong></font>";
        gravarLog($sql_insere_projeto);
    } else {
        $mensagem = "<font color='#01DF3A'><strong>Erro ao gravar! Tente novamente.</strong></font>";
    }
}

if (isset($_POST['insereAtuacao'])) {
    $usuario = recuperaDados("pessoa_fisica", "idPf", $idPf);
    $usuarioLogado =
        $usuario['nome'] . ' [ID=' . $usuario['idPf'] . ']';

    $idPf = $_SESSION['idUser'];
    $nomeProjeto = $_POST['nomeProjeto'];
    $idAreaAtuacao = $_POST['idAreaAtuacao'];
    $tags = isset($_POST['tags']) ? $_POST['tags'] : "";
    $sql_insere_projeto = "UPDATE projeto SET
		nomeProjeto = '$nomeProjeto',
		idAreaAtuacao = '$idAreaAtuacao',
		alteradoPor   = '$usuarioLogado' 
		WHERE idProjeto = '$idProjeto'";
    if (mysqli_query($con, $sql_insere_projeto)) {
        if (count($_FILES) > 0) {
            $sql_arquivos = "SELECT * FROM lista_documento WHERE idTipoUpload = '7'";
            $query_arquivos = mysqli_query($con, $sql_arquivos);
            while ($arq = mysqli_fetch_array($query_arquivos)) {
                $y = $arq['idListaDocumento'];
                $x = $arq['sigla'];
                $nome_arquivo = isset($_FILES['arquivo']['name'][$x]) ? $_FILES['arquivo']['name'][$x] : null;
                $f_size = isset($_FILES['arquivo']['size'][$x]) ? $_FILES['arquivo']['size'][$x] : null;

                if ($f_size > 5242880) // 5MB em bytes
                {
                    $mensagem = "<font color='#FF0000'><strong>Erro! Tamanho de arquivo excedido! Tamanho máximo permitido: 05 MB.</strong></font>";
                } else {
                    if ($nome_arquivo != "") {
                        $nome_temporario = $_FILES['arquivo']['tmp_name'][$x];
                        $new_name = date("YmdHis") . "_" . semAcento($nome_arquivo); //Definindo um novo nome para o arquivo
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
        }

        atualizaRelacionamento('projeto_tag', 'projeto_id', $idProjeto, 'tag_id', $tags);

        $mensagem = "<font color='#01DF3A'><strong>Gravado com sucesso!</strong></font>";
        gravarLog($sql_insere_projeto);
    } else {
        $mensagem = "<font color='#01DF3A'><strong>Erro ao gravar! Tente novamente.</strong></font>";
    }
}

if (isset($_POST['apagar'])) {
    $idArquivo = $_POST['apagar'];
    $sql_apagar_arquivo = "UPDATE upload_arquivo SET publicado = 0 WHERE idUploadArquivo = '$idArquivo'";
    if (mysqli_query($con, $sql_apagar_arquivo)) {
        $mensagem = "<font color='#01DF3A'><strong>Arquivo apagado com sucesso!</strong></font>";
        gravarLog($sql_apagar_arquivo);
    } else {
        $mensagem = "<font color='#FF0000'><strong>Erro ao apagar arquivo!</strong></font>";
    }
}


$projeto = recuperaDados("projeto", "idProjeto", $idProjeto);
?>
<section id="list_items" class="home-section bg-white">
    <div class="container">
        <?php
        if ($projeto['tipoPessoa'] == 1) {
            $idPf = $_SESSION['idUser'];
            include '../perfil/includes/menu_interno_pf.php';
            $pf = recuperaDados("pessoa_fisica", "idPf", $idPf);
            $cooperado = $pf['cooperado'];
        } else {
            $idPj = $_SESSION['idUser'];
            include '../perfil/includes/menu_interno_pj.php';
        }
        ?>
        <div class="form-group">
            <h4>Cadastro de Projeto</h4>
            <p><strong><?php if (isset($mensagem)) {
                        echo $mensagem;
                    } ?></strong></p>
        </div>
        <div class="row">
            <div class="col-md-offset-1 col-md-10">

                <?php
                if ($projeto['tipoPessoa'] == 2) //Pessoa Jurídica
                {
                    ?>
                    <form method="POST" action="?perfil=projeto_edicao" class="form-horizontal" role="form"
                          enctype="multipart/form-data">
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <strong>Possui Contrato de Gestão ou Termo de Colaboração com o Poder
                                    Público?* </strong>&nbsp;&nbsp;&nbsp;<input type="checkbox" name="contratoGestao"
                                                                                value="1" <?php checar($projeto['contratoGestao']) ?>>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8"><label>Nome do projeto</label>
                                <input type="text" name="nomeProjeto" required class="form-control"
                                       value="<?= $projeto['nomeProjeto'] ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Área de atuação *</label>
                                <select class="form-control" name="idAreaAtuacao">
                                    <option value="1"></option>
                                    <?php echo geraOpcao("area_atuacao", $projeto['idAreaAtuacao']) ?>
                                </select>
                            </div>
                        </div>
                        <?php if ($projeto['idAreaAtuacao'] == 22) { ?>
                            <div class="form-group">
                                <div class="col-md-offset-2 col-md-8">
                                    <label>Segmento *</label>
                                    <input type="text" name="segmento" maxlength="80" class="form-control"
                                           value="<?= isset($projeto['segmento']) ? $projeto['segmento'] : null ?>">
                                </div>
                            </div>
                        <?php } ?>

                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <?php if (verificaArquivosExistentesPF($idProjeto, 58, 7)): ?>
                                    <label>Foto do Projeto *</label>
                                    <?php exibeFotoProjeto($idProjeto, '7', 'projeto_edicao') ?>
                                <?php else: ?>
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
                                        <strong>São aceitos apenas imagens no formato .JPG e .PNG</strong><br>
                                        <strong>Tamanho Máximo: 5Mb</strong>
                                    </div>
                                    <input type="file" name="arquivo[foto_proj]" accept="image/*" required>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Tags do Projeto *</label>
                                <div class="alert alert-warning">
                                    Escolha até 3 (três) tags que você considera que tem mais relação com seu projeto.
                                    As tags são uma nova maneira de ajudar a identificar o seu projeto para além da
                                    linguagem ou segmento do qual ele faz parte. Escolha, no máximo, 3 (três)
                                    palavras-chave.
                                </div>
                                <?php geraCheckbox('tags', 'projeto_tag', 'projeto_id', $idProjeto); ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Você deseja que o projeto seja avaliado para ser enquadrado na exceção
                                    possibilitada pelo Art.53 do Decreto 59.119/2019?</label>
                                <div class="alert alert-warning">
                                    "O Art.53 do Decreto 59.119/2019 diz:
                                    Art. 53. Estão excluídos do cálculo previsto no artigo 52 e terão 100% de
                                    renúncia fiscal os projetos culturais que, concomitantemente, tenham como
                                    proponentes organizações da sociedade civil sem fins lucrativos, ofereçam de
                                    forma gratuita ao público a totalidade de suas atividades e ofereçam como
                                    contrapartida para a Municipalidade o atendimento a alunos da rede pública de
                                    ensino e, também, pelo menos, uma das seguintes ações de democratização ou
                                    formação de acordo com regras estabelecidas em edital do Programa:
                                    I – plano de residência artística voltado a artistas moradores das Faixas 1 e 2
                                    referidas no artigo 51;
                                    II - cessão de espaço do proponente para apresentações de grupos fomentados
                                    diretamente pela Secretaria Municipal da Cultura por Editais de Fomento direto,
                                    tais como Fomento à Periferia, VAI e Fomento às Linguagens Artísticas;
                                    III - contratação de jovens moradores dos distritos pertencentes à Faixa 1
                                    referida no artigo 51 para prestação de serviços necessários à realização do
                                    projeto ou para outras atividades de caráter permanente da instituição;
                                    IV – realização de atividades de difusão e democratização relacionadas ao
                                    projeto, tais como oficinas, apresentações, seminários, em distritos
                                    pertencentes às Faixas 1 e 2 referidas no artigo 51. "
                                </div>
                                <div class="form-group text-left">
                                    <p><input type="radio" name="avaliaProjeto" value="1" <?= $projeto['avaliaProjeto'] ? 'checked' : '' ?> > &nbsp;&nbsp; Sim, desejo que
                                        este projeto seja avaliado sob a perspectiva do Artigo 53.</p>
                                    <p><input type="radio" name="avaliaProjeto" value="0" <?= !($projeto['avaliaProjeto']) ? 'checked' : '' ?> > &nbsp;&nbsp; Não, este projeto
                                        não se enquadra nesta exceção.</p>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <input type="submit" name="novoPj" class="btn btn-theme btn-md btn-block"
                                       value="gravar">
                            </div>
                        </div>
                    </form>
                    <?php
                }
                if ($projeto['tipoPessoa'] == 1) //Pessoa Física
                {
                    ?>
                    <form method="POST" action="?perfil=projeto_edicao" class="form-horizontal" role="form"
                          enctype="multipart/form-data">
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8"><label>Nome do projeto</label>
                                <input type="text" name="nomeProjeto" required class="form-control"
                                       value="<?= $projeto['nomeProjeto'] ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Área de atuação *</label><br/>
                                <select class="form-control" name="idAreaAtuacao">
                                    <?php
                                    if ($cooperado == 1) {
                                        echo geraAreaAtuacao("area_atuacao", "1,2", $projeto['idAreaAtuacao']);
                                    } else {
                                        echo geraAreaAtuacao("area_atuacao", "1", $projeto['idAreaAtuacao']);
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <?php if (verificaArquivosExistentesPF($idProjeto, 58, 7)): ?>
                                    <label>Foto do Projeto *</label>
                                    <?php exibeFotoProjeto($idProjeto, '7', 'projeto_edicao') ?>
                                <?php else: ?>
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
                                        <strong>São aceitos apenas imagens no formato .JPG e .PNG</strong><br>
                                        <strong>Tamanho Máximo: 5Mb</strong>
                                    </div>
                                    <input type="file" name="arquivo[foto_proj]" accept="image/*" required>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Tags do Projeto *</label>
                                <div class="alert alert-warning">
                                    Escolha até 3 (três) tags que você considera que tem mais relação com seu projeto.
                                    As tags são uma nova maneira de ajudar a identificar o seu projeto para além da
                                    linguagem ou segmento do qual ele faz parte. Escolha, no máximo, 3 (três)
                                    palavras-chave.
                                </div>
                                <?php geraCheckbox('tags', 'projeto_tag', 'projeto_id', $idProjeto); ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-offset-2 col-md-8">
                                <label>Você deseja que o projeto seja avaliado para ser enquadrado na exceção
                                    possibilitada pelo Art.53 do Decreto 59.119/2019?</label>
                                <div class="alert alert-warning">
                                    "O Art.53 do Decreto 59.119/2019 diz:
                                    Art. 53. Estão excluídos do cálculo previsto no artigo 52 e terão 100% de
                                    renúncia fiscal os projetos culturais que, concomitantemente, tenham como
                                    proponentes organizações da sociedade civil sem fins lucrativos, ofereçam de
                                    forma gratuita ao público a totalidade de suas atividades e ofereçam como
                                    contrapartida para a Municipalidade o atendimento a alunos da rede pública de
                                    ensino e, também, pelo menos, uma das seguintes ações de democratização ou
                                    formação de acordo com regras estabelecidas em edital do Programa:
                                    I – plano de residência artística voltado a artistas moradores das Faixas 1 e 2
                                    referidas no artigo 51;
                                    II - cessão de espaço do proponente para apresentações de grupos fomentados
                                    diretamente pela Secretaria Municipal da Cultura por Editais de Fomento direto,
                                    tais como Fomento à Periferia, VAI e Fomento às Linguagens Artísticas;
                                    III - contratação de jovens moradores dos distritos pertencentes à Faixa 1
                                    referida no artigo 51 para prestação de serviços necessários à realização do
                                    projeto ou para outras atividades de caráter permanente da instituição;
                                    IV – realização de atividades de difusão e democratização relacionadas ao
                                    projeto, tais como oficinas, apresentações, seminários, em distritos
                                    pertencentes às Faixas 1 e 2 referidas no artigo 51. "
                                </div>
                                <div class="form-group text-left">
                                    <p><input type="radio" name="avaliaProjeto" value="1" <?= $projeto['avaliaProjeto'] ? 'checked' : '' ?> > &nbsp;&nbsp; Sim, desejo que
                                        este projeto seja avaliado sob a perspectiva do Artigo 53.</p>
                                    <p><input type="radio" name="avaliaProjeto" value="0" <?= !($projeto['avaliaProjeto']) ? 'checked' : '' ?> > &nbsp;&nbsp; Não, este projeto
                                        não se enquadra nesta exceção.</p>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <input type="submit" name="insereAtuacao" class="btn btn-theme btn-md btn-block"
                                       value="Inserir">
                            </div>
                        </div>
                    </form>
                    <?php
                    if ($cooperado == 1) {
                        $pj = recuperaDados("pessoa_juridica", "idPj", $projeto['idPj']);
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
                            <form method="POST" action="?perfil=cooperativa_resultado_busca" class="form-horizontal"
                                  role="form">
                                <div class="col-md-offset-4 col-md-3">
                                    <input type="text" name="busca" class="form-control" placeholder="CNPJ" id="cnpj">
                                </div>
                                <div class="col-md-2">
                                    <input type="submit" name="pesquisar" class="btn btn-theme btn-md btn-block"
                                           value="Pesquisar">
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
    <!-- Confirmação de Exclusão -->
    <div class="modal fade" id="confirmApagar" role="dialog" aria-labelledby="confirmApagarLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Excluir Arquivo?</h4>
                </div>
                <div class="modal-body">
                    <p>Deseja realmente excluir esta foto do projeto?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                    <form id='apagarArq' method='POST' action='?perfil=projeto_edicao'>
                        <input type='hidden' name='idPessoa' value='<?= $idProjeto ?>'/>
                        <input type='hidden' name='tipoPessoa' value='7'/>
                        <input type='hidden' name='apagar' id="idArquivo" value=''/>
                        <button class='btn btn-theme' type='submit' data-toggle='modal'
                                data-target='#confirmApagar' data-title='Remover Arquivo?'
                                data-message='Deseja realmente excluir esta foto do projeto?'>Remover
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Fim Confirmação de Exclusão -->
</section>
<script>
    $('#btnRemover').click(function () {
        let idArquivo = $(this).attr('data-id');
        $('#idArquivo').attr('value', idArquivo)
    })

    function travaCheckbox() {
        let checkboxes = $('input:checkbox');
        let qtdChecked = $('input:checkbox:checked').length;
        console.log(checkboxes);
        console.log(qtdChecked);

        // if (qtdChecked == 3) {
        //
        // }

        if (qtdChecked == 3) {
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