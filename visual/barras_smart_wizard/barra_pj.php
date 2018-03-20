<?php 
$con = bancoMysqli();
$idPj = $_SESSION['idUser'];
$pj = recuperaDados("pessoa_juridica","idPj",$idPj);
# Barra nPessoa Juridica
$urlPj = array(
    0 => '/promac/visual/index_pj.php?secao=perfil',
    1 => '/promac/visual/index_pj.php',
    2 => '/promac/visual/index_pj.php?perfil=informacoes_iniciais_pj',
    3 => '/promac/visual/index_pj.php?perfil=representante_pj',
    4 => '/promac/visual/index_pj.php?perfil=representante_pj_resultado_busca',
    5 => '/promac/visual/index_pj.php?perfil=representante_pj_cadastro',
    6 => '/promac/visual/index_pj.php?perfil=arquivos_pj',
    7 => '/promac/visual/index_pj.php?perfil=projeto_pj',
    8 => '/promac/visual/index_pj.php?perfil=projeto_visualizacao',
    9 => '/promac/visual/index_pj.php?perfil=projeto_pf',
    10 => '/promac/visual/index_pj.php?perfil=projeto_novo',
    11 => '/promac/visual/index_pj.php?perfil=projeto_edicao',
    12 => '/promac/visual/index_pj.php?perfil=projeto_2',
    13 => '/promac/visual/index_pj.php?perfil=projeto_3',
    14 => '/promac/visual/index_pj.php?perfil=projeto_4',
    15 => '/promac/visual/index_pj.php?perfil=projeto_5',
    16 => '/promac/visual/index_pj.php?perfil=projeto_6',
    17 => '/promac/visual/index_pj.php?perfil=local', // local
    18 => '/promac/visual/index_pj.php?perfil=local_novo', // local
    19 => '/promac/visual/index_pj.php?perfil=local_edicao', // local
    20 => '/promac/visual/index_pj.php?perfil=projeto_8', // puplico alvo Passo 8
    21 => '/promac/visual/index_pj.php?perfil=ficha_tecnica', // Ficha Técnica
    22 => '/promac/visual/index_pj.php?perfil=ficha_tecnica_novo', // Ficha Técnica
    23 => '/promac/visual/index_pj.php?perfil=ficha_tecnica_edicao', // Ficha Técnica
    24 => '/promac/visual/index_pj.php?perfil=cronograma', //  Cronograma  
    25 => '/promac/visual/index_pj.php?perfil=cronograma_novo', //  Cronograma  
    26 => '/promac/visual/index_pj.php?perfil=cronograma_edicao', //  Cronograma  
    27 => '/promac/visual/index_pj.php?perfil=orcamento', //  Orçamento   
    28 => '/promac/visual/index_pj.php?perfil=orcamento_novo', //  Orçamento   
    29 => '/promac/visual/index_pj.php?perfil=orcamento_edicao', //  Orçamento   
    30 => '/promac/visual/index_pj.php?perfil=anexos', //  Anexos  
    31 => '/promac/visual/index_pj.php?perfil=projeto_13', //  Link do YouTube
    32 => '/promac/visual/index_pj.php?perfil=finalProjeto', // Final Projeto  
    33 => '/promac/visual/index_pj.php?perfil=informacoes_administrativas',
    34 => '/promac/visual/index_pj.php?perfil=cooperativa_resultado_busca' // Empresa  
);

