<?php
if (isset($_GET['id'])) {
    $_SESSION['projeto_c'] = $id = $_GET['id'];
} elseif (isset($_SESSION['projeto_c'])) {
    $id = $_SESSION['projeto_c'];
} else {
    $id = null;
}

require_once "./controllers/ProjetoController.php";
require_once "./controllers/FomentoController.php";

$objProjeto = new ProjetoController();
$objFomento = new FomentoController();

if ($id) {
    $projeto = $objProjeto->recuperaProjeto($id);
    $nucleo = $projeto['representante_nucleo'] != "Não se aplica" ? 'checked' : '';
    $coletivo = $projeto['coletivo_produtor'] != "Não se aplica" ? 'checked' : '';
}

$pessoa_tipos_id = $objFomento->recuperaEdital($_SESSION['edital_c'])->pessoa_tipos_id;
?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Cadastro do projeto</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <!-- Horizontal Form -->
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Dados</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form class="form-horizontal formulario-ajax" method="POST"
                          action="<?= SERVERURL ?>ajax/projetoAjax.php" role="form"
                          data-form="<?= ($id) ? "update" : "save" ?>">
                        <input type="hidden" name="_method" value="<?= ($id) ? "editar" : "cadastrar" ?>">
                        <input type="hidden" name="pagina" value="fomentos">
                        <input type="hidden" name="usuario_id" value="<?= $_SESSION['usuario_id_c'] ?>">
                        <input type="hidden" name="pessoa_tipo_id" value="<?= $pessoa_tipos_id ?>">

                        <?php if ($id): ?>
                            <input type="hidden" name="id" value="<?= $id ?>">
                        <?php endif; ?>

                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md">
                                    <label for="nome_projeto">Nome do projeto: *</label>
                                    <input type="text" class="form-control" id="nome_projeto" name="nome_projeto"  maxlength="70" value="<?= $projeto['nome_projeto'] ?? null ?>" required>
                                </div>
                            </div>

                            <?php if ($pessoa_tipos_id == 2) : ?>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="instituicao">Instituição responsável: *</label>
                                        <input type="text" class="form-control" id="instituicao" name="instituicao"
                                               maxlength="80" value="<?= $projeto['instituicao'] ?? null ?>" required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="site">Site: </label>
                                        <input type="text" class="form-control" id="site" name="site" value="<?= $projeto['site'] ?? null ?>">
                                    </div>
                                </div>
                            <?php endif; ?>

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="usuario_nome">Responsável pela inscrição: *</label>
                                    <input type="text" class="form-control" id="usuario_nome" name="usuario_nome"
                                           value="<?= $_SESSION['nome_c'] ?>" disabled>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="valor_projeto">Valor do projeto: *</label>
                                    <input type="text" class="form-control" id="valor_projeto" name="valor_projeto"
                                           value="<?= isset($projeto['valor_projeto']) ? $objProjeto->dinheiroParaBr($projeto['valor_projeto']) : null ?>"
                                           onKeyPress="return(moeda(this,'.',',',event))" required autocomplete="off">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="duracao">Duração: (em meses) *</label>
                                    <input type="number" class="form-control" id="duracao" name="duracao"
                                           value="<?= $projeto['duracao'] ?? null ?>" min="0" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-4">
                                    <br>
                                    <div class="custom-control custom-checkbox mt-2">
                                        <input class="custom-control-input" type="checkbox" id="representante"
                                            onchange="representanteCheck()" <?= $nucleo ?? ''?>>
                                        <label for="representante" class="custom-control-label">Caso seja núcleo/coletivo artístico <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-rep-nucleo"> <i class="fas fa-info"></i></button></label>
                                    </div>
                                </div>
                                <div class="form-group col-md">
                                    <label for="nome_nucleo"> Nome do núcleo artístico/coletivo artístico: *</label>
                                    <input type="text" class="form-control" id="nome_nucleo" name="nome_nucleo"
                                           maxlength="70" value="<?= $projeto['nome_nucleo'] ?? null ?>" required readonly>
                                </div>
                                <div class="form-group col-md">
                                    <label for="representante_nucleo">Nome do representante do núcleo: *</label>
                                    <input type="text" class="form-control" id="representante_nucleo"
                                           name="representante_nucleo" maxlength="100" placeholder="Não se aplica"
                                           value="<?= $projeto['representante_nucleo'] ?? null ?>" required readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <div class="custom-control custom-checkbox mt-4">
                                        <input class="custom-control-input" type="checkbox" id="coletivo"
                                            onchange="coletivoCheck()" <?= $coletivo ?? ''?>>
                                        <label for="coletivo" class="custom-control-label">Caso seja produtor independente <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-coletivo"> <i class="fas fa-info"></i></button></label>
                                    </div>
                                </div>
                                <div class="form-group col-md">
                                    <label for="coletivo_produtor">Nome do produtor independente: *</label>
                                    <input type="text" class="form-control" id="coletivo_produtor"
                                           name="coletivo_produtor" maxlength="100" placeholder="Não se aplica" readonly
                                           value="<?= $projeto['coletivo_produtor'] ?? null ?>" required>
                                </div>
                            </div>
                            <?php if ($pessoa_tipos_id ==1) : ?>
                                <div class="row">
                                    <div class="form-group col-md">
                                        <label for="fom_linguagem_projeto_id">Linguagem do projeto: *</label>
                                        <select class="form-control" id="fom_linguagem_projeto_id" name="fom_linguagem_projeto_id" required>
                                            <option value="">Selecione uma opção...</option>
                                            <?php
                                            $objFomento->geraOpcao("fom_linguagem_projetos",$projeto['fom_linguagem_projeto_id'] ?? null,true);
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-md">
                                        <label for="fom_tematica_projeto_id">Temática do projeto: *</label>
                                        <select class="form-control" id="fom_tematica_projeto_id" name="fom_tematica_projeto_id" required>
                                            <option value="">Selecione uma opção...</option>
                                            <?php
                                            $objFomento->geraOpcao("fom_tematica_projetos",$projeto['fom_tematica_projeto_id'] ?? null,true);
                                            ?>
                                        </select>
                                    </div>
                                    <?php if ($objFomento->recuperaTipoContratacao($_SESSION['edital_c']) == 24): ?>
                                    <div class="form-group col-md">
                                        <label for="fom_area_id">Área: *</label>
                                        <select class="form-control" id="fom_area_id" name="fom_area_id" required>
                                            <option value="">Selecione uma opção...</option>
                                            <?php
                                            $objFomento->geraOpcao("fom_areas",$projeto['fom_area_id'] ?? null);
                                            ?>
                                        </select>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="submit" id="btnGrava" class="btn btn-info float-right">Gravar</button>
                        </div>
                        <!-- /.card-footer -->
                        <div class="resposta-ajax"></div>
                    </form>
                </div>
                <!-- /.card -->
            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->

