var termo = document.querySelector('#termo');
var inptEnvia = document.querySelector('#inptEnviar');

$(function(){
	termosDoProjeto();
});

function termosDoProjeto()
{
  btnAceitar.addEventListener('click', function(){    
    
    termo.checked = true;  
    document.getElementById("inptEnviar").style.display = "block";
  });	 

  btnRejeitar.addEventListener('click', function(){    
    
    termo.checked = false;  
    document.getElementById("inptEnviar").style.display = "none";
  });	 
}
