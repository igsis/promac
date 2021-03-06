<?php
 
$con = bancoMysqli();
$idUsuario = $_SESSION['idUser'];
$tipoPessoa = $_SESSION['tipoPessoa'];

$pj = recuperaDados("pessoa_juridica","idPj",$idUsuario);
$repre_legal = recuperaDados("representante_legal","idRepresentanteLegal",$pj['idRepresentanteLegal']);

?>
<section id="list_items" class="home-section bg-white">
	<div class="container">
		<div class='well'>
			<p align='justify'><strong>Nome:</strong> <?php echo $repre_legal['nome'] ?? null; ?></p>
			<p align='justify'><strong>CPF:</strong> <?php echo $repre_legal['cpf'] ?? null; ?></p>
			<p align='justify'><strong>RG:</strong> <?php echo $repre_legal['rg'] ?? null; ?></p>
			<p align='justify'><strong>Endereço:</strong> <?php echo $repre_legal['logradouro'] ?? null; ?><p>
			<p align='justify'><strong>Bairro:</strong> <?php echo $repre_legal['bairro'] ?? null; ?><p>
			<p align='justify'><strong>Cidade:</strong> <?php echo $repre_legal['cidade'] ?? null; ?><p>
			<p align='justify'><strong>Estado:</strong> <?php echo $repre_legal['estado'] ?? null; ?><p>
			<p align='justify'><strong>CEP:</strong> <?php echo $repre_legal['cep'] ?? null; ?><p>
			<p align='justify'><strong>Número:</strong> <?php echo $repre_legal['numero'] ?? null; ?><p>
			<p align='justify'><strong>Complemento:</strong> <?php echo $repre_legal['complemento'] ?? null; ?><p>
			<p align='justify'><strong>Telefone:</strong> <?php echo $repre_legal['telefone'] ?? null; ?><p>
			<p align='justify'><strong>Celular:</strong> <?php echo $repre_legal['celular'] ?? null; ?><p>
			<p align='justify'><strong>Email:</strong> <?php echo $repre_legal['email'] ?? null; ?><p>
                <?php
                $dados = retornaDadosAdicionais($pj['idPj'], 2);
                if ($dados) {
                ?>
            <div class="text-center"><h5>Informações Adicionais</h5></div>
            <p align="justify"><strong>Gênero:</strong> <?= $dados['genero'] ?></p>
            <p align="justify"><strong>Cor / Raça:</strong> <?= $dados['etnia'] ?></p>
            <p align="justify"><strong>Participou de outras leis de incentivo à cultura?:</strong> <?= $dados['lei_incentivo'] == 1 ? "Sim" : "Não" ?></p>
        <?php if($dados['lei_incentivo'] == 1) { ?>
            <p align="justify"><strong>Qual:</strong> <?= $dados['nome_lei'] ?></p>
        <?php } ?>
        <?php } else { ?>
            <div class="alert alert-danger"><strong>Informações Adicionais ainda não cadastradas</strong></div>
        <?php } ?>
		</div>
	</div>
</section>



