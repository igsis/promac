<?php
$con = bancoMysqli();
$idPj = $_SESSION['idPj'];

if(isset($_POST["Verificar"]))
{
}

?>

<section id="list_items" class="home-section bg-white">
<div class="form-group"><div="well">
  <div class="col-md-offset-2 col-md-8"><strong>Você está sendo representado por uma cooperativa?</strong><br/><br/></div>
</div></div>
<div class="form-group">
  <div class="col-md-offset-2 col-md-2">
    <form class="form-horizontal" role="form" action="?perfil=projeto_pf" method="post">
      <input type="submit" value="Não" class="btn btn-theme btn-lg btn-block"  value="<?php echo $idPj ?>">
    </form>
  </div>
  <div class="col-md-offset-4 col-md-2">
    <form class="form-horizontal" role="form" action="?perfil=cooperado" method="post">
      <input type="submit" value="SIM" class="btn btn-theme btn-lg btn-block" value='Verificar'>
    </form>
  </div>
</div>
</section>
