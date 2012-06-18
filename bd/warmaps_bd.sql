-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tempo de Geração: Abr 04, 2012 as 03:57 AM
-- Versão do Servidor: 5.1.36
-- Versão do PHP: 5.3.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Banco de Dados: `wm2`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `cartas`
--

CREATE TABLE IF NOT EXISTS `cartas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_mapa` int(11) NOT NULL,
  `id_territorio` int(11) NOT NULL,
  `valor` int(11) NOT NULL,
  `figura` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `conquista_regioes`
--

CREATE TABLE IF NOT EXISTS `conquista_regioes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_obj_continentes` int(11) NOT NULL,
  `id_continente` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `mapas`
--

CREATE TABLE IF NOT EXISTS `mapas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(80) NOT NULL,
  `numero_territorios` int(11) NOT NULL,
  `numero_regioes` int(11) DEFAULT NULL,
  `numero_objetivos` int(11) DEFAULT NULL,
  `tipo` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `objetivos`
--

CREATE TABLE IF NOT EXISTS `objetivos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_mapa` int(11) NOT NULL,
  `tipo` int(11) NOT NULL,
  `nome` varchar(20) DEFAULT NULL,
  `descricao` varchar(250) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `obj_inimigo`
--

CREATE TABLE IF NOT EXISTS `obj_inimigo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_obj` int(11) NOT NULL,
  `cor` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `obj_regioes`
--

CREATE TABLE IF NOT EXISTS `obj_regioes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_objetivo` int(11) NOT NULL,
  `numero_continentes` int(11) NOT NULL,
  `qualquer` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `obj_territorios`
--

CREATE TABLE IF NOT EXISTS `obj_territorios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_objetivo` int(11) NOT NULL,
  `numero_territorios` int(11) NOT NULL,
  `numero_exercitos` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `regioes`
--

CREATE TABLE IF NOT EXISTS `regioes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_mapa` int(11) NOT NULL,
  `nome` varchar(80) NOT NULL,
  `numero_territorios` int(11) DEFAULT NULL,
  `exercitos` int(11) DEFAULT NULL,
  `valor_estrategico` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
