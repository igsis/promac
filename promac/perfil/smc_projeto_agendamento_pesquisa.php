<?php

set_time_limit(1200);

$con = bancoMysqli();

if(isset($_POST['pesquisar'])){
    $nomeProjeto = $_POST['nomeProjeto'] ?? NULL;
    $protocolo = $_POST['protocolo'] ?? NULL;

    if($nomeProjeto != '')
    {
        $filtro_nomeProjeto = " AND nomeProjeto LIKE '%$nomeProjeto%'";
    }
    else
    {
        $filtro_nomeProjeto = "";
    }

    if($protocolo != '')
    {
        $filtro_protocolo = " AND protocolo LIKE '%$protocolo%'";
    }
    else
    {
        $filtro_protocolo = "";
    }

    $sql = "SELECT * FROM projeto
        WHERE publicado = 1 AND idStatus != 6
        $filtro_nomeProjeto $filtro_protocolo ORDER BY protocolo";
    $query = mysqli_query($con,$sql);
    $num = mysqli_num_rows($query);
    if($num > 0)
    {
        $i = 0;
        while($lista = mysqli_fetch_array($query))
        {
            $etapa = recuperaDados("etapa_projeto","idEtapaProjeto",$lista['idEtapaProjeto']);
            $pf = recuperaDados("pessoa_fisica","idPf",$lista['idPf']);
            $pj = recuperaDados("pessoa_juridica","idPj",$lista['idPj']);
            $x[$i]['idProjeto'] = $lista['idProjeto'];
            $x[$i]['nomeProjeto'] = $lista['nomeProjeto'];
            $x[$i]['protocolo'] = $lista['protocolo'];
            if($lista['tipoPessoa'] == 1)
            {
                $x[$i]['proponente'] = $pf['nome'];
                $x[$i]['documento'] = $pf['cpf'];
            }
            else
            {
                $x[$i]['proponente'] = $pj['razaoSocial'];
                $x[$i]['documento'] = $pj['cnpj'];
            }
            $i++;
        }
        $x['num'] = $i;
    }
    else
    {
        $x['num'] = 0;
    }

    $mensagem = "Foram encontrados ".$x['num']." resultados";
}
?>
<section id="list_items" class="home-section bg-white">
	<div class="container"><?php include 'includes/menu_smc.php'; ?>
		<div class="form-group">
			<h4>Pesquisar Projetos</h4>
			<h5><?php if(isset($mensagem)){echo $mensagem;}; ?></h5>
		</div>
		<div class="row">
			<div class="col-md-offset-1 col-md-10">
				<form method="POST" action="?perfil=smc_projeto_agendamento_pesquisa" class="form-horizontal" role="form">

					<div class="form-group">
						<div class="col-md-offset-2 col-md-8"><label>Nome do projeto</label>
							<input type="text" name="nomeProjeto" class="form-control" placeholder="">
						</div>
					</div>

					<div class="form-group">
                        <div class="col-md-offset-2 col-md-8"><label>Protocolo</label> (somente números)
							<input type="number" name="protocolo" class="form-control" placeholder="">
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-offset-2 col-md-8">
							<input type="submit" name="pesquisar" class="btn btn-theme btn-lg btn-block" value="Pesquisar">
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
    <?php
    if(isset($_POST['pesquisar'])) {
    ?>
        <div class="container">
            <div class="row">
                <div class="col-md-offset-1 col-md-10">
                    <div class="table-responsive list_info">
                        <table class='table table-condensed'>
                            <thead>
                            <tr class='list_menu'>
                                <td>Protocolo</td>
                                <td>Nome do Projeto</td>
                                <td>Proponente</td>
                                <td>Documento</td>
                                <td width='10%'></td>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            for ($h = 0; $h < $x['num']; $h++) {
                                echo "<tr>";
                                echo "<td class='list_description maskProtocolo' data-mask = '0000.00.00/0000000'>" . $x[$h]['protocolo'] . "</td>";
                                echo "<td class='list_description'>" . $x[$h]['nomeProjeto'] . "</td>";
                                echo "<td class='list_description'>" . $x[$h]['proponente'] . "</td>";
                                echo "<td class='list_description'>" . $x[$h]['documento'] . "</td>";
                                echo "<td class='list_description'>
										<form method='POST' action='?perfil=smc_projeto_agendamento'>
											<input type='hidden' name='idProjeto' value='" . $x[$h]['idProjeto'] . "' />
											<input type ='submit' class='btn btn-theme btn-block' value='detalhes'>
										</form>
									</td>";
                                echo "</tr>";
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    <?php
    }
    ?>
</section>