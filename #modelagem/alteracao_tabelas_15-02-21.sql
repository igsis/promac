ALTER TABLE `locais_realizacao`
    ADD COLUMN `observacaoLocal` TEXT NULL DEFAULT NULL AFTER `idDistrito`;

ALTER TABLE `projeto`
    CHANGE COLUMN `avaliaProjeto` `avaliaProjeto` TINYINT(1) NULL DEFAULT '0' AFTER `verificadoComissao`;