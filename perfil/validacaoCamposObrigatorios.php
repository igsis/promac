<?php 
  
  $erros = [];  

  function mensagemErro($tipoPessoa, $msg)
  {
    global $erros;
    
    array_push($erros, $msg);

    /*$erros = ['dos campos Local, Ficha Técnica, Cronograma, Orçamento'];

    if($tipoPessoa == 2):
      $erros = ['dos campos Local, Ficha Técnica, Cronograma, Orçamento e 
                 Representante Legal'];
    endif;*/    
    
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
        
        /*$locais = retornaCamposObrigatoriosLocais($idProjeto);   
        $fichaTecnicas = retornaCamposObrigatoriosFichaTecnica($idProjeto); 
        $cronogramas = retornaCamposObrigatoriosCronograma($idProjeto); 
        $orcamentos = retornaCamposObrigatoriosOrcamento($idProjeto); 

        empty($locais) ? mensagemErro($tipoPessoa, 'da fase Local') : '';  
        empty($fichaTecnicas) ? mensagemErro($tipoPessoa, 'da fase Ficha Ténica') : '';  
        empty($cronogramas) ? mensagemErro($tipoPessoa, 'da fase Cronograma') : '';  
        empty($orcamentos) ? mensagemErro($tipoPessoa, 'da fase Orçamento') : '';*/

        require_once('validacaoArqsObrigsComplemento.php');           

      else:      
        $erros = array_unique(processaDados(
                     retornaCamposObrigatoriosPf($idProjeto))); 

      endif;    
    endif; 

    if($tipoPessoa == 2):         
      $campos = retornaCamposObrigatoriosPj($idProjeto);
    
      if(empty($campos)):
        $erros = mensagemErro($tipoPessoa);
      else:
        $erros = array_unique(processaDados(
  	              retornaCamposObrigatoriosPj($idProjeto)));    
      endif;    
    endif;    

    ImpressaoMsgsErro($erros);
  }

  echo camposObrigatorios($tipoPessoa, $idProjeto);

