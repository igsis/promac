<?php
require_once "./controllers/FormacaoController.php";
$formObj = new FormacaoController();

if (isset($_SESSION['origem_id_c'])){
    $idPf = $_SESSION['origem_id_c'];
    $ano = $_SESSION['ano_c'];
    $form = $formObj->recuperaFormacao($ano, $idPf);
    if ($form){
        $id = MainModel::encryption($form->id);
    }
}
?>
<li class="nav-item">
    <a href="<?= SERVERURL ?>formacao/inicio" class="nav-link" id="fomentos_inicio">
        <i class="fa fa-info nav-icon"></i>
        <p>Lista Cadastros</p>
    </a>
</li>
<hr/>
<?php if (isset($_SESSION['origem_id_c'])){ ?>
    <li class="nav-item">
        <a href="<?= SERVERURL ?>formacao/pf_dados_cadastro<?= $idPf ? '&id='.$idPf : NULL ?>" class="nav-link" id="dados_cadastrais">
            <i class="far fa-circle nav-icon"></i>
            <p>Dados pessoais</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?= SERVERURL ?>formacao/pf_endereco_cadastro<?= $idPf ? '&id='.$idPf : NULL ?>" class="nav-link" id="dados_endereco">
            <i class="far fa-circle nav-icon"></i>
            <p>Dados de endereço</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?= SERVERURL ?>formacao/pf_banco_cadastro<?= $idPf ? '&id='.$idPf : NULL ?>" class="nav-link" id="dados_bancarios">
            <i class="far fa-circle nav-icon"></i>
            <p>Dados bancários</p>
        </a>
    </li>

    <?php if (isset($_SESSION['formacao_id_c'])) { ?>
        <li class="nav-item">
            <a href="<?= SERVERURL ?>formacao/formacao_cadastro&idC=<?= $_SESSION['formacao_id_c'] ?>" class="nav-link" id="programa">
                <i class="far fa-circle nav-icon"></i>
                <p>Dados complementares</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= SERVERURL ?>formacao/anexos" class="nav-link" id="anexos">
                <i class="far fa-circle nav-icon"></i>
                <p>Anexos</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= SERVERURL ?>formacao/finalizar" class="nav-link" id="finalizar">
                <i class="far fa-circle nav-icon"></i>
                <p>Finalizar</p>
            </a>
        </li>
    <?php } else { ?>
        <li class="nav-item">
            <a href="<?= SERVERURL ?>formacao/formacao_cadastro<?= $form != NULL ? '&idPf='.$idPf : NULL ?>" class="nav-link" id="programa">
                <i class="far fa-circle nav-icon"></i>
                <p>Dados complementares</p>
            </a>
        </li>
    <?php } ?>
<?php } ?>