<div class="modal fade" id="modal-rep-nucleo">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Núcleo artístico</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="text-justify">Entende-se por núcleo artístico os artistas e técnicos que se responsabilizem pela fundamentação e execução do projeto, constituindo uma
                    base organizativa de caráter continuado.</p>
                <br>
                <h4 class="modal-title">Representante do núcleo ou coletivo</h4>
                <hr>
                <p class="text-justify">Entende-se que o responsável legal é o membro do Núcleo ou Coletivo que assinará o Termo de Fomento junto à Secretaria Municipal de Cultura.</p>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modal-coletivo">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Produtor independente</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="text-justify">Entende-se por produtor independente o artista, diretor e/ou produtor profissionais diretamente responsáveis pela criação, consecução e/ou viabilização do projeto. Os demais profissionais envolvidos, sejam artistas ou técnicos, integram a ficha técnica do projeto.</p>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<script type="application/javascript">
    const valorMaximo = parseFloat('<?=  $objProjeto->recuperaValorMax() ?>');
    const btnGrava = document.querySelector('#btnGrava');

    $(document).ready(function () {
        $('.nav-link').removeClass('active');
        $('#projeto').addClass('active');
    })
    $('#duracao').keyup(function () {
        let num = $(this).val();
        num = num.split('-');
        $(this).val(num);
    });

    $('#valor_projeto').keyup(function () {
        let valorP = converteValor($(this).val());

        if (valorP > valorMaximo) {
            Swal.fire(
                'Valor de Projeto acima do máximo!',
                "Valor deve ter no maximo até R$  <?= $objProjeto->dinheiroParaBr($objProjeto->recuperaValorMax()) ?>.",
                'error'
            );
            $(this).val('');
            $(this).addClass('is-invalid');
        } else {
            $(this).removeClass('is-invalid');
        }

    });

    function converteValor(valor) {
        let ValorNovo = '';
        let valores = valor.split('.');

        valores.forEach((valor) => {
            ValorNovo = ValorNovo + valor;
        });
        ValorNovo = ValorNovo.replace(',', '.');

        return parseFloat(ValorNovo).toFixed(2);
    }

    function coletivoCheck() {
        let coletivoCheck = $('#coletivo');

        let coletivo = $('#coletivo_produtor');

        if (coletivoCheck.is(':checked')) {
            coletivo.attr('readonly', false);
            coletivo.attr('required', true);
            coletivo.removeAttr('placeholder');
        } else {
            coletivo.attr('readonly', true);
            coletivo.attr('required', false);
            coletivo.attr('placeholder', 'Não se aplica');
            coletivo.val('Não se aplica');
        }
    }

    function representanteCheck() {
        let representanteCheck = $('#representante');

        let representante = $('#representante_nucleo');
        let nomeNucleo = $('#nome_nucleo');

        if (representanteCheck.is(':checked')) {
            representante.attr('readonly', false);
            representante.attr('required', true);
            representante.removeAttr('placeholder');
            nomeNucleo.attr('readonly', false);
            nomeNucleo.attr('required', true);
            nomeNucleo.removeAttr('placeholder');
        } else {
            representante.attr('readonly', true);
            representante.attr('required', false);
            representante.attr('placeholder', 'Não se aplica');
            representante.val('Não se aplica');
            nomeNucleo.attr('readonly', true);
            nomeNucleo.attr('required', false);
            nomeNucleo.attr('placeholder', 'Não se aplica');
            nomeNucleo.val('Não se aplica');
        }
    }

    $(document).ready(coletivoCheck());
    $(document).ready(representanteCheck());
</script>
