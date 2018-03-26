<head>
    <!-- Include SmartWizard CSS -->
    <link href="../visual/dist/css/smart_wizard.css" rel="stylesheet" type="text/css" />
    <!-- Optional SmartWizard theme -->
    <!-- <link href="../visual/dist/css/smart_wizard_theme_circles.css" rel="stylesheet" type="text/css" /> -->
    <!-- <link href="../visual/dist/css/smart_wizard_theme_arrows.css" rel="stylesheet" type="text/css" /> -->
    <link href="../visual/dist/css/smart_wizard_theme_dots.css" rel="stylesheet" type="text/css" />
</head>
<div class="container">      
    <form class="form-inline">
         <div class="form-group hidden">
          <label >Selecione o tema:</label>
          <select id="theme_selector" class="form-control">
                <option value="dots">dots</option>
                <!-- <option value="default">default</option> -->
                <!-- <option value="circles">circles</option> -->
                <!-- <option value="arrows">arrows</option> -->
          </select>
        </div>           
    </form>
    <?php 

        #Pega a url da pagina
        $uri = $_SERVER['REQUEST_URI']; 
        // echo $uri;
        # Barra Pessoa Fisica
        include_once 'barras_smart_wizard/barra_pf.php';
        # Barra Pessoa Juridica
        include_once 'barras_smart_wizard/barra_pj.php';
        //-------------------------------------------------------------------
        # Barra Incentivador Pessoa Fisica
        include_once 'barras_smart_wizard/barra_incentivador_pf.php';
         # Barra Incentivador Pessoa Fisica
        include_once 'barras_smart_wizard/barra_incentivador_pj.php';

    ?>
</div>
<!-- Include SmartWizard JavaScript source -->
<script type="text/javascript" src="../visual/dist/js/jquery.smartWizard.js"></script>
<!-- Javascript - funções botões -->
<script type="text/javascript" src="../visual/dist/js/js-smartWizard.js"></script>  

