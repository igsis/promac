
INSERT INTO promac.lista_documento (idListaDocumento, idTipoUpload, documento, sigla, publicado) 
VALUES ('54', '3', 'Comprovante de que o incentivador n�o pertence �s listas de Empresas Apenadas', 'apenadas', 1);

/*  LEGENDA */
/* liberado 4 = em analise
   liberado 5 = apto
   liberado 6 = inapto */


/*
* INÍCIO
* 27/05/2019 -> Lorelei
*/

CREATE TABLE `etapas_incentivo` (
  `id` int(11) NOT NULL,
  `tipoPessoa` tinyint(1) NOT NULL,
  `idIncentivador` int(11) NOT NULL,
  `idProjeto` int(11) NOT NULL,
  `etapa` tinyint(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `etapas_incentivo`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `etapas_incentivo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

/*
* FIM
* 27/05/2019 -> Lorelei
*/

/*
* Inicio 
* 06/06/2019 -> Tanair
*/ 

ALTER TABLE `promac`.`incentivador_projeto` 
ADD COLUMN `valor_aportado` DECIMAL(11,2) NOT NULL AFTER `idProjeto`;

/* 
* FIM
* 06/06/2019 -> Tanair 
*/

/* 
* Início
* 10/06/2019 -> Tanair 
*/ 

CREATE TABLE `promac`.`parcelas_incentivo` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `idProjeto` INT NOT NULL,
  `tipoPessoa` TINYINT(1) NOT NULL,
  `idIncentivador` INT NOT NULL,
  `numero_parcela` TINYINT(1) NOT NULL,
  `valor` DECIMAL(8,2) NOT NULL,
  `data_pagamento` DATE NOT NULL,
  `publicado` TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`));


ALTER TABLE `promac`.`incentivador_projeto` 
ADD COLUMN `numero_parcelas` TINYINT(1) NULL AFTER `valor_aportado`;


/* 
* FIM -> Tanair
* 10/06/2019 
*/ 

/* 
* Início 
* 17/06/2019 -> Tanair 
*/ 

ALTER TABLE `promac`.`incentivador_projeto` 
ADD COLUMN `edital` INT NULL COMMENT '' AFTER `numero_parcelas`,
ADD COLUMN `imposto` VARCHAR(5) NULL COMMENT '' AFTER `edital`;


/* 
* FIM -> Tanair
* 17/06/2019 
*/ 
