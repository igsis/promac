<?php
//CONTROLLERS
require_once "./controllers/PessoaFisicaController.php";

$projetoObj = new ProjetoController();
$fomentoObj = new FomentoController();
$pfObj = new PessoaFisicaController();

//Pessoa Física
$pf = $pfObj->recuperaPessoaFisicaFom(MainModel::encryption($projeto['pessoa_fisica_id']));
$genero = $pfObj->dadosAdcFom(['genero',$pf['genero_id']]);
$etnia = $pfObj->dadosAdcFom(['descricao','etnias',$pf['etnia_id']]);
$grau_inst = $pfObj->dadosAdcFom(['grau_instrucao','grau_instrucoes',$pf['grau_instrucao_id']]);
$subpref = $pfObj->dadosAdcFom(['subprefeitura',$pf['subprefeitura_id']]);