for ($i = 0; $i < count($urlPj); $i++) {
    if ($uri == $urlPj[$i]) {
        if ($i == 0 || $i == 1 || $i == 2){ // informações iniciais
            $ativa1 = 'active loading';
        }elseif ($i == 3 || $i == 4 || $i == 5) {                
            $ativa2 = 'active loading';
        }elseif ($i == 6) {                
            $ativa3 = 'active loading';
        }elseif ($i == 7 || $i == 8 || $i == 9) {  // Projeto                
            $ativa4 = 'active loading';
        }elseif ($i == 10 || $i == 11) { // cadastro              
            $ativa5 = 'active loading';
        }elseif ($i == 34) {       // Empresa          
            $ativa6 = 'active loading';
        }elseif ($i == 12) {       // Passo 2             
            $ativa7 = 'active loading';
        }elseif ($i == 13) {       // Passo 3              
            $ativa8 = 'active loading';
        }elseif ($i == 14) {       // Passo 4              
            $ativa9 = 'active loading';
        }elseif ($i == 15) {       // Passo 5              
            $ativa10 = 'active loading';
        }elseif ($i == 16) {       // Passo 6
            $ativa11 = 'active loading';
        }elseif ($i == 17 || $i == 18 || $i == 19) { //  Local   
            $ativa12 = 'active loading';
        }elseif ($i == 21 || $i == 22 || $i == 23) { //  Ficha Técnica             
            $ativa13 = 'active loading';
        }elseif ($i == 24 || $i == 25 || $i == 26) { //  Cronograma             
            $ativa14 = 'active loading';
        }elseif ($i == 27 || $i == 28 || $i == 29) { //  Orçamento            
            $ativa15 = 'active loading';
        }elseif ($i == 30) {       //  Anexos           
            $ativa16 = 'active loading';
        }elseif ($i == 31) {       //  Link do YouTube             
            $ativa17 = 'active loading';
        }elseif ($i == 32) {       // Final Projeto              
            $ativa18 = 'active loading';
        }elseif ($i == 33) {       //  Informações Administrativas             
            $ativa19 = 'active loading';
        }elseif ($i == 20) {       //  Informações Administrativas             
            $ativa20 = 'active loading';
        }

?>

 <!-- Pessoa Física -->
        <div id="smartwizard">
            <ul>
                <li class="hidden">
                    <a href=""><br /></a>
                </li>
                <li class="<?php echo isset($ativa1) ? $ativa1 : 'clickable'; ?>">
                    <a onclick="location.href='index_pj.php?perfil=informacoes_iniciais_pj'" href=""><br /><small>Proponente</small></a>
                </li> 
                <li class="<?php echo isset($ativa2) ? $ativa2 : 'clickable'; ?>">
                    <a onclick="location.href='index_pj.php?perfil=representante_pj'" href=""><br /><small>Representante Legal</small></a>
                </li>    
                <li class="<?php echo isset($ativa3) ? $ativa3 : 'clickable'; ?>">
                    <a onclick="location.href='index_pj.php?perfil=arquivos_pj'" href=""><br /><small>Documentos do Proponente</small></a>
                </li>
                <?php 
                    if ($pj['liberado'] != 3) {
                ?>                
                <li class="<?php echo isset($ativa4) ? $ativa4 : 'clickable'; ?>">
                    <a onclick="location.href='index_pj.php?perfil=projeto_pj'" href=""><br /><small>Projetos</small></a>
                </li>
                <?php
                        break;
                    } 
                ?>
                <li class="<?php echo isset($ativa4) ? $ativa4 : 'clickable'; ?>">
                    <a onclick="location.href='index_pj.php?perfil=projeto_pj'" href=""><br /><small>Projetos</small></a>
                </li>                
                <li class="<?php echo isset($ativa5) ? $ativa5 : 'clickable'; ?>">
                   <a onclick="location.href='index_pj.php?perfil=projeto_novo'" href=""><br />Cadastro de Projeto</a>
                </li>
                <li class="<?php echo isset($ativa6) ? $ativa6 : 'clickable'; ?>">
                   <a onclick="location.href='index_pj.php?perfil=cooperativa_resultado_busca'" href=""><br />Empresa</a>
                </li>
                <li class="<?php echo isset($ativa7) ? $ativa7 : 'clickable'; ?>">
                   <a onclick="location.href='index_pj.php?perfil=projeto_2'" href=""><br />Passo 2</a>
                </li>  
                <li class="<?php echo isset($ativa8) ? $ativa8 : 'clickable'; ?>">
                   <a onclick="location.href='index_pj.php?perfil=projeto_3'" href=""><br />Passo 3</a>
                </li> 
                <li class="<?php echo isset($ativa9) ? $ativa9 : 'clickable'; ?>">
                   <a onclick="location.href='index_pj.php?perfil=projeto_4'" href=""><br />Passo 4</a>
                </li> 
                <li class="<?php echo isset($ativa10) ? $ativa10 : 'clickable'; ?>">
                   <a onclick="location.href='index_pj.php?perfil=projeto_5'" href=""><br />Passo 5</a>
                </li>
            </ul> <!-- Barra linha 2 -->
            <ul>                
                <li class="<?php echo isset($ativa11) ? $ativa11 : 'clickable'; ?>">
                   <a onclick="location.href='index_pj.php?perfil=projeto_6'" href=""><br />Passo 6</a>
                </li>
                <li class="<?php echo isset($ativa12) ? $ativa12 : 'clickable'; ?>">
                   <a onclick="location.href='index_pj.php?perfil=local'" href=""><br />Local</a>
                </li>
                <li class="<?php echo isset($ativa20) ? $ativa20 : 'clickable'; ?>">
                   <a onclick="location.href='index_pj.php?perfil=projeto_8'" href=""><br />Passo 8</a>
                </li>
                <li class="<?php echo isset($ativa13) ? $ativa13 : 'clickable'; ?>">
                   <a onclick="location.href='index_pj.php?perfil=ficha_tecnica'" href=""><br />Ficha Técnica</a>
                </li>   
                <li class="<?php echo isset($ativa14) ? $ativa14 : 'clickable'; ?>">
                   <a onclick="location.href='index_pj.php?perfil=cronograma'" href=""><br />Cronograma</a>
                </li>
                <li class="<?php echo isset($ativa15) ? $ativa15 : 'clickable'; ?>">
                   <a onclick="location.href='index_pj.php?perfil=orcamento'" href=""><br />Orçamento</a>
                </li>
                <li class="<?php echo isset($ativa16) ? $ativa16 : 'clickable'; ?>">
                   <a onclick="location.href='index_pj.php?perfil=anexos'" href=""><br />Anexos</a>
                </li>
                <li class="<?php echo isset($ativa17) ? $ativa17 : 'clickable'; ?>">
                   <a onclick="location.href='index_pj.php?perfil=projeto_13'" href=""><br />Link do YouTube</a>
                </li>
                <li class="<?php echo isset($ativa18) ? $ativa18 : 'clickable'; ?>">
                   <a onclick="location.href='index_pj.php?perfil=finalProjeto'" href=""><br />Final Projeto</a>
                </li>
                <li class="<?php echo isset($ativa19) ? $ativa19 : 'clickable'; ?>">
                   <a onclick="location.href='index_pj.php?perfil=informacoes_administrativas'" href=""><br />Informações Administrativas</a>
                </li> 
            </ul> 
        </div>
<?php  
    
    }
}
?>