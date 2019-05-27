
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