<?php
$con = bancoMysqli();
$idProjeto = $_GET['idProjeto'];
$consulta = isset($_POST['consulta']) ? 1 : 0;

$projeto = recuperaDados("projeto","idProjeto",$idProjeto);

if(isset($_POST['consulta']))
{
    $tipoPessoa = $_POST['tipo'];

    // Inicio Incentivador Pessoa Física
    if($tipoPessoa == "4")
    {
        $nome = $_POST['nome'];
        $cpf = $_POST['cpf'];
        $tabela = "incentivador_pessoa_fisica";

        if($nome != '')
        {
            $filtro_nome = " AND nome LIKE '%$nome%'";
        }
        else
        {
            $filtro_nome = "";
        }

        if($cpf != '')
        {
            $filtro_cpf = " AND cpf = '$cpf'";
        }
        else
        {
            $filtro_cpf = "";
        }

        $sql = "SELECT * FROM $tabela AS IPF
                LEFT JOIN financeiro AS F
                  ON IPF.idPf = F.idIncentivador AND F.idProjeto = $idProjeto AND F.tipoPessoa = $tipoPessoa
                WHERE IPF.idPf > 0 $filtro_nome $filtro_cpf AND F.idIncentivador IS NULL
                ORDER BY IPF.nome";
        $query = mysqli_query($con,$sql);
        $num = mysqli_num_rows($query);
        if($num > 0)
        {
            $mensagem = "Foram encontrados $num registros";
        }
        else
        {
            $consulta = 0;
            $mensagem = "Não foram encontrados registros";
        }
    }

    // Inicio Incentivador Pessoa Juridica
    else
    {
        $razaoSocial = $_POST['razaoSocial'];
        $cnpj = $_POST['cnpj'];
        $tabela = "incentivador_pessoa_juridica";

        if($razaoSocial != '')
        {
            $filtro_razaoSocial = " AND razaoSocial LIKE '%$razaoSocial%'";
        }
        else
        {
            $filtro_razaoSocial = "";
        }

        if($cnpj != '')
        {
            $filtro_cnpj = " AND cnpj = '$cnpj'";
        }
        else
        {
            $filtro_cnpj = "";
        }
        $sql = "SELECT * FROM $tabela AS IPJ
                LEFT JOIN financeiro AS F
                  ON IPJ.idPj = F.idIncentivador AND F.idProjeto = $idProjeto AND F.tipoPessoa = $tipoPessoa
                WHERE IPJ.idPj > 0 $filtro_razaoSocial $filtro_cnpj AND F.idIncentivador IS NULL
                ORDER BY IPJ.razaoSocial";
        $query = mysqli_query($con,$sql);
        $num = mysqli_num_rows($query);
        if($num > 0)
        {
            $mensagem = "Foram encontrados $num registros";
        }
        else
        {
            $consulta = 0;
            $mensagem = "Não foram encontrados registros";
        }
    }
}
?>

<section id="list_items" class="home-section bg-white">
    <div class="container"><?php include 'includes/menu_smc.php'; ?>
        <div class="form-group">
            <h4>Inserir Incentivador<br>
                <small>Projeto: <?=$projeto['nomeProjeto']?></small>
            </h4>
        </div>
        <div class="row">
            <div class="col-md-offset-1 col-md-10">
                <hr/>
                <div id="accordion">
                    <!--Botão Incentivador Pessoa Fisica-->
                    <div class="panel">
                        <div class="form-group">
                            <button type="button" class="btn btn-theme" data-parent="#accordion" data-toggle="collapse" data-target="#incentivadorPf">Incentivador Pessoa Física</button>
                        </div>
                        <div id="incentivadorPf" class="collapse">
                            <form method="POST" action="?perfil=insere_incentivador_projeto&idProjeto=<?=$idProjeto?>" class="form-horizontal" role="form">
                                <label>INCENTIVADOR PESSOA FÍSICA</label>
                                <div class="form-group">
                                    <div class="col-md-offset-2 col-md-5"><label>Nome</label>
                                        <input type="text" name="nome" class="form-control" placeholder="">
                                    </div>
                                    <div class="col-md-3"><label>CPF</label>
                                        <input type="text" name="cpf" id="cpf" class="form-control" placeholder="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-offset-2 col-md-8">
                                        <input type="hidden" name="tipo" value="4">
                                        <input type="submit" name="consulta" class="btn btn-theme btn-lg btn-block" value="Pesquisar">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!--Botão Incentivador Pessoa Juridica-->
                    <div class="panel">
                        <div class="form-group">
                            <button type="button" class="btn btn-theme" data-parent="#accordion" data-toggle="collapse" data-target="#incentivadorPj">Incentivador Pessoa Jurídica</button>
                        </div>
                        <div id="incentivadorPj" class="collapse">
                            <form method="POST" action="?perfil=insere_incentivador_projeto&idProjeto=<?=$idProjeto?>" class="form-horizontal" role="form">
                                <label>INCENTIVADOR PESSOA JURÍDICA</label>
                                <div class="form-group">
                                    <div class="col-md-offset-2 col-md-5"><label>Razão Social</label>
                                        <input type="text" name="razaoSocial" class="form-control" placeholder="">
                                    </div>
                                    <div class="col-md-3"><label>CNPJ</label>
                                        <input type="text" name="cnpj" id="cnpj" class="form-control" placeholder="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-offset-2 col-md-8">
                                        <input type="hidden" name="tipo" value="5">
                                        <input type="submit" name="consulta" class="btn btn-theme btn-lg btn-block" value="Pesquisar">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <h5><?php if(isset($mensagem)){echo $mensagem;}; ?></h5>
        <div class="row">
            <?php if ($consulta == 1) { ?>
                <div class="table-responsive list_info">
                    <table class='table table-condensed'>
                        <thead>
                        <tr class='list_menu'>
                            <td><?=($tipoPessoa == 4 ? "Nome" : "Razão Social")?></td>
                            <td><?=($tipoPessoa == 4 ? "CPF" : "CNPJ")?></td>
                            <td>Email</td>
                            <td width="30"></td>
                        </tr>
                        </thead>
                        <tbody>
                        <?php while($linha = mysqli_fetch_array($query)) {?>
                            <tr>
                                <td class="list_description"><?=($tipoPessoa == 4 ? $linha['nome'] : $linha['razaoSocial'])?></td>
                                <td class="list_description"><?=($tipoPessoa == 4 ? $linha['cpf'] : $linha['cnpj'])?></td>
                                <td class="list_description"><?=$linha['email']?></td>
                                <td class="list_description">
                                    <form method="POST" action="?perfil=smc_detalhes_projeto&idFF=<?=$idProjeto?>">
                                        <input type="hidden" name="idIncentivador" value="<?=($tipoPessoa == 4 ? $linha['idPf'] : $linha['idPj'])?>">
                                        <input type="hidden" name="tipoPessoa" value="<?=$tipoPessoa?>">
                                        <input type="submit" class="btn btn-theme" name="insereIncentivador" value="Inserir">
                                    </form>
                                </td>
                            </tr>
                        <?php } ?>

                        </tbody>
                    </table>
                </div>
            <?php }?>
        </div>
    </div>
</section>
