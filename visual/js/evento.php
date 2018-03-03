<? include "funcoes.php";?>
<? include "configuracao.php";?>
<? include "iniciar_sessao.php"; ?>
<? include "script.php"; ?>


<?
if(!isset($_GET['p'])){
	$pag = 1;
}else {
	$pag = $_GET['p'];
}


$sql_dic = "SELECT * FROM ig_dic WHERE dic_evento='$id_evento';";
$dic = mysql_query($sql_dic);
$campo_dic = mysql_fetch_array($dic);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <head>

<link rel="stylesheet" href="jquery-ui.css" />
<link rel="stylesheet" type="text/css" href="igccsp.css">

    <title><? echo $titulo_pagina; ?></title>
    </head>
    
    <body>
	<div class = "center">
<?php include "menu.php"; ?>
         
<script>
$( "#button01" ).click(function() {
  $( "div#contratado" ).show( "fold", 1000 );
});
</script>

    	<div id="caixa">    	
<form method="post" action="atualizar_evento.php" >

<?
switch ($pag){
case 1:
?>
    	

[Apresentação Básica] [<a href="evento.php?p=2">Detalhamento</a>] [<a href="evento.php?p=3">Conteúdo</a>] [<a href="evento.php?p=4">Serviços Internos</a>] [<a href="evento.php?p=5">Especificidades de Área</a>]
<h2>Apresentação Básica</h2>
                <p>* campos obrigatórios.</p>
                
<label for="pg01_modalidade">Tipo de modalidade</label><br />
<select name="pg01_modalidade" id="pg01_modalidade">
<?
	$sql2 = "SELECT * FROM ig_modalidades";
	$lista2 = mysql_query($sql2);
	while($campo2 = mysql_fetch_array($lista2)){ ?>
        <option value="<? echo $campo2['id_modalidade'];?>" <? checked($campo['pg01_modalidade'],$campo2['id_modalidade']); ?> ><? echo $campo2['modalidade']; ?></option>	
        <? } ?>
</select>                
<br /><br />

<label for="pg01_programa">Nome do Programa</label><br />
<?php
	$selected = $campo['pg01_programa']; 
	form_programa($selected); ?>
 
<input type="button" class="button" value="?" onClick="dalert.alert('Considera-se no campo PROGRAMA deste sistema apenas programas institucionais do Centro Cultural São Paulo que permeiam e são princípio para as ações e reflexões de todas as áreas da instituição, ainda que não estejam presentes em todos os eventos. A criação de um programa deve ser feita coletivamente entre os funcionários com posterior aprovação em reunião de diretoria. Por isso, neste campo, não é possível criar uma categoria, apenas é oferecido selecionar um entre os programas já existentes e consolidados no CCSP.');"/> 

<br /><br />

<label for="pg01_projeto_especial">Nome do Projeto Especial</label><br />
<?php 
	$selected2 = $campo['pg01_projeto_especial'];
	form_projetos($selected2); ?> <input type="button" class="button" value="?" onClick="dalert.alert('Considera-se no campo PROJETOS ESPECIAIS deste sistema apenas projetos especiais que envolvam mais de uma área curatorial e tenham alta relevância na programação da instituição, devendo receber atenção especial das áreas. Um novo projeto especial deve ser criado em trabalho conjunto das curadorias do CCSP e, portanto, um novo projeto especial só pode ser inserido no sistema pelo Diretor de Curadoria. No preenchimento, caberá ao Curador apenas selecionar o projeto especial na lista de projetos em andamento. <br />Atenção: um projeto especial é diferente de um projeto de uma única área, como um festival de música ou uma mostra de teatro, por exemplo – para estes casos, há um campo específico abaixo: Nome do Projeto.');"/></p>
<br /><br />
	
<label for="pg01_evento">Nome do Evento *</label><br />
<input name="pg01_evento" type="text" id="pg01_evento" size="80" value="<? echo html_entity_decode($campo['pg01_evento']); ?>" />


<br /><br />
	
<label for="pg01_projeto">Nome do Projeto</label><br />
<input name="pg01_projeto" type="text" id="pg01_projeto" size="80" value="<? echo $campo['pg01_projeto']; ?>"/>

<br />  <br />
<label for="pg01_tipo_evento">Tipo de Evento *</label><br />
  <? form_tipo_evento($id_evento); ?>

<br />  <br />
<label for="pg01_memorando">Memorando</label><input type="button" class="button" value="?" onClick="dalert.alert('Caso haja um documento interno relacionado a este evento, por favor, preencha este campo com o número deste documento. Valeu!');"/>
  <br />
  <input name="pg01_memorando" type="text" id="pg01_memorando" size="30" value="<? echo $campo['pg01_memorando']; ?>"/>
<br />  <br />
<label for="pg01_responsavel">Nome do Responsável pelo Evento no CCSP * </label><br />
  <input name="pg01_responsavel" type="text" id="pg01_responsavel" size="50" value="<? echo $campo['pg01_resp_ccsp']; ?>"/><br /><br />
<label for="pg01_ramal">Telefone / Ramal do Responsável pelo Evento do CCSP * </label><br />
  <input name="pg01_ramal" type="text" id="pg01_ramal" size="50" value="<? echo $campo['pg01_ramal']; ?>" />
<br /><br />
<label for="pg01_email">E-mail do Responsável pelo Evento no CCSP *</label><br />
  <input name="pg01_email" type="text" id="pg01_email" size="50" value="<? echo $campo['pg01_email']; ?>"/>
<br /><br />
				  

				</li>

	<div id="gravar">
<input type="hidden" name="pag" value="<? echo $pag; ?>"  />

			
		
					<h3> <input type="submit" value="Gravar" id="gobutton" /> ATENÇÃO! Todas as informações inseridas sobre o evento só terão efetividade se forem gravadas a cada etapa.</h3>
                    

                    
                     
					  <br />


		  </form>
					
</div>		
			<!-- Fim: Conteúdo das abas -->
		
		</div>
		
		<!-- Fim: Caixa -->
		
 <script type="text/javascript">
			
			$(function(){
				// quick routine for scrolling nav
				var $nav = $('.header ul'),
					navoffset = $nav.offset(),
					$navclone = $nav.clone().addClass('scrollnav').appendTo('.header'),
					$window = $(window);
				$window.scroll(function(e){
					if((navoffset.top+50) < $window.scrollTop()){
						if(!$navclone.hasClass('scrolled'))
							$navclone.addClass('scrolled');
					}
					else $navclone.removeClass('scrolled');
				}).scroll();

				// run the examples
				$('.example-container').each(function(i,el){
					var $ex = $(this),
						$run = $ex.find('.run'),
						code = $ex.find('.code').text();
					$run.click(function(e){
						e.preventDefault();
						(new Function(code))();
					});
				});

				// hotlink the tour
				$('#TourLink').click(function(e){
					e.preventDefault();
					$('#TourExample button').click();
				});
			});
			
		</script>

     
        <? include "rodape.php"; ?>  

		


</div>
  

    </body>
    
</html>
<? break; 

case 2:
?>				
[<a href="evento.php?p=1">Apresentação Básica</a>] [Detalhamento] [<a href="evento.php?p=3">Conteúdo</a>] [<a href="evento.php?p=4">Serviços Internos</a>] [<a href="evento.php?p=5">Especificidades de Área</a>]
				
               <h2>Detalhamento</h2>
                <p>* campos obrigatórios.</p>
<br /> <br />
<label for="pg02_autor">Autor *</label>         
<input type="button" class="button" value="?" onClick="dalert.alert('Por AUTOR entendemos neste sistema o artista ou grupo que irá se apresentar. Pode ser o cantor, dramaturgo, bailarino, palestrante. Utilizamos esta terminologia para futuras integrações com outros bancos de dados');"/><br />
<textarea name="pg02_autor" id="pg02_autor" cols="60" rows="5" ><? echo html_entity_decode($campo['pg02_autor']); ?></textarea><br />
  

<label for="pg02_ficha">Ficha técnica completa *</label><br />         
<textarea name="pg02_ficha" id="pg02_ficha" cols="60" rows="5"><? echo html_entity_decode($campo['pg02_ficha']); ?></textarea><br /><br />
  
<label for="pg02_etaria">Classificação etária *</label><br />         
<select name='pg02_etaria' id='pg02_etaria'>
<option value='12' <? checked(12,$campo['pg02_etaria']); ?>  >12 anos</option>
<option value='14' <? checked(14,$campo['pg02_etaria']); ?>>14 anos</option>
<option value='16' <? checked(16,$campo['pg02_etaria']); ?>>16 anos</option>
<option value='18' <? checked(18,$campo['pg02_etaria']); ?>>18 anos</option>
<option value='Livre' <? checked('Livre',$campo['pg02_etaria']); ?>>Livre</option>
</select>

<br />
<br />

<label for="pg02_duracao">Duração do evento em minutos (ex: 120 minutos)</label><br />  
  <input name="pg02_duracao" type="text" id="pg_duracao" size="30"value="<? echo $campo['pg02_duracao']; ?>" /> minutos<br /><br />
  
<p>Período / Data <input type="button" class="button" value="?" onClick="dalert.alert('Se for data única, preencher somente a data início');"/></p>
	
	  
<label for="datepicker01">Início:</label>  
  <input type="Text" id="datepicker01" name="pg02_data_inicio" value="<? echo $campo['pg02_data_inicio']; ?>"> (AAAA-MM-DD)<br />
<label for="datepicker02">Encerramento: </label>  
      <input type="Text" id="datepicker02" name="pg02_data_final" value="<? echo $campo['pg02_data_final']; ?>"> (AAAA-MM-DD)
<br /><br /><br />
  
<label for="pg02_dia_semana_hora">Dia(s) da Semana e Horário(s) * </label> 
<input type="button" class="button" value="?" onClick="dalert.alert('Ex: De terça a domingo / HH:MM');"/><br />
<textarea name="pg02_dia_semana_hora" id="pg02_dia_semana_hora" cols="60" rows="5"><? echo $campo['pg02_dia_semana_hora']; ?></textarea><br /><br />

<label for="pg02_dias_especiais">Dias Especiais </label> 
<input type="button" class="button" value="?" onClick="dalert.alert(' Especificar dias em que não acontecerá o evento, apresentações especiais e de preço popular, audiodescrição, libras, alteração da sala.');"/>  <br />
  
 <textarea name="pg02_dias_especiais" id="pg02_dias_especiais" cols="60" rows="5"><? echo $campo['pg02_dias_especiais']; ?></textarea></p><br /><br />
  
<label for="pg02_ingresso">Valor do Ingresso * </label><br />
  <input name="pg02_ingresso" type="text" id="pg02_ingresso" size="30" value="<? echo $campo['pg02_ingresso']; ?>"/>,00<br /><br /><br />
  

<label for="pg02_retirada_ingresso">Sistema de retirada de ingresso *</label>
<input type="button" class="button" value="?" onClick="dalert.alert(' O sistema de retirada de ingressos é definido entre o curador, a produção do evento ou o artista e a produção do CCSP. Neste campo você deve indicar as datas e horários de abertura da bilheteria para distribuição de ingressos desse evento e quantos ingressos serão distribuídos por pessoa.');"/><br />

<select name="pg02_retirada_ingresso" id="pg02_retirada_ingresso">
<?
switch($campo['pg02_retirada_ingresso']){

case "gratuito – 2 ingressos por pessoa – 2 horas de antecedência":
	echo " 
<option value='gratuito – 2 ingressos por pessoa – 2 horas de antecedência' selected>gratuito – 2 ingressos por pessoa – 2 horas de antecedência</option>
<option value='gratuito – 2 ingressos por pessoa – das 14h às 20h, a partir da quarta-feira anterior ao evento'>gratuito – 2 ingressos por pessoa – das 14h às 20h, a partir da quarta-feira anterior ao evento</option>
<option value='pago – 2 horas de antecedência'>pago – 2 horas de antecedência</option>
<option value='pago – das 14h às 20h, a partir da quarta-feira anterior ao evento'>pago – das 14h às 20h, a partir da quarta-feira anterior ao evento</option>
<option value='sem necessidade de retirada de ingressos'>sem necessidade de retirada de ingressos</option>"; 
break;

case "gratuito – 2 ingressos por pessoa – das 14h às 20h, a partir da quarta-feira anterior ao evento":
	echo " 
<option value='gratuito – 2 ingressos por pessoa – 2 horas de antecedência'>gratuito – 2 ingressos por pessoa – 2 horas de antecedência</option>
<option value='gratuito – 2 ingressos por pessoa – das 14h às 20h, a partir da quarta-feira anterior ao evento' selected>gratuito – 2 ingressos por pessoa – das 14h às 20h, a partir da quarta-feira anterior ao evento</option>
<option value='pago – 2 horas de antecedência'>pago – 2 horas de antecedência</option>
<option value='pago – das 14h às 20h, a partir da quarta-feira anterior ao evento'>pago – das 14h às 20h, a partir da quarta-feira anterior ao evento</option>
<option value='sem necessidade de retirada de ingressos'>sem necessidade de retirada de ingressos</option>"; 
break;

case "pago – 2 horas de antecedência":
	echo " 
<option value='gratuito – 2 ingressos por pessoa – 2 horas de antecedência'>gratuito – 2 ingressos por pessoa – 2 horas de antecedência</option>
<option value='gratuito – 2 ingressos por pessoa – das 14h às 20h, a partir da quarta-feira anterior ao evento'>gratuito – 2 ingressos por pessoa – das 14h às 20h, a partir da quarta-feira anterior ao evento</option>
<option value='pago – 2 horas de antecedência' selected>pago – 2 horas de antecedência</option>
<option value='pago – das 14h às 20h, a partir da quarta-feira anterior ao evento'>pago – das 14h às 20h, a partir da quarta-feira anterior ao evento</option>
<option value='sem necessidade de retirada de ingressos'>sem necessidade de retirada de ingressos</option>"; 
break;

case "pago – das 14h às 20h, a partir da quarta-feira anterior ao evento":
	echo " 
<option value='gratuito – 2 ingressos por pessoa – 2 horas de antecedência'>gratuito – 2 ingressos por pessoa – 2 horas de antecedência</option>
<option value='gratuito – 2 ingressos por pessoa – das 14h às 20h, a partir da quarta-feira anterior ao evento'>gratuito – 2 ingressos por pessoa – das 14h às 20h, a partir da quarta-feira anterior ao evento</option>
<option value='pago – 2 horas de antecedência'>pago – 2 horas de antecedência</option>
<option value='pago – das 14h às 20h, a partir da quarta-feira anterior ao evento' selected>pago – das 14h às 20h, a partir da quarta-feira anterior ao evento</option>
<option value='sem necessidade de retirada de ingressos'>sem necessidade de retirada de ingressos</option>"; 
break;
case "sem necessidade de retirada de ingressos":
	echo " 
<option value='gratuito – 2 ingressos por pessoa – 2 horas de antecedência'>gratuito – 2 ingressos por pessoa – 2 horas de antecedência</option>
<option value='gratuito – 2 ingressos por pessoa – das 14h às 20h, a partir da quarta-feira anterior ao evento'>gratuito – 2 ingressos por pessoa – das 14h às 20h, a partir da quarta-feira anterior ao evento</option>
<option value='pago – 2 horas de antecedência'>pago – 2 horas de antecedência</option>
<option value='pago – das 14h às 20h, a partir da quarta-feira anterior ao evento'>pago – das 14h às 20h, a partir da quarta-feira anterior ao evento</option>
<option value='sem necessidade de retirada de ingressos' selected>sem necessidade de retirada de ingressos</option>"; 
break;

default:
	echo " 
<option value='gratuito – 2 ingressos por pessoa – 2 horas de antecedência'>gratuito – 2 ingressos por pessoa – 2 horas de antecedência</option>
<option value='gratuito – 2 ingressos por pessoa – das 14h às 20h, a partir da quarta-feira anterior ao evento'>gratuito – 2 ingressos por pessoa – das 14h às 20h, a partir da quarta-feira anterior ao evento</option>
<option value='pago – 2 horas de antecedência'>pago – 2 horas de antecedência</option>
<option value='pago – das 14h às 20h, a partir da quarta-feira anterior ao evento'>pago – das 14h às 20h, a partir da quarta-feira anterior ao evento</option>
<option value='sem necessidade de retirada de ingressos'>sem necessidade de retirada de ingressos</option>"; 
break;

}
?>

</select>
<br /><br /><br />
<label for="pg02_local">Local *</label> <br />
<?php 
$selected3 = $campo['pg02_local'];
form_salas($selected3); ?>

<br /><br />
<label for="pg02_local_outros">Outros espaços</label> <br />
 <input name="pg02_local_outros" type="text" id="pg02_local_outros" size="50" value="<? echo $campo['pg02_local_outros']; ?>" /></p><br/>

<label for="pg02_lotacao">Ingressos disponíveis </label> 
<input type="button" class="button" value="?" onClick="dalert.alert('Por INGRESSOS DISPONÍVEIS neste sistema, entendemos a quantidade de ingressos que será destinada livremente à venda ou distribuição direta aos públicos do CCSP, em oposição aos ingressos reservados pela produção do artista ou do CCSP.');"/><br />
<input name="pg02_lotacao" type="text" id="pg02_lotacao" size="50"value="<? echo $campo['pg02_lotacao']; ?>" />
<br /><br />

<label for="pg02_reservados">Ingressos reservados</label> 
<input type="button" class="button" value="?" onClick="dalert.alert('Por INGRESSOS RESERVADOS, neste sistema, entendemos a quantidade de ingressos que estará reservada – seja pela produção do evento, pela produção do CCSP ou por qualquer outro agente, em oposição aos ingressos que serão destinados livremente à venda ou distribuição direta aos públicos do CCSP.');"/><br />
  <input name="pg02_reservados" type="text" id="pg02_reservados" size="50" value="<? echo $campo['pg02_reservados']; ?>"/><br />
  
<br /><br />

					

	<div id="gravar">
<input type="hidden" name="pag" value="<? echo $pag; ?>"  />		
					<h3> <input type="submit" value="Gravar" id="gobutton" /> ATENÇÃO! Todas as informações inseridas sobre o evento só terão efetividade se forem gravadas a cada etapa.</h3>
                    

                    
                     
					  <br />


					</form>
					
</div>		
			<!-- Fim: Conteúdo das abas -->
		
		</div>
		
		<!-- Fim: Caixa -->
		
 <script type="text/javascript">
			
			$(function(){
				// quick routine for scrolling nav
				var $nav = $('.header ul'),
					navoffset = $nav.offset(),
					$navclone = $nav.clone().addClass('scrollnav').appendTo('.header'),
					$window = $(window);
				$window.scroll(function(e){
					if((navoffset.top+50) < $window.scrollTop()){
						if(!$navclone.hasClass('scrolled'))
							$navclone.addClass('scrolled');
					}
					else $navclone.removeClass('scrolled');
				}).scroll();

				// run the examples
				$('.example-container').each(function(i,el){
					var $ex = $(this),
						$run = $ex.find('.run'),
						code = $ex.find('.code').text();
					$run.click(function(e){
						e.preventDefault();
						(new Function(code))();
					});
				});

				// hotlink the tour
				$('#TourLink').click(function(e){
					e.preventDefault();
					$('#TourExample button').click();
				});
			});
			
		</script>

     
        <? include "rodape.php"; ?>  

		


</div>
  

    </body>
    
</html>
<? break ;
case 3:
 ?>
[<a href="evento.php?p=1">Apresentação Básica</a>] [<a href="evento.php?p=2">Detalhamento</a>] [Conteúdo] [<a href="evento.php?p=4">Serviços Internos</a>] [<a href="evento.php?p=5">Especificidades de Área</a>]
               <h2> Conteúdo </h2>
                <p>* campos obrigatórios.</p>

<label for="pg03_sinopse">Sinopse *</label> <br/>
<textarea name="pg03_sinopse" id="pg03_sinopse" cols="60" rows="10"><? echo html_entity_decode($campo['pg03_sinopse']); ?></textarea>
<br />
				
<br/>
<label for="pg03_release">Release *</label> <br/>
<textarea name="pg03_release" id="pg03_release" cols="60" rows="10"><? echo html_entity_decode($campo['pg03_release']); ?></textarea><br />

<br />
<label for="pg03_parecer">Parecer artístico *</label> <br/>
<textarea name="pg03_parecer" id="pg03_parecer" cols="60" rows="10"><? echo html_entity_decode($campo['pg03_parecer']); ?></textarea></p> <br /><br />



<label for="pensamento">Indique links de internet (youtube, flickr, etc)</label> <br/>
<textarea name="pensamento" id="pensamento" cols="60" rows="5"><? echo $campo_dic['dic_resposta'] ?></textarea>
<br /><br />
	<div id="gravar">
<input type="hidden" name="pag" value="<? echo $pag; ?>"  />		
					<h3> <input type="submit" name="form1" value="Gravar" id="gobutton" /> ATENÇÃO! Todas as informações inseridas sobre o evento só terão efetividade se forem gravadas a cada etapa.</h3>
                    

                    
                     
					  <br />


					</form>
					
</div>		
			<!-- Fim: Conteúdo das abas -->
		
		</div>
		
		<!-- Fim: Caixa -->
		
 <script type="text/javascript">
			
			$(function(){
				// quick routine for scrolling nav
				var $nav = $('.header ul'),
					navoffset = $nav.offset(),
					$navclone = $nav.clone().addClass('scrollnav').appendTo('.header'),
					$window = $(window);
				$window.scroll(function(e){
					if((navoffset.top+50) < $window.scrollTop()){
						if(!$navclone.hasClass('scrolled'))
							$navclone.addClass('scrolled');
					}
					else $navclone.removeClass('scrolled');
				}).scroll();

				// run the examples
				$('.example-container').each(function(i,el){
					var $ex = $(this),
						$run = $ex.find('.run'),
						code = $ex.find('.code').text();
					$run.click(function(e){
						e.preventDefault();
						(new Function(code))();
					});
				});

				// hotlink the tour
				$('#TourLink').click(function(e){
					e.preventDefault();
					$('#TourExample button').click();
				});
			});
			
		</script>

     
        <? include "rodape.php"; ?>  

		


</div>
  

    </body>
    
</html>
<? break;
case 4:
?>					

[<a href="evento.php?p=1">Apresentação Básica</a>] [<a href="evento.php?p=2">Detalhamento</a>] [<a href="evento.php?p=3">Conteúdo</a>] [Serviços Internos] [<a href="evento.php?p=5">Especificidades de Área</a>]
<h2> Serviços Internos </h2><br  />
<h3>Infraestrutura para Espetáculos</h3>
<br />

<br />
<label for="pg04_resp_externo">Nome do produtor do evento</label> <br/>
<input name="pg04_resp_externo" type="text" id="tecnico" size="60" value="<? echo $campo['pg04_resp_externo']; ?>" />
<br />  
<br />
<label for="pg04_tel">Telefone</label> <br/>
<input type="text" name="pg04_tel" id="pg04_tel" value="<? echo $campo['pg04_tel']; ?>"/>
  
<br />
<label for="pg04_email">Email</label> <br/>
<input type="text" name="pg04_email" id="pg04_email" value="<? echo $campo['pg04_email']; ?>"/>
  
<br />
<label for="pg04_carros">Carros / Placas</label> <br/>
 <textarea name="pg04_carros" id="pg04_carros" cols="60" rows="10"><? echo $campo['pg04_carros']; ?></textarea>
<br />

<br />
<label for="pg04_equipe">Equipe (Nome completo, RG)</label> <br/>
<textarea name="pg04_equipe" id="pg04_equipe" cols="60" rows="10"><? echo $campo['pg04_equipe']; ?></textarea>
<br />
<br />
<h3>Registro e Documentação</h3>
<br />
<br />
<label for="registro">Sugestão de registro</label> <br/>
<select name="registro" id="registro">
<option value="Nenhum"></option>  
<option value="video" <? checked('video',$campo_dic['dic_registro']); ?> >Video</option>
<option value="audio" <? checked('audio',$campo_dic['dic_registro']); ?> >Audio</option>
<option value="video + audio" <? checked('video + audio',$campo_dic['dic_registro']); ?>>Video + Audio</option>
</select>
	<br />
    <br />
<label for="fotografia">Sugestão de documentação fotográfica ?</label> <br/>
  <select name="fotografia" id="fotografia">
    <option value="nao" <? checked('nao',$campo_dic['dic_fotografia']); ?> >Não</option>
    <option value="sim" <? checked('sim',$campo_dic['dic_fotografia']); ?> >Sim</option>
  </select>
<br />
	<div id="gravar">
<input type="hidden" name="pag" value="<? echo $pag; ?>"  />		
					<h3> <input type="submit" name="form1" value="Gravar" id="gobutton" /> ATENÇÃO! Todas as informações inseridas sobre o evento só terão efetividade se forem gravadas a cada etapa.</h3>
                    

                    
                     
					  <br />


					</form>
					
</div>		
			<!-- Fim: Conteúdo das abas -->
		
		</div>
		
		<!-- Fim: Caixa -->
		
 <script type="text/javascript">
			
			$(function(){
				// quick routine for scrolling nav
				var $nav = $('.header ul'),
					navoffset = $nav.offset(),
					$navclone = $nav.clone().addClass('scrollnav').appendTo('.header'),
					$window = $(window);
				$window.scroll(function(e){
					if((navoffset.top+50) < $window.scrollTop()){
						if(!$navclone.hasClass('scrolled'))
							$navclone.addClass('scrolled');
					}
					else $navclone.removeClass('scrolled');
				}).scroll();

				// run the examples
				$('.example-container').each(function(i,el){
					var $ex = $(this),
						$run = $ex.find('.run'),
						code = $ex.find('.code').text();
					$run.click(function(e){
						e.preventDefault();
						(new Function(code))();
					});
				});

				// hotlink the tour
				$('#TourLink').click(function(e){
					e.preventDefault();
					$('#TourExample button').click();
				});
			});
			
		</script>

     
        <? include "rodape.php"; ?>  

		


</div>
  

    </body>
    
</html>
<? break;
case 5: ?>
[<a href="evento.php?p=1">Apresentação Básica</a>] [<a href="evento.php?p=2">Detalhamento</a>] [<a href="evento.php?p=3">Conteúdo</a>] [<a href="evento.php?p=4">Serviços Internos</a>] [Especificidades de Área]

					<h2>Especifidades de área</h2> <br />
<div class='resumo01'>                    
                    <h3><strong>Artes Visuais</strong></h3>
                   
                    <p><label for="art_numero">Número de contratados</label> 
  						<input name="art_numero" type="text" id="art_numero" size="10" value="<? echo $campo['art_numero']; ?>"/></p>
 					
                    <p><label for="art_tipo">Tipo de contração</label>
 						<select name="art_tipo" id="art_tipo">
    						<option></option>
    						<option value="edital" <? checked('edital',$campo['art_tipo']); ?> >Edital</option>
    						<option value="selecionado" <? checked('selecionado',$campo['art_tipo']); ?> >Selecionado</option>
    						<option value="jurado" <? checked('jurado',$campo['art_tipo']); ?> >Jurado</option>
  						</select>
                       </p>
                <p>    <label for="cache_total">Total cachê</label>
 					<input name="art_valor" type="text" id="cache_total" size="30" value="<? echo $campo['art_valor']; ?>" /> </p> 
<br />
</div>					
<div class='resumo02'>
					<h3><strong>Teatro / Dança</strong></h3>
                   <p> <label for="estreia">Estréia? </label>
    				<select name="teadan_estreia" id="estreia">
      				<option value="nao" <? checked('nao',$campo['teadan_estreia']); ?> >Não</option>
      				<option value="sim" <? checked('sim',$campo['teadan_estreia']); ?> >Sim</option>
			        </select>
</p>
<p>
                   <label for="genero">Gênero </label>
    			  <input name="teadan_genero" type="text" id="genero" size="60" value="<? echo $campo['teadan_genero']; ?>"/>
</p>
</div>
<div class='resumo01'>
				  <h3><strong><p>Oficinas e Palestras</strong></h3>
					<p>
                  <label for="certificado">Certificado</label>
    				<select name="ofi_certificado" id="certificado">
                    <option></option>    						
     				<option value="nao" <? checked('nao',$campo['ofi_certificado']); ?> >Não</option>
      				<option value="sim" <? checked('sim',$campo['ofi_certificado']); ?> >Sim</option>
    				</select>
</p><p>                 <label for="vagas">Vagas</label>
 <input type="text" name="ofi_vagas" id="vagas" value='<? echo $campo['ofi_vagas']; ?>'/><br />
                  <label for="publicoalvo">Públic-alvo</label>
  				  <textarea name="ofi_publico" id="publicoalvo" cols="45" rows="5"><? echo $campo['ofi_publico']; ?></textarea>
       </p><p>
                    <label for="material">Material Requisitado</label>
  					<input type="text" name="ofi_material" id="material" value="<? echo $campo['ofi_material']; ?>" />

</p><p>                    <label for="inscricao">Forma da inscrição</label>
  					<select name="ofi_inscricao" id="inscricao">
                    <option></option>
    				<option value="sem_necessidade" <? checked('sem_necessidade',$campo['ofi_inscricao']); ?> >Sem necessidade</option>
    				<option value="site_ficha" <? checked('site_ficha',$campo['ofi_inscricao']); ?>>pelo site - ficha de inscrição</option>
    				<option value="site_email" <? checked('site_email',$campo['ofi_inscricao']); ?>>pelo site - por email</option>
    				<option value="pessoalmente" <? checked('pessoalmente',$campo['ofi_inscricao']); ?>>pessoalmente</option>
    				</select>
                    
</p>                   
  					<p>Período de inscrição</p>
                    <p><label for="datepicker03">Início: </label>
  					<input type="Text" id="datepicker03" maxlength="25" size="25" name="ofi_periodo_abertura" value="<? echo $campo['ofi_periodo_abertura']; ?>"  /><br />

<label for="datepicker04">Encerramento: </label>
      <input type="Text" id="datepicker04" maxlength="25" size="25" name="ofi_periodo_encerramento" value="<? echo $campo['ofi_periodo_encerramento']; ?>"> <br />

<label for="datepicker05">Divulgação dos selecionados: </label>
  <input type="Text" id="datepicker05" maxlength="25" size="25" name="ofi_divulgacao" value="<? echo $campo['ofi_divulgacao']; ?>">
 </p>
 <p>
 <label for="pagamento">Forma de pagamento oficineiro </label>
  <textarea name="ofi_pagamento" id="pagamento" cols="45" rows="5"><? echo $campo['ofi_pagamento']; ?></textarea></p>
</p><p><label for="ofi_valor_hora">Valor da hora/aula do oficineiro </label>
  <input type="text" name="ofi_valor_hora" id="ofi_valor_hora" value="<? echo $campo['ofi_valor_hora']; ?>"/></p>
<p>
<label for="ofi_venda">Venda de Material?</label>
  <select name="ofi_venda" id="ofi_venda">
    <option value="sim" <? checked('sim',$campo['ofi_venda']); ?> >Sim</option>
    <option value="nao" <? checked('nao',$campo['ofi_venda']); ?>>Não</option>
  </select></p>
  
<p>  
<label for="ofi_venda_material">Discrimine o material (CD, DVD, impresso, camiseta, etc)</label>
  <textarea name="ofi_venda_material" id="ofi_venda_material" cols="45" rows="5" ><? echo $campo['ofi_venda_material']; ?></textarea></p>
  </div>
  <div class='resumo02'>
	<h3>Música</h3>
<p><label for="mus_genero">Gênero (ex: erudito, popular)</label>
<input type="text" id="mus_genero" maxlength="25" size="25" name="mus_genero" value="<? echo $campo['mus_genero']; ?>">
 </p><p>
<label for="venda">Venda de Material?</label>
  <select name="mus_venda" id="venda">
    <option value="sim" <? checked('sim',$campo['mus_venda']); ?> >Sim</option>
    <option value="nao" <? checked('nao',$campo['mus_venda']); ?>>Não</option>
  </select></p>
  
  <p>
<label for="venda_material">Discrimine o material (CD, DVD, impresso, camiseta, etc)</label>
  <textarea name="mus_material" id="venda_material" cols="45" rows="5" ><? echo $campo['mus_material']; ?></textarea>
<p></div>
<div class='resumo01'>
<h3>Sub-evento</h3>

<p><label for="sub_evento">Sinopse / Tipo de evento / Local / Horário</label>
<textarea name="sub_evento" id="sub_evento" cols="45" rows="10"><? echo $campo['sub_evento']; ?></textarea>
</p>
</div>
	<div id="gravar">
	<input type="hidden" name="pag" value="<? echo $pag; ?>"  />	
					<h3> <input type="submit" name="form1" value="Gravar" id="gobutton" /> ATENÇÃO! Todas as informações inseridas sobre o evento só terão efetividade se forem gravadas a cada etapa.</h3>
                    

                    
                     
					  <br />


					</form>
					
</div>		
			<!-- Fim: Conteúdo das abas -->
		
		</div>
		
		<!-- Fim: Caixa -->
		
 <script type="text/javascript">
			
			$(function(){
				// quick routine for scrolling nav
				var $nav = $('.header ul'),
					navoffset = $nav.offset(),
					$navclone = $nav.clone().addClass('scrollnav').appendTo('.header'),
					$window = $(window);
				$window.scroll(function(e){
					if((navoffset.top+50) < $window.scrollTop()){
						if(!$navclone.hasClass('scrolled'))
							$navclone.addClass('scrolled');
					}
					else $navclone.removeClass('scrolled');
				}).scroll();

				// run the examples
				$('.example-container').each(function(i,el){
					var $ex = $(this),
						$run = $ex.find('.run'),
						code = $ex.find('.code').text();
					$run.click(function(e){
						e.preventDefault();
						(new Function(code))();
					});
				});

				// hotlink the tour
				$('#TourLink').click(function(e){
					e.preventDefault();
					$('#TourExample button').click();
				});
			});
			
		</script>

     
        <? include "rodape.php"; ?>  

		


</div>
  
<script>
  $(document).ready(function(){
    $('#sidebar').stickyMojo({footerID: '#footer', contentID: '#main'});
  });
</script>
    </body>
    
</html>
<? break;
}?>