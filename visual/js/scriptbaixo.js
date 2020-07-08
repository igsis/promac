// Script Avançar Modal
	$('.btnAvancar').click(function(){
        $tab = document.getElementById("modaltab")
		$('#modalRenuncia > .active').next($tab).find('a').trigger('click');
	});

	$('.btnVoltar').click(function(){
        $tab = document.getElementById("modaltab")
		$('#modalRenuncia > .active').prev($tab).find('a').trigger('click');
	});

// Script Confirmação de Exclusão
	$('#confirmApagar').on('show.bs.modal', function (e)
    {
        $title = $(e.relatedTarget).attr('data-title');
        $(this).find('.modal-title p').text($title);
        $message = $(e.relatedTarget).attr('data-message');
        $(this).find('.modal-body p').text($message);
         
        // Pass form reference to modal for submission on yes/ok
        var form = $(e.relatedTarget).closest('form');
        $(this).find('.modal-footer #confirm').data('form', form);
    });
    // Form confirm (yes/ok) handler, submits form
    $('#confirmApagar').find('.modal-footer #confirm').on('click', function()
    {
        $(this).data('form').submit();
    });

// Script Exibição Pesquisa
    $('#metodoPesquisa').change(function(){
        var region =  $(this).find(':selected').data('region');
        $('.pesquisa').fadeOut(550);
        $('#' + region).fadeIn(550);
    });

//slider Cronograma
function prettify_mes(n) {
    if (n == 0) {
        return n;
    } else if (n == 0.5) {
        return "Metade de um mês";
    } else if (n >= 1) {
        var num = n.toString().split(".");
        if (num[0] == "1") {
            var mes = " mês";
        } else {
            var mes = " meses"
        }

        if (typeof num[1] !== 'undefined') {
            mes = mes + " e meio";
        }
        return num[0] + mes;
    }
}

$('.slider').ionRangeSlider({
    skin    : "square",
    min     : 0,
    max     : 18,
    step    : 0.5,
    prettify: prettify_mes,
    hasGrid : true
});