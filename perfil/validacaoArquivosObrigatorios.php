<?php 
    
  $arqPendentes = [];

  function ImpressaoMsgErros($arqPendentes)
  {
    if(sizeof($arqPendentes) > 0): 
      foreach($arqPendentes as $nomeArquivo): ?>
        <div class="alert alert-danger container page-header">
          <p>O arquivo <b><?=$nomeArquivo?></b> está pendente</b> </p>  
        </div>
      <?php endforeach;  
    endif;
  }

  function arquivosObrigatorios($tipoPessoa)
  {

    global  $arqPendentes;

    $docObrig = formataDados(retornaArquivosObrigatorios($tipoPessoa));   
    
    $docCarregados = formataDados(
                       retornaArquivosCarregados($tipoPessoa)); 

    $listaDivergencias = formataDados(
                             analiseArquivos($docObrig, $docCarregados));
  
    $arqPendentes = array_unique($listaDivergencias); 

    ImpressaoMsgErros($arqPendentes);    
  }

  echo arquivosObrigatorios($tipoPessoa);
    
 