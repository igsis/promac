<?php 
# Barra Incentivador PJ
$con  = bancoMysqli();

$urlIncentivadorPj = array(
	// Rotas
	0 => '/promac/visual/incentivador_index_pj.php',
	1 => '/promac/visual/incentivador_index_pj.php?perfil=cadastro_incentivador_pj',
	2 => '/promac/visual/incentivador_index_pj.php?perfil=arquivos_incentivador_pj',
	3 => '/promac/visual/incentivador_index_pf.php?perfil=incentivador_informacoes_iniciais_pj',
	4 => '/promac/visual/incentivador_index_pj.php?perfil=incentivador_representante_pj',
	5 => '/promac/visual/incentivador_index_pj.php?perfil=incentivador_representante_pj_resultado_busca',
	6 => '/promac/visual/incentivador_index_pj.php?perfil=incentivador_representante_pj_cadastro'
);


for ($i = 0; $i < count($urlIncentivadorPj); $i++) {
    if ($uri == $urlIncentivadorPj[$i]) {
        if ($i == 0|| $i == 1) {
            $liga1 = 'active loading';
        }
?>

	<!-- SmartWizard html -->
        <div id="smartwizard">
            <ul>
                <li class="hidden">
                    <a href=""><br /></a>
                </li>
                <li class="<?php echo isset($liga1) ? $liga1 : 'clickable'; ?>">
                    <a onclick="location.href='incentivador_index_pj.php'" href=""><br />Incentivador</a>
                </li>
                <li class="<?php echo isset($liga2) ? $liga2 : 'clickable'; ?>">
                    <a onclick="location.href=''" href=""><br />Representante Legal</a>
                </li>
                <li class="<?php echo isset($liga3) ? $liga3 : 'clickable'; ?>">
                    <a onclick="location.href=''" href=""><br />Documentos do Incentivador</a>
                </li>
            </ul>
        </div>
<?php  
	}
}
?>
