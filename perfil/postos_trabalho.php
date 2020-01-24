<?php
$con = bancoMysqli();
$idProjeto = $_SESSION['idProjeto'];

if(isset($_POST['insere']))
{
	$valorProjeto = dinheiroDeBr($_POST['valorProjeto']);
	$idRenunciaFiscal = $_POST['idRenunciaFiscal'];
	$idExposicaoMarca = $_POST['idExposicaoMarca'];
	$indicacaoIngresso = $_POST['indicacaoIngresso'];

	$sql_insere = "UPDATE projeto SET
		valorProjeto = '$valorProjeto',
		idRenunciaFiscal = '$idRenunciaFiscal',
		idExposicaoMarca = '$idExposicaoMarca',
		indicacaoIngresso = '$indicacaoIngresso'
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
                <ul class="list-group">
                    <li class="list-group-item list-group-item-warning">
                        <strong>O valor do incentivo é igual ao valor do orçamento preenchido na tela de orçamento.<br/>O valor total do projeto pode ser igual ao valor solicitado ao Pro-Mac ou maior, incluindo recursos oriundos de outras fontes.</strong><br/>
                    </li>
                </ul>
                <p><strong><?php if(isset($mensagem)){echo $mensagem;} ?></strong></p>
            </div>
            <div class="row">
                <div class="col-md-offset-1 col-md-10">
                    <form method="POST" action="?perfil=postos_trabalho" class="form-horizontal" role="form">

                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-12">
                                <label>a) Quantos postos de trabalho diretos o seu projeto gera, ainda que temporariamente? </label>
                                <input type="text" name="valorProjeto" class="form-control" id="valor" value="<?php echo isset($projeto['valorProjeto']) ? dinheiroParaBr($projeto['valorProjeto']) : null ?>" />
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-12">
                                <label>b) Qual a média, em meses, de tempo de contratação de cada posto de trabalho? </label>
                                <input type="text" title="Formato desejado: 1.000,99" name="valorIncentivo" class="form-control" readonly id="valorIncentivo" value="<?php echo isset($projeto['valorIncentivo']) ? dinheiroParaBr($projeto['valorIncentivo']) : null ?>" />
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-12">
                                <label>c) Qual a média, em reais, de remuneração de cada posto de trabalho? </label>
                                <button class='btn btn-default' type='button' data-toggle='modal' data-target='#infoRenunciaFiscal' style="border-radius: 30px;"><i class="fa fa-question-circle"></i></button>
                                <select required class="form-control" name="idRenunciaFiscal">
                                    <option value="">Selecione</option>
                                    <?php echo geraOpcao("renuncia_fiscal",$projeto['idRenunciaFiscal']) ?>
                                </select>
                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </section>
