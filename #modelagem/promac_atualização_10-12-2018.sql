USE `promac`;

ALTER TABLE `projeto` ADD `dataParecerista` DATE NOT NULL AFTER `idStatusParecerista`;

CREATE TABLE IF NOT EXISTS `promac`.`agendamento` (
 `id` INT NOT NULL AUTO_INCREMENT,
  `linkAgendamento` VARCHAR(150) NOT NULL,
  `data` DATE NULL,
  PRIMARY KEY (`id`)
);

ALTER TABLE `historico_reuniao` CHANGE `idStatus` `idEtapaProjeto` INT(11) NOT NULL;