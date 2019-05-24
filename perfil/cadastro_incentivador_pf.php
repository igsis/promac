<?php
$con = bancoMysqli();
$idPf = $_SESSION['idUser'];
$pf = recuperaDados("incentivador_pessoa_fisica", "idPf", $idPf);
$estados = formataDados(listaEstados());
$cidades = formataDados(listaCidades());
$habilitaCampo = false;
$userIn = $pf['nome'] . ' [ID=' . $pf['idPf'] . ']';

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

if (isset($_POST['cadastraNovoPf']) and $_POST['numero']):
    $nome = addslashes($_POST['nome']);
    $rg = $_POST['rg'];
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

    $validar = array(
        $_POST['Endereco'],
        $_POST['Bairro'],
        $_POST['cidade'],
        $_POST['estado'],
        $_POST['cep'],
        $_POST['numero']
    );

    $sql_atualiza_pf = "UPDATE incentivador_pessoa_fisica SET
    `nome` = '$nome',
	`rg` = '$rg',
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
  WHERE `idPf` = '$idPf'";


    if (mysqli_query($con, $sql_atualiza_pf)) {
        if (in_array(null, $validar)) {
            $mensagem = "<font color='#ff2100'><strong>Seu cadastro possui campos pendêntes!</strong></font>";
        } else {
            $mensagem = "<font color='#01DF3A'><strong>Atualizado com sucesso! Utilize o menu para avançar.</strong></font>";
        }

        gravarLog($sql_atualiza_pf);
    } else {
        $mensagem = "<font color='#FF0000'><strong>Erro ao atualizar! Tente novamente.</strong></font>";
    }
endif;

$pf = recuperaDados("incentivador_pessoa_fisica", "idPf", $idPf);

if ($pf['liberado'] == 3) {
    ?>
    <br>
    <div class="container">
        <ul class="nav nav-tabs">
            <li class="nav active"><a href="#resumo" data-toggle="tab">Resumo do projeto</a></li>
            <li class="nav"><a href="#admIncentivador" data-toggle="tab">Administrativo</a></li>
            <li class="nav"><a href="#lolol" data-toggle="tab">lalal</a></li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane fade in active" id="resumo">
                <?php
                    echo "<div class='alert alert-warning'>
	                    <strong>Aviso!</strong> Seus dados já foram aceitos, portanto, não podem ser alterados.</div>";
                    include 'includes/resumo_dados_incentivador_pf.php';
                ?>
            </div>

            <div class="tab-pane fade" id="admIncentivador">
                <?php include 'includes/incentivador_adm.php'?>
            </div>

            <div class="tab-pane fade" id="lolol">



            </div>
        </div>
    </div>

    </div>
    <?php
} elseif ($pf['liberado'] == 1) {
    echo "<div class='alert alert-warning'>
	<strong>Aviso!</strong> Seus dados foram encaminhados para análise, portanto, não podem ser alterados.</div>";

    include 'includes/resumo_dados_incentivador_pf.php';
} else {
?>

    <section id="contact" class="home-section bg-white">
        <div class="container"><?php include 'includes/menu_interno_pf.php'; ?>
            <div class="form-group">
                <h4>Cadastro de Incentivador<br>
                    <small>Pessoa Física</small>
                </h4>
                <h4><?= (isset($mensagem)) ? $mensagem : "" ?></h4>
            </div>
            <div class="row">
                <div class="col-md-offset-1 col-md-10">
                    <form class="form-horizontal" role="form"
                          action="?perfil=cadastro_incentivador_pf" method="post" id="frmCad">
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8"><strong>Nome *:</strong><br/>
                                <input type="text" class="form-control" name="nome"
                                       placeholder="Nome" required
                                       value="<?= (!empty($pf['nome'])) ? $pf['nome'] : "" ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-6"><strong>CPF *:</strong><br/>
                                <input type="text" readonly class="form-control" id="cpf"
                                       name="cpf" placeholder="CPF"
                                       value="<?php echo $pf['cpf']; ?>" required>
                            </div>
                            <div class="col-md-6"><strong>RG ou RNE *:</strong><br/>
                                <input type="text" class="form-control" name="rg"
                                       placeholder="Número do Documento" required
                                       value="<?= (!empty($pf['rg'])) ? $pf['rg'] : "" ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8"><strong>Email *:</strong><br/>
                                <input type="email" class="form-control" name="email"
                                       placeholder="E-mail" required
                                       value="<?= (!empty($pf['email'])) ? $pf['email'] : "" ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-6"><strong>Telefone :</strong><br/>
                                <input type="text" class="form-control" name="telefone" id="telefone"
                                       onkeyup="mascara( this, mtel );" maxlength="15"
                                       placeholder="Exemplo: (11) 98765-4321"
                                       value="<?= (!empty($pf['telefone'])) ? $pf['telefone'] : "" ?>">
                            </div>
                            <div class="col-md-6"><strong>Celular:</strong><br/>
                                <input type="text" class="form-control" name="celular" id="telefone"
                                       onkeyup="mascara( this, mtel );" maxlength="15"
                                       placeholder="Exemplo: (11) 98765-4321"
                                       value="<?= (!empty($pf['celular'])) ? $pf['celular'] : "" ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8"><hr/></div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-6"><strong>CEP *:</strong><br/>
                                <input type="text" class="form-control" id="CEP" name="cep"
                                       placeholder="CEP" required
                                       value="<?= (!empty($pf['cep'])) ? $pf['cep'] : "" ?>">
                            </div>
                            <div class="col-md-6" align="left">
                                <i>Clique no número do CEP e pressione a tecla Tab para carregar</i>
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
                                        <?= $habilitaCampo ? '' : 'readonly'?>
                                           required
                                           value="<?php echo $_POST['Endereco'];?>">
                                <?php else: ?>
                                    <input type="text" class="form-control" id="Endereco"
                                           name="Endereco" placeholder="Endereço"
                                        <?=$habilitaCampo ? '' : 'readonly'?>
                                           required
                                           value="<?php echo $pf['logradouro'];?>">
                                <?php endif ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-6"><strong>Número *:</strong><br/>
                                <input type="text" class="form-control" name="numero" placeholder="Numero" required
                                       value="<?=$pf['numero']?>">
                            </div>
                            <div class=" col-md-6"><strong>Complemento:</strong><br/>
                                <input type="text" class="form-control" name="complemento" placeholder="complemento" value="<?=$pf['complemento']?>">
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
                                           value="<?php echo $pf['bairro'];?>">
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
                                           elseif(!empty($pf['cidade'])):
                                               echo $pf['cidade'];
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
                                           elseif(!empty($pf['estado'])):
                                               echo $pf['estado'];
                                           elseif(!empty($endereco['estado'])):
                                               echo $endereco['estado'];
                                           else:
                                               echo '';
                                           endif?>">
                                <?php endif ?>
                            </div>
                        </div>

                        <!-- Botão para Gravar -->
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <input type="hidden" name="cadastraNovoPf" value="<?php echo $idPf ?>">
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
                event.preventDefault();
                form = document.querySelector('#frmCad');

            });
        }
    </script>
    <?php
}
?>