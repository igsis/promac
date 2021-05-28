<?php   
  require_once('../funcoes/funcoesGerais.php');  
  require_once('../funcoes/funcoesConecta.php');          

  include('../../promac/visual/webLogHeader.php');
   
  $logs = geraWebLogDetalhes($_GET['id']);   
  $old = retornaDados($logs, 'antes');
  $new = retornaDados($logs, 'depois');     
  ?>
  
  <h1 class="title">Registro Manipulado </h1> 
  <div class="containerDetalhe">
    <div class="old">      
      <p style="color:blue">ANTERIOR</p>
      <?php
        for ($i=0; $i <count($old) ; $i++):                      
          if($old[$i] != $new[$i]): 
            echo $old[$i].'<br/>'.'<hr/>';
          endif;  
        endfor;
      ?>  
    </div>     
    <div class="new">
      <p style="color:blue">ATUAL</p>
      <?php
        for ($i=0; $i <count($old) ; $i++):  
          if($old[$i] != $new[$i]): 
            echo $new[$i].'<br/>'.'<hr/>';
          endif;            
        endfor;
      ?>
    </div>     
  </div>
  
  


  
  






  
  
  
    







  



  



  

  

