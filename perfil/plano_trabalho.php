<?php
$con = bancoMysqli();
$idProjeto = $_SESSION['idProjeto'];

function recuperaPlanos($idProjeto) {
    $con = bancoMysqli();
    $queryPlano = $con->query("SELECT * FROM planos WHERE projeto_id = '$idProjeto' AND publicado = '1'");
    if ($queryPlano->num_rows > 0) {
        ?>
        <table class="table-condensed table-responsive table-bordered tabela">
            <thead>
            <tr>
                <th>Objetivo Específico</th>
                <th>Atividade</th>
                <th>Responsável</th>
                <th>Produto</th>
                <th width="15%">Prazo</th>
                <th width="10%" colspan="3" class="text-center">Ações</th>
            </tr>
            </thead>
            <tbody>
        <?php
        $planos = $queryPlano->fetch_all(MYSQLI_ASSOC);
        foreach ($planos as $plano) {
            $queryAtividades = $con->query("SELECT * FROM plano_atividades WHERE plano_id = '{$plano['id']}' AND publicado = '1'");
            $numAtividades = $queryAtividades->num_rows;
            if ($numAtividades > 0) {
                $atividades = $queryAtividades->fetch_all(MYSQLI_ASSOC);
            } else {
                $atividades = [];
            }
            ?>
            <tr>
                <td rowspan="0" class="objetivo"><?=$plano['objetivo_especifico']?></td>
                <?php if ($numAtividades > 0):
                    ?>
                    <td class="atividade"><?= $atividades[0]['atividade'] ?></td>
                    <td class="responsavel"><?= $atividades[0]['responsavel'] ?></td>
                    <td class="produto"><?= $atividades[0]['produto'] ?></td>
                    <td class="prazo"><?= $atividades[0]['prazo'] ?></td>
                    <td>
                        <button class="btn btn-sm btn-theme" data-toggle="modal" data-target="#novaAtividade"
                                data-btn="editaAtividade" data-id="<?=$atividades[0]['id']?>">
                            Editar Atividade
                        </button>
                    </td>
                    <td>
                        <button class='btn btn-sm btn-theme' type='button'
                                onclick="modalApagar(
                                        '#apagarPlanoAtividade',
                                        '<?= $atividades[0]['atividade'] ?>',
                                        '<?= $atividades[0]['id'] ?>',
                                        'apagaAtividade')">Remover Atividade
                        </button>
                    </td>
                    <?php
                    unset($atividades[0]);
                else: ?>
                    <td colspan="6" class="text-center">Nenhuma Atividade Cadastrada</td>
                <?php endif; ?>
                <td rowspan="0" class="text-center">
                    <button class='btn btn-theme form-control' type='button' data-toggle="modal"
                            data-target="#novaAtividade" data-id="<?=$plano['id']?>">
                        Adicionar Atividade
                    </button>

                    <button class='btn btn-theme mar-top10 form-control' type='button'
                            onclick="modalApagar('#apagarPlanoAtividade', '<?=$plano['objetivo_especifico']?>', '<?=$plano['id']?>', 'apagaPlano')">
                        Remover Objetivo
                    </button>

                    <button class='btn btn-theme mar-top10 form-control' data-toggle="modal"
                            data-target="#novoObjetivo" data-btn="editaObjetivo" data-id="<?=$plano['id']?>">
                        Editar Objetivo
                    </button>
                </td>
            </tr>
            <?php
            if ($numAtividades > 0 && count($atividades) >= 1):
                foreach ($atividades as $atividade) {
                    ?>
                    <tr>
                        <td class="atividade"><?=$atividade['atividade']?></td>
                        <td class="responsavel"><?=$atividade['responsavel']?></td>
                        <td class="produto"><?=$atividade['produto']?></td>
                        <td class="prazo"><?=$atividade['prazo']?></td>
                        <td>
                            <button class="btn btn-sm btn-theme" data-toggle="modal" data-target="#novaAtividade"
                                    data-btn="editaAtividade" data-id="<?=$atividade['id']?>">
                                Editar Atividade
                            </button>
                        </td>
                        <td>
                            <button class='btn btn-sm btn-theme' type='button'
                                    onclick="modalApagar(
                                            '#apagarPlanoAtividade',
                                            '<?=$atividade['atividade']?>',
                                            '<?=$atividade['id']?>',
                                            'apagaAtividade')">Remover Atividade
                            </button>
                        </td>
                    </tr>
                    <?php
                }
            endif;
        }
        ?>
            </tbody>
        </table>
    <?php
    } else { ?>
        <div class="col-md-offset-2 col-md-8">
            <div class="alert alert-info">Não há registros cadastrados</div>
        </div>
    <?php
    }
}

