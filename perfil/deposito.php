<?php
$con = bancoMysqli();
$idReserva = $_GET['idReserva'];
$idProjeto = $_GET['idProjeto'];



?>
        <section id="list_items" class="home-section bg-white">
            <div class="container">
                <?php include 'includes/menu_smc.php';?>
                <div class="form-group">
                    <h4>Depósitos</h4>
                    <h5><?php if(isset($mensagem)){echo $mensagem;}; ?></h5>
                </div>
                <div class="row">
                    <div class="col-md-offset-1 col-md-10">
                        <div class="form-group">
                            <div class="col-md-offset-2 col-md-8">
                                <form class="form-horizontal" role="form" action="?perfil=cadastro_deposito&idReserva=<?=$idReserva?>&idProjeto=<?=$idProjeto?>" method="POST">
                                    <input type="submit" value="Inserir novo depósito" class="btn btn-theme btn-lg btn-block">
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-offset-2 col-md-8"><br></div>
                    </div>
                    <div class="col-md-offset-1 col-md-10">
                        <div class="table-responsive list_info">
                        <?php
                            $sql = "SELECT * FROM deposito WHERE idReserva = '$idReserva'";
                            $query = mysqli_query($con, $sql);
                            $num = mysqli_num_rows($query);
                            if($num > 0) { ?>
                                <div class="table-responsive list_info">
                                    <table class='table table-condensed'>
                                        <thead>
                                        <tr class='list_menu'>
                                            <td>Documento</td>
                                            <td>Incentivador</td>
                                            <td>Data</td>
                                            <td>Valor do Depósito</td>
                                            <td>Valor da Renúncia</td>
                                            <td>Porcentagem Renúncia</td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            
                                        <?php 
                                          $sql = "SELECT * FROM deposito d INNER JOIN incentivador_pessoa_fisica pf ON d.idIncentivador = pf.idPf WHERE d.idReserva = '$idReserva' AND d.tipoPessoa = 4";
                                          $query = mysqli_query($con, $sql);
                                          while ($deposito = mysqli_fetch_array($query)) { ?>
                                            <tr>
                                               <td><?php echo $deposito['cpf']; ?></td>
                                               <td><?php echo $deposito['nome']; ?></td>
                                               <td><?php echo exibirDataBr($deposito['data']); ?></td>
                                               <td><?php echo dinheiroParaBr($deposito['valorDeposito']); ?></td>
                                               <td><?php echo dinheiroParaBr($deposito['valorRenuncia']); ?></td>
                                               <td><?php echo $deposito['porcentagemValorRenuncia']; ?></td>
                                               <td class='list_description'>
                                                <form method='POST' action="?perfil=edicao_deposito&idDeposito=<?=$deposito['idDeposito']?>&idProjeto=<?=$idProjeto?>">
                                                    <input type='hidden' name='' value='".$campo['']."' />
                                                    <input type="hidden" name="idIncentivador" value="<?php echo $deposito['idIncentivador'] ;?>">
                                                    <input type="hidden" name="nome" value="<?php echo $deposito['nome'] ;?>">
                                                    <input type="hidden" name="tipoPessoa" value="<?php echo $deposito['tipoPessoa'] ;?>">
                                                    <input type="hidden" name="idReserva" value="<?php echo $deposito['idReserva'] ;?>">
                                                    <input type ='submit' class='btn btn-theme btn-block' value='editar'>
                                                </form>
                                                </td>
                                                 <td class='list_description'>
                                                    <form method='POST' action='?perfil='>
                                                        <input type='hidden' name='' value='".$campo['']."' />
                                                        <input type ='submit' class='btn btn-theme btn-block' value='reservas'>
                                                     </form>
                                                </td>
                                            </tr>
                                            </tr>
                                        <?php }
                                          $sql = "SELECT * FROM deposito d INNER JOIN incentivador_pessoa_juridica pj ON d.idIncentivador = pj.idPj WHERE d.idReserva = '$idReserva' AND d.tipoPessoa = 5";
                                          $query = mysqli_query($con, $sql);
                                          while ($deposito = mysqli_fetch_array($query)) { ?>
                                            <tr>
                                               <td><?php echo $deposito['cnpj']; ?></td>
                                               <td><?php echo $deposito['razaoSocial']; ?></td>
                                               <td><?php echo exibirDataBr($deposito['data']); ?></td>
                                               <td><?php echo dinheiroParaBr($deposito['valorDeposito']); ?></td>
                                               <td><?php echo dinheiroParaBr($deposito['valorRenuncia']); ?></td>
                                               <td><?php echo $deposito['porcentagemValorRenuncia']; ?></td>
                                               <td class='list_description'>
                                                <form method='POST' action="?perfil=edicao_deposito&idDeposito=<?=$deposito['idDeposito']?>&idProjeto=<?=$idProjeto?>">
                                                    <input type='hidden' name='' value='".$campo['']."' />
                                                    <input type="hidden" name="idIncentivador" value="<?php echo $deposito['idIncentivador'] ;?>">
                                                    <input type="hidden" name="nome" value="<?php echo $deposito['razaoSocial'] ;?>">
                                                    <input type="hidden" name="tipoPessoa" value="<?php echo $deposito['tipoPessoa'] ;?>">
                                                    <input type="hidden" name="idReserva" value="<?php echo $deposito['idReserva'] ;?>">
                                                    <input type ='submit' class='btn btn-theme btn-block' value='editar'>
                                                </form>
                                                </td>
                                                 <td class='list_description'>
                                                    <form method='POST' action='?perfil='>
                                                        <input type='hidden' name='' value='".$campo['']."' />
                                                        <input type ='submit' class='btn btn-theme btn-block' value='reservas'>
                                                     </form>
                                                </td>
                                            </tr>
                                            </tr>
                                        <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                                <?php
                            }
                            else {?>
                                <h4>Não existem depósitos cadastrados!</h4>
                            <?php } ?>
                    </div>
            </div>        
        </section>

