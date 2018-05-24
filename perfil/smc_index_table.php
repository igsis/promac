<table class='table table-condensed'>
  <thead class='list_menu'>
    <tr>
  	  <th>Protocolo (nº ISP)</th>
   	  <th>Nome do Projeto</th>
	    <th>Proponente</th>
	    <th>Documento</th>
	    <th>Área de Atuação</th>
	    <th width='10%'></th>
    </tr>	
  </thead>  
  <tbody>  	
    <?php foreach($campos as $campo) :?>
      <tr>  	    
        <td><?=$campo['protocolo']?></td>
  	    <td><?=$campo['nomeProjeto']?></td>  
  	    <td>
  	      <?= 
  	        isset($campo['nomePf'])
  	          ? $campo['nomePf']
  	          : $campo['nomePj'];
  	      ?>
  	    </td>  
  	    <td>
  	      <?= 
  	        isset($campo['cpf'])
  	          ? $campo['cpf']
  	          : $campo['cnpj'];
  	      ?>
  	    </td>  
 	      <td><?=$campo['areaAtuacao']?></td>  	
 	      <td class='list_description'>
	        <form method='POST' action='?perfil=smc_detalhes_projeto'>
		        <input type='hidden' name='idProjeto' value='<?=$campo['idProjeto']?>'>
		        <input type ='submit' class='btn btn-theme btn-block' value='Visualizar'>
		      </form>
	      </td> 
  	  </tr>   
  	<?php endforeach ?>  
  </tbody>
</table>