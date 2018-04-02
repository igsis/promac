<?php 
    
  $arqPendentes = [];  
  

  function ImpressaoMsgErros($arqPendentes)
  {
    if(sizeof($arqPendentes) == 0): 
      foreach($arqPendentes as $nomeArquivo): ?>
        <div class="alert alert-danger container page-header">
          <p>O arquivo <b><?=$nomeArquivo?></b> está pendente</b> </p>  
        </div>
      <?php endforeach;  
    endif;
  }
  

  function arquivosObrigatorios($tipoPessoa, $tipoDoc, $idUser, $idProjeto)
  {
    
    global  $arqPendentes;        

    if($tipoDoc == 'proponente'):      
      $docObrig = formataDados(
                    retornaDocumentosObrigatoriosProponente($tipoPessoa));

      $docCarregados = formataDados(
                       retornaArquivosCarregados($idUser)); 

    elseif ($tipoDoc == 'anexo'):
      $docObrig = formataDados(retornaArquivosObrigatorios($tipoPessoa));      
      
      $docCarregados = formataDados(
                         retornaAnexosCarregados($idProjeto)); 
      
    endif;       
    
    $listaDivergencias = formataDados(
                             analiseArquivos($docObrig, $docCarregados));
  
    $arqPendentes = array_unique($listaDivergencias); 

    ImpressaoMsgErros($arqPendentes);    
  }

  echo arquivosObrigatorios($tipoPessoa, $tipoDoc, $idUser, $idProjeto);

    
 