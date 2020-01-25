<?php
$con = bancoMysqli();
$idProjeto = $_SESSION['idProjeto'];

if(isset($_POST['insere']) || isset($_POST['edita'])) {
    $quantidade = $_POST['quantidade'];
    $media_meses = $_POST['media_meses'];
    $media_valor = dinheiroDeBr($_POST['media_valor']);
}

if(isset($_POST['insere'])){
    $insere = "INSERT INTO postos_trabalho (idProjeto, quantidade, media_meses, media_valor) VALUES ('$idProjeto', '$quantidade', '$media_meses', '$media_valor')";
    if($con->query($insere)) {
        $mensagem = "<font color='#01DF3A'><strong>Gravado com sucesso! Utilize o menu para avançar.</strong></font>";
        gravarLog($insere);
    }
    else {
        $mensagem = "<font color='#FF0000'><strong>Erro ao gravar! Tente novamente.</strong></font>".$insere;
    }
}

if(isset($_POST['edita'])){
    $edita = "UPDATE postos_trabalho SET quantidade = '$quantidade', media_meses = '$media_meses', media_valor = '$media_valor' WHERE idProjeto = '$idProjeto'";
    if($con->query($edita)) {
        $mensagem = "<font color='#01DF3A'><strong>Gravado com sucesso! Utilize o menu para avançar.</strong></font>";
        gravarLog($edita);
    }
    else {
        $mensagem = "<font color='#FF0000'><strong>Erro ao gravar! Tente novamente.</strong></font>".$edita;
    }
}

$postos = recuperaDados("postos_trabalho","idProjeto",$idProjeto);

if (isset($postos['id'])){
    $botao = "edita";
} else{
    $botao = "insere";
}
?>
    <section id="inserir" class="home-section bg-white">
        <div class="container">
            <?php
    	if($_SESSION['tipoPessoa'] == 1)
		{
			$idPf= $_SESSION['idUser'];
			include '../perfil/includes/menu_interno_pf.php';
		}
		else
		{
			$idPj= $_SESSION['idUser'];
			include '../perfil/includes/menu_interno_pj.php';
		}
    	?>
            <div class="form-group">
                <h4>Cadastro de Projeto</h4>
                <ul class="list-group">
                    <li class="list-group-item list-group-item-warning">
                        <strong>O valor do incentivo é igual ao valor do orçamento preenchido na tela de orçamento.<br/>O valor total do projeto pode ser igual ao valor solicitado ao Pro-Mac ou maior, incluindo recursos oriundos de outras fontes.</strong><br/>
                    </li>
                </ul>
                <p><strong><?php if(isset($mensagem)){echo $mensagem;} ?></strong></p>
            </div>
            <div class="row">
                <div class="col-md-offset-1 col-md-10">
                    <form method="POST" action="?perfil=postos_trabalho" class="form-horizontal" role="form">

                        <div class="form-group">
                            <div class="col-md-12">
                                <label>a) Quantos postos de trabalho diretos o seu projeto gera, ainda que temporariamente? <input type="number" name="quantidade" maxlength="4" class="form-control" value="<?= $postos['quantidade'] ?? null ?>" /></label>
                                <div class="well">
                                    <p>Aqui, você deverá considerar os postos de trabalho que são criados e pagos pelo projeto, ou seja, quantas “vagas” o projeto gera diretamente.</p>
                                    <p>Exemplo: Se são necessários 5 produtores, 1 diretor, 1 assistente de direção, 1 figurinista, 1 operador de som e 1 operador de luz para execução de seu projeto, quer dizer que são gerados 10 postos de trabalho pelo seu projeto.</p>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-12">
                                <label>b) Qual a média, em meses, de tempo de contratação de cada posto de trabalho?
                                <input type="number" name="media_meses" class="form-control" value="<?= $postos['media_meses'] ?? null ?>" /></label>
                                <div class="well">
                                    <p>Aqui, você deverá considerar a somatória dos meses de contratação de cada posto de trabalho gerado e dividir pelo número de postos de trabalho informado acima.</p>
                                    <p>Exemplo: Se os 5 produtores são contratados por 5 meses para a execução do seu projeto, o diretor por 6 meses, o assistente de direção, o figurinista, o operador de som e o operador de luz por 4 meses cada, você teria a seguinte conta: Produtores: 5x5 = 25; Diretor: 1x6 = 6; Assistente de Direção, Figurinista, Operador de Som e Operador de Luz: 4x4 = 16. Total de 47 meses de trabalho (25 + 6 + 16 ) contratados pelo seu projeto. Divididos por 10 postos de trabalho, você tem a média de 4,7 meses de trabalho para cada posto de trabalho gerado.</p>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-12">
                                <label>c) Qual a média, em reais, de remuneração de cada posto de trabalho? <input type="text" name="media_valor" id="valor" class="form-control" value="<?= $postos['media_valor'] ?? null ?>" /></label>
                                <div class="well">
                                    <p>Aqui, você deverá considerar o valor da somatória da remuneração de todos os postos de trabalho gerados e dividir pelo número de postos de trabalho informado acima. Normalmente, será o total informado no Orçamento no Grupo de Despesa “Recursos Humanos” dividido pelo número de postos de trabalho informado.</p>
                                    <p>Exemplo: Se os produtores recebem (considerando o que recebem na totalidade dos meses de trabalho) 10 mil reais cada, o diretor recebe 18 mil reais, o assistente de direção, o figurinista, o operador de som e o operador de luz recebem 8 mil reais cada, você teria a seguinte conta: Produtores: 5x10 = 50 mil reais; Diretor: 1x18 = 18 mil reais; Assistente de Direção, Figurinista, Operador de Som e Operador de Luz: 4x8 = 32 mil reais. Total de 100 mil reais contratados em postos de trabalho pelo seu projeto. Divididos por 10 postos de trabalho, você tem a média de 10 mil reais de remuneração para cada posto de trabalho gerado.</p>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <input type="submit" name="<?= $botao ?>" class="btn btn-theme btn-lg btn-block" value="Gravar">
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </section>
