<?php

set_time_limit(1200);

$con = bancoMysqli();
$conn = bancoPDO();

$usuario = recuperaDados("pessoa_fisica", "idPf", $_SESSION['idUser']);

$sql = "SELECT he.data, pro.idProjeto, nomeProjeto, protocolo, idComissao, pro.dataParecerista, pf.nome, pf.cpf, razaoSocial, cnpj, areaAtuacao, pfc.nome AS comissao, etapaProjeto, pro.idEtapaProjeto AS idEtapaProjeto, pro.publicado, pro.idStatus
                    FROM projeto AS pro
                           LEFT JOIN pessoa_fisica AS pf ON pro.idPf = pf.idPf
                           LEFT JOIN pessoa_juridica AS pj ON pro.idPj = pj.idPj
                           INNER JOIN area_atuacao AS ar ON pro.idAreaAtuacao = ar.idArea
                           LEFT JOIN pessoa_fisica AS pfc ON pro.idComissao = pfc.idPf
                           INNER JOIN etapa_projeto AS st ON pro.idEtapaProjeto = st.idEtapaProjeto
                           LEFT JOIN (
                             SELECT MAX(data) AS data, idProjeto FROM historico_etapa GROUP BY idProjeto
                          ) AS he ON pro.idProjeto = he.idProjeto
                    WHERE pro.publicado = 1 AND pro.idEtapaProjeto = '6' ORDER BY he.data, protocolo ";

$query = mysqli_query($con, $sql);


?>
<section id="list_items" class="home-section bg-white">
	<div class="container"><?php include 'includes/menu_smc.php'; ?>
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive list_info">
                    <table class="table table-condensed">
                        <thead>
                        <tr class="list_menu">
                            <td>Protocolo (nº ISP)</td>
                            <td>Nome do Projeto</td>
                            <td>Proponente</td>
                            <td>Documento</td>
                            <td>Área de Atuação</td>
                            <td>Parecerista</td>
                            <td colspan="2"></td>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        while ($campo = mysqli_fetch_array($query)){
                            ?>
                            <tr style="background: #EBEBEB">
                                <td class="list_description maskProtocolo" data-mask="0000.00.00/0000000">
                                    <?= $campo['protocolo'] ?>
                                </td>
                                <td class="list_description"><?= $campo['nomeProjeto'] ?></td>
                                <td class='list_description'><?= isset($campo['nome']) ? $campo['nome'] : $campo['razaoSocial'] ?></td>
                                <td class='list_description'><?= isset($campo['cpf']) ? $campo['cpf'] : $campo['cnpj'] ?></td>
                                <td class='list_description'><?= mb_strimwidth($campo['areaAtuacao'], 0, 38, "...") ?></td>
                                <td class='list_description'><?= $campo['comissao'] ?></td>
                                <td style='color: #942a25;text-align: center;font-weight: bold;'>
                                    <form method='POST' action='?perfil=cancelado_visualizacao'>
                                        <input type='hidden' name='idProjeto'
                                               value='<?= $campo['idProjeto'] ?>'>
                                        <input style='margin-top: 14px' type='submit' class='btn btn-warning btn-block'
                                               value='Resumo'><small>Cancelado</small>
                                    </form>
                                </td>
                                <td style='color: #942a25;text-align: center;font-weight: bold'>
                                    <button class='btn btn-danger btn-block' data-id='<?= $campo['idProjeto'] ?>' name='arquivar'
                                            data-toggle='modal' data-target='#arquivar'>Arquivar
                                    </button>
                                    <small>Cancelado</small>
                            </tr>
                            <?php
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
	</div>
</section>

<!-- Modal para arquivar projeto -->
<div class="modal fade" id="arquivar" tabindex="-1" role="dialog" aria-labelledby="arquivar">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="arquivar">Deseja arquivar esse projeto?</h4>
            </div>
            <div class="modal-body">
                <p>Para confirmar clique no botão SIM!</p>
            </div>
            <div class="modal-footer">
                <form method='POST' action='' id="formArquivar">
                    <input type='hidden' name='idProjeto' value="">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Não</button>
                    <button type="submit" name='arquivar' class="btn btn-danger">SIM</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $('#enviarComissao').on('show.bs.modal', function (e) {
        let idProjeto = $(e.relatedTarget).attr('data-id');
        $(this).find('#formEnviar input[name="idProjeto"]').attr('value', idProjeto);

    });
    $('#arquivar').on('show.bs.modal', function (e) {
        let idProjeto = $(e.relatedTarget).attr('data-id');
        $(this).find('#formArquivar input[name="idProjeto"]').attr('value', idProjeto);

    });
</script>