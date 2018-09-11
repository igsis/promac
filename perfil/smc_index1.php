<?php
$con = bancoMysqli();
$tipoPessoa = '1';
$idStatus = 1;

$idPf = $_SESSION['idUser'];
$pf = recuperaDados("pessoa_fisica","idPf",$idPf);


$situacaoAtual = recuperaDados("statusprojeto", "idStatus", $idStatus);

if(isset($_POST['liberacaoPF']))
{
?>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
                </div>
                <div class="modal-body">...</div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
    <?php
}

if(isset($_POST['liberacaoPJ']))
{
	$idJuridico = $_POST['LIBPJ'];
	$QueryPJ = "UPDATE pessoa_juridica SET liberado='3' WHERE idPj='$idJuridico'";
	$envio = mysqli_query($con, $QueryPJ);
	if($envio)
		echo "<script>alert('O usuário foi ativo com sucesso');</script>";
}
?>
<section id="list_items" class="home-section bg-white">
    <div class="container">
        <?php include 'includes/menu_smc.php'; ?>
        <p align="left"><strong><?php echo saudacao(); ?>, <?php echo $_SESSION['nome']; ?></strong></p>
        <div class="form-group">
            <h5 class="alert alert-info" role="alert">
                CADASTRO DE PROJETOS:
                <?php echo $situacaoAtual['descricaoSituacao'];?>
            </h5>
        </div>
        <!-- Lista 1 -->
        <div class="form-group">
            <h5>Inscrições de pessoa física a liberar</h5>
        </div>
        <div class="row">
            <div class="col-md-offset-1 col-md-10">
                <div class="table-responsive list_info">
                    <?php
            $sql = "SELECT * FROM pessoa_fisica WHERE liberado = 1 LIMIT 0,10";
            $query = mysqli_query($con,$sql);
            $num = mysqli_num_rows($query);
            if($num > 0)
            {
                echo "
                    <table class='table table-condensed'>
                        <thead>
                            <tr class='list_menu'>
                                <td>Nome</td>
                                <td>CPF</td>
                                <td>RG</td>
                                <td>Email</td>
                                <td>Telefone</td>
                                <td width='10%'></td>
                            </tr>
                        </thead>
                        <tbody>";
                        while($campo = mysqli_fetch_array($query))
                        {
                            echo "<tr>";
                            echo "<td class='list_description'>".$campo['nome']."</td>";
                            echo "<td class='list_description'>".$campo['cpf']."</td>";
                            echo "<td class='list_description'>".$campo['rg']."</td>";
                            echo "<td class='list_description'>".$campo['email']."</td>";
                            echo "<td class='list_description'>".$campo['telefone']."</td>";
                            echo "
                                <td class='list_description'>
                                    <form method='POST' action='?perfil=smc_visualiza_perfil_pf'>
                                        <input type='hidden' name='liberado' value='".$campo['idPf']."' />
                                        <input type ='submit' class='btn btn-theme btn-block' value='Visualizar'>
                                    </form>
                                </td>";
                        }
                    echo "</tr>";
                    echo "</tbody>
                        </table>";
                }
                else
                {
                    echo "Não há resultado no momento.";
                }
            ?>
                </div>
            </div>
        </div>
        <!-- Lista 2 -->
        <div class="form-group">
            <h5>Inscrições de pessoa jurídica a liberar</h5>
        </div>
        <div class="row">
            <div class="col-md-offset-1 col-md-10">
                <div class="table-responsive list_info">
                    <?php
            $sql = "SELECT * FROM pessoa_juridica WHERE liberado = 1 LIMIT 0,10";
            $query = mysqli_query($con,$sql);
            $num = mysqli_num_rows($query);
            if($num > 0)
            {
                echo "
                    <table class='table table-condensed'>
                        <thead>
                            <tr class='list_menu'>
                                <td>Razão Social</td>
                                <td>CNPJ</td>
                                <td>Email</td>
                                <td>Telefone</td>
                                <td width='10%'></td>
                            </tr>
                        </thead>
                        <tbody>";
                        while($campo = mysqli_fetch_array($query))
                        {
                            echo "<tr>";
                            echo "<td class='list_description'>".$campo['razaoSocial']."</td>";
                            echo "<td class='list_description'>".$campo['cnpj']."</td>";
                            echo "<td class='list_description'>".$campo['email']."</td>";
                            echo "<td class='list_description'>".$campo['telefone']."</td>";
                            echo "
                                <td class='list_description'>
                                    <form method='POST' action='?perfil=smc_visualiza_perfil_pj'>
                                        <input type='hidden' name='liberado' value='".$campo['idPj']."' />
                                        <input type ='submit' class='btn btn-theme btn-block' value='Visualizar'>
                                    </form>
                                </td>";
                        }
                    echo "</tr>";
                    echo "</tbody>
                        </table>";
                }
                else
                {
                    echo "Não há resultado no momento.";
                }
            ?>
                </div>
            </div>
        </div>
        <!-- Lista 3 -->
        <div class="form-group">
            <h5>Inscrições de incentivador pessoa física a liberar</h5>
        </div>
        <div class="row">
            <div class="col-md-offset-1 col-md-10">
                <div class="table-responsive list_info">
                    <?php
            $sql = "SELECT * FROM incentivador_pessoa_fisica WHERE liberado = 1 LIMIT 0,10";
            $query = mysqli_query($con,$sql);
            $num = mysqli_num_rows($query);
            if($num > 0)
            {
                echo "
                    <table class='table table-condensed'>
                        <thead>
                            <tr class='list_menu'>
                                <td>Nome</td>
                                <td>CPF</td>
                                <td>Email</td>
                                <td>Telefone</td>
                                <td width='10%'></td>
                            </tr>
                        </thead>
                        <tbody>";
                        while($campo = mysqli_fetch_array($query))
                        {
                            echo "<tr>";
                            echo "<td class='list_description'>".$campo['nome']."</td>";
                            echo "<td class='list_description'>".$campo['cpf']."</td>";
                            echo "<td class='list_description'>".$campo['email']."</td>";
                            echo "<td class='list_description'>".$campo['telefone']."</td>";
                            echo "
                                <td class='list_description'>
                                    <form method='POST' action='?perfil=smc_visualiza_incentivadores_pf'>
                                        <input type='hidden' name='liberado' value='".$campo['idPf']."' />
                                        <input type ='submit' class='btn btn-theme btn-block' value='Visualizar'>
                                    </form>
                                </td>";
                        }
                    echo "</tr>";
                    echo "</tbody>
                        </table>";
                }
                else
                {
                    echo "Não há resultado no momento.";
                }
            ?>
                </div>
            </div>
        </div>
        <!-- Lista 4 -->
        <div class="form-group">
            <h5>Inscrições de incentivador pessoa jurídica a liberar</h5>
        </div>
        <div class="row">
            <div class="col-md-offset-1 col-md-10">
                <div class="table-responsive list_info">
