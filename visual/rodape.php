
<footer>
    <div class="container">
        <table style="width: 100%">
            <tr>
                <td style="color: #ccc"><i class="fa fa-phone-square"></i> Dúvidas: <br>Sobre cadastros: cadastrospromac@prefeitura.sp.gov.br<br>Sobre projetos: projetospromac@prefeitura.sp.gov.br<br>Sobre incentivo e abatimento fiscal: incentivopromac@gmail.com<br>Sobre prestação de contas: prestacaocontaspromac@prefeitura.sp.gov.br</td>
                <td style="color: #ccc; text-align: center">2018 @ Pro-Mac - Programa Municipal de Apoio a Projetos Culturais<br/>Secretaria Municipal de Cultura<br/>Prefeitura de São Paulo</td>
                <td style="width: 20%; text-align: right"><img src="images/pin_promac_pq.png" alt="Logo Promac"/>
            </tr>
            <tr>
                <td colspan="3" style="color: #ccc; text-align: center; font-size: x-small"><br/><i>Supervisão de Tecnologia da Informação - Sistemas de Informação</i></td>
            </tr>
        </table>
    </div>
	<div class="container">
		<div class="col-md-12">
			<?php
			if($_SESSION['idUser'] == 1 AND $_SESSION['tipoPessoa'] == 1) {
                echo "<strong>SESSION</strong><pre>", var_dump($_SESSION), "</pre>";
                echo "<strong>POST</strong><pre>", var_dump($_POST), "</pre>";
                echo "<strong>GET</strong><pre>", var_dump($_GET), "</pre>";
                echo "<strong>FILES</strong><pre>", var_dump($_FILES), "</pre>";
                echo ini_get('session.gc_maxlifetime') / 60; // em minutos
            }
			?>
		</div>
	</div>
</footer>

<!-- Ion Slider -->
<script src="dist/ion-rangeslider/js/ion.rangeSlider.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.smooth-scroll.min.js"></script>
<script src="js/jquery.dlmenu.js"></script>
<script src="js/wow.min.js"></script>
<script src="js/custom.js"></script>
<script src="js/scriptbaixo.js"></script>
<script src="js/termoContrato.js"></script>
<!-- <script src="js/pegaCep.js"></script> -->

</body>
</html>