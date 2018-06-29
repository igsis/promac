<?php
$con = bancoMysqli();

$idDeposito = $_GET['idDeposito'];

$deposito = recuperaDados("deposito", "idDeposito", $idDeposito);


if(isset($_POST['insereLiquidacao']))
{
        $data = exibirDataBr($_POST['data']);
        $valor = $_POST['valor'];
        $numeroLiquidacao = $_POST['numeroLiquidacao'];
      
        $sql_insere_liquidacao = "INSERT INTO `liquidacao`(`idLiquidacao`, `data`, `valor`, `numeroLiquidacao`) VALUES ('$idLiquidacao', '$data', '$valor', '$numeroLiquidacao')";

        if(mysqli_query($con,$sql_insere_liquidacao))
        {
                $mensagem = "<font color='#01DF3A'><strong>Gravado com sucesso!</strong></font>";
                gravarLog($sql_insere_liquidacao);
        }
        else
        {
                $mensagem = "<font color='#FF0000'><strong>Erro ao gravar! Tente novamente.</strong></font>";
        }
}

if(isset($_POST['editaLiquidacao']))
{
        $idLiquidacao = $_POST['editaLiquidacao'];
        $data = exibirDataBr($_POST['data']);
        $valor = $_POST['valor'];
        $numeroLiquidacao = $_POST['numeroLiquidacao'];

        $sql_edita_liquidacao = "UPDATE `liquidacao` SET
        `data`= '$data',
        `valor` = '$valor',
        `numeroLiquidacao` = '$numeroLiquidacao'
        WHERE idLiquidacao = '$idLiquidacao'";
        if(mysqli_query($con,$sql_edita_liquidacao))
        {
                $mensagem = "<font color='#01DF3A'><strong>Gravado com sucesso!</strong></font>";
                gravarLog($sql_edita_liquidacao);
        }
        else
        {       
                $mensagem = "<font color='#FF0000'><strong>Erro ao gravar! Tente novamente.</strong></font>";
        }
}

?>
      <section id="list_items" class="home-section bg-white">
        <div class="container">
              <?php include 'includes/menu_smc.php';?>
              <div class="form-group">
                      <h4>Liquidações</h4>
                      <h5>
                              <?php if(isset($mensagem)){echo $mensagem;}; ?>
                      </h5>
              </div>
              <div class="row">
                <div class="col-md-offset-1 col-md-10">
                  <div class="form-group">
                    <div class="col-md-offset-2 col-md-8">
                      <form class="form-horizontal" role="form" action="?perfil=cadastro_liquidacao&idDeposito=<?=$idDeposito?>" method="post">
                              <input type="submit" value="Inserir liquidação" class="btn btn-theme btn-lg btn-block">
                      </form>
                    </div>
                  </div>
                </div>

                <?php
                  $sql = "SELECT * FROM liquidacao WHERE idDeposito = '$idDeposito'";
                  $query = mysqli_query($con, $sql);
                  $num = mysqli_num_rows($query);
                  if($num > 0) { ?>
                  <div class="table-responsive list_info">
                      <table class='table table-condensed'>
                          <thead>
                            <tr class='list_menu'>
                                <td>Data</td>
                                <td>Valor</td>
                                <td>Número da Liquidação</td>
                                <td></td>
                                <td></td>
                            </tr>
                          </thead>
                        <tbody>
                          <?php while ($liquidacao = mysqli_fetch_array($query)) { ?>
                            <tr>
                              <td>
                                      <?php echo exibirDataBr($liquidacao['data']); ?>
                              </td>
                              <td>
                                      <?php echo dinheiroParabr($liquidacao['valor']); ?>
                              </td>
                              <td>
                                      <?php echo $liquidacao['numeroLiquidacao']; ?>
                              </td>
                              <td class='list_description'>
                                      <form method="POST" action="?perfil=edicao_liquidacao&idLiquidacao=<?=$liquidacao['idLiquidacao'] ?>">
                                              <input type='hidden' name='' value='".$campo[' ']."' />
                                              <input type='submit' class='btn btn-theme btn-block' value='editar'>
                                      </form>
                              </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                      </table>
                  </div>
                  <?php
                  }
                  else {?>
                          <h4>Não existem liquidações cadastradas!</h4>
                          <?php } ?>
     </div>
        </div>
      </section>
