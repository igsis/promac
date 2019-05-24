<form method="POST">
    <div class="well">
        <label for="admResposta"></label>
        <input type="radio" name="admResposta" value="1" class="resposta" id="sim"> Sim
        <input type="radio" name="admResposta" checked value="0" class="resposta" id="nao"> Não

        <p>
            <span id="aviso-a">a</span>
        </p>
    </div>
</form>

<script>

    var texto = "Para encontrar um projeto para incentivar, continue buscando os projetos para incentivar, continue buscando os projetos aprovados semanalmente na Consulta Pública disponível na Home do site PROMAC. Depois de escolher o projeto que deseja incentivar, retorne a essa página, por gentileza."

    var resposta = $('.resposta');
    resposta.on("change", verficaResposta());
    $(document).ready(verficaResposta());

    function verficaResposta() {
        if ($('#sim').is(':checked')) {
                $('#aviso-a').text("");
        } else $('#nao').is(':checked'){
            $('#aviso-a').text(texto);
        }
    }

</script>