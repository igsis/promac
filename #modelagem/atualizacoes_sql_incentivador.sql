
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


ALTER TABLE `etapas_incentivo` CHANGE `idProjeto` `idProjeto` INT(11) NULL DEFAULT NULL;


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

/* 
* Início -> Tanair 
* 18/06/2019 
*/ 

ALTER TABLE pessoa_fisica ADD nacionalidade_id TINYINT(3) NOT NULL AFTER cooperado, ADD estado_civil VARCHAR(45) NOT NULL AFTER nacionalidade_id, ADD profissao VARCHAR(100) NOT NULL AFTER estado_civil;


ALTER TABLE incentivador_pessoa_fisica ADD nacionalidade_id TINYINT(3) NOT NULL AFTER email, ADD estado_civil VARCHAR(45) NOT NULL AFTER nacionalidade_id, ADD profissao VARCHAR(100) NOT NULL AFTER estado_civil;


CREATE TABLE nacionalidades (
id int(3) NOT NULL,
nacionalidade varchar(115) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


INSERT INTO nacionalidades (id, nacionalidade) VALUES
(1, 'Brasileiro'),
(2, 'Afegão'),
(3, 'Alemão'),
(4, 'Americano'),
(5, 'Angolano'),
(6, 'Antiguano'),
(7, 'Árabe'),
(8, 'Argélia'),
(9, 'Argentino'),
(10, 'Armeno'),
(11, 'Australiano'),
(12, 'Austríaco'),
(13, 'Bahamense'),
(14, 'Bangladesh'),
(15, 'Barbadiano/Barbadense'),
(16, 'Bechuano'),
(17, 'Belga'),
(18, 'Belizenho'),
(19, 'Boliviano'),
(20, 'Britânico'),
(21, 'Camaronense'),
(22, 'Canadense'),
(23, 'Catariano'),
(24, 'Chileno'),
(25, 'Chinês'),
(26, 'Cingalês'),
(27, 'Colombiano'),
(28, 'Comorense'),
(29, 'Costarriquenho'),
(30, 'Croata'),
(31, 'Cubano'),
(32, 'Dinamarquês'),
(33, 'Dominicana'),
(34, 'Dominicano'),
(35, 'Egípcio'),
(36, 'Equatoriano'),
(37, 'Escocês'),
(38, 'Eslovaco'),
(39, 'Esloveno'),
(40, 'Espanhol'),
(41, 'Francês'),
(42, 'Galês'),
(43, 'Ganês'),
(44, 'Granadino'),
(45, 'Grego'),
(46, 'Guatemalteco'),
(47, 'Guianense'),
(48, 'Guianês'),
(49, 'Haitiano'),
(50, 'Holandês'),
(51, 'Hondurenho'),
(52, 'Húngaro'),
(53, 'Iemenita'),
(54, 'Indiano'),
(55, 'Indonésio'),
(56, 'Inglês'),
(57, 'Iraniano'),
(58, 'Iraquiano'),
(59, 'Irlandês'),
(60, 'Israelita'),
(61, 'Italiano'),
(62, 'Jamaicano'),
(63, 'Japonês'),
(64, 'Líbio'),
(65, 'Malaio'),
(66, 'Marfinense'),
(67, 'Marroquino'),
(68, 'Mexicano'),
(69, 'Moçambicano'),
(70, 'Neozelandês'),
(71, 'Nepalês'),
(72, 'Nicaraguense'),
(73, 'Nigeriano'),
(74, 'Norte-coreano/Coreano'),
(75, 'Norueguês'),
(76, 'Omanense'),
(77, 'Palestino'),
(78, 'Panamenho'),
(79, 'Paquistanês'),
(80, 'Paraguaio'),
(81, 'Peruano'),
(82, 'Polonês'),
(83, 'Porto-riquenho'),
(84, 'Português'),
(85, 'Queniano'),
(86, 'Romeno'),
(87, 'Ruandês'),
(88, 'Russo'),
(89, 'Salvadorenho'),
(90, 'Santa-lucense'),
(91, 'São-cristovense'),
(92, 'São-vicentino'),
(93, 'Saudita'),
(94, 'Sérvio'),
(95, 'Sírio'),
(96, 'Somali'),
(97, 'Sueco'),
(98, 'Suíço'),
(99, 'Sul-africano'),
(100, 'Sul-coreano/Coreano'),
(101, 'Surinamês'),
(102, 'Tailandês'),
(103, 'Timorense/Maubere'),
(104, 'Trindadense'),
(105, 'Turco'),
(106, 'Ucraniano'),
(107, 'Ugandense'),
(108, 'Uruguaio'),
(109, 'Venezuelano'),
(110, 'Vietnamita'),
(111, 'Zimbabuense');


ALTER TABLE `incentivador_projeto` ADD `data_recebimento_carta` DATE NULL AFTER `imposto`;


/* 
* FIM -> Tanair
* 18/06/2019
*/


/*
* Início -> Tanair
* 02/07/2019
*/


ALTER TABLE `projeto` CHANGE `contaMovimentacao` `contaMovimentacao` 
VARCHAR(45) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL, 
CHANGE `contaCaptacao` `contaCaptacao` VARCHAR(45) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;

INSERT INTO lista_documento (idListaDocumento, idTipoUpload, documento, sigla, publicado) 
VALUES 
(55, 3, "Comprovante de déposito por parcela", "cdp", 1), 
(56, 3, "Extrato da conta do projeto", "ecp", 1);


/*
* FIM -> Tanair 
* 02/07/2019 
*/


