<?php
$con = bancoMysqli();
$tipoPessoa = '1';
$idStatus = 1;

$idPf = $_SESSION['idUser'];
$pf = recuperaDados("pessoa_fisica","idPf",$idPf);


$situacaoAtual = recuperaDados("statusprojeto", "idStatus", $idStatus);

if(isset($_POST['liberacaoPF']))
{
?>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
                </div>
                <div class="modal-body">...</div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
    <?php
}

if(isset($_POST['liberacaoPJ']))
{
	$idJuridico = $_POST['LIBPJ'];
	$QueryPJ = "UPDATE pessoa_juridica SET liberado='3' WHERE idPj='$idJuridico'";
	$envio = mysqli_query($con, $QueryPJ);
	if($envio)
		echo "<script>alert('O usuário foi ativo com sucesso');</script>";
}
?>
<section id="list_items" class="home-section bg-white">
    <div class="container">
        <?php include 'includes/menu_smc.php'; ?>
        <p align="left"><strong><?php echo saudacao(); ?>, <?php echo $_SESSION['nome']; ?></strong></p>
        <div class="form-group">
            <h5 class="alert alert-info" role="alert">
                CADASTRO DE PROJETOS:
                <?php echo $situacaoAtual['descricaoSituacao'];?>
            </h5>
        </div>

        <div role="tabpanel">
            <!-- LABELS -->
            <ul class="nav nav-tabs">
                <li class="nav active"><a href="#smc" data-toggle="tab">Área SMC</a></li>
                <li class="nav"><a href="#comissao" data-toggle="tab">Área Comissão</a></li>
            </ul>

            <div class="tab-content">
                <div role="tabpanel" class="tab-pane fade in active" id="smc">
                    <?php include "includes/smc_area_index.php"; ?>
                </div>
            </div>

            <div class="tab-content">
                <div role="tabpanel" class="tab-pane fade" id="comissao">
                    <?php include "includes/comissao_area_index.php"; ?>
                </div>
            </div>
        </div>
    </div>
</section>