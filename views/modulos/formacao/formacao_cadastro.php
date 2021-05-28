<?php
$url_cargos = SERVERURL.'api/api_formacao_cargos.php';

$id = isset($_GET['idC']) ? $_GET['idC'] : null;
require_once "./controllers/FormacaoController.php";
$formObj = new FormacaoController();

$ano = $_SESSION['ano_c'];

if ($id) {
    $form = $formObj->recuperaFormacao($ano, false, $id);
    $idPf = $_SESSION['origem_id_c'];
    $form = $formObj->recuperaFormacao($ano, $idPf);
}
?>

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Dados complementares</h1>
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
                        <h3 class="card-title">Ano de execução so serviço:</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form class="form-horizontal formulario-ajax" method="POST" action="<?= SERVERURL ?>ajax/formacaoAjax.php" role="form" data-form="<?= ($id) ? "update" : "save" ?>">
                        <input type="hidden" name="_method" value="<?= ($id) ? "editar" : "cadastrar" ?>">
                        <input type="hidden" name="ano" value="<?= $_SESSION['ano_c'] ?>">
                        <input type="hidden" name="usuario_id" value="<?= $_SESSION['usuario_id_c'] ?>">
                        <?php if ($id): ?>
                            <input type="hidden" name="id" value="<?= $id ?>">
                        <?php endif; ?>
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col">
                                    <label for="regiao_preferencial_id">Região preferencial: *</label>
                                    <select class="form-control" id="regiao_preferencial_id" name="regiao_preferencial_id" required>
                                        <option value="">Selecione uma opção...</option>
                                        <?php
                                        $formObj->geraOpcao("form_regioes_preferenciais",$form->regiao_preferencial_id);
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group col">
                                    <label for="programa_id">Programa: *</label>
                                    <select class="form-control" id="programa" name="programa_id" required>
                                        <option value="">Selecione uma opção...</option>
                                        <?php
                                        $formObj->geraOpcao("programas",$form->programa_id ?? "", true, false, false, true);
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group col">
                                    <label for="linguagem_id">Linguagem: *</label>
                                    <select class="form-control" id="linguagem_id" name="linguagem_id" required>
                                        <option value="">Selecione uma opção...</option>
                                        <?php
                                        $formObj->geraOpcao("linguagens",$form->linguagem_id, true, false, false, true);
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col">
                                    <label for="">Função (1ª opção): *</label>
                                    <select class="form-control" id="cargo1" name="form_cargo_id" required>
                                        <option value="">Selecione o Programa...</option>
                                    </select>
                                </div>
                                <div class="form-group col">
                                    <label for="">Função (2ª opção):</label>
                                    <select class="form-control" id="cargo2" name="form_cargo2_id" disabled>
                                        <option value="">Selecione o Programa...</option>
                                    </select>
                                </div>
                                <div class="form-group col">
                                    <label for="">Função (3ª opção):</label>
                                    <select class="form-control" id="cargo3" name="form_cargo3_id" disabled>
                                        <option value="">Selecione o Programa...</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-info float-right">Gravar</button>
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

