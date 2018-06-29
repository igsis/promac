-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 29-Jun-2018 às 18:03
-- Versão do servidor: 10.1.22-MariaDB
-- PHP Version: 7.1.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `promac`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `administrators`
--

CREATE TABLE `administrators` (
  `id` int(11) NOT NULL,
  `login` varchar(10) NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 NOT NULL,
  `local` varchar(100) CHARACTER SET utf8mb4 NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 NOT NULL,
  `dateCreated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `administrators_users`
--

CREATE TABLE `administrators_users` (
  `users_id` int(11) NOT NULL,
  `admininstrators_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `area_atuacao`
--

CREATE TABLE `area_atuacao` (
  `idArea` int(10) UNSIGNED NOT NULL,
  `areaAtuacao` varchar(255) DEFAULT NULL,
  `tipo` tinyint(1) DEFAULT NULL COMMENT 'PJ e PF = 1 | PF = 1 | PJ = 2',
  `publicado` tinyint(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `categories`
--

CREATE TABLE `categories` (
  `id` int(2) NOT NULL,
  `category` varchar(120) NOT NULL,
  `published` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `cronograma`
--

CREATE TABLE `cronograma` (
  `idCronograma` int(10) UNSIGNED NOT NULL,
  `captacaoRecurso` varchar(50) DEFAULT NULL,
  `preProducao` varchar(50) DEFAULT NULL,
  `producao` varchar(50) DEFAULT NULL,
  `posProducao` varchar(50) DEFAULT NULL,
  `prestacaoContas` varchar(50) DEFAULT NULL,
  `alteradoPor` varchar(150) DEFAULT 'none'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Acionadores `cronograma`
--
DELIMITER $$
CREATE TRIGGER `tr_cronograma` AFTER UPDATE ON `cronograma` FOR EACH ROW INSERT INTO weblogs(tabela, acao, idCronograma, dataOcorrencia, antes, depois)     
    
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
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `deposito`
--

CREATE TABLE `deposito` (
  `idDeposito` int(11) NOT NULL,
  `tipoPessoa` tinyint(1) NOT NULL,
  `idIncentivador` int(11) NOT NULL,
  `idReserva` int(11) NOT NULL,
  `data` date NOT NULL,
  `valorDeposito` decimal(9,2) NOT NULL,
  `valorRenuncia` decimal(9,2) NOT NULL,
  `porcentagemValorRenuncia` varchar(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `distrito`
--

CREATE TABLE `distrito` (
  `idDistrito` int(10) NOT NULL,
  `distrito` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `empenho`
--

CREATE TABLE `empenho` (
  `idEmpenho` int(11) NOT NULL,
  `idReserva` int(11) NOT NULL,
  `data` date NOT NULL,
  `valor` decimal(9,2) NOT NULL,
  `numeroEmpenho` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `employees`
--

CREATE TABLE `employees` (
  `id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `role` varchar(45) NOT NULL,
  `published` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `employees_problems`
--

CREATE TABLE `employees_problems` (
  `problems_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `toolMaterial` longtext
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `etapa`
--

CREATE TABLE `etapa` (
  `idEtapa` int(11) NOT NULL,
  `etapa` varchar(70) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `ficha_tecnica`
--

CREATE TABLE `ficha_tecnica` (
  `idFichaTecnica` int(10) UNSIGNED NOT NULL,
  `idProjeto` int(10) UNSIGNED NOT NULL,
  `nome` varchar(150) DEFAULT NULL,
  `cpf` char(14) DEFAULT NULL,
  `funcao` varchar(50) DEFAULT NULL,
  `publicado` tinyint(1) DEFAULT NULL,
  `alteradoPor` varchar(150) DEFAULT 'none'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Acionadores `ficha_tecnica`
--
DELIMITER $$
CREATE TRIGGER `tr_ficha_tecnica` AFTER UPDATE ON `ficha_tecnica` FOR EACH ROW INSERT INTO weblogs(tabela, acao, idRegistro, dataOcorrencia, antes, depois)     
    
    VALUES('ficha_tecnica', 'UPDATE', new.idProjeto, now(), 
      
      concat('NOME',old.nome, '|','CPF:',old.cpf,
       '|','FUNCAO:',old.funcao,
       '|','PUBLICADO:',old.publicado       
      ),
      
      concat('NOME',new.nome,      
       '|','CPF:',new.cpf,
       '|','FUNCAO:',new.funcao,
       '|','PUBLICADO:',new.publicado             
      
      ))
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `frase_seguranca`
--

CREATE TABLE `frase_seguranca` (
  `id` int(11) NOT NULL,
  `frase_seguranca` varchar(60) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `incentivador_pessoa_fisica`
--

CREATE TABLE `incentivador_pessoa_fisica` (
  `idPf` int(10) UNSIGNED NOT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Acionadores `incentivador_pessoa_fisica`
--
DELIMITER $$
CREATE TRIGGER `tr_log_incentivador_pf` AFTER UPDATE ON `incentivador_pessoa_fisica` FOR EACH ROW INSERT INTO  weblogs(tabela, acao, idRegistro, documento, dataOcorrencia,  antes, depois)     
    
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
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `incentivador_pessoa_juridica`
--

CREATE TABLE `incentivador_pessoa_juridica` (
  `idPj` int(10) UNSIGNED NOT NULL,
  `razaoSocial` varchar(150) DEFAULT NULL,
  `cnpj` char(18) NOT NULL,
  `logradouro` varchar(150) DEFAULT NULL,
  `bairro` varchar(30) DEFAULT NULL,
  `cidade` varchar(50) DEFAULT NULL,
  `estado` char(2) DEFAULT NULL,
  `cep` char(9) DEFAULT NULL,
  `numero` int(5) DEFAULT NULL,
  `complemento` varchar(15) DEFAULT NULL,
  `telefone` varchar(15) DEFAULT NULL,
  `celular` varchar(15) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `idRepresentanteLegal` int(10) UNSIGNED DEFAULT NULL,
  `liberado` tinyint(1) DEFAULT NULL,
  `senha` varchar(60) DEFAULT NULL,
  `idNivelAcesso` int(11) DEFAULT '1',
  `idFraseSeguranca` int(11) DEFAULT NULL,
  `respostaFrase` varchar(10) DEFAULT NULL,
  `dataInscricao` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `incentivador_projeto`
--

CREATE TABLE `incentivador_projeto` (
  `idIncentivador` int(11) NOT NULL,
  `tipoPessoa` tinyint(1) NOT NULL,
  `idProjeto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `liquidacao`
--

CREATE TABLE `liquidacao` (
  `idLiquidacao` int(11) NOT NULL,
  `idDeposito` int(11) NOT NULL,
  `data` date NOT NULL,
  `valor` decimal(9,2) NOT NULL,
  `numeroLiquidacao` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `lista_documento`
--

CREATE TABLE `lista_documento` (
  `idListaDocumento` int(10) UNSIGNED NOT NULL,
  `idTipoUpload` int(11) DEFAULT NULL,
  `documento` varchar(255) DEFAULT NULL,
  `sigla` varchar(10) DEFAULT NULL,
  `publicado` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `locais_realizacao`
--

CREATE TABLE `locais_realizacao` (
  `idLocaisRealizacao` int(10) UNSIGNED NOT NULL,
  `idProjeto` int(10) UNSIGNED NOT NULL,
  `local` varchar(100) DEFAULT NULL,
  `estimativaPublico` int(11) DEFAULT NULL,
  `idZona` int(11) DEFAULT NULL,
  `idSubprefeitura` int(11) DEFAULT NULL,
  `idDistrito` int(11) DEFAULT NULL,
  `publicado` tinyint(1) DEFAULT NULL,
  `alteradoPor` varchar(150) DEFAULT 'none'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Acionadores `locais_realizacao`
--
DELIMITER $$
CREATE TRIGGER `tr_log_locais` AFTER UPDATE ON `locais_realizacao` FOR EACH ROW INSERT INTO weblogs(tabela, acao, idRegistro, dataOcorrencia, antes, depois)     
    
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
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `log`
--

CREATE TABLE `log` (
  `id` int(11) NOT NULL,
  `idUsuario` int(11) DEFAULT NULL,
  `enderecoIP` varchar(20) DEFAULT NULL,
  `dataLog` datetime DEFAULT NULL,
  `descricao` longtext
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `nivel_acesso`
--

CREATE TABLE `nivel_acesso` (
  `idNivelAcesso` int(11) NOT NULL,
  `nivelAcesso` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `notas`
--

CREATE TABLE `notas` (
  `idNotas` int(10) UNSIGNED NOT NULL,
  `idProjeto` int(11) DEFAULT NULL,
  `data` datetime DEFAULT NULL,
  `nota` longtext,
  `interna` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `notes`
--

CREATE TABLE `notes` (
  `id` int(11) NOT NULL,
  `problems_id` int(11) NOT NULL,
  `administrator_id` int(11) DEFAULT NULL,
  `users_id` int(11) DEFAULT NULL,
  `note` longtext NOT NULL,
  `private` tinyint(1) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `orcamento`
--

CREATE TABLE `orcamento` (
  `idOrcamento` int(10) UNSIGNED NOT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Acionadores `orcamento`
--
DELIMITER $$
CREATE TRIGGER `tr_log_orcamento` AFTER UPDATE ON `orcamento` FOR EACH ROW INSERT INTO weblogs(tabela, acao, idRegistro, dataOcorrencia, antes, depois)     
    
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
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `orcamento_anual`
--

CREATE TABLE `orcamento_anual` (
  `idOrcamentoAnual` int(11) NOT NULL,
  `ano` int(4) NOT NULL,
  `valor` decimal(11,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `pessoa_fisica`
--

CREATE TABLE `pessoa_fisica` (
  `idPf` int(10) UNSIGNED NOT NULL,
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
  `alteradoPor` varchar(150) DEFAULT 'none',
  `agencia` varchar(12) DEFAULT NULL,
  `contaCaptacao` varchar(12) DEFAULT NULL,
  `contaMovimentacao` varchar(12) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Acionadores `pessoa_fisica`
--
DELIMITER $$
CREATE TRIGGER `tr_log_pessoa_fisica` AFTER UPDATE ON `pessoa_fisica` FOR EACH ROW INSERT INTO  weblogs(tabela, acao, idRegistro, documento, dataOcorrencia,  antes, depois)     
    
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
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `pessoa_juridica`
--

CREATE TABLE `pessoa_juridica` (
  `idPj` int(10) UNSIGNED NOT NULL,
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
  `idRepresentanteLegal` int(10) UNSIGNED DEFAULT NULL,
  `liberado` tinyint(1) DEFAULT NULL,
  `senha` varchar(60) DEFAULT NULL,
  `idNivelAcesso` int(11) DEFAULT '1',
  `idFraseSeguranca` int(11) DEFAULT NULL,
  `respostaFrase` varchar(10) DEFAULT NULL,
  `dataInscricao` datetime DEFAULT NULL,
  `alteradoPor` varchar(150) DEFAULT 'none',
  `agencia` varchar(12) DEFAULT NULL,
  `contaCaptacao` varchar(12) DEFAULT NULL,
  `contaMovimentacao` varchar(12) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Acionadores `pessoa_juridica`
--
DELIMITER $$
CREATE TRIGGER `tr_log_pessoa_juridica` AFTER UPDATE ON `pessoa_juridica` FOR EACH ROW INSERT INTO  weblogs(tabela, acao, idRegistro, documento, dataOcorrencia,  antes, depois)     
    
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
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `prazos_projeto`
--

CREATE TABLE `prazos_projeto` (
  `idPrazo` int(10) UNSIGNED NOT NULL,
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
-- Estrutura da tabela `priorities`
--

CREATE TABLE `priorities` (
  `id` int(1) NOT NULL,
  `priority` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `problems`
--

CREATE TABLE `problems` (
  `id` int(11) NOT NULL,
  `users_id` int(11) NOT NULL,
  `local` varchar(100) NOT NULL,
  `phone` varchar(45) NOT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 NOT NULL,
  `contact` varchar(20) NOT NULL,
  `priorities_id` int(1) NOT NULL,
  `categories_id` int(2) NOT NULL,
  `description` longtext NOT NULL,
  `solution` longtext,
  `startDate` datetime NOT NULL,
  `closedate` datetime DEFAULT NULL,
  `problem_status_id` int(1) NOT NULL,
  `administrators_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `problem_status`
--

CREATE TABLE `problem_status` (
  `id` int(1) NOT NULL,
  `status` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `projeto`
--

CREATE TABLE `projeto` (
  `idProjeto` int(10) UNSIGNED NOT NULL,
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
  `idCronograma` int(10) UNSIGNED DEFAULT '0',
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
  `alteradoPor` varchar(150) DEFAULT 'none',
  `processoSei` varchar(30) DEFAULT NULL,
  `assinaturaTermo` date DEFAULT NULL,
  `observacoes` longtext
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Acionadores `projeto`
--
DELIMITER $$
CREATE TRIGGER `tr_log_projeto` AFTER UPDATE ON `projeto` FOR EACH ROW INSERT INTO  weblogs(tabela, acao, idRegistro, dataOcorrencia, antes, depois)     
       
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
       '|','PJ:',old.idPj, '|','PF:',old.idPf,
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
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `regions`
--

CREATE TABLE `regions` (
  `id` int(1) NOT NULL,
  `region` varchar(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `renuncia_fiscal`
--

CREATE TABLE `renuncia_fiscal` (
  `idRenuncia` int(10) UNSIGNED NOT NULL,
  `renunciaFiscal` varchar(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `representante_legal`
--

CREATE TABLE `representante_legal` (
  `idRepresentanteLegal` int(10) UNSIGNED NOT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `reserva`
--

CREATE TABLE `reserva` (
  `idReserva` int(11) NOT NULL,
  `idProjeto` int(11) NOT NULL,
  `data` date NOT NULL,
  `valor` decimal(9,2) NOT NULL,
  `numeroReserva` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `status`
--

CREATE TABLE `status` (
  `idStatus` int(11) NOT NULL,
  `status` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `statusprojeto`
--

CREATE TABLE `statusprojeto` (
  `idStatus` int(11) NOT NULL,
  `situacaoAtual` int(11) NOT NULL,
  `descricaoSituacao` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `status_documento`
--

CREATE TABLE `status_documento` (
  `idStatusDocumento` int(11) NOT NULL,
  `status` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `subprefeitura`
--

CREATE TABLE `subprefeitura` (
  `idSubprefeitura` int(10) NOT NULL,
  `subprefeitura` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tipo_upload`
--

CREATE TABLE `tipo_upload` (
  `idTipoUpload` int(10) UNSIGNED NOT NULL,
  `tipo` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `unidade_medida`
--

CREATE TABLE `unidade_medida` (
  `idUnidadeMedida` int(11) NOT NULL,
  `unidadeMedida` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `upload_arquivo`
--

CREATE TABLE `upload_arquivo` (
  `idUploadArquivo` int(10) UNSIGNED NOT NULL,
  `idTipo` int(11) DEFAULT NULL,
  `idPessoa` int(11) DEFAULT NULL,
  `idListaDocumento` int(11) DEFAULT NULL,
  `arquivo` varchar(255) DEFAULT NULL,
  `dataEnvio` datetime DEFAULT NULL,
  `idStatusDocumento` int(11) DEFAULT NULL,
  `observacoes` varchar(150) DEFAULT NULL,
  `publicado` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `login` varchar(10) NOT NULL,
  `password` varchar(255) NOT NULL,
  `local` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `contact` varchar(20) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `idRegion` int(1) DEFAULT NULL,
  `operatingHours` varchar(100) DEFAULT NULL,
  `historicalBuilding` tinyint(1) DEFAULT NULL,
  `dateCreated` datetime NOT NULL,
  `dateLastAccess` datetime DEFAULT NULL,
  `user_status_id` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `user_status`
--

CREATE TABLE `user_status` (
  `id` int(1) NOT NULL,
  `status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `weblogs`
--

CREATE TABLE `weblogs` (
  `idWebLog` int(11) NOT NULL,
  `tabela` varchar(50) DEFAULT NULL,
  `acao` varchar(10) DEFAULT NULL,
  `idRegistro` int(11) DEFAULT NULL,
  `dataOcorrencia` date DEFAULT NULL,
  `antes` mediumtext,
  `depois` mediumtext,
  `documento` char(18) DEFAULT NULL,
  `idCronograma` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `zona`
--

CREATE TABLE `zona` (
  `idZona` int(10) UNSIGNED NOT NULL,
  `zona` varchar(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `administrators`
--
ALTER TABLE `administrators`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `administrators_users`
--
ALTER TABLE `administrators_users`
  ADD KEY `fk_administrators_idx` (`admininstrators_id`),
  ADD KEY `fk_users_idx` (`users_id`);

--
-- Indexes for table `area_atuacao`
--
ALTER TABLE `area_atuacao`
  ADD PRIMARY KEY (`idArea`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `category_UNIQUE` (`category`);

--
-- Indexes for table `cronograma`
--
ALTER TABLE `cronograma`
  ADD PRIMARY KEY (`idCronograma`);

--
-- Indexes for table `deposito`
--
ALTER TABLE `deposito`
  ADD PRIMARY KEY (`idDeposito`),
  ADD KEY `idReserva` (`idReserva`);

--
-- Indexes for table `distrito`
--
ALTER TABLE `distrito`
  ADD PRIMARY KEY (`idDistrito`);

--
-- Indexes for table `empenho`
--
ALTER TABLE `empenho`
  ADD PRIMARY KEY (`idEmpenho`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employees_problems`
--
ALTER TABLE `employees_problems`
  ADD KEY `fk_emploees_idx` (`problems_id`),
  ADD KEY `fk_employee_idx` (`employee_id`);

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
  ADD PRIMARY KEY (`idPj`),
  ADD UNIQUE KEY `email_UNIQUE` (`email`);

--
-- Indexes for table `liquidacao`
--
ALTER TABLE `liquidacao`
  ADD PRIMARY KEY (`idLiquidacao`),
  ADD KEY `idDeposito` (`idDeposito`);

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
-- Indexes for table `notes`
--
ALTER TABLE `notes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_notes_problems_idx` (`problems_id`),
  ADD KEY `fk_notes_administrators_idx` (`administrator_id`),
  ADD KEY `fk_notes_users_idx` (`users_id`);

--
-- Indexes for table `orcamento`
--
ALTER TABLE `orcamento`
  ADD PRIMARY KEY (`idOrcamento`);

--
-- Indexes for table `orcamento_anual`
--
ALTER TABLE `orcamento_anual`
  ADD PRIMARY KEY (`idOrcamentoAnual`);

--
-- Indexes for table `pessoa_fisica`
--
ALTER TABLE `pessoa_fisica`
  ADD PRIMARY KEY (`idPf`);

--
-- Indexes for table `pessoa_juridica`
--
ALTER TABLE `pessoa_juridica`
  ADD PRIMARY KEY (`idPj`),
  ADD UNIQUE KEY `email_UNIQUE` (`email`);

--
-- Indexes for table `prazos_projeto`
--
ALTER TABLE `prazos_projeto`
  ADD PRIMARY KEY (`idPrazo`);

--
-- Indexes for table `priorities`
--
ALTER TABLE `priorities`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `priority_UNIQUE` (`priority`);

--
-- Indexes for table `problems`
--
ALTER TABLE `problems`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_problems_user_idx` (`users_id`),
  ADD KEY `fk_problems_proprieties_idx` (`priorities_id`),
  ADD KEY `fk_problems_categories_idx` (`categories_id`),
  ADD KEY `fk_problems_administrators_idx` (`administrators_id`),
  ADD KEY `fk_problems_status_idx` (`problem_status_id`);

--
-- Indexes for table `problem_status`
--
ALTER TABLE `problem_status`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `status_UNIQUE` (`status`);

--
-- Indexes for table `projeto`
--
ALTER TABLE `projeto`
  ADD PRIMARY KEY (`idProjeto`);

--
-- Indexes for table `regions`
--
ALTER TABLE `regions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `region_UNIQUE` (`region`);

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
-- Indexes for table `reserva`
--
ALTER TABLE `reserva`
  ADD PRIMARY KEY (`idReserva`);

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
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `dapartment_UNIQUE` (`local`),
  ADD KEY `fk_regios_users_idx` (`idRegion`),
  ADD KEY `fk_user_status_users_idx` (`user_status_id`);

--
-- Indexes for table `user_status`
--
ALTER TABLE `user_status`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `status_UNIQUE` (`status`);

--
-- Indexes for table `weblogs`
--
ALTER TABLE `weblogs`
  ADD PRIMARY KEY (`idWebLog`),
  ADD KEY `index_por_ocorrencia` (`dataOcorrencia`);

--
-- Indexes for table `zona`
--
ALTER TABLE `zona`
  ADD PRIMARY KEY (`idZona`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `administrators`
--
ALTER TABLE `administrators`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `area_atuacao`
--
ALTER TABLE `area_atuacao`
  MODIFY `idArea` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `cronograma`
--
ALTER TABLE `cronograma`
  MODIFY `idCronograma` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;
--
-- AUTO_INCREMENT for table `deposito`
--
ALTER TABLE `deposito`
  MODIFY `idDeposito` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `distrito`
--
ALTER TABLE `distrito`
  MODIFY `idDistrito` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;
--
-- AUTO_INCREMENT for table `empenho`
--
ALTER TABLE `empenho`
  MODIFY `idEmpenho` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `etapa`
--
ALTER TABLE `etapa`
  MODIFY `idEtapa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `ficha_tecnica`
--
ALTER TABLE `ficha_tecnica`
  MODIFY `idFichaTecnica` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=371;
--
-- AUTO_INCREMENT for table `frase_seguranca`
--
ALTER TABLE `frase_seguranca`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `incentivador_pessoa_fisica`
--
ALTER TABLE `incentivador_pessoa_fisica`
  MODIFY `idPf` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `incentivador_pessoa_juridica`
--
ALTER TABLE `incentivador_pessoa_juridica`
  MODIFY `idPj` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT for table `liquidacao`
--
ALTER TABLE `liquidacao`
  MODIFY `idLiquidacao` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `lista_documento`
--
ALTER TABLE `lista_documento`
  MODIFY `idListaDocumento` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;
--
-- AUTO_INCREMENT for table `locais_realizacao`
--
ALTER TABLE `locais_realizacao`
  MODIFY `idLocaisRealizacao` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=174;
--
-- AUTO_INCREMENT for table `log`
--
ALTER TABLE `log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12901;
--
-- AUTO_INCREMENT for table `nivel_acesso`
--
ALTER TABLE `nivel_acesso`
  MODIFY `idNivelAcesso` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `notas`
--
ALTER TABLE `notas`
  MODIFY `idNotas` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `notes`
--
ALTER TABLE `notes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `orcamento`
--
ALTER TABLE `orcamento`
  MODIFY `idOrcamento` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2357;
--
-- AUTO_INCREMENT for table `pessoa_fisica`
--
ALTER TABLE `pessoa_fisica`
  MODIFY `idPf` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=229;
--
-- AUTO_INCREMENT for table `pessoa_juridica`
--
ALTER TABLE `pessoa_juridica`
  MODIFY `idPj` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=467;
--
-- AUTO_INCREMENT for table `prazos_projeto`
--
ALTER TABLE `prazos_projeto`
  MODIFY `idPrazo` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `priorities`
--
ALTER TABLE `priorities`
  MODIFY `id` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `problems`
--
ALTER TABLE `problems`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `problem_status`
--
ALTER TABLE `problem_status`
  MODIFY `id` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `projeto`
--
ALTER TABLE `projeto`
  MODIFY `idProjeto` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=144;
--
-- AUTO_INCREMENT for table `regions`
--
ALTER TABLE `regions`
  MODIFY `id` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `renuncia_fiscal`
--
ALTER TABLE `renuncia_fiscal`
  MODIFY `idRenuncia` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `representante_legal`
--
ALTER TABLE `representante_legal`
  MODIFY `idRepresentanteLegal` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=320;
--
-- AUTO_INCREMENT for table `reserva`
--
ALTER TABLE `reserva`
  MODIFY `idReserva` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `status`
--
ALTER TABLE `status`
  MODIFY `idStatus` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `statusprojeto`
--
ALTER TABLE `statusprojeto`
  MODIFY `idStatus` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `status_documento`
--
ALTER TABLE `status_documento`
  MODIFY `idStatusDocumento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `subprefeitura`
--
ALTER TABLE `subprefeitura`
  MODIFY `idSubprefeitura` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
--
-- AUTO_INCREMENT for table `unidade_medida`
--
ALTER TABLE `unidade_medida`
  MODIFY `idUnidadeMedida` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `upload_arquivo`
--
ALTER TABLE `upload_arquivo`
  MODIFY `idUploadArquivo` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3361;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `weblogs`
--
ALTER TABLE `weblogs`
  MODIFY `idWebLog` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2049;
--
-- AUTO_INCREMENT for table `zona`
--
ALTER TABLE `zona`
  MODIFY `idZona` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `administrators_users`
--
ALTER TABLE `administrators_users`
  ADD CONSTRAINT `fk_administrators` FOREIGN KEY (`admininstrators_id`) REFERENCES `administrators` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_users` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `deposito`
--
ALTER TABLE `deposito`
  ADD CONSTRAINT `idReserva` FOREIGN KEY (`idReserva`) REFERENCES `reserva` (`idReserva`);

--
-- Limitadores para a tabela `employees_problems`
--
ALTER TABLE `employees_problems`
  ADD CONSTRAINT `fk_employee` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_problems` FOREIGN KEY (`problems_id`) REFERENCES `problems` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `liquidacao`
--
ALTER TABLE `liquidacao`
  ADD CONSTRAINT `idDeposito` FOREIGN KEY (`idDeposito`) REFERENCES `deposito` (`idDeposito`);

--
-- Limitadores para a tabela `notes`
--
ALTER TABLE `notes`
  ADD CONSTRAINT `fk_notes_administrators` FOREIGN KEY (`administrator_id`) REFERENCES `administrators` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_notes_problems` FOREIGN KEY (`problems_id`) REFERENCES `problems` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_notes_users` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `problems`
--
ALTER TABLE `problems`
  ADD CONSTRAINT `fk_problems_administrators` FOREIGN KEY (`administrators_id`) REFERENCES `administrators` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_problems_categories` FOREIGN KEY (`categories_id`) REFERENCES `categories` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_problems_proprieties` FOREIGN KEY (`priorities_id`) REFERENCES `priorities` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_problems_status` FOREIGN KEY (`problem_status_id`) REFERENCES `problem_status` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_problems_users` FOREIGN KEY (`users_id`) REFERENCES `administrators_users` (`users_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_regios_users` FOREIGN KEY (`idRegion`) REFERENCES `regions` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_user_status_users` FOREIGN KEY (`user_status_id`) REFERENCES `user_status` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
