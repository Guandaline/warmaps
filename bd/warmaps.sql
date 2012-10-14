-- phpMyAdmin SQL Dump
-- version 3.4.5deb1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tempo de Geração: 14/10/2012 às 14h40min
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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `objetivos`
--

CREATE TABLE IF NOT EXISTS `objetivos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_mapa` int(11) NOT NULL,
  `tipo` varchar(30) NOT NULL,
  `nome` varchar(20) DEFAULT NULL,
  `conquistarcontinente` float NOT NULL,
  `conquistafacil` float NOT NULL,
  `tomarcontinente` varchar(11) NOT NULL,
  `reg1` varchar(40) NOT NULL,
  `reg2` varchar(40) NOT NULL,
  `outro` varchar(80) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