if(isset($_POST['insereObjetivo']))
{
	$objetivo = addslashes($_POST['objetivo']);

	$sql_insere = "INSERT INTO planos (projeto_id, objetivo_especifico) VALUES ('$idProjeto', '$objetivo')";
	if(mysqli_query($con,$sql_insere))
	{
		$mensagem = "<font color='#01DF3A'><strong>Gravado com sucesso!</strong></font>";
		gravarLog($sql_insere);
	}
	else
	{
		$mensagem = "<font color='#FF0000'><strong>Erro ao gravar! Tente novamente.</strong></font>";
	}
}

if (isset($_POST['editaObjetivo'])) {
    $plano_id = $_POST['objetivo_id'];
    $objetivo = addslashes($_POST['objetivo']);

    $sql_insere = "UPDATE planos SET 
                    objetivo_especifico = '$objetivo'
                    WHERE id = '$plano_id'";
    if(mysqli_query($con,$sql_insere))
    {
        $mensagem = "<font color='#01DF3A'><strong>Atualizado com sucesso!</strong></font>";
        gravarLog($sql_insere);
    }
    else
    {
        $mensagem = "<font color='#FF0000'><strong>Erro ao gravar! Tente novamente.</strong></font>";
    }
}

if (isset($_POST['apagaObjetivo'])) {
    $plano_id = $_POST['apaga'];
    $atividades = $con->query("SELECT id FROM plano_atividades WHERE plano_id = '$plano_id'")->num_rows;

    if ($atividades > 0) {
        $sqlRemoveAtividades = "UPDATE plano_atividades SET publicado = '0' WHERE plano_id = '$plano_id'";
        if (mysqli_query($con, $sqlRemoveAtividades)) {
            $sqlRemoveObjetivo = "UPDATE planos SET publicado = '0' WHERE id = '$plano_id'";
            if (mysqli_query($con, $sqlRemoveObjetivo)) {
                $mensagem = "<font color='#01DF3A'><strong>Removido com sucesso!</strong></font>";
                gravarLog($sqlRemoveObjetivo);
            } else {
                $mensagem = "<font color='#FF0000'><strong>Erro ao gravar! Tente novamente.</strong></font>";
            }
        } else {
            $mensagem = "<font color='#FF0000'><strong>Erro ao gravar! Tente novamente.</strong></font>";
        }
    } else {
        $sqlRemoveObjetivo = "UPDATE planos SET publicado = '0' WHERE id = '$plano_id'";
        if (mysqli_query($con, $sqlRemoveObjetivo)) {
            $mensagem = "<font color='#01DF3A'><strong>Removido com sucesso!</strong></font>";
            gravarLog($sqlRemoveObjetivo);
        } else {
            $mensagem = "<font color='#FF0000'><strong>Erro ao gravar! Tente novamente.</strong></font>";
        }
    }
}

