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
    8 => '/promac/visual/index_pj.php?perfil=projeto_novo',
    9 => '/promac/visual/index_pj.php?perfil=projeto_edicao',
    10 => '/promac/visual/index_pj.php?perfil=projeto_2',
    11 => '/promac/visual/index_pj.php?perfil=projeto_3',
    12 => '/promac/visual/index_pj.php?perfil=projeto_4',
    13 => '/promac/visual/index_pj.php?perfil=projeto_5',
    14 => '/promac/visual/index_pj.php?perfil=projeto_6',
    15 => '/promac/visual/index_pj.php?perfil=local',
    16 => '/promac/visual/index_pj.php?perfil=local_novo',
    17 => '/promac/visual/index_pj.php?perfil=local_edicao',
    18 => '/promac/visual/index_pj.php?perfil=projeto_8'
);

for ($i = 0; $i < count($urlPj); $i++) {
    if ($uri == $urlPj[$i]) {
        if ($i == 0 || $i == 1 || $i == 2){ // informações iniciais
            $ativa1 = 'active loading';
        }elseif ($i == 3 || $i == 4 || $i == 5) {                
            $ativa2 = 'active loading';
        }elseif ($i == 6) {                
            $ativa3 = 'active loading';
        }elseif ($i == 7 || $i == 8) {                
            $ativa4 = 'active loading';
        }

?>

 <!-- Pessoa Física -->
        <div id="smartwizard">
            <ul>
                <li class="hidden">
                    <a href=""><br /></a>
                </li>
                <li class="<?php echo isset($ativa1) ? $ativa1 : 'clickable'; ?>">
                    <a onclick="location.href='index_pj.php?perfil=informacoes_iniciais_pj'" href=""><br /><small>Informações Iniciais</small></a>
                </li> 
                <li class="<?php echo isset($ativa2) ? $ativa2 : 'clickable'; ?>">
                    <a onclick="location.href='index_pj.php?perfil=representante_pj'" href=""><br /><small>Representante Legal</small></a>
                </li>    
                <li class="<?php echo isset($ativa3) ? $ativa3 : 'clickable'; ?>">
                    <a onclick="location.href='index_pj.php?perfil=arquivos_pj'" href=""><br /><small>Arquivos Pessoais</small></a>
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
                <li class="<?php echo isset($ativa) ? $ativa : 'clickable'; ?>">
                   <a onclick="location.href='index_pj.php?perfil=projeto_novo'" href=""><br />Cadastro de Projeto</a>
                </li>
                <li class="<?php echo isset($ativa) ? $ativa : 'clickable'; ?>">
                   <a onclick="location.href='index_pj.php?perfil=cooperativa_resultado_busca'" href=""><br />Empresa</a>
                </li>
                <li class="<?php echo isset($ativa) ? $ativa : 'clickable'; ?>">
                   <a onclick="location.href='index_pj.php?perfil=projeto_2'" href=""><br />Passo 2</a>
                </li>  
                <li class="<?php echo isset($ativa) ? $ativa : 'clickable'; ?>">
                   <a onclick="location.href='index_pj.php?perfil=ativaprojeto_3'" href=""><br />Passo 3</a>
                </li> 
                <li class="<?php echo isset($ativa) ? $ativa : 'clickable'; ?>">
                   <a onclick="location.href='index_pj.php?perfil=projeto_4'" href=""><br />Passo 4</a>
                </li> 
                <li class="<?php echo isset($ativa) ? $ativa : 'clickable'; ?>">
                   <a onclick="location.href='index_pj.php?perfil=projeto_5'" href=""><br />Passo 5</a>
                </li>
            </ul> <!-- Barra linha 2 -->
            <ul>                
                <li class="<?php echo isset($ativa) ? $ativa : 'clickable'; ?>">
                   <a onclick="location.href='index_pj.php?perfil=projeto_6'" href=""><br />Passo 6</a>
                </li>
                <li class="<?php echo isset($ativa) ? $ativa : 'clickable'; ?>">
                   <a onclick="location.href='index_pj.php?perfil=local'" href=""><br />Local</a>
                </li>
                <li class="<?php echo isset($ativa) ? $ativa : 'clickable'; ?>">
                   <a onclick="location.href='index_pj.php?perfil=ficha_tecnica'" href=""><br />Ficha Técnica</a>
                </li>   
                <li class="<?php echo isset($ativa) ? $ativa : 'clickable'; ?>">
                   <a onclick="location.href='index_pj.php?perfil=cronograma'" href=""><br />Cronograma</a>
                </li>
                <li class="<?php echo isset($ativa) ? $ativa : 'clickable'; ?>">
                   <a onclick="location.href='index_pj.php?perfil=orcamento'" href=""><br />Orçamento</a>
                </li>
                <li class="<?php echo isset($ativa) ? $ativa : 'clickable'; ?>">
                   <a onclick="location.href='index_pj.php?perfil=anexos'" href=""><br />Anexos</a>
                </li>
                <li class="<?php echo isset($ativa) ? $ativa : 'clickable'; ?>">
                   <a onclick="location.href='index_pj.php?perfil=projeto_13'" href=""><br />Link do YouTube</a>
                </li>
                <li class="<?php echo isset($ativa) ? $ativa : 'clickable'; ?>">
                   <a onclick="location.href='index_pj.php?perfil=finalProjeto'" href=""><br />Final Projeto</a>
                </li>
                <li class="<?php echo isset($ativa) ? $ativa : 'clickable'; ?>">
                   <a onclick="location.href='index_pj.php?perfil=informacoes_administrativas'" href=""><br />Informações Administrativas</a>
                </li> 
            </ul> 
        </div>
<?php  
    
    }
}
?>