<script type="application/javascript">
    $(document).ready(function () {
        $('.nav-link').removeClass('active');
        $('#programa').addClass('active');
    })

    const url_cargos = '<?= $url_cargos ?>';

    let programa = document.querySelector('#programa');
    let cargo1 = document.querySelector('#cargo1');
    let cargo2 = document.querySelector('#cargo2');

    if (programa.value != '') {
        let idPrograma = <?= $form->programa_id ?? "false" ?>;
        let idCargo1 = <?= $form->form_cargo_id ?? "false" ?>;
        let idCargo2 = <?= $form->form_cargo2_id ?? "false" ?>;
        let idCargo3 = <?= $form->form_cargo3_id ?? "false" ?>;
        getCargos(idPrograma, idCargo1, idCargo2, idCargo3);
    }

    programa.addEventListener('change', async e => {
        let idPrograma = $('#programa option:checked').val();
        getCargo1(idPrograma);

        $('#cargo2').attr('disabled', true);
        $('#cargo2').attr('required', false);
        $('#cargo2 option').remove();
        $('#cargo2').append('<option value="">Selecione a Função 1...</option>');

        $('#cargo3').attr('disabled', true);
        $('#cargo3').attr('required', false);
        $('#cargo3 option').remove();
        $('#cargo3').append('<option value="">Selecione a Função 1...</option>');
    });

    cargo1.addEventListener('change', async e => {
        let idPrograma = $('#programa option:checked').val();
        let idCargo1 = $('#cargo1 option:checked').val();
        if ((idCargo1 != 4) && (idCargo1 != 5)) {
            getCargo2(idPrograma, idCargo1)

            $('#cargo3').attr('disabled', true);
            $('#cargo3 option').remove();
            $('#cargo3').append('<option value="">[Opcional] Selecione a Função 2...</option>');
        } else {
            $('#cargo2').attr('disabled', true);
            $('#cargo2 option').remove();
            $('#cargo2').append('<option value="">Opção não necessária...</option>');

            $('#cargo3').attr('disabled', true);
            $('#cargo3 option').remove();
            $('#cargo3').append('<option value="">Opção não necessária...</option>');
        }
    });

    cargo2.addEventListener('change', async e => {
        let idPrograma = $('#programa option:checked').val();
        let idCargo1 = $('#cargo1 option:checked').val();
        let idCargo2 = $('#cargo2 option:checked').val();

        if (idCargo2 != "") {
            getCargo3(idPrograma, idCargo1, idCargo2);
        } else {
            $('#cargo3').attr('disabled', true);
            $('#cargo3 option').remove();
            $('#cargo3').append('<option value="">[Opcional] Selecione a Função 2...</option>');
        }
    });
    function getCargos(idPrograma, idCargo1, idCargo2 = false, idCargo3 = false){

        getCargo1(idPrograma, idCargo1);

        if ((idCargo1 == 4) || (idCargo1 == 5)) {
            $('#cargo2').attr('disabled', true);
            $('#cargo2 option').remove();
            $('#cargo2').append('<option value="">Opção não necessária...</option>');

            $('#cargo3').attr('disabled', true);
            $('#cargo3 option').remove();
            $('#cargo3').append('<option value="">Opção não necessária...</option>');
        } else {

            if (idCargo2) {
                getCargo2(idPrograma, idCargo1, idCargo2);
            } else {
                getCargo2(idPrograma, idCargo1);
            }

            if (idCargo3) {
                getCargo3(idPrograma, idCargo1, idCargo2, idCargo3);
            } else {
                $('#cargo3').attr('disabled', true);
                $('#cargo3 option').remove();
                $('#cargo3').append('<option value="">[Opcional] Selecione a Função 2...</option>');
            }
        }
    }

    function getCargo1(idPrograma, idCargo1 = '') {
        fetch(`${url_cargos}?busca=1&programa_id=${idPrograma}`)
            .then(response => response.json())
            .then(cargos1 => {
                $('#cargo1 option').remove();
                $('#cargo1').append('<option value="">Selecione uma opção...</option>');

                for (const cargo1 of cargos1) {
                    if(idCargo1 == cargo1.id) {
                        $('#cargo1').append(`<option value='${cargo1.id}' selected>${cargo1.cargo}</option>`).focus();
                    } else {
                        $('#cargo1').append(`<option value='${cargo1.id}'>${cargo1.cargo}</option>`).focus();
                    }

                }
            });
    }

    function getCargo2(idPrograma, idCargo1, idCargo2 = '') {
        fetch(`${url_cargos}?busca=2&programa_id=${idPrograma}&cargo1_id=${idCargo1}`)
            .then(response => response.json())
            .then(cargos2 => {
                $('#cargo2').attr('disabled', false);
                $('#cargo2 option').remove();
                $('#cargo2').append('<option value="">[Opcional] Selecione uma opção...</option>');

                for (const cargo2 of cargos2) {
                    if(idCargo2 == cargo2.id) {
                        $('#cargo2').append(`<option value='${cargo2.id}' selected>${cargo2.cargo}</option>`).focus();
                    } else {
                        $('#cargo2').append(`<option value='${cargo2.id}'>${cargo2.cargo}</option>`).focus();
                    }

                }
            })
    }

    function getCargo3(idPrograma, idCargo1, idCargo2, idCargo3 = '') {
        fetch(`${url_cargos}?busca=3&programa_id=${idPrograma}&cargo1_id=${idCargo1}&cargo2_id=${idCargo2}`)
            .then(response => response.json())
            .then(cargos3 => {
                $('#cargo3').attr('disabled', false);
                $('#cargo3 option').remove();
                $('#cargo3').append('<option value="">[Opcional] Selecione uma opção...</option>');
                for (const cargo3 of cargos3) {
                    if(idCargo3 == cargo3.id) {
                        $('#cargo3').append(`<option value='${cargo3.id}' selected>${cargo3.cargo}</option>`).focus();
                    } else {
                        $('#cargo3').append(`<option value='${cargo3.id}'>${cargo3.cargo}</option>`).focus();
                    }
                }
            })
    }
</script>