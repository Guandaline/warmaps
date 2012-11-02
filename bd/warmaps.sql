-- phpMyAdmin SQL Dump
-- version 3.4.5deb1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tempo de Geração: 02/11/2012 às 05h46min
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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Extraindo dados da tabela `mapas`
--

INSERT INTO `mapas` (`id`, `nome`, `mapa`, `numero_territorios`, `numero_regioes`, `numero_objetivos`, `tipo`) VALUES
(1, 'Original.svg', 'Mapa', 42, NULL, NULL, NULL),
(2, 'Oficial.svg', 'Mapa', 42, NULL, NULL, NULL),
(3, 'Mapa 2.svg', 'Mapa', 42, NULL, NULL, NULL);

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Extraindo dados da tabela `objetivos`
--

INSERT INTO `objetivos` (`id`, `id_mapa`, `tipo`, `nome`, `conquistarcontinente`, `conquistafacil`, `tomarcontinente`, `reg1`, `reg2`, `outro`) VALUES
(2, 1, 'conquistaContinentes', 'Conquistar a Asia e America do Sul', 0.5, 0.9, 0.5, 'Asia', 'America do Sul', '0'),
(3, 1, 'conquistaContinentes', 'Conquistar America do Norte e Africa', 0.5, 0.9, 0.5, 'America do Norte', 'Africa', '0'),
(4, 1, 'conquistaContinentes', 'Conquistar America do Norte e Oceania', 0.5, 0.9, 0.5, 'America do Norte', 'Oceania', '0'),
(5, 1, 'conquistaContinentes', 'Conquistar Asia e Africa', 0.5, 0.9, 0.5, 'Asia', 'Africa', '0'),
(6, 1, 'conquistaContinentes', 'Conquistar America do Sul, Europa e um Terceiro', 0.5, 0.9, 0.5, 'America do Sul', 'Europa', '1'),
(7, 1, 'conquistaContinentes', 'conquistar Europa, Oceania e um Terceiro', 0.5, 0.9, 0.5, 'Europa', 'Oceania', '1'),
(8, 2, 'conquistaContinentes', 'Conquistar Asia e America do Sul', 0.5, 0.9, 0.5, 'Asia', 'America do sul', '0'),
(9, 2, 'conquistaContinentes', 'Conquistar America do Norte, Africa e um terceiro a sua escolha ', 0.5, 0.9, 0.5, 'America do Norte', 'Africa', '1'),
(10, 2, 'conquistaContinentes', 'Conquistar Europa e America do Sul', 0.5, 0.9, 0.5, 'Europa', 'America do sul', '0');

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Extraindo dados da tabela `regioes`
--