if(isset($_POST['insereAtividade']))
{
    $objetivo_id = addslashes($_POST['id']);
    $atividade = addslashes($_POST['atividade']);
    $responsavel = addslashes($_POST['responsavel']);
    $produto = addslashes($_POST['produto']);
    $prazo = addslashes($_POST['prazo']);

    $sql_insere = "INSERT INTO plano_atividades (plano_id, atividade, responsavel, produto, prazo)
                    VALUES ('$objetivo_id', '$atividade', '$responsavel', '$produto', '$prazo')";
    if(mysqli_query($con,$sql_insere))
    {
        $mensagem = "<font color='#01DF3A'><strong>Gravado com sucesso!</strong></font>";
        gravarLog($sql_insere);
    }
    else
    {
        $mensagem = "<font color='#FF0000'><strong>Erro ao gravar! Tente novamente.</strong></font>";
    }
}

if(isset($_POST['editaAtividade']))
{
    $atividade_id = addslashes($_POST['id']);
    $atividade = addslashes($_POST['atividade']);
    $responsavel = addslashes($_POST['responsavel']);
    $produto = addslashes($_POST['produto']);
    $prazo = addslashes($_POST['prazo']);

    $sql_insere = "UPDATE plano_atividades SET
                    atividade = '$atividade',
                    responsavel = '$responsavel',
                    produto = '$produto',
                    prazo = '$prazo'
                    WHERE id = '$atividade_id'";
    if(mysqli_query($con,$sql_insere))
    {
        $mensagem = "<font color='#01DF3A'><strong>Gravado com sucesso!</strong></font>";
        gravarLog($sql_insere);
    }
    else
    {
        $mensagem = "<font color='#FF0000'><strong>Erro ao gravar! Tente novamente.</strong></font>";
    }
}

