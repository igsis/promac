<?php
$con = bancoMysqli();
$tipoPessoa = '4';
$idPj = $_POST['idPj'];
$pj = recuperaDados("incentivador_pessoa_juridica", "idPj", $idPj);

if (isset($_POST['atualizar'])) {
    // // array com os inputs
    $dados = $_POST['dado'];

    //atualiza todos os campos
    foreach ($dados as $dado) {
        if (isset($dado['observ'])) {
            $observacao = $dado['observ'];
        } else {
            $observacao = '';
        }

        $query = "UPDATE upload_arquivo SET idStatusDocumento = '" . $dado['status'] . "', observacoes = '$observacao' WHERE idUploadArquivo = '" . $dado['idArquivo'] . "' ";
        $envia = mysqli_query($con, $query);
        if ($envia) {
            $mensagem = "<font color='#01DF3A'><strong>Os status dos arquivos foram atualizados com sucesso!</strong></font>";
            gravarLog($query);
        } else {
            echo "<script>alert('Erro durante o processamento, entre em contato com os responsáveis pelo sistema para maiores informações.')</script>";
            echo "<script>window.location.href = 'index_pj.php?perfil=smc_index';</script>";
        }
    }
}

if (isset($_POST['nota'])) {
    if ($_POST['nota'] != "") {
        $id = $_POST['idPj'];
        if ($id != 0) {
            $dateNow = date('Y-m-d H:i:s');
            $nota = addslashes($_POST['nota']);
            $sql_nota = "INSERT INTO notas (idPessoa, idTipo, data, nota, interna) VALUES ('$idPj', '4', '$dateNow', '$nota', '1')";
            if (mysqli_query($con, $sql_nota)) {
                $mensagem = "<br><font color='#01DF3A'><strong>Nota inserida com sucesso!</strong></font>";
                gravarLog($sql_nota);
            } else {
                $mensagem = "<br><font color='#FF0000'><strong>Erro ao inserir nota! Tente novamente.</strong></font>";
            }
        }
    }
}

if (isset($_POST['apto'])) {
    $sql = "UPDATE incentivador_pessoa_juridica SET liberado = '5' WHERE idPj = $idPj";
    $sql_etapa = "UPDATE etapas_incentivo SET etapa = 4 WHERE idIncentivador = $idPj AND tipoPessoa = '$tipoPessoa'";
    $apto = mysqli_query($con, $sql);
    $prox_etapa = mysqli_query($con, $sql_etapa);

    if ($apto && $prox_etapa) {
        if (isset($mensagem)) {
            $mensagem .= "<br><font color='#01DF3A'><strong>Incentivador classificado como APTO!</strong></font>";
        } else {
            $mensagem = "<br><font color='#01DF3A'><strong>Incentivador classificado como APTO!</strong></font>";
        }
        gravarLog($sql);
    } else {
        if (isset($mensagem)) {
            $mensagem .= "<br><font color='#FF0000'><strong>Erro ao deixar o incentivador APTO! Tente novamente.</strong></font>";
        } else {
            $mensagem = "<br><font color='#FF0000'><strong>Erro ao deixar o incentivador APTO! Tente novamente.</strong></font>";
        }

    }
}

if (isset($_POST['inapto'])) {
    $sql = "UPDATE incentivador_pessoa_juridica SET liberado = 6 WHERE idPj = '$idPj'";
    $sql_etapa = "UPDATE etapas_incentivo SET etapa = 3 WHERE idIncentivador = $idPj AND tipoPessoa = '$tipoPessoa'";

    if (mysqli_query($con, $sql)) {
        if (isset($mensagem)) {
            $mensagem .= "<br><font color='#01DF3A'><strong>Incentivador classificado como INAPTO!</strong></font>";
        } else {
            $mensagem = "\"<br><font color='#01DF3A'><strong>Incentivador classificado como INAPTO!</strong></font>\"";
        }
        gravarLog($sql);
    } else {
        if (isset($mensagem)) {
            $mensagem .= "<br><font color='#FF0000'><strong>Erro ao deixar o incentivador INAPTO! Tente novamente.</strong></font>";
        } else {
            $mensagem = "<br><font color='#FF0000'><strong>Erro ao deixar o incentivador INAPTO! Tente novamente.</strong></font>";
        }
    }
}

