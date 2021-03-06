<?php 
  
  $erros = [];  

  function mensagemErro($tipoPessoa, $msg)
  {
    global $erros;
    
    array_push($erros, $msg);
    
    return $erros;
  }

  function ImpressaoMsgsErro($erros)
  {
    if(sizeof($erros) > 0): 
      foreach($erros as $erro): ?>        
        <div class="alert alert-danger container page-header">
          <p>É obrigatório o preenchimento <b><?=$erro?></b>. </p>  
        </div>        
      <?php endforeach;  
    endif;             
  }

  function camposObrigatorios($tipoPessoa, $idProjeto)
  { 
    global $erros;

    if($tipoPessoa == 1):           
      
      $campos = retornaCamposObrigatoriosPf($idProjeto);
       
      if(empty($campos)):            
        require_once('validacaoCamposObrigComplemento.php');           
      else:      
        $erros = array_unique(processaDados(
                     retornaCamposObrigatoriosPf($idProjeto))); 

      endif;    
    endif; 

    if($tipoPessoa == 2):         
      $campos = retornaCamposObrigatoriosPj($idProjeto);
    
      if(empty($campos)):        
        require_once('validacaoCamposObrigComplemento.php');
      else:
        $erros = array_unique(processaDados(
  	              retornaCamposObrigatoriosPj($idProjeto)));    
      endif;    
    endif;    

    ImpressaoMsgsErro($erros);
  }

  echo camposObrigatorios($tipoPessoa, $idProjeto);

