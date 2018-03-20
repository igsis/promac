var termo = document.querySelector('#termo');
var inptEnvia = document.querySelector('#inptEnviar');

$(function(){
	termosDoProjeto();
});

function termosDoProjeto()
{
  btnAceitar.addEventListener('click', function(){    
    
    termo.checked = true;  
    inptEnviar.type = 'submit';    
  });	 

  btnRejeitar.addEventListener('click', function(){    
    
    termo.checked = false;  
    inptEnviar.type = 'hidden';    
  });	 
}
