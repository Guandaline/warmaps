-- phpMyAdmin SQL Dump
-- version 3.4.5deb1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tempo de Geração: 28/09/2012 às 00h28min
-- Versão do Servidor: 5.1.63
-- Versão do PHP: 5.3.6-13ubuntu3.9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

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
-- Estrutura da tabela `teste`
--

CREATE TABLE IF NOT EXISTS `teste` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `teste` int(11) NOT NULL,
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
-- Estrutura da tabela `tipos`
--

CREATE TABLE IF NOT EXISTS `tipos` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `descr` varchar(40) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `descr` (`descr`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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

--
-- Extraindo dados da tabela `mapas`
--

INSERT INTO `mapas` (`id`, `nome`, `mapa`, `numero_territorios`, `numero_regioes`, `numero_objetivos`, `tipo`) VALUES
(83, 'Mapa_final.svg', 'Mapa', 43, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Extraindo dados da tabela `regioes`
--

INSERT INTO `regioes` (`id`, `id_mapa`, `nome`, `cor`, `exercitos`, `valor_estrategico`) VALUES
(27, 83, 'America do Sul', 'amarelo', 4, 4),
(28, 83, 'America do Norte', 'verde', 7, 7),
(29, 83, 'Europa', 'vermelho', 8, 8),
(30, 83, 'Africa', 'azul', 5, 5),
(31, 83, 'Asia', 'branco', 9, 9),
(32, 83, 'Oceania', 'preto', 4, 4);
--
-- Extraindo dados da tabela `territorios`
--

INSERT INTO `territorios` (`id`, `id_mapa`, `id_regiao`, `nome`, `numero_vizinhos`, `valor_estrategico`, `label`, `inome`) VALUES
(1864, 83, 27, 'uruguai', NULL, NULL, 'l_uruguai', 't_uruguai'),
(1865, 83, 27, 'brasil', NULL, NULL, 'l_brasil', 't_brasil'),
(1866, 83, 27, 'bolivia', NULL, NULL, 'l_bolivia', 't_bolivia'),
(1867, 83, 27, 'colombia', NULL, NULL, 'l_colombia', 't_colombia'),
(1868, 83, 28, 'mexico', NULL, NULL, 'l_mexico', 't_mexico'),
(1869, 83, 28, 'novaYork', NULL, NULL, 'l_novaYork', 't_novaYork'),
(1870, 83, 28, 'california', NULL, NULL, 'l_california', 't_california'),
(1871, 83, 28, 'vancouver', NULL, NULL, 'l_vancouver', 't_vancouver'),
(1872, 83, 28, 'ottawa', NULL, NULL, 'l_ottawa', 't_ottawa'),
(1873, 83, 28, 'labrador', NULL, NULL, 'l_labrador', 't_labrador'),
(1874, 83, 28, 'alaska', NULL, NULL, 'l_alaska', 't_alaska'),
(1875, 83, 28, 'mackenzie', NULL, NULL, 'l_mackenzie', 't_mackenzie'),
(1876, 83, 28, 'groenlandia', NULL, NULL, 'l_groenlandia', 't_groenlandia'),
(1877, 83, 30, 'argelia', NULL, NULL, 'l_argelia', 't_argelia'),
(1878, 83, 30, 'sudao', NULL, NULL, 'l_sudao', 't_sudao'),
(1879, 83, 30, 'congo', NULL, NULL, 'l_congo', 't_congo'),
(1880, 83, 30, 'africaSul', NULL, NULL, 'l_africaSul', 't_africaSul'),
(1881, 83, 30, 'madagascar', NULL, NULL, 'l_madagascar', 't_madagascar'),
(1882, 83, 30, 'egito', NULL, NULL, 'l_egito', 't_egito'),
(1883, 83, 29, 'franca', NULL, NULL, 'l_franca', 't_franca'),
(1884, 83, 29, 'inglaterra', NULL, NULL, 'l_inglaterra', 't_inglaterra'),
(1885, 83, 29, 'alemanha', NULL, NULL, 'l_alemanha', 't_alemanha'),
(1886, 83, 29, 'suecia', NULL, NULL, 'l_suecia', 't_suecia'),
(1887, 83, 29, 'islandia', NULL, NULL, 'l_islandia', 't_islandia'),
(1888, 83, 29, 'polonia', NULL, NULL, 'l_polonia', 't_polonia'),
(1889, 83, 29, 'moscou', NULL, NULL, 'l_moscou', 't_moscou'),
(1890, 83, 31, 'orienteMedio', NULL, NULL, 'l_orienteMedio', 't_orienteMedio'),
(1891, 83, 31, 'aral', NULL, NULL, 'l_aral', 't_aral'),
(1892, 83, 31, 'india', NULL, NULL, 'l_india', 't_india'),
(1893, 83, 31, 'china', NULL, NULL, 'l_china', 't_china'),
(1894, 83, 31, 'omsk', NULL, NULL, 'l_omsk', 't_omsk'),
(1895, 83, 31, 'dudinka', NULL, NULL, 'l_dudinka', 't_dudinka'),
(1896, 83, 31, 'siberia', NULL, NULL, 'l_siberia', 't_siberia'),
(1897, 83, 31, 'tchita', NULL, NULL, 'l_tchita', 't_tchita'),
(1898, 83, 31, 'mongolia', NULL, NULL, 'l_mongolia', 't_mongolia'),
(1899, 83, 31, 'vladivostok', NULL, NULL, 'l_vladivostok', 't_vladivostok'),
(1900, 83, 31, 'japao', NULL, NULL, 'l_japao', 't_japao'),
(1901, 83, 31, 'vietna', NULL, NULL, 'l_vietna', 't_vietna'),
(1902, 83, 32, 'sumatra', NULL, NULL, 'l_sumatra', 't_sumatra'),
(1903, 83, 32, 'australia', NULL, NULL, 'l_australia', 't_australia'),
(1904, 83, 32, 'borneo', NULL, NULL, 'l_borneo', 't_borneo'),
(1905, 83, 32, 'novaGuine', NULL, NULL, 'l_novaGuine', 't_novaGuine'),
(1906, 83, 28, 'cuba', NULL, NULL, 'l_cuba', 't_cuba');

--
-- Extraindo dados da tabela `vizinhos`
--
INSERT INTO `vizinhos` (`id`, `territorio`, `vizinho`) VALUES
(301, 1865, 1864),
(302, 1865, 1866),
(303, 1865, 1867),
(304, 1865, 1877),
(305, 1864, 1865),
(306, 1864, 1866),
(307, 1866, 1864),
(308, 1866, 1865),
(309, 1866, 1867),
(310, 1867, 1906),
(311, 1867, 1868),
(312, 1867, 1866),
(313, 1867, 1865),
(314, 1868, 1870),
(315, 1868, 1906),
(316, 1868, 1869),
(317, 1868, 1867),
(318, 1906, 1867),
(319, 1906, 1868),
(320, 1906, 1869),
(321, 1869, 1873),
(322, 1869, 1872),
(323, 1869, 1870),
(324, 1869, 1868),
(325, 1869, 1906),
(326, 1870, 1871),
(327, 1870, 1872),
(328, 1870, 1869),
(329, 1870, 1868),
(330, 1871, 1874),
(331, 1871, 1875),
(332, 1871, 1872),
(333, 1871, 1870),
(334, 1873, 1876),
(336, 1873, 1872),
(337, 1873, 1869),
(338, 1876, 1873),
(339, 1876, 1875),
(340, 1876, 1887),
(341, 1872, 1873),
(342, 1872, 1875),
(343, 1872, 1871),
(344, 1872, 1870),
(345, 1872, 1869),
(346, 1875, 1876),
(347, 1875, 1872),
(348, 1875, 1871),
(349, 1875, 1874),
(350, 1874, 1871),
(351, 1874, 1875),
(352, 1874, 1899),
(353, 1877, 1883),
(354, 1877, 1882),
(355, 1877, 1878),
(356, 1877, 1879),
(357, 1877, 1865),
(358, 1879, 1878),
(359, 1879, 1880),
(360, 1879, 1877),
(361, 1881, 1878),
(362, 1881, 1880),
(363, 1880, 1881),
(364, 1880, 1879),
(365, 1880, 1878),
(366, 1878, 1880),
(367, 1878, 1881),
(368, 1878, 1879),
(369, 1878, 1882),
(370, 1878, 1890),
(371, 1882, 1878),
(373, 1882, 1877),
(374, 1882, 1890),
(375, 1882, 1888),
(376, 1890, 1878),
(377, 1890, 1882),
(378, 1890, 1888),
(379, 1890, 1889),
(380, 1890, 1891),
(381, 1890, 1892),
(382, 1887, 1886),
(383, 1887, 1884),
(384, 1887, 1876),
(385, 1883, 1877),
(386, 1883, 1888),
(387, 1883, 1885),
(388, 1883, 1884),
(389, 1888, 1882),
(390, 1888, 1890),
(391, 1888, 1889),
(392, 1888, 1885),
(393, 1888, 1883),
(394, 1885, 1886),
(395, 1885, 1889),
(396, 1885, 1888),
(397, 1885, 1883),
(398, 1885, 1884),
(399, 1884, 1887),
(400, 1884, 1886),
(401, 1884, 1883),
(402, 1884, 1885),
(403, 1889, 1888),
(404, 1889, 1885),
(405, 1889, 1886),
(406, 1889, 1891),
(407, 1889, 1894),
(408, 1889, 1890),
(409, 1891, 1894),
(410, 1891, 1889),
(411, 1891, 1890),
(412, 1891, 1892),
(413, 1891, 1893),
(414, 1894, 1889),
(415, 1894, 1891),
(416, 1894, 1893),
(417, 1894, 1895),
(418, 1895, 1894),
(419, 1895, 1896),
(420, 1895, 1897),
(421, 1895, 1898),
(422, 1895, 1893),
(423, 1896, 1895),
(424, 1896, 1897),
(425, 1896, 1899),
(426, 1900, 1899),
(427, 1900, 1898),
(428, 1899, 1896),
(429, 1899, 1897),
(430, 1899, 1898),
(431, 1897, 1899),
(432, 1897, 1896),
(433, 1897, 1895),
(434, 1897, 1898),
(435, 1899, 1874),
(436, 1898, 1897),
(437, 1898, 1895),
(438, 1898, 1893),
(439, 1898, 1900),
(440, 1898, 1899),
(441, 1893, 1898),
(442, 1893, 1895),
(443, 1893, 1894),
(444, 1893, 1891),
(445, 1893, 1892),
(446, 1893, 1901),
(447, 1892, 1893),
(448, 1892, 1901),
(449, 1892, 1891),
(450, 1892, 1890),
(451, 1902, 1892),
(452, 1902, 1903),
(453, 1903, 1905),
(454, 1903, 1904),
(455, 1903, 1902),
(456, 1904, 1901),
(457, 1904, 1905),
(458, 1904, 1903),
(459, 1905, 1903),
(460, 1905, 1904),
(461, 1905, 1901),
(462, 1886, 1885),
(463, 1886, 1889),
(464, 1886, 1884),
(465, 1886, 1887),
(466, 1901, 1904),
(467, 1901, 1893),
(468, 1901, 1892);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;