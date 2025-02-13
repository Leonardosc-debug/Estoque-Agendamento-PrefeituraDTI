-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 20-Dez-2024 às 20:54
-- Versão do servidor: 10.1.38-MariaDB
-- versão do PHP: 7.1.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dtiagendaestoque`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `agendamento`
--

CREATE TABLE `agendamento` (
  `idAgendamento` int(11) NOT NULL,
  `dataAgendamento` datetime NOT NULL,
  `tipoAgendamento` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `conteudoAgendamento` text COLLATE utf8_unicode_ci NOT NULL,
  `envolvidosAgendamento` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `statusAgendamento` varchar(20) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `anexosagendamento`
--

CREATE TABLE `anexosagendamento` (
  `idAnexo` int(11) NOT NULL,
  `idAgendamento` int(11) NOT NULL,
  `nomeAnexo` varchar(70) COLLATE utf8_unicode_ci NOT NULL,
  `textoAnexo` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `dbestoque`
--

CREATE TABLE `dbestoque` (
  `id` int(11) NOT NULL,
  `tipoEquipamento` varchar(255) NOT NULL,
  `numeroPatrimonio` varchar(255) NOT NULL,
  `numeroSerie` varchar(255) NOT NULL,
  `quantidade` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `opcoes`
--

CREATE TABLE `opcoes` (
  `idOpcoes` int(11) NOT NULL,
  `nomeOpcoes` varchar(255) DEFAULT NULL,
  `statusOpcoes` int(11) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarioregistrado`
--

CREATE TABLE `usuarioregistrado` (
  `idUserRegistrado` int(11) NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `nome` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `senha` varchar(20) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `agendamento`
--
ALTER TABLE `agendamento`
  ADD PRIMARY KEY (`idAgendamento`);

--
-- Indexes for table `anexosagendamento`
--
ALTER TABLE `anexosagendamento`
  ADD PRIMARY KEY (`idAnexo`),
  ADD KEY `anexosagendamento_ibfk_1` (`idAgendamento`);

--
-- Indexes for table `dbestoque`
--
ALTER TABLE `dbestoque`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `opcoes`
--
ALTER TABLE `opcoes`
  ADD PRIMARY KEY (`idOpcoes`);

--
-- Indexes for table `usuarioregistrado`
--
ALTER TABLE `usuarioregistrado`
  ADD PRIMARY KEY (`idUserRegistrado`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `agendamento`
--
ALTER TABLE `agendamento`
  MODIFY `idAgendamento` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `anexosagendamento`
--
ALTER TABLE `anexosagendamento`
  MODIFY `idAnexo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dbestoque`
--
ALTER TABLE `dbestoque`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `opcoes`
--
ALTER TABLE `opcoes`
  MODIFY `idOpcoes` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `usuarioregistrado`
--
ALTER TABLE `usuarioregistrado`
  MODIFY `idUserRegistrado` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `anexosagendamento`
--
ALTER TABLE `anexosagendamento`
  ADD CONSTRAINT `anexosagendamento_ibfk_1` FOREIGN KEY (`idAgendamento`) REFERENCES `agendamento` (`idAgendamento`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
