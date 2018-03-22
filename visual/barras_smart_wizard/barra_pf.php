<?php 
# Barra pf 
$con  = bancoMysqli();
$idPf = $_SESSION['idUser'];
$pf   = recuperaDados("pessoa_fisica","idPf",$idPf);
$idProj   = isset($_SESSION['idProjeto'])?$_SESSION['idProjeto']:null;
$proj = recuperaDados("projeto","idProjeto",$idProj); // Para verificar status


$urlPf = array(
    27 => '/promac/visual/index_pf.php?secao=perfil',
    0 => '/promac/visual/index_pf.php',
    1 => '/promac/visual/index_pf.php?perfil=informacoes_iniciais_pf',
    2 => '/promac/visual/index_pf.php?perfil=arquivos_pf',
    3 => '/promac/visual/index_pf.php?perfil=projeto_pf', // Projeto
    4 => '/promac/visual/index_pf.php?perfil=projeto_novo',
    5 => '/promac/visual/index_pf.php?perfil=projeto_edicao',
    6 => '/promac/visual/index_pf.php?perfil=cooperativa_resultado_busca', // Projeto
    7 => '/promac/visual/index_pf.php?perfil=projeto_2',
    8 => '/promac/visual/index_pf.php?perfil=projeto_3',
    9 => '/promac/visual/index_pf.php?perfil=projeto_4', 
    10 => '/promac/visual/index_pf.php?perfil=projeto_5', 
    11 => '/promac/visual/index_pf.php?perfil=projeto_6', 
    12 => '/promac/visual/index_pf.php?perfil=local',
    13 => '/promac/visual/index_pf.php?perfil=local_novo',
    14 => '/promac/visual/index_pf.php?perfil=local_edicao',
    15 => '/promac/visual/index_pf.php?perfil=ficha_tecnica',
    16 => '/promac/visual/index_pf.php?perfil=ficha_tecnica_novo',
    17 => '/promac/visual/index_pf.php?perfil=cronograma',
    18 => '/promac/visual/index_pf.php?perfil=cronograma_novo',
    19 => '/promac/visual/index_pf.php?perfil=cronograma_edicao',
    20 => '/promac/visual/index_pf.php?perfil=orcamento',
    21 => '/promac/visual/index_pf.php?perfil=orcamento_novo',
    22 => '/promac/visual/index_pf.php?perfil=orcamento_edicao',
    23 => '/promac/visual/index_pf.php?perfil=anexos',
    24 => '/promac/visual/index_pf.php?perfil=projeto_13',
    25 => '/promac/visual/index_pf.php?perfil=finalProjeto',
    26 => '/promac/visual/index_pf.php?perfil=informacoes_administrativas',
    28 => '/promac/visual/index_pf.php?perfil=projeto_8' // Passo 8
);
for ($i = 0; $i < count($urlPf); $i++) {
    if ($uri == $urlPf[$i]) {
        if ($i == 0 || $i == 1 || $i == 27) {
            $acionar1 = 'active loading';            
        }elseif ($i == 2) {
            $acionar2 = 'active loading';                        
        }elseif ($i == 3 ||$i == 4 || $i == 5 ||$i == 6) {
            $acionar3 = 'active loading';                        
        }elseif ($i == 7) { // passo 2
            $acionar6 = 'active loading';                        
        }elseif ($i == 8) { // passo 3
            $acionar7 = 'active loading';                        
        }elseif ($i == 9) { // passo 4
            $acionar8 = 'active loading';                        
        }elseif ($i == 10) { // passo 5
            $acionar9 = 'active loading';                        
        }elseif ($i == 11) { // passo 6
            $acionar10 = 'active loading';                        
        }elseif ($i == 12 || $i == 13 || $i == 14) { // Local
            $acionar11 = 'active loading';                        
        }elseif ($i == 15 || $i == 16) { // Ficha Técnica
            $acionar12 = 'active loading';                        
        }elseif ($i == 17 || $i == 18 || $i == 19){
            $acionar13 = 'active loading';   
        }elseif ($i == 20 || $i == 21 || $i == 22){
            $acionar14 = 'active loading';
        }elseif ($i == 23){
            $acionar15 = 'active loading';
        }elseif ($i == 24){
            $acionar16 = 'active loading';
        }elseif ($i == 25){
            $acionar17 = 'active loading';
        }elseif ($i == 26){
            $acionar18 = 'active loading';
        }elseif ($i == 28){ // passo 8
            $acionar19 = 'active loading';
        }

?>
        <!-- SmartWizard html -->
        <div id="smartwizard">
            <ul>
                <li class="hidden">
                    <a href=""><br /></a>
                </li>
                <li class="<?php echo isset($acionar1) ? $acionar1 : 'clickable'; ?>">
                    <a onclick="location.href='index_pf.php?perfil=informacoes_iniciais_pf'" href=""><br />Proponente</a>
                </li> 
                <li class="<?php echo isset($acionar2) ? $acionar2 : 'clickable'; ?>">
                   <a onclick="location.href='index_pf.php?perfil=arquivos_pf'" href=""><br />Documentos do Proponente</a>
                </li>
                <?php 
                    if ($pf['liberado'] != 3) {
                ?>
                <li class="<?php echo isset($acionar3) ? $acionar3 : 'clickable'; ?>">
                   <a onclick="location.href='index_pf.php?perfil=projeto_pf'" href=""><br />Projeto</a>
                </li>
                <?php
                        break;
                    } 
                ?>

                <li class="<?php echo isset($acionar3) ? $acionar3 : 'clickable'; ?>">
                   <a onclick="location.href='index_pf.php?perfil=projeto_pf'" href=""><br />Projeto</a>
                </li>
                <?php 
                    if ($idProj == true) {  
                ?>
                <li class="<?php echo isset($acionar6) ? $acionar6 : 'clickable'; ?>">
                   <a onclick="location.href='index_pf.php?perfil=projeto_2'" href=""><br />Passo 2</a>
                </li>
                <?php 
                    }else {   
                                         
                        break;
                    }
                ?>  
                <li class="<?php echo isset($acionar7) ? $acionar7 : 'clickable'; ?>">
                   <a onclick="location.href='index_pf.php?perfil=projeto_3'" href=""><br />Passo 3</a>
                </li> 
                <li class="<?php echo isset($acionar8) ? $acionar8 : 'clickable'; ?>">
                   <a onclick="location.href='index_pf.php?perfil=projeto_4'" href=""><br />Passo 4</a>
                </li> 
                <li class="<?php echo isset($acionar9) ? $acionar9 : 'clickable'; ?>">
                   <a onclick="location.href='index_pf.php?perfil=projeto_5'" href=""><br />Passo 5</a>
                </li>
                <li class="<?php echo isset($acionar10) ? $acionar10 : 'clickable'; ?>">
                   <a onclick="location.href='index_pf.php?perfil=projeto_6'" href=""><br />Passo 6</a>
                </li>
                <li class="<?php echo isset($acionar11) ? $acionar11 : 'clickable'; ?>">
                   <a onclick="location.href='index_pf.php?perfil=local'" href=""><br />Local</a>
                </li>
                <li class="<?php echo isset($acionar19) ? $acionar19 : 'clickable'; ?>">
                   <a onclick="location.href='index_pf.php?perfil=projeto_8'" href=""><br />Passo 8</a>
                </li>
            </ul> <!-- Barra linha 2 -->
            <ul>                
                <li class="<?php echo isset($acionar12) ? $acionar12 : 'clickable'; ?>">
                   <a onclick="location.href='index_pf.php?perfil=ficha_tecnica'" href=""><br />Ficha Técnica</a>
                </li>   
                <li class="<?php echo isset($acionar13) ? $acionar13 : 'clickable'; ?>">
                   <a onclick="location.href='index_pf.php?perfil=cronograma'" href=""><br />Cronograma</a>
                </li>
                <li class="<?php echo isset($acionar14) ? $acionar14 : 'clickable'; ?>">
                   <a onclick="location.href='index_pf.php?perfil=orcamento'" href=""><br />Orçamento</a>
                </li>
                <li class="<?php echo isset($acionar15) ? $acionar15 : 'clickable'; ?>">
                   <a onclick="location.href='index_pf.php?perfil=anexos'" href=""><br />Anexos</a>
                </li>
                <li class="<?php echo isset($acionar16) ? $acionar16 : 'clickable'; ?>">
                   <a onclick="location.href='index_pf.php?perfil=projeto_13'" href=""><br />Link do YouTube</a>
                </li>
                <li class="<?php echo isset($acionar17) ? $acionar17 : 'clickable'; ?>">
                   <a onclick="location.href='index_pf.php?perfil=finalProjeto'" href=""><br />Final Projeto</a>
                </li>
                <?php 
                    if ($proj['idStatus'] != 1) {                        
                ?>
                <li class="<?php echo isset($acionar18) ? $acionar18 : 'clickable'; ?>">
                   <a onclick="location.href='index_pf.php?perfil=informacoes_administrativas'" href=""><br />Informações da Inscrição</a>
                </li>
                <?php 
                    }else{
                ?> 
                <li class="<?php echo isset($acionar18) ? $acionar18 : 'disabled'; ?>">
                   <a><br />Informações da Inscrição</a>
                </li>
                <?php        
                    }
                ?>                                  
            </ul>
       	</div>
<?php 
    }
}
?>