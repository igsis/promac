<?php   
  $locais = retornaCamposObrigatoriosLocais($idProjeto);   
  $fichaTecnicas = retornaCamposObrigatoriosFichaTecnica($idProjeto); 
  $cronogramas = retornaCamposObrigatoriosCronograma($idProjeto); 
  $orcamentos = retornaCamposObrigatoriosOrcamento($idProjeto); 

  empty($locais) ? mensagemErro($tipoPessoa, 'da fase Local') : '';  
  empty($fichaTecnicas) ? mensagemErro($tipoPessoa, 'da fase Ficha Ténica') : '';  
  empty($cronogramas) ? mensagemErro($tipoPessoa, 'da fase Cronograma') : '';  
  empty($orcamentos) ? mensagemErro($tipoPessoa, 'da fase Orçamento') : ''; 

  if($tipoPessoa == 2):
   $representatesLegais = retornaCamposObrigatoriosRepresentate($idProjeto);	
   empty($representatesLegais) ? mensagemErro($tipoPessoa, 'da fase Representate Legal'):''; 
  endif; 