<?php
            $sql = "SELECT * FROM incentivador_pessoa_juridica WHERE liberado = 1 LIMIT 0,10";
            $query = mysqli_query($con,$sql);
            $num = mysqli_num_rows($query);
            if($num > 0)
            {
                echo "
                    <table class='table table-condensed'>
                        <thead>
                            <tr class='list_menu'>
                                <td>Razão Social</td>
                                <td>CNPJ</td>
                                <td>Email</td>
                                <td>Telefone</td>
                                <td width='10%'></td>
                            </tr>
                        </thead>
                        <tbody>";
                        while($campo = mysqli_fetch_array($query))
                        {
                            echo "<tr>";
                            echo "<td class='list_description'>".$campo['razaoSocial']."</td>";
                            echo "<td class='list_description'>".$campo['cnpj']."</td>";
                            echo "<td class='list_description'>".$campo['email']."</td>";
                            echo "<td class='list_description'>".$campo['telefone']."</td>";
                            echo "
                                <td class='list_description'>
                                    <form method='POST' action='?perfil=smc_visualiza_incentivadores_pj'>
                                        <input type='hidden' name='liberado' value='".$campo['idPj']."' />
                                        <input type ='submit' class='btn btn-theme btn-block' value='Visualizar'>
                                    </form>
                                </td>";
                        }
                    echo "</tr>";
                    echo "</tbody>
                        </table>";
                }
                else
                {
                    echo "Não há resultado no momento.";
                }
