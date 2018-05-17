<?php 
  $erros = [];  
   
  validaData($_POST['dt-inicio'], $_POST['dt-fim'])
    ? ''
    : array_push($erros, 'Data de inicio deve ser maior que a data final');
   
  $_POST['tabela'] == 'todos'
    ? $logs = geraHeaderWebLogTodos($_POST['dt-inicio'], $_POST['dt-fim'])
    : $logs = geraHeaderWebLogParam($_POST['dt-inicio'], $_POST['dt-fim'], $_POST['tabela'], 
      $_POST['nome']); 

  sizeof($logs) == 0
    ? array_push($erros, 'Não existe registros nesse período')
    : ''; 

  if(sizeof($erros)):
    foreach($erros as $erro): ?>       
      <div class="alert alert-warning msg">
        <p><?=$erro?></p><br/>        
      </div>               
    <?php endforeach;
  else: ?>
    <h1 class="title">Consulta</h1>  
  <?php endif; 