INSERT INTO `regioes` (`id`, `id_mapa`, `nome`, `cor`, `exercitos`, `valor_estrategico`) VALUES
(1, 1, 'America do Sul', 'verde', 3, NULL),
(2, 1, 'America do Norte', 'laranja', 7, NULL),
(3, 1, 'Africa', 'amarelo', 4, NULL),
(4, 1, 'Europa', 'vermelho', 7, NULL),
(5, 1, 'Asia', 'preto', 9, NULL),
(6, 1, 'Oceania', 'rosa', 2, NULL),
(7, 2, 'America do sul', 'verde', 3, NULL),
(8, 2, 'America do Norte', 'laranja', 7, NULL),
(9, 2, 'Europa', 'vermelho', 8, NULL),
(10, 2, 'Africa', 'amarelo', 4, NULL),
(11, 2, 'Asia', 'preto', 10, NULL),
(12, 2, 'Oceania', 'rosa', 2, NULL),
(13, 3, 'America do Sul', 'verde', 3, NULL),
(14, 3, 'America do Norte', 'laranja', 7, NULL),
(15, 3, 'Africa', 'amarelo', 4, NULL),
(16, 3, 'Europa', 'vermelho', 8, NULL),
(17, 3, 'Asia', 'preto', 10, NULL),
(18, 3, 'Oceania', 'rosa', 2, NULL),
(19, 3, 'Nova', 'azul', 5, NULL);

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=129 ;

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
(42, 1, 6, 'novaGuine', NULL, NULL, 'l_novaGuine', 'novaGuine'),
(43, 2, 7, 'bolivia', NULL, NULL, 'l_bolivia', 'bolivia'),
(44, 2, 7, 'brasil', NULL, NULL, 'l_brasil', 'brasil'),
(45, 2, 7, 'colombia', NULL, NULL, 'l_colombia', 'colombia'),
(46, 2, 8, 'mexico', NULL, NULL, 'l_mexico', 'mexico'),
(47, 2, 8, 'novayork', NULL, NULL, 'l_novayork', 'novayork'),
(48, 2, 8, 'california', NULL, NULL, 'l_california', 'california'),
(49, 2, 8, 'vancouver', NULL, NULL, 'l_vancouver', 'vancouver'),
(50, 2, 8, 'ottawa', NULL, NULL, 'l_ottawa', 'ottawa'),
(51, 2, 8, 'labrador', NULL, NULL, 'l_labrador', 'labrador'),
(52, 2, 8, 'mackenzie', NULL, NULL, 'l_mackenzie', 'mackenzie'),
(53, 2, 8, 'alaska', NULL, NULL, 'l_alaska', 'alaska'),
(54, 2, 8, 'groelandia', NULL, NULL, 'l_groelandia', 'groelandia'),
(55, 2, 9, 'islandia', NULL, NULL, 'l_islandia', 'islandia'),
(56, 2, 9, 'inglaterra', NULL, NULL, 'l_inglaterra', 'inglaterra'),
(57, 2, 9, 'suecia', NULL, NULL, 'l_suecia', 'suecia'),
(58, 2, 9, 'alemanha', NULL, NULL, 'l_alemanha', 'alemanha'),
(59, 2, 9, 'polonia', NULL, NULL, 'l_polonia', 'polonia'),
(60, 2, 9, 'moscou', NULL, NULL, 'l_moscou', 'moscou'),
(61, 2, 10, 'argelia', NULL, NULL, 'l_argelia', 'argelia'),
(62, 2, 10, 'congo', NULL, NULL, 'l_congo', 'congo'),
(63, 2, 10, 'africadosul', NULL, NULL, 'l_africadosul', 'africadosul'),
(64, 2, 10, 'madagascar', NULL, NULL, 'l_madagascar', 'madagascar'),
(65, 2, 10, 'sudao', NULL, NULL, 'l_sudao', 'sudao'),
(66, 2, 10, 'egito', NULL, NULL, 'l_egito', 'egito'),
(67, 2, 12, 'australia', NULL, NULL, 'l_australia', 'australia'),
(68, 2, 12, 'sumatra', NULL, NULL, 'l_sumatra', 'sumatra'),
(69, 2, 12, 'borneo', NULL, NULL, 'l_borneo', 'borneo'),
(70, 2, 12, 'novaguine', NULL, NULL, 'l_novaguine', 'novaguine'),
(71, 2, 11, 'japao', NULL, NULL, 'l_japao', 'japao'),
(72, 2, 11, 'orientemedio', NULL, NULL, 'l_orientemedio', 'orientemedio'),
(73, 2, 11, 'india', NULL, NULL, 'l_india', 'india'),
(74, 2, 11, 'vietina', NULL, NULL, 'l_vietina', 'vietina'),
(75, 2, 11, 'vladivostok', NULL, NULL, 'l_vladivostok', 'vladivostok'),
(76, 2, 11, 'aral', NULL, NULL, 'l_aral', 'aral'),
(77, 2, 11, 'china', NULL, NULL, 'l_china', 'china'),
(78, 2, 11, 'omsk', NULL, NULL, 'l_omsk', 'omsk'),
(79, 2, 11, 'mongolia', NULL, NULL, 'l_mongolia', 'mongolia'),
(80, 2, 11, 'dudinka', NULL, NULL, 'l_dudinka', 'dudinka'),
(81, 2, 11, 'tchita', NULL, NULL, 'l_tchita', 'tchita'),
(82, 2, 11, 'siberia', NULL, NULL, 'l_siberia', 'siberia'),
(83, 2, 9, 'espanha', NULL, NULL, 'l_espanha', 'espanha'),
(84, 2, 7, 'argentina', NULL, NULL, 'l_argentina', 'argentina'),
(85, 3, 13, 'bolivia', NULL, NULL, 'l_bolivia', 'bolivia'),
(86, 3, 13, 'brasil', NULL, NULL, 'l_brasil', 'brasil'),
(87, 3, 13, 'colombia', NULL, NULL, 'l_colombia', 'colombia'),
(88, 3, 14, 'mexico', NULL, NULL, 'l_mexico', 'mexico'),
(89, 3, 14, 'novayork', NULL, NULL, 'l_novayork', 'novayork'),
(90, 3, 14, 'california', NULL, NULL, 'l_california', 'california'),
(91, 3, 14, 'vancouver', NULL, NULL, 'l_vancouver', 'vancouver'),
(92, 3, 14, 'ottawa', NULL, NULL, 'l_ottawa', 'ottawa'),
(93, 3, 14, 'labrador', NULL, NULL, 'l_labrador', 'labrador'),
(94, 3, 14, 'mackenzie', NULL, NULL, 'l_mackenzie', 'mackenzie'),
(95, 3, 14, 'alaska', NULL, NULL, 'l_alaska', 'alaska'),
(96, 3, 14, 'groelandia', NULL, NULL, 'l_groelandia', 'groelandia'),
(97, 3, 16, 'islandia', NULL, NULL, 'l_islandia', 'islandia'),
(98, 3, 16, 'inglaterra', NULL, NULL, 'l_inglaterra', 'inglaterra'),
(99, 3, 16, 'suecia', NULL, NULL, 'l_suecia', 'suecia'),
(100, 3, 16, 'alemanha', NULL, NULL, 'l_alemanha', 'alemanha'),
(101, 3, 16, 'polonia', NULL, NULL, 'l_polonia', 'polonia'),
(102, 3, 19, 'moscou', NULL, NULL, 'l_moscou', 'moscou'),
(103, 3, 15, 'argelia', NULL, NULL, 'l_argelia', 'argelia'),
(104, 3, 15, 'congo', NULL, NULL, 'l_congo', 'congo'),
(105, 3, 15, 'africadosul', NULL, NULL, 'l_africadosul', 'africadosul'),
(106, 3, 15, 'madagascar', NULL, NULL, 'l_madagascar', 'madagascar'),
(107, 3, 15, 'sudao', NULL, NULL, 'l_sudao', 'sudao'),
(108, 3, 15, 'egito', NULL, NULL, 'l_egito', 'egito'),
(109, 3, 18, 'australia', NULL, NULL, 'l_australia', 'australia'),
(110, 3, 18, 'sumatra', NULL, NULL, 'l_sumatra', 'sumatra'),
(111, 3, 18, 'borneo', NULL, NULL, 'l_borneo', 'borneo'),
(112, 3, 18, 'novaguine', NULL, NULL, 'l_novaguine', 'novaguine'),
(113, 3, 17, 'japao', NULL, NULL, 'l_japao', 'japao'),
(114, 3, 19, 'orientemedio', NULL, NULL, 'l_orientemedio', 'orientemedio'),
(115, 3, 17, 'india', NULL, NULL, 'l_india', 'india'),
(116, 3, 17, 'vietina', NULL, NULL, 'l_vietina', 'vietina'),
(117, 3, 17, 'vladivostok', NULL, NULL, 'l_vladivostok', 'vladivostok'),
(118, 3, 19, 'aral', NULL, NULL, 'l_aral', 'aral'),
(119, 3, 17, 'china', NULL, NULL, 'l_china', 'china'),
(120, 3, 19, 'omsk', NULL, NULL, 'l_omsk', 'omsk'),
(121, 3, 17, 'mongolia', NULL, NULL, 'l_mongolia', 'mongolia'),
(122, 3, 19, 'dudinka', NULL, NULL, 'l_dudinka', 'dudinka'),
(123, 3, 17, 'tchita', NULL, NULL, 'l_tchita', 'tchita'),
(124, 3, 17, 'siberia', NULL, NULL, 'l_siberia', 'siberia'),
(125, 3, 16, 'espanha', NULL, NULL, 'l_espanha', 'espanha'),
(126, 3, 13, 'argentina', NULL, NULL, 'l_argentina', 'argentina'),
(127, 3, 14, 'cuba', NULL, NULL, 'l_cuba', 'cuba'),
(128, 3, 15, 'nigeria', NULL, NULL, 'l_nigeria', 'nigeria');

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=625 ;

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
(222, 29, 39),
(224, 43, 44),
(225, 44, 43),
(226, 44, 45),
(227, 45, 44),
(228, 43, 45),
(229, 43, 84),
(230, 45, 43),
(231, 84, 43),
(232, 44, 84),
(233, 84, 44),
(234, 45, 46),
(235, 46, 45),
(236, 46, 47),
(237, 47, 46),
(238, 46, 48),
(239, 48, 46),
(240, 47, 48),
(241, 48, 47),
(242, 47, 49),
(243, 49, 47),
(244, 47, 50),
(245, 50, 47),
(246, 47, 51),
(247, 51, 47),
(248, 48, 49),
(249, 49, 48),
(250, 48, 50),
(251, 50, 48),
(252, 49, 50),
(253, 50, 49),
(254, 50, 51),
(255, 51, 50),
(427, 66, 83),
(257, 49, 52),
(426, 66, 59),
(259, 52, 49),
(260, 52, 50),
(261, 50, 52),
(262, 52, 53),
(263, 53, 52),
(264, 51, 54),
(265, 54, 51),
(266, 49, 53),
(267, 53, 49),
(420, 54, 52),
(421, 56, 55),
(270, 54, 55),
(271, 55, 54),
(422, 56, 58),
(273, 57, 54),
(274, 56, 83),
(275, 83, 56),
(423, 56, 57),
(425, 44, 61),
(412, 57, 58),
(279, 58, 57),
(280, 57, 60),
(281, 60, 57),
(282, 59, 60),
(283, 59, 58),
(284, 60, 59),
(285, 58, 59),
(286, 59, 72),
(287, 72, 59),
(288, 59, 83),
(289, 83, 59),
(290, 60, 76),
(291, 76, 60),
(417, 59, 66),
(424, 61, 44),
(294, 60, 72),
(413, 57, 59),
(296, 72, 60),
(428, 86, 85),
(298, 61, 62),
(299, 62, 61),
(300, 60, 78),
(301, 78, 60),
(302, 61, 65),
(303, 65, 61),
(304, 61, 66),
(305, 66, 61),
(411, 57, 56),
(433, 85, 87),
(308, 61, 83),
(309, 83, 61),
(310, 62, 63),
(311, 63, 62),
(312, 62, 65),
(313, 65, 62),
(314, 63, 65),
(315, 65, 63),
(316, 63, 64),
(317, 64, 63),
(318, 65, 64),
(319, 64, 65),
(415, 55, 56),
(321, 65, 66),
(416, 58, 56),
(323, 67, 70),
(324, 70, 67),
(325, 66, 65),
(405, 68, 67),
(406, 68, 73),
(446, 91, 89),
(329, 69, 70),
(330, 70, 69),
(407, 73, 68),
(332, 69, 74),
(333, 74, 69),
(334, 71, 75),
(335, 75, 71),
(336, 72, 66),
(337, 72, 76),
(338, 72, 73),
(339, 76, 72),
(340, 66, 72),
(341, 73, 72),
(342, 72, 78),
(430, 86, 87),
(408, 77, 71),
(345, 73, 76),
(346, 76, 73),
(444, 89, 90),
(418, 59, 57),
(443, 90, 88),
(350, 73, 77),
(351, 77, 73),
(352, 73, 74),
(353, 74, 73),
(441, 87, 88),
(410, 80, 81),
(442, 89, 88),
(445, 89, 91),
(358, 75, 81),
(359, 75, 82),
(360, 81, 75),
(361, 82, 75),
(436, 87, 85),
(363, 77, 75),
(419, 83, 66),
(365, 76, 77),
(429, 85, 86),
(434, 126, 86),
(438, 88, 89),
(369, 77, 76),
(370, 77, 74),
(371, 74, 77),
(372, 77, 79),
(373, 79, 77),
(409, 71, 77),
(435, 85, 126),
(376, 77, 78),
(377, 78, 77),
(378, 77, 81),
(379, 81, 77),
(380, 78, 80),
(431, 87, 86),
(382, 78, 79),
(383, 80, 78),
(384, 79, 78),
(432, 86, 126),
(440, 88, 87),
(439, 88, 90),
(388, 78, 76),
(389, 76, 78),
(390, 79, 80),
(391, 80, 79),
(392, 80, 82),
(393, 82, 80),
(437, 126, 85),
(395, 81, 80),
(396, 81, 82),
(397, 82, 81),
(398, 81, 79),
(399, 79, 81),
(400, 83, 58),
(401, 58, 83),
(402, 67, 69),
(403, 67, 68),
(404, 69, 67),
(447, 90, 89),
(448, 89, 92),
(449, 92, 89),
(450, 90, 92),
(451, 92, 90),
(452, 90, 91),
(453, 91, 90),
(454, 89, 93),
(455, 93, 89),
(456, 91, 94),
(457, 94, 91),
(458, 91, 95),
(459, 95, 91),
(460, 92, 93),
(461, 93, 92),
(462, 91, 92),
(463, 93, 92),
(464, 92, 91),
(465, 92, 91),
(466, 93, 94),
(467, 94, 93),
(468, 93, 96),
(469, 96, 93),
(470, 94, 92),
(471, 92, 94),
(472, 96, 98),
(473, 98, 96),
(474, 95, 94),
(475, 96, 97),
(476, 94, 95),
(477, 97, 96),
(478, 96, 99),
(479, 99, 96),
(480, 96, 100),
(481, 99, 100),
(482, 100, 96),
(483, 100, 99),
(484, 99, 102),
(485, 101, 100),
(486, 98, 125),
(487, 100, 101),
(488, 102, 99),
(489, 101, 102),
(490, 125, 98),
(491, 102, 101),
(492, 101, 114),
(493, 114, 101),
(494, 101, 103),
(622, 103, 101),
(496, 101, 125),
(497, 125, 101),
(498, 102, 114),
(499, 102, 118),
(500, 114, 102),
(501, 118, 102),
(502, 102, 122),
(503, 102, 125),
(504, 122, 102),
(505, 103, 104),
(506, 125, 102),
(507, 104, 103),
(508, 102, 120),
(509, 103, 107),
(510, 120, 102),
(511, 107, 103),
(512, 103, 108),
(513, 108, 103),
(514, 104, 107),
(515, 103, 125),
(516, 104, 105),
(517, 107, 104),
(518, 125, 103),
(519, 105, 104),
(520, 105, 106),
(521, 106, 105),
(522, 105, 107),
(523, 107, 106),
(524, 107, 105),
(525, 107, 105),
(526, 106, 107),
(527, 107, 114),
(528, 114, 107),
(529, 107, 108),
(530, 110, 111),
(531, 108, 107),
(532, 111, 110),
(533, 109, 112),
(534, 112, 109),
(535, 110, 116),
(536, 116, 110),
(537, 111, 112),
(538, 112, 111),
(539, 111, 116),
(540, 116, 111),
(541, 113, 117),
(542, 117, 113),
(543, 114, 118),
(544, 118, 114),
(545, 114, 115),
(546, 115, 114),
(547, 114, 108),
(548, 115, 116),
(549, 116, 115),
(550, 108, 114),
(551, 115, 118),
(552, 115, 117),
(553, 114, 120),
(554, 118, 115),
(555, 115, 119),
(556, 120, 114),
(557, 117, 115),
(558, 119, 115),
(559, 115, 121),
(560, 121, 115),
(561, 117, 119),
(562, 117, 122),
(563, 119, 117),
(564, 122, 117),
(565, 117, 121),
(566, 121, 117),
(567, 118, 119),
(568, 117, 123),
(569, 119, 118),
(570, 123, 117),
(571, 117, 124),
(572, 124, 117),
(573, 119, 116),
(574, 116, 119),
(575, 118, 123),
(576, 123, 118),
(577, 119, 120),
(578, 120, 119),
(579, 118, 122),
(580, 122, 118),
(581, 119, 121),
(582, 121, 119),
(583, 120, 118),
(584, 120, 121),
(585, 118, 120),
(586, 121, 120),
(587, 119, 122),
(588, 120, 122),
(589, 122, 120),
(590, 122, 119),
(591, 119, 123),
(592, 123, 119),
(593, 120, 123),
(594, 123, 120),
(595, 120, 124),
(596, 121, 122),
(597, 122, 121),
(598, 124, 120),
(599, 122, 123),
(600, 123, 122),
(601, 122, 124),
(602, 124, 122),
(603, 123, 124),
(604, 123, 121),
(605, 124, 123),
(606, 121, 123),
(607, 125, 100),
(608, 100, 125),
(609, 89, 127),
(610, 127, 89),
(611, 104, 128),
(612, 128, 104),
(613, 107, 128),
(614, 128, 107),
(615, 108, 128),
(616, 128, 108),
(617, 88, 127),
(618, 127, 88),
(619, 128, 103),
(620, 103, 128),
(624, 128, 86);

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
