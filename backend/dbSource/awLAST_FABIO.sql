-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 16, 2012 at 04:44 PM
-- Server version: 5.1.44
-- PHP Version: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `aw`
--

-- --------------------------------------------------------

--
-- Table structure for table `clube`
--

CREATE TABLE IF NOT EXISTS `clube` (
  `idclube` int(11) NOT NULL AUTO_INCREMENT,
  `idlocal` int(11) NOT NULL,
  `idcompeticao` int(11) NOT NULL,
  `nome_clube` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  PRIMARY KEY (`idclube`,`idlocal`,`idcompeticao`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `clube`
--

INSERT INTO `clube` (`idclube`, `idlocal`, `idcompeticao`, `nome_clube`) VALUES
(1, 1, 1, 'Sport Lisboa e Benfica'),
(2, 2, 1, 'Futebol Clube do Porto'),
(3, 1, 1, 'Sporting Clube de Portugal'),
(4, 3, 1, 'Sporting Clube de Braga'),
(5, 4, 1, 'Clube Desportivo Nacional');

-- --------------------------------------------------------

--
-- Table structure for table `clubes_lexico`
--

CREATE TABLE IF NOT EXISTS `clubes_lexico` (
  `idclube` int(11) NOT NULL,
  `idlexico` int(11) NOT NULL,
  PRIMARY KEY (`idclube`,`idlexico`),
  KEY `idlexico` (`idlexico`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `clubes_lexico`
--

INSERT INTO `clubes_lexico` (`idclube`, `idlexico`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(1, 6),
(1, 7),
(1, 8),
(1, 9),
(1, 10),
(1, 11),
(1, 12),
(1, 13),
(1, 14),
(1, 15),
(1, 16),
(1, 17),
(1, 18),
(2, 19),
(2, 20),
(2, 21),
(2, 22),
(2, 23),
(2, 24),
(2, 25),
(2, 26),
(2, 27),
(2, 28),
(2, 29),
(2, 30),
(2, 31),
(2, 32),
(2, 33),
(2, 34),
(3, 35),
(3, 36),
(3, 37),
(3, 38),
(3, 39),
(3, 40),
(3, 41),
(3, 42),
(3, 43),
(3, 44),
(3, 45),
(3, 46),
(3, 47),
(3, 48),
(3, 49),
(3, 50),
(3, 51),
(3, 52),
(3, 53);

-- --------------------------------------------------------

--
-- Table structure for table `competicao`
--

CREATE TABLE IF NOT EXISTS `competicao` (
  `idcompeticao` int(11) NOT NULL AUTO_INCREMENT,
  `nome_competicao` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  PRIMARY KEY (`idcompeticao`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `competicao`
--

INSERT INTO `competicao` (`idcompeticao`, `nome_competicao`) VALUES
(1, 'Liga Zon Sagres'),
(2, 'Liga Orangina');

-- --------------------------------------------------------

--
-- Table structure for table `fonte`
--

CREATE TABLE IF NOT EXISTS `fonte` (
  `idfonte` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) CHARACTER SET latin1 DEFAULT NULL,
  `main_url` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `ligado` tinyint(1) NOT NULL,
  PRIMARY KEY (`idfonte`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `fonte`
--

INSERT INTO `fonte` (`idfonte`, `nome`, `main_url`, `ligado`) VALUES
(1, 'Arquivo da Web Portuguesa', 'http://arquivo.pt/opensearch?query=', 1),
(2, 'RSS Sapo Notícias', 'http://noticias.sapo.pt/rss/news/', 1),
(3, 'Geo-Net-PT', 'http://dmir.inesc-id.pt/resolve/geonetpt02/sparql.psp', 1),
(4, 'RSS Google News', 'https://ajax.googleapis.com/ajax/services/search/news?v=1.0&q=', 1),
(6, 'Google Maps', 'http://maps.google.com', 1),
(8, 'TwitterSearch', 'http://search.twitter.com/search.rss', 1);

-- --------------------------------------------------------

--
-- Table structure for table `fonte_has_parametros`
--

CREATE TABLE IF NOT EXISTS `fonte_has_parametros` (
  `idfonte` int(11) NOT NULL,
  `idparametros` int(11) NOT NULL,
  PRIMARY KEY (`idfonte`,`idparametros`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `fonte_has_parametros`
--


-- --------------------------------------------------------

--
-- Table structure for table `funcao`
--

CREATE TABLE IF NOT EXISTS `funcao` (
  `idfuncao` int(11) NOT NULL AUTO_INCREMENT,
  `funcao` varchar(45) CHARACTER SET latin1 DEFAULT NULL,
  PRIMARY KEY (`idfuncao`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `funcao`
--

INSERT INTO `funcao` (`idfuncao`, `funcao`) VALUES
(1, 'Presidente'),
(2, 'Treinador Principal'),
(3, 'Jogador');

-- --------------------------------------------------------

--
-- Table structure for table `integrante`
--

CREATE TABLE IF NOT EXISTS `integrante` (
  `idintegrante` int(11) NOT NULL AUTO_INCREMENT,
  `idclube` int(11) NOT NULL,
  `idfuncao` int(11) NOT NULL,
  `nome_integrante` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`idintegrante`,`idclube`,`idfuncao`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=44 ;

--
-- Dumping data for table `integrante`
--

INSERT INTO `integrante` (`idintegrante`, `idclube`, `idfuncao`, `nome_integrante`) VALUES
(1, 1, 3, 'Artur Moraes'),
(2, 1, 3, 'Emerson'),
(3, 1, 3, 'LuisÃ£o'),
(4, 1, 3, 'Javi GarcÃ­a'),
(5, 1, 3, 'Ã“scar Cardozo'),
(6, 1, 3, 'Bruno CÃ©sar'),
(7, 1, 3, 'Nolito'),
(8, 1, 3, 'Pablo Aimar'),
(9, 1, 3, 'Yannick DjalÃ³'),
(10, 1, 3, 'Maxi Pereira'),
(11, 1, 3, 'NÃ©lson Oliveira'),
(12, 1, 3, 'Rodrigo'),
(13, 1, 3, 'Nico GaitÃ¡n'),
(14, 1, 3, 'Matic'),
(15, 1, 3, 'Ezequiel Garay'),
(16, 1, 3, 'Miguel VÃ­tor'),
(17, 1, 3, 'Witsel'),
(18, 1, 3, 'Saviola'),
(19, 1, 3, 'Jardel'),
(20, 1, 3, 'AndrÃ© Almeida'),
(21, 1, 3, 'Luis Martins'),
(22, 1, 3, 'RÃºben Pinto'),
(23, 1, 3, 'Capdevila'),
(24, 1, 3, 'Mika'),
(25, 1, 3, 'Eduardo'),
(26, 1, 2, 'Jorge Jesus'),
(27, 2, 2, 'Vítor Pereira'),
(28, 1, 3, 'Raúl José'),
(29, 1, 3, 'Miguel Quaresma'),
(30, 2, 3, 'Paulinho Santos'),
(31, 2, 3, 'Semedo'),
(32, 2, 3, 'Rui Quinta'),
(33, 1, 3, 'Minervino Pietra'),
(34, 1, 4, 'Mário Monteiro'),
(35, 2, 4, 'António Dias'),
(36, 1, 5, 'Hugo Oliveira'),
(37, 2, 5, 'Wil Coort'),
(38, 1, 6, 'Bento Leitão'),
(39, 2, 6, 'José Carlos Esteves'),
(40, 1, 6, 'António Martins'),
(41, 2, 6, 'Nélson Puga'),
(42, 2, 1, 'Pinto da Costa'),
(43, 1, 7, 'Duarte Pinto');

-- --------------------------------------------------------

--
-- Table structure for table `integrantes_lexico`
--

CREATE TABLE IF NOT EXISTS `integrantes_lexico` (
  `idintegrante` int(11) NOT NULL,
  `idlexico` int(11) NOT NULL,
  PRIMARY KEY (`idintegrante`,`idlexico`),
  KEY `idlexico` (`idlexico`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `integrantes_lexico`
--

INSERT INTO `integrantes_lexico` (`idintegrante`, `idlexico`) VALUES
(26, 199),
(26, 200),
(26, 201),
(26, 202),
(26, 203),
(26, 204),
(26, 205),
(26, 206),
(26, 207),
(26, 208),
(26, 209),
(26, 210),
(26, 211),
(26, 212),
(26, 213),
(26, 214),
(26, 215),
(26, 216),
(26, 217),
(26, 218),
(26, 219),
(26, 220),
(26, 221),
(26, 222),
(26, 223),
(26, 224),
(26, 225),
(26, 226),
(26, 227),
(26, 228),
(26, 229),
(26, 230),
(26, 231),
(26, 232),
(26, 233),
(26, 234),
(26, 235),
(26, 236),
(26, 237),
(26, 238),
(26, 239),
(26, 240),
(26, 241),
(26, 242),
(8, 329),
(8, 330),
(8, 331),
(8, 332),
(8, 333),
(8, 334),
(3, 335),
(3, 336),
(3, 337),
(3, 338),
(3, 339),
(3, 340),
(3, 341),
(3, 342),
(3, 343),
(3, 344),
(3, 345),
(3, 346),
(3, 347),
(3, 348),
(3, 349),
(3, 350),
(3, 351),
(3, 352),
(3, 353),
(3, 354),
(3, 355),
(3, 356);

-- --------------------------------------------------------

--
-- Table structure for table `lexico`
--

CREATE TABLE IF NOT EXISTS `lexico` (
  `nucleo` varchar(255) NOT NULL,
  `contexto` varchar(255) NOT NULL,
  `entidade` varchar(255) NOT NULL,
  `tipo` varchar(255) NOT NULL,
  `pol` int(10) NOT NULL,
  `ambiguidade` int(10) NOT NULL,
  `idlexico` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`idlexico`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=431 ;

--
-- Dumping data for table `lexico`
--

INSERT INTO `lexico` (`nucleo`, `contexto`, `entidade`, `tipo`, `pol`, `ambiguidade`, `idlexico`) VALUES
('slb', 'slb', 'SLB', 'sigla', 0, 0, 1),
('s.l.b', 's.l.b', 'SLB', 'sigla', 0, 0, 2),
('s l b', 's l b', 'SLB', 'sigla', 0, 0, 3),
('sport', 'sport lisboa e benfica', 'SLB', 'nome', 0, 0, 4),
('benfica', 'benfica', 'SLB', 'alternativo', 0, 1, 5),
('benfica', 's.l.benfica', 'SLB', 'alternativo', 0, 0, 6),
('benfica', 's.l benfica', 'SLB', 'alternativo', 0, 0, 7),
('benfica', 's l benfica', 'SLB', 'alternativo', 0, 0, 8),
('benfica', 'sl benfica', 'SLB', 'alternativo', 0, 0, 9),
('slbenfica', 'slbenfica', 'SLB', 'alternativo', 0, 0, 10),
('glorioso', 'glorioso', 'SLB', 'alcunha', 1, 1, 11),
('clube', 'clube da luz', 'SLB', 'alcunha', 0, 0, 12),
('clube', 'clube encarnado', 'SLB', 'alcunha', 0, 1, 13),
('aguias', 'Ã¡guias', 'SLB', 'alcunha', 0, 1, 14),
('gaivotas', 'gaivotas', 'SLB', 'alcunha', -1, 1, 15),
('gayvotas', 'gayvotas', 'SLB', 'alcunha', -1, 0, 16),
('benfilixo', 'benfilixo', 'SLB', 'alcunha', -1, 0, 17),
('lampioes', 'lampiÃµes', 'SLB', 'alcunha', -1, 0, 18),
('fcp', 'fcp', 'FCP', 'sigla', 0, 0, 19),
('f.c.p', 'f.c.p', 'FCP', 'sigla', 0, 0, 20),
('f c p', 'f c p', 'FCP', 'sigla', 0, 0, 21),
('futebol', 'futebol clube do porto', 'FCP', 'nome', 0, 0, 22),
('porto', 'porto', 'FCP', 'alternativo', 0, 1, 23),
('porto', 'f.c.porto', 'FCP', 'alternativo', 0, 0, 24),
('porto', 'f.c porto', 'FCP', 'alternativo', 0, 0, 25),
('porto', 'f c porto', 'FCP', 'alternativo', 0, 0, 26),
('porto', 'fc porto', 'FCP', 'alternativo', 0, 0, 27),
('fcporto', 'fcporto', 'FCP', 'alternativo', 0, 0, 28),
('dragoes', 'dragÃµes', 'FCP', 'alcunha', 0, 1, 29),
('dragays', 'dragays', 'FCP', 'alcunha', -1, 0, 30),
('clube', 'clube corrupto', 'FCP', 'alcunha', -1, 0, 31),
('clube', 'clube da fruta', 'FCP', 'alcunha', -1, 0, 32),
('clube', 'clube do cafÃ© com leite', 'FCP', 'alcunha', -1, 0, 33),
('fruta', 'fruta corrupÃ§Ã£o e putedo', 'FCP', 'alcunha', -1, 0, 34),
('scp', 'scp', 'SCP', 'sigla', 0, 0, 35),
('s.c.p', 's.c.p', 'SCP', 'sigla', 0, 0, 36),
('s c p', 's c p', 'SCP', 'sigla', 0, 0, 37),
('sporting', 'sporting clube de portugal', 'SCP', 'nome', 0, 0, 38),
('sporting', 'sporting', 'SCP', 'alternativo', 0, 1, 39),
('sporting', 'sporting lisboa', 'SCP', 'alternativo', 0, 0, 40),
('sporting', 'sporting.c.p', 'SCP', 'alternativo', 0, 0, 41),
('sportingcp', 'sportingcp', 'SCP', 'alternativo', 0, 0, 42),
('sporting', 'sporting c.p', 'SCP', 'alternativo', 0, 0, 43),
('sporting', 'sporting c p', 'SCP', 'alternativo', 0, 0, 44),
('sporting', 'sporting cp', 'SCP', 'alternativo', 0, 0, 45),
('leoes', 'leÃµes', 'SCP', 'alcunha', 0, 1, 46),
('lagartos', 'lagartos', 'SCP', 'alcunha', -1, 1, 47),
('lagartagem', 'lagartagem', 'SCP', 'alcunha', -1, 1, 48),
('osgas', 'osgas', 'SCP', 'alcunha', -1, 1, 49),
('submissos', 'submissos clube do porto', 'SCP', 'alcunha', -1, 0, 50),
('submissos', 'submissos', 'SCP', 'alcunha', -1, 1, 51),
('zbordem', 'zbordem', 'SCP', 'alcunha', -1, 0, 52),
('zbording', 'zbording', 'SCP', 'alcunha', -1, 0, 53),
('estadio', 'estÃ¡dio da luz', 'EstÃ¡dio da Luz', 'nome', 0, 0, 54),
('estadio', 'estÃ¡dio do slb', 'EstÃ¡dio da Luz', 'sigla', 0, 0, 55),
('estadio', 'estÃ¡dio do s.l.b', 'EstÃ¡dio da Luz', 'sigla', 0, 0, 56),
('estadio', 'estÃ¡dio do s l b', 'EstÃ¡dio da Luz', 'sigla', 0, 0, 57),
('estadio', 'estÃ¡dio do sport lisboa e benfica', 'EstÃ¡dio da Luz', 'nome', 0, 0, 58),
('estadio', 'estÃ¡dio do benfica', 'EstÃ¡dio da Luz', 'alternativo', 0, 1, 59),
('estadio', 'estÃ¡dio do s.l.benfica', 'EstÃ¡dio da Luz', 'alternativo', 0, 0, 60),
('estadio', 'estÃ¡dio do s.l benfica', 'EstÃ¡dio da Luz', 'alternativo', 0, 0, 61),
('estadio', 'estÃ¡dio do s l benfica', 'EstÃ¡dio da Luz', 'alternativo', 0, 0, 62),
('estadio', 'estÃ¡dio do sl benfica', 'EstÃ¡dio da Luz', 'alternativo', 0, 0, 63),
('estadio', 'estÃ¡dio do slbenfica', 'EstÃ¡dio da Luz', 'alternativo', 0, 0, 64),
('estadio', 'estÃ¡dio do glorioso', 'EstÃ¡dio da Luz', 'alcunha', 1, 1, 65),
('estadio', 'estÃ¡dio do clube da luz', 'EstÃ¡dio da Luz', 'alcunha', 0, 0, 66),
('estadio', 'estÃ¡dio do clube encarnado', 'EstÃ¡dio da Luz', 'alcunha', 0, 1, 67),
('estadio', 'estÃ¡dio das Ã¡guias', 'EstÃ¡dio da Luz', 'alcunha', 0, 1, 68),
('estadio', 'estÃ¡dio das gaivotas', 'EstÃ¡dio da Luz', 'alcunha', -1, 1, 69),
('estadio', 'estÃ¡dio das gayvotas', 'EstÃ¡dio da Luz', 'alcunha', -1, 0, 70),
('estadio', 'estÃ¡dio do benfilixo', 'EstÃ¡dio da Luz', 'alcunha', -1, 0, 71),
('estadio', 'estÃ¡dio dos lampiÃµes', 'EstÃ¡dio da Luz', 'alcunha', -1, 0, 72),
('luz', 'luz', 'EstÃ¡dio da Luz', 'alternativo', 0, 1, 73),
('inferno', 'inferno da luz', 'EstÃ¡dio da Luz', 'alternativo', 1, 0, 74),
('catedral', 'catedral', 'EstÃ¡dio da Luz', 'alternativo', 1, 1, 75),
('gaiola', 'gaiola', 'EstÃ¡dio da Luz', 'alternativo', -1, 1, 76),
('galinheiro', 'galinheiro', 'EstÃ¡dio da Luz', 'alternativo', -1, 1, 77),
('estadio', 'estÃ¡dio do dragÃ£o', 'EstÃ¡dio do DragÃ£o', 'nome', 0, 0, 78),
('estadio', 'estÃ¡dio do fcp', 'EstÃ¡dio do DragÃ£o', 'sigla', 0, 0, 79),
('estadio', 'estÃ¡dio do f.c.p', 'EstÃ¡dio do DragÃ£o', 'sigla', 0, 0, 80),
('estadio', 'estÃ¡dio do f c p', 'EstÃ¡dio do DragÃ£o', 'sigla', 0, 0, 81),
('estadio', 'estÃ¡dio do futebol clube do porto', 'EstÃ¡dio do DragÃ£o', 'nome', 0, 0, 82),
('estadio', 'estÃ¡dio do porto', 'EstÃ¡dio do DragÃ£o', 'alternativo', 0, 1, 83),
('estadio', 'estÃ¡dio do f.c.porto', 'EstÃ¡dio do DragÃ£o', 'alternativo', 0, 0, 84),
('estadio', 'estÃ¡dio do f.c porto', 'EstÃ¡dio do DragÃ£o', 'alternativo', 0, 0, 85),
('estadio', 'estÃ¡dio do f c porto', 'EstÃ¡dio do DragÃ£o', 'alternativo', 0, 0, 86),
('estadio', 'estÃ¡dio do fc porto', 'EstÃ¡dio do DragÃ£o', 'alternativo', 0, 0, 87),
('estadio', 'estÃ¡dio do fcporto', 'EstÃ¡dio do DragÃ£o', 'alternativo', 0, 0, 88),
('estadio', 'estÃ¡dio dos dragÃµes', 'EstÃ¡dio do DragÃ£o', 'alcunha', 0, 1, 89),
('estadio', 'estÃ¡dio dos dragays', 'EstÃ¡dio do DragÃ£o', 'alcunha', -1, 0, 90),
('estadio', 'estÃ¡dio do clube corrupto', 'EstÃ¡dio do DragÃ£o', 'alcunha', -1, 0, 91),
('estadio', 'estÃ¡dio do clube da fruta', 'EstÃ¡dio do DragÃ£o', 'alcunha', -1, 0, 92),
('estadio', 'estÃ¡dio do clube do cafÃ© com leite', 'EstÃ¡dio do DragÃ£o', 'alcunha', -1, 0, 93),
('estadio', 'estÃ¡dio do fruta corrupÃ§Ã£o e putedo', 'EstÃ¡dio do DragÃ£o', 'alcunha', -1, 0, 94),
('dragao', 'dragÃ£o', 'EstÃ¡dio do DragÃ£o', 'alternativo', 0, 1, 95),
('contumil', 'contumil', 'EstÃ¡dio do DragÃ£o', 'alternativo', -1, 1, 96),
('estadio', 'estÃ¡dio alvalade xxi', 'EstÃ¡dio Alvalade XXI', 'nome', 0, 0, 97),
('estadio', 'estÃ¡dio do scp', 'EstÃ¡dio Alvalade XXI', 'sigla', 0, 0, 98),
('estadio', 'estÃ¡dio do s.c.p', 'EstÃ¡dio Alvalade XXI', 'sigla', 0, 0, 99),
('estadio', 'estÃ¡dio do s c p', 'EstÃ¡dio Alvalade XXI', 'sigla', 0, 0, 100),
('estadio', 'estÃ¡dio do sporting clube de portugal', 'EstÃ¡dio Alvalade XXI', 'nome', 0, 0, 101),
('estadio', 'estÃ¡dio do sporting', 'EstÃ¡dio Alvalade XXI', 'alternativo', 0, 1, 102),
('estadio', 'estÃ¡dio do sporting lisboa', 'EstÃ¡dio Alvalade XXI', 'alternativo', 0, 0, 103),
('estadio', 'estÃ¡dio do sporting.c.p', 'EstÃ¡dio Alvalade XXI', 'alternativo', 0, 0, 104),
('estadio', 'estÃ¡dio do sportingcp', 'EstÃ¡dio Alvalade XXI', 'alternativo', 0, 0, 105),
('estadio', 'estÃ¡dio do sporting c.p', 'EstÃ¡dio Alvalade XXI', 'alternativo', 0, 0, 106),
('estadio', 'estÃ¡dio do sporting c p', 'EstÃ¡dio Alvalade XXI', 'alternativo', 0, 0, 107),
('estadio', 'estÃ¡dio do sporting cp', 'EstÃ¡dio Alvalade XXI', 'alternativo', 0, 0, 108),
('estadio', 'estÃ¡dio dos leÃµes', 'EstÃ¡dio Alvalade XXI', 'alcunha', 0, 1, 109),
('estadio', 'estÃ¡dio dos lagartos', 'EstÃ¡dio Alvalade XXI', 'alcunha', -1, 1, 110),
('estadio', 'estÃ¡dio da lagartagem', 'EstÃ¡dio Alvalade XXI', 'alcunha', -1, 1, 111),
('estadio', 'estÃ¡dio das osgas', 'EstÃ¡dio Alvalade XXI', 'alcunha', -1, 1, 112),
('estadio', 'estÃ¡dio dos submissos clube do porto', 'EstÃ¡dio Alvalade XXI', 'alcunha', -1, 0, 113),
('estadio', 'estÃ¡dio dos submissos', 'EstÃ¡dio Alvalade XXI', 'alcunha', -1, 1, 114),
('estadio', 'estÃ¡dio do zbordem', 'EstÃ¡dio Alvalade XXI', 'alcunha', -1, 0, 115),
('estadio', 'estÃ¡dio do zbording', 'EstÃ¡dio Alvalade XXI', 'alcunha', -1, 0, 116),
('alvalade', 'alvalade', 'EstÃ¡dio Alvalade XXI', 'alternativo', 0, 1, 117),
('wc', 'wc', 'EstÃ¡dio Alvalade XXI', 'alternativo', -1, 1, 118),
('casa', 'casa de banho', 'EstÃ¡dio Alvalade XXI', 'alternativo', -1, 1, 119),
('alvalixo', 'alvalixo', 'EstÃ¡dio Alvalade XXI', 'alternativo', -1, 0, 120),
('alvalidl', 'alvalidl', 'EstÃ¡dio Alvalade XXI', 'alternativo', -1, 0, 121),
('luis', 'luis filipe vieira', 'Luis Filipe Vieira', 'nome', 0, 0, 122),
('lfv', 'lfv', 'Luis Filipe Vieira', 'sigla', 0, 0, 123),
('filipe', 'filipe vieira', 'Luis Filipe Vieira', 'alternativo', 0, 0, 124),
('presidente', 'presidente do slb', 'Luis Filipe Vieira', 'sigla', 0, 0, 125),
('presidente', 'presidente do s.l.b', 'Luis Filipe Vieira', 'sigla', 0, 0, 126),
('presidente', 'presidente do s l b', 'Luis Filipe Vieira', 'sigla', 0, 0, 127),
('presidente', 'presidente do sport lisboa e benfica', 'Luis Filipe Vieira', 'nome', 0, 0, 128),
('presidente', 'presidente do benfica', 'Luis Filipe Vieira', 'alternativo', 0, 1, 129),
('presidente', 'presidente do s.l.benfica', 'Luis Filipe Vieira', 'alternativo', 0, 0, 130),
('presidente', 'presidente do s.l benfica', 'Luis Filipe Vieira', 'alternativo', 0, 0, 131),
('presidente', 'presidente do s l benfica', 'Luis Filipe Vieira', 'alternativo', 0, 0, 132),
('presidente', 'presidente do sl benfica', 'Luis Filipe Vieira', 'alternativo', 0, 0, 133),
('presidente', 'presidente do slbenfica', 'Luis Filipe Vieira', 'alternativo', 0, 0, 134),
('presidente', 'presidente do glorioso', 'Luis Filipe Vieira', 'alcunha', 1, 1, 135),
('presidente', 'presidente do clube da luz', 'Luis Filipe Vieira', 'alcunha', 0, 0, 136),
('presidente', 'presidente do clube encarnado', 'Luis Filipe Vieira', 'alcunha', 0, 1, 137),
('presidente', 'presidente das Ã¡guias', 'Luis Filipe Vieira', 'alcunha', 0, 1, 138),
('presidente', 'presidente das gaivotas', 'Luis Filipe Vieira', 'alcunha', -1, 1, 139),
('presidente', 'presidente das gayvotas', 'Luis Filipe Vieira', 'alcunha', -1, 0, 140),
('presidente', 'presidente do benfilixo', 'Luis Filipe Vieira', 'alcunha', -1, 0, 141),
('presidente', 'presidente dos lampiÃµes', 'Luis Filipe Vieira', 'alcunha', -1, 0, 142),
('presidente', 'presidente benfiquista', 'Luis Filipe Vieira', 'alternativo', 0, 0, 143),
('presidente', 'presidente encarnado', 'Luis Filipe Vieira', 'alternativo', 0, 0, 144),
('orelhas', 'orelhas', 'Luis Filipe Vieira', 'alternativo', -1, 0, 145),
('jorge', 'jorge nuno pinto da costa', 'Jorge Nuno Pinto da Costa', 'nome', 0, 0, 146),
('pinto', 'pinto da costa', 'Jorge Nuno Pinto da Costa', 'alternativo', 0, 0, 147),
('pinto', 'pinto da bosta', 'Jorge Nuno Pinto da Costa', 'alcunha', -1, 0, 148),
('pintinho', 'pintinho da costa', 'Jorge Nuno Pinto da Costa', 'alcunha', -1, 0, 149),
('pintinho', 'pintinho da bosta', 'Jorge Nuno Pinto da Costa', 'alcunha', -1, 0, 150),
('pdc', 'pdc', 'Jorge Nuno Pinto da Costa', 'sigla', 0, 1, 151),
('presidente', 'presidente do fcp', 'Jorge Nuno Pinto da Costa', 'sigla', 0, 0, 152),
('presidente', 'presidente do f.c.p', 'Jorge Nuno Pinto da Costa', 'sigla', 0, 0, 153),
('presidente', 'presidente do f c p', 'Jorge Nuno Pinto da Costa', 'sigla', 0, 0, 154),
('presidente', 'presidente do futebol clube do porto', 'Jorge Nuno Pinto da Costa', 'nome', 0, 0, 155),
('presidente', 'presidente do porto', 'Jorge Nuno Pinto da Costa', 'alternativo', 0, 1, 156),
('presidente', 'presidente do f.c.porto', 'Jorge Nuno Pinto da Costa', 'alternativo', 0, 0, 157),
('presidente', 'presidente do f.c porto', 'Jorge Nuno Pinto da Costa', 'alternativo', 0, 0, 158),
('presidente', 'presidente do f c porto', 'Jorge Nuno Pinto da Costa', 'alternativo', 0, 0, 159),
('presidente', 'presidente do fc porto', 'Jorge Nuno Pinto da Costa', 'alternativo', 0, 0, 160),
('presidente', 'presidente do fcporto', 'Jorge Nuno Pinto da Costa', 'alternativo', 0, 0, 161),
('presidente', 'presidente dos dragÃµes', 'Jorge Nuno Pinto da Costa', 'alcunha', 0, 1, 162),
('presidente', 'presidente dos dragays', 'Jorge Nuno Pinto da Costa', 'alcunha', -1, 0, 163),
('presidente', 'presidente do clube corrupto', 'Jorge Nuno Pinto da Costa', 'alcunha', -1, 0, 164),
('presidente', 'presidente do clube da fruta', 'Jorge Nuno Pinto da Costa', 'alcunha', -1, 0, 165),
('presidente', 'presidente do clube do cafÃ© com leite', 'Jorge Nuno Pinto da Costa', 'alcunha', -1, 0, 166),
('presidente', 'presidente do fruta corrupÃ§Ã£o e putedo', 'Jorge Nuno Pinto da Costa', 'alcunha', -1, 0, 167),
('presidente', 'presidente corrupto', 'Jorge Nuno Pinto da Costa', 'alcunha', -1, 1, 168),
('presidente', 'presidente portista', 'Jorge Nuno Pinto da Costa', 'alcunha', 0, 0, 169),
('presidente', 'presidente azul', 'Jorge Nuno Pinto da Costa', 'alcunha', 0, 1, 170),
('pintelho', 'pintelho da bosta', 'Jorge Nuno Pinto da Costa', 'alcunha', -1, 0, 171),
('pintelho', 'pintelho da costa', 'Jorge Nuno Pinto da Costa', 'alcunha', -1, 0, 172),
('bimbo', 'bimbo da bosta', 'Jorge Nuno Pinto da Costa', 'alcunha', -1, 0, 173),
('bimbo', 'bimbo da costa', 'Jorge Nuno Pinto da Costa', 'alcunha', -1, 0, 174),
('corrupto', 'corrupto mor', 'Jorge Nuno Pinto da Costa', 'alcunha', -1, 1, 175),
('jose', 'josÃ© godinho lopes', 'JosÃ© Godinho Lopes', 'nome', 0, 0, 176),
('godinho', 'godinho lopes', 'JosÃ© Godinho Lopes', 'alternativo', 0, 0, 177),
('presidente', 'presidente do scp', 'JosÃ© Godinho Lopes', 'sigla', 0, 0, 178),
('presidente', 'presidente do s.c.p', 'JosÃ© Godinho Lopes', 'sigla', 0, 0, 179),
('presidente', 'presidente do s c p', 'JosÃ© Godinho Lopes', 'sigla', 0, 0, 180),
('presidente', 'presidente do sporting clube de portugal', 'JosÃ© Godinho Lopes', 'nome', 0, 0, 181),
('presidente', 'presidente do sporting', 'JosÃ© Godinho Lopes', 'alternativo', 0, 1, 182),
('presidente', 'presidente do sporting lisboa', 'JosÃ© Godinho Lopes', 'alternativo', 0, 0, 183),
('presidente', 'presidente do sporting.c.p', 'JosÃ© Godinho Lopes', 'alternativo', 0, 0, 184),
('presidente', 'presidente do sportingcp', 'JosÃ© Godinho Lopes', 'alternativo', 0, 0, 185),
('presidente', 'presidente do sporting c.p', 'JosÃ© Godinho Lopes', 'alternativo', 0, 0, 186),
('presidente', 'presidente do sporting c p', 'JosÃ© Godinho Lopes', 'alternativo', 0, 0, 187),
('presidente', 'presidente do sporting cp', 'JosÃ© Godinho Lopes', 'alternativo', 0, 0, 188),
('presidente', 'presidente dos leÃµes', 'JosÃ© Godinho Lopes', 'alcunha', 0, 1, 189),
('presidente', 'presidente dos lagartos', 'JosÃ© Godinho Lopes', 'alcunha', -1, 1, 190),
('presidente', 'presidente da lagartagem', 'JosÃ© Godinho Lopes', 'alcunha', -1, 1, 191),
('presidente', 'presidente das osgas', 'JosÃ© Godinho Lopes', 'alcunha', -1, 1, 192),
('presidente', 'presidente dos submissos clube do porto', 'JosÃ© Godinho Lopes', 'alcunha', -1, 0, 193),
('presidente', 'presidente dos submissos', 'JosÃ© Godinho Lopes', 'alcunha', -1, 1, 194),
('presidente', 'presidente do zbordem', 'JosÃ© Godinho Lopes', 'alcunha', -1, 0, 195),
('presidente', 'presidente do zbording', 'JosÃ© Godinho Lopes', 'alcunha', -1, 0, 196),
('presidente', 'presidente sportinguista', 'JosÃ© Godinho Lopes', 'alternativo', 0, 0, 197),
('presidente', 'presidente verde', 'JosÃ© Godinho Lopes', 'alternativo', 0, 0, 198),
('jorge', 'jorge jesus', 'Jorge Jesus', 'nome', 0, 0, 199),
('jj', 'jj', 'Jorge Jesus', 'sigla', 0, 1, 200),
('mister', 'mister do slb', 'Jorge Jesus', 'sigla', 0, 0, 201),
('mister', 'mister do s.l.b', 'Jorge Jesus', 'sigla', 0, 0, 202),
('mister', 'mister do s l b', 'Jorge Jesus', 'sigla', 0, 0, 203),
('mister', 'mister do sport lisboa e benfica', 'Jorge Jesus', 'nome', 0, 0, 204),
('mister', 'mister do benfica', 'Jorge Jesus', 'alternativo', 0, 1, 205),
('mister', 'mister do s.l.benfica', 'Jorge Jesus', 'alternativo', 0, 0, 206),
('mister', 'mister do s.l benfica', 'Jorge Jesus', 'alternativo', 0, 0, 207),
('mister', 'mister do s l benfica', 'Jorge Jesus', 'alternativo', 0, 0, 208),
('mister', 'mister do sl benfica', 'Jorge Jesus', 'alternativo', 0, 0, 209),
('mister', 'mister do slbenfica', 'Jorge Jesus', 'alternativo', 0, 0, 210),
('mister', 'mister do glorioso', 'Jorge Jesus', 'alcunha', 1, 1, 211),
('mister', 'mister do clube da luz', 'Jorge Jesus', 'alcunha', 0, 0, 212),
('mister', 'mister do clube encarnado', 'Jorge Jesus', 'alcunha', 0, 1, 213),
('mister', 'mister das Ã¡guias', 'Jorge Jesus', 'alcunha', 0, 1, 214),
('mister', 'mister das gaivotas', 'Jorge Jesus', 'alcunha', -1, 1, 215),
('mister', 'mister das gayvotas', 'Jorge Jesus', 'alcunha', -1, 0, 216),
('mister', 'mister do benfilixo', 'Jorge Jesus', 'alcunha', -1, 0, 217),
('mister', 'mister dos lampiÃµes', 'Jorge Jesus', 'alcunha', -1, 0, 218),
('mister', 'mister jesus', 'Jorge Jesus', 'alternativo', 0, 0, 219),
('mister', 'mister jorge jesus', 'Jorge Jesus', 'alternativo', 0, 0, 220),
('treinador', 'treinador do slb', 'Jorge Jesus', 'sigla', 0, 0, 221),
('treinador', 'treinador do s.l.b', 'Jorge Jesus', 'sigla', 0, 0, 222),
('treinador', 'treinador do s l b', 'Jorge Jesus', 'sigla', 0, 0, 223),
('treinador', 'treinador do sport lisboa e benfica', 'Jorge Jesus', 'nome', 0, 0, 224),
('treinador', 'treinador do benfica', 'Jorge Jesus', 'alternativo', 0, 1, 225),
('treinador', 'treinador do s.l.benfica', 'Jorge Jesus', 'alternativo', 0, 0, 226),
('treinador', 'treinador do s.l benfica', 'Jorge Jesus', 'alternativo', 0, 0, 227),
('treinador', 'treinador do s l benfica', 'Jorge Jesus', 'alternativo', 0, 0, 228),
('treinador', 'treinador do sl benfica', 'Jorge Jesus', 'alternativo', 0, 0, 229),
('treinador', 'treinador do slbenfica', 'Jorge Jesus', 'alternativo', 0, 0, 230),
('treinador', 'treinador do glorioso', 'Jorge Jesus', 'alcunha', 1, 1, 231),
('treinador', 'treinador do clube da luz', 'Jorge Jesus', 'alcunha', 0, 0, 232),
('treinador', 'treinador do clube encarnado', 'Jorge Jesus', 'alcunha', 0, 1, 233),
('treinador', 'treinador das Ã¡guias', 'Jorge Jesus', 'alcunha', 0, 1, 234),
('treinador', 'treinador das gaivotas', 'Jorge Jesus', 'alcunha', -1, 1, 235),
('treinador', 'treinador das gayvotas', 'Jorge Jesus', 'alcunha', -1, 0, 236),
('treinador', 'treinador do benfilixo', 'Jorge Jesus', 'alcunha', -1, 0, 237),
('treinador', 'treinador dos lampiÃµes', 'Jorge Jesus', 'alcunha', -1, 0, 238),
('treinador', 'treinador jesus', 'Jorge Jesus', 'alternativo', 0, 0, 239),
('treinador', 'treinador jorge jesus', 'Jorge Jesus', 'alternativo', 0, 0, 240),
('treinador', 'treinador benfiquista', 'Jorge Jesus', 'alternativo', 0, 0, 241),
('treinador', 'treinador encarnado', 'Jorge Jesus', 'alternativo', 0, 0, 242),
('vitor', 'vÃ­tor pereira', 'VÃ­tor Pereira', 'nome', 0, 1, 243),
('mister', 'mister vÃ­tor pereira', 'VÃ­tor Pereira', 'alternativo', 0, 0, 244),
('mister', 'mister pereira', 'VÃ­tor Pereira', 'alternativo', 0, 0, 245),
('mister', 'mister do fcp', 'VÃ­tor Pereira', 'sigla', 0, 0, 246),
('mister', 'mister do f.c.p', 'VÃ­tor Pereira', 'sigla', 0, 0, 247),
('mister', 'mister do f c p', 'VÃ­tor Pereira', 'sigla', 0, 0, 248),
('mister', 'mister do futebol clube do porto', 'VÃ­tor Pereira', 'nome', 0, 0, 249),
('mister', 'mister do porto', 'VÃ­tor Pereira', 'alternativo', 0, 1, 250),
('mister', 'mister do f.c.porto', 'VÃ­tor Pereira', 'alternativo', 0, 0, 251),
('mister', 'mister do f.c porto', 'VÃ­tor Pereira', 'alternativo', 0, 0, 252),
('mister', 'mister do f c porto', 'VÃ­tor Pereira', 'alternativo', 0, 0, 253),
('mister', 'mister do fc porto', 'VÃ­tor Pereira', 'alternativo', 0, 0, 254),
('mister', 'mister do fcporto', 'VÃ­tor Pereira', 'alternativo', 0, 0, 255),
('mister', 'mister dos dragÃµes', 'VÃ­tor Pereira', 'alcunha', 0, 1, 256),
('mister', 'mister dos dragays', 'VÃ­tor Pereira', 'alcunha', -1, 0, 257),
('mister', 'mister do clube corrupto', 'VÃ­tor Pereira', 'alcunha', -1, 0, 258),
('mister', 'mister do clube da fruta', 'VÃ­tor Pereira', 'alcunha', -1, 0, 259),
('mister', 'mister do clube do cafÃ© com leite', 'VÃ­tor Pereira', 'alcunha', -1, 0, 260),
('mister', 'mister do fruta corrupÃ§Ã£o e putedo', 'VÃ­tor Pereira', 'alcunha', -1, 0, 261),
('treinador', 'treinador vÃ­tor pereira', 'VÃ­tor Pereira', 'alternativo', 0, 0, 262),
('treinador', 'treinador pereira', 'VÃ­tor Pereira', 'alternativo', 0, 0, 263),
('treinador', 'treinador do fcp', 'VÃ­tor Pereira', 'sigla', 0, 0, 264),
('treinador', 'treinador do f.c.p', 'VÃ­tor Pereira', 'sigla', 0, 0, 265),
('treinador', 'treinador do f c p', 'VÃ­tor Pereira', 'sigla', 0, 0, 266),
('treinador', 'treinador do futebol clube do porto', 'VÃ­tor Pereira', 'nome', 0, 0, 267),
('treinador', 'treinador do porto', 'VÃ­tor Pereira', 'alternativo', 0, 1, 268),
('treinador', 'treinador do f.c.porto', 'VÃ­tor Pereira', 'alternativo', 0, 0, 269),
('treinador', 'treinador do f.c porto', 'VÃ­tor Pereira', 'alternativo', 0, 0, 270),
('treinador', 'treinador do f c porto', 'VÃ­tor Pereira', 'alternativo', 0, 0, 271),
('treinador', 'treinador do fc porto', 'VÃ­tor Pereira', 'alternativo', 0, 0, 272),
('treinador', 'treinador do fcporto', 'VÃ­tor Pereira', 'alternativo', 0, 0, 273),
('treinador', 'treinador dos dragÃµes', 'VÃ­tor Pereira', 'alcunha', 0, 1, 274),
('treinador', 'treinador dos dragays', 'VÃ­tor Pereira', 'alcunha', -1, 0, 275),
('treinador', 'treinador do clube corrupto', 'VÃ­tor Pereira', 'alcunha', -1, 0, 276),
('treinador', 'treinador do clube da fruta', 'VÃ­tor Pereira', 'alcunha', -1, 0, 277),
('treinador', 'treinador do clube do cafÃ© com leite', 'VÃ­tor Pereira', 'alcunha', -1, 0, 278),
('treinador', 'treinador do fruta corrupÃ§Ã£o e putedo', 'VÃ­tor Pereira', 'alcunha', -1, 0, 279),
('treinador', 'treinador portista', 'VÃ­tor Pereira', 'alternativo', 0, 0, 280),
('treinador', 'treinador azul', 'VÃ­tor Pereira', 'alternativo', 0, 1, 281),
('domingos', 'domingos paciencia', 'Domingos Paciencia', 'nome', 0, 0, 282),
('mister', 'mister domingos paciencia', 'Domingos Paciencia', 'alternativo', 0, 0, 283),
('mister', 'mister domingos', 'Domingos Paciencia', 'alternativo', 0, 0, 284),
('mister', 'mister do scp', 'Domingos Paciencia', 'sigla', 0, 0, 285),
('mister', 'mister do s.c.p', 'Domingos Paciencia', 'sigla', 0, 0, 286),
('mister', 'mister do s c p', 'Domingos Paciencia', 'sigla', 0, 0, 287),
('mister', 'mister do sporting clube de portugal', 'Domingos Paciencia', 'nome', 0, 0, 288),
('mister', 'mister do sporting', 'Domingos Paciencia', 'alternativo', 0, 1, 289),
('mister', 'mister do sporting lisboa', 'Domingos Paciencia', 'alternativo', 0, 0, 290),
('mister', 'mister do sporting.c.p', 'Domingos Paciencia', 'alternativo', 0, 0, 291),
('mister', 'mister do sportingcp', 'Domingos Paciencia', 'alternativo', 0, 0, 292),
('mister', 'mister do sporting c.p', 'Domingos Paciencia', 'alternativo', 0, 0, 293),
('mister', 'mister do sporting c p', 'Domingos Paciencia', 'alternativo', 0, 0, 294),
('mister', 'mister do sporting cp', 'Domingos Paciencia', 'alternativo', 0, 0, 295),
('mister', 'mister dos leÃµes', 'Domingos Paciencia', 'alcunha', 0, 1, 296),
('mister', 'mister dos lagartos', 'Domingos Paciencia', 'alcunha', -1, 1, 297),
('mister', 'mister da lagartagem', 'Domingos Paciencia', 'alcunha', -1, 1, 298),
('mister', 'mister das osgas', 'Domingos Paciencia', 'alcunha', -1, 1, 299),
('mister', 'mister dos submissos clube do porto', 'Domingos Paciencia', 'alcunha', -1, 0, 300),
('mister', 'mister dos submissos', 'Domingos Paciencia', 'alcunha', -1, 1, 301),
('mister', 'mister do zbordem', 'Domingos Paciencia', 'alcunha', -1, 0, 302),
('mister', 'mister do zbording', 'Domingos Paciencia', 'alcunha', -1, 0, 303),
('treinador', 'treinador domingos paciencia', 'Domingos Paciencia', 'alternativo', 0, 0, 304),
('treinador', 'treinador domingos', 'Domingos Paciencia', 'alternativo', 0, 0, 305),
('treinador', 'treinador do scp', 'Domingos Paciencia', 'sigla', 0, 0, 306),
('treinador', 'treinador do s.c.p', 'Domingos Paciencia', 'sigla', 0, 0, 307),
('treinador', 'treinador do s c p', 'Domingos Paciencia', 'sigla', 0, 0, 308),
('treinador', 'treinador do sporting clube de portugal', 'Domingos Paciencia', 'nome', 0, 0, 309),
('treinador', 'treinador do sporting', 'Domingos Paciencia', 'alternativo', 0, 1, 310),
('treinador', 'treinador do sporting lisboa', 'Domingos Paciencia', 'alternativo', 0, 0, 311),
('treinador', 'treinador do sporting.c.p', 'Domingos Paciencia', 'alternativo', 0, 0, 312),
('treinador', 'treinador do sportingcp', 'Domingos Paciencia', 'alternativo', 0, 0, 313),
('treinador', 'treinador do sporting c.p', 'Domingos Paciencia', 'alternativo', 0, 0, 314),
('treinador', 'treinador do sporting c p', 'Domingos Paciencia', 'alternativo', 0, 0, 315),
('treinador', 'treinador do sporting cp', 'Domingos Paciencia', 'alternativo', 0, 0, 316),
('treinador', 'treinador dos leÃµes', 'Domingos Paciencia', 'alcunha', 0, 1, 317),
('treinador', 'treinador dos lagartos', 'Domingos Paciencia', 'alcunha', -1, 1, 318),
('treinador', 'treinador da lagartagem', 'Domingos Paciencia', 'alcunha', -1, 1, 319),
('treinador', 'treinador das osgas', 'Domingos Paciencia', 'alcunha', -1, 1, 320),
('treinador', 'treinador dos submissos clube do porto', 'Domingos Paciencia', 'alcunha', -1, 0, 321),
('treinador', 'treinador dos submissos', 'Domingos Paciencia', 'alcunha', -1, 1, 322),
('treinador', 'treinador do zbordem', 'Domingos Paciencia', 'alcunha', -1, 0, 323),
('treinador', 'treinador do zbording', 'Domingos Paciencia', 'alcunha', -1, 0, 324),
('treinador', 'treinador sportinguista', 'Domingos Paciencia', 'alternativo', 0, 0, 325),
('treinador', 'treinador verde', 'Domingos Paciencia', 'alternativo', 0, 0, 326),
('choramingas', 'choramingas paciencia', 'Domingos Paciencia', 'alcunha', -1, 0, 327),
('choramingas', 'choramingas', 'Domingos Paciencia', 'alcunha', -1, 1, 328),
('pablo', 'pablo aimar', 'Pablo Aimar', 'nome', 0, 0, 329),
('pablo', 'pablo', 'Pablo Aimar', 'alternativo', 0, 1, 330),
('aimar', 'aimar', 'Pablo Aimar', 'alternativo', 0, 1, 331),
('pablito', 'pablito aimar', 'Pablo Aimar', 'alternativo', 1, 0, 332),
('pablito', 'pablito', 'Pablo Aimar', 'alternativo', 1, 1, 333),
('mago', 'mago', 'Pablo Aimar', 'alternativo', 1, 1, 334),
('luisao', 'luisÃ£o', 'LuisÃ£o', 'nome', 0, 0, 335),
('girafa', 'girafa', 'LuisÃ£o', 'alcunha', 0, 1, 336),
('capitao', 'capitÃ£o do slb', 'LuisÃ£o', 'sigla', 0, 1, 337),
('capitao', 'capitÃ£o do s.l.b', 'LuisÃ£o', 'sigla', 0, 1, 338),
('capitao', 'capitÃ£o do s l b', 'LuisÃ£o', 'sigla', 0, 1, 339),
('capitao', 'capitÃ£o do sport lisboa e benfica', 'LuisÃ£o', 'nome', 0, 1, 340),
('capitao', 'capitÃ£o do benfica', 'LuisÃ£o', 'alternativo', 0, 1, 341),
('capitao', 'capitÃ£o do s.l.benfica', 'LuisÃ£o', 'alternativo', 0, 1, 342),
('capitao', 'capitÃ£o do s.l benfica', 'LuisÃ£o', 'alternativo', 0, 1, 343),
('capitao', 'capitÃ£o do s l benfica', 'LuisÃ£o', 'alternativo', 0, 1, 344),
('capitao', 'capitÃ£o do sl benfica', 'LuisÃ£o', 'alternativo', 0, 1, 345),
('capitao', 'capitÃ£o do slbenfica', 'LuisÃ£o', 'alternativo', 0, 1, 346),
('capitao', 'capitÃ£o do glorioso', 'LuisÃ£o', 'alcunha', 1, 1, 347),
('capitao', 'capitÃ£o do clube da luz', 'LuisÃ£o', 'alcunha', 0, 1, 348),
('capitao', 'capitÃ£o do clube encarnado', 'LuisÃ£o', 'alcunha', 0, 1, 349),
('capitao', 'capitÃ£o das Ã¡guias', 'LuisÃ£o', 'alcunha', 0, 1, 350),
('capitao', 'capitÃ£o das gaivotas', 'LuisÃ£o', 'alcunha', -1, 1, 351),
('capitao', 'capitÃ£o das gayvotas', 'LuisÃ£o', 'alcunha', -1, 1, 352),
('capitao', 'capitÃ£o do benfilixo', 'LuisÃ£o', 'alcunha', -1, 1, 353),
('capitao', 'capitÃ£o dos lampiÃµes', 'LuisÃ£o', 'alcunha', -1, 1, 354),
('capitao', 'capitÃ£o encarnado', 'LuisÃ£o', 'alternativo', 0, 1, 355),
('capitao', 'capitÃ£o benfiquista', 'LuisÃ£o', 'alternativo', 0, 1, 356),
('oscar', 'oscar cardozo', 'Oscar Cardozo', 'nome', 0, 0, 357),
('oscar', 'oscar tacuara cardozo', 'Oscar Cardozo', 'alternativo', 0, 0, 358),
('oscar', 'oscar takuara cardozo', 'Oscar Cardozo', 'alternativo', 0, 0, 359),
('oscar', 'oscar tacuara', 'Oscar Cardozo', 'alternativo', 0, 0, 360),
('oscar', 'oscar takuara', 'Oscar Cardozo', 'alternativo', 0, 0, 361),
('tacuara', 'tacuara cardozo', 'Oscar Cardozo', 'alternativo', 0, 0, 362),
('takuara', 'takuara cardozo', 'Oscar Cardozo', 'alternativo', 0, 0, 363),
('tacuara', 'tacuara', 'Oscar Cardozo', 'alternativo', 0, 1, 364),
('takuara', 'takuara', 'Oscar Cardozo', 'alternativo', 0, 1, 365),
('cardozo', 'tacuara cardozo', 'Oscar Cardozo', 'alternativo', 0, 1, 366),
('cristian', 'cristian rodrÃ­guez', 'Cristian RodrÃ­guez', 'nome', 0, 0, 367),
('rodriguez', 'rodrÃ­guez', 'Cristian RodrÃ­guez', 'alternativo', 0, 1, 368),
('cebola', 'cebola', 'Cristian RodrÃ­guez', 'alcunha', 0, 1, 369),
('helton', 'helton', 'Helton', 'nome', 0, 1, 370),
('capitao', 'capitÃ£o do fcp', 'Helton', 'sigla', 0, 1, 371),
('capitao', 'capitÃ£o do f.c.p', 'Helton', 'sigla', 0, 1, 372),
('capitao', 'capitÃ£o do f c p', 'Helton', 'sigla', 0, 1, 373),
('capitao', 'capitÃ£o do futebol clube do porto', 'Helton', 'nome', 0, 1, 374),
('capitao', 'capitÃ£o do porto', 'Helton', 'alternativo', 0, 1, 375),
('capitao', 'capitÃ£o do f.c.porto', 'Helton', 'alternativo', 0, 1, 376),
('capitao', 'capitÃ£o do f.c porto', 'Helton', 'alternativo', 0, 1, 377),
('capitao', 'capitÃ£o do f c porto', 'Helton', 'alternativo', 0, 1, 378),
('capitao', 'capitÃ£o do fc porto', 'Helton', 'alternativo', 0, 1, 379),
('capitao', 'capitÃ£o do fcporto', 'Helton', 'alternativo', 0, 1, 380),
('capitao', 'capitÃ£o dos dragÃµes', 'Helton', 'alcunha', 0, 1, 381),
('capitao', 'capitÃ£o dos dragays', 'Helton', 'alcunha', -1, 1, 382),
('capitao', 'capitÃ£o do clube corrupto', 'Helton', 'alcunha', -1, 1, 383),
('capitao', 'capitÃ£o do clube da fruta', 'Helton', 'alcunha', -1, 1, 384),
('capitao', 'capitÃ£o do clube do cafÃ© com leite', 'Helton', 'alcunha', -1, 1, 385),
('capitao', 'capitÃ£o do fruta corrupÃ§Ã£o e putedo', 'Helton', 'alcunha', -1, 1, 386),
('hulk', 'hulk', 'Hulk', 'nome', 0, 1, 387),
('incrivel', 'o incrivel hulk', 'Hulk', 'alternativo', 1, 1, 388),
('givanildo', 'givanildo', 'Hulk', 'alternativo', -1, 1, 389),
('holk', 'holk', 'holk', 'alcunha', -1, 0, 390),
('diego', 'diego capel', 'Diego Capel', 'nome', 0, 1, 391),
('capel', 'capel', 'Diego Capel', 'alternativo', 0, 1, 392),
('polga', 'polga', 'Polga', 'nome', 0, 1, 393),
('capitao', 'capitÃ£o do scp', 'Polga', 'sigla', 0, 1, 394),
('capitao', 'capitÃ£o do s.c.p', 'Polga', 'sigla', 0, 1, 395),
('capitao', 'capitÃ£o do s c p', 'Polga', 'sigla', 0, 1, 396),
('capitao', 'capitÃ£o do sporting clube de portugal', 'Polga', 'nome', 0, 1, 397),
('capitao', 'capitÃ£o do sporting', 'Polga', 'alternativo', 0, 1, 398),
('capitao', 'capitÃ£o do sporting lisboa', 'Polga', 'alternativo', 0, 1, 399),
('capitao', 'capitÃ£o do sporting.c.p', 'Polga', 'alternativo', 0, 1, 400),
('capitao', 'capitÃ£o do sportingcp', 'Polga', 'alternativo', 0, 1, 401),
('capitao', 'capitÃ£o do sporting c.p', 'Polga', 'alternativo', 0, 1, 402),
('capitao', 'capitÃ£o do sporting c p', 'Polga', 'alternativo', 0, 1, 403),
('capitao', 'capitÃ£o do sporting cp', 'Polga', 'alternativo', 0, 1, 404),
('capitao', 'capitÃ£o dos leÃµes', 'Polga', 'alcunha', 0, 1, 405),
('capitao', 'capitÃ£o dos lagartos', 'Polga', 'alcunha', -1, 1, 406),
('capitao', 'capitÃ£o da lagartagem', 'Polga', 'alcunha', -1, 1, 407),
('capitao', 'capitÃ£o das osgas', 'Polga', 'alcunha', -1, 1, 408),
('capitao', 'capitÃ£o dos submissos clube do porto', 'Polga', 'alcunha', -1, 1, 409),
('capitao', 'capitÃ£o dos submissos', 'Polga', 'alcunha', -1, 1, 410),
('capitao', 'capitÃ£o do zbordem', 'Polga', 'alcunha', -1, 1, 411),
('capitao', 'capitÃ£o do zbording', 'Polga', 'alcunha', -1, 1, 412),
('elias', 'elias', 'elias', 'nome', 0, 1, 413),
('futebol', 'futebol', 'desporto', 'topico', 0, 0, 414),
('jogador', 'jogador', 'desporto', 'topico', 0, 0, 415),
('capitao', 'capitÃ£o', 'desporto', 'topico', 0, 1, 416),
('defesa', 'defesa', 'desporto', 'topico', 0, 1, 417),
('medio', 'medio', 'desporto', 'topico', 0, 1, 418),
('avancado', 'avanÃ§ado', 'desporto', 'topico', 0, 0, 419),
('lateral', 'lateral', 'desporto', 'topico', 0, 1, 420),
('ala', 'ala', 'desporto', 'topico', 0, 1, 421),
('extremo', 'extremo', 'desporto', 'topico', 0, 1, 422),
('treinador', 'treinador', 'desporto', 'topico', 0, 0, 423),
('estadio', 'estÃ¡dio', 'desporto', 'topico', 0, 0, 424),
('clube', 'clube', 'desporto', 'topico', 0, 1, 425),
('mister', 'mister', 'desporto', 'topico', 0, 0, 426),
('sport', 'sport', 'desporto', 'topico', 0, 0, 427),
('claque', 'claque', 'desporto', 'topico', 0, 0, 428),
('adeptos', 'adeptos', 'desporto', 'topico', 0, 0, 429),
('sporting', 'sporting', 'desporto', 'topico', 0, 1, 430);

-- --------------------------------------------------------

--
-- Table structure for table `local`
--

CREATE TABLE IF NOT EXISTS `local` (
  `idlocal` int(11) NOT NULL AUTO_INCREMENT,
  `nome_local` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `coordenadas` varchar(45) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`idlocal`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=338 ;

--
-- Dumping data for table `local`
--

INSERT INTO `local` (`idlocal`, `nome_local`, `coordenadas`) VALUES
(1, 'Ilha Terceira', '38.7238;-27.2112'),
(2, 'Ilha da Graciosa', '39.0522;-28.0102'),
(3, 'Ilha da Madeira', '32.7327;-16.9857'),
(4, 'Ilha das Flores', '39.4428;-31.2031'),
(5, 'Ilha de Porto Santo', '33.0666;-16.3438'),
(6, 'Ilha de Santa Maria', '36.9723;-25.0994'),
(7, 'Ilha de SÃ£o Jorge', '38.6371;-28.0281'),
(8, 'Ilha de SÃ£o Miguel', '37.7963;-25.4815'),
(9, 'Ilha do Corvo', '39.6999;-31.1059'),
(10, 'Ilha do Faial', '38.5781;-28.7002'),
(11, 'Ilha do Pico', '38.4694;-28.3325'),
(12, 'Abrantes', '39.4263;-8.1578'),
(13, 'Aguiar da Beira', '40.7812;-7.5284'),
(14, 'Alandroal', '38.6158;-7.3829'),
(15, 'Albergaria-a-Velha', '40.7001;-8.4955'),
(16, 'Albufeira', '37.1338;-8.2326'),
(17, 'Alcanena', '39.4724;-8.689299999999999'),
(18, 'AlcobaÃ§a', '39.5524;-8.990399999999999'),
(19, 'Alcochete', '38.7356;-8.915900000000001'),
(20, 'Alcoutim', '37.4198;-7.652'),
(21, 'AlcÃ¡cer do Sal', '38.3676;-8.474600000000001'),
(22, 'Alenquer', '39.0982;-9.039099999999999'),
(23, 'AlfÃ¢ndega da FÃ©', '41.3498;-6.9511'),
(24, 'AlijÃ³', '41.3038;-7.486'),
(25, 'Aljezur', '37.2972;-8.800800000000001'),
(26, 'Aljustrel', '37.8879;-8.1881'),
(27, 'Almada', '38.6356;-9.193'),
(28, 'Almeida', '40.623;-6.914'),
(29, 'Almeirim', '39.1589;-8.58'),
(30, 'AlmodÃ´var', '37.475;-8.0845'),
(31, 'AlpiarÃ§a', '39.2411;-8.570600000000001'),
(32, 'Alter do ChÃ£o', '39.213;-7.7249'),
(33, 'AlvaiÃ¡zere', '39.8192;-8.3954'),
(34, 'Alvito', '38.2441;-8.041499999999999'),
(35, 'Amadora', '38.7598;-9.2295'),
(36, 'Amarante', '41.2725;-8.0421'),
(37, 'Amares', '41.6517;-8.3453'),
(38, 'Anadia', '40.4526;-8.4428'),
(39, 'Angra do HeroÃ­smo', '38.7082;-27.2489'),
(40, 'AnsiÃ£o', '39.9342;-8.438700000000001'),
(41, 'Arcos de Valdevez', '41.9029;-8.3645'),
(42, 'Arganil', '40.229;-7.9855'),
(43, 'Armamar', '41.0949;-7.6776'),
(44, 'Arouca', '40.9288;-8.2517'),
(45, 'Arraiolos', '38.7868;-7.9164'),
(46, 'Arronches', '39.1168;-7.2433'),
(47, 'Arruda dos Vinhos', '38.9747;-9.094200000000001'),
(48, 'Aveiro', '40.6422;-8.6282'),
(49, 'Avis', '39.0697;-7.9128'),
(50, 'Azambuja', '39.1337;-8.8969'),
(51, 'BaiÃ£o', '41.1576;-7.9893'),
(52, 'Barcelos', '41.5367;-8.623699999999999'),
(53, 'Barrancos', '38.1482;-7.0522'),
(54, 'Barreiro', '38.6284;-9.045'),
(55, 'Batalha', '39.6371;-8.765499999999999'),
(56, 'Beja', '37.9625;-7.8559'),
(57, 'Belmonte', '40.3308;-7.3297'),
(58, 'Benavente', '38.8678;-8.8111'),
(59, 'Bombarral', '39.2841;-9.1579'),
(60, 'Borba', '38.8165;-7.4693'),
(61, 'Boticas', '41.6759;-7.734'),
(62, 'Braga', '41.5445;-8.4209'),
(63, 'BraganÃ§a', '41.7709;-6.7353'),
(64, 'Cabeceiras de Basto', '41.5402;-7.9539'),
(65, 'Cadaval', '39.2349;-9.067500000000001'),
(66, 'Caldas da Rainha', '39.4076;-9.088200000000001'),
(67, 'Calheta', '38.5942;-27.9142'),
(68, 'Calheta', '32.7703;-17.1823'),
(69, 'Caminha', '41.8476;-8.790800000000001'),
(70, 'Campo Maior', '39.0262;-7.0505'),
(71, 'Cantanhede', '40.355;-8.6373'),
(72, 'Carrazeda de AnsiÃ£es', '41.228;-7.308'),
(73, 'Carregal do Sal', '40.4498;-7.988'),
(74, 'Cartaxo', '39.1458;-8.7896'),
(75, 'Cascais', '38.725;-9.401'),
(76, 'Castanheira de PÃªra', '40.0199;-8.1958'),
(77, 'Castelo Branco', '39.8548;-7.5017'),
(78, 'Castelo de Paiva', '41.0182;-8.303000000000001'),
(79, 'Castelo de Vide', '39.4646;-7.4933'),
(80, 'Castro Daire', '40.9129;-7.9329'),
(81, 'Castro Marim', '37.2926;-7.5169'),
(82, 'Castro Verde', '37.7047;-8.0283'),
(83, 'Celorico da Beira', '40.6223;-7.3849'),
(84, 'Celorico de Basto', '41.4013;-8.0396'),
(85, 'Chamusca', '39.2716;-8.3804'),
(86, 'Chaves', '41.7502;-7.4371'),
(87, 'CinfÃ£es', '41.0352;-8.102600000000001'),
(88, 'Coimbra', '40.2162;-8.446199999999999'),
(89, 'Condeixa-a-Nova', '40.0987;-8.499599999999999'),
(90, 'ConstÃ¢ncia', '39.4257;-8.291499999999999'),
(91, 'Coruche', '38.9402;-8.4475'),
(92, 'Corvo', '39.6999;-31.1059'),
(93, 'CovilhÃ£', '40.2567;-7.5626'),
(94, 'Crato', '39.3133;-7.645'),
(95, 'Cuba', '38.1928;-7.9135'),
(96, 'CÃ¢mara de Lobos', '32.7023;-16.9767'),
(97, 'Elvas', '38.9105;-7.2289'),
(98, 'Entroncamento', '39.4644;-8.4787'),
(99, 'Espinho', '40.9948;-8.6258'),
(100, 'Esposende', '41.5469;-8.757999999999999'),
(101, 'Estarreja', '40.7616;-8.575799999999999'),
(102, 'Estremoz', '38.8455;-7.6137'),
(103, 'Fafe', '41.4773;-8.148300000000001'),
(104, 'Faro', '37.0552;-7.9184'),
(105, 'Felgueiras', '41.3506;-8.201599999999999'),
(106, 'Ferreira do Alentejo', '38.0882;-8.1889'),
(107, 'Ferreira do ZÃªzere', '39.7214;-8.3169'),
(108, 'Figueira da Foz', '40.1689;-8.8088'),
(109, 'Figueira de Castelo Rodrigo', '40.8845;-6.9594'),
(110, 'FigueirÃ³ dos Vinhos', '39.9252;-8.2821'),
(111, 'Fornos de Algodres', '40.651;-7.5001'),
(112, 'Freixo de Espada Ã  Cinta', '41.1135;-6.8327'),
(113, 'Fronteira', '39.076;-7.6267'),
(114, 'Funchal', '32.5873;-16.8826'),
(115, 'FundÃ£o', '40.1214;-7.4825'),
(116, 'GaviÃ£o', '39.4388;-7.895'),
(117, 'GolegÃ£', '39.3868;-8.505599999999999'),
(118, 'Gondomar', '41.1096;-8.483000000000001'),
(119, 'Gouveia', '40.5014;-7.5803'),
(120, 'GrÃ¢ndola', '38.179;-8.575100000000001'),
(121, 'Guarda', '40.5195;-7.2451'),
(122, 'GuimarÃ£es', '41.4609;-8.3156'),
(123, 'GÃ³is', '40.1025;-8.089399999999999'),
(124, 'Horta', '38.5781;-28.7002'),
(125, 'Idanha-a-Nova', '39.9003;-7.113'),
(126, 'Lagoa', '37.7459;-25.5358'),
(127, 'Lagoa', '37.1257;-8.4533'),
(128, 'Lagos', '37.1519;-8.7281'),
(129, 'Lajes das Flores', '39.4137;-31.2142'),
(130, 'Lajes do Pico', '38.43;-28.2239'),
(131, 'Lamego', '41.0807;-7.8225'),
(132, 'Leiria', '39.7895;-8.802300000000001'),
(133, 'Lisboa', '38.7416;-9.1577'),
(134, 'LoulÃ©', '37.2252;-8.0467'),
(135, 'Loures', '38.8605;-9.1511'),
(136, 'LourinhÃ£', '39.2465;-9.2692'),
(137, 'Lousada', '41.2855;-8.2752'),
(138, 'LousÃ£', '40.1318;-8.228400000000001'),
(139, 'Macedo de Cavaleiros', '41.5434;-6.9063'),
(140, 'Machico', '32.7408;-16.8023'),
(141, 'Madalena', '38.4858;-28.4626'),
(142, 'Mafra', '38.9611;-9.3089'),
(143, 'Maia', '41.245;-8.6012'),
(144, 'Mangualde', '40.5949;-7.7201'),
(145, 'Manteigas', '40.3911;-7.5201'),
(146, 'Marco de Canaveses', '41.1556;-8.158300000000001'),
(147, 'Marinha Grande', '39.7853;-8.9526'),
(148, 'MarvÃ£o', '39.4053;-7.3628'),
(149, 'Matosinhos', '41.2131;-8.6713'),
(150, 'MaÃ§Ã£o', '39.6052;-7.9749'),
(151, 'Mealhada', '40.3538;-8.441000000000001'),
(152, 'Meda', '40.9366;-7.2528'),
(153, 'MelgaÃ§o', '42.0496;-8.2133'),
(154, 'MesÃ£o Frio', '41.1639;-7.871'),
(155, 'Mira', '40.4331;-8.7547'),
(156, 'Miranda do Corvo', '40.1049;-8.327400000000001'),
(157, 'Miranda do Douro', '41.5106;-6.3585'),
(158, 'Mirandela', '41.5085;-7.1877'),
(159, 'Mogadouro', '41.3334;-6.67'),
(160, 'Moimenta da Beira', '40.9643;-7.6386'),
(161, 'Moita', '38.6535;-9.0014'),
(162, 'Monchique', '37.3162;-8.591699999999999'),
(163, 'Mondim de Basto', '41.3887;-7.8951'),
(164, 'Monforte', '39.0479;-7.4354'),
(165, 'Montalegre', '41.7756;-7.8514'),
(166, 'Montemor-o-Novo', '38.6486;-8.296099999999999'),
(167, 'Montemor-o-Velho', '40.2147;-8.6585'),
(168, 'Montijo', '38.7299;-8.6936'),
(169, 'MonÃ§Ã£o', '42.0272;-8.426399999999999'),
(170, 'Mora', '38.9189;-8.088800000000001'),
(171, 'MortÃ¡gua', '40.4195;-8.2532'),
(172, 'Moura', '38.1334;-7.2874'),
(173, 'MourÃ£o', '38.3182;-7.2749'),
(174, 'Murtosa', '40.7577;-8.673400000000001'),
(175, 'MurÃ§a', '41.4224;-7.4407'),
(176, 'MÃ©rtola', '37.6468;-7.7066'),
(177, 'NazarÃ©', '39.5946;-9.045'),
(178, 'Nelas', '40.5269;-7.8652'),
(179, 'Nisa', '39.5229;-7.6676'),
(180, 'Nordeste', '37.8235;-25.2169'),
(181, 'Odemira', '37.6073;-8.5768'),
(182, 'Odivelas', '38.7978;-9.199299999999999'),
(183, 'Oeiras', '38.7171;-9.276300000000001'),
(184, 'Oleiros', '39.9446;-7.8711'),
(185, 'OlhÃ£o', '37.062;-7.8105'),
(186, 'Oliveira de AzemÃ©is', '40.8422;-8.468400000000001'),
(187, 'Oliveira de Frades', '40.7037;-8.2384'),
(188, 'Oliveira do Bairro', '40.5159;-8.551500000000001'),
(189, 'Oliveira do Hospital', '40.3685;-7.8637'),
(190, 'Ourique', '37.6399;-8.2911'),
(191, 'OurÃ©m', '39.6923;-8.574199999999999'),
(192, 'Ovar', '40.8762;-8.6198'),
(193, 'Palmela', '38.6183;-8.806900000000001'),
(194, 'Pampilhosa da Serra', '40.0843;-7.9164'),
(195, 'Paredes', '41.1815;-8.396100000000001'),
(196, 'Paredes de Coura', '41.9102;-8.572100000000001'),
(197, 'PaÃ§os de Ferreira', '41.2885;-8.380000000000001'),
(198, 'PedrÃ³gÃ£o Grande', '39.9349;-8.182600000000001'),
(199, 'Penacova', '40.2976;-8.2676'),
(200, 'Penafiel', '41.1506;-8.293799999999999'),
(201, 'Penalva do Castelo', '40.6713;-7.6559'),
(202, 'Penamacor', '40.1765;-7.1368'),
(203, 'Penedono', '40.9912;-7.3951'),
(204, 'Penela', '40.0101;-8.3698'),
(205, 'Peniche', '39.3387;-9.3194'),
(206, 'Peso da RÃ©gua', '41.1833;-7.7687'),
(207, 'Pinhel', '40.742;-7.1101'),
(208, 'Pombal', '39.9266;-8.6777'),
(209, 'Ponta Delgada', '37.8194;-25.7287'),
(210, 'Ponta do Sol', '32.7228;-17.0939'),
(211, 'Ponte da Barca', '41.8067;-8.309799999999999'),
(212, 'Ponte de Lima', '41.7574;-8.5875'),
(213, 'Ponte de SÃ´r', '39.1879;-8.0824'),
(214, 'Portalegre', '39.2693;-7.3996'),
(215, 'Portel', '38.3018;-7.6966'),
(216, 'PortimÃ£o', '37.1916;-8.5831'),
(217, 'Porto', '41.1618;-8.620799999999999'),
(218, 'Porto Moniz', '32.817;-17.1467'),
(219, 'Porto Santo', '33.0666;-16.3438'),
(220, 'Porto de MÃ³s', '39.5579;-8.817'),
(221, 'PovoaÃ§Ã£o', '37.766;-25.2602'),
(222, 'ProenÃ§a-a-Nova', '39.7383;-7.8558'),
(223, 'PÃ³voa de Lanhoso', '41.5881;-8.2536'),
(224, 'PÃ³voa de Varzim', '41.4192;-8.7178'),
(225, 'Redondo', '38.6256;-7.5988'),
(226, 'Reguengos de Monsaraz', '38.3962;-7.4774'),
(227, 'Resende', '41.0762;-7.9398'),
(228, 'Ribeira Brava', '32.709;-17.0325'),
(229, 'Ribeira Grande', '37.8043;-25.455'),
(230, 'Ribeira de Pena', '41.5089;-7.797'),
(231, 'Rio Maior', '39.3289;-8.901400000000001'),
(232, 'Sabrosa', '41.2524;-7.5986'),
(233, 'Sabugal', '40.3733;-7.0325'),
(234, 'Salvaterra de Magos', '39.0467;-8.687799999999999'),
(235, 'Santa Comba DÃ£o', '40.4006;-8.115600000000001'),
(236, 'Santa Cruz', '32.6587;-16.7795'),
(237, 'Santa Cruz da Graciosa', '39.0522;-28.0102'),
(238, 'Santa Cruz das Flores', '39.4715;-31.1922'),
(239, 'Santa Maria da Feira', '40.967;-8.5105'),
(240, 'Santa Marta de PenaguiÃ£o', '41.2281;-7.8023'),
(241, 'Santana', '32.7813;-16.9052'),
(242, 'SantarÃ©m', '39.337;-8.726900000000001'),
(243, 'Santiago do CacÃ©m', '37.9531;-8.568099999999999'),
(244, 'Santo Tirso', '41.3209;-8.444000000000001'),
(245, 'Sardoal', '39.563;-8.138500000000001'),
(246, 'Seia', '40.3778;-7.7192'),
(247, 'Seixal', '38.6045;-9.108599999999999'),
(248, 'Sernancelhe', '40.91;-7.5071'),
(249, 'Serpa', '37.9329;-7.4896'),
(250, 'SertÃ£', '39.8244;-8.0992'),
(251, 'Sesimbra', '38.4949;-9.120200000000001'),
(252, 'SetÃºbal', '38.5225;-8.9156'),
(253, 'Sever do Vouga', '40.7244;-8.351800000000001'),
(254, 'Silves', '37.2703;-8.345800000000001'),
(255, 'Sines', '37.9248;-8.7775'),
(256, 'Sintra', '38.823;-9.357699999999999'),
(257, 'Sobral de Monte AgraÃ§o', '38.9951;-9.1607'),
(258, 'Soure', '40.0668;-8.6196'),
(259, 'Sousel', '38.9615;-7.7394'),
(260, 'SÃ¡tÃ£o', '40.7703;-7.674'),
(261, 'SÃ£o BrÃ¡s de Alportel', '37.1957;-7.8786'),
(262, 'SÃ£o JoÃ£o da Madeira', '40.8956;-8.490399999999999'),
(263, 'SÃ£o JoÃ£o da Pesqueira', '41.1185;-7.438'),
(264, 'SÃ£o Pedro do Sul', '40.8164;-8.0946'),
(265, 'SÃ£o Roque do Pico', '38.4954;-28.3163'),
(266, 'SÃ£o Vicente', '32.7871;-17.011'),
(267, 'TabuaÃ§o', '41.0943;-7.5656'),
(268, 'Tarouca', '41.0139;-7.7621'),
(269, 'Tavira', '37.2252;-7.7323'),
(270, 'Terras de Bouro', '41.7391;-8.1912'),
(271, 'Tomar', '39.6029;-8.386799999999999'),
(272, 'Tondela', '40.5434;-8.1227'),
(273, 'Torre de Moncorvo', '41.1726;-7.0168'),
(274, 'Torres Novas', '39.5056;-8.550800000000001'),
(275, 'Torres Vedras', '39.1049;-9.260400000000001'),
(276, 'Trancoso', '40.7915;-7.3347'),
(277, 'Trofa', '41.3114;-8.567299999999999'),
(278, 'TÃ¡bua', '40.3342;-8.0152'),
(279, 'Vagos', '40.5155;-8.6896'),
(280, 'Vale de Cambra', '40.8336;-8.336399999999999'),
(281, 'ValenÃ§a', '41.9983;-8.606400000000001'),
(282, 'Valongo', '41.2067;-8.494199999999999'),
(283, 'ValpaÃ§os', '41.6118;-7.3413'),
(284, 'Velas', '38.6832;-28.1505'),
(285, 'Vendas Novas', '38.655;-8.514799999999999'),
(286, 'Viana do Alentejo', '38.3846;-8.122400000000001'),
(287, 'Viana do Castelo', '41.7171;-8.7593'),
(288, 'Vidigueira', '38.1689;-7.7169'),
(289, 'Vieira do Minho', '41.6312;-8.104699999999999'),
(290, 'Vila Flor', '41.3217;-7.1595'),
(291, 'Vila Franca de Xira', '38.9223;-8.984400000000001'),
(292, 'Vila Franca do Campo', '37.7445;-25.4178'),
(293, 'Vila Nova da Barquinha', '39.4817;-8.400399999999999'),
(294, 'Vila Nova de Cerveira', '41.9173;-8.7066'),
(295, 'Vila Nova de FamalicÃ£o', '41.4086;-8.503399999999999'),
(296, 'Vila Nova de Foz CÃ´a', '41.0526;-7.1699'),
(297, 'Vila Nova de Gaia', '41.0744;-8.580500000000001'),
(298, 'Vila Nova de Paiva', '40.8723;-7.7634'),
(299, 'Vila Nova de Poiares', '40.2169;-8.250400000000001'),
(300, 'Vila Pouca de Aguiar', '41.511;-7.6233'),
(301, 'Vila Real', '41.3117;-7.7386'),
(302, 'Vila Real de Santo AntÃ³nio', '37.1943;-7.5193'),
(303, 'Vila Velha de RÃ³dÃ£o', '39.6809;-7.6638'),
(304, 'Vila Verde', '41.6808;-8.4435'),
(305, 'Vila ViÃ§osa', '38.7689;-7.3532'),
(306, 'Vila da Praia da VitÃ³ria', '38.7469;-27.1553'),
(307, 'Vila de Rei', '39.6831;-8.144299999999999'),
(308, 'Vila do Bispo', '37.0863;-8.8834'),
(309, 'Vila do Conde', '41.338;-8.6828'),
(310, 'Vila do Porto', '36.9723;-25.0994'),
(311, 'Vimioso', '41.5707;-6.5308'),
(312, 'Vinhais', '41.8325;-7.0487'),
(313, 'Viseu', '40.688;-7.9056'),
(314, 'Vizela', '41.3733;-8.2956'),
(315, 'Vouzela', '40.675;-8.139200000000001'),
(316, 'Ãgueda', '40.586;-8.3956'),
(317, 'Ã‰vora', '38.5331;-7.8702'),
(318, 'Ãlhavo', '40.6062;-8.6999'),
(319, 'Ã“bidos', '39.3633;-9.189299999999999'),
(320, 'Aveiro', '40.7237;-8.468400000000001'),
(321, 'Beja', '37.8297;-7.9439'),
(322, 'Braga', '41.553;-8.309799999999999'),
(323, 'BraganÃ§a', '41.5094;-6.8593'),
(324, 'Castelo Branco', '39.9465;-7.5016'),
(325, 'Coimbra', '40.2044;-8.335900000000001'),
(326, 'Faro', '37.2437;-8.1317'),
(327, 'Guarda', '40.6413;-7.2296'),
(328, 'Leiria', '39.7173;-8.7752'),
(329, 'Lisboa', '38.9982;-9.163500000000001'),
(330, 'Portalegre', '39.1901;-7.6204'),
(331, 'Porto', '41.2248;-8.352600000000001'),
(332, 'SantarÃ©m', '39.2935;-8.477600000000001'),
(333, 'SetÃºbal', '38.3149;-8.649699999999999'),
(334, 'Viana do Castelo', '41.8779;-8.507'),
(335, 'Vila Real', '41.555;-7.6317'),
(336, 'Viseu', '40.7989;-7.8709'),
(337, 'Ã‰vora', '38.6039;-7.8418');

-- --------------------------------------------------------

--
-- Table structure for table `noticia`
--

CREATE TABLE IF NOT EXISTS `noticia` (
  `idnoticia` int(11) NOT NULL AUTO_INCREMENT,
  `idfonte` int(11) NOT NULL,
  `data_pub` datetime DEFAULT NULL,
  `data_noticia` datetime DEFAULT NULL,
  `assunto` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `descricao` varchar(250) CHARACTER SET latin1 DEFAULT NULL,
  `texto` longtext CHARACTER SET latin1,
  `url` text CHARACTER SET latin1,
  `visivel` tinyint(1) NOT NULL,
  PRIMARY KEY (`idnoticia`,`idfonte`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=62 ;

--
-- Dumping data for table `noticia`
--

INSERT INTO `noticia` (`idnoticia`, `idfonte`, `data_pub`, `data_noticia`, `assunto`, `descricao`, `texto`, `url`, `visivel`) VALUES
(32, 8, '2012-03-09 16:03:39', NULL, 'â€œ@daaniloluiz: Porto 25 graus! Ta ruim? Rsrsâ€ santos 30, ta ruim ?', 'â€œ@<a class=\\" \\" href=\\"http://twitter.com/daaniloluiz\\">daaniloluiz</a>: <em>Porto</em> 25 graus! Ta ruim? Rsrsâ€ santos 30, ta ruim ?', NULL, 'http://twitter.com/NeyJunior_92/statuses/178149055006908418', 1),
(33, 8, '2012-03-09 15:53:25', NULL, 'Estamos construindo o maior e mais eficiente complexo porto indÃºstria da AmÃ©rica Latina e o maior ', 'Estamos construindo o maior e mais eficiente complexo <em>porto</em> indÃºstria da AmÃ©rica Latina e o maior estaleiro das AmÃ©ricas <a href=\\"http://search.twitter.com/search?q=%23EquipedoEike\\" title=\\"#EquipedoEike\\" class=\\" \\">#EquipedoEike</a>', NULL, 'http://twitter.com/eikebatista/statuses/178146481990144001', 1),
(34, 8, '2012-03-09 17:12:07', NULL, 'Porto Alegre dia 22 de abril! Vamo aeee!?!?!?!', '<em>Porto</em> Alegre dia 22 de abril! Vamo aeee!?!?!?!', NULL, 'http://twitter.com/abrilrock/statuses/178166288357666817', 1),
(35, 8, '2012-03-09 22:00:02', NULL, 'SimpÃ³sio de AtualizaÃ§Ã£o da SBD 2012 - Diabetes na GestaÃ§Ã£o (Porto Alegre/RS)\nhttp://t.co/5z1G0i', 'SimpÃ³sio de AtualizaÃ§Ã£o da SBD 2012 - Diabetes na GestaÃ§Ã£o (<em>Porto</em> Alegre/RS)\n<a href=\\"http://t.co/5z1G0i9x\\">http://t.co/5z1G0i9x</a> <a href=\\"http://search.twitter.com/search?q=%23nutricao\\" title=\\"#nutricao\\" class=\\" \\">#nutricao<', NULL, 'http://twitter.com/nutricaoemfoco/statuses/178238744372068353', 1),
(36, 8, '2012-03-09 21:59:57', NULL, '@LeeMattosOFC man eu nem sei se vou amanha pro porto, sla  provavelmente qe nao  !', '@<a class=\\" \\" href=\\"http://twitter.com/LeeMattosOFC\\">LeeMattosOFC</a> man eu nem sei se vou amanha pro <em>porto</em>, sla  provavelmente qe nao  !', NULL, 'http://twitter.com/Corturatto/statuses/178238720598753280', 1),
(37, 8, '2012-03-09 21:59:55', NULL, 'Quaresmanin futboluna Porto\\''daki yillarindan beri hayranim ama maales Porto disinda hicbiryerde bas', 'Quaresmanin futboluna <em>Porto</em>\\''daki yillarindan beri hayranim ama maales <em>Porto</em> disinda hicbiryerde basarili olamadi,hepde ayni nedenlerden', NULL, 'http://twitter.com/el_brus/statuses/178238714940620800', 1),
(38, 8, '2012-03-09 21:59:55', NULL, '@chaymiaire Eu sou de Porto Alegre :S', '@<a class=\\" \\" href=\\"http://twitter.com/chaymiaire\\">chaymiaire</a> Eu sou de <em>Porto</em> Alegre :S', NULL, 'http://twitter.com/MeninaaRebeldee/statuses/178238712583421952', 1),
(39, 8, '2012-03-09 21:59:54', NULL, '34.E justin? ora vado da lui e lo porto qui in italia a calci in culo. HAHAHHA', '34.E justin? ora vado da lui e lo <em>porto</em> qui in italia a calci in culo. HAHAHHA', NULL, 'http://twitter.com/ximharryswife/statuses/178238708791779329', 1),
(40, 8, '2012-03-09 21:59:53', NULL, '@Vmoora jajajajajajajajajajajajajajajajjajajajajaajaja dele yo aquÃ­ me portÃ³ mal jiji.<<JAJAJA DEL', '@<a class=\\" \\" href=\\"http://twitter.com/Vmoora\\">Vmoora</a> jajajajajajajajajajajajajajajajjajajajajaajaja dele yo aquÃ­ me <em>portÃ³</em> mal jiji.<<JAJAJA DELE JAJAJAJA :*', NULL, 'http://twitter.com/09Franciscoo/statuses/178238705583144960', 1),
(41, 8, '2012-03-09 21:59:49', NULL, 'O sorriso mais lindo, o olhar mais sincero, o meu porto seguro a pessoa mais linda do mundo', 'O sorriso mais lindo, o olhar mais sincero, o meu <em>porto</em> seguro a pessoa mais linda do mundo', NULL, 'http://twitter.com/_CaarolBr/statuses/178238688310984704', 1),
(42, 8, '2012-03-09 21:59:44', NULL, 'I\\''m at Onibus Guaiba Executivo (Porto Alegre, RS) http://t.co/vNRAN8VS', 'I\\''m at Onibus Guaiba Executivo (<em>Porto</em> Alegre, RS) <a href=\\"http://t.co/vNRAN8VS\\">http://t.co/vNRAN8VS</a>', NULL, 'http://twitter.com/alexbittencurt/statuses/178238667880534016', 1),
(43, 8, '2012-03-09 21:59:43', NULL, 'EU TÃ” VENDO UMA POSSIBILIDADE DA GNT IR PRA PORTO SEGURO OU SALVADOOR ;P;P', 'EU TÃ” VENDO UMA POSSIBILIDADE DA GNT IR PRA <em>PORTO</em> SEGURO OU SALVADOOR ;P;P', NULL, 'http://twitter.com/sabrinamv_03/statuses/178238664105672704', 1),
(44, 8, '2012-03-09 21:59:40', NULL, 'E minha mae nem pra passa na academia, projeto porto!', 'E minha mae nem pra passa na academia, projeto <em>porto</em>!', NULL, 'http://twitter.com/LucassVolpato/statuses/178238651459846144', 1),
(45, 8, '2012-03-09 21:59:36', NULL, 'que calooooooooooor Ã© esse aqui em porto alegre ? nossa tchÃª', 'que calooooooooooor Ã© esse aqui em <em>porto</em> alegre ? nossa tchÃª', NULL, 'http://twitter.com/Luuan_foreveer/statuses/178238634888151040', 1),
(46, 8, '2012-03-09 21:59:35', NULL, '@vinniciusss @thiagomunhoz_1 eu vo colar la depois tambem, fala com o rafa porto e dps vo pro r1', '@<a class=\\" \\" href=\\"http://twitter.com/vinniciusss\\">vinniciusss</a> @<a class=\\" \\" href=\\"http://twitter.com/thiagomunhoz_1\\">thiagomunhoz_1</a> eu vo colar la depois tambem, fala com o rafa <em>porto</em> e dps vo pro r1', NULL, 'http://twitter.com/lucascostii/statuses/178238631469776896', 1),
(47, 8, '2012-03-08 18:23:41', NULL, '#SCP 0-0 #MCFC: 21.Sporting break away and it\\''s 4 on 3. @MCFC temporarily escape punishment and sho', '<a href=\\"http://search.twitter.com/search?q=%23SCP\\" title=\\"#SCP\\" class=\\" \\">#SCP</a> 0-0 <a href=\\"http://search.twitter.com/search?q=%23MCFC\\" title=\\"#MCFC\\" class=\\" \\">#MCFC</a>: 21.<em>Sporting</em> break away and it\\''s 4 on 3. @<a class=\\"', NULL, 'http://twitter.com/MCFC/statuses/177821910229454849', 1),
(48, 8, '2012-03-09 10:22:56', NULL, 'Manolo Preciado demanda al Sporting y reclama mÃ¡s de 1\\''3 millones: http://t.co/aivhywY9', 'Manolo Preciado demanda al <em>Sporting</em> y reclama mÃ¡s de 1\\''3 millones: <a href=\\"http://t.co/aivhywY9\\">http://t.co/aivhywY9</a>', NULL, 'http://twitter.com/sportyou/statuses/178063310720204800', 1),
(49, 8, '2012-03-08 19:53:14', NULL, 'FINAL DO JOGO - 1/8 Final (1Âª mÃ£o) Liga Europa\n\nSporting Clube de Portugal 1-0 Man. City\n\nPartilha', 'FINAL DO JOGO - 1/8 Final (1Âª mÃ£o) Liga Europa\n\n<em>Sporting</em> Clube de Portugal 1-0 Man. City\n\nPartilha o teu orgulho! SPOOOOORTING!!', NULL, 'http://twitter.com/Sporting_CP/statuses/177844445478268928', 1),
(50, 8, '2012-03-09 21:59:58', NULL, 'I\\''m at Dick\\''s Sporting Goods (Manhattan, Kansas) http://t.co/X8O5Q1e6', 'I\\''m at Dick\\''s <em>Sporting</em> Goods (Manhattan, Kansas) <a href=\\"http://t.co/X8O5Q1e6\\">http://t.co/X8O5Q1e6</a>', NULL, 'http://twitter.com/berickson45/statuses/178238727099916288', 1),
(51, 8, '2012-03-09 21:59:31', NULL, '@BigMikeWill17 Go to a concert or sporting event', '@<a class=\\" \\" href=\\"http://twitter.com/BigMikeWill17\\">BigMikeWill17</a> Go to a concert or <em>sporting</em> event', NULL, 'http://twitter.com/thetimkelly/statuses/178238614868733952', 1),
(52, 8, '2012-03-09 21:59:29', NULL, '@28CGiroux in about a week, I will be sporting your winter classic jersey/sweater, my first NHL jers', '@<a class=\\" \\" href=\\"http://twitter.com/28CGiroux\\">28CGiroux</a> in about a week, I will be <em>sporting</em> your winter classic jersey/sweater, my first NHL jersey! <a href=\\"http://search.twitter.com/search?q=%23flyers\\" title=\\"#flyers\\" class', NULL, 'http://twitter.com/NancyPants28/statuses/178238605095993346', 1),
(53, 8, '2012-03-09 21:59:23', NULL, 'Can\\''t wait!!! RT @QuicksBarBQ: Be one of the first 25 people to buy a $2 beer tomorrow night and yo', 'Can\\''t wait!!! RT @<a class=\\" \\" href=\\"http://twitter.com/QuicksBarBQ\\">QuicksBarBQ</a>: Be one of the first 25 people to buy a $2 beer tomorrow night and you can keep the <em>Sporting</em> glass!', NULL, 'http://twitter.com/treyrey86/statuses/178238577325510656', 1),
(54, 8, '2012-03-09 21:59:10', NULL, 'Does Reese Witherspoon look pregnant to you or is she just sporting \\"poofy\\" clothing for style? Th', 'Does Reese Witherspoon look pregnant to you or is she just <em>sporting</em> \\"poofy\\" clothing for style? The rumors are swirling!...', NULL, 'http://twitter.com/997now/statuses/178238523307081729', 1),
(55, 8, '2012-03-09 21:59:08', NULL, 'I\\''m at Modell\\''s Sporting Goods (Willow Grove, PA) http://t.co/HeBtGZeS', 'I\\''m at Modell\\''s <em>Sporting</em> Goods (Willow Grove, PA) <a href=\\"http://t.co/HeBtGZeS\\">http://t.co/HeBtGZeS</a>', NULL, 'http://twitter.com/oh_kaykaykayy/statuses/178238516092870656', 1),
(56, 8, '2012-03-09 21:58:48', NULL, 'ROBERTO MOSQUERA NUEVO DT DE SPORTING CRISTAL 2012 http://t.co/hxEIVTlQ', 'ROBERTO MOSQUERA NUEVO DT DE <em>SPORTING</em> CRISTAL 2012 <a href=\\"http://t.co/hxEIVTlQ\\">http://t.co/hxEIVTlQ</a>', NULL, 'http://twitter.com/juancprado/statuses/178238433024688129', 1),
(57, 8, '2012-03-09 21:58:43', NULL, '@Wonderbread77 - 25 = times you combed your hair today.  8 = number of times you\\''ve adjussted the s', '@<a class=\\" \\" href=\\"http://twitter.com/Wonderbread77\\">Wonderbread77</a> - 25 = times you combed your hair today.  8 = number of times you\\''ve adjussted the shawl youre certainly <em>sporting</em>!!', NULL, 'http://twitter.com/RustyGundrum/statuses/178238412946546688', 1),
(58, 8, '2012-03-09 21:58:41', NULL, '*runs to nearest sporting goods store* RT @MarauderJames: http://t.co/ed1u7pqu this video inspired m', '*runs to nearest <em>sporting</em> goods store* RT @<a class=\\" \\" href=\\"http://twitter.com/MarauderJames\\">MarauderJames</a>: <a href=\\"http://t.co/ed1u7pqu\\">http://t.co/ed1u7pqu</a> this video inspired me to go get a fitness ball <a href=\\"http:/', NULL, 'http://twitter.com/BrianTooFlyy/statuses/178238404700540930', 1),
(59, 8, '2012-03-09 21:58:40', NULL, 'Sporting de volta aos treinos http://t.co/sBR6C0SV', '<em>Sporting</em> de volta aos treinos <a href=\\"http://t.co/sBR6C0SV\\">http://t.co/sBR6C0SV</a>', NULL, 'http://twitter.com/EspiritoLeonino/statuses/178238400032280577', 1),
(60, 8, '2012-03-09 21:58:21', NULL, '@petermayavi why is nameless still sporting du-rags? #smh', '@<a class=\\" \\" href=\\"http://twitter.com/petermayavi\\">petermayavi</a> why is nameless still <em>sporting</em> du-rags? <a href=\\"http://search.twitter.com/search?q=%23smh\\" title=\\"#smh\\" class=\\" \\">#smh</a>', NULL, 'http://twitter.com/comeupshuffle/statuses/178238318872494080', 1),
(61, 8, '2012-03-09 21:58:10', NULL, 'Easton-Bell Sports Scores with Bats in Q4; FY Net Up 23% - Sporting Goods Intelligence (registration', 'Easton-Bell Sports Scores with Bats in Q4; FY Net Up 23% - <em>Sporting</em> Goods Intelligence (registration) <a href=\\"http://t.co/HTlDA5Ln\\">http://t.co/HTlDA5Ln</a>', NULL, 'http://twitter.com/BigAllieGill/statuses/178238274488377344', 1);

-- --------------------------------------------------------

--
-- Table structure for table `noticia_has_clube`
--

CREATE TABLE IF NOT EXISTS `noticia_has_clube` (
  `idnoticia` int(11) NOT NULL,
  `idclube` int(11) NOT NULL,
  `qualificacao` int(1) NOT NULL,
  PRIMARY KEY (`idnoticia`,`idclube`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `noticia_has_clube`
--


-- --------------------------------------------------------

--
-- Table structure for table `noticia_has_integrante`
--

CREATE TABLE IF NOT EXISTS `noticia_has_integrante` (
  `idnoticia` int(11) NOT NULL,
  `idintegrante` int(11) NOT NULL,
  PRIMARY KEY (`idnoticia`,`idintegrante`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `noticia_has_integrante`
--


-- --------------------------------------------------------

--
-- Table structure for table `noticia_locais`
--

CREATE TABLE IF NOT EXISTS `noticia_locais` (
  `idnoticia` int(11) NOT NULL,
  `idlocal` int(11) NOT NULL,
  PRIMARY KEY (`idnoticia`,`idlocal`),
  KEY `idnoticia` (`idnoticia`,`idlocal`),
  KEY `idlocal` (`idlocal`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `noticia_locais`
--

INSERT INTO `noticia_locais` (`idnoticia`, `idlocal`) VALUES
(32, 10),
(32, 133),
(32, 217),
(32, 329),
(32, 331);

-- --------------------------------------------------------

--
-- Table structure for table `parametros`
--

CREATE TABLE IF NOT EXISTS `parametros` (
  `idparametros` int(11) NOT NULL,
  `nome_parametro` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  PRIMARY KEY (`idparametros`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `parametros`
--


--
-- Constraints for dumped tables
--

--
-- Constraints for table `clubes_lexico`
--
ALTER TABLE `clubes_lexico`
  ADD CONSTRAINT `clubes_lexico_ibfk_1` FOREIGN KEY (`idclube`) REFERENCES `clube` (`idclube`) ON DELETE CASCADE,
  ADD CONSTRAINT `clubes_lexico_ibfk_2` FOREIGN KEY (`idlexico`) REFERENCES `lexico` (`idlexico`) ON DELETE CASCADE;

--
-- Constraints for table `integrantes_lexico`
--
ALTER TABLE `integrantes_lexico`
  ADD CONSTRAINT `integrantes_lexico_ibfk_3` FOREIGN KEY (`idintegrante`) REFERENCES `integrante` (`idintegrante`) ON DELETE CASCADE,
  ADD CONSTRAINT `integrantes_lexico_ibfk_4` FOREIGN KEY (`idlexico`) REFERENCES `lexico` (`idlexico`) ON DELETE CASCADE;

--
-- Constraints for table `local`
--
ALTER TABLE `local`
  ADD CONSTRAINT `local_ibfk_1` FOREIGN KEY (`idlocal`) REFERENCES `local` (`idlocal`);
