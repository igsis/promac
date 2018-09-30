<div role="tabpanel" class="tab-pane fade" id="F" align="left">
    <li class="list-group-item list-group-item-success">
        <div style="text-align: center;"><b>Dados Pessoa Física</b></div>
    </li>
    <table class="table table-bordered">
        <tr>
            <td colspan="2">
                <strong>Nome:</strong>
                <?= isset($pf['nome']) ? $pf['nome'] : ''; ?>
            </td>
        </tr>
        <tr>
            <td width="50%">
                <strong>CPF:</strong>
                <?= isset($pf['cpf']) ? $pf['cpf'] : ''; ?>
            </td>
            <td>
                <strong>RG:</strong>
                <?= isset($pf['rg']) ? $pf['rg'] : ''; ?>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <strong>Endereço:</strong>
                <?= isset($pf['logradouro']) ? $pf['logradouro'] : ''; ?>,
                <?= isset($pf['numero']) ? $pf['numero'] : ''; ?>
                <?= isset($pf['complemento']) ? $pf['complemento'] : ''; ?> -
                <?= isset($pf['bairro']) ? $pf['bairro'] : ''; ?> -
                <?= isset($pf['cidade']) ? $pf['cidade'] : ''; ?> -
                <?= isset($pf['estado']) ? $pf['estado'] : ''; ?> -
                <?= isset($pf['cep']) ? 'CEP '.$pf['cep'] : ''; ?>
            </td>
        </tr>
        <tr>
            <td>
                <strong>Telefone:</strong>
                <?= isset($pf['telefone']) ? $pf['telefone'] : ''; ?>
            </td>
            <td>
                <strong>Celular:</strong>
                <?= isset($pf['celular']) ? $pf['celular'] : ''; ?>
            </td>
        </tr>

        <tr>
            <td>
                <strong>E-mail:</strong>
                <?= isset($pf['email']) ? $pf['email'] : ''; ?>
            </td>
            <td>
                <strong>Cooperado:</strong>
                <?= $pf['cooperado'] == 1 ? 'SIM' : 'NÃO' ?>
            </td>
        </tr>
    </table>
    <li class="list-group-item list-group-item-success">
        <div style="text-align: center;"><b>Arquivos da Pessoa Física</b></div>
    </li>
    <li class="list-group-item">
        <?php exibirArquivos(1,$pf['idPf']); ?>
    </li>
</div>