<?php
$con = bancoMysqli();

$idProjeto = $_POST['idProjeto'];
$projeto = recuperaDados("projeto","idProjeto",$idProjeto);

if($projeto['tipoPessoa'] == 1)
{
	$pessoaFisica = recuperaDados("pessoa_fisica","idPf",$projeto['idPf']);
}
else
{
	$pj = recuperaDados("pessoa_juridica","idPj",$projeto['idPj']);
    $representante = pegaProjetoRepresentante($idProjeto);
}

$prazos = recuperaDados("prazos_projeto","idProjeto",$idProjeto);
$area = recuperaDados("area_atuacao","idArea",$projeto['idAreaAtuacao']);
$renuncia = recuperaDados("renuncia_fiscal","idRenuncia",$projeto['idRenunciaFiscal']);
$cronograma = recuperaDados("cronograma","idCronograma",$projeto['idCronograma']);
$video = recuperaDados("projeto","idProjeto",$idProjeto);
$v = array($video['video1'], $video['video2'], $video['video3']);
?>
<section id="list_items" class="home-section bg-white">
	<div class="container">
		<div class="row">
			<div class="form-group">
				<div class="col-md-offset-2 col-md-6">
					<form method="POST" action="../visual/index.php" class="form-horizontal" role="form">
						<input type="hidden" name="consulta" value="1">
						<button class='btn btn-theme btn-md btn-block' align= "center" type='submit' style="border-radius: 30px;">Fazer outra busca</button>
					</form>
				</div>

				<div class="col-md-6">
					<form method="POST" action="../index.php" class="form-horizontal" role="form">
						<input type="hidden" value="1">
						<button class='btn btn-theme btn-md btn-block' align= "center" type='submit' style="border-radius: 30px;">Voltar a tela de login</button>
					</form>
				</div>
			</div>
		</div>
	</div>
		<div class="form-group">
			<h4>Detalhes do Projeto: <small><?= $projeto['nomeProjeto'] ?></small></h4>
		</div>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<div role="tabpanel">
					<!-- LABELS -->
					<ul class="nav nav-tabs">
						<li class="nav active"><a href="#projeto" data-toggle="tab">Resumo do Projeto</a></li>
                        <?php if($projeto['tipoPessoa'] == 2):  ?>
                            <li class="nav"><a href="#J" data-toggle="tab">Pessoa Jurídica</a></li>
                        <?php else: ?>
                            <li class="nav"><a href="#F" data-toggle="tab">Pessoa Física</a></li>
                        <?php endif ?>
					</ul>

					<div class="tab-content">
						<!-- LABEL PROJETO -->
						<div role="tabpanel" class="tab-pane fade in active" id="projeto" align="left">
							<br>
                            <table class="table table-bordered">
                                <tr>
                                    <td>
                                        <strong>Protocolo (nº ISP):</strong>
                                        <span data-mask = "0000.00.00/0000000"><?= $projeto['protocolo'] ?></span>
                                    </td>
                                    <td><strong>Tipo:</strong>
                                        <?php
                                        if ($projeto['tipoPessoa'] == 1) {
                                            echo "Pessoa Física";
                                        } else {
                                            echo "Pessoa Jurídica";
                                        } ?>
                                    </td>
                                    <?php
                                    if ($projeto['tipoPessoa'] == 1) { ?>
                                        <td><strong>Cooperado:</strong>
                                            <?php
                                            if ($pf['cooperado'] == 1) {
                                                echo "Sim";
                                            } else {
                                                echo "Não";
                                            } ?>
                                        </td>
                                    <?php } else { ?>
                                        <td><strong>Cooperativa:</strong>
                                            <?php
                                            if ($pj['cooperativa'] == 1) {
                                                echo "Sim";
                                            } else {
                                                echo "Não";
                                            } ?>
                                        </td>
                                    <?php } ?>
                                </tr>
                                <tr>
                                    <td><strong>Valor do projeto:</strong> R$
                                        <?php echo
                                        dinheiroParabr(isset($projeto['valorProjeto'])
                                            ? $projeto['valorProjeto']
                                            : ''); ?>
                                    </td>
                                    <td><strong>Valor do incentivo:</strong> R$
                                        <?php echo
                                        dinheiroParabr(isset($projeto['valorIncentivo'])
                                            ? $projeto['valorIncentivo']
                                            : null); ?>
                                    </td>
                                    <td><strong>Valor do financiamento:</strong> R$
                                        <?php echo dinheiroParabr(isset($projeto['valorFinanciamento'])
                                            ? $projeto['valorFinanciamento']
                                            : null); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Área de atuação:</strong>
                                        <?php echo $area['areaAtuacao'] ?>
                                    </td>
                                    <td><strong>Valor aprovado:</strong>
                                        <?= isset($projeto['valorAprovado']) ? 'R$ '.dinheiroParabr($projeto['valorAprovado']) : null; ?>
                                    </td>
                                    <td><strong>Renúncia Fiscal:</strong>
                                        <?php echo $renuncia['renunciaFiscal'] ?>
                                    </td>
                                </tr>
                                <?php
                                if ($projeto['idAreaAtuacao'] == 22) {
                                    ?>
                                    <tr>
                                        <td colspan="3"><strong>Segmento:</strong>
                                            <?php echo isset($projeto['segmento']) ? $projeto['segmento'] : null; ?>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                                <tr>
                                    <td colspan="3"><strong>Nome do Projeto:</strong>
                                        <?php echo isset($projeto['nomeProjeto']) ? $projeto['nomeProjeto'] : null; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3"><strong>Exposição da Marca:</strong>
                                        <?php echo isset($projeto['exposicaoMarca']) ? $projeto['exposicaoMarca'] : null; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3"><strong>Resumo do projeto:</strong>
                                        <?php echo isset($projeto['resumoProjeto']) ? $projeto['resumoProjeto'] : null; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3"><strong>Currículo:</strong>
                                        <?php echo isset($projeto['curriculo']) ? $projeto['curriculo'] : null; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3"><strong>Descrição:</strong>
                                        <?php echo isset($projeto['descricao']) ? $projeto['descricao'] : null; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3"><strong>Justificativa:</strong>
                                        <?php echo isset($projeto['justificativa']) ? $projeto['justificativa'] : null; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3"><strong>Objetivo:</strong>
                                        <?php echo isset($projeto['objetivo']) ? $projeto['objetivo'] : null; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3"><strong>Contrapartida:</strong>
                                        <?php echo isset($projeto['contrapartida']) ? $projeto['contrapartida'] : null; ?>
                                    </td>
                                </tr>
                            </table>
                            <ul class="list-group">
                                <li class="list-group-item list-group-item-success"><b>Local</b></li>
                                <li class="list-group-item">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th>Local</th>
                                            <th>Público estimado</th>
                                            <th>Zona</th>
                                        </tr>
                                        <?php
                                        $sql = "SELECT * FROM locais_realizacao WHERE publicado = 1 AND idProjeto = " . $projeto['idProjeto'];
                                        $query = mysqli_query($con, $sql);
                                        while ($campo = mysqli_fetch_array($query)) {
                                            $zona = recuperaDados("zona", "idZona", $campo['idZona']);
                                            echo "<tr>";
                                            echo "<td>" . $campo['local'] . "</td>";
                                            echo "<td>" . $campo['estimativaPublico'] . "</td>";
                                            echo "<td>" . $zona['zona'] . "</td>";
                                            echo "</tr>";
                                        }
                                        ?>
                                    </table>
                                </li>
                            </ul>
                            <table class="table table-bordered">
                                <tr>
                                    <td colspan="3"><strong>Público alvo:</strong>
                                        <?php echo isset($projeto['publicoAlvo']) ? $projeto['publicoAlvo'] : null; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3"><strong>Plano de divulgação:</strong>
                                        <?php echo isset($projeto['planoDivulgacao']) ? $projeto['planoDivulgacao'] : null; ?>
                                    </td>
                                </tr>
                            </table>

                            <ul class="list-group">
                                <li class="list-group-item list-group-item-success"><b>Ficha Técnica</b></li>
                                <li class="list-group-item">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th>Nome</th>
                                            <th>CPF</th>
                                            <th>Função</th>
                                        </tr>
                                        <?php
                                        $sql = "SELECT * FROM ficha_tecnica WHERE publicado = 1 AND idProjeto = '$idProjeto'";
                                        $query = mysqli_query($con, $sql);
                                        while ($campo = mysqli_fetch_array($query)) {
                                            echo "<tr>";
                                            echo "<td class='list_description'>" . $campo['nome'] . "</td>";
                                            echo "<td class='list_description'>" . $campo['cpf'] . "</td>";
                                            echo "<td class='list_description'>" . $campo['funcao'] . "</td>";
                                            echo "</tr>";
                                        } ?>
                                    </table>
                                </li>
                            </ul>
                            <ul class="list-group">
                                <li class="list-group-item list-group-item-success"><b>Cronograma</b></li>
                                <li class="list-group-item">
                                    <table class="table table-bordered">
                                        <!--<tr>
                                            <td><strong>Início do cronograma:</strong>
                                                <?php /*echo exibirDataBr($projeto['inicioCronograma']) */?>
                                            </td>
                                            <td><strong>Fim do cronograma:</strong>
                                                <?php /*echo exibirDataBr($projeto['fimCronograma']) */?>
                                            </td>
                                        </tr>-->
                                        <tr>
                                            <td><strong>Captação de recursos:</strong>
                                                <?php echo $cronograma['captacaoRecurso'] ?> mes(es)
                                            </td>
                                            <td><strong>Pré-Produção:</strong>
                                                <?php echo $cronograma['preProducao'] ?> mes(es)
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong>Produção:</strong>
                                                <?php echo $cronograma['producao'] ?> mes(es)
                                            </td>
                                            <td><strong>Pós-Produção:</strong>
                                                <?php echo $cronograma['posProducao'] ?> mes(es)
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"><strong>Prestação de Contas:</strong>
                                                <?php echo $cronograma['prestacaoContas'] ?> mes(es)
                                            </td>
                                        </tr>
                                    </table>
                                </li>
                            </ul>
                            <ul class="list-group">
                                <li class="list-group-item list-group-item-success"><b>Orçamento</b></li>
                                <?php
                                for ($i = 1; $i <= 7; $i++) {
                                    $sql_etapa = "SELECT idEtapa, SUM(valorTotal) AS tot FROM orcamento WHERE publicado > 0 AND idProjeto ='$idProjeto' AND idEtapa = '$i' ORDER BY idOrcamento";
                                    $query_etapa = mysqli_query($con, $sql_etapa);
                                    $lista = mysqli_fetch_array($query_etapa);

                                    $etapa = recuperaDados("etapa", "idEtapa", $lista['idEtapa']);
                                    echo  isset($etapa['etapa']) ? "<li class='list-group-item'><strong>" . $etapa['etapa']. ":</strong> R$ " . dinheiroParaBr($lista['tot']) . "</li>" : null;
                                }
                                $sql_total = "SELECT SUM(valorTotal) AS tot FROM orcamento WHERE publicado > 0 AND idProjeto ='$idProjeto' ORDER BY idOrcamento";
                                $query_total = mysqli_query($con, $sql_total);
                                $total = mysqli_fetch_array($query_total);
                                echo "<li class='list-group-item'><strong>TOTAL:</strong> R$ " . dinheiroParaBr($total['tot']) . "</li>";
                                ?>
                                <li class="list-group-item">
                                    <table class="table table-bordered">
                                        <tr>
                                            <td width='25%'><strong>Grupo de Defesa</strong></td>
                                            <td><strong>Descrição</strong></td>
                                            <td width='5%'><strong>Qtde</strong></td>
                                            <td width='5%'><strong>Unid. Med.</strong></td>
                                            <td width='5%'><strong>Ocorrências</strong></td>
                                            <td><strong>Valor Unit.</strong></td>
                                            <td><strong>Valor Total</strong></td>
                                        </tr>
                                        <?php
                                        $sql = "SELECT * FROM orcamento WHERE publicado > 0 AND idProjeto ='$idProjeto' ORDER BY idEtapa";
                                        $query = mysqli_query($con, $sql);
                                        while ($campo = mysqli_fetch_array($query)) {
                                            $etapa = recuperaDados("etapa", "idEtapa", $campo['idEtapa']);
                                            $medida = recuperaDados("unidade_medida", "idUnidadeMedida", $campo['idUnidadeMedida']);
                                            echo "<tr>";
                                            echo "<td class='list_description'>" . $etapa['etapa'] . "</td>";
                                            echo "<td class='list_description'>" . $campo['descricao'] . "</td>";
                                            echo "<td class='list_description'>" . $campo['quantidade'] . "</td>";
                                            echo "<td class='list_description'>" . $medida['unidadeMedida'] . "</td>";
                                            echo "<td class='list_description'>" . $campo['quantidadeUnidade'] . "</td>";
                                            echo "<td class='list_description'>" . dinheiroParaBr($campo['valorUnitario']) . "</td>";
                                            echo "<td class='list_description'>" . dinheiroParaBr($campo['valorTotal']) . "</td>";
                                            echo "</tr>";
                                        } ?>
                                    </table>
                                </li>
                            </ul>
                            <ul class="list-group">
                                <li class="list-group-item list-group-item-success"><b>Mídias sociais</b></li>
                                <li class="list-group-item">
                                    <?php

                                    if (!empty($video['video1'] || $video['video2'] || $video['video3'])) {
                                        ?>
                                        <table class='table table-condensed'>
                                            <?php
                                            foreach ($v as $key => $m) {
                                                if (!empty($m)) {
                                                    if (isYoutubeVideo($m) == "youtube") {
                                                        $desc = "https://www.youtube.com/oembed?format=json&url=" . $m;
                                                        $obj = json_decode(file_get_contents($desc), true);
                                                    } else {
                                                        echo "<div class='alert alert-danger'><strong>Erro!</strong> O link ($m) não pode ser aberto, a plataforma aceita somente YouTube.</div>";
                                                    }
                                                    if (isYoutubeVideo($m) == "youtube") { ?>
                                                        <tr>
                                                            <td>
                                                                <img src="<?php echo $obj['thumbnail_url']; ?>" style='width: 150px;'>
                                                            </td>
                                                            <td>
                                                                <?php echo $obj['title']; ?><br/>
                                                                <?php echo $m ?>
                                                            </td>
                                                        </tr>
                                                    <?php } ?>
                                                    <?php
                                                }
                                            } ?>
                                        </table>
                                        <?php
                                    } else {
                                        echo "<p>Não há video(s) inserido(s).<p/><br/>";
                                    }
                                    ?>
                                </li>
                            </ul>
						</div>

						<!-- LABEL PESSOA FÍSICA -->
						<div role="tabpanel" class="tab-pane fade" id="F" align="left">
							<br>
                            <table class="table table-bordered">
                                <tr>
                                    <td colspan="2">
                                        <strong>Nome:</strong>
                                        <?= isset($pessoaFisica['nome']) ? $pessoaFisica['nome'] : ''; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong>Telefone:</strong>
                                        <?= isset($pessoaFisica['telefone']) ? $pessoaFisica['telefone'] : ''; ?>
                                    </td>

                                    <td>
                                        <strong>Celular:</strong>
                                        <?= isset($pessoaFisica['celular']) ? $pessoaFisica['celular'] : ''; ?>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <strong>E-mail:</strong>
                                        <?php //echo isset($pf['email']) ? $pf['email'] : null; ?>
                                        <?= isset($pessoaFisica['email']) ? $pessoaFisica['email'] : ''; ?>
                                    </td>

                                    <td>
                                        <strong>Cooperado:</strong>
                                        <?= $pessoaFisica['cooperado'] == 1 ? 'SIM' : 'NÃO' ?>
                                    </td>
                                </tr>
                            </table>
						</div>

						<!-- LABEL PESSOA JURÍDICA -->
						<div role="tabpanel" class="tab-pane fade" id="J">
							<br>
                            <li class="list-group-item list-group-item-success">
                                <b>Dados Pessoa Jurídica</b>
                            </li>
                            <table class="table table-bordered">
                                <tr>
                                    <td colspan="2">
                                        <strong>Razão Social:</strong>
                                        <?php echo isset($pj['razaoSocial']) ? $pj['razaoSocial'] : null; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="50%">
                                        <strong>CNPJ:</strong>
                                        <?php echo isset($pj['cnpj']) ? $pj['cnpj'] : null; ?>
                                    </td>
                                    <td>
                                        <strong>CCM:</strong>
                                        <?php echo isset($pj['ccm']) ? $pj['ccm'] : null; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2"><strong>Endereço:</strong>
                                        <?php echo isset($pj['logradouro']) ? $pj['logradouro'] : null; ?>,
                                        <?php echo isset($pj['numero']) ? $pj['numero'] : null; ?>
                                        <?php echo isset($pj['complemento']) ? $pj['complemento'] : null; ?> -
                                        <?php echo isset($pj['bairro']) ? $pj['bairro'] : null; ?> -
                                        <?php echo isset($pj['cidade']) ? $pj['cidade'] : null; ?> -
                                        <?php echo isset($pj['estado']) ? $pj['estado'] : null; ?> - CEP
                                        <?php echo isset($pj['cep']) ? $pj['cep'] : null; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Telefone:</strong>
                                        <?php echo isset($pj['telefone']) ? $pj['telefone'] : null; ?>
                                    </td>
                                    <td><strong>Celular:</strong>
                                        <?php echo isset($pj['celular']) ? $pj['celular'] : null; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>E-mail:</strong>
                                        <?php echo isset($pj['email']) ? $pj['email'] : null; ?>
                                    </td>
                                    <td><strong>Cooperativa:</strong>
                                        <?php if($pj['cooperativa'] == 1){ echo "Sim"; } else { echo "Não"; } ?>
                                    </td>
                                </tr>
                            </table>
                            <!--Dados Representante -->
                            <li class="list-group-item list-group-item-success">
                                <b>Dados Representante</b>
                            </li>
                            <table class="table table-bordered">
                                <tr>
                                    <td colspan="2">
                                        <strong>Nome:</strong>
                                        <?= isset($representante['nome']) ? $representante['nome'] : ''; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong>Telefone:</strong>
                                        <?= isset($representante['telefone']) ? $representante['telefone'] : ''; ?>
                                    </td>
                                    <td>
                                        <strong>Celular:</strong>
                                        <?= isset($representante['celular']) ? $representante['celular'] : ''; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <strong>E-mail:</strong>
                                        <?= isset($representante['email']) ? $representante['email'] : ''; ?>
                                    </td>
                                </tr>
                            </table>
						</div>
					</div><!-- class="tab-content" -->
				</div><!-- role="tabpanel" -->
			</div>
		</div>
	</div>
</section>