?>
                </div>
            </div>
        </div>



<?php
            $array_status = array(2, 3, 10, 12, 13, 20, 23, 25, 29, 31, 14, 15, 11); //status
            foreach ($array_status as $idStatus)
            {
                $sqlStatus = "SELECT status, ordem FROM status WHERE idStatus = '$idStatus'";
                $sqlProjeto = "SELECT idProjeto, nomeProjeto, protocolo, pf.nome, pf.cpf, razaoSocial, cnpj, areaAtuacao, pfc.nome AS comissao, status, pro.idStatus AS idStatus 
                    FROM projeto AS pro
                    LEFT JOIN pessoa_fisica AS pf ON pro.idPf = pf.idPf
                    LEFT JOIN pessoa_juridica AS pj ON pro.idPj = pj.idPj
                    INNER JOIN area_atuacao AS ar ON pro.idAreaAtuacao = ar.idArea
                    LEFT JOIN pessoa_fisica AS pfc ON pro.idComissao = pfc.idPf 
                    INNER JOIN status AS st ON pro.idStatus = st.idStatus
                    WHERE pro.publicado = 1 AND pro.idStatus = '$idStatus' ORDER BY idProjeto DESC";
                $queryProjeto = mysqli_query($con,$sqlProjeto);
                $queryStatus = mysqli_query($con,$sqlStatus);
                $num = mysqli_num_rows($queryProjeto);

                foreach ($queryStatus as $status)
                {
                    $i = 0;
?>
                    <div class='form-group'>
                        <h5>Projetos com Status "<?=$status['status']?>"</h5>
                    </div>
                    <div class="row">
                        <div class="col-md-offset-1 col-md-10">
                            <div class="table-responsive list_info">
<?php
//                                var_dump($sqlProjeto);

                                    if($num > 0)
                                    {
?>

                                            <table class='table table-condensed'>
                                                <thead>
                                                    <tr class='list_menu'>
                                                        <td>Protocolo (nº ISP)</td>
                                                        <td>Nome do Projeto</td>
                                                        <td>Proponente</td>
                                                        <td>Documento</td>
                                                        <td>Área de Atuação</td>
                                                        <?=($status['ordem'] >= 5) ? "<td>Parecerista</td>" : NULL ?>
                                                        <td width='10%'></td>
                                                    </tr>
                                                </thead>
<?php
                                        while ($campo = mysqli_fetch_array($queryProjeto))
                                        {
                                            if ($i < 5) {
?>
                                                <tr>
                                                    <td class='list_description'><?= $campo['protocolo'] ?></td>
                                                    <td class='list_description'><?= $campo['nomeProjeto'] ?></td>
                                                    <td class='list_description'><?= isset($campo['nome']) ? $campo['nome'] : $campo['razaoSocial'] ?></td>
                                                    <td class='list_description'><?= isset($campo['cpf']) ? $campo['cpf'] : $campo['cnpj'] ?></td>
                                                    <td class='list_description'><?= substr($campo['areaAtuacao'], 0,35) ?></td>
                                                    <?= ($status['ordem'] >= 5) ? "<td class='list_description'>".$campo['comissao']."</td>" : NULL ?>
                                                    <td class='list_description'>
                                                        <form method='POST' action='?perfil=smc_detalhes_projeto'>
                                                            <input type='hidden' name='idProjeto' value='<?= $campo['idProjeto'] ?>' />
                                                            <input type ='submit' class='btn btn-theme btn-block' value='Visualizar'>
                                                        </form>
                                                    </td>
                                                </tr>
<?php
                                                $i++;
                                            }
                                        }
                                   }
                                   else
                                   {
                                       echo "Não há resultado no momento.";
                                   }
?>
                                </table>
                            </div>
                        </div>
                    </div>
<?php
                }
            }
?>
            </div>
        </div>
    </div>
</section>