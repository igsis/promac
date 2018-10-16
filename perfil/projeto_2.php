<?php
$con = bancoMysqli();
$idProjeto = $_SESSION['idProjeto'];

if(isset($_POST['insere']))
{
	$valorProjeto = $_POST['valorProjeto'];
	$valorIncentivo = dinheiroDeBr($_POST['valorIncentivo']);
	$valorFinanciamento = dinheiroDeBr($_POST['valorFinanciamento']);
	$idRenunciaFiscal = $_POST['idRenunciaFiscal'];
	$exposicaoMarca = $_POST['exposicaoMarca'];

	$sql_insere = "UPDATE projeto SET
		valorProjeto = '$valorProjeto',
		valorIncentivo = '$valorIncentivo',
		valorFinanciamento = '$valorFinanciamento',
		idRenunciaFiscal = '$idRenunciaFiscal',
		exposicaoMarca = '$exposicaoMarca'
		WHERE idProjeto = '$idProjeto'";
	if(mysqli_query($con,$sql_insere))
	{
		$mensagem = "<font color='#01DF3A'><strong>Gravado com sucesso! Utilize o menu para avançar.</strong></font>";
		gravarLog($sql_insere);
	}
	else
	{
		$mensagem = "<font color='#FF0000'><strong>Erro ao gravar! Tente novamente.</strong></font>";
	}
}
$projeto = recuperaDados("projeto","idProjeto",$idProjeto);
?>
    <section id="inserir" class="home-section bg-white">
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
                        <form method="POST" action="?perfil=projeto_2" class="form-horizontal" role="form">

                            <!--TODO: Numero com pontuação quebra a regra de soma do valor total-->
                            <div class="form-group">
                                <div class="col-md-offset-3 col-md-2">
                                    <label>Valor total do <br/>projeto</label>
                                    <input type="text" name="valorProjeto" class="form-control" id="valorProjeto" readOnly value="<?= $projeto['valorProjeto'] ?>" />
                                </div>

                                <div class="col-md-2">
                                    <label>Valor do Incentivo solicitado no Pro-Mac</label>
                                    <input type="text" title="Formato desejado: 1.000,99" name="valorIncentivo" class="form-control" id="valorIncentivo" value="<?php echo isset($projeto['valorIncentivo']) ? dinheiroParaBr($projeto['valorIncentivo']) : null ?>" />
                                </div>
                                <div class="col-md-2">
                                    <label>Valor de outros financiamentos</label>
                                    <input type="text" title="Formato desejado: 1.000,99" name="valorFinanciamento" class="form-control" id="valorFinanciamento" value="<?php echo isset($projeto['valorFinanciamento']) ? dinheiroParaBr($projeto['valorFinanciamento']) : null ?>" />
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-offset-2 col-md-8">
                                    <label>Enquadramento da renúncia fiscal *</label> <button class='btn btn-default' type='button' data-toggle='modal' data-target='#infoRenunciaFiscal' style="border-radius: 30px;"><i class="fa fa-question-circle"></i></button>
                                    <select required class="form-control" name="idRenunciaFiscal">
								<option value="0"></option>
								<?php echo geraOpcao("renuncia_fiscal",$projeto['idRenunciaFiscal']) ?>
							</select>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-offset-2 col-md-8">
                                    <label>Descrição da exposição da marca e indicação do valor do ingresso*</label><button class='btn btn-default' type='button' data-toggle='modal' data-target='#infoExposicaoMarca' style="border-radius: 30px;"><i class="fa fa-question-circle"></i></button>
                                    <textarea name="exposicaoMarca" class="form-control" rows="10" maxlength="5000" required><?php echo isset($projeto['exposicaoMarca']) ? $projeto['exposicaoMarca'] : null ?></textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-offset-2 col-md-8">
                                    <input type="submit" name="insere" class="btn btn-theme btn-lg btn-block" value="Gravar">
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
                <!-- Inicio Modal Informações Exposição da Marca -->
                <div class="modal fade" id="infoExposicaoMarca" role="dialog" aria-labelledby="infoExposicaoMarca" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title">Informações sobre a Exposição da Marca</h4>
                            </div>
                            <div class="modal-body" style="text-align: left;">
                                <div role="tabpanel">
                                    <div class="tab-content">
                                        <!-- TABELA -->
                                        <div role="tabpanel" class="tab-pane fade in active" id="tabela">
                                            <br>
                                            <div class="well">
                                                O proponente deverá descrever proposta de ações que sejam acompanhadas de disponibilização de ingressos ou oferta de gratuidade visando garantir o mais amplo acesso da população ao produto do projeto cultural, ainda que essas ações de acessibilidade sejam indiretas em relação ao objeto/produto principal do projeto.
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" data-dismiss="modal">Fechar</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Fim Modal Informações da Exposição da Marca -->
                <!-- Inicio Modal Informações Renuncia fiscal -->
                <div class="modal fade" id="infoRenunciaFiscal" role="dialog" aria-labelledby="infoRenunciaFiscalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title">Informações para a Escolha da Renúncia Fiscal</h4>
                            </div>
                            <div class="modal-body" style="text-align: left;">
                                <div role="tabpanel">
                                    <ul id="modalRenuncia" class="nav nav-tabs">
                                        <li id="modaltab" class="nav active"><a href="#tabela1" data-toggle="tab">Tabela para Consulta</a></li>
                                        <li id="modaltab" class="nav"><a href="#artigo" data-toggle="tab">Legislação</a></li>
                                        <li id="modaltab" class="nav"><a href="#informacoes" data-toggle="tab">Informações Importantes</a></li>
                                    </ul>
                                    <div class="tab-content">
                                        <!-- TABELA -->
                                        <div role="tabpanel" class="tab-pane fade in active" id="tabela1">
                                            <br>
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Pontuação</th>
                                                        <th>1 Ponto</th>
                                                        <th>2 Pontos</th>
                                                        <th>3 Pontos</th>
                                                        <th>4 Pontos</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <th>Valor do Ingresso</th>
                                                        <td>superior a R$ 50,00</td>
                                                        <td>Acima de R$ 10,00 até R$ 50,00</td>
                                                        <td>Igual ou inferior a R$ 10,00</td>
                                                        <td>Gratuito</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Exposição da Marca</th>
                                                        <td>Como "apresenta", junto ao nome do projeto ou do realizador</td>
                                                        <td>Como "patrocínio"</td>
                                                        <td>Como "apoio"</td>
                                                        <td>mecenato</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Orçamento Integral do Projeto</th>
                                                        <td>Acima de R$ 8.000.000,00</td>
                                                        <td>Acima de R$ 4.000.000,00 até R$ 8.000.000,00</td>
                                                        <td>Acima de R$ 1.000.000,00 até R$ 4.000.000,00</td>
                                                        <td>Até R$ 1.000.000,00</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <a class="btn btn-success btnAvancar">Próximo</a>
                                        </div>
                                        <!-- ARTIGO -->
                                        <div role="tabpanel" class="tab-pane fade" id="artigo">
                                            <br>
                                            <ul class="list-group">
                                                <li class="list-group-item list-group-item-success"><b>100% (cem por cento) de renúncia fiscal</b></li>
                                                <li class="list-group-item">Os projetos que obtiverem pelo menos 9 (nove) pontos e os que somarem 8 (oite) pontos nas categorias "valor do ingresso" e "exposição da marca";</li>
                                            </ul>
                                            <ul class="list-group">
                                                <li class="list-group-item list-group-item-success"><b>80% (oitenta por cento) de renúncia fiscal</b></li>
                                                <li class="list-group-item">Os projetos que obtiverem 7 (sete) e 8 (oite) pontos;</li>
                                            </ul>
                                            <ul class="list-group">
                                                <li class="list-group-item list-group-item-success"><b>50% (cinquenta por cento) de renúncia fiscal</b></li>
                                                <li class="list-group-item">Os projetos que obtiverem 5 (cinco) e 6 (seis) pontos;</li>
                                            </ul>
                                            <ul class="list-group">
                                                <li class="list-group-item list-group-item-success"><b>20% (cinquenta por cento) de renúncia fiscal</b></li>
                                                <li class="list-group-item">Os projetos que obtiverem 4 (quatro) ou menos pontos;</li>
                                            </ul>
                                            <a class="btn btn-success btnVoltar">Anterior</a>
                                            <a class="btn btn-success btnAvancar">Próximo</a>
                                        </div>

                                        <!-- INFORMAÇÕES IMPORTANTES -->
                                        <div role="tabpanel" class="tab-pane fade" id="informacoes">
                                            <br>
                                            <div class="well">
                                                Os projetos de Plano Anual de Atividades não serão avaliados em função do orçamento integral do projeto e já obterão 4 (quatro) pontos iniciais.
                                            </div>
                                            <div class="well">
                                                As doações para o FEPAC não implicarão divulgação ou exposição da marca do Contribuinte Incentivador.
                                            </div>
                                            <div class="well">
                                                É vedado o uso de recursos provenientes dos mecanismos previstos neste decreto em projetos que se caracterizem exclusivamente como peças promocionais e institucionais de empresas patrocinadoras.
                                            </div>
                                            <a class="btn btn-success btnVoltar">Anterior</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" data-dismiss="modal">Fechar</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Fim Modal Informações Renuncia fiscal -->
        </div>
    </section>

    <script type="text/javascript">
        $(function() {
            $('#valorIncentivo, #valorFinanciamento').maskMoney({
                allowNegative: false,
                thousands: '.',
                decimal: ',',
                affixesStay: false
            }); // aplicar máscara imediatamente

            let valorIncentivo = $('#valorIncentivo');
            let valorFinanciamento = $('#valorFinanciamento');
            let valorProjeto = $('#valorProjeto');
            let valorTotal = 0;

            valorIncentivo.keyup(function () {
                valorTotal = parseFloat(valorIncentivo.maskMoney('unmasked')[0]) + parseFloat(valorFinanciamento.maskMoney('unmasked')[0]);
                valorProjeto.val(valorTotal.toFixed(2));
            });

            valorFinanciamento.keyup(function () {
                valorTotal = parseFloat(valorIncentivo.maskMoney('unmasked')[0]) + parseFloat(valorFinanciamento.maskMoney('unmasked')[0]);
                valorProjeto.val(valorTotal.toFixed(2));
            });

            valorIncentivo.blur(function () {
                valorTotal = parseFloat(valorIncentivo.maskMoney('unmasked')[0]) + parseFloat(valorFinanciamento.maskMoney('unmasked')[0]);
                valorProjeto.val(valorTotal.toFixed(2));
            });

            valorFinanciamento.blur(function () {
                valorTotal = parseFloat(valorIncentivo.maskMoney('unmasked')[0]) + parseFloat(valorFinanciamento.maskMoney('unmasked')[0]);
                valorProjeto.val(valorTotal.toFixed(2));
            });

        });

    </script>
