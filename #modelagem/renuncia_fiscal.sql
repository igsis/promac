-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 12-Mar-2018 às 20:05
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
-- Estrutura da tabela `renuncia_fiscal`
--

CREATE TABLE `renuncia_fiscal` (
  `idRenuncia` int(10) UNSIGNED NOT NULL,
  `renunciaFiscal` varchar(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `renuncia_fiscal`
--

INSERT INTO `renuncia_fiscal` (`idRenuncia`, `renunciaFiscal`) VALUES
(1, '100%'),
(2, '80%'),
(3, '50%'),
(4, '20%');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `renuncia_fiscal`
--
ALTER TABLE `renuncia_fiscal`
  ADD PRIMARY KEY (`idRenuncia`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `renuncia_fiscal`
--
ALTER TABLE `renuncia_fiscal`
  MODIFY `idRenuncia` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
