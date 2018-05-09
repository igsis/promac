<?php   
  require_once('../funcoes/funcoesGerais.php');  
  require_once('../funcoes/funcoesConecta.php');          

  include('../../promac/visual/webLogHeader.php');

  $idWebLog = $_GET['id'];
  $logs = geraWebLogDetalhes($idWebLog); 
  $old = retornaDados($logs, 'antes');
  $new = retornaDados($logs, 'depois');
  $log = array_diff($old, $new); ?>

  <h1 class="title">Registros Manipulados</h1>  
  <div class="container">
    <div class="old">      
      <p>Anterior</p>
      <?php
        foreach($old as $o):
          echo $o.'<br/>'.'<hr/>';
        endforeach;         
      ?>  
    </div>     
    <div class="new">
      <p>Atual</p>
      <?php
        foreach($new as $n):
          echo $n.'<br/>'.'<hr/>';
        endforeach;  
      ?>
    </div>     
  </div>
  
  


  
  






  
  
  
    







  



  



  

  

