<?php
$con = bancoMysqli();

$pessoa_id = $_SESSION['idUser'];
$tipo_pessoa_id = $_SESSION['tipoPessoa'];

if(isset($_POST['cadastra']) || isset($_POST['edita'])){
    $genero = $_POST['genero'];
    $etnia = $_POST['etnia'];
    $lei_incentivo = $_POST['lei_incentivo'];
    $nome_lei = (isset($_POST['nome_lei'])) ? "'".addslashes($_POST['nome_lei'])."'" : "NULL" ;
}

if(isset($_POST['cadastra'])){
    $cadastra = "INSERT INTO pessoa_informacao_adicional (tipo_pessoa_id, pessoa_id, genero, etnia, lei_incentivo, nome_lei)
                 VALUES ('$tipo_pessoa_id', '$pessoa_id', '$genero', '$etnia', '$lei_incentivo', $nome_lei)";
    if(mysqli_query($con,$cadastra)){
        $mensagem = "<span style='color:#01DF3A'><strong>Gravado com sucesso!</strong></span>";
        gravarLog($cadastra);
    } else{
        $mensagem = "<span style='color:#ff2100'><strong>Erro ao gravar!</strong></span>".$cadastra;
    }
}

if(isset($_POST['edita'])){
    $sqlEdita = "UPDATE pessoa_informacao_adicional SET
                    genero = '$genero',
                    etnia = '$etnia',
                    lei_incentivo = '$lei_incentivo',
                    nome_lei = $nome_lei
                 WHERE tipo_pessoa_id = '$tipo_pessoa_id' AND pessoa_id = '$pessoa_id'";
    $edita = $con->query($sqlEdita);
    if($edita){
        $mensagem = "<span style='color:#01DF3A'><strong>Gravado com sucesso!</strong></span>";
        gravarLog($sqlEdita);
    } else{
        $mensagem = "<span style='color:#ff2100'><strong>Erro ao gravar!</strong></span>";
    }
}

$adicional = $con->query("SELECT * FROM pessoa_informacao_adicional WHERE tipo_pessoa_id = $tipo_pessoa_id AND pessoa_id = '$pessoa_id'")->fetch_array();

if(empty($adicional)){
    $botao = "cadastra";
} else{
    $botao = "edita";
}
?>

<section id="list_items" class="home-section bg-white">
    <div class="container"><?php include 'includes/menu_interno_pj.php'; ?>
        <div class="form-group">
            <h4>Proponente</h4>
            <h5><?= $mensagem ?? NULL ?></h5>
        </div>
        <div class="row">
            <div class="col-md-offset-1 col-md-10">
                <form class="form-horizontal" role="form" action="?perfil=informacoes_adicionais" method="post" id="frmCad">
                    <div class="form-group">
                        <div class="col-md-offset-2 col-md-6"><strong>Com qual gênero você se identifica? *</strong><br/>
                            <select class="form-control" name="genero" required>
                                <option value="">Selecione...</option>
                                <?php
                                $tipos = [1 => 'Feminino', 2 => 'Masculino', 3 => 'Nenhuma das opções'];
                                foreach($tipos as $chave => $tipo):
                                    $selected = $adicional['genero'] == $chave ? "selected='selected'" : "";
                                    ?>
                                    <option value="<?=$chave?>" <?=$selected?>>	<?=$tipo?> </option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="col-md-6"><strong>A sua cor ou raça é: *</strong><br/>
                            <select class="form-control" name="etnia" required>
                                <option value="">Selecione...</option>
                                <?php
                                $tipos = [1 => 'Branca', 2 => 'Preta', 3 => 'Amarela', 4 => 'Parda', 5 => 'Indígena'];
                                foreach($tipos as $chave => $tipo):
                                    $selected = $adicional['etnia'] == $chave ?
                                        "selected='selected'" : "";
                                    ?>
                                    <option value="<?=$chave?>" <?=$selected?>>	<?=$tipo?> </option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-offset-2 col-md-8"><strong>Você já participou de outras leis de incentivo à cultura? *</strong><br/>
                        <?php
                        if ($botao == "edita") {
                            ?>
                            <label><input type="radio" class="lei_incentivo" name="lei_incentivo" value="1" id="sim" <?= $adicional['lei_incentivo'] == 1 ? 'checked' : NULL ?>> Sim</label>&nbsp;&nbsp;
                            <label><input type="radio" class="lei_incentivo" name="lei_incentivo" value="0" id="nao" <?= $adicional['lei_incentivo'] == 0 ? 'checked' : NULL ?>> Não</label>
                            <?php
                        } else{
                            ?>
                            <label><input type="radio" class="lei_incentivo" name="lei_incentivo" value="1" id="sim"> Sim</label>&nbsp;&nbsp;
                            <label><input type="radio" class="lei_incentivo" name="lei_incentivo" value="0" id="nao" checked> Não </label>
                            <?php
                        }
                        ?>
                    </div>
                    <div class="form-group">
                        <div class="col-md-offset-2 col-md-8">
                            <label for="nome_lei">Qual? </label> <br>
                            <input class="form-control" type="text" id="nome_lei" name="nome_lei" maxlength="80" <?php if($botao == "edita") echo "value='".$adicional['nome_lei']."'" ?>>
                        </div>
                    </div>

                    <!-- Botão para Gravar -->
                    <div class="form-group">
                        <div class="col-md-offset-2 col-md-8">
                            <input type="hidden" name="<?= $botao ?>" value="<?= $pessoa_id ?>">
                            <input type="submit" value="GRAVAR" class="btn btn-theme btn-lg btn-block">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<script>
    //FOMENTO
    function verificaLei() {
        if ($('#sim').is(':checked')) {
            $('#nome_lei')
                .attr('disabled', false)
                .attr('required', true)
        } else {
            $('#nome_lei')
                .attr('disabled', true)
                .attr('required', false)
            $('#nome_lei').val("");
        }
    }

    //EXECUTA TUDO
    $('.lei_incentivo').on('change', verificaLei);

    $(document).ready(function () {
        verificaLei();
    });
</script>