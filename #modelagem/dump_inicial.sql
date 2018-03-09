-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 09-Mar-2018 às 21:15
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
-- Estrutura da tabela `area_atuacao`
--

CREATE TABLE `area_atuacao` (
  `idArea` int(10) UNSIGNED NOT NULL,
  `areaAtuacao` varchar(45) DEFAULT NULL,
  `tipo` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `contrapartida`
--

CREATE TABLE `contrapartida` (
  `idContrapartida` int(10) UNSIGNED NOT NULL,
  `faixaEtaria` varchar(25) DEFAULT NULL,
  `numeroPessoas` int(5) DEFAULT NULL,
  `valorIngresso` decimal(6,2) DEFAULT NULL,
  `valoresProdutos` decimal(6,2) DEFAULT NULL,
  `descricaoAoPublico` longtext
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `cronograma`
--

CREATE TABLE `cronograma` (
  `idCronograma` int(10) UNSIGNED NOT NULL,
  `captacaoRecurso` int(3) DEFAULT NULL,
  `preProducao` int(3) DEFAULT NULL,
  `producao` int(3) DEFAULT NULL,
  `posProducao` int(3) DEFAULT NULL,
  `prestacaoContas` int(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `despesas`
--

CREATE TABLE `despesas` (
  `idDespesas` int(10) UNSIGNED NOT NULL,
  `idProjeto` int(10) UNSIGNED NOT NULL,
  `item` varchar(50) DEFAULT NULL,
  `quantidade` int(4) DEFAULT NULL,
  `tipo` varchar(50) DEFAULT NULL,
  `valorUnitario` decimal(6,2) DEFAULT NULL,
  `valorTotal` decimal(7,2) DEFAULT NULL,
  `subtotal` decimal(8,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `etapa`
--

CREATE TABLE `etapa` (
  `idEtapa` int(11) NOT NULL,
  `etapa` varchar(70) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `publicado` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `informacoes_administrativas`
--

CREATE TABLE `informacoes_administrativas` (
  `idInformacoesAdministrativas` int(10) UNSIGNED NOT NULL,
  `idProjeto` int(11) DEFAULT NULL,
  `statusProjeto` varchar(25) DEFAULT NULL,
  `valorAprovado` decimal(9,2) DEFAULT NULL,
  `notas` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `lista_documento`
--

CREATE TABLE `lista_documento` (
  `idListaDocumento` int(10) UNSIGNED NOT NULL,
  `idTipoUpload` int(11) DEFAULT NULL,
  `documento` varchar(120) DEFAULT NULL,
  `sigla` varchar(10) DEFAULT NULL,
  `publicado` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `lista_documento`
--

INSERT INTO `lista_documento` (`idListaDocumento`, `idTipoUpload`, `documento`, `sigla`, `publicado`) VALUES
(1, 1, 'RG/RNE', 'rg', 1),
(2, 1, 'CPF', 'cpf', 1),
(3, 1, 'CCM', 'ccm', 1),
(4, 1, 'Comprovante de endereço', 'cde', 1),
(6, 1, 'Declaração', 'dec', 1);

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
  `publicado` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `nivelacesso`
--

CREATE TABLE `nivelacesso` (
  `idNivelAcesso` int(11) NOT NULL,
  `nivelAcesso` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `orcamento`
--

CREATE TABLE `orcamento` (
  `idOrcamento` int(10) UNSIGNED NOT NULL,
  `idProjeto` int(11) DEFAULT NULL,
  `idEtapa` int(11) DEFAULT NULL,
  `descricao` varchar(255) DEFAULT NULL,
  `quantidade` int(11) DEFAULT NULL,
  `idUnidadeMedida` int(11) DEFAULT NULL,
  `quantidadeUnidade` int(11) DEFAULT NULL,
  `valorUnitario` decimal(9,2) DEFAULT NULL,
  `valorTotal` decimal(9,2) DEFAULT NULL,
  `publicado` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `patrocinador`
--

CREATE TABLE `patrocinador` (
  `idPatrocinador` int(10) UNSIGNED NOT NULL,
  `descricao` longtext
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
  `cooperado` tinyint(1) DEFAULT NULL,
  `liberado` tinyint(1) DEFAULT NULL,
  `senha` varchar(60) DEFAULT NULL,
  `idNivelAcesso` int(11) DEFAULT '1',
  `idFraseSeguranca` int(11) DEFAULT NULL,
  `respostaFrase` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `pessoa_fisica`
--

INSERT INTO `pessoa_fisica` (`idPf`, `nome`, `cpf`, `rg`, `logradouro`, `bairro`, `cidade`, `estado`, `cep`, `numero`, `complemento`, `telefone`, `celular`, `email`, `cooperado`, `liberado`, `senha`, `idNivelAcesso`, `idFraseSeguranca`, `respostaFrase`) VALUES
(1, 'Pessoa Física', '000.000.000-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'pessoafisica@gmail.com', NULL, NULL, 'e10adc3949ba59abbe56e057f20f883e', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `pessoa_juridica`
--

CREATE TABLE `pessoa_juridica` (
  `idPj` int(10) UNSIGNED NOT NULL,
  `razaoSocial` varchar(150) DEFAULT NULL,
  `cnpj` char(18) NOT NULL,
  `ccm` char(11) DEFAULT NULL,
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
  `cooperativa` tinyint(1) DEFAULT NULL,
  `idRepresentanteLegal` int(10) UNSIGNED NOT NULL,
  `liberado` tinyint(1) DEFAULT NULL,
  `senha` varchar(60) DEFAULT NULL,
  `idNivelAcesso` int(11) DEFAULT '1',
  `idFraseSeguranca` int(11) DEFAULT NULL,
  `respostaFrase` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `pessoa_juridica`
--

INSERT INTO `pessoa_juridica` (`idPj`, `razaoSocial`, `cnpj`, `ccm`, `logradouro`, `bairro`, `cidade`, `estado`, `cep`, `numero`, `complemento`, `telefone`, `celular`, `email`, `cooperativa`, `idRepresentanteLegal`, `liberado`, `senha`, `idNivelAcesso`, `idFraseSeguranca`, `respostaFrase`) VALUES
(1, 'Razão Social', '00.000.000/0000-00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'razaosocial@gmail.com', NULL, 0, NULL, 'e10adc3949ba59abbe56e057f20f883e', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `projeto`
--

CREATE TABLE `projeto` (
  `idProjeto` int(10) UNSIGNED NOT NULL,
  `tipoPessoa` tinyint(1) DEFAULT NULL COMMENT '1 - pessoa física\n2 - pessoa jurídica',
  `idPj` int(11) DEFAULT NULL,
  `contratoGestao` tinyint(1) DEFAULT NULL,
  `idPf` int(11) DEFAULT NULL,
  `idAreaAtuacao` int(11) DEFAULT NULL,
  `valorProjeto` decimal(9,2) DEFAULT NULL,
  `valorIncentivo` decimal(9,2) DEFAULT NULL,
  `valorFinanciamento` decimal(9,2) DEFAULT NULL,
  `idRenunciaFiscal` int(11) DEFAULT NULL,
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
  `inicioCronograma` date DEFAULT NULL,
  `fimCronograma` date DEFAULT NULL,
  `idCronograma` int(10) UNSIGNED DEFAULT NULL,
  `totalPreProducao` decimal(9,2) DEFAULT NULL,
  `totalProducao` decimal(9,2) DEFAULT NULL,
  `totalImprensa` decimal(9,2) DEFAULT NULL,
  `totalCustosAdministrativos` decimal(9,2) DEFAULT NULL,
  `totalImpostos` decimal(9,2) DEFAULT NULL,
  `totalAgenciamento` decimal(9,2) DEFAULT NULL,
  `totalOutrosFinanciamentos` decimal(9,2) DEFAULT NULL,
  `video1` varchar(50) DEFAULT NULL,
  `video2` varchar(50) DEFAULT NULL,
  `video3` varchar(50) DEFAULT NULL,
  `idContrapartida` int(10) UNSIGNED DEFAULT NULL,
  `idPatrocinador` int(10) UNSIGNED DEFAULT NULL,
  `idDireitoAutoral` int(10) UNSIGNED DEFAULT NULL,
  `idAnexos` int(10) UNSIGNED DEFAULT NULL,
  `idInformacoesAdministrativas` int(10) UNSIGNED DEFAULT NULL,
  `publicado` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `renuncia_fiscal`
--

CREATE TABLE `renuncia_fiscal` (
  `idRenuncia` int(10) UNSIGNED NOT NULL,
  `renunciaFiscal` varchar(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tipo_upload`
--

CREATE TABLE `tipo_upload` (
  `idTipoUpload` int(10) UNSIGNED NOT NULL,
  `tipo` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `unidade_medida`
--

CREATE TABLE `unidade_medida` (
  `idUnidadeMedida` int(11) NOT NULL,
  `unidadeMedida` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `publicado` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura da tabela `zona`
--

CREATE TABLE `zona` (
  `idZona` int(10) UNSIGNED NOT NULL,
  `zona` varchar(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `area_atuacao`
--
ALTER TABLE `area_atuacao`
  ADD PRIMARY KEY (`idArea`);

--
-- Indexes for table `contrapartida`
--
ALTER TABLE `contrapartida`
  ADD PRIMARY KEY (`idContrapartida`);

--
-- Indexes for table `cronograma`
--
ALTER TABLE `cronograma`
  ADD PRIMARY KEY (`idCronograma`);

--
-- Indexes for table `despesas`
--
ALTER TABLE `despesas`
  ADD PRIMARY KEY (`idDespesas`);

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
-- Indexes for table `informacoes_administrativas`
--
ALTER TABLE `informacoes_administrativas`
  ADD PRIMARY KEY (`idInformacoesAdministrativas`);

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
-- Indexes for table `nivelacesso`
--
ALTER TABLE `nivelacesso`
  ADD PRIMARY KEY (`idNivelAcesso`);

--
-- Indexes for table `orcamento`
--
ALTER TABLE `orcamento`
  ADD PRIMARY KEY (`idOrcamento`);

--
-- Indexes for table `patrocinador`
--
ALTER TABLE `patrocinador`
  ADD PRIMARY KEY (`idPatrocinador`);

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
  MODIFY `idArea` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `contrapartida`
--
ALTER TABLE `contrapartida`
  MODIFY `idContrapartida` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `cronograma`
--
ALTER TABLE `cronograma`
  MODIFY `idCronograma` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `despesas`
--
ALTER TABLE `despesas`
  MODIFY `idDespesas` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `etapa`
--
ALTER TABLE `etapa`
  MODIFY `idEtapa` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ficha_tecnica`
--
ALTER TABLE `ficha_tecnica`
  MODIFY `idFichaTecnica` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `informacoes_administrativas`
--
ALTER TABLE `informacoes_administrativas`
  MODIFY `idInformacoesAdministrativas` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `lista_documento`
--
ALTER TABLE `lista_documento`
  MODIFY `idListaDocumento` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `locais_realizacao`
--
ALTER TABLE `locais_realizacao`
  MODIFY `idLocaisRealizacao` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `nivelacesso`
--
ALTER TABLE `nivelacesso`
  MODIFY `idNivelAcesso` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `orcamento`
--
ALTER TABLE `orcamento`
  MODIFY `idOrcamento` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `patrocinador`
--
ALTER TABLE `patrocinador`
  MODIFY `idPatrocinador` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pessoa_fisica`
--
ALTER TABLE `pessoa_fisica`
  MODIFY `idPf` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `pessoa_juridica`
--
ALTER TABLE `pessoa_juridica`
  MODIFY `idPj` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `projeto`
--
ALTER TABLE `projeto`
  MODIFY `idProjeto` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `renuncia_fiscal`
--
ALTER TABLE `renuncia_fiscal`
  MODIFY `idRenuncia` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `representante_legal`
--
ALTER TABLE `representante_legal`
  MODIFY `idRepresentanteLegal` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `unidade_medida`
--
ALTER TABLE `unidade_medida`
  MODIFY `idUnidadeMedida` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `upload_arquivo`
--
ALTER TABLE `upload_arquivo`
  MODIFY `idUploadArquivo` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `zona`
--
ALTER TABLE `zona`
  MODIFY `idZona` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
