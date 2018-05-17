<div class="container">
  <table class="table table-striped table-hover">
    <thead>
      <tr>
        <th>IDLOG</th>        
        <th>TABELA</th>  
        <th>AÇÃO</th>
        <th>DATA</th>
        <th>PESSOA FISICA</th>        
        <th>ALTERADO POR</th>
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
            <?=$log['alteradoPor'] == 'none'
              ? ''
              : $log['alteradoPor']; 
            ?>              
          </td>
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
  <?php 
    $nextPg = $pagina + 1;
    $prevPag = $pagina - 1;    
  ?>   
  <center>
    <nav aria-label="Page navigation example">
      <ul class="pagination">
        <li class="page-item">
          <?php if($prevPag != 0):?>
            <a class="page-link" 
               href="webLog.php?pagina=<?=$prevPag?>"
               aria-label="Previous">
              <span aria-hidden="true">&laquo;</span>
              <span class="sr-only">Previous</span>
            </a>
          <?php endif ?>  
        </li>
        <?php for ($i=1; $i < $numPaginas + 1; $i++): ?>
          <li class="page-item">
            <a class="page-link" 
               href="webLog.php?pagina=<?=$i?>"><?=$i?></a>
          </li>
        <?php endfor ?>  
        <li class="page-item">
          <?php if($nextPg != 0):?>
            <a class="page-link" 
               href="webLog.php?pagina=<?=$nextPg?>"
               aria-label="Next">
              <span aria-hidden="true">&raquo;</span>
              <span class="sr-only">Next</span>
            </a>
          <?php endif ?>  
        </li>
      </ul>
    </nav> 
  </center>
</div>