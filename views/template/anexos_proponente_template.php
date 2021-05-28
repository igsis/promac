<?php
require_once "./controllers/ArquivoController.php";
require_once "./controllers/PedidoController.php";

$pedido_id = $_SESSION['pedido_id_c'];

$pedidoObj = new PedidoController();
$arquivosObj = new ArquivoController();

$proponente = $pedidoObj->recuperaProponente($pedido_id);

if ($proponente->pessoa_tipo_id == 1) {
    $tipo_documento_id = 1;
    $proponente_id = $arquivosObj->encryption($proponente->pessoa_fisica_id);
    $url = SERVERURL."pdf/facc_pf.php?id=".$proponente_id;
} else {
    $tipo_documento_id = 2;
    $proponente_id = $arquivosObj->encryption($proponente->pessoa_juridica_id);
    $url = SERVERURL."pdf/facc_pj.php?id=".$proponente_id;
}

$lista_documento_ids = $arquivosObj->recuperaIdListaDocumento($tipo_documento_id)->fetchAll(PDO::FETCH_COLUMN);
?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Anexos do Proponente</h1>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                <div class="card card-warning">
                    <div class="card-header">
                        <h3 class="card-title">Atenção!</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <ul>
                            <li><strong>Formato Permitido:</strong> PDF</li>
                            <li><strong>Tamanho Máximo:</strong> 6Mb</li>
                            <li>Clique nos arquivos após efetuar o upload e confira a exibição do documento!</li>
                        </ul>
                    </div>
                </div>
                <!-- /.card -->
            </div>
            <div class="col-md-9">
                <div class="card card-outline card-info">
                    <div class="card-header">
                        <h3 class="card-title">Gerar documentos</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                            </button>
                        </div>
                        <!-- /.card-tools -->
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <p>Para gerar alguns dos arquivos online, utilize os links abaixo:</p>
                        <ul>
                            <?php
                            if ($proponente->pessoa_tipo_id == 1) {
                                ?>
                                <li><a href="" target="_blank">Cartão CPF</a></li>
                                <li><a href="" target="_blank">Declaração CCM (caso não possua)</a></li>
                                <li><a href="http://www.tst.jus.br/certidao" target="_blank">CNDT - Certidão Negativa de Débitos de Tributos Trabalhistas</a></li>
                                <li><a href="http://servicos.receita.fazenda.gov.br/Servicos/certidao/CNDConjuntaInter/InformaNICertidao.asp?tipo=2" target="_blank">CND Federal - Certidão de Débitos Relativos a Créditos Tributários Federais e à Dívida Ativa da União</a></li>
                                <?php
                            }else {
                                ?>
                                <li><a href="http://www.receita.fazenda.gov.br/pessoajuridica/cnpj/cnpjreva/cnpjreva_solicitacao.asp" target="_blank">Cartão CNPJ</li>
                                <li><a href="https://cpom.prefeitura.sp.gov.br/prestador/SituacaoCadastral" target="_blank">CPOM - Cadastro de Empresas Fora do Município</a></li>
                                <li><a href="https://www.sifge.caixa.gov.br/Cidadao/Crf/FgeCfSCriteriosPesquisa.asp" target="_blank">CRF do FGTS</a></li>
                                <li><a href="http://www.receita.fazenda.gov.br/Aplicacoes/ATSPO/Certidao/CNDConjuntaSegVia/NICertidaoSegVia.asp?Tipo=1" target="_blank">CND Federal - Certidão de Débitos Relativos a Créditos Tributários Federais e à Dívida Ativa da União</a></li>
                                <li><a href="http://www.receita.fazenda.gov.br/Aplicacoes/ATSPO/Certidao/certaut/CndConjunta/ConfirmaAutenticCndSolicitacao.asp?ORIGEM=PJ" target="_blank">Autenticidade de CND ­ Certidão de Débitos Relativos a Créditos Tributários Federais e à Dívida Ativa da União (CND)</a></li>
                                <?php
                            }
                            ?>
                            <li><a href="https://duc.prefeitura.sp.gov.br/certidoes/forms_anonimo/frmConsultaEmissaoCertificado.aspx" target="_blank">CTM - Certidão Negativa de Débitos Tributários Mobiliários Municipais de São Paulo</a></li>
                            <li><a href="http://www3.prefeitura.sp.gov.br/cadin/Pesq_Deb.aspx" target="_blank">CADIN Municipal</a></li>
                            <li><a href="https://ccm.prefeitura.sp.gov.br/login/contribuinte?tipo=F" target="_blank">FDC CCM - Ficha de Dados Cadastrais de Contribuintes Mobiliários</a></li>
                            <li><a href="#" onclick="alerta();">FACC - Ficha de Atualização de Cadastro de Credores</a></li>
                        </ul>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <!-- Horizontal Form -->
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Lista de Arquivos</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- table start -->
                    <div class="card-body p-0">
                        <form class="formulario-ajax" method="POST" action="<?=SERVERURL?>ajax/arquivosAjax.php" data-form="save" enctype="multipart/form-data">
                            <input type="hidden" name="_method" value="enviarArquivo">
                            <input type="hidden" name="origem_id" value="<?= $proponente_id ?>">
                            <input type="hidden" name="pagina" value="<?=$_GET['views']?>">
                            <table class="table table-striped">
                                <tbody>
                                <?php
                                $arquivos = $arquivosObj->listarArquivos($tipo_documento_id)->fetchAll(PDO::FETCH_OBJ);
                                foreach ($arquivos as $arquivo) {
                                    if ($arquivosObj->consultaArquivoEnviado($arquivo->id, $proponente_id)) {
                                        ?>
                                        <tr>
                                            <td colspan="2">
                                                <div class="callout callout-success text-center">
                                                    Arquivo <strong><?= $arquivo->documento ?></strong> já enviado!
                                                </div>
                                            </td>
                                        </tr>
                                    <?php } else { ?>
                                        <tr>
                                            <td>
                                                <label for=""><?=$arquivo->documento?></label>
                                            </td>
                                            <td>
                                                <input type="hidden" name="<?=$arquivo->sigla?>" value="<?=$arquivo->id?>">
                                                <input class="text-center" type='file' name='<?=$arquivo->sigla?>'><br>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>
                                </tbody>
                            </table>
                            <input type="submit" class="btn btn-success btn-md btn-block" name="enviar" value='Enviar'>

                            <div class="resposta-ajax"></div>
                        </form>
                    </div>
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
            <div class="col-md-6">
                <!-- Horizontal Form -->
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Aquivos anexados</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- table start -->
                    <div class="card-body p-0">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>Tipo do documento</th>
                                <th>Nome do documento</th>
                                <th style="width: 30%">Data de envio</th>
                                <th style="width: 10%">Ação</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $arquivosEnviados = $arquivosObj->listarArquivosEnviados($proponente_id, $lista_documento_ids)->fetchAll(PDO::FETCH_OBJ);
                            if (count($arquivosEnviados) != 0) {
                                foreach ($arquivosEnviados as $arquivo) {
                                    ?>
                                    <tr>
                                        <td><?= $arquivo->documento ?></td>
                                        <td><a href="<?=SERVERURL."uploads/".$arquivo->arquivo?>" target="_blank"><?= $arquivo->arquivo ?></a></td>
                                        <td><?= $arquivosObj->dataParaBR($arquivo->data) ?></td>
                                        <td>
                                            <form class="formulario-ajax" action="<?=SERVERURL?>ajax/arquivosAjax.php" method="POST" data-form="delete">
                                                <input type="hidden" name="_method" value="removerArquivo">
                                                <input type="hidden" name="pagina" value="<?=$_GET['views']?>">
                                                <input type="hidden" name="arquivo_id" value="<?=$arquivosObj->encryption($arquivo->id)?>">
                                                <button type="submit" class="btn btn-sm btn-danger">Apagar</button>
                                                <div class="resposta-ajax"></div>
                                            </form>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                ?>
                                <tr>
                                    <td class="text-center" colspan="3">Nenhum arquivo enviado</td>
                                </tr>
                                <?php
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>

                </div>
                <!-- /.card -->
            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->

<script>
    function alerta(){
            Swal.fire({
                title: 'FACC - Ficha de Atualização de Cadastro de Credores',
                html: 'A FACC é um documento necessário para recebimento do cachê. Após inserir seus dados pessoais e os dados bancários, clique no botão para gerar a FACC. <br><span style="color:red">Deve ser impressa, datada e assinada nos campos indicados no documento</span>.<br>Logo após, deve-se digitaliza-la e então anexa-la ao sistema através do campo abaixo.',
                type: 'warning',
                allowOutsideClick: false,
                allowEscapeKey: false,
                showCancelButton: false,
                confirmButtonText: 'Confirmar'
            }).then(function() {
                window.open('<?=$url?>', '_blank');
            });
        }
</script>

<script type="application/javascript">
    $(document).ready(function () {
        $('.nav-link').removeClass('active');
        $('#itens-proponente').addClass('menu-open');
        $('#anexos-proponente').addClass('active');
    })
</script>