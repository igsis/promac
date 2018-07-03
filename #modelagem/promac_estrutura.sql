-- phpMyAdmin SQL Dump
-- version 4.2.12deb2+deb8u2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 03-Jul-2018 às 13:37
-- Versão do servidor: 5.5.53-0+deb8u1
-- PHP Version: 5.6.29-0+deb8u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `promac`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `pr_atualizaCampos`()
BEGIN
    SET SQL_SAFE_UPDATES = 0;
    UPDATE projeto SET 
      exposicaoMarca = ''
    WHERE exposicaoMarca is null;  
    
    UPDATE projeto SET 
      resumoProjeto = ''
    WHERE resumoProjeto is null;  
    
    UPDATE projeto SET 
      curriculo = ''
    WHERE curriculo is null;  
    
    UPDATE projeto SET 
      descricao = ''
    WHERE descricao is null;  
    
    UPDATE projeto SET 
      justificativa = ''
    WHERE justificativa is null;  
    
    UPDATE projeto SET 
      objetivo = ''
    WHERE objetivo is null;         
    
    UPDATE projeto SET 
      metodologia = ''
    WHERE metodologia is null;         
    
    UPDATE projeto SET 
      contrapartida = ''
    WHERE contrapartida is null;       
    
    UPDATE projeto SET 
      publicoAlvo = ''
    WHERE publicoAlvo is null;       
    
    UPDATE projeto SET 
      planoDivulgacao = ''
    WHERE planoDivulgacao is null;    
    
    UPDATE projeto SET 
      inicioCronograma = ''
    WHERE inicioCronograma is null;    
    
    UPDATE projeto SET 
      fimCronograma = ''
    WHERE fimCronograma is null;    
    
    UPDATE projeto SET 
      video1 = ''
    WHERE video1 is null;    
    
    UPDATE projeto SET 
      video2 = ''
    WHERE video2 is null;    
    
    UPDATE projeto SET 
      video3 = ''
    WHERE video3 is null;    
    
    UPDATE projeto SET 
      protocolo = ''
    WHERE protocolo is null;   
    
    UPDATE projeto SET 
      envioComissao = 0
    WHERE envioComissao is null;   
    
    UPDATE projeto SET 
      protocolo = ''
    WHERE protocolo is null;      
    
    UPDATE projeto SET 
      contratoGestao = 0
    WHERE contratoGestao is null;            
    
  END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `pr_exclui_iguais`()
BEGIN 
    DELETE FROM weblogs
      WHERE strcmp(antes, depois) = 0;
  END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `pr_limpa_null`()
BEGIN 
    DELETE FROM weblogs 
      WHERE antes IS NULL
      AND   depois IS NULL;
  END$$

--
-- Functions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `fn_busca_registro`(`doc` VARCHAR(18), `registro` INT, `idCrono` INT, `tabela` VARCHAR(50)) RETURNS varchar(150) CHARSET utf8
BEGIN            
  IF(length(doc) = 14 and tabela = 'pessoa_fisica') THEN 
    SET @alteradoPor = (
      SELECT 
        alteradoPor
      FROM pessoa_fisica AS pf 
      
      INNER JOIN weblogs as log
      ON pf.cpf = doc limit 1); 

      RETURN @alteradoPor;
  END IF;
    
  IF(length(doc) = 14 and tabela = 'incentivador_pessoa_fisica') THEN 
    SET @alteradoPor = (
      SELECT 
        alteradoPor
      FROM incentivador_pessoa_fisica AS ipf 
      INNER JOIN weblogs as log
      ON ipf.cpf = doc limit 1); 

    RETURN @alteradoPor;
  END IF;
      
    
  IF(length(doc) = 18) THEN  
    SET @alteradoPor = (
      SELECT 
        alteradoPor
      FROM pessoa_juridica AS pj 
      INNER JOIN weblogs as log
      ON pj.cnpj = doc limit 1); 

      RETURN @alteradoPor;
  END IF; 
   
  IF(idCrono > 0) THEN  
    SET @alteradoPor = (
      SELECT 
        c.alteradoPor          
      FROM cronograma AS c         
      WHERE c.idCronograma = idCrono LIMIT 1); 

      RETURN @alteradoPor;
  END IF; 
   
  SET @alteradoPor = (
    SELECT 
      p.alteradoPor
    FROM projeto AS p
    WHERE p.idProjeto = registro
    LIMIT 1); 
        
    RETURN @alteradoPor;    
  END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `area_atuacao`
--

