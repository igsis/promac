<h1 class="title">Monitoramento <?=$tipo?></h1>  
<form action="?idWebLog.php" method="POST">      
  <div class="form-group row container containerInput">    
    <label class="col-2 col-form-label">Período</label>
    <div class="col-10 dataInicio">  
      <input type="date" class="form-control" name="dataInicio" value="<?=$_POST['dataInicio']?>">
    </div>  
    <div class="col-10 dataFim">  
      <input type="date" name="dataFim" class="form-control" value="<?=$_POST['dataFim']?>">
    </div>      
    <div class="col-10 dataFim">
      <button type="submit" class="btn-busca">Buscar</button>        
    </div>
  </div>  
</form> 

