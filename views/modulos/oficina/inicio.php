<?php
if (isset($_GET['modulo'])) {
    $_SESSION['modulo_c'] = $_GET['modulo'];
}
?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <h1 class="m-0 text-dark">Resumo das informações para preenchimento do cadastro</h1>
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
                <p class="card-text">
                    Inicia-se aqui um processo passo-a-passo para o preenchimento dos dados do oficineiro conforme descrito abaixo. Antes de começar, tenha disponível estas informações para que o cadastro possa ser concluído.
                </p>
                <div class="card card-info card-outline">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-edit"></i>
                            Cadastro de oficineiros
                        </h3>
                    </div>
                    <div class="card-body">
                        <p class="text-info"><b>Informações iniciais</b></p>
                        <ul>
                            <li>Nome da oficina</li>
                            <li>Espaço em que será realizado o evento é público? (sim ou não)</li>
                            <li>É fomento/programa? (se sim, indicar qual)</li>
                            <li>Público (Representatividade e Visibilidade Sócio-cultural)</li>
                            <li>Sinopse</li>
                            <li>Ficha técnica completa</li>
                            <li>Integrantes</li>
                            <li>Classificação indicativa</li>
                            <li>Links</li>
                        </ul>
                        <br>
                        <p class="text-info"><b>Dados complementares da oficina</b></p>
                        <ul>
                            <li>Modalidade</li>
                            <li>Data inicial</li>
                            <li>Data final</li>
                            <li>Dia execução 1 (segunda, terça, quarta, etc)</li>
                            <li>Dia execução 2 (segunda, terça, quarta, etc)</li>
                        </ul>
                        <br>
                        <p class="text-info"><b>Produtor</b></p>
                        <ul>
                            <li>Nome</li>
                            <li>E-mail</li>
                            <li>Telefones</li>
                        </ul>
                        <br>
                        <p class="text-info"><b>Comunicação/Produção Anexos</b></p>
                        <ul>
                            <li>Nesta página você envia os arquivos como o rider, mapas de cenas e luz, logos de parceiros, programação de filmes de mostras de cinema, entre outros arquivos destinados à comunicação e produção.</li>
                        </ul>
                        <br>
                        <p class="text-info"><b>Proponente</b></p>
                        <p>Escolha entre "Pessoa Física" ou "Pessoa Jurídica"</p>

                        <ul class="nav nav-tabs" id="custom-content-above-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="custom-content-above-home-tab" data-toggle="pill" href="#custom-content-above-home" role="tab" aria-controls="custom-content-above-home" aria-selected="true">Pessoa Física</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="custom-content-above-profile-tab" data-toggle="pill" href="#custom-content-above-profile" role="tab" aria-controls="custom-content-above-profile" aria-selected="false">Pessoa Jurídica</a>
                            </li>
                        </ul>

                        <div class="tab-content" id="custom-content-above-tabContent">
                            <div class="tab-pane fade show active" id="custom-content-above-home" role="tabpanel" aria-labelledby="custom-content-above-home-tab">
                                <br>
                                <p class="text-info"><b>Informações iniciais</b></p>
                                <ul>
                                    <li>Nome</li>
                                    <li>Nome artístico</li>
                                    <li>Tipo do documento</li>
                                    <li>Nº do documento</li>
                                    <li>CPF</li>
                                    <li>CCM</li>
                                    <li>Telefones</li>
                                    <li>E-mail</li>
                                    <li>Data de nascimento</li>
                                </ul>
                                <br>
                                <p class="text-info"><b>Arquivos da Pessoa</b></p>
                                <ul>
                                    <li>RG/RNE/PASSAPORTE</li>
                                    <li>CPF</li>
                                    <li>PIS/PASEP/NIT</li>
                                    <li>FDC – CCM (Ficha de Dados Cadastrais de Contribuintes Mobiliários)</li>
                                </ul>
                                <br>
                                <p class="text-info"><b>Endereço</b></p>
                                <ul>
                                    <li>CEP</li>
                                    <li>Número</li>
                                    <li>Complemento</li>
                                    <li>Prefeitura Regional</li>
                                    <li>Comprovante de Residência</li>
                                </ul>
                                <br>
                                <p class="text-info"><b>Informações Complementares</b></p>
                                <ul>
                                    <li>Nível</li>
                                    <li>Linguagem</li>
                                    <li>Curriculo</li>
                                </ul>
                                <br>
                                <p class="text-info"><b>Dados Bancários</b></p>
                                <div class="alert alert-danger">Realizamos pagamentos de valores acima de R$ 5.000,00 *SOMENTE COM CONTA CORRENTE NO BANCO DO BRASIL*.<br />Não são aceitas: conta fácil, poupança e conjunta.</div>
                                <ul>
                                    <li>Banco</li>
                                    <li>Agência</li>
                                    <li>Conta</li>
                                </ul>
                                <br>
                                <p class="text-info"><b>Demais anexos</b></p>
                                <ul>
                                    <li>CTM - Certidão Negativa de Débitos Tributários Mobiliários Municipais</li>
                                    <li>CADIN Municipal</li>
                                    <li>CND Federal - (Certidão Negativa de Débitos de Tributos Federais)</li>
                                    <li>CNDT - Certidão Negativa de Débitos de Tributos Trabalhistas</li>
                                    <li>Comprovante de experiência artístico-pedagógica (no mínimo 2)</li>
                                    <li>Comprovante de experiência artística (no mínimo 2)</li>
                                </ul>
                                <br>
                                <p class="text-info"><b>Finalizar</b></p>
                                <ul>
                                    <li>Nesta tela haverá um resumo com todas as informações inseridas neste evento</li>
                                    <li>Listará também, quando existirem, os campos pendente para preenchimento</li>
                                </ul>
                            </div>

                            <div class="tab-pane fade" id="custom-content-above-profile" role="tabpanel" aria-labelledby="custom-content-above-profile-tab">
                                <br>
                                <div class="alert alert-danger">Somente com MEI</div>
                                <p class="text-info"><b>Informações iniciais</b></p>
                                <ul>
                                    <li>Razão Social</li>
                                    <li>CNPJ</li>
                                    <li>CCM</li>
                                    <li>Telefones</li>
                                    <li>E-mail</li>
                                </ul>
                                <br>
                                <p class="text-info"><b>Arquivos da empresa em PDF</b></p>
                                <ul>
                                    <li><a href="http://www.receita.fazenda.gov.br/pessoajuridica/cnpj/cnpjreva/cnpjreva_solicitacao.asp" target="_blank">Cartão CNPJ</a></li>
                                    <li><a href="https://ccm.prefeitura.sp.gov.br/login/contribuinte?tipo=F" target="_blank">FDC CCM - Ficha de Dados Cadastrais de Contribuintes Mobiliários</a></li>
                                    <li><a href="https://www3.prefeitura.sp.gov.br/cpom2/Consulta_Tomador.aspx" target="_blank">CPOM - Cadastro de Empresas Fora do Município</a></li>
                                </ul>
                                <br>
                                <p class="text-info"><b>Endereço</b></p>
                                <ul>
                                    <li>CEP</li>
                                    <li>Número</li>
                                    <li>Complemento</li>
                                    <li>Prefeitura Regional</li>
                                </ul>
                                <br>
                                <p class="text-info"><b>Informações Complementares</b></p>
                                <ul>
                                    <li>Nível</li>
                                    <li>Linguagem</li>
                                    <li>Curriculo</li>
                                </ul>
                                <br>
                                <p class="text-info"><b>Representante Legal</b></p>
                                <ul>
                                    <li>Nome</li>
                                    <li>RG/RNE/PASSAPORTE</li>
                                    <li>CPF</li>
                                </ul>
                                <br>
                                <p class="text-info"><b>Arquivos do Representante Legal em PDF</b></p>
                                <ul>
                                    <li>RG/RNE/PASSAPORTE</li>
                                    <li>CPF</li>
                                </ul>
                                <br>
                                <p class="text-info"><b>Dados Bancários</b></p>
                                <div class="alert alert-danger">Realizamos pagamentos de valores acima de R$ 5.000,00 *SOMENTE COM CONTA CORRENTE NO BANCO DO BRASIL*.<br />Não são aceitas: conta fácil, poupança e conjunta.<br>*A conta deve estar em nome da Pessoa Jurídica que está sendo contratada*</div>
                                <ul>
                                    <li>Banco</li>
                                    <li>Agência</li>
                                    <li>Conta</li>
                                </ul>
                                <br>
                                <p class="text-info"><b>Demais anexos</b></p>
                                <ul>
                                    <li><a href="https://www.sifge.caixa.gov.br/Cidadao/Crf/FgeCfSCriteriosPesquisa.asp" target="_blank">CRF do FGTS</a></li>
                                    <li><a href="https://duc.prefeitura.sp.gov.br/certidoes/forms_anonimo/frmConsultaEmissaoCertificado.aspx" target="_blank">CTM - Certidão Negativa de Débitos Tributários Mobiliários Municipais</a></li>
                                    <li><a href="http://www3.prefeitura.sp.gov.br/cadin/Pesq_Deb.aspx" target="_blank">CADIN Municipal</a></li>
                                    <li><a href="http://www.receita.fazenda.gov.br/Aplicacoes/ATSPO/Certidao/CNDConjuntaSegVia/NICertidaoSegVia.asp?Tipo=1" target="_blank">CND Federal - (Certidão Negativa de Débitos de Tributos Federais)</a></li>
                                    <li>CNDT - Certidão Negativa de Débitos de Tributos Trabalhistas</li>
                                    <li>Declaração de Aceite</li>
                                    <li>Comprovante de experiência artístico-pedagógica (no mínimo 2)</li>
                                    <li>Comprovante de experiência artística (no mínimo 2)</li>
                                </ul>
                                <br>
                                <p class="text-info"><b>Finalizar</b></p>
                                <ul>
                                    <li>Nesta tela haverá um resumo com todas as informações inseridas neste evento</li>
                                    <li>Listará também, quando existirem, os campos pendente para preenchimento</li>
                                </ul>
                            </div>
                            <div class="offset-md-4 col-md-4">
                                <a href="<?= SERVERURL ?>oficina/evento_lista"><button class="btn btn-block btn-success">Clique aqui para começar</button></a>
                            </div>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.card -->
            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->
