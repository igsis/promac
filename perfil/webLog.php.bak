<?php   
  require_once('../funcoes/funcoesGerais.php');  
  require_once('../funcoes/funcoesConecta.php');     

  $tipo="Pessoa Física";
  $erros = [];

  function impressaoMsgErros($erros)
  {
    foreach($erros as $erro):
      echo $erro;  
    endforeach;
  }

  if(array_key_exists('dataInicio', $_POST)):              
     if(validaData($_POST['dataInicio'], $_POST['dataFim'])): 
       array_push($erros,'<b>Data de inicio</b> não pode ser maior que a <b>Data de fim</b>.<br/>');       
     endif;         
     $logs = geraWebLog($_POST['dataInicio'], $_POST['dataFim'], "ORDER BY pf.nome");     
  else:
     $logs = geraWebLog(date('y/m/d'),date('y/m/d'), "ORDER BY log.dataOcorrencia desc");     
  endif; 
    
  include("../views/header.php");
  include("webLogFormData.php");

  if(empty($logs)): 
    array_push($erros, 'Lista não possui registros'); ?>           
    <div class="alert alert-warning">
      <p><?php impressaoMsgErros($erros);?></p>
    </div>  
  <?php else: ?>    
    <table class="table table-bordered table-dark table-striped table-hover">
      <thead>
        <tr>
      	  <th scope="col">ID</th>
      	  <th>TABELA</th>
      	  <th>ACAO</th>                               
      	  <th>PESSOA FÍSICA</th>
      	  <th>DATA</th>     
          <th>DETALHES</th> 	  
        </tr>
      </thead>	
      <tbody>
        <?php foreach($logs as $log):?>
          <tr>
            <td><?=$log['idWebLog']?></td>
            <td><?=$log['tabela']?></td>
            <td><?=$log['acao']?></td>
            <td><?=$log['nome']?></td>
            <td><?=date('d/m/y',strtotime($log['dataOcorrencia']))?></td>      
            <td>
              <a href="webLogDetalhes.php?id=<?=$log['idWebLog']?>" target="_blank">  
                <span class="glyphicon glyphicon-search" aria-hidden="true">
                </span>
              </a>  
            </td>
          </tr>	
       <?php endforeach ?>
      </tbody>
    </table>
    <?php include("../views/header.php") ?>
  <?php endif ?>
  







