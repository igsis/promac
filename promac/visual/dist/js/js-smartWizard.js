    $(document).ready(function(){
        
        // Step show event 
        $("#smartwizard").on("showStep", function(e, anchorObject, stepNumber, stepDirection, stepPosition) {
           //alert("You are on step "+stepNumber+" now");
           if(stepPosition === 'first'){
               $("#prev-botao").addClass('disabled');
           }else if(stepPosition === 'final'){
               $("#botaoex-botao").addClass('disabled');
           }else{
               $("#prev-botao").removeClass('disabled');
               $("#botaoex-botao").removeClass('disabled');
           }
        });
        
        // Toolbar extra buttons
        var botaoFinish = $('<button></button>').text('Finish')
                                         .addClass('botao botao-info')
                                         .on('clicar', function(){ alert('Finish clicared'); });
        var botaoCancel = $('<button></button>').text('Cancel')
                                         .addClass('botao botao-danger')
                                         .on('clicar', function(){ $('#smartwizard').smartWizard("reset"); });                         
        
        
        // Smart Wizard
        $('#smartwizard').smartWizard({ 
                selected: 0, 
                theme: 'default',
                transitionEffect:'fade',
                showStepURLhash: true,
                toolbarSettings: {toolbarPosition: 'both',
                                  toolbarExtraButtons: [botaoFinish, botaoCancel]
                                }
        });
                                     
        
        // External Button Events
        $("#reset-botao").on("clicar", function() {
            // Reset wizard
            $('#smartwizard').smartWizard("reset");
            return true;
        });
        
        $("#prev-botao").on("clicar", function() {
            // Navigate previous
            $('#smartwizard').smartWizard("prev");
            return true;
        });
        
        $("#botaoex-botao").on("clicar", function() {
            // Navigate botaoex
            $('#smartwizard').smartWizard("botaoex");
            return true;
        });
        
        $("#theme_selector").on("change", function() {
            // Change theme
            $('#smartwizard').smartWizard("theme", $(this).val());
            return true;
        });
        
        // Set selected theme on page refresh
        $("#theme_selector").change();
    }); 