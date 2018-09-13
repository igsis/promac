<div role="tabpanel" class="tab-pane fade" id="pagamentos"> 
 <form method="POST" action="?perfil=cadastro_reserva&idProjeto=<?=$idProjeto?>" class="form-horizontal" role="form">
   <h5> <?php if(isset($mensagem)){echo $mensagem;}; ?></h5>
     <div class="form-group">
       <h4>Reservas</h4>
     </div>
       <div class="form-group">
         <div class="col-md-offset-2 col-md-8">
          <input type="submit" class="btn btn-theme btn-md btn-block" value="INSERIR RESERVA">
         </div>
       </div>

   <div class="form-group">
     <div class="col-md-12">
       <hr/>
     </div>
   </div>
 </form>

<?php
    $sql = "SELECT * FROM reserva WHERE idProjeto = '$idProjeto'";
     $query = mysqli_query($con, $sql);
     $num = mysqli_num_rows($query);
        if($num > 0) {
 ?>
<div class="table-responsive list_info">
 <table class='table table-condensed'>
      <thead>
       <tr class='list_menu'>
         <td>Data</td>
         <td>Valor</td>
         <td>Número da Reserva</td>
         <td></td>
         <td></td>
         <td></td>
       </tr>
      </thead>

  <tbody>
     <?php while ($reserva = mysqli_fetch_array($query)) { ?>
    <tr>
      <td>
        <?php echo exibirDataBr($reserva['data']) 
        ?>
      </td>
      <td>
        <?php echo dinheiroParabr($reserva['valor']); 
        ?>
      </td>
      <td>
        <?php echo $reserva['numeroReserva']; 
        ?>
      </td>

     <td class="list_description">
       <form method="POST" action="?perfil=edicao_reserva&idReserva=<?=$reserva['idReserva']?>">
         <input type="hidden" name="idReserva" value="'.$linha['idReserva'].'" />
         <input type="submit" class="btn btn-theme btn-block" value="editar">
       </form>
     </td>

     <td class='list_description'>
       <form method="POST" action="?perfil=empenho&idReserva=<?=$reserva['idReserva']?>">
         <input type='hidden' name='' value='".$campo[' ']."' />
         <input type='submit' class='btn btn-theme btn-block' value='empenhos'>
       </form>
     </td>

     <td class='list_description'>
       <form method='POST' action="?perfil=deposito&idReserva=<?=$reserva['idReserva']?>&idProjeto=<?=$reserva['idProjeto']?>">
         <input type='hidden' name='' value='".$campo[' ']."' />
         <input type='submit' class='btn btn-theme btn-block' value='depósitos'>
        </form>
     </td>
   </tr>
<?php } ?>
  </tbody>
 </table>
</div>

<?php
} 
else 
{ 
 ?> 
   <h4>Não existem reservas cadastradas!</h4> <?php } ?>
 </div>