CREATE TABLE IF NOT EXISTS `area_atuacao` (
`idArea` int(10) unsigned NOT NULL,
  `areaAtuacao` varchar(255) DEFAULT NULL,
  `tipo` tinyint(1) DEFAULT NULL COMMENT 'PJ e PF = 1 | PF = 1 | PJ = 2',
  `publicado` tinyint(1) DEFAULT '1'
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `cronograma`
--

CREATE TABLE IF NOT EXISTS `cronograma` (
`idCronograma` int(10) unsigned NOT NULL,
  `captacaoRecurso` varchar(50) DEFAULT NULL,
  `preProducao` varchar(50) DEFAULT NULL,
  `producao` varchar(50) DEFAULT NULL,
  `posProducao` varchar(50) DEFAULT NULL,
  `prestacaoContas` varchar(50) DEFAULT NULL,
  `alteradoPor` varchar(150) DEFAULT 'none'
) ENGINE=InnoDB AUTO_INCREMENT=78 DEFAULT CHARSET=utf8;

--
-- Acionadores `cronograma`
--
DELIMITER //
CREATE TRIGGER `tr_cronograma` AFTER UPDATE ON `cronograma`
 FOR EACH ROW INSERT INTO weblogs(tabela, acao, idCronograma, dataOcorrencia, antes, depois)     
    
    VALUES('cronograma', 'UPDATE', new.idCronograma, now(), 
      
      concat('CAP-RECURSO: ',old.captacaoRecurso,      
       '|','PRODUCAO: ',old.preProducao,
       '|','PRE-PRODUCAO: ',old.producao,
       '|','POS-PRODUCAO: ',old.posProducao,
       '|','PREST-CONTA: ',old.prestacaoContas
      ),
      
      concat('CAP-RECURSO: ',new.captacaoRecurso,      
       '|','PRODUCAO: ',new.preProducao,
       '|','PRE-PRODUCAO: ',new.producao,
       '|','POS-PRODUCAO: ',new.posProducao,
       '|','PREST-CONTA: ',new.prestacaoContas      
      
      ))
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `distrito`
--

CREATE TABLE IF NOT EXISTS `distrito` (
`idDistrito` int(10) NOT NULL,
  `distrito` varchar(25) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=97 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `etapa`
--

CREATE TABLE IF NOT EXISTS `etapa` (
`idEtapa` int(11) NOT NULL,
  `etapa` varchar(70) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `ficha_tecnica`
--

CREATE TABLE IF NOT EXISTS `ficha_tecnica` (
`idFichaTecnica` int(10) unsigned NOT NULL,
  `idProjeto` int(10) unsigned NOT NULL,
  `nome` varchar(150) DEFAULT NULL,
  `cpf` char(14) DEFAULT NULL,
  `funcao` varchar(50) DEFAULT NULL,
  `publicado` tinyint(1) DEFAULT NULL,
  `alteradoPor` varchar(150) DEFAULT 'none'
) ENGINE=InnoDB AUTO_INCREMENT=370 DEFAULT CHARSET=utf8;

--
-- Acionadores `ficha_tecnica`
--
DELIMITER //
CREATE TRIGGER `tr_ficha_tecnica` AFTER UPDATE ON `ficha_tecnica`
 FOR EACH ROW INSERT INTO weblogs(tabela, acao, idRegistro, dataOcorrencia, antes, depois)     
    
    VALUES('ficha_tecnica', 'UPDATE', new.idProjeto, now(), 
      
      concat('NOME',old.nome,      
       '|','CPF:',old.cpf,
       '|','FUNCAO:',old.funcao,
       '|','PUBLICADO:',old.publicado       
      ),
      
      concat('NOME',new.nome,      
       '|','CPF:',new.cpf,
       '|','FUNCAO:',new.funcao,
       '|','PUBLICADO:',new.publicado             
      
      ))
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `frase_seguranca`
--

CREATE TABLE IF NOT EXISTS `frase_seguranca` (
`id` int(11) NOT NULL,
  `frase_seguranca` varchar(60) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `incentivador_pessoa_fisica`
--

CREATE TABLE IF NOT EXISTS `incentivador_pessoa_fisica` (
`idPf` int(10) unsigned NOT NULL,
  `nome` varchar(150) DEFAULT NULL,
  `cpf` char(14) NOT NULL,
  `rg` varchar(20) DEFAULT '',
  `logradouro` varchar(150) DEFAULT '',
  `bairro` varchar(30) DEFAULT '',
  `cidade` varchar(50) DEFAULT '',
  `estado` varchar(2) DEFAULT '',
  `cep` varchar(9) DEFAULT '',
  `numero` int(5) DEFAULT '0',
  `complemento` varchar(15) DEFAULT '',
  `telefone` varchar(15) DEFAULT '',
  `celular` varchar(15) DEFAULT '',
  `email` varchar(50) DEFAULT NULL,
  `liberado` tinyint(4) DEFAULT '0',
  `senha` varchar(60) DEFAULT NULL,
  `idNivelAcesso` int(11) DEFAULT '1',
  `idFraseSeguranca` int(11) DEFAULT NULL,
  `respostaFrase` varchar(10) DEFAULT NULL,
  `dataInscricao` datetime DEFAULT '0000-00-00 00:00:00',
  `alteradoPor` varchar(150) DEFAULT ''
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

--
-- Acionadores `incentivador_pessoa_fisica`
--
DELIMITER //
CREATE TRIGGER `tr_log_incentivador_pf` AFTER UPDATE ON `incentivador_pessoa_fisica`
 FOR EACH ROW INSERT INTO  weblogs(tabela, acao, idRegistro, documento, dataOcorrencia,  antes, depois)     
    
    VALUES('incentivador_pessoa_fisica', 'UPDATE', new.idPf, new.cpf, now(),        
      concat('NOME:',old.nome,
        '|','CPF:',old.cpf,
        '|','RG:',old.rg,
        '|','Logradouro:',old.logradouro,
        '|','BAIRRO:',old.bairro,
        '|','CIDADE:',old.cidade,
        '|','ESTADO:',old.estado,
        '|','NUMERO:',old.numero,
        '|','CEP:',old.cep,
        '|','Complemento:',old.complemento,
        '|','Telefone:',old.telefone,
        '|','Celuar:',old.celular,
        '|','EMAIL:',old.email,        
        '|','Liberado:',old.liberado,
        '|','SENHA:',old.senha,
        '|','NivelAcesso:',old.idNivelAcesso,
        '|','FraseSegura:',old.idFraseSeguranca,
        '|','Resposta:',old.respostaFrase                 
         ),
         
     concat('NOME:',new.nome,
     '|','CPF:',new.cpf,
     '|','RG:',new.rg,
     '|','Logradouro:',new.logradouro,
     '|','BAIRRO:',new.bairro,
     '|','CIDADE:',new.cidade,
     '|','ESTADO:',new.estado,
     '|','NUMERO:',new.numero,
     '|','CEP:',new.cep,
     '|','Complemento:',new.complemento,
     '|','Telefone:',new.telefone,
     '|','Celuar:',new.celular,
     '|','EMAIL:',new.email,     
     '|','Liberado:',new.liberado,
     '|','SENHA:',new.senha,
     '|','NivelAcesso:',new.idNivelAcesso,
     '|','FraseSegura:',new.idFraseSeguranca,
     '|','Resposta:',new.respostaFrase
     
    ))
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `incentivador_pessoa_juridica`
--

CREATE TABLE IF NOT EXISTS `incentivador_pessoa_juridica` (
`idPj` int(10) unsigned NOT NULL,
  `razaoSocial` varchar(150) DEFAULT NULL,
  `cnpj` char(18) NOT NULL,
  `logradouro` varchar(150) DEFAULT '',
  `bairro` varchar(30) DEFAULT '',
  `cidade` varchar(50) DEFAULT '',
  `estado` char(2) DEFAULT '',
  `cep` char(9) DEFAULT '',
  `numero` int(5) DEFAULT '0',
  `complemento` varchar(15) DEFAULT '',
  `telefone` varchar(15) DEFAULT '',
  `celular` varchar(15) DEFAULT '',
  `email` varchar(50) DEFAULT NULL,
  `idRepresentanteLegal` int(10) unsigned DEFAULT '0',
  `liberado` tinyint(1) DEFAULT '0',
  `senha` varchar(60) DEFAULT NULL,
  `idNivelAcesso` int(11) DEFAULT '1',
  `idFraseSeguranca` int(11) DEFAULT NULL,
  `respostaFrase` varchar(10) DEFAULT NULL,
  `dataInscricao` datetime DEFAULT '0000-00-00 00:00:00',
  `alteradoPor` varchar(150) DEFAULT ''
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8;

--
-- Acionadores `incentivador_pessoa_juridica`
--
DELIMITER //
CREATE TRIGGER `tr_log_incentivador_pj` AFTER UPDATE ON `incentivador_pessoa_juridica`
 FOR EACH ROW INSERT INTO  weblogs(tabela, acao, idRegistro, documento, dataOcorrencia,  antes, depois)     
    
    VALUES('incentivador_pessoa_juridica', 'UPDATE', new.idPj, new.cnpj, now(),        
      concat('NOME:',old.razaoSocial,
			'|','CNPJ:', old.cnpj,
            '|','LOGRADOURO:', old.logradouro,
            '|','BAIRRO:', old.bairro,
            '|','CIDADE:', old.cidade,
            '|','ESTADO:', old.estado,
            '|','CEP:', old.cep,
            '|','NUMERO:', old.numero,
            '|','COMPLE:', old.complemento,
            '|','TELEFONE:', old.telefone,
            '|','CELULAR:', old.celular,
            '|','EMAIL:', old.email,
            '|','ID-REPRESENT:', old.idRepresentanteLegal,
            '|','LIBERADO:', old.liberado,
            '|','SENHA:', old.senha,
            '|','ID-NIV-ACESS:', old.idNivelAcesso,
            '|','FRASE-SEGUR:', old.idFraseSeguranca,
            '|','RESP-FRASE:', old.respostaFrase,
            '|','DT-INSCRICAO:', old.dataInscricao
         ),
         
     concat('NOME:',new.razaoSocial,
            '|','CNPJ:', new.cnpj,
            '|','LOGRADOURO:', new.logradouro,
            '|','BAIRRO:', new.bairro,
            '|','CIDADE:', new.cidade,
            '|','ESTADO:', new.estado,
            '|','CEP:', new.cep,
            '|','NUMERO:', new.numero,
            '|','COMPLE:', new.complemento,
            '|','TELEFONE:', new.telefone,
            '|','CELULAR:', new.celular,
            '|','EMAIL:', new.email,
            '|','ID-REPRESENT:', new.idRepresentanteLegal,
            '|','LIBERADO:', new.liberado,
            '|','SENHA:', new.senha,
            '|','ID-NIV-ACESS:', new.idNivelAcesso,
            '|','FRASE-SEGUR:', new.idFraseSeguranca,
            '|','RESP-FRASE:', new.respostaFrase,
            '|','DT-INSCRICAO:', new.dataInscricao     
    ))
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `lista_documento`
--

CREATE TABLE IF NOT EXISTS `lista_documento` (
`idListaDocumento` int(10) unsigned NOT NULL,
  `idTipoUpload` int(11) DEFAULT NULL,
  `documento` varchar(255) DEFAULT NULL,
  `sigla` varchar(10) DEFAULT NULL,
  `publicado` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `locais_realizacao`
--

CREATE TABLE IF NOT EXISTS `locais_realizacao` (
`idLocaisRealizacao` int(10) unsigned NOT NULL,
  `idProjeto` int(10) unsigned NOT NULL,
  `local` varchar(100) DEFAULT NULL,
  `estimativaPublico` int(11) DEFAULT NULL,
  `idZona` int(11) DEFAULT NULL,
  `idSubprefeitura` int(11) DEFAULT NULL,
  `idDistrito` int(11) DEFAULT NULL,
  `publicado` tinyint(1) DEFAULT NULL,
  `alteradoPor` varchar(150) DEFAULT 'none'
) ENGINE=InnoDB AUTO_INCREMENT=173 DEFAULT CHARSET=utf8;

--
-- Acionadores `locais_realizacao`
--
DELIMITER //
CREATE TRIGGER `tr_log_locais` AFTER UPDATE ON `locais_realizacao`
 FOR EACH ROW INSERT INTO weblogs(tabela, acao, idRegistro, dataOcorrencia, antes, depois)     
    
    VALUES('locais', 'UPDATE', new.idProjeto, now(), 
      concat('PROJETO',old.idProjeto,      
       '|','LOCAL:',old.local,
       '|','PUBLICO ESTIMADO:',old.estimativaPublico,
       '|','ZONA:',old.idZona,
       '|','SUBPREFEITURA:',old.idSubprefeitura,
       '|','DISTRITO:',old.idDistrito,
       '|','PUBLICADO:',old.publicado       
      ),
      
      concat('PROJETO',new.idProjeto,      
       '|','LOCAL:',new.local,
       '|','PUBLICO ESTIMADO:',new.estimativaPublico,
       '|','ZONA:',new.idZona,
       '|','SUBPREFEITURA:',new.idSubprefeitura,
       '|','DISTRITO:',new.idDistrito,
       '|','PUBLICADO:',new.publicado            
      ))
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `log`
--

CREATE TABLE IF NOT EXISTS `log` (
`id` int(11) NOT NULL,
  `idUsuario` int(11) DEFAULT NULL,
  `enderecoIP` varchar(20) DEFAULT NULL,
  `dataLog` datetime DEFAULT NULL,
  `descricao` longtext
) ENGINE=InnoDB AUTO_INCREMENT=13241 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `nivel_acesso`
--

CREATE TABLE IF NOT EXISTS `nivel_acesso` (
`idNivelAcesso` int(11) NOT NULL,
  `nivelAcesso` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `notas`
--

CREATE TABLE IF NOT EXISTS `notas` (
`idNotas` int(10) unsigned NOT NULL,
  `idProjeto` int(11) DEFAULT NULL,
  `data` datetime DEFAULT NULL,
  `nota` longtext,
  `interna` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `orcamento`
--

CREATE TABLE IF NOT EXISTS `orcamento` (
`idOrcamento` int(10) unsigned NOT NULL,
  `idProjeto` int(11) DEFAULT NULL,
  `idEtapa` int(11) DEFAULT NULL,
  `observacoesEtapa` varchar(255) DEFAULT NULL,
  `descricao` varchar(255) DEFAULT NULL,
  `quantidade` int(11) DEFAULT NULL,
  `idUnidadeMedida` int(11) DEFAULT NULL,
  `quantidadeUnidade` int(11) DEFAULT NULL,
  `valorUnitario` decimal(9,2) DEFAULT NULL,
  `valorTotal` decimal(9,2) DEFAULT NULL,
  `observacoes` varchar(255) DEFAULT NULL,
  `publicado` tinyint(1) DEFAULT NULL,
  `alteradoPor` varchar(150) DEFAULT 'none'
) ENGINE=InnoDB AUTO_INCREMENT=2356 DEFAULT CHARSET=utf8;

--
-- Acionadores `orcamento`
--
DELIMITER //
CREATE TRIGGER `tr_log_orcamento` AFTER UPDATE ON `orcamento`
 FOR EACH ROW INSERT INTO weblogs(tabela, acao, idRegistro, dataOcorrencia, antes, depois)     
    
    VALUES('orcamento', 'UPDATE', new.idProjeto, now(), 
      concat('PROJETO',old.idProjeto,      
       '|','ETAPA:',old.idEtapa,
       '|','OBS ETAPA:',old.observacoesEtapa,
       '|','DESCRICAO:',old.descricao,	
       '|','QTD:',old.quantidade,       
       '|','UND.MEDIDA:',old.idUnidadeMedida,
       '|','QTD-UND.:',old.quantidadeUnidade,
       '|','V.UNITARIO:',old.valorUnitario,
       '|','V.TOTAL:',old.valorUnitario,
       '|','OBS:',old.observacoes,       
       '|','PUBLICADO:',old.publicado
      ),
      
      concat('PROJETO',new.idProjeto,      
       '|','ETAPA:',new.idEtapa,
       '|','OBS ETAPA:',new.observacoesEtapa,
       '|','DESCRICAO:',new.descricao,	
       '|','QTD:',new.quantidade,
       '|','UND.MEDIDA:',new.idUnidadeMedida,
       '|','QTD-UND.:',new.quantidadeUnidade,       
       '|','V.UNITARIO:',new.valorUnitario,
       '|','V.TOTAL:',new.valorUnitario,
       '|','OBS:',new.observacoes,       
       '|','PUBLICADO:',new.publicado       
      
      ))
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `pessoa_fisica`
--

CREATE TABLE IF NOT EXISTS `pessoa_fisica` (
`idPf` int(10) unsigned NOT NULL,
  `nome` varchar(150) DEFAULT NULL,
  `cpf` char(14) NOT NULL,
  `rg` varchar(20) DEFAULT NULL,
  `telefone` varchar(15) DEFAULT NULL,
  `celular` varchar(15) DEFAULT NULL,
  `logradouro` varchar(150) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `bairro` varchar(30) DEFAULT NULL,
  `cidade` varchar(50) DEFAULT NULL,
  `estado` char(2) DEFAULT NULL,
  `cep` char(9) DEFAULT NULL,
  `numero` int(5) DEFAULT NULL,
  `complemento` varchar(15) DEFAULT NULL,
  `idZona` int(11) NOT NULL,
  `idSubprefeitura` int(11) NOT NULL,
  `idDistrito` int(11) NOT NULL,
  `cooperado` tinyint(1) DEFAULT NULL,
  `liberado` tinyint(1) DEFAULT NULL,
  `senha` varchar(60) DEFAULT NULL,
  `idNivelAcesso` int(11) DEFAULT '1',
  `idFraseSeguranca` int(11) DEFAULT NULL,
  `respostaFrase` varchar(10) DEFAULT NULL,
  `dataInscricao` datetime DEFAULT NULL,
  `alteradoPor` varchar(150) DEFAULT 'none'
) ENGINE=InnoDB AUTO_INCREMENT=264 DEFAULT CHARSET=utf8;

--
-- Acionadores `pessoa_fisica`
--
DELIMITER //
CREATE TRIGGER `tr_log_pessoa_fisica` AFTER UPDATE ON `pessoa_fisica`
 FOR EACH ROW INSERT INTO  weblogs(tabela, acao, idRegistro, documento, dataOcorrencia,  antes, depois)     
    
    VALUES('pessoa_fisica', 'UPDATE', new.idPf, new.cpf, now(),  
      concat('Nome:',old.nome,'|','CPF:',old.cpf,'|','RG:',old.rg,'|','Logradouro:',old.logradouro,'|','Bairro:',old.bairro,'|','Cidade:',old.cidade,
             '|','Estado:',old.estado,'|','Numero:',old.numero,'|','Cep:',old.cep,'|','Complemento:',old.complemento,'|','Telefone:',old.telefone,
             '|','Celuar:',old.celular,'|','Email:',old.email,'|','Cooperado:',old.cooperado,'|','Liberado:',old.liberado,'|','Senha:',old.senha,
             '|','NivelAcesso:',old.idNivelAcesso,'|','FraseSegura:',old.idFraseSeguranca,'|','Resposta:',old.respostaFrase,'|','|','Zona:',old.idZona,
             '|','Subprefeitura:',old.idSubprefeitura,'|','Distrito:',old.idDistrito),                                                                               
             
     concat('Nome:',new.nome,'|','CPF:',new.cpf,'|','RG:',new.rg,'|','Logradouro:',new.logradouro,'|','Bairro:',new.bairro,'|','Cidade:',new.cidade,
             '|','Estado:',new.estado,'|','Numero:',new.numero,'|','Cep:',new.cep,'|','Complemento:',new.complemento,'|','Telefone:',new.telefone,
             '|','Celuar:',new.celular,'|','Email:',new.email,'|','Cooperado:',new.cooperado,'|','Liberado:',new.liberado,'|','Senha:',new.senha,
             '|','NivelAcesso:',new.idNivelAcesso,'|','FraseSegura:',new.idFraseSeguranca,'|','Resposta:',new.respostaFrase,'|','|','Zona:',new.idZona,
             '|','Subprefeitura:',new.idSubprefeitura,'|','Distrito:',new.idDistrito))
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `pessoa_juridica`
--

CREATE TABLE IF NOT EXISTS `pessoa_juridica` (
`idPj` int(10) unsigned NOT NULL,
  `razaoSocial` varchar(150) DEFAULT NULL,
  `cnpj` char(18) NOT NULL,
  `telefone` varchar(15) DEFAULT NULL,
  `celular` varchar(15) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `logradouro` varchar(150) DEFAULT NULL,
  `bairro` varchar(30) DEFAULT NULL,
  `cidade` varchar(50) DEFAULT NULL,
  `estado` char(2) DEFAULT NULL,
  `cep` char(9) DEFAULT NULL,
  `numero` int(5) DEFAULT NULL,
  `complemento` varchar(15) DEFAULT NULL,
  `idZona` int(11) NOT NULL,
  `idSubprefeitura` int(11) NOT NULL,
  `idDistrito` int(11) NOT NULL,
  `cooperativa` tinyint(1) DEFAULT NULL,
  `idRepresentanteLegal` int(10) unsigned DEFAULT NULL,
  `liberado` tinyint(1) DEFAULT NULL,
  `senha` varchar(60) DEFAULT NULL,
  `idNivelAcesso` int(11) DEFAULT '1',
  `idFraseSeguranca` int(11) DEFAULT NULL,
  `respostaFrase` varchar(10) DEFAULT NULL,
  `dataInscricao` datetime DEFAULT NULL,
  `alteradoPor` varchar(150) DEFAULT 'none'
) ENGINE=InnoDB AUTO_INCREMENT=473 DEFAULT CHARSET=utf8;

--
-- Acionadores `pessoa_juridica`
--
DELIMITER //
CREATE TRIGGER `tr_log_pessoa_juridica` AFTER UPDATE ON `pessoa_juridica`
 FOR EACH ROW INSERT INTO  weblogs(tabela, acao, idRegistro, documento, dataOcorrencia,  antes, depois)     
    
    VALUES('pessoa_juridica', 'UPDATE', new.idPj, new.cnpj, now(),  
      concat('RAZAO:',old.razaoSocial,'|','CNPJ:',old.cnpj,'|','TELEFONE:',old.telefone,'|','CELULAR:',old.celular,'|','EMAIL:',old.email,
      '|','LOGRADOURO:',old.logradouro,'|','BAIRRO:',old.bairro,'|','CIDADE:',old.cidade,'|','ESTADO:',old.estado,'|','CEP:',old.cep,
      '|','NUMERO:',old.numero,'|','COMPLEMENTO:',old.complemento,'|','ZONA:',old.idZona,'|','SUBPREFEITURA:',old.idSubprefeitura,
      '|','DISTRITO:',old.idDistrito,'|','COOPERATIVA:',old.cooperativa,'|','REPRESENTANTE:',old.idRepresentanteLegal,'|','LIBERADO:',old.liberado,
      '|','SENHA:',old.senha,'|','NIVEL:',old.idNivelAcesso,'|','FRASE:',old.idFraseSeguranca,'|','RESPOSTA:',old.respostaFrase
      ),
      concat('RAZAO:',new.razaoSocial,'|','CNPJ:',new.cnpj,'|','TELEFONE:',new.telefone,'|','CELULAR:',new.celular,'|','EMAIL:',new.email,
      '|','LOGRADOURO:',new.logradouro,'|','BAIRRO:',new.bairro,'|','CIDADE:',new.cidade,'|','ESTADO:',new.estado,'|','CEP:',new.cep,
      '|','NUMERO:',new.numero,'|','COMPLEMENTO:',new.complemento,'|','ZONA:',new.idZona,'|','SUBPREFEITURA:',new.idSubprefeitura,
      '|','DISTRITO:',new.idDistrito,'|','COOPERATIVA:',new.cooperativa,'|','REPRESENTANTE:',new.idRepresentanteLegal,'|','LIBERADO:',new.liberado,
      '|','SENHA:',new.senha,'|','NIVEL:',new.idNivelAcesso,'|','FRASE:',new.idFraseSeguranca,'|','RESPOSTA:',new.respostaFrase
      ))
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `prazos_projeto`
--

CREATE TABLE IF NOT EXISTS `prazos_projeto` (
`idPrazo` int(10) unsigned NOT NULL,
  `idProjeto` int(11) DEFAULT NULL,
  `prazoCaptacao` date DEFAULT NULL,
  `prorrogacaoCaptacao` tinyint(1) DEFAULT NULL,
  `finalCaptacao` date DEFAULT NULL,
  `inicioExecucao` date DEFAULT NULL,
  `fimExecucao` date DEFAULT NULL,
  `prorrogacaoExecucao` tinyint(1) DEFAULT NULL,
  `finalProjeto` date DEFAULT NULL,
  `prestarContas` date DEFAULT NULL,
  `publicado` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `projeto`
--

CREATE TABLE IF NOT EXISTS `projeto` (
`idProjeto` int(10) unsigned NOT NULL,
  `protocolo` varchar(15) DEFAULT NULL,
  `tipoPessoa` tinyint(1) DEFAULT NULL COMMENT '1 - pessoa física\n2 - pessoa jurídica',
  `idpj` int(11) DEFAULT '0',
  `contratoGestao` tinyint(1) DEFAULT NULL,
  `idpf` int(11) DEFAULT '0',
  `nomeProjeto` varchar(200) DEFAULT NULL,
  `idAreaAtuacao` int(11) DEFAULT NULL,
  `valorprojeto` decimal(9,2) DEFAULT '0.00',
  `valorIncentivo` decimal(9,2) DEFAULT '0.00',
  `valorFinanciamento` decimal(9,2) DEFAULT '0.00',
  `idRenunciaFiscal` int(11) DEFAULT '4',
  `exposicaoMarca` longtext,
  `resumoProjeto` longtext,
  `curriculo` longtext,
  `descricao` longtext,
  `justificativa` longtext,
  `objetivo` longtext,
  `metodologia` longtext,
  `contrapartida` longtext,
  `publicoAlvo` longtext,
  `planoDivulgacao` longtext,
  `inicioCronograma` varchar(100) DEFAULT NULL,
  `fimCronograma` varchar(100) DEFAULT NULL,
  `idCronograma` int(10) unsigned DEFAULT '0',
  `totalPreProducao` decimal(9,2) DEFAULT '0.00',
  `totalProducao` decimal(9,2) DEFAULT '0.00',
  `totalImprensa` decimal(9,2) DEFAULT '0.00',
  `totalCustosAdministrativos` decimal(9,2) DEFAULT '0.00',
  `totalImpostos` decimal(9,2) DEFAULT '0.00',
  `totalAgenciamento` decimal(9,2) DEFAULT '0.00',
  `totalOutrosFinanciamentos` decimal(9,2) DEFAULT '0.00',
  `video1` varchar(50) DEFAULT NULL,
  `video2` varchar(50) DEFAULT NULL,
  `video3` varchar(50) DEFAULT NULL,
  `valorAprovado` decimal(9,2) DEFAULT '0.00',
  `idStatus` int(11) DEFAULT NULL,
  `publicado` tinyint(1) DEFAULT NULL,
  `envioComissao` datetime DEFAULT NULL,
  `solicitacaoReabertura` datetime DEFAULT NULL,
  `reaberturaProjeto` datetime DEFAULT NULL,
  `alteradoPor` varchar(150) DEFAULT 'none'
) ENGINE=InnoDB AUTO_INCREMENT=144 DEFAULT CHARSET=utf8;

--
-- Acionadores `projeto`
--
DELIMITER //
CREATE TRIGGER `tr_log_projeto` AFTER UPDATE ON `projeto`
 FOR EACH ROW INSERT INTO  weblogs(tabela, acao, idRegistro, dataOcorrencia, antes, depois)     
       
    VALUES('projeto', 'UPDATE', new.idProjeto, now(),  
      concat('NOMEPROJETO:',old.nomeProjeto,      
       '|','ATUACAO:',old.idAreaAtuacao,
       '|','VALOR-P:',old.valorProjeto,
       '|','INCENTIVO:',old.valorIncentivo,
       '|','FINANCIAMENTO:',old.valorFinanciamento,
       '|','RENUNCIA-F:',old.idRenunciaFiscal,      
       '|','EXPOSICAO-M:',old.exposicaoMarca,       
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
        '|','EXPOSICAO-M:',new.exposicaoMarca,
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
      
      ))
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `renuncia_fiscal`
--

CREATE TABLE IF NOT EXISTS `renuncia_fiscal` (
`idRenuncia` int(10) unsigned NOT NULL,
  `renunciaFiscal` varchar(4) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `representante_legal`
--

CREATE TABLE IF NOT EXISTS `representante_legal` (
`idRepresentanteLegal` int(10) unsigned NOT NULL,
  `nome` varchar(150) DEFAULT NULL,
  `cpf` char(14) NOT NULL,
  `rg` varchar(20) DEFAULT NULL,
  `logradouro` varchar(150) DEFAULT NULL,
  `bairro` varchar(30) DEFAULT NULL,
  `cidade` varchar(50) DEFAULT NULL,
  `estado` varchar(50) DEFAULT NULL,
  `cep` char(9) DEFAULT NULL,
  `numero` int(5) DEFAULT NULL,
  `complemento` varchar(15) DEFAULT NULL,
  `telefone` varchar(15) DEFAULT NULL,
  `celular` varchar(15) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=320 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `status`
--

CREATE TABLE IF NOT EXISTS `status` (
`idStatus` int(11) NOT NULL,
  `status` varchar(45) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `statusprojeto`
--

CREATE TABLE IF NOT EXISTS `statusprojeto` (
`idStatus` int(11) NOT NULL,
  `situacaoAtual` int(11) NOT NULL,
  `descricaoSituacao` varchar(20) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `status_documento`
--

CREATE TABLE IF NOT EXISTS `status_documento` (
`idStatusDocumento` int(11) NOT NULL,
  `status` varchar(15) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `subprefeitura`
--

CREATE TABLE IF NOT EXISTS `subprefeitura` (
`idSubprefeitura` int(10) NOT NULL,
  `subprefeitura` varchar(25) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tipo_upload`
--

CREATE TABLE IF NOT EXISTS `tipo_upload` (
  `idTipoUpload` int(10) unsigned NOT NULL,
  `tipo` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `unidade_medida`
--

CREATE TABLE IF NOT EXISTS `unidade_medida` (
`idUnidadeMedida` int(11) NOT NULL,
  `unidadeMedida` varchar(45) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `upload_arquivo`
--

CREATE TABLE IF NOT EXISTS `upload_arquivo` (
`idUploadArquivo` int(10) unsigned NOT NULL,
  `idTipo` int(11) DEFAULT NULL,
  `idPessoa` int(11) DEFAULT NULL,
  `idListaDocumento` int(11) DEFAULT NULL,
  `arquivo` varchar(255) DEFAULT NULL,
  `dataEnvio` datetime DEFAULT NULL,
  `idStatusDocumento` int(11) DEFAULT NULL,
  `observacoes` varchar(150) DEFAULT NULL,
  `publicado` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3353 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `weblogs`
--

CREATE TABLE IF NOT EXISTS `weblogs` (
`idWebLog` int(11) NOT NULL,
  `tabela` varchar(50) DEFAULT NULL,
  `acao` varchar(10) DEFAULT NULL,
  `idRegistro` int(11) DEFAULT NULL,
  `dataOcorrencia` date DEFAULT NULL,
  `antes` mediumtext,
  `depois` mediumtext,
  `documento` char(18) DEFAULT NULL,
  `idCronograma` int(11) DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=2040 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `zona`
--

CREATE TABLE IF NOT EXISTS `zona` (
`idZona` int(10) unsigned NOT NULL,
  `zona` varchar(6) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `area_atuacao`
--
ALTER TABLE `area_atuacao`
 ADD PRIMARY KEY (`idArea`);

--
-- Indexes for table `cronograma`
--
ALTER TABLE `cronograma`
 ADD PRIMARY KEY (`idCronograma`);

--
-- Indexes for table `distrito`
--
ALTER TABLE `distrito`
 ADD PRIMARY KEY (`idDistrito`);

--
-- Indexes for table `etapa`
--
ALTER TABLE `etapa`
 ADD PRIMARY KEY (`idEtapa`);

--
-- Indexes for table `ficha_tecnica`
--
ALTER TABLE `ficha_tecnica`
 ADD PRIMARY KEY (`idFichaTecnica`);

--
-- Indexes for table `frase_seguranca`
--
ALTER TABLE `frase_seguranca`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `incentivador_pessoa_fisica`
--
ALTER TABLE `incentivador_pessoa_fisica`
 ADD PRIMARY KEY (`idPf`);

--
-- Indexes for table `incentivador_pessoa_juridica`
--
ALTER TABLE `incentivador_pessoa_juridica`
 ADD PRIMARY KEY (`idPj`), ADD UNIQUE KEY `email_UNIQUE` (`email`);

--
-- Indexes for table `lista_documento`
--
ALTER TABLE `lista_documento`
 ADD PRIMARY KEY (`idListaDocumento`);

--
-- Indexes for table `locais_realizacao`
--
ALTER TABLE `locais_realizacao`
 ADD PRIMARY KEY (`idLocaisRealizacao`);

--
-- Indexes for table `log`
--
ALTER TABLE `log`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `nivel_acesso`
--
ALTER TABLE `nivel_acesso`
 ADD PRIMARY KEY (`idNivelAcesso`);

--
-- Indexes for table `notas`
--
ALTER TABLE `notas`
 ADD PRIMARY KEY (`idNotas`);

--
-- Indexes for table `orcamento`
--
ALTER TABLE `orcamento`
 ADD PRIMARY KEY (`idOrcamento`);

--
-- Indexes for table `pessoa_fisica`
--
ALTER TABLE `pessoa_fisica`
 ADD PRIMARY KEY (`idPf`);

--
-- Indexes for table `pessoa_juridica`
--
ALTER TABLE `pessoa_juridica`
 ADD PRIMARY KEY (`idPj`), ADD UNIQUE KEY `email_UNIQUE` (`email`);

--
-- Indexes for table `prazos_projeto`
--
ALTER TABLE `prazos_projeto`
 ADD PRIMARY KEY (`idPrazo`);

--
-- Indexes for table `projeto`
--
ALTER TABLE `projeto`
 ADD PRIMARY KEY (`idProjeto`);

--
-- Indexes for table `renuncia_fiscal`
--
ALTER TABLE `renuncia_fiscal`
 ADD PRIMARY KEY (`idRenuncia`);

--
-- Indexes for table `representante_legal`
--
ALTER TABLE `representante_legal`
 ADD PRIMARY KEY (`idRepresentanteLegal`);

--
-- Indexes for table `status`
--
ALTER TABLE `status`
 ADD PRIMARY KEY (`idStatus`);

--
-- Indexes for table `statusprojeto`
--
ALTER TABLE `statusprojeto`
 ADD PRIMARY KEY (`idStatus`);

--
-- Indexes for table `status_documento`
--
ALTER TABLE `status_documento`
 ADD PRIMARY KEY (`idStatusDocumento`);

--
-- Indexes for table `subprefeitura`
--
ALTER TABLE `subprefeitura`
 ADD PRIMARY KEY (`idSubprefeitura`);

--
-- Indexes for table `tipo_upload`
--
ALTER TABLE `tipo_upload`
 ADD PRIMARY KEY (`idTipoUpload`);

--
-- Indexes for table `unidade_medida`
--
ALTER TABLE `unidade_medida`
 ADD PRIMARY KEY (`idUnidadeMedida`);

--
-- Indexes for table `upload_arquivo`
--
ALTER TABLE `upload_arquivo`
 ADD PRIMARY KEY (`idUploadArquivo`);

--
-- Indexes for table `weblogs`
--
ALTER TABLE `weblogs`
 ADD PRIMARY KEY (`idWebLog`), ADD KEY `index_por_ocorrencia` (`dataOcorrencia`);

--
-- Indexes for table `zona`
--
ALTER TABLE `zona`
 ADD PRIMARY KEY (`idZona`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `area_atuacao`
--
ALTER TABLE `area_atuacao`
MODIFY `idArea` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT for table `cronograma`
--
ALTER TABLE `cronograma`
MODIFY `idCronograma` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=78;
--
-- AUTO_INCREMENT for table `distrito`
--
ALTER TABLE `distrito`
MODIFY `idDistrito` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=97;
--
-- AUTO_INCREMENT for table `etapa`
--
ALTER TABLE `etapa`
MODIFY `idEtapa` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `ficha_tecnica`
--
ALTER TABLE `ficha_tecnica`
MODIFY `idFichaTecnica` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=370;
--
-- AUTO_INCREMENT for table `frase_seguranca`
--
ALTER TABLE `frase_seguranca`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `incentivador_pessoa_fisica`
--
ALTER TABLE `incentivador_pessoa_fisica`
MODIFY `idPf` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `incentivador_pessoa_juridica`
--
ALTER TABLE `incentivador_pessoa_juridica`
MODIFY `idPj` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=35;
--
-- AUTO_INCREMENT for table `lista_documento`
--
ALTER TABLE `lista_documento`
MODIFY `idListaDocumento` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=39;
--
-- AUTO_INCREMENT for table `locais_realizacao`
--
ALTER TABLE `locais_realizacao`
MODIFY `idLocaisRealizacao` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=173;
--
-- AUTO_INCREMENT for table `log`
--
ALTER TABLE `log`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13241;
--
-- AUTO_INCREMENT for table `nivel_acesso`
--
ALTER TABLE `nivel_acesso`
MODIFY `idNivelAcesso` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `notas`
--
ALTER TABLE `notas`
MODIFY `idNotas` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `orcamento`
--
ALTER TABLE `orcamento`
MODIFY `idOrcamento` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2356;
--
-- AUTO_INCREMENT for table `pessoa_fisica`
--
ALTER TABLE `pessoa_fisica`
MODIFY `idPf` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=264;
--
-- AUTO_INCREMENT for table `pessoa_juridica`
--
ALTER TABLE `pessoa_juridica`
MODIFY `idPj` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=473;
--
-- AUTO_INCREMENT for table `prazos_projeto`
--
ALTER TABLE `prazos_projeto`
MODIFY `idPrazo` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `projeto`
--
ALTER TABLE `projeto`
MODIFY `idProjeto` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=144;
--
-- AUTO_INCREMENT for table `renuncia_fiscal`
--
ALTER TABLE `renuncia_fiscal`
MODIFY `idRenuncia` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `representante_legal`
--
ALTER TABLE `representante_legal`
MODIFY `idRepresentanteLegal` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=320;
--
-- AUTO_INCREMENT for table `status`
--
ALTER TABLE `status`
MODIFY `idStatus` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `statusprojeto`
--
ALTER TABLE `statusprojeto`
MODIFY `idStatus` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `status_documento`
--
ALTER TABLE `status_documento`
MODIFY `idStatusDocumento` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `subprefeitura`
--
ALTER TABLE `subprefeitura`
MODIFY `idSubprefeitura` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=33;
--
-- AUTO_INCREMENT for table `unidade_medida`
--
ALTER TABLE `unidade_medida`
MODIFY `idUnidadeMedida` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `upload_arquivo`
--
ALTER TABLE `upload_arquivo`
MODIFY `idUploadArquivo` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3353;
--
-- AUTO_INCREMENT for table `weblogs`
--
ALTER TABLE `weblogs`
MODIFY `idWebLog` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2040;
--
-- AUTO_INCREMENT for table `zona`
--
ALTER TABLE `zona`
MODIFY `idZona` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
