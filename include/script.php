<script type="text/javascript" src="js/autocomplete.js"></script>
<script src="js/modernizr.custom.js"></script>
<script src="js/jquery-1.9.1.js"></script>
<script src="js/jquery-ui.js"></script>
<script src="js/jquery.maskedinput.js" type="text/javascript"></script>
<script src="js/jquery.maskMoney.js" type="text/javascript"></script>
  <script>
  $(function(){
	$( "#hora" ).mask("99:99");
  });
 
    $(function() {
    $('#valor').maskMoney({thousands:'', decimal:',', allowZero:true, suffix: ''});
  });
      $(function() {
    $('.valor').maskMoney({thousands:'', decimal:',', allowZero:true, suffix: ''});
  });
    $(function() {
    $('#valor01').maskMoney({thousands:'', decimal:',', allowZero:true, suffix: ''});
  });
      $(function() {
    $('#valor_individual').maskMoney({thousands:'', decimal:',', allowZero:true, suffix: ''});
  });
  $(function() {
    $('#duracao').maskMoney({thousands:'', decimal:'', allowZero:true, suffix: ''});
  })
  $(function(){
	$("#CEP").mask("99999-999");
  });
  
  $(function(){
	$( ".processo" ).mask("9999.9999/9999999-9");
  });  
    
</script>

<script type="text/javascript">
  /* Máscaras ER */
function mascara(o,f){
    v_obj=o
    v_fun=f
    setTimeout("execmascara()",1)
}
function execmascara(){
    v_obj.value=v_fun(v_obj.value)
}
function mtel(v){
    v=v.replace(/\D/g,"");             //Remove tudo o que não é dígito
    v=v.replace(/^(\d{2})(\d)/g,"($1) $2"); //Coloca parênteses em volta dos dois primeiros dígitos
    v=v.replace(/(\d)(\d{4})$/,"$1-$2");    //Coloca hífen entre o quarto e o quinto dígitos
    return v;
}

 function mask(t, mask){
 var i = t.value.length;
 var saida = mask.substring(1,0);
 var texto = mask.substring(i)
 if (texto.substring(0,1) != saida){
 t.value += texto.substring(0,1);
 }
 }

 </script>

<script type="text/javascript">
	$(document).ready(function(){	$("#cnpj").mask("99.999.999/9999-99");});
</script>
<script type="text/javascript">
	$(document).ready(function(){	$("#cpf").mask("999.999.999-99");});</script>

<script type="text/javascript">
	$(document).ready( function()
	{
		/* Executa a requisição quando o campo CEP perder o foco */
		$('#CEP').blur(function()
		{
			/* Configura a requisição AJAX */
			$.ajax
			(
				{
					url : 'ajax_cep.php', /* URL que será chamada */ 
					type : 'POST', /* Tipo da requisição */ 
					data: 'CEP=' + $('#CEP').val(), /* dado que será enviado via POST */
					dataType: 'json', /* Tipo de transmissão */
					success: function(data)
					{
						if(data.sucesso == 1)
						{
							$('#Endereco').val(data.rua);
							$('#Bairro').val(data.bairro);
							$('#Cidade').val(data.cidade);
							$('#Estado').val(data.estado);
							$('#Sucesso').val(data.sucesso);
							$('#Numero').focus();
						}
						else
						{
							$('#Sucesso').val(0);
						}
					}
				}
			);   
			return false;    
		})
	});
	</script>

 <script type="text/javascript"> 	
 	$(document).ready(function(){
    $('#diaespecial').change(function(){
        var checked = $(this).attr('checked');
        if (checked) { 
           $('.other').show();             
        } else {
            $('.other').hide();
        }
    });        
})
 </script>
 
	<script>
	//funções para calendário	
	  $(function() {
    $( "#datepicker01" ).datepicker({ 
      changeMonth: true,
      changeYear: true
    });
  });
  $(function() {
    $( "#datepicker02" ).datepicker({ 
      changeMonth: true,
      changeYear: true
    });
  });
  $(function() {
    $( "#datepicker03" ).datepicker({ 
      changeMonth: true,
      changeYear: true
    });
  });
  $(function() {
    $( "#datepicker04" ).datepicker({ 
      changeMonth: true,
      changeYear: true
    });
  });
  $(function() {
    $( "#datepicker05" ).datepicker({ 
      changeMonth: true,
      changeYear: true
    });
  });
  $(function() {
    $( "#datepicker10" ).datepicker({ 
      changeMonth: true,
      changeYear: true,
	  minDate: 0,
      addSliderAccess: true,
      sliderAccessArgs: {
        touchonly: false
      }
    });
  });
  $(function() {
    $( "#datepicker11" ).datepicker({ 
      changeMonth: true,
      changeYear: true,
      minDate: 0,
      addSliderAccess: true,
      sliderAccessArgs: {
        touchonly: false
      }
    });
  });
  $(function() {
    $( "#datepicker12" ).datepicker({ 
      changeMonth: true,
      changeYear: true,
      minDate: 0,
      addSliderAccess: true,
      sliderAccessArgs: {
        touchonly: false
      }
    });
  });
  $(function() {
    $( "#datepicker13" ).datepicker({ 
      changeMonth: true,
      changeYear: true,
      minDate: 0,
      addSliderAccess: true,
      sliderAccessArgs: {
        touchonly: false
      }
    });
  });
  $(function() {
    $( "#datepicker14" ).datepicker({ 
      changeMonth: true,
      changeYear: true,
      minDate: 0,
      addSliderAccess: true,
      sliderAccessArgs: {
        touchonly: false
      }
    });
  });
  $(function() {
    $( "#datepicker15" ).datepicker({ 
      changeMonth: true,
      changeYear: true,
      minDate: 0,
      addSliderAccess: true,
      sliderAccessArgs: {
        touchonly: false
      }
    });
  });
  $(function() {
    $( "#datepicker16" ).datepicker({ 
      changeMonth: true,
      changeYear: true,
      minDate: 0,
      addSliderAccess: true,
      sliderAccessArgs: {
        touchonly: false
      }
    });
  });
  $(function() {
    $( "#datepicker17" ).datepicker({ 
      changeMonth: true,
      changeYear: true,
      minDate: 0,
      addSliderAccess: true,
      sliderAccessArgs: {
        touchonly: false
      }
    });
  });
  $(function() {
    $( "#datepicker18" ).datepicker({ 
      changeMonth: true,
      changeYear: true,
      minDate: 0,
      addSliderAccess: true,
      sliderAccessArgs: {
        touchonly: false
      }
    });
  });
  $(function() {
    $( "#datepicker19" ).datepicker({ 
      changeMonth: true,
      changeYear: true,
      minDate: 0,
      addSliderAccess: true,
      sliderAccessArgs: {
        touchonly: false
      }
    });
  });
	//funções para mostrar/esconder
	$('#toggle1').click(function() {
		$('.toggle1').slideToggle('slow');
		return false;
	});	
	$('#toggle2').click(function() {
		$('.toggle2').slideToggle('slow');
		return false;
	});	
	$('#toggle3').click(function() {
		$('.toggle3').slideToggle('slow');
		return false;
	});	
	$('#toggle4').click(function() {
		$('.toggle4').slideToggle('slow');
		return false;
	});	
	$('#toggle5').click(function() {
		$('.toggle5').slideToggle('slow');
		return false;
	});	
  </script>