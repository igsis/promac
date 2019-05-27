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

if (isset($_POST['cadastraNovoPj']) and $_POST['numero']):
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
    $Complemento = addslashes($_POST['complemento']);
    $imposto = $_POST['imposto'];

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
	`imposto` = '$imposto',
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

$pj = recuperaDados("incentivador_pessoa_juridica", "idPj", $idPj);

if ($pj['liberado'] >= 3) {
    ?>
    <br>
    <div class="container">
        <ul class="nav nav-tabs">
            <li class="nav active"><a href="#admIncentivador" data-toggle="tab">Administrativo</a></li>
            <li class="nav"><a href="#resumo" data-toggle="tab">Resumo do projeto</a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade in active" id="admIncentivador">
                <?php include 'includes/incentivador_adm.php'?>
            </div>
            <div class="tab-pane fade" id="resumo">
                <?php
                    echo "<div class='alert alert-warning'>
	                    <strong>Aviso!</strong> Seus dados já foram aceitos, portanto, não podem ser alterados.</div>";
                        include 'includes/resumo_dados_incentivador_pj.php';
                        include 'includes/resumo_dados_representante_pj.php'
                ?>
            </div>
            <div class="tab-pane fade" id="lolol">
            </div>
        </div>
    </div>
    </div>
    <?php

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
                <h4><?= (isset($mensagem)) ? $mensagem : "" ?></h4>
            </div>
            <div class="row">
                <div class="col-md-offset-1 col-md-10">
                    <form class="form-horizontal" role="form"
                          action="?perfil=cadastro_incentivador_pj" method="post" id="frmCad">
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8"><strong>Razão Social *:</strong><br/>
                                <input type="text" class="form-control" name="razaoSocial"
                                       placeholder="Razão Social" required
                                       value="<?= (!empty($pj['razaoSocial'])) ? $pj['razaoSocial'] : "" ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-6"><strong>CNPJ *:</strong><br/>
                                <input type="text" readonly class="form-control" id="cnpj"
                                       name="cnpj" placeholder="CNPJ" required
                                       value="<?= $pj['cnpj'] ?>">
                            </div>
                            <div class="col-md-6"><strong>E-mail *:</strong><br/>
                                <input type="text" class="form-control" name="email" required
                                       placeholder="E-mail"
                                       value="<?= (!empty($pj['email'])) ? $pj['email'] : ""?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-6"><strong>Telefone :</strong><br/>
                                <input type="text" class="form-control" name="telefone" id="telefone"
                                       onkeyup="mascara( this, mtel );" maxlength="15"
                                       placeholder="Exemplo: (11) 98765-4321"
                                       value="<?= (!empty($pj['telefone'])) ? $pj['telefone'] : ""?>">
                            </div>
                            <div class="col-md-6"><strong>Celular:</strong><br/>
                                <input type="text" class="form-control" name="celular" id="telefone"
                                       onkeyup="mascara( this, mtel );" maxlength="15"
                                       placeholder="Exemplo: (11) 98765-4321"
                                       value="<?= (!empty($pj['celular'])) ? $pj['celular'] : ""?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8"><hr/></div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-6"><strong>CEP *:</strong><br/>
                                <input type="text" class="form-control" id="CEP" name="cep"
                                       placeholder="CEP" required
                                       value="<?= (!empty($pj['cep'])) ? $pj['cep'] : ""?>">
                            </div>
                            <div class="col-md-6" align="left"><br/>
                                <i>Pressione a tecla Tab para carregar</i>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8"><strong>Endereço:</strong><br/>
                                <?php if(!empty($endereco['logradouro'])): ?>
                                    <input type="text" class="form-control" id="Endereco"
                                           name="Endereco" placeholder="Endereço"
                                        <?=$habilitaCampo ? '' : 'readonly'?>
                                           required
                                           value="<?php echo $endereco['logradouro'];?>">
                                <?php elseif(!empty($_POST['Endereco'])): ?>
                                    <input type="text" class="form-control" id="Endereco"
                                           name="Endereco" placeholder="Endereço"
                                        <?=$habilitaCampo ? '' : 'readonly'?>
                                           required
                                           value="<?php echo $_POST['Endereco'];?>">
                                <?php else: ?>
                                    <input type="text" class="form-control" id="Endereco"
                                           name="Endereco" placeholder="Endereço"
                                        <?=$habilitaCampo ? '' : 'readonly'?>
                                           required
                                           value="<?php echo $pj['logradouro'];?>">
                                <?php endif ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-6"><strong>Número *:</strong><br/>
                                <input type="text" class="form-control" id="numero" name="numero"
                                       placeholder="Número" required
                                       value="<?= (!empty($pj['numero'])) ? $pj['numero'] : ""?>">
                            </div>
                            <div class=" col-md-6"><strong>Complemento:</strong><br/>
                                <input type="text" class="form-control" id="complemento"
                                       name="complemento" placeholder="Complemento"
                                       value="<?= (!empty($pj['complemento'])) ? $pj['complemento'] : ""?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8"><strong>Bairro:</strong><br/>
                                <?php if(!empty($endereco['bairro'])): ?>
                                    <input type="text" class="form-control" id="Bairro"
                                           name="Bairro" placeholder="Bairro"
                                        <?=$habilitaCampo ? '' : 'readonly'?>
                                           required
                                           value="<?php echo $endereco['bairro'];?>">
                                <?php elseif(!empty($_POST['Bairro'])): ?>
                                    <input type="text" class="form-control" id="Bairro"
                                           name="Bairro" placeholder="Bairro"
                                        <?=$habilitaCampo ? '' : 'readonly'?>
                                           required
                                           value="<?php echo $_POST['Bairro'];?>">
                                <?php else: ?>
                                    <input type="text" class="form-control" id="Bairro"
                                           name="Bairro" placeholder="Bairro"
                                        <?=$habilitaCampo ? '' : 'readonly'?>
                                           required
                                           value="<?php echo $pj['bairro'];?>">
                                <?php endif ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-6"><strong>Cidade:</strong><br/>
                                <?php
                                if($habilitaCampo): ?>
                                    <select class="form-control" name="cidade" id="Cidade">
                                        <?php foreach($cidades as $cidade):
                                            $selected = $_POST['cidade'] == $cidade ?
                                                "selected='selected'" : ""; ?>
                                            <option value="<?=$cidade?>"<?=$selected?>><?=$cidade?></option>
                                        <?php endforeach ?>
                                    </select>
                                <?php else: ?>
                                    <input type="text" class="form-control" id="Cidade"
                                           name="cidade" required
                                        <?=$habilitaCampo ? '' : 'readonly'?>
                                           value="<?php
                                           if(!empty($endereco['cidade'])):
                                               echo $endereco['cidade'];
                                           elseif(!empty($pj['cidade'])):
                                               echo $pj['cidade'];
                                           elseif(!empty($_POST['cidade'])):
                                               echo $_POST['cidade'];
                                           else:
                                               echo '';
                                           endif?>">
                                <?php endif ?>
                            </div>
                            <div class="col-md-6"><strong>Estado:</strong><br/>
                                <?php
                                if($habilitaCampo): ?>
                                    <select class="form-control" name="estado" id="Estado">
                                        <?php foreach($estados as $estado):
                                            $selected = $_POST['estado'] == $estado ?
                                                "selected='selected'" : ""; ?>
                                            <option value="<?=$estado?>" <?=$selected?>><?=$estado?></option>
                                        <?php endforeach ?>
                                    </select>
                                <?php else: ?>
                                    <input type="text" class="form-control" id="Estado"
                                           name="estado"
                                        <?=$habilitaCampo ? '' : 'readonly'?>
                                           value="<?php
                                           if(!empty($uf)):
                                               echo $uf;
                                           elseif(!empty($pj['estado'])):
                                               echo $pj['estado'];
                                           elseif(!empty($endereco['estado'])):
                                               echo $endereco['estado'];
                                           else:
                                               echo '';
                                           endif?>">
                                <?php endif ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <div class="row">
                                    <label for="">Imposto:</label>
                                </div>

                                <div class="row">
                                    <label class="radio-inline">
                                        <input type="radio" name="imposto"
                                               value="1" <?= ($pj['imposto'] == 1) ? "checked" : "" ?> required>ISS
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="imposto"
                                               value="2" <?= ($pj['imposto'] == 2) ? "checked" : "" ?>>IPTU
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="imposto"
                                               value="3" <?= ($pj['imposto'] == 3) ? "checked" : "" ?>>ISS e IPTU
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Botão para Gravar -->
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <input type="hidden" name="cadastraNovoPj" value="<?php echo $idPj ?>">
                                <input type="submit" value="GRAVAR" class="btn btn-theme btn-lg btn-block">
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