<?php
require_once "config/configGeral.php";
require_once "controllers/ViewsController.php";

$template = new ViewsController();

$template->exibirTemplate();