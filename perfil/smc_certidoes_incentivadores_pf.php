<?php
$con = bancoMysqli();
$tipoPessoa = '3';
$idPf = $_POST['idPf'];
$pf = recuperaDados("incentivador_pessoa_fisica", "idPf", $idPf);

if(isset($_POST['atualizar']))
{
    // // array com os inputs
    $dados = $_POST['dado'];

    //atualiza todos os campos
    foreach ($dados as $dado) {

        $query = "UPDATE upload_arquivo SET idStatusDocumento = '".$dado['status']."', observacoes = '".$dado['observ']."' WHERE idUploadArquivo = '".$dado['idArquivo']."' ";
        $envia = mysqli_query($con, $query);
        if($envia)
        {
            $mensagem = "<font color='#01DF3A'><strong>Os arquivos foram atualizados com sucesso!</strong></font>";
            gravarLog($query);
        }
        else
        {
            echo "<script>alert('Erro durante o processamento, entre em contato com os responsáveis pelo sistema para maiores informações.')</script>";
            echo "<script>window.location.href = 'index_pf.php?perfil=smc_index';</script>";
        }
    }
}

if(isset($_POST['nota']))
{
    if($_POST['nota'] != "")
    {
        $id = $_POST['idPf'];
        if ($id != 0)
        {
            $dateNow = date('Y-m-d H:i:s');
            $nota = addslashes($_POST['nota']);
            $sql_nota = "INSERT INTO notas (idPessoa, idTipo, data, nota, interna) VALUES ('$id', '3', '$dateNow', '$nota', '1')";
            if(mysqli_query($con,$sql_nota))
            {
                $mensagem .= "<br><font color='#01DF3A'><strong>Nota inserida com sucesso!</strong></font>";
                gravarLog($sql_nota);
            }
            else
            {
                $mensagem .= "<br><font color='#FF0000'><strong>Erro ao inserir nota! Tente novamente.</strong></font>";
            }
        }
    }
}


function listaArquivosPessoaEditorr($idPessoa,$tipoPessoa)
{
    $con = bancoMysqli();
    $sql = "SELECT *
			FROM lista_documento as list
			INNER JOIN upload_arquivo as arq ON arq.idListaDocumento = list.idListaDocumento
			WHERE arq.idPessoa = '$idPessoa'
			AND arq.idListaDocumento IN (39, 40, 41, 42, 43, 53)
			AND arq.idTipo = '$tipoPessoa'
			AND arq.publicado = '1'";
    $query = mysqli_query($con,$sql);
    $linhas = mysqli_num_rows($query);

    if ($linhas > 0)
    {
        echo "
		<table class='table table-condensed'>
			<thead>
				<tr class='list_menu'>
					<td>Tipo de arquivo</td>
					<td>Nome do arquivo</td>
					<td>Status</td>
					<td>Observações</td>
					<td>Ação</td>
				</tr>
			</thead>
			<tbody>";
        echo "<form id='atualizaDoc' method='POST' action='?perfil=smc_certidoes_incentivadores_pf'>";
        $count = 0;
        while($arquivo = mysqli_fetch_array($query))
        {
            echo "<tr>";
            echo "<td class='list_description'>(".$arquivo['documento'].")</td>";
            echo "<td class='list_description'><a href='../uploadsdocs/".$arquivo['arquivo']."' target='_blank'>". mb_strimwidth($arquivo['arquivo'], 15 ,25,"..." )."</a></td>";
            $queryy = "SELECT idStatusDocumento FROM upload_arquivo WHERE idUploadArquivo = '".$arquivo['idUploadArquivo']."'";
            $send = mysqli_query($con, $queryy);
            $row = mysqli_fetch_array($send);

            echo "<td class='list_description'>
							<select class='colorindo' name='dado[$count][status]' id='statusOpt' value='teste'>";
            echo "<option value=''>Selecione</option>";
            geraOpcao('status_documento', $row['idStatusDocumento']);
            echo " </select>
						</td>";
            $queryOBS = "SELECT observacoes FROM upload_arquivo WHERE idUploadArquivo = '".$arquivo['idUploadArquivo']."'";
            $send = mysqli_query($con, $queryOBS);
            $row = mysqli_fetch_array($send);
            echo "<td class='list_description'>
					<input type='text' name='dado[$count][observ]' maxlength='100' id='observ' value='".$row['observacoes']."'/>
					</td>";


            echo "
						<td class='list_description'>
								<input type='hidden' name='dado[$count][idPessoa]' value='$idPessoa' />
								<input type='hidden' name='dado[$count][idArquivo]' value='".$arquivo['idUploadArquivo']."' />								
								";
            echo "</tr>";
            $count++;
        }
        echo "
		</tbody>
		</table>";
        echo "<input type='hidden' name='idPf' class='btn btn-theme btn-lg' value='$idPessoa'>";
        echo "<input type='submit' name='atualizar' class='btn btn-theme btn-lg' value='Gravar análise'><br>";
        echo "</form>";
    }
    else
    {
        echo "<p>Não há arquivo(s) inserido(s).<p/><br/>";
    }
}
?>

