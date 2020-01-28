<?php
$con = bancoMysqli();
$idProjeto = $_SESSION['idProjeto'];

if (isset($_POST['insere'])) {
    $planoDivulgacao = addslashes($_POST['planoDivulgacao']);

    $sql_insere = "UPDATE projeto SET
		planoDivulgacao = '$planoDivulgacao'
		WHERE idProjeto = '$idProjeto'";
    if (mysqli_query($con, $sql_insere)) {
        $mensagem = "<font color='#01DF3A'><strong>Gravado com sucesso!</strong></font>";
        gravarLog($sql_insere);
    } else {
        $mensagem = "<font color='#FF0000'><strong>Erro ao gravar! Tente novamente.</strong></font>";
    }
}

if (isset($_POST['materialDivulgacao'])){
    $materialDivulgacao = $_POST['material_divulgacao'];
    $quantidade = $_POST['quantidade'];
    $veiculoDivulgacao = $_POST['veiculo_divulgacao'];
    $id = $_POST['idMaterial'];
    if ($id == 0) {
        $queryInsert = "INSERT INTO 
                    material_divulgacao (material_divulgacao, quantidade,veiculo_divulgacao,projeto_id,publicado) 
                    VALUES ('$materialDivulgacao','$quantidade','$veiculoDivulgacao','$idProjeto','1')";
        if(mysqli_query($con,$queryInsert))
        {
            $mensagem = "<font color='#01DF3A'><strong>Gravado com sucesso!</strong></font>";
            gravarLog($queryInsert);
        }
        else
        {
            $mensagem = "<font color='#FF0000'><strong>Erro ao gravar Inserção! Tente novamente.</strong></font>";
        }
    }else{
        $queryUpdate = "UPDATE material_divulgacao 
                        SET material_divulgacao ='$materialDivulgacao', quantidade = '$quantidade', 
                        veiculo_divulgacao = '$veiculoDivulgacao' WHERE idMaterial = '$id'";
        if(mysqli_query($con,$queryUpdate))
        {
            $mensagem = "<font color='#01DF3A'><strong>Gravado com sucesso!</strong></font>";
            gravarLog($queryUpdate);
        }
        else
        {
            $mensagem = "<font color='#FF0000'><strong>Erro ao gravar Atualização! Tente novamente.</strong></font>";
        }
    }

}

if (isset($_POST['idApagar'])){
    $id = $_POST['idApagar'];
    $queryDelete = "UPDATE material_divulgacao 
                        SET publicado ='0' WHERE idMaterial = '$id'";
    if(mysqli_query($con,$queryDelete))
    {
        $mensagem = "<font color='#01DF3A'><strong>Apagado com sucesso!</strong></font>";
        gravarLog($queryDelete);
    }
    else
    {
        $mensagem = "<font color='#FF0000'><strong>Erro ao apagar! Tente novamente.</strong></font>";
    }
}



$projeto = recuperaDados("projeto", "idProjeto", $idProjeto);
?>
<section id="list_items" class="home-section bg-white">
    <div class="container">
        <?php
        if ($_SESSION['tipoPessoa'] == 1) {
            $idPf = $_SESSION['idUser'];
            include '../perfil/includes/menu_interno_pf.php';
        } else {
            $idPj = $_SESSION['idUser'];
            include '../perfil/includes/menu_interno_pj.php';
        }
        ?>
        <div class="form-group">
            <h4>Cadastro de Projeto</h4>
            <p><strong><?php if (isset($mensagem)) {
                        echo $mensagem;
                    } ?></strong></p>
        </div>
        <div class="row">
            <div class="col-md-offset-1 col-md-10">
                <form method="POST" action="?perfil=projeto_8" class="form-horizontal" role="form">

                    <div class="form-group">
                        <div class="col-md-offset-2 col-md-8">
                            <label>Plano de Divulgação *</label>
                            <textarea name="planoDivulgacao" class="form-control" rows="10"
                                      required><?php echo $projeto['planoDivulgacao'] ?></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-offset-2 col-md-8">
                            <input type="submit" name="insere" class="btn btn-theme btn-lg btn-block" value="Gravar">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-offset-2 col-md-8">
                            <button type="button" class="btn btn-theme btn-lg btn-block"
                                    data-toggle="modal" data-target="#novoMaterial" id="btnNovoMaterial">Inserir Novo Material
                            </button>
                        </div>
                    </div>
                </form>
                <div class="row">
                    <br>
                    <h4>Material de divulgação cadastrados</h4>

                        <?php recuperaMaterial($idProjeto,true) ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Inicio Modal Adiciona / Material de divulgacao -->
<div class="modal fade" id="novoMaterial" tabindex="-1" role="dialog" aria-labelledby="novoMaterialLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Inserir novo Plano de Trabalho</h4>
            </div>
            <form method="POST" action="?perfil=projeto_8" role="form">
                <div class="modal-body" style="text-align: left;">
                    <input type="hidden" id="idMaterial" name="idMaterial" value="0">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="objetivo">Material Divulgação</label>
                                <input type="text" name="material_divulgacao" class="form-control" id="material_divulgacao" required maxlength="180">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="quantidade">Quantidade</label>
                                <input type="number"  name="quantidade" class="form-control" id="quantidade" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="quantidade">Veiculo de divulgação</label>
                                <input type="text" name="veiculo_divulgacao" class="form-control" id="veiculo_divulgacao" required maxlength="180">
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="projeto_id" value="<?= $idProjeto ?>">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                    <button type="submit" name="materialDivulgacao" class="btn btn-theme" id="btnObjetivo">Gravar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Fim Modal Adiciona / Edita Plano -->

<div class="modal fade" id="apagarMaterial" tabindex="-1" role="dialog" aria-labelledby="apagarMaterialLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Apagar Material de Divulgação</h4>
            </div>
            <form method="POST" action="?perfil=projeto_8" role="form">
                <div class="modal-body" style="text-align: left;">
                    <p class="text-center">Você deseja mesmo Apagar este Material de Divulgação</p>
                </div>
                <input type="hidden" name="idApagar" id="idApagar">
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
                    <button type="submit" name="materialDivulgacaoApaga" class="btn btn-theme" id="btnObjetivo">Apagar</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
    let tabela = document.querySelector('#tbMaterial');

    tabela.addEventListener("click",function (event) {

        // pegando dados da tabela carregadaa
        let td = event.target.parentNode;
        let tr = td.parentNode;

        //pegando dados do input idMat que está hidden dentro da tr de Ações
        let idTela = document.querySelector('#idMat').value;

        //colocar os calores no modal
        document.querySelector('#idMaterial').value = idTela;
        document.querySelector('#material_divulgacao').value = tr.children[0].textContent;
        document.querySelector('#quantidade').value = tr.children[1].textContent;
        document.querySelector('#veiculo_divulgacao').value = tr.children[2].textContent;
    })

    document.querySelector('#btnNovoMaterial').addEventListener("click",function () {
        document.querySelector('#idMaterial').value = 0;
        document.querySelector('#material_divulgacao').value = "";
        document.querySelector('#quantidade').value = "";
        document.querySelector('#veiculo_divulgacao').value = "";
    })

    function prrencherModalApagar(idMaterial) {

        document.querySelector('#idApagar').value = idMaterial;

    }

</script>