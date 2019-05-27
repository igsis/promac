<?php 
# Barra Incentivador PJ
$con  = bancoMysqli();
$pj   = recuperaDados("incentivador_pessoa_juridica","idPj",$idPj);

$urlIncentivadorPj = array(
	// Rotas
	0 => '/promac/visual/incentivador_index_pj.php',
	1 => '/promac/visual/incentivador_index_pj.php?perfil=cadastro_incentivador_pj',
	2 => '/promac/visual/incentivador_index_pj.php?perfil=incentivador_representante_pj',
	3 => '/promac/visual/incentivador_index_pj.php?perfil=incentivador_representante_pj_resultado_busca',
	4 => '/promac/visual/incentivador_index_pj.php?perfil=incentivador_representante_pj_cadastro',
	5 => '/promac/visual/incentivador_index_pj.php?perfil=representante_pj',
	6 => '/promac/visual/incentivador_index_pj.php?perfil=representante_pj_cadastro',
	7 => '/promac/visual/incentivador_index_pj.php?perfil=representante_pj_resultado_busca',
	8 => '/promac/visual/incentivador_index_pj.php?perfil=arquivos_incentivador_pj',
    9 => '/promac/visual/incentivador_index_pj.php?perfil=incentivador_concluir_pj',
    10 => '/promac/visual/incentivador_index_pj.php?perfil=resultado_inscricao_incentivador_pj' // Resultado Inscrição
);


if($barraPf['liberado'] < 3 ){

    for ($i = 0; $i < count($urlIncentivadorPj); $i++) {
        if ($uri == $urlIncentivadorPj[$i]) {
            if ($i == 0|| $i == 1) { // Cadastro Incentivador
                $liga1 = 'active loading'; 
            }elseif ($i == 2 || $i == 3 || $i == 4 || $i == 5 || $i == 6 || $i == 7) { 	 // Representante Legal
                $liga2 = 'active loading'; 
            }elseif ($i == 8) { // Documentos do Incentivador
                $liga3 = 'active loading';
            }elseif ($i == 9) { // Concluir Inscrição
                $liga4 = 'active loading';
            }elseif ($i == 10) { // Resultado Inscrição
                $liga5 = 'active loading';
            }
    ?>

        <!-- SmartWizard html -->
        <div id="smartwizard">
            <ul>
                <li class="hidden">
                    <a href=""><br /></a>
                </li>
                <li class="<?php echo $liga1 ?? 'clickable'; ?>">
                    <a onclick="location.href='incentivador_index_pj.php'" href=""><br />Incentivador</a>
                </li>
                <li class="<?php echo $liga2 ?? 'clickable'; ?>">
                    <a onclick="location.href='incentivador_index_pj.php?perfil=incentivador_representante_pj'" href=""><br />Representante Legal</a>
                </li>
                <?php
                    if ($pj['liberado'] != 3) {
                ?>
                <li class="<?php echo $liga3 ?? 'clickable'; ?>">
                    <a onclick="location.href='incentivador_index_pj.php?perfil=arquivos_incentivador_pj'" href=""><br />Documentos do Incentivador</a>
                </li>
                <?php 
                    }
                ?>
                <li class="<?php echo $liga5 ?? 'clickable'; ?>">
                    <a onclick="location.href='incentivador_index_pj.php?perfil=resultado_inscricao_incentivador_pj'" href=""><br /><small>Concluir Inscrição</small></a>
                </li>
                <li class="<?php echo $liga4 ?? 'clickable'; ?>">
                    <a onclick="location.href='incentivador_index_pj.php?perfil=incentivador_concluir_pj'" href=""><br />Resultado Inscrição</a>
                </li>
            </ul>
        </div>
    <?php  
            }
        }
}
?>
