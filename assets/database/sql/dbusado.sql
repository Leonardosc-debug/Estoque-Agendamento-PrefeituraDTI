-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 28-Nov-2024 às 21:01
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

--
-- Extraindo dados da tabela `agendamento`
--

INSERT INTO `agendamento` (`idAgendamento`, `dataAgendamento`, `tipoAgendamento`, `conteudoAgendamento`, `envolvidosAgendamento`, `statusAgendamento`) VALUES
(99, '2024-11-27 16:44:00', 'Manutenção', 'agora sim?', 'Só o leo', 'pendente'),
(100, '2024-11-28 15:33:00', 'Manutenção', 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Doloremque ab deserunt aspernatur tempore amet molestiae enim reprehenderit accusantium minima numquam est vero commodi vel, ut architecto quos praesentium sint earum? Lorem ipsum dolor sit amet consectetur adipisicing elit. Fugit, delectus, vitae est assumenda placeat nulla ratione in pariatur, excepturi modi necessitatibus. Doloremque consequatur eius, possimus labore architecto facilis dignissimos expedita. Lorem ipsum dolor sit, amet consectetur adipisicing elit. Hic harum eligendi recusandae nostrum dicta molestias nulla rem amet, vel fugiat exercitationem ex. Illum aut, voluptatem iusto impedit aliquam maiores est? Lorem ipsum dolor, sit amet consectetur adipisicing elit. Amet cumque corporis dolore eum voluptatibus, saepe porro quae quasi odit labore placeat nobis eaque at autem quas expedita. Ipsum, ex. Saepe! Lorem ipsum dolor, sit amet consectetur adipisicing elit. Numquam a tempore asperiores! Omnis, nostrum. Tempore deserunt ducimus animi nihil quos autem nulla numquam, neque rem iusto soluta praesentium reiciendis temporibus?', '', 'realizado'),
(101, '2024-11-29 15:40:00', 'Manutenção', 'Lel é massa', 'Leuzinho', 'realizado'),
(102, '2024-11-28 16:33:00', 'Organização', 'teste sem anexo', '', 'pendente');

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

--
-- Extraindo dados da tabela `anexosagendamento`
--

INSERT INTO `anexosagendamento` (`idAnexo`, `idAgendamento`, `nomeAnexo`, `textoAnexo`) VALUES
(11, 99, 'anexoImagemAgendamentoId99_0.jpg', 'teste anexo 1'),
(12, 99, 'anexoImagemAgendamentoId99_1.jpg', 'teste anexo 2'),
(13, 99, 'anexoImagemAgendamentoId99_2.jpg', 'teste anexo 3'),
(14, 100, 'anexoImagemAgendamentoId100_0.jpg', 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Doloremque ab deserunt aspernatur tempore amet molestiae enim reprehenderit accusantium minima numquam est vero commodi vel, ut architecto quos praesentium sint earum? Lorem ipsum dolor sit amet consectetur adipisicing elit. Fugit, delectus, vitae est assumenda placeat nulla ratione in pariatur, excepturi modi necessitatibus. Doloremque consequatur eius, possimus labore architecto facilis dignissimos expedita. Lorem ipsum dolor sit, amet consectetur adipisicing elit. Hic harum eligendi recusandae nostrum dicta molestias nulla rem amet, vel fugiat exercitationem ex. Illum aut, voluptatem iusto impedit aliquam maiores est? Lorem ipsum dolor, sit amet consectetur adipisicing elit. Amet cumque corporis dolore eum voluptatibus, saepe porro quae quasi odit labore placeat nobis eaque at autem quas expedita. Ipsum, ex. Saepe! Lorem ipsum dolor, sit amet consectetur adipisicing elit. Numquam a tempore asperiores! Omnis, nostrum. Tempore deserunt ducimus animi nihil quos autem nulla numquam, neque rem iusto soluta praesentium reiciendis temporibus?'),
(15, 100, 'anexoImagemAgendamentoId100_1.jpg', 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Doloremque ab deserunt aspernatur tempore amet molestiae enim reprehenderit accusantium minima numquam est vero commodi vel, ut architecto quos praesentium sint earum? Lorem ipsum dolor sit amet consectetur adipisicing elit. Fugit, delectus, vitae est assumenda placeat nulla ratione in pariatur, excepturi modi necessitatibus. Doloremque consequatur eius, possimus labore architecto facilis dignissimos expedita. Lorem ipsum dolor sit, amet consectetur adipisicing elit. Hic harum eligendi recusandae nostrum dicta molestias nulla rem amet, vel fugiat exercitationem ex. Illum aut, voluptatem iusto impedit aliquam maiores est? Lorem ipsum dolor, sit amet consectetur adipisicing elit. Amet cumque corporis dolore eum voluptatibus, saepe porro quae quasi odit labore placeat nobis eaque at autem quas expedita. Ipsum, ex. Saepe! Lorem ipsum dolor, sit amet consectetur adipisicing elit. Numquam a tempore asperiores! Omnis, nostrum. Tempore deserunt ducimus animi nihil quos autem nulla numquam, neque rem iusto soluta praesentium reiciendis temporibus?'),
(16, 100, 'anexoImagemAgendamentoId100_2.jpg', 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Doloremque ab deserunt aspernatur tempore amet molestiae enim reprehenderit accusantium minima numquam est vero commodi vel, ut architecto quos praesentium sint earum? Lorem ipsum dolor sit amet consectetur adipisicing elit. Fugit, delectus, vitae est assumenda placeat nulla ratione in pariatur, excepturi modi necessitatibus. Doloremque consequatur eius, possimus labore architecto facilis dignissimos expedita. Lorem ipsum dolor sit, amet consectetur adipisicing elit. Hic harum eligendi recusandae nostrum dicta molestias nulla rem amet, vel fugiat exercitationem ex. Illum aut, voluptatem iusto impedit aliquam maiores est? Lorem ipsum dolor, sit amet consectetur adipisicing elit. Amet cumque corporis dolore eum voluptatibus, saepe porro quae quasi odit labore placeat nobis eaque at autem quas expedita. Ipsum, ex. Saepe! Lorem ipsum dolor, sit amet consectetur adipisicing elit. Numquam a tempore asperiores! Omnis, nostrum. Tempore deserunt ducimus animi nihil quos autem nulla numquam, neque rem iusto soluta praesentium reiciendis temporibus?'),
(17, 100, 'anexoImagemAgendamentoId100_3.jpg', 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Doloremque ab deserunt aspernatur tempore amet molestiae enim reprehenderit accusantium minima numquam est vero commodi vel, ut architecto quos praesentium sint earum? Lorem ipsum dolor sit amet consectetur adipisicing elit. Fugit, delectus, vitae est assumenda placeat nulla ratione in pariatur, excepturi modi necessitatibus. Doloremque consequatur eius, possimus labore architecto facilis dignissimos expedita. Lorem ipsum dolor sit, amet consectetur adipisicing elit. Hic harum eligendi recusandae nostrum dicta molestias nulla rem amet, vel fugiat exercitationem ex. Illum aut, voluptatem iusto impedit aliquam maiores est? Lorem ipsum dolor, sit amet consectetur adipisicing elit. Amet cumque corporis dolore eum voluptatibus, saepe porro quae quasi odit labore placeat nobis eaque at autem quas expedita. Ipsum, ex. Saepe! Lorem ipsum dolor, sit amet consectetur adipisicing elit. Numquam a tempore asperiores! Omnis, nostrum. Tempore deserunt ducimus animi nihil quos autem nulla numquam, neque rem iusto soluta praesentium reiciendis temporibus?'),
(18, 101, 'anexoImagemAgendamentoId101_0.jpg', 'celso é viado'),
(19, 101, 'anexoImagemAgendamentoId101_1.jpg', ''),
(20, 101, 'anexoImagemAgendamentoId101_2.jpg', '');

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

--
-- Extraindo dados da tabela `dbestoque`
--

INSERT INTO `dbestoque` (`id`, `tipoEquipamento`, `numeroPatrimonio`, `numeroSerie`, `quantidade`) VALUES
(6, '2', 'PMP-AAXXXX6', 'XDG1234567', '0'),
(7, '6', 'PMP-AAXXXX6', 'XDG1234567', '0'),
(8, '6', 'PMP-AAXXXX6', 'XDG1234567', '0'),
(9, '2', 'PMP-AAXXXX6', 'XDG1234567', '0'),
(10, '2', 'PMP-AAXXXX6', 'XDG1234567', '0'),
(11, '2', 'PMP-AAXXXX9', 'XDG1234123', '0'),
(12, '2', 'PMP-AAXXXX9', 'XDG1234123', '0'),
(13, '4', 'PMP-AAXXXX6', 'XDG1234567', '0'),
(14, '4', 'PMP-AAXXXX6', 'XDG1234567', '0'),
(15, '4', 'PMP-AAXXXX6', 'XDG1234567', '0'),
(16, '7', 'PMP-AADDDD25', 'XYZB123456', '0'),
(17, '6', 'PMP-AAXXXX6', '654', '0'),
(18, '6', 'PMP-AAXXXX6', '654', ''),
(19, '6', 'PMP-AAXXXX6', '654', '50'),
(20, '6', 'PMP-AAXXXX6', '654', '50'),
(21, '2', 'PMP-AAXXXX8', 'XDG1234567', '1'),
(22, '', '', '', ''),
(23, '', '', '', ''),
(24, '2', '', '', ''),
(25, '2', '', '', ''),
(26, '2', '', '', ''),
(27, '2', '', '', ''),
(28, '4', '', '', ''),
(29, '4', '', '', ''),
(30, '2', '', '', ''),
(31, '2', '', '', ''),
(32, '2', '', '', ''),
(33, '2', '', '', ''),
(34, '4', 'asasasa', 'asasasas', '14'),
(35, '2', '', '', ''),
(36, '2', 'asasas', '', ''),
(37, '2', '', '', ''),
(38, '4', '', '', ''),
(39, '6', '', '', ''),
(40, '6', '', '', ''),
(41, '4', '', '', ''),
(42, '4', '', '', ''),
(43, '5', '', '', ''),
(44, '6', '', '', ''),
(45, '6', '', '', ''),
(46, '4', '', '', ''),
(47, '6', '', '', ''),
(48, '4', '', '', ''),
(49, '5', '', '', ''),
(50, '2', '', '', ''),
(51, '7', '', '', ''),
(52, '2', '', '', ''),
(53, '4', '', '', ''),
(54, '2', '', '', ''),
(55, '2', '', '', ''),
(56, '4', '', '', ''),
(57, '2', '', '', ''),
(58, '', '', '', ''),
(59, '', '', '', ''),
(60, '', '', '', ''),
(61, '', '', '', ''),
(62, '', '', '', ''),
(63, '', '', '', ''),
(64, '5', 'PMP-AAXXXX6', 'XDG1234567', '6'),
(65, '', '', '', ''),
(66, '', '', '', '');

-- --------------------------------------------------------

--
-- Estrutura da tabela `opcoes`
--

CREATE TABLE `opcoes` (
  `idOpcoes` int(11) NOT NULL,
  `nomeOpcoes` varchar(255) DEFAULT NULL,
  `statusOpcoes` int(11) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `opcoes`
--

INSERT INTO `opcoes` (`idOpcoes`, `nomeOpcoes`, `statusOpcoes`) VALUES
(2, 'COMPUTADOR', 0),
(4, 'IMPRESSORA', 1),
(5, 'NOTEBOOK', 1),
(6, 'SCANNER', 1),
(7, 'CELULAR', 1),
(8, 'PEÇAS EM GERAL', 1);

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
-- Extraindo dados da tabela `usuarioregistrado`
--

INSERT INTO `usuarioregistrado` (`idUserRegistrado`, `email`, `nome`, `senha`) VALUES
(1, 'leonardocorbetta@outlook.com', 'Leonardo da Silva Corbetta', 'Teste@12345');

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
  ADD KEY `idAgendamento` (`idAgendamento`);

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
  MODIFY `idAgendamento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT for table `anexosagendamento`
--
ALTER TABLE `anexosagendamento`
  MODIFY `idAnexo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `dbestoque`
--
ALTER TABLE `dbestoque`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `opcoes`
--
ALTER TABLE `opcoes`
  MODIFY `idOpcoes` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `usuarioregistrado`
--
ALTER TABLE `usuarioregistrado`
  MODIFY `idUserRegistrado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `anexosagendamento`
--
ALTER TABLE `anexosagendamento`
  ADD CONSTRAINT `anexosagendamento_ibfk_1` FOREIGN KEY (`idAgendamento`) REFERENCES `agendamento` (`idAgendamento`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
