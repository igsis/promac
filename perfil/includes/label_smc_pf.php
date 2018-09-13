<div role="tabpanel" class="tab-pane fade" id="F" align="left">
    <li class="list-group-item list-group-item-success">
            <div style="text-align: center;">
                <b>Dados Pessoa Física</b>
            </div>
        </li>
    <table class="table table-bordered">
        <tr>
            <td colspan="2">
                <strong>Nome:</strong>
                <?php //echo isset($pf['nome']) ? $pf['nome'] : null; ?>
                <?= isset($pessoaFisica['nome']) ? $pessoaFisica['nome'] : ''; ?>
            </td>
        </tr>
        
        <tr>
            <td width="50%">
                <strong>CPF:</strong>
                <?php //echo isset($pf['cpf']) ? $pf['cpf'] : null; ?>
                <?= isset($pessoaFisica['cpf']) ? $pessoaFisica['cpf'] : ''; ?>
            </td>
            <td>
                <strong>RG:</strong>
                <?php //echo isset($pf['rg']) ? $pf['rg'] : null; ?>
                <?= isset($pessoaFisica['rg']) ? $pessoaFisica['rg'] : ''; ?>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <strong>Endereço:</strong>
                <?php //echo isset($pf['logradouro']) ? $pf['logradouro'] : null; ?>
                <?php //echo isset($pf['numero']) ? $pf['numero'] : null; ?>
                <?php //echo isset($pf['complemento']) ? $pf['complemento'] : null; ?>
                <?php //echo isset($pf['bairro']) ? $pf['bairro'] : null; ?>
                <?php //echo isset($pf['cidade']) ? $pf['cidade'] : null; ?>
                <?php //echo isset($pf['estado']) ? $pf['estado'] : null; ?>
                <?php //echo isset($pf['cep']) ? $pf['cep'] : null; ?>

                <?= isset($pessoaFisica['logradouro']) ? $pessoaFisica['logradouro'] : ''; ?> , 
                <?= isset($pessoaFisica['numero']) ? $pessoaFisica['numero'] : ''; ?>

                <b>Bairro</b>:
                <?= isset($pessoaFisica['bairro']) ? $pessoaFisica['bairro'] : ''; ?>

                <b>Cep</b>:
                <?= isset($pessoaFisica['cep']) ? $pessoaFisica['cep'] : ''; ?>

                <b>Cidade</b>:
                <?= isset($pessoaFisica['cidade']) ? $pessoaFisica['cidade'] : ''; ?>
                <?= isset($pessoaFisica['estado']) ? $pessoaFisica['estado'] : ''; ?>
            </td>
        </tr>

        <tr>
            <td>
                <strong>Telefone:</strong>
                <?php //echo isset($pf['telefone']) ? $pf['telefone'] : null; ?>
                <?= isset($pessoaFisica['telefone']) ? $pessoaFisica['telefone'] : ''; ?>
            </td>

            <td>
                <strong>Celular:</strong>
                <?php //echo isset($pf['celular']) ? $pf['celular'] : null; ?>
                <?= isset($pessoaFisica['celular']) ? $pessoaFisica['celular'] : ''; ?>
            </td>
        </tr>

        <tr>
            <td>
                <strong>E-mail:</strong>
                <?php //echo isset($pf['email']) ? $pf['email'] : null; ?>
                <?= isset($pessoaFisica['email']) ? $pessoaFisica['email'] : ''; ?>
            </td>

            <td>
                <strong>Cooperado:</strong>
                <?php //if($pf['cooperado'] == 1){ echo "Sim"; } else { echo "Não"; } ?>
                <?= $pessoaFisica['cooperado'] == 1 ? 'SIM' : 'NÃO' ?>
            </td>
        </tr>
    </table>
            <ul class="list-group">
                <li class="list-group-item list-group-item-success">
            <center>
                <b>Arquivos da Pessoa Física</b>
            </center>
                </li>
                <li class="list-group-item">
                <?php exibirArquivos(1,$pessoaFisica['idPf']); ?>
                </li>
            </ul>
        </div>