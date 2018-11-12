<section id="list_items" class="home-section bg-white">
    <div class="container"><?php include 'includes/menu_smc.php'; ?>
        <div class="form-group">
            <h4>Cadastro do link de agendamento</h4>
            <h5><?php if(isset($mensagem)){echo $mensagem;}; ?></h5>
        </div>
        <div class="row">
            <div class="col-md-offset-1 col-md-10">
                <form method="POST" action="?perfil=smc_cadastro_agendamento_edita" class="form-group" role="form">

                    <hr/>

                       <label for="link_agendamento">Informe o link</label><br>
                       <input type="url" name="link_agendamento" id="link_agendamento" size="75">

                    <hr/>

                    <div class="form-group">
                        <div class="col-md-offset-2 col-md-8">
                            <input type="submit" name="cadastrar" class="btn btn-theme btn-lg btn-block" value="Cadastrar">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>