<?php
$con = bancoMysqli();
$idProjeto = $_POST['IDP'];

$projeto = recuperaDados("projeto","id",$idProjeto);

// Inicio Pessoa Física - Incentivador ou Proponente
if(isset($_POST['pesquisaPf']))
{
$nome = $_POST['nome'];
$cpf = $_POST['cpf'];
$tabela = $_POST['tipo'];

if($tabela == "pessoa_fisica")
{
$tipoPessoa = 1;
}
else
{
$tipoPessoa = 4;
}

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

$sql = "SELECT * FROM $tabela WHERE idPf > 0 $filtro_nome $filtro_cpf";
$query = mysqli_query($con,$sql);
$num = mysqli_num_rows($query);
if($num > 0)
{
$i = 0;
while($lista = mysqli_fetch_array($query))
{
$frase = recuperaDados("frase_seguranca","id",$lista['idFraseSeguranca']);
$x[$i]['id'] = $lista['idPf'];
$x[$i]['pessoa'] = $lista['nome'];
$x[$i]['documento'] = $lista['cpf'];
$x[$i]['email'] = $lista['email'];
$x[$i]['telefone'] = $lista['telefone'];
$x[$i]['frase'] = $frase['frase_seguranca'];
$x[$i]['resposta'] = $lista['respostaFrase'];
$x[$i]['tipoPessoa'] = $tipoPessoa;
$i++;
}
$x['num'] = $i;
}
else
{
$x['num'] = 0;
}
}
// Inicio Pessoa Jurídica - Incentivador ou Proponente
if(isset($_POST['pesquisaPj']))
{
$razaoSocial = $_POST['razaoSocial'];
$cnpj = $_POST['cnpj'];
$tabela = $_POST['tipo'];

if($tabela == "pessoa_juridica")
{
$tipoPessoa = 2;
}
else
{
$tipoPessoa = 5;
}

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
$sql = "SELECT * FROM $tabela WHERE idPj > 0 $filtro_razaoSocial $filtro_cnpj";
$query = mysqli_query($con,$sql);
$num = mysqli_num_rows($query);
if($num > 0)
{
$i = 0;
while($lista = mysqli_fetch_array($query))
{
$frase = recuperaDados("frase_seguranca","id",$lista['idFraseSeguranca']);
$x[$i]['id'] = $lista['idPj'];
$x[$i]['pessoa'] = $lista['razaoSocial'];
$x[$i]['documento'] = $lista['cnpj'];
$x[$i]['email'] = $lista['email'];
$x[$i]['telefone'] = $lista['telefone'];
$x[$i]['frase'] = $frase['frase_seguranca'];
$x[$i]['resposta'] = $lista['respostaFrase'];
$x[$i]['tipoPessoa'] = $tipoPessoa;
$i++;
}
$x['num'] = $i;
}
else
{
$x['num'] = 0;
}
}

$mensagem = "Foram encontrados ".$x['num']." resultados";
?>

<section id="list_items" class="home-section bg-white">
    <div class="container"><?php include 'includes/menu_smc.php'; ?>
        <div class="form-group">
            <h4>Inserir Incentivador <br>
                <small>Projeto: <?=$projeto['nome']?></small>
            </h4>
            <h5><?php if(isset($mensagem)){echo $mensagem;}; ?></h5>
        </div>
        <div class="row">
            <div class="col-md-offset-1 col-md-10">
                <hr/>
                <div id="accordion">
                    <div class="panel">
                        <div class="form-group">
                            <button type="button" class="btn btn-theme" data-parent="#accordion" data-toggle="collapse" data-target="#proponentePf">Proponente Pessoa Física</button>
                        </div>
                        <div id="proponentePf" class="collapse">
                            <form method="POST" action="?perfil=smc_pesquisa_reseta_senha_resultado" class="form-horizontal" role="form">
                                <label>PESSOA FÍSICA</label>
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
                                        <input type="hidden" name="tipo" value="pessoa_fisica">
                                        <input type="submit" name="pesquisaPf" class="btn btn-theme btn-lg btn-block" value="Pesquisar">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="panel">
                        <div class="form-group">
                            <button type="button" class="btn btn-theme" data-parent="#accordion" data-toggle="collapse" data-target="#proponentePj">Proponente Pessoa Jurídica</button>
                        </div>
                        <div id="proponentePj" class="collapse">
                            <form method="POST" action="?perfil=smc_pesquisa_reseta_senha_resultado" class="form-horizontal" role="form">
                                <label>PESSOA JURÍDICA</label>
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
                                        <input type="hidden" name="tipo" value="pessoa_juridica">
                                        <input type="submit" name="pesquisaPj" class="btn btn-theme btn-lg btn-block" value="Pesquisar">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="panel">
                        <div class="form-group">
                            <button type="button" class="btn btn-theme" data-parent="#accordion" data-toggle="collapse" data-target="#incentivadorPf">Incentivador Pessoa Física</button>
                        </div>
                        <div id="incentivadorPf" class="collapse">
                            <form method="POST" action="?perfil=smc_pesquisa_reseta_senha_resultado" class="form-horizontal" role="form">
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
                                        <input type="hidden" name="tipo" value="incentivador_pessoa_fisica">
                                        <input type="submit" name="pesquisaPf" class="btn btn-theme btn-lg btn-block" value="Pesquisar">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="panel">
                        <div class="form-group">
                            <button type="button" class="btn btn-theme" data-parent="#accordion" data-toggle="collapse" data-target="#incentivadorPj">Incentivador Pessoa Jurídica</button>
                        </div>
                        <div id="incentivadorPj" class="collapse">
                            <form method="POST" action="?perfil=smc_pesquisa_reseta_senha_resultado" class="form-horizontal" role="form">
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
                                        <input type="hidden" name="tipo" value="incentivador_pessoa_juridica">
                                        <input type="submit" name="pesquisaPj" class="btn btn-theme btn-lg btn-block" value="Pesquisar">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
