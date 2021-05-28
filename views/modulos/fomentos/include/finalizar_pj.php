<?php

$pjObj = new PessoaJuridicaController();
$repObj = new RepresentanteController();

//Pessoa Juridica
$pj = $pjObj->recuperaPessoaJuridica(MainModel::encryption($projeto['pessoa_juridica_id']));

//Representante
$repre = $repObj->recuperaRepresentante(MainModel::encryption($pj['representante_legal1_id']))->fetch(PDO::FETCH_ASSOC);