<div class="container">
  <table class="table table-striped table-hover">
    <thead>
      <tr>
        <th>IDLOG</th>
        <th>TABELA</th>  
        <th>AÇÃO</th>
        <th>DATA</th>
        <th>PESSOA FISICA</th>      
      </tr>  
    </thead>  
    <tbody>
      <?php foreach($logs as $log):?>
        <tr>
          <td><?=$log['idWebLog']?></td>  
          <td><?=$log['tabela']?></td>
          <td><?=$log['acao']?></td>          
          <td><?=date('d/m/y',strtotime($log['dataOcorrencia']))?></td> 
          <td><?=$log['nome']?></td>
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
</div>