// Script Avançar Modal
	$('.btnNext').click(function(){
		$('.nav-tabs > .active').next('li').find('a').trigger('click');
	});

	$('.btnPrevious').click(function(){
		$('.nav-tabs > .active').prev('li').find('a').trigger('click');
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