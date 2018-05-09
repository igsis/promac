<?php   
  require_once('../funcoes/funcoesGerais.php');  
  require_once('../funcoes/funcoesConecta.php');         
  
  $logs = getLogs(geraHeaderWebLog());      
    
  include('../../promac/visual/webLogHeader.php'); ?>
  
  <h1 class="title">Consulta</h1>
  <div class="containerHeader">
    <form action="webLogConsulta.php" method="POST" class="form-horizontal">
      <div class="form-group">
        <div class="col-md-offset-2 col-md-6">
          <label id="dataInicio">Inicio:</label>
          <input type="date" name="dt-inicio" value="<?php echo date('d-m-Y')?>" class="form-control set-input-dtIncio" id="dataInicio">
        </div>        
        <div class="col-md-offset-2 col-md-6">
          <label id="dataFim">Fim:</label>
          <input type="date" name="dt-fim" value="<?php echo date('d-m-Y')?>" class="form-control"
                 id="dataFim">
        </div>  
      </div>      
      <div>
        <label id="nome">Nome</label>  
        <input type="text" name="nome" class="form-control" id="nome">
      </div>  
      <div>
        <label id="tabela">Tabelas</label>  
        <?php $tabelas = ['pessoa_fisica', 'pessoa_juridica', 'projeto', 'todos' ] ?>
        <select name="tabela" id="tabela">
          <?php foreach($tabelas as $tabela): ?>
            <option value="<?=$tabela?>"><?=$tabela?></option>
          <?php endforeach ?>
        </select>        
      </div>
      <button type="submit" class="btn btn-success" id="button">Pesquisar</button>    
    </form>        
    <?php return include('webLogTable.php'); ?>
  </div>  
  <?php include('../../promac/visual/webLogFooter.php'); ?>
  



  
  
  