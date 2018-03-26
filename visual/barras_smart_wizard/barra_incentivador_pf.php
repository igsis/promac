<?php 
# Barra Incentivador PF
$con  = bancoMysqli();

$urlIncentivadorPf = array(
	// Rotas
	0 => '/promac/visual/incentivador_index_pf.php',
	1 => '/promac/visual/incentivador_index_pf.php?perfil=cadastro_incentivador_pf',
	2 => '/promac/visual/incentivador_index_pf.php?perfil=incentivador_informacoes_iniciais_pf',
	3 => '/promac/visual/incentivador_index_pf.php?perfil=incentivador_arquivos_pf'

);

for ($i = 0; $i < count($urlIncentivadorPf); $i++) {
    if ($uri == $urlIncentivadorPf[$i]) {
        if ($i == 0|| $i == 1) {
            $ligar1 = 'active loading';
        }
?>

	<!-- SmartWizard html -->
        <div id="smartwizard">
            <ul>
                <li class="hidden">
                    <a href=""><br /></a>
                </li>
                <li class="<?php echo isset($ligar1) ? $ligar1 : 'clickable'; ?>">
                    <a onclick="location.href='incentivador_index_pf.php'" href=""><br />Incentivador</a>
                </li>
                <li class="<?php echo isset($ligar2) ? $ligar2 : 'clickable'; ?>">
                    <a onclick="location.href=''" href=""><br />Documentos do Incentivador</a>
                </li>
            </ul>
        </div>
<?php  
	}
}
?>