if (isset($_POST['apagaAtividade'])) {
    $atividade_id = $_POST['apaga'];

    $sql_remove = "UPDATE plano_atividades SET 
                    publicado = '0'
                    WHERE id = '$atividade_id'";
    if(mysqli_query($con,$sql_remove))
    {
        $mensagem = "<font color='#01DF3A'><strong>Removido com sucesso!</strong></font>";
        gravarLog($sql_remove);
    }
    else
    {
        $mensagem = "<font color='#FF0000'><strong>Erro ao gravar! Tente novamente.</strong></font>";
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

                <div class="col-md-offset-2 col-md-8">
                    <label>Plano de Trabalho</label>
                    <div class="well">Aqui você deverá elencar de forma organizada as atividades a serem desenvolvidas para atingir cada objetivo específico elencado no item Objetivos a serem alcançados com o projeto, quanto tempo levará para executar cada uma delas e qual produto será entregue para confirmar a execução. O plano de trabalho ajuda você a se organizar quanto ao que deve fazer para realizar seu projeto e ajuda SMC a entender o que será realizado e entregue. O modelo de Plano de Trabalho se encontra no Anexo VII do Edital do PROMAC 2020</div>
                </div>

                <div class="col-md-offset-2 col-md-8">
                    <button type="button" class="btn btn-theme btn-lg btn-block"
                            data-toggle='modal' data-target='#novoObjetivo'>Inserir Novo Objetivo</button>
                </div>
            </div>
		</div>

        <div class="row">
            <br>
            <h4>Planos cadastrados</h4>
            <?php recuperaPlanos($idProjeto) ?>
        </div>
	</div>

    <!-- Inicio Modal Adiciona / Edita Plano -->
    <div class="modal fade" id="novoObjetivo" role="dialog" aria-labelledby="novoObjetivoLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Inserir novo Plano de Trabalho</h4>
                </div>
                <form method="POST" action="?perfil=plano_trabalho" role="form">
                    <div class="modal-body" style="text-align: left;">
                        <div class="form-group">
                            <label for="objetivo">Objetivo Específico</label>
                            <textarea name="objetivo" class="form-control" rows="5" id="objetivo" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                        <input type="hidden" name="objetivo_id" id="objetivo_id" value="">
                        <button type="submit" name="insereObjetivo" class="btn btn-theme" id="btnObjetivo">Gravar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Fim Modal Adiciona / Edita Plano -->

    <!-- Inicio Modal Adiciona / Edita Atividade -->
    <div class="modal fade" id="novaAtividade" role="dialog" aria-labelledby="novaAtividadeLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Inserir Nova Atividade</h4>
                </div>
                <form method="POST" action="?perfil=plano_trabalho" role="form">
                    <div class="modal-body" style="text-align: left;">
                        <div class="form-group">
                            <label for="atividade">Atividade:</label>
                            <textarea name="atividade" class="form-control" id="atividade" rows="5" required></textarea>
                        </div>

                        <div class="form-group">
                            <label for="resposavel">Responsável</label>
                            <input name="responsavel" class="form-control" type="text" id="responsavel" required>
                        </div>

                        <div class="form-group">
                            <label for="produto">Produto</label>
                            <textarea name="produto" class="form-control" rows="5" id="produto" required></textarea>
                        </div>

                        <div class="form-group">
                            <label for="prazo">Prazo</label>
                            <input name="prazo" class="form-control" type="text" id="prazo" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                        <input type="hidden" name="id" id="id" value="">
                        <button type="submit" name="insereAtividade" class="btn btn-theme" id="btnAtividade">Gravar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Fim Modal Adiciona / Edita Atividade -->

    <div class="modal fade" id="apagarPlanoAtividade" role="dialog" aria-labelledby="apagarPlanoAtividadeLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">
                        <p>Remover?</p>
                    </h4>
                </div>
                <div class="modal-body">
                    <p>Certeza?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                    <form method="POST" action="?perfil=plano_trabalho" role="form">
                        <input type="hidden" name="apaga" value="">
                        <button type="submit" name="" class="btn btn-danger" id="confirmApagar">Remover</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    function modalApagar(modal, nomeAtividade, id, nameBtn) {
        $(modal).find('.modal-title p').text('Remover "'+ nomeAtividade +'"?');
        $(modal).find('.modal-footer input').attr('value', id);
        $(modal).find('.modal-body p').text('Tem certeza que deseja remover "'+ nomeAtividade + '"?');
        $(modal).find('#confirmApagar').attr('name', nameBtn);
        $(modal).modal();
    }

    function atividadeEdita(classes, id, e) {
        jQuery.each(classes, function (key, val) {
            let texto = $(e).parent().parent().find('.'+val).text();
            $('#novaAtividade').find('#'+val).val(texto);
        });
        $('#novaAtividade').find('.modal-title').text('Editar Atividade');
        $('#novaAtividade').find('#id').attr('value', id);
        $('#novaAtividade').find('#btnAtividade').attr('name', 'editaAtividade');
    }

    $('#novaAtividade').on('show.bs.modal', function (e) {
        let classes = ['atividade', 'responsavel', 'produto', 'prazo'];
        let btnName = $(e.relatedTarget).data('btn');
        let id = $(e.relatedTarget).data('id');
        if (btnName === "editaAtividade") {
            atividadeEdita(classes, id, $(e.relatedTarget))
        } else {
            jQuery.each(classes, function (key, val) {
                $('#novaAtividade').find('#'+val).val("");
            });
            $(this).find('.modal-title').text('Insere Nova Atividade');
            $(this).find('#id').attr('value', id);
            $(this).find('#btnAtividade').attr('name', 'insereAtividade');
        }
    });

    $('#novoObjetivo').on('show.bs.modal', function (e) {
        let btnName = $(e.relatedTarget).data('btn');
        let id = $(e.relatedTarget).data('id');
        if (btnName === "editaObjetivo") {
            let texto = $(e.relatedTarget).parent().parent().find('.objetivo').text();
            $('#novoObjetivo').find('#objetivo').val(texto);
            $(this).find('.modal-title').text('Edita Objetivo');
            $(this).find('#objetivo_id').attr('value', id);
            $(this).find('#btnObjetivo').attr('name', 'editaObjetivo');
        } else {
            $('#novoObjetivo').find('#objetivo').val("");
            $(this).find('.modal-title').text('Insere Novo Objetivo');
            $(this).find('#objetivo_id').attr('value', id);
            $(this).find('#btnObjetivo').attr('name', 'insereObjetivo');
        }
    });
</script>