<?php 
  $cleaner = cleanerWeblog();
  if(sizeof($cleaner) > 0):
    buscaRegistrosSemAlteracoes($cleaner);    
  endif;  

  limpaRegistrosNulos();  