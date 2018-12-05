<section id="list_items" class="home-section bg-white">
    <div class="container">
        <?php

        $idProjeto = $_GET['idProjeto'];
        $projeto = recuperaDados("projeto","idProjeto",$idProjeto);

        if ($_SESSION['tipoPessoa'] == 1) {
            $idPf = $_SESSION['idUser'];
            include '../perfil/includes/menu_interno_pf.php';
        } else {
            $idPj = $_SESSION['idUser'];
            include '../perfil/includes/menu_interno_pj.php';
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
        <div class="form-group">
            <h4>Carta de incentivo</h4>
        </div>
        <div class="row">
            <div class="col-md-offset-1 col-md-10">
                <form method="POST" action="?perfil=carta_incentivo_edita&idProjeto=<?= $idProjeto ?>" class="form-group" role="form">

                    <hr/>

                    <label for="carta_incentivo">Upload da carta de incentivo</label><br><br>
                    <center><input type="file" name="carta_incentivo" id="carta_incentivo" size="75"></center>

                    <hr/>

                    <div class="form-group">
                        <div class="col-md-offset-2 col-md-8">
                            <input type="submit" name="enviar" class="btn btn-theme btn-lg btn-block" value="Enviar">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>