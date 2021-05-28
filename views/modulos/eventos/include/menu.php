<li class="nav-item">
    <a href="<?= SERVERURL ?>eventos/inicio" class="nav-link" id="evento_cc_inicio">
        <i class="fa fa-info nav-icon"></i>
        <p>Dados necessários</p>
    </a>
</li>
<li class="nav-item">
    <a href="<?= SERVERURL ?>eventos/evento_lista" class="nav-link" id="evento_lista">
        <i class="far fa-circle nav-icon"></i>
        <p>Eventos</p>
    </a>
</li>
<?php if (isset($_SESSION['origem_id_c'])): ?>
    <li class="nav-item">
        <a href="<?= SERVERURL ?>eventos/evento_cadastro" class="nav-link" id="evento_cc_cadastro">
            <i class="far fa-circle nav-icon"></i>
            <p>Informações Iniciais</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?= SERVERURL ?>eventos/atracao_lista" class="nav-link" id="atracao_lista">
            <i class="far fa-circle nav-icon"></i>
            <p>Atrações</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?= SERVERURL ?>eventos/arquivos_com_prod" class="nav-link" id="com_prod">
            <i class="far fa-circle nav-icon"></i>
            <p>Comunicação/Produção</p>
        </a>
    </li>

    <?php
    if (isset($_SESSION['pedido_id_c'])) {
        ?>
        <li class="nav-item has-treeview menu-open" id="itens-proponente">
            <a href="#" class="nav-link"><i class="far fa-circle nav-icon"></i>
                <p>
                    Proponente
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="<?= SERVERURL ?>eventos/proponente_lista" class="nav-link" id="proponentes-cadastrados">

                        <div class="row">
                            <div class="col-3"><i class="ml-3 far fa-dot-circle nav-icon"></i></div>
                            <div class="col-9">Cadastro</div>
                        </div>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= SERVERURL ?>eventos/anexos_proponente" class="nav-link" id="anexos-proponente">
                        <div class="row">
                            <div class="col-3"><i class="ml-3 far fa-dot-circle nav-icon"></i></div>
                            <div class="col-9">Anexos</div>
                        </div>
                    </a>
                </li>
            </ul>
        </li>
        <?php
    } else {
        ?>
        <li class="nav-item">
            <a href="<?= SERVERURL ?>eventos/proponente" class="nav-link" id="proponente">
                <i class="far fa-circle nav-icon"></i>
                <p>
                    Proponente
                </p>
            </a>
        </li>
        <?php
    }
    ?>
    <?php
    if (isset($_SESSION['pedido_id_c'])):
        require_once "./controllers/PedidoController.php";
        $pedidoObj = new PedidoController();

        $idPedido = $pedidoObj->getPedido($_SESSION['pedido_id_c']);

        $pedido = $pedidoObj->consultaSimples("SELECT * FROM pedidos WHERE id = $idPedido AND pessoa_juridica_id IS NOT NULL");
        if ($pedido->rowCount() > 0):
            ?>
            <li class="nav-item">
                <a href="<?= SERVERURL ?>eventos/lider" class="nav-link" id="lider">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Líder</p>
                </a>
            </li>
        <?php endif; ?>
        <li class="nav-item">
            <a href="<?= SERVERURL ?>eventos/demais_anexos" class="nav-link" id="demais_anexos">
                <i class="far fa-circle nav-icon"></i>
                <p>Demais Anexos</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="<?= SERVERURL ?>eventos/finalizar" class="nav-link" id="finalizar">
                <i class="far fa-circle nav-icon"></i>
                <p>Finalizar</p>
            </a>
        </li>
    <?php endif; ?>
<?php endif; ?>