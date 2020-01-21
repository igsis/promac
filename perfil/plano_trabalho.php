<?php
$con = bancoMysqli();
$idProjeto = $_SESSION['idProjeto'];

function recuperaPlanos($idProjeto) {
    $con = bancoMysqli();
    $queryPlano = $con->query("SELECT * FROM plano_trabalhos WHERE projeto_id = '$idProjeto' AND publicado = '1'");
    if ($queryPlano->num_rows > 0) {
        $planos = $queryPlano->fetch_all(MYSQLI_ASSOC);
        foreach ($planos as $plano) { ?>
            <tr>
                <form method="POST" action="?perfil=plano_trabalho" role="form">
                    <td><textarea name="objetivo" class="form-control" rows="5" required><?=$plano['objetivo_especifico']?></textarea></td>
                    <td><textarea name="atividade" class="form-control" rows="5" required><?=$plano['atividade']?></textarea></td>
                    <td><textarea name="produto" class="form-control" rows="5" required><?=$plano['produto']?></textarea></td>
                    <td><input class="form-control" type="text" name="prazo" value="<?=$plano['prazo']?>"></td>
                    <td>
                        <input type="hidden" name="plano_id" value="<?=$plano['id']?>">
                        <input class="btn btn-theme" type="submit" name="edita" value="Editar">
                    </td>
                </form>
                    <td>
                        <form method="POST" action="?perfil=plano_trabalho" role="form">
                            <input type="hidden" name="apaga" value="<?= $plano['id'] ?>">
                            <button class='btn btn-theme' type='button' data-toggle='modal'
                                    data-target='#confirmApagar' data-title="Remover plano cadastrado?" data-message="Deseja realmente remover este plano?">Remover</button>
                        </form>
                    </td>
            </tr>
        <?php
        }
    } else { ?>
        <tr>
            <td colspan="6" class="text-center"><div class="alert alert-info">Não há registros cadastrados</div></td>
        </tr>
    <?php
    }
}

if(isset($_POST['insere']))
{
	$objetivo = addslashes($_POST['objetivo']);
	$atividade = addslashes($_POST['atividade']);
	$produto = addslashes($_POST['produto']);
	$prazo = addslashes($_POST['prazo']);

	$sql_insere = "INSERT INTO plano_trabalhos (projeto_id, objetivo_especifico, atividade, produto, prazo)
                    VALUES ('$idProjeto', '$objetivo', '$atividade', '$produto', '$prazo')";
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

if (isset($_POST['edita'])) {
    $plano_id = $_POST['plano_id'];
    $objetivo = addslashes($_POST['objetivo']);
    $atividade = addslashes($_POST['atividade']);
    $produto = addslashes($_POST['produto']);
    $prazo = addslashes($_POST['prazo']);

    $sql_insere = "UPDATE plano_trabalhos SET 
                    objetivo_especifico = '$objetivo',
                    atividade = '$atividade',
                    produto = '$produto',
                    prazo = '$prazo'
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

if (isset($_POST['apaga'])) {
    $plano_id = $_POST['apaga'];

    $sql_remove = "UPDATE plano_trabalhos SET 
                    publicado = '0'
                    WHERE id = '$plano_id'";
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
                            data-toggle='modal' data-target='#novoPlano'>Inserir Novo</button>
                </div>
            </div>
		</div>

        <div class="row">
            <div class="col-md-offset-1 col-md-10">
                <br>
                <h4>Planos cadastrados</h4>

                <table class="table table-condensed table-responsive">
                    <thead>
                    <tr>
                        <th>Objetivo Específico</th>
                        <th>Atividade</th>
                        <th>Produto a ser apresentado</th>
                        <th width="15%">Prazo</th>
                        <th width="10%"></th>
                        <th width="10%"></th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php recuperaPlanos($idProjeto); ?>
                    </tbody>
                </table>
            </div>
        </div>
	</div>
    <!-- Inicio Modal Adiciona Plano -->
    <div class="modal fade" id="novoPlano" role="dialog" aria-labelledby="novoPlanoLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Inserir novo Plano de Trabalho</h4>
                </div>
                <form method="POST" action="?perfil=plano_trabalho" role="form">
                    <div class="modal-body" style="text-align: left;">
                        <table class="table table-condensed">
                            <thead>
                            <tr>
                                <th>Objetivo Específico</th>
                                <th>Atividade</th>
                                <th>Produto a ser apresentado</th>
                                <th>Prazo</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td><textarea name="objetivo" class="form-control" rows="5" required></textarea></td>
                                <td><textarea name="atividade" class="form-control" rows="5" required></textarea></td>
                                <td><textarea name="produto" class="form-control" rows="5" required></textarea></td>
                                <td><input class="form-control" type="text" name="prazo"></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                        <button type="submit" name="insere" class="btn btn-theme">Gravar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Fim Modal Adiciona Plano -->

    <div class="modal fade" id="confirmApagar" role="dialog" aria-labelledby="confirmApagarLabel" aria-hidden="true">
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
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger" id="confirm">Remover</button>
                </div>
            </div>
        </div>
    </div>
</section>