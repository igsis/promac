<?php
$con = bancoMysqli();
$idPj = $_SESSION['idUser'];
$pj = recuperaDados("incentivador_pessoa_juridica", "idPj", $idPj);
$estados = formataDados(listaEstados());
$cidades = formataDados(listaCidades());
$habilitaCampo = false;
$userIn = $pj['razaoSocial'] . ' [ID=' . $pj['idPj'] . ']';

if (isset($_POST['cep'])):
    $enderecos = retornaEndereco($_POST['cep']);

    if (isset($enderecos)):
        $endereco = configuraEndereco($enderecos);
        $uf = implode("", retornaUf($_POST['cep']));
    endif;
endif;


if (isset($_POST['cep']) and empty($enderecos)): $habilitaCampo = true; ?>
    <div class="alert alert-warning">
        <p>O cep: <b><?= $_POST['cep'] ?></b> não foi localizado. Informe manualmente</p>
    </div>
<?php endif;


if (isset($_POST['cadastraNovoPj']) and $_POST['numero'] and empty($endereco)):
    $razaoSocial = addslashes($_POST['razaoSocial']);
    $cnpj = $_POST['cnpj'];
    $telefone = $_POST['telefone'];
    $celular = $_POST['celular'];
    $email = $_POST['email'];
    $Endereco = addslashes($_POST['Endereco']);
    $Bairro = addslashes($_POST['Bairro']);
    $Cidade = addslashes($_POST['cidade']);
    $Estado = $_POST['estado'];
    $CEP = $_POST['cep'];
    $Numero = $_POST['numero'];
    $Complemento = addslashes($_POST['Complemento']);

    $validar = array(
        $_POST['Endereco'],
        $_POST['Bairro'],
        $_POST['cidade'],
        $_POST['estado'],
        $_POST['cep'],
        $_POST['numero']
    );

    $sql_atualiza_pj = "UPDATE incentivador_pessoa_juridica SET
    `razaoSocial` = '$razaoSocial',
    `telefone` = '$telefone',
	`celular` = '$celular',
	`email` = '$email',
	`logradouro` = '$Endereco',
	`bairro` = '$Bairro',
	`cidade` = '$Cidade',
	`estado` = '$Estado',
	`cep` = '$CEP',
	`numero` = '$Numero',
	`complemento` = '$Complemento',
	`alteradoPor` = '$userIn'
	WHERE `idPj` = '$idPj'";

    if (mysqli_query($con, $sql_atualiza_pj)) {
        if (in_array(null, $validar)) {
            $mensagem = "<font color='#ff2100'><strong>Seu cadastro possui campos pendêntes!</strong></font>";
        } else {
            $mensagem = "<font color='#01DF3A'><strong>Atualizado com sucesso! Utilize o menu para avançar.</strong></font>";
        }

        gravarLog($sql_atualiza_pj);
    } else {
        $mensagem = "<font color='#FF0000'><strong>Erro ao atualizar! Tente novamente.</strong></font>";
    }
endif;