function listaArquivosPessoaEditorr($idPessoa, $tipoPessoa)
{
    $con = bancoMysqli();
    $sql = "SELECT *
			FROM lista_documento as list
			INNER JOIN upload_arquivo as arq ON arq.idListaDocumento = list.idListaDocumento
			WHERE arq.idPessoa = '$idPessoa'
			AND arq.idListaDocumento IN (39, 40, 41, 42, 43, 54)
			AND arq.idTipo = '$tipoPessoa'
			AND arq.publicado = '1'";
    $query = mysqli_query($con, $sql);
    $linhas = mysqli_num_rows($query);

    if ($linhas > 0) {
        echo "
		<table class='table table-condensed table-striped text-center'>
			<thead>
				<tr class='list_menu'>
					<td>Tipo de arquivo</td>
					<td>Nome do arquivo</td>
					<td>Status</td>
					<td>Observações</td>
				</tr>
			</thead>
			<tbody>";
        echo "<form id='atualizaDoc' method='POST' action='?perfil=smc_certidoes_incentivadores_pj'>";
        $count = 0;
        while ($arquivo = mysqli_fetch_array($query)) {
            echo "<tr>";
            echo "<td class='list_description'>(" . $arquivo['documento'] . ")</td>";
            echo "<td class='list_description'><a href='../uploadsdocs/" . $arquivo['arquivo'] . "' target='_blank'>" . mb_strimwidth($arquivo['arquivo'], 15, 25, "...") . "</a></td>";
            $queryy = "SELECT idStatusDocumento FROM upload_arquivo WHERE idUploadArquivo = '" . $arquivo['idUploadArquivo'] . "'";
            $send = mysqli_query($con, $queryy);
            $row = mysqli_fetch_array($send);

            echo "<td class='list_description'>
							<select class='colorindo' onchange='colorindo()' name='dado[$count][status]' id='statusOpt' value='teste'>";
            echo "<option value=''>Selecione</option>";
            geraOpcao('status_documento', $row['idStatusDocumento']);
            echo " </select>
						</td>";
            $queryOBS = "SELECT observacoes FROM upload_arquivo WHERE idUploadArquivo = '" . $arquivo['idUploadArquivo'] . "'";
            $send = mysqli_query($con, $queryOBS);
            $row = mysqli_fetch_array($send);
            echo "<td class='list_description'>
					<input type='text' name='dado[$count][observ]' maxlength='100' disabled id='observ' value='" . $row['observacoes'] . "'/>
					</td>";

            echo "
						
								<input type='hidden' name='dado[$count][idPessoa]' value='$idPessoa' />
								<input type='hidden' name='dado[$count][idArquivo]' value='" . $arquivo['idUploadArquivo'] . "' />								
								";
            echo "</tr>";
            $count++;
        }
        echo "
		</tbody>
		</table>";
        echo "<input type='hidden' name='idPj' class='btn btn-theme btn-lg' value='$idPessoa'>";
        echo "<input type='submit' name='atualizar' class='btn btn-theme btn-lg' value='Gravar análise'><br><br>";
        echo "</form>";
    } else {
        echo "<p>Não há arquivo(s) inserido(s).<p/><br/>";
    }
}

?>

<section id="list_items" class="home-section bg-white">
    <div class="container"><?php include 'includes/menu_smc.php'; ?>
        <ul class="nav nav-tabs">
            <li class="nav active"><a href="#admIncentivador" data-toggle="tab">Administrativo SMC</a></li>
            <li class="nav"><a href="#resumo" data-toggle="tab">Resumo do cadastro</a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade" id="resumo">
                <?php
                include 'includes/resumo_dados_incentivador_pj.php';
                ?>
            </div>
            <div class="tab-pane fade in active" id="admIncentivador">
                <div class="table-responsive list_info"><h4>Certidões de Regularidade Fiscal</h4>

                    <div class="row">
                        <h5><?php if (isset($mensagem)) {
                                echo $mensagem;
                            }; ?></h5>
                    </div>
                    <br>
                    <?php
                    listaArquivosPessoaEditorr($pj['idPj'], '4');
                    ?>
                </div>
                <div class="container">
                    <div class='col-md-offset-2 col-md-8'>
                        <div class='form-group'>
                            <ul class='list-group'>
                                <li class='list-group-item list-group-item-success'>Notas</li>
                                <?php listaNota($idPj, $tipoPessoa, 1) ?>
                            </ul>
                        </div>
                    </div>
                    <form method="POST" action="?perfil=smc_certidoes_incentivadores_pj" class="form-horizontal"
                          role="form">
                        <div class='row'>
                            <div class='form-group'>
                                <div class='col-md-offset-2 col-md-8'><label>Notas</label><br/>
                                    <input type='text' class='form-control' name='nota'>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class='col-md-offset-4 col-md-2'>
                                <!-- Button para ativar modal -->
                                <input type='hidden' name='idPj' value='<?php echo $pj['idPj'] ?>'/>
                                <input type='submit' name='inapto' value='INAPTO'
                                       class='btn btn-danger btn-lg btn-block'>
                            </div>
                            <div class='col-md-2'>
                                <input type='hidden' name='idPj' value='<?php echo $pj['idPj'] ?>'/>
                                <input type='submit' name='apto' value='APTO' class='btn btn-success btn-lg btn-block'>
                            </div>
                        </div>
                    </form>
                    <br>
                    <div class="col-md-offset-2 col-md-8">
                        <a href="../include/arquivos_pessoa.php?idPessoa=<?php echo $pj['idPj'] ?>&tipo=<?php echo $tipoPessoa ?>"
                           class="btn btn-theme btn-md btn-block" target="_blank">Baixar todos os arquivos do
                            incentivador</a>
                    </div>
                </div>
            </div>
        </div>
</section>

<script>

    window.onload = colorindo;

    function colorindo() {

        let statusAll = document.querySelectorAll(".colorindo");

        for (let status of statusAll) {
            if (status.options[status.selectedIndex].value == "") {
                status.style.backgroundColor = "#fdff72"
            }
        }

        let observacoes = document.querySelectorAll("#observ");
        var i = 0;

        for (let status of statusAll) {
            let id = status.name.substr(5, 1);
            if (status.options[status.selectedIndex].value == "") {
                status.style.backgroundColor = "#fdff72"
                observacoes[id].disabled = true;

            } else if (status.options[status.selectedIndex].value == 3) {
                status.style.backgroundColor = "#F0F0E9"
                observacoes[id].disabled = false;

            } else if (status.options[status.selectedIndex].value == 1) {
                status.style.backgroundColor = "#F0F0E9"
                observacoes[id].disabled = true;
            }
            i++;
        }
    }

</script>