USE `promac`;

ALTER TABLE `projeto` ADD `dataParecerista` DATE NOT NULL AFTER `idStatusParecerista`;

CREATE TABLE IF NOT EXISTS `promac`.`agendamento` (
 `id` INT NOT NULL AUTO_INCREMENT,
  `linkAgendamento` VARCHAR(150) NOT NULL,
  `data` DATE NULL,
  PRIMARY KEY (`id`)
);

ALTER TABLE `historico_reuniao` CHANGE `idStatus` `idEtapaProjeto` INT(11) NOT NULL;

UPDATE lista_documento SET documento = 'Declaração de inscrição [modelo para download]' WHERE lista_documento.idListaDocumento = 6;

UPDATE lista_documento SET documento = 'Declaração de inscrição [modelo para download]' WHERE lista_documento.idListaDocumento = 15;


CREATE TABLE `exposicao_marca` (
 `id` tinyint(1) NOT NULL,
 `exposicao_marca` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `exposicao_marca` (`id`, `exposicao_marca`) VALUES
(1, 'Apresenta'),
(2, 'Patrocínio'),
(3, 'Apoio'),
(4, 'Mecenato');

ALTER TABLE `exposicao_marca`
 ADD PRIMARY KEY (`id`);

ALTER TABLE `exposicao_marca`
 MODIFY `id` tinyint(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

ALTER TABLE `projeto` CHANGE `exposicaoMarca` `indicacaoIngresso` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;

ALTER TABLE `projeto` ADD `idExposicaoMarca` TINYINT(1) NOT NULL AFTER `indicacaoIngresso`;



/*
PROCEDURE
 */
DROP PROCEDURE `pr_atualizaCampos`;
DELIMITER |
CREATE DEFINER=`root`@`localhost` PROCEDURE `pr_atualizaCampos`() NOT DETERMINISTIC CONTAINS SQL SQL SECURITY DEFINER BEGIN
 SET SQL_SAFE_UPDATES = 0;
UPDATE projeto SET indicacaoIngresso = '' WHERE indicacaoIngresso is null;
UPDATE projeto SET resumoProjeto = '' WHERE resumoProjeto is null;
UPDATE projeto SET curriculo = '' WHERE curriculo is null;
UPDATE projeto SET descricao = '' WHERE descricao is null;
UPDATE projeto SET justificativa = '' WHERE justificativa is null;
UPDATE projeto SET objetivo = '' WHERE objetivo is null;
UPDATE projeto SET metodologia = '' WHERE metodologia is null;
UPDATE projeto SET contrapartida = '' WHERE contrapartida is null;
UPDATE projeto SET publicoAlvo = '' WHERE publicoAlvo is null;
UPDATE projeto SET planoDivulgacao = '' WHERE planoDivulgacao is null;
UPDATE projeto SET inicioCronograma = '' WHERE inicioCronograma is null;
UPDATE projeto SET fimCronograma = '' WHERE fimCronograma is null;
UPDATE projeto SET video1 = '' WHERE video1 is null;
UPDATE projeto SET video2 = '' WHERE video2 is null;
UPDATE projeto SET video3 = '' WHERE video3 is null;
UPDATE projeto SET protocolo = '' WHERE protocolo is null;
UPDATE projeto SET envioComissao = 0 WHERE envioComissao is null;
UPDATE projeto SET protocolo = '' WHERE protocolo is null;
UPDATE projeto SET contratoGestao = 0 WHERE contratoGestao is null;

END
|
DELIMITER ;
/*
final procedure
 */

ALTER TABLE promac.statusprojeto ADD COLUMN data DATE NOT NULL AFTER descricaoSituacao, RENAME TO promac.liberacao_projeto;

DROP TRIGGER `tr_log_projeto`;
CREATE DEFINER=`root`@`localhost` TRIGGER `tr_log_projeto` AFTER UPDATE ON `projeto` FOR EACH ROW INSERT INTO  weblogs(tabela, acao, idRegistro, dataOcorrencia, antes, depois)
VALUES('projeto', 'UPDATE', new.idProjeto, now(),
       concat('NOMEPROJETO:',old.nomeProjeto,
              '|','ATUACAO:',old.idAreaAtuacao,
              '|','VALOR-P:',old.valorProjeto,
              '|','INCENTIVO:',old.valorIncentivo,
              '|','FINANCIAMENTO:',old.valorFinanciamento,
              '|','RENUNCIA-F:',old.idRenunciaFiscal,
              '|','EXPOSICAO-M:',old.idExposicaoMarca,
              '|','RESUMO-P:',old.resumoProjeto,
              '|','CURRICULO:',old.curriculo,
              '|','DESCRICAO:',old.descricao,
              '|','JUSTIFICATIVA:',old.justificativa,
              '|','OBJETIVO:',old.objetivo,
              '|','METODOLOGIA:',old.metodologia,
              '|','CONTRAPARTIDA:',old.contrapartida,
              '|','PUBLICOALVO:',old.publicoAlvo,
              '|','DIVULGACAO:',old.planoDivulgacao,
              '|','CONOGRAMA-I:',old.inicioCronograma,
              '|','CONOGRAMA-F:',old.fimCronograma,
              '|','CONOGRAMA-ID:',old.idCronograma,
              '|','TOTALPREPROD:',old.totalPreProducao,
              '|','TOTALPROD:',old.totalProducao,
              '|','IMPRESSA:',old.totalImprensa,
              '|','CUSTO-AMD:',old.totalCustosAdministrativos,
              '|','IMPOSTOS:',old.totalImpostos,
              '|','AGENCIAMENTO:',old.totalAgenciamento,
              '|','OUTROS-FINAC:',old.totalOutrosFinanciamentos,
              '|','VIDEO01:',old.video1,
              '|','VIDEO02:',old.video2,
              '|','VIDEO03:',old.video3,
              '|','VALOR-AP:',old.valorAprovado,
              '|','STATUS:',old.idStatus,
              '|','PUBLICADO:',old.publicado,
              '|','PROTOCOLO:',old.protocolo,
              '|','TIPOPESSOA:',old.tipoPessoa,
              '|','CONTRATO:',old.contratoGestao,
              '|','PJ:',old.idPj,
              '|','PF:',old.idPf,
              '|','COMISSAO:',old.envioComissao
         ),

       concat('NOMEPROJETO:',new.nomeProjeto,
              '|','ATUACAO:',new.idAreaAtuacao,
              '|','VALOR-P:',new.valorProjeto,
              '|','INCENTIVO:',new.valorIncentivo,
              '|','FINANCIAMENTO:',new.valorFinanciamento,
              '|','RENUNCIA-F:',new.idRenunciaFiscal,
              '|','EXPOSICAO-M:',new.idExposicaoMarca,
              '|','RESUMO-P:',new.resumoProjeto,
              '|','CURRICULO:',new.curriculo,
              '|','DESCRICAO:',new.descricao,
              '|','JUSTIFICATIVA:',new.justificativa,
              '|','OBJETIVO:',new.objetivo,
              '|','METODOLOGIA:',new.metodologia,
              '|','CONTRAPARTIDA:',new.contrapartida,
              '|','PUBLICOALVO:',new.publicoAlvo,
              '|','DIVULGACAO:',new.planoDivulgacao,
              '|','CONOGRAMA-I:',new.inicioCronograma,
              '|','CONOGRAMA-F:',new.fimCronograma,
              '|','CONOGRAMA-ID:',new.idCronograma,
              '|','TOTALPREPROD:',new.totalPreProducao,
              '|','TOTALPROD:',new.totalProducao,
              '|','IMPRESSA:',new.totalImprensa,
              '|','CUSTO-AMD:',new.totalCustosAdministrativos,
              '|','IMPOSTOS:',new.totalImpostos,
              '|','AGENCIAMENTO:',new.totalAgenciamento,
              '|','OUTROS-FINAC:',new.totalOutrosFinanciamentos,
              '|','VIDEO01:',new.video1,
              '|','VIDEO02:',new.video2,
              '|','VIDEO03:',new.video3,
              '|','VALOR-AP:',new.valorAprovado,
              '|','STATUS:',new.idStatus,
              '|','PUBLICADO:',new.publicado,
              '|','PROTOCOLO:',new.protocolo,
              '|','TIPOPESSOA:',new.tipoPessoa,
              '|','CONTRATO:',new.contratoGestao,
              '|','PJ:',new.idPj,
              '|','PF:',new.idPf,
              '|','COMISSAO:',new.envioComissao

         ));