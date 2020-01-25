<?php
$con = bancoMysqli();
$idProjeto = $_SESSION['idProjeto'];

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
    $etapa = addslashes($_POST['etapa']);

    $sql_insere = "INSERT INTO plano_atividades (plano_id, atividade, responsavel, produto, etapa_planos_id)
                    VALUES ('$objetivo_id', '$atividade', '$responsavel', '$produto', '$etapa')";
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
    $etapa = addslashes($_POST['etapa']);

    $sql_insere = "UPDATE plano_atividades SET
                    atividade = '$atividade',
                    responsavel = '$responsavel',
                    produto = '$produto',
                    etapa_planos_id = '$etapa'
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
                    <div class="well">
                        As atividades devem dialogar com os objetivos específicos do projeto, ou seja, você deve
                        descrever as atividades que serão executadas para que o objetivo específico seja alcançado.
                        O produto indica o resultado da atividade realizada, o material ou documentação que será
                        apresentado como comprovação da realização da atividade. A etapa deve indicar em qual fase do
                        projeto se realizará a atividade (fase de pré-produção, produção ou pós-produção).
                    </div>
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
            <?php recuperaPlanos($idProjeto, true) ?>
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
                            <select class="form-control" name="etapa" id="etapa" required>
                                <option value="">Selecione uma opção...</option>
                                <?php geraOpcao('etapa_planos', ''); ?>
                            </select>
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
        let classes = ['atividade', 'responsavel', 'produto'];
        let btnName = $(e.relatedTarget).data('btn');
        let etapa = $(e.relatedTarget).data('etapa');
        let id = $(e.relatedTarget).data('id');
        if (btnName === "editaAtividade") {
            atividadeEdita(classes, id, $(e.relatedTarget));
            $('#etapa option').removeAttr('selected');
            $('#etapa').val(etapa);
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