if ($pj['liberado'] == 3) {
    echo "<div class='alert alert-warning'>
	<strong>Aviso!</strong> Seus dados já foram aceitos, portanto, não podem ser alterados.</div>";

    include 'includes/resumo_dados_incentivador_pj.php';
} elseif ($pj['liberado'] == 1) {
    echo "<div class='alert alert-warning'>
	<strong>Aviso!</strong> Seus dados foram encaminhados para análise, portanto, não podem ser alterados.</div>";

    include 'includes/resumo_dados_incentivador_pj.php';
} else {
    ?>

    <section id="contact" class="home-section bg-white">
        <div class="container"><?php include 'includes/menu_interno_pj.php'; ?>
            <div class="form-group">
                <h4>Cadastro de Incentivador<br>
                    <small>Pessoa Jurídica</small>
                </h4>
                <h4><?php if (isset($mensagem)) {
                        echo $mensagem;
                    }; ?></h4>
            </div>
            <div class="row">
                <div class="col-md-offset-1 col-md-10">
                    <form class="form-horizontal" role="form"
                          action="?perfil=cadastro_incentivador_pj" method="post" id="frmCad">
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8"><strong>Razão Social *:</strong><br/>
                                <input type="text" class="form-control" name="razaoSocial"
                                       placeholder="Razão Social" required
                                       value="<?php
                                       if (!empty($_POST['razaoSocial'])):
                                           echo $_POST['razaoSocial'];
                                       elseif (!empty($pj['razaoSocial'])):
                                           echo $pj['razaoSocial'];
                                       else:
                                           echo '';
                                       endif
                                       ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-6"><strong>CNPJ *:</strong><br/>
                                <input type="text" readonly class="form-control" id="cnpj"
                                       name="cnpj" placeholder="CNPJ" required
                                       value="<?php echo $pj['cnpj']; ?>">
                            </div>
                            <div class="col-md-6"><strong>E-mail *:</strong><br/>
                                <input type="text" class="form-control" name="email" required
                                       placeholder="E-mail"
                                       value="<?php
                                       if (!empty($_POST['email'])):
                                           echo $_POST['email'];
                                       elseif (!empty($pj['email'])):
                                           echo $pj['email'];
                                       else:
                                           echo '';
                                       endif
                                       ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-6"><strong>Telefone :</strong><br/>
                                <input type="text" class="form-control" name="telefone" id="telefone"
                                       onkeyup="mascara( this, mtel );" maxlength="15"
                                       placeholder="Exemplo: (11) 98765-4321"
                                       value="<?php
                                       if (!empty($_POST['telefone'])):
                                           echo $_POST['telefone'];
                                       elseif (!empty($pj['telefone'])):
                                           echo $pj['telefone'];
                                       else:
                                           echo '';
                                       endif
                                       ?>">
                            </div>
                            <div class="col-md-6"><strong>Celular:</strong><br/>
                                <input type="text" class="form-control" name="celular" id="telefone"
                                       onkeyup="mascara( this, mtel );" maxlength="15"
                                       placeholder="Exemplo: (11) 98765-4321"
                                       value="<?php
                                       if (!empty($_POST['celular'])):
                                           echo $_POST['celular'];
                                       elseif (!empty($pj['celular'])):
                                           echo $pj['celular'];
                                       else:
                                           echo '';
                                       endif
                                       ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <hr/>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-6"><strong>CEP *:</strong><br/>
                                <input type="text" class="form-control" id="CEP"
                                       name="cep" placeholder="CEP" required
                                       value="<?php
                                       if (!empty($_POST['cep'])):
                                           echo $_POST['cep'];
                                       elseif (!empty($pj['cep'])):
                                           echo $pj['cep'];
                                       else:
                                           echo '';
                                       endif
                                       ?>">
                            </div>
                            <div class="col-md-6" align="left"><br/>
                                <i>Pressione a tecla Tab para carregar</i>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8"><strong>Endereço:</strong><br/>
                                <?php if (!empty($endereco['logradouro'])): ?>
                                    <input type="text" class="form-control" id="Endereco"
                                           name="Endereco" placeholder="Endereço" required
                                           value="<?php echo $endereco['logradouro']; ?>">
                                <?php elseif (!empty($_POST['Endereco'])): ?>
                                    <input type="text" class="form-control" id="Endereco"
                                           name="Endereco" placeholder="Endereço"
                                           required
                                           value="<?php echo $_POST['Endereco']; ?>">
                                <?php else: ?>
                                    <input type="text" class="form-control" id="Endereco"
                                           name="Endereco" placeholder="Endereço"
                                           required
                                           value="<?php echo $pj['logradouro']; ?>">
                                <?php endif ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-6"><strong>Número *:</strong><br/>
                                <input type="text" class="form-control" id="numero" name="numero"
                                       placeholder="Numero" required
                                       value="<?php
                                       if (!empty($_POST['numero'])):
                                           echo $_POST['numero'];
                                       elseif (!empty($pj['numero'])):
                                           echo $pj['numero'];
                                       else:
                                           echo '';
                                       endif
                                       ?>">
                            </div>
                            <div class=" col-md-6"><strong>Complemento:</strong><br/>
                                <input type="text" class="form-control" id="Complemento"
                                       name="Complemento" placeholder="Complemento"
                                       value="<?php
                                       if (!empty($_POST['complemento'])):
                                           echo $_POST['complemento'];
                                       elseif (!empty($pj['complemento'])):
                                           echo $pj['complemento'];
                                       else:
                                           echo '';
                                       endif
                                       ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8"><strong>Bairro:</strong><br/>
                                <?php if (!empty($endereco['bairro'])): ?>
                                    <input type="text" class="form-control" id="Bairro"
                                           name="Bairro" placeholder="Bairro"
                                           required
                                           value="<?php echo $endereco['bairro']; ?>">
                                <?php elseif (!empty($_POST['Bairro'])): ?>
                                    <input type="text" class="form-control" id="Bairro"
                                           name="Bairro" placeholder="Bairro"
                                           required
                                           value="<?php echo $_POST['Bairro']; ?>">
                                <?php else: ?>
                                    <input type="text" class="form-control" id="Bairro"
                                           name="Bairro" placeholder="Bairro"
                                           required
                                           value="<?php echo $pj['bairro']; ?>">
                                <?php endif ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-6"><strong>Cidade:</strong><br/>
                                <input type="text" class="form-control" id="Cidade"
                                       name="cidade" required
                                       value="<?php
                                       if (!empty($endereco['cidade'])):
                                           echo $endereco['cidade'];
                                       elseif (!empty($pj['cidade'])):
                                           echo $pj['cidade'];
                                       elseif (!empty($_POST['cidade'])):
                                           echo $_POST['cidade'];
                                       else:
                                           echo '';
                                       endif ?>">
                            </div>
                            <div class="col-md-6"><strong>Estado:</strong><br/>
                                <input type="text" class="form-control" id="Estado"
                                       name="estado"
                                       value="<?php
                                       if (!empty($uf)):
                                           echo $uf;
                                       elseif (!empty($pj['estado'])):
                                           echo $pj['estado'];
                                       elseif (!empty($endereco['estado'])):
                                           echo $endereco['estado'];
                                       else:
                                           echo '';
                                       endif ?>">
                            </div>
                        </div>

                        <!-- Botão para Gravar -->
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <input type="hidden" name="cadastraNovoPj">
                                <input type="submit" value="Enviar" class="btn btn-theme btn-lg btn-block">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <script language="JavaScript" type="text/javascript">
        var cep = document.querySelector('#cep');

        $(function () {
            pegaCep();
        });

        function pegaCep() {
            cep.addEventListener('focusout', function () {
                form = document.querySelector('#frmCad');

            });
        }
    </script>
    <?php
}
?>