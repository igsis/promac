<!DOCTYPE html>
<html>
  <head>    
    <title>SMC / Pro-Mac - Programa Municipal de Apoio a Projetos Culturais</title>    
    <meta charset="utf-8">        
    <link rel="stylesheet" type="text/css" href="../views/css/detalheLog.css">    
  </head>
  <body>    
   <h1 class="title">Detalhes</h1>  
   <p class="old">Anterior</p>
   <p class="new">Atual</p>
   <?php   
    require_once('../funcoes/funcoesGerais.php');  
    require_once('../funcoes/funcoesConecta.php');          

    $idWebLog = $_GET['id'];

    $logs = geraWebLogDetalhes($idWebLog);  ?>
      
    <?php foreach($logs as $log): ?>
      <div class="container">                            
        <div class="antes">                    
          <?php echo str_replace('|', '<br/><hr/>', $log['antes']);?>
        </div>  	            	    	
        <div class="depois">
          <?php echo str_replace('|', '<br/><hr/>', $log['depois']);?>
        </div>              	    	      
    <?php endforeach ?>	     
  </body>
</html>    


    
  
  