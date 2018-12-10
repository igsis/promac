<section id="list_items" class="home-section bg-white">
    <div class="container">
        <?php

        if ($_SESSION['tipoPessoa'] == 1) {
            $idPf = $_SESSION['idUser'];
            include '../perfil/includes/menu_interno_pf.php';
        } else {
            $idPj = $_SESSION['idUser'];
            include '../perfil/includes/menu_interno_pj.php';
        }

        ?>

        <div class="form-group">
            <h4>Carta de intenção de incentivo</h4>
        </div>

        <?php

        $idProjeto = $_GET['idProjeto'];
        $projeto = recuperaDados("projeto","idProjeto",$idProjeto);

        if ($projeto['idEtapaProjeto'] == 35) {

            $sqlCarta = "SELECT * FROM upload_arquivo WHERE idPessoa = '$idProjeto' AND idListaDocumento = 18 ORDER BY dataEnvio";
            $queryCarta = mysqli_query($con, $sqlCarta);
            echo "<div class='table-responsive list_info'><h6>Carta(s) anexada(s)</h6>
                    <table class='table table-condensed'>
                        <thead>
				            <tr class='list_menu'>
					            <td>Tipo de arquivo</td>
					            <td>Data do Envio</td>
				            </tr>
			            </thead>";
             echo "<tbody>";


            while ($item = mysqli_fetch_array($queryCarta))
            {
                echo "<tr>";
                echo "<td class='list_description'>Carta de incentivo</td>";
                echo "<td class='list_description'><a href='../uploadsdocs/" . $item['arquivo'] . "' target='_blank'>" . mb_strimwidth($item['dataEnvio'], 0, 25, "...") . "</a></td>";
                echo "</tr>";
            }
            echo "</tbody>
					 </table></div>";
        }else
            {
                echo "<p>Ainda não há carta(s) inserida(s).<p/><br/>";
                echo "</div>";
            }
	?>


        <!-- Chamamento Alert-->
        <thead>
        <script src="../visual/js/sweetalert.min.js"></script>
        <link href="../visual/css/sweetalert.css" rel="stylesheet" type="text/css"/>
        <script>
            function alerta()
            {
                swal({   title: "Atenção!",
                    text: "Certifique-se de que preencheu todos os campos corretamente e que o tipo do arquivo seja PDF!",
                    timer: 10000,
                    confirmButtonColor:	"#5b6533",
                    showConfirmButton: true });}
            window.onload = alerta();
        </script>
        </thead>
        <div class="row">
            <div class="col-md-offset-1 col-md-10">
                <div class="list_info"><h6>Upload da carta de incentivo</h6>
                <form method="POST" enctype="multipart/form-data" action="?perfil=carta_incentivo_edita&idProjeto=<?= $idProjeto ?>" class="form-group" role="form">
                        <table class="table table-condensed">

                            <thead>
                            <tr class="list_menu">
                                <td width="50%">Tipo de arquivo</td>
                                <td></td>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td class="list_description">Carta de incentivo</td>
                                <td class="list_description"><input type="file" name="carta_incentivo" id="carta_incentivo" size="75"></center></td>
                            </tr>
                            </tbody>
                        </table>
                    <div class="form-group">
                        <div class="col-md-offset-2 col-md-8">
                            <br><input type="submit" name="enviar" class="btn btn-theme btn-lg btn-block" value="Fazer Upload">
                        </div>
                    </div>
                </form>
                </div>
                <div class="col-md-offset-4 col-md-6">
                    <form method="post" action="?perfil=projeto_visualizacao" class="form-group" role="form">
                        <br><input type="submit" value="Voltar" class="btn btn-theme btn-md btn-block">
                    </form>
                </div>
            </div>

        </div>
    </div>
    </div>
    </div>
</section>

