-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 09-Mar-2018 às 21:00
-- Versão do servidor: 10.1.30-MariaDB
-- PHP Version: 7.2.2

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
(4, 1, 'Comprovante de endereço atual (até últimos 3 meses)', 'ce', 1),
(5, 1, 'Comprovante de endereço de pelo menos 2 anos atrás', 'ce2', 1),
(6, 1, 'Declaração [modelo para download]', 'de', 1),
(8, 2, 'CNPJ', 'cnpj', 1),
(9, 2, 'CCM', 'ccm', 1),
(10, 2, 'Ato Constitutivo', 'ac', 1),
(11, 2, 'Ata de Eleição e Posse', 'aep', 1),
(12, 2, 'RG/RNE', 'rg', 1),
(13, 2, 'CPF', 'cpf', 1),
(14, 2, 'Comprovante de endereço atual (até últimos 3 meses)', 'ce', 1),
(15, 2, 'Comprovante de endereço de pelo menos 2 anos atrás', 'ce2', 1),
(16, 2, 'Declaração [modelo para download]', 'de', 1),
(17, 2, 'Declaração exclusiva para Organização Social com Termo de Colaboração a SMC [modelo para download]', 'deost', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `lista_documento`
--
ALTER TABLE `lista_documento`
  ADD PRIMARY KEY (`idListaDocumento`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `lista_documento`
--
ALTER TABLE `lista_documento`
  MODIFY `idListaDocumento` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