<section id="list_items" class="home-section bg-white">
    <div class="container"><?php include 'includes/menu_smc.php'; ?>
        <div class="form-group">
            <h4>Resumo do Usuário</h4>
            <div class="alert alert-warning">
                <strong>Atenção!</strong> Confirme atentamente se os dados abaixo estão corretos!
            </div>
        </div>
        <div class = "page-header">
            <h5>Dados do proponente
                <?php
                if(isset($mensagem))
                {
                    echo "<br>";
                    echo $mensagem;
                }
                ?>
            </h5>
        </div>
        <div class="well">
            <p align="justify"><strong>Nome:</strong> <?php echo isset($pf['nome']) ? $pf['nome'] .$pf['idPf'] : null; ?></p>
            <p align="justify"><strong>CPF:</strong> <?php echo isset($pf['cpf']) ? $pf['cpf'] : null; ?><p>
            <p align="justify"><strong>RG:</strong> <?php echo isset($pf['rg']) ? $pf['rg'] : null; ?><p>
            <p align="justify"><strong>Telefone:</strong> <?php echo isset($pf['telefone']) ? $pf['telefone'] : null; ?></p>
            <p align="justify"><strong>Celular:</strong> <?php echo isset($pf['celular']) ? $pf['celular'] : null; ?></p>
            <p align="justify"><strong>Email:</strong> <?php echo isset($pf['email']) ? $pf['email'] : null; ?></p>

            <p align="justify"><strong>Cooperado:</strong>
                <?php
                if(isset($pf['cooperado'])){
                    if($pf['cooperado'] == 1){
                        echo "Sim";
                    }else {
                        echo "Não";
                    }
                }
                ?>
            </p>

            <p align="justify"><strong>Logradouro:</strong> <?php echo isset($pf['logradouro']) ? $pf['logradouro'] : null; ?></p>
            <p align="justify"><strong>Número:</strong> <?php echo isset($pf['numero']) ? $pf['numero'] : null; ?></p>
            <p align="justify"><strong>Complemento:</strong> <?php echo isset($pf['complemento']) ? $pf['complemento'] : null; ?></p>
            <p align="justify"><strong>Bairro:</strong> <?php echo isset($pf['bairro']) ? $pf['bairro'] : null; ?></p>
            <p align="justify"><strong>Cidade:</strong> <?php echo isset($pf['cidade']) ? $pf['cidade'] : null; ?></p>
            <p align="justify"><strong>Estado:</strong> <?php echo isset($pf['estado']) ? $pf['estado'] : null; ?></p>
            <p align="justify"><strong>CEP:</strong> <?php echo isset($pf['cep']) ? $pf['cep'] : null; ?></p>
            <p align="justify"><strong>Data da Inscrição:</strong> <?php echo isset($pf['dataInscricao']) ? exibirDataHoraBr($pf['dataInscricao']) : null; ?></p>
        </div>
        <div class="table-responsive list_info"><h6>Certidões de Regularidade Fiscal</h6>
            <?php
                listaArquivosPessoaEditorr($pf['idPf'],'3');
            ?>
        </div>
    </div>
        <div class="container">
            <form method="POST" action="?perfil=smc_visualiza_perfil_pf" class="form-horizontal" role="form">
                <div class='col-md-offset-2 col-md-8'>
                    <div class='form-group'>
                        <ul class='list-group'>
                            <li class='list-group-item list-group-item-success'>Notas</li>
                            <?+ listaNota($idPf,1,1) ?>
                        </ul>
                    </div>
                    <div class='row'>
                        <div class='form-group'>
                            <div class='col-md-offset-2 col-md-8'><label>Notas</label><br/>
                                <input type='text' class='form-control' name='nota'>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class='col-md-offset-4 col-md-2'>
                        <!-- Button para ativar modal -->
                        <input type='hidden' name='idPf' value='<?php echo $pf['idPf'] ?>' />
                        <input type='submit' name='inapto' value='INAPTO' class='btn btn-theme btn-lg btn-block'>
                    </div>
                    <div class='col-md-2'>
                        <input type='hidden' name='idPf' value='<?php echo $pf['idPf'] ?>' />
                        <input type='submit' name='apto' value='APTO' class='btn btn-theme btn-lg btn-block'>
                    </div>
                </div>
            </form>
        </div>
</section>

<script>

    let statusAll = document.querySelectorAll(".colorindo")

    for (let status of statusAll) {

        if (status.options[status.selectedIndex].value == "") {
            status.style.backgroundColor = "#fdff72"
        }
    }

    for (let status of statusAll) {

        status.addEventListener("change", () => {
            if (status.options[status.selectedIndex].value == "") {
                status.style.backgroundColor = "#fdff72"
            } else {
                status.style.backgroundColor = "#F0F0E9"
            }
        })
    }

</script>



