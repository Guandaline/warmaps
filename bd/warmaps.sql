-- phpMyAdmin SQL Dump
-- version 3.4.5deb1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tempo de Geração: 14/10/2012 às 16h46min
-- Versão do Servidor: 5.1.63
-- Versão do PHP: 5.3.6-13ubuntu3.9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Banco de Dados: `warmaps`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `forca`
--

CREATE TABLE IF NOT EXISTS `forca` (
  `id_jogo` int(11) NOT NULL DEFAULT '0',
  `id_rodada` int(11) NOT NULL DEFAULT '0',
  `id_jogador` int(11) NOT NULL DEFAULT '0',
  `q_continetes` int(11) DEFAULT NULL,
  `q_paises` int(11) DEFAULT NULL,
  `q_exercitos` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_jogo`,`id_rodada`,`id_jogador`),
  KEY `f_rodada` (`id_rodada`),
  KEY `f_jogador` (`id_jogador`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estrutura stand-in para visualizar `forca_calculada`
--
CREATE TABLE IF NOT EXISTS `forca_calculada` (
`id_jogo` int(11)
,`id_rodada` int(11)
,`id_jogador` int(11)
,`forca` decimal(14,1)
);
-- --------------------------------------------------------

--
-- Estrutura da tabela `jogada`
--

CREATE TABLE IF NOT EXISTS `jogada` (
  `id_jogada` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_rodada` int(10) unsigned NOT NULL,
  `id_jogo` int(10) unsigned NOT NULL,
  `id_atacante` int(10) unsigned DEFAULT NULL,
  `id_atacado` int(10) unsigned DEFAULT NULL,
  `ataque` int(10) unsigned DEFAULT NULL,
  `defesa` int(10) unsigned DEFAULT NULL,
  `continuidade` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id_jogada`,`id_rodada`,`id_jogo`),
  KEY `jogada_FKIndex2` (`id_rodada`,`id_jogo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `jogadores`
--

CREATE TABLE IF NOT EXISTS `jogadores` (
  `id_jogador` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL,
  `id_jogo` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_jogador`,`nome`,`id_jogo`),
  KEY `jogadores_FKIndex1` (`id_jogo`),
  KEY `id_jogador` (`id_jogador`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `jogo`
--

CREATE TABLE IF NOT EXISTS `jogo` (
  `id_jogo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `numero_jogadores` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id_jogo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `mapas`
--

CREATE TABLE IF NOT EXISTS `mapas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(80) NOT NULL,
  `mapa` text NOT NULL,
  `numero_territorios` int(11) NOT NULL,
  `numero_regioes` int(11) DEFAULT NULL,
  `numero_objetivos` int(11) DEFAULT NULL,
  `tipo` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Extraindo dados da tabela `mapas`
--

INSERT INTO `mapas` (`id`, `nome`, `mapa`, `numero_territorios`, `numero_regioes`, `numero_objetivos`, `tipo`) VALUES
(1, 'Original.svg', 'Mapa', 42, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `objetivos`
--

CREATE TABLE IF NOT EXISTS `objetivos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_mapa` int(11) NOT NULL,
  `tipo` varchar(30) NOT NULL,
  `nome` varchar(255) DEFAULT NULL,
  `conquistarcontinente` float NOT NULL,
  `conquistafacil` float NOT NULL,
  `tomarcontinente` float NOT NULL,
  `reg1` varchar(40) NOT NULL,
  `reg2` varchar(40) NOT NULL,
  `outro` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Extraindo dados da tabela `objetivos`
--

INSERT INTO `objetivos` (`id`, `id_mapa`, `tipo`, `nome`, `conquistarcontinente`, `conquistafacil`, `tomarcontinente`, `reg1`, `reg2`, `outro`) VALUES
(2, 1, 'conquistaContinentes', 'Conquistar a Asia e America do Sul', 0.5, 0.9, 0.5, 'Asia', 'America do Sul', '0'),
(3, 1, 'conquistaContinentes', 'Conquistar America do Norte e Africa', 0.5, 0.9, 0.5, 'America do Norte', 'Africa', '0'),
(4, 1, 'conquistaContinentes', 'Conquistar America do Norte e Oceania', 0.5, 0.9, 0.5, 'America do Norte', 'Oceania', '0'),
(5, 1, 'conquistaContinentes', 'Conquistar Asia e Africa', 0.5, 0.9, 0.5, 'Asia', 'Africa', '0'),
(6, 1, 'conquistaContinentes', 'Conquistar America do Sul, Europa e um Terceiro', 0.5, 0.9, 0.5, 'America do Sul', 'Europa', '1'),
(7, 1, 'conquistaContinentes', 'conquistar Europa, Oceania e um Terceiro', 0.5, 0.9, 0.5, 'Europa', 'Oceania', '1');

-- --------------------------------------------------------

--
-- Estrutura da tabela `perfil`
--

CREATE TABLE IF NOT EXISTS `perfil` (
  `id_jogo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_jogador` int(11) NOT NULL,
  `id_perfil` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id_jogo`,`id_jogador`,`id_perfil`),
  KEY `Table_10_FKIndex1` (`id_perfil`),
  KEY `Table_10_FKIndex2` (`id_jogo`),
  KEY `Table_10_FKIndex3` (`id_jogador`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `regioes`
--

CREATE TABLE IF NOT EXISTS `regioes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_mapa` int(11) NOT NULL,
  `nome` varchar(80) NOT NULL,
  `cor` varchar(20) DEFAULT NULL,
  `exercitos` int(11) DEFAULT NULL,
  `valor_estrategico` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Extraindo dados da tabela `regioes`
--

INSERT INTO `regioes` (`id`, `id_mapa`, `nome`, `cor`, `exercitos`, `valor_estrategico`) VALUES
(1, 1, 'America do Sul', 'verde', 3, NULL),
(2, 1, 'America do Norte', 'laranja', 7, NULL),
(3, 1, 'Africa', 'amarelo', 4, NULL),
(4, 1, 'Europa', 'vermelho', 7, NULL),
(5, 1, 'Asia', 'preto', 9, NULL),
(6, 1, 'Oceania', 'rosa', 2, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `rodada`
--

CREATE TABLE IF NOT EXISTS `rodada` (
  `id_rodada` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_jogo` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id_rodada`,`id_jogo`),
  KEY `rodada_FKIndex1` (`id_jogo`),
  KEY `id_rodada` (`id_rodada`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `territorios`
--

CREATE TABLE IF NOT EXISTS `territorios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_mapa` int(11) NOT NULL,
  `id_regiao` int(11) DEFAULT NULL,
  `nome` varchar(40) NOT NULL,
  `numero_vizinhos` int(11) DEFAULT NULL,
  `valor_estrategico` int(11) DEFAULT NULL,
  `label` varchar(40) NOT NULL,
  `inome` varchar(40) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=43 ;

--
-- Extraindo dados da tabela `territorios`
--

INSERT INTO `territorios` (`id`, `id_mapa`, `id_regiao`, `nome`, `numero_vizinhos`, `valor_estrategico`, `label`, `inome`) VALUES
(1, 1, 1, 'uruguai', NULL, NULL, 'l_uruguai', 'uruguai'),
(2, 1, 1, 'brasil', NULL, NULL, 'l_brasil', 'brasil'),
(3, 1, 1, 'bolivia', NULL, NULL, 'l_bolivia', 'bolivia'),
(4, 1, 1, 'colombia', NULL, NULL, 'l_colombia', 'colombia'),
(5, 1, 2, 'mexico', NULL, NULL, 'l_mexico', 'mexico'),
(6, 1, 2, 'novaYork', NULL, NULL, 'l_novaYork', 'novaYork'),
(7, 1, 2, 'california', NULL, NULL, 'l_california', 'california'),
(8, 1, 2, 'vancouver', NULL, NULL, 'l_vancouver', 'vancouver'),
(9, 1, 2, 'ottawa', NULL, NULL, 'l_ottawa', 'ottawa'),
(10, 1, 2, 'labrador', NULL, NULL, 'l_labrador', 'labrador'),
(11, 1, 2, 'alaska', NULL, NULL, 'l_alaska', 'alaska'),
(12, 1, 2, 'mackenzie', NULL, NULL, 'l_mackenzie', 'mackenzie'),
(13, 1, 2, 'groenlandia', NULL, NULL, 'l_groenlandia', 'groenlandia'),
(14, 1, 3, 'argelia', NULL, NULL, 'l_argelia', 'argelia'),
(15, 1, 3, 'sudao', NULL, NULL, 'l_sudao', 'sudao'),
(16, 1, 3, 'congo', NULL, NULL, 'l_congo', 'congo'),
(17, 1, 3, 'africaSul', NULL, NULL, 'l_africaSul', 'africaSul'),
(18, 1, 3, 'madagascar', NULL, NULL, 'l_madagascar', 'madagascar'),
(19, 1, 3, 'egito', NULL, NULL, 'l_egito', 'egito'),
(20, 1, 4, 'franca', NULL, NULL, 'l_franca', 'franca'),
(21, 1, 4, 'inglaterra', NULL, NULL, 'l_inglaterra', 'inglaterra'),
(22, 1, 4, 'alemanha', NULL, NULL, 'l_alemanha', 'alemanha'),
(23, 1, 4, 'suecia', NULL, NULL, 'l_suecia', 'suecia'),
(24, 1, 4, 'islandia', NULL, NULL, 'l_islandia', 'islandia'),
(25, 1, 4, 'polonia', NULL, NULL, 'l_polonia', 'polonia'),
(26, 1, 4, 'moscou', NULL, NULL, 'l_moscou', 'moscou'),
(27, 1, 5, 'orienteMedio', NULL, NULL, 'l_orienteMedio', 'orienteMedio'),
(28, 1, 5, 'aral', NULL, NULL, 'l_aral', 'aral'),
(29, 1, 5, 'india', NULL, NULL, 'l_india', 'india'),
(30, 1, 5, 'china', NULL, NULL, 'l_china', 'china'),
(31, 1, 5, 'omsk', NULL, NULL, 'l_omsk', 'omsk'),
(32, 1, 5, 'dudinka', NULL, NULL, 'l_dudinka', 'dudinka'),
(33, 1, 5, 'siberia', NULL, NULL, 'l_siberia', 'siberia'),
(34, 1, 5, 'tchita', NULL, NULL, 'l_tchita', 'tchita'),
(35, 1, 5, 'mongolia', NULL, NULL, 'l_mongolia', 'mongolia'),
(36, 1, 5, 'vladivostok', NULL, NULL, 'l_vladivostok', 'vladivostok'),
(37, 1, 5, 'japao', NULL, NULL, 'l_japao', 'japao'),
(38, 1, 5, 'vietna', NULL, NULL, 'l_vietna', 'vietna'),
(39, 1, 6, 'sumatra', NULL, NULL, 'l_sumatra', 'sumatra'),
(40, 1, 6, 'australia', NULL, NULL, 'l_australia', 'australia'),
(41, 1, 6, 'borneo', NULL, NULL, 'l_borneo', 'borneo'),
(42, 1, 6, 'novaGuine', NULL, NULL, 'l_novaGuine', 'novaGuine');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tipo`
--

CREATE TABLE IF NOT EXISTS `tipo` (
  `id_perfil` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nome_perfil` varchar(100) NOT NULL,
  `ataque_minimo` int(10) unsigned DEFAULT NULL,
  `defesa_minima` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id_perfil`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Extraindo dados da tabela `tipo`
--

INSERT INTO `tipo` (`id_perfil`, `nome_perfil`, `ataque_minimo`, `defesa_minima`) VALUES
(1, 'ataca mais  forte', 1, 2),
(2, 'ataca mais fraco', 1, 1),
(3, 'ataca continuo alguem', 1, 1),
(5, 'vingativo', 1, 1),
(6, 'suicida', 1, 1),
(7, 'conservador', 1, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `ultimo`
--

CREATE TABLE IF NOT EXISTS `ultimo` (
  `id_atacante` int(11) NOT NULL AUTO_INCREMENT,
  `id_jogo` int(10) unsigned NOT NULL DEFAULT '0',
  `id_atacado` int(11) DEFAULT NULL,
  `numero_de_ataque` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id_atacante`,`id_jogo`),
  KEY `ultimo_FKIndex1` (`id_atacante`),
  KEY `ultimo_FKIndex2` (`id_atacado`),
  KEY `ultimo_FKIndex3` (`id_jogo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `vizinhos`
--

CREATE TABLE IF NOT EXISTS `vizinhos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `territorio` int(11) NOT NULL,
  `vizinho` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=224 ;

--
-- Extraindo dados da tabela `vizinhos`
--

INSERT INTO `vizinhos` (`id`, `territorio`, `vizinho`) VALUES
(1, 1, 3),
(2, 3, 1),
(3, 2, 3),
(4, 3, 2),
(5, 2, 4),
(6, 4, 2),
(7, 2, 1),
(8, 1, 2),
(9, 5, 4),
(10, 4, 5),
(11, 5, 6),
(12, 6, 5),
(13, 5, 7),
(14, 7, 5),
(15, 8, 7),
(16, 7, 8),
(168, 11, 36),
(169, 17, 18),
(19, 8, 9),
(20, 9, 8),
(21, 8, 11),
(22, 11, 8),
(23, 9, 7),
(24, 7, 9),
(25, 9, 10),
(26, 10, 9),
(27, 12, 8),
(28, 8, 12),
(167, 12, 13),
(166, 13, 12),
(31, 12, 9),
(32, 9, 12),
(33, 12, 11),
(34, 11, 12),
(35, 13, 24),
(36, 24, 13),
(165, 13, 10),
(172, 21, 23),
(102, 6, 9),
(173, 25, 19),
(41, 14, 20),
(42, 20, 14),
(100, 14, 2),
(170, 18, 17),
(101, 6, 7),
(174, 22, 21),
(47, 14, 19),
(48, 19, 14),
(49, 14, 15),
(50, 15, 14),
(51, 14, 16),
(52, 16, 14),
(53, 17, 16),
(54, 16, 17),
(55, 17, 15),
(56, 15, 17),
(57, 18, 15),
(58, 15, 18),
(59, 22, 25),
(60, 25, 22),
(61, 22, 20),
(62, 20, 22),
(63, 22, 23),
(64, 23, 22),
(65, 28, 27),
(66, 27, 28),
(68, 32, 28),
(69, 28, 30),
(70, 30, 28),
(71, 28, 31),
(72, 31, 28),
(73, 28, 26),
(74, 26, 28),
(75, 28, 29),
(76, 29, 28),
(77, 33, 36),
(78, 36, 33),
(79, 33, 34),
(80, 34, 33),
(81, 34, 35),
(82, 35, 34),
(189, 35, 37),
(87, 35, 32),
(88, 32, 35),
(89, 35, 36),
(90, 36, 35),
(91, 35, 30),
(92, 30, 35),
(93, 38, 29),
(94, 29, 38),
(95, 38, 41),
(186, 41, 42),
(97, 2, 14),
(98, 3, 4),
(99, 4, 3),
(103, 6, 10),
(104, 10, 6),
(105, 10, 13),
(106, 9, 6),
(107, 7, 6),
(179, 42, 41),
(178, 24, 23),
(191, 40, 42),
(111, 15, 16),
(112, 16, 15),
(113, 15, 19),
(114, 19, 15),
(177, 23, 24),
(176, 23, 21),
(171, 19, 25),
(175, 21, 22),
(119, 21, 20),
(120, 20, 21),
(121, 21, 24),
(122, 24, 21),
(123, 20, 25),
(124, 25, 20),
(125, 23, 26),
(126, 26, 23),
(127, 25, 27),
(128, 27, 25),
(129, 26, 22),
(130, 22, 26),
(131, 25, 26),
(132, 26, 25),
(133, 26, 31),
(134, 31, 26),
(135, 26, 27),
(136, 27, 26),
(137, 27, 29),
(138, 29, 27),
(139, 27, 19),
(140, 19, 27),
(141, 29, 30),
(142, 30, 29),
(143, 30, 31),
(144, 31, 30),
(145, 30, 32),
(146, 32, 30),
(190, 36, 11),
(149, 30, 38),
(150, 38, 30),
(153, 32, 31),
(154, 31, 32),
(157, 32, 33),
(158, 33, 32),
(159, 32, 34),
(160, 34, 32),
(161, 36, 34),
(162, 34, 36),
(163, 36, 37),
(164, 37, 36),
(192, 42, 40),
(182, 40, 41),
(183, 40, 39),
(184, 39, 29),
(185, 39, 40),
(187, 41, 38),
(188, 41, 40),
(209, 28, 32),
(210, 29, 35),
(223, 37, 35),
(222, 29, 39);

-- --------------------------------------------------------

--
-- Estrutura para visualizar `forca_calculada`
--
DROP TABLE IF EXISTS `forca_calculada`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `forca_calculada` AS select `forca`.`id_jogo` AS `id_jogo`,`forca`.`id_rodada` AS `id_rodada`,`forca`.`id_jogador` AS `id_jogador`,(((`forca`.`q_continetes` * 1) + (`forca`.`q_paises` * 0.6)) + (`forca`.`q_exercitos` * 0.4)) AS `forca` from `forca` where ((`forca`.`id_jogo` = (select max(`jogo`.`id_jogo`) AS `MAX(jogo.id_jogo)` from `jogo`)) and (`forca`.`id_rodada` = (select max(`rodada`.`id_rodada`) AS `MAX(rodada.id_rodada)` from `rodada` where (`rodada`.`id_jogo` = (select max(`jogo`.`id_jogo`) AS `MAX(jogo.id_jogo)` from `jogo`))))) group by `forca`.`id_jogo`,`forca`.`id_rodada`,`forca`.`id_jogador`;

--
-- Restrições para as tabelas dumpadas
--

--
-- Restrições para a tabela `jogada`
--
ALTER TABLE `jogada`
  ADD CONSTRAINT `jogada_ibfk_2` FOREIGN KEY (`id_rodada`, `id_jogo`) REFERENCES `rodada` (`id_rodada`, `id_jogo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para a tabela `jogadores`
--
ALTER TABLE `jogadores`
  ADD CONSTRAINT `jogadores_ibfk_1` FOREIGN KEY (`id_jogo`) REFERENCES `jogo` (`id_jogo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para a tabela `perfil`
--
ALTER TABLE `perfil`
  ADD CONSTRAINT `perfil_ibfk_1` FOREIGN KEY (`id_perfil`) REFERENCES `tipo` (`id_perfil`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `perfil_ibfk_2` FOREIGN KEY (`id_jogo`) REFERENCES `jogo` (`id_jogo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `perfil_ibfk_3` FOREIGN KEY (`id_jogador`) REFERENCES `jogadores` (`id_jogador`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para a tabela `rodada`
--
ALTER TABLE `rodada`
  ADD CONSTRAINT `rodada_ibfk_1` FOREIGN KEY (`id_jogo`) REFERENCES `jogo` (`id_jogo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Restrições para a tabela `ultimo`
--
ALTER TABLE `ultimo`
  ADD CONSTRAINT `ultimo_ibfk_1` FOREIGN KEY (`id_atacante`) REFERENCES `jogadores` (`id_jogador`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `ultimo_ibfk_2` FOREIGN KEY (`id_atacado`) REFERENCES `jogadores` (`id_jogador`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `ultimo_ibfk_3` FOREIGN KEY (`id_jogo`) REFERENCES `jogo` (`id_jogo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
