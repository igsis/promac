<?php 

 require_once('../funcoes/funcoesGerais.php');  
 require_once('../funcoes/funcoesConecta.php');              
 include('../../promac/visual/webLogHeader.php');

 $cleaner = cleanerWeblog();
   if(sizeof($cleaner) > 0):
     buscaRegistrosSemAlteracoes($cleaner);    
  endif;  

 limpaRegistrosNulos();  
 
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
?>
 
 <div class="containerHeader">
   <form action="webLogConsulta.php" method="POST" class="form-horizontal">
     <div class="form-group">
       <div class="col-md-offset-2 col-md-6">
         <label id="dataInicio">Inicio:</label>
         <input type="date" name="dt-inicio" value="<?=$_POST['dt-inicio']?>" class="form-control set-input-dtIncio" id="dataInicio">
       </div>        
       <div class="col-md-offset-2 col-md-6">
         <label id="dataFim">Fim:</label>
         <input type="date" name="dt-fim" value="<?=$_POST['dt-fim']?>" class="form-control"
                 id="dataFim">
       </div>  
     </div>      
     <div>
        <label id="nome">Nome</label>  
        <input type="text" name="nome" value="<?=$_POST['nome']?>" class="form-control" id="nome">
      </div>  
     <div>
       <label id="tabela">Tabelas</label>  
       <?php $tabelas = ['pessoa_fisica', 'pessoa_juridica', 'projeto', 'todos' ] ?>
       <select name="tabela" id="tabela">
         <?php 
           foreach($tabelas as $tabela): 
             $selected = 
               $_POST['tabela'] == $tabela
                 ? "selected"
                 : '' ?>
             <option value="<?=$tabela?>" <?=$selected?>><?=$tabela?></option>
           <?php endforeach ?>
        </select>
     </div>            
     <button type="submit" class="btn btn-success" id="button">Pesquisar</button>    
   </form> 
   <?php return include('webLogTable.php'); ?>        
 </div>


 
 


  
 
 




 

 


  

