USE `promac`;

ALTER TABLE projeto ADD dataParecerista DATE NOT NULL AFTER idStatusParecerista

CREATE TABLE IF NOT EXISTS `promac`.`agendamento` (
 `id` INT NOT NULL AUTO_INCREMENT,
  `linkAgendamento` VARCHAR(45) NOT NULL,
  `data` DATE NULL,
  PRIMARY KEY (`id`)
);