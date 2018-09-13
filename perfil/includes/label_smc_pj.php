<div role="tabpanel" class="tab-pane fade" id="J">
                                         
    <li class="list-group-item list-group-item-success">
        <b>Dados Pessoa Jurídica</b>
    </li>
        <table class="table table-bordered">
            <tr>
                <td colspan="2">
                    <strong>Razão Social:</strong>
                    <?php echo isset($pj['razaoSocial']) ? $pj['razaoSocial'] : null; ?>
                </td>
            </tr>
            <tr>
                <td width="50%">
                    <strong>CNPJ:</strong>
                    <?php echo isset($pj['cnpj']) ? $pj['cnpj'] : null; ?>
                </td>
                <td>
                    <strong>CCM:</strong>
                    <?php echo isset($pj['ccm']) ? $pj['ccm'] : null; ?>
                </td>
            </tr>
            <tr>
                <td colspan="2"><strong>Endereço:</strong>
                    <?php echo isset($pj['logradouro']) ? $pj['logradouro'] : null; ?>,
                    <?php echo isset($pj['numero']) ? $pj['numero'] : null; ?>
                    <?php echo isset($pj['complemento']) ? $pj['complemento'] : null; ?> -
                    <?php echo isset($pj['bairro']) ? $pj['bairro'] : null; ?> -
                    <?php echo isset($pj['cidade']) ? $pj['cidade'] : null; ?> -
                    <?php echo isset($pj['estado']) ? $pj['estado'] : null; ?> - CEP
                    <?php echo isset($pj['cep']) ? $pj['cep'] : null; ?>
                </td>
            </tr>
            <tr>
                <td><strong>Telefone:</strong>
                    <?php echo isset($pj['telefone']) ? $pj['telefone'] : null; ?>
                </td>
                <td><strong>Celular:</strong>
                    <?php echo isset($pj['celular']) ? $pj['celular'] : null; ?>
                </td>
            </tr>
            <tr>
                <td><strong>E-mail:</strong>
                    <?php echo isset($pj['email']) ? $pj['email'] : null; ?>
                </td>
                <td><strong>Cooperativa:</strong>
                    <?php if($pj['cooperativa'] == 1){ echo "Sim"; } else { echo "Não"; } ?>
                </td>
            </tr>
        </table>

            <li class="list-group-item list-group-item-success">
                <b>Dados Representante</b>
            </li>
            <!--Dados Representante xura -->
            <table class="table table-bordered">
                <tr>
                    <td colspan="2">
                        <strong>Nome:</strong>
                        <?= isset($representante['nome']) ? $representante['nome'] : ''; ?>
                    </td>
                </tr>
                <tr>
                    <td width="50%">
                        <strong>CPF:</strong>
                        <?= isset($representante['cpf']) ? $representante['cpf'] : ''; ?>
                    </td>
                    <td>
                        <strong>RG:</strong>
                        <?= isset($representante['rg']) ? $representante['rg'] : ''; ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <strong>Endereço:</strong>
                            <?= isset($representante['logradouro']) ? $representante['logradouro'] : ''; ?> ,
                            <?= isset($representante['numero']) ? $representante['numero'] : ''; ?>
                        <b>Bairro</b>:
                            <?= isset($representante['bairro']) ? $representante['bairro'] : ''; ?>
                        <b>Cep</b>:
                            <?= isset($representante['cep']) ? $representante['cep'] : ''; ?>
                        <b>Cidade</b>:
                            <?= isset($representante['cidade']) ? $representante['cidade'] : ''; ?> - 
                            <?= isset($representante['estado']) ? $representante['estado'] : ''; ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <strong>Telefone:</strong>
                            <?= isset($representante['telefone']) ? $representante['telefone'] : ''; ?>
                    </td>
                    <td>
                        <strong>Celular:</strong>
                            <?= isset($representante['celular']) ? $representante['celular'] : ''; ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <strong>E-mail:</strong>
                            <?= isset($representante['email']) ? $representante['email'] : ''; ?>
                    </td>
                    <td>
                        <strong>Cooperado:</strong>
                            <?= $representante['cooperativa'] == 1 ? 'SIM' : 'NÃO' ?>
                    </td>
                </tr>
            </table>
                    <ul class="list-group">
                        <li class="list-group-item list-group-item-success">
                            <b>Arquivos da Pessoa Jurídica</b></li>
                        <li class="list-group-item">
                            <?php exibirArquivos(2,$pj['idPj']); ?>
                        </li>
                    </ul>
                            
</div>