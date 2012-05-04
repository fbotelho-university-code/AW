-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 01, 2012 at 09:05 PM
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
  `nome_oficial` varchar(100) NOT NULL,
  `resumo` text,
  PRIMARY KEY (`idclube`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Esta tabela representa ....' AUTO_INCREMENT=2 ;

--
-- Dumping data for table `clube`
--

INSERT INTO `clube` (`idclube`, `nome_oficial`, `resumo`) VALUES
(1, 'http://dbpedia.org/resource/Baba_Diawara', 'O Club Sport Marítimo é um clube de futebol da ilha da Madeira, tendo cerca de 24000 sócios inscritos. A sua principal modalidade é o futebol, mas conta ainda com andebol, automobilismo, atletismo, basquetebol, futsal, hóquei em patins, patinagem, karaté, natação, pesca desportiva, tiro e voleibol. O Maior clube da ilha da madeira, fruto de uma maior mobilidade social, tem claramente a maioria da população da sua região como adepta. Um dos clubes mais históricos do campeonato português tem no futebol a sua maior e mais mediática modalidade, estando a sua história indubitavelmente ligada a este desporto.');

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
(1, 4);

-- --------------------------------------------------------

--
-- Table structure for table `clube_imagem`
--

CREATE TABLE IF NOT EXISTS `clube_imagem` (
  `idclube` int(11) NOT NULL,
  `imagem` blob NOT NULL,
  `content_type` varchar(255) NOT NULL,
  PRIMARY KEY (`idclube`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `clube_imagem`
--


-- --------------------------------------------------------

--
-- Table structure for table `comentario`
--

CREATE TABLE IF NOT EXISTS `comentario` (
  `idnoticia` int(11) NOT NULL,
  `idcomentario` int(11) NOT NULL AUTO_INCREMENT,
  `comentario` varchar(4048) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user` varchar(1024) NOT NULL DEFAULT 'anonymous',
  PRIMARY KEY (`idcomentario`),
  KEY `idnoticia` (`idnoticia`),
  KEY `user` (`user`(255))
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `comentario`
--


-- --------------------------------------------------------

--
-- Table structure for table `competicao`
--

CREATE TABLE IF NOT EXISTS `competicao` (
  `idcompeticao` int(11) NOT NULL AUTO_INCREMENT,
  `nome_competicao` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`idcompeticao`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `competicao`
--


-- --------------------------------------------------------

--
-- Table structure for table `fonte`
--

CREATE TABLE IF NOT EXISTS `fonte` (
  `idfonte` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) DEFAULT NULL,
  `main_url` varchar(100) DEFAULT NULL,
  `ligado` tinyint(1) NOT NULL,
  PRIMARY KEY (`idfonte`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `fonte`
--

INSERT INTO `fonte` (`idfonte`, `nome`, `main_url`, `ligado`) VALUES
(1, 'Arquivo da Web Portuguesa', 'http://arquivo.pt/opensearch?query=', 1),
(2, 'RSS Sapo Noticias', 'http://pesquisa.sapo.pt/?barra=noticias&cluster=0&format=rss&location=pt&st=local&limit=10&q=', 1),
(3, 'Geo-Net-PT', 'http://dmir.inesc-id.pt/resolve/geonetpt02/sparql.psp', 1),
(4, 'RSS Google News', 'https://ajax.googleapis.com/ajax/services/search/news?v=1.0&q=', 1),
(5, 'Google Maps', 'http://maps.google.com', 1),
(6, 'WebService', '', 1);

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
-- Table structure for table `integrante`
--

CREATE TABLE IF NOT EXISTS `integrante` (
  `idintegrante` int(11) NOT NULL AUTO_INCREMENT,
  `idclube` int(11) NOT NULL DEFAULT '0',
  `funcao` varchar(255) NOT NULL,
  `nome_integrante` varchar(100) DEFAULT NULL,
  `resumo` text,
  PRIMARY KEY (`idintegrante`,`idclube`,`funcao`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `integrante`
--

INSERT INTO `integrante` (`idintegrante`, `idclube`, `funcao`, `nome_integrante`, `resumo`) VALUES
(1, 1, 'Presidente', 'Pereira, Carlos', 'José Carlos Rodrigues Pereira is the president of Portuguese association football club C.S. Marítimo. A businessman by profession, Pereira took over the reins of C.S. Marítimo on 4 July 1997, when he was elected to replace the previous chairman Rui Fontes.');

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
(1, 5),
(1, 6);

-- --------------------------------------------------------

--
-- Table structure for table `lexico`
--

CREATE TABLE IF NOT EXISTS `lexico` (
  `nucleo` varchar(255) DEFAULT NULL,
  `contexto` varchar(255) NOT NULL,
  `entidade` varchar(255) DEFAULT NULL,
  `tipo` varchar(255) NOT NULL,
  `pol` int(10) NOT NULL,
  `ambiguidade` int(10) NOT NULL,
  `idlexico` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`idlexico`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `lexico`
--

INSERT INTO `lexico` (`nucleo`, `contexto`, `entidade`, `tipo`, `pol`, `ambiguidade`, `idlexico`) VALUES
(NULL, 'Marítimo', NULL, 'dbpedia_name', 0, 0, 1),
(NULL, 'Club Sport Marítimo', NULL, 'dbpedia_name', 0, 0, 2),
(NULL, 'Os Verde-Rubros', NULL, 'dbpedia_name', 0, 0, 3),
(NULL, 'Os Leões', NULL, 'dbpedia_name', 0, 0, 4),
(NULL, 'Pereira', NULL, 'dbpedia_name', 0, 0, 5),
(NULL, 'Carlos', NULL, 'dbpedia_name', 0, 0, 6);

-- --------------------------------------------------------

--
-- Table structure for table `local`
--

CREATE TABLE IF NOT EXISTS `local` (
  `idlocal` int(11) NOT NULL AUTO_INCREMENT,
  `nome_local` varchar(100) DEFAULT NULL,
  `coordenadas` varchar(45) NOT NULL,
  PRIMARY KEY (`idlocal`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `local`
--


-- --------------------------------------------------------

--
-- Table structure for table `noticia`
--

CREATE TABLE IF NOT EXISTS `noticia` (
  `idnoticia` int(11) NOT NULL AUTO_INCREMENT,
  `idfonte` int(11) NOT NULL,
  `data_pub` datetime DEFAULT NULL,
  `assunto` varchar(100) DEFAULT NULL,
  `descricao` varchar(250) DEFAULT NULL,
  `texto` longtext,
  `url` text,
  PRIMARY KEY (`idnoticia`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `noticia`
--


-- --------------------------------------------------------

--
-- Table structure for table `noticia_bin`
--

CREATE TABLE IF NOT EXISTS `noticia_bin` (
  `idnoticia` int(11) NOT NULL,
  `idfonte` int(11) DEFAULT NULL,
  `data_pub` datetime DEFAULT NULL,
  `assunto` varchar(100) DEFAULT NULL,
  `descricao` varchar(250) DEFAULT NULL,
  `texto` longtext,
  `url` text
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Tabela para noticias que removidas';

--
-- Dumping data for table `noticia_bin`
--


-- --------------------------------------------------------

--
-- Table structure for table `noticia_data`
--

CREATE TABLE IF NOT EXISTS `noticia_data` (
  `idnoticia` int(11) NOT NULL,
  `tempo` varchar(100) NOT NULL,
  `data_interpretada` date NOT NULL,
  PRIMARY KEY (`idnoticia`,`tempo`,`data_interpretada`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `noticia_data`
--


-- --------------------------------------------------------

--
-- Table structure for table `noticia_data_clube`
--

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `aw`.`noticia_data_clube` AS select month(`nd`.`data_interpretada`) AS `month( nd.data_interpretada )`,`c`.`nome_oficial` AS `nome_oficial`,count(`n`.`idnoticia`) AS `count( n.idnoticia )` from (((`aw`.`noticia_data` `nd` join `aw`.`clube` `c`) join `aw`.`noticia` `n`) join `aw`.`noticia_has_clube` `nc`) where ((`n`.`idnoticia` = `nd`.`idnoticia`) and (`n`.`idnoticia` = `nc`.`idnoticia`) and (`nc`.`idclube` = `c`.`idclube`) and (`nd`.`idnoticia` = `nc`.`idnoticia`) and (`nd`.`data_interpretada` like '2012-%')) group by month(`nd`.`data_interpretada`),`c`.`idclube`;

--
-- Dumping data for table `noticia_data_clube`
--


-- --------------------------------------------------------

--
-- Table structure for table `noticia_has_clube`
--

CREATE TABLE IF NOT EXISTS `noticia_has_clube` (
  `idnoticia` int(11) NOT NULL,
  `idclube` int(11) NOT NULL,
  `qualificacao` int(1) NOT NULL,
  `idlexico` int(11) NOT NULL,
  PRIMARY KEY (`idnoticia`,`idclube`),
  KEY `idclube` (`idclube`)
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
  `qualificacao` int(11) NOT NULL DEFAULT '0',
  `idlexico` int(11) NOT NULL,
  PRIMARY KEY (`idnoticia`,`idintegrante`),
  KEY `idintegrante` (`idintegrante`)
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


-- --------------------------------------------------------

--
-- Table structure for table `noticia_x_clube`
--

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `aw`.`noticia_x_clube` AS select `c`.`nome_oficial` AS `nome_oficial`,count(0) AS `nr_noticia` from (`aw`.`clube` `c` join `aw`.`noticia_has_clube` `nc`) where (`c`.`idclube` = `nc`.`idclube`) group by `c`.`idclube`;

--
-- Dumping data for table `noticia_x_clube`
--


-- --------------------------------------------------------

--
-- Table structure for table `nr_noticia_data`
--

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `aw`.`nr_noticia_data` AS select month(`nd`.`data_interpretada`) AS `month( nd.data_interpretada )`,count(0) AS `nr_noticia` from `aw`.`noticia_data` `nd` where (`nd`.`data_interpretada` like '2012-%');

--
-- Dumping data for table `nr_noticia_data`
--

INSERT INTO `nr_noticia_data` (`month( nd.data_interpretada )`, `nr_noticia`) VALUES
(NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `nr_noticia_integrante`
--

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `aw`.`nr_noticia_integrante` AS select `i`.`nome_integrante` AS `nome_integrante`,count(0) AS `nr_noticia` from (`aw`.`integrante` `i` join `aw`.`noticia_has_integrante` `ni`) where (`i`.`idintegrante` = `ni`.`idintegrante`) group by `i`.`idintegrante`;

--
-- Dumping data for table `nr_noticia_integrante`
--


-- --------------------------------------------------------

--
-- Table structure for table `nr_noticia_local_clube`
--

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `aw`.`nr_noticia_local_clube` AS select `l`.`nome_local` AS `nome_local`,`c`.`nome_oficial` AS `nome_oficial`,count(`n`.`idnoticia`) AS `count( n.idnoticia )` from ((((`aw`.`noticia_locais` `nl` join `aw`.`local` `l`) join `aw`.`clube` `c`) join `aw`.`noticia` `n`) join `aw`.`noticia_has_clube` `nc`) where ((`nl`.`idlocal` = `l`.`idlocal`) and (`n`.`idnoticia` = `nl`.`idnoticia`) and (`n`.`idnoticia` = `nc`.`idnoticia`) and (`nc`.`idclube` = `c`.`idclube`) and (`nl`.`idnoticia` = `nc`.`idnoticia`)) group by `l`.`idlocal`,`c`.`idclube`;

--
-- Dumping data for table `nr_noticia_local_clube`
--


-- --------------------------------------------------------

--
-- Table structure for table `parametros`
--

CREATE TABLE IF NOT EXISTS `parametros` (
  `idparametros` int(11) NOT NULL,
  `nome_parametro` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`idparametros`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `parametros`
--


-- --------------------------------------------------------

--
-- Table structure for table `testview`
--

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `aw`.`testview` AS select `l`.`nucleo` AS `nucleo`,`l`.`contexto` AS `contexto`,`l`.`entidade` AS `entidade`,`l`.`tipo` AS `tipo`,`l`.`pol` AS `pol`,`l`.`ambiguidade` AS `ambiguidade`,`l`.`idlexico` AS `idlexico`,`i`.`nome_integrante` AS `nome_integrante` from ((`aw`.`lexico` `l` join `aw`.`integrante` `i`) join `aw`.`integrantes_lexico` `il`) where ((`l`.`idlexico` = `il`.`idlexico`) and (`i`.`idintegrante` = `il`.`idintegrante`));

--
-- Dumping data for table `testview`
--

INSERT INTO `testview` (`nucleo`, `contexto`, `entidade`, `tipo`, `pol`, `ambiguidade`, `idlexico`, `nome_integrante`) VALUES
(NULL, 'Pereira', NULL, 'dbpedia_name', 0, 0, 5, 'Pereira, Carlos'),
(NULL, 'Carlos', NULL, 'dbpedia_name', 0, 0, 6, 'Pereira, Carlos');

-- --------------------------------------------------------

--
-- Table structure for table `view_noticia_clube`
--
-- in use(#1356 - View 'aw.view_noticia_clube' references invalid table(s) or column(s) or function(s) or definer/invoker of view lack rights to use them)

--
-- Dumping data for table `view_noticia_clube`
--
-- in use (#1356 - View 'aw.view_noticia_clube' references invalid table(s) or column(s) or function(s) or definer/invoker of view lack rights to use them)

-- --------------------------------------------------------

--
-- Table structure for table `view_noticia_clube_lexico`
--
-- in use(#1356 - View 'aw.view_noticia_clube_lexico' references invalid table(s) or column(s) or function(s) or definer/invoker of view lack rights to use them)

--
-- Dumping data for table `view_noticia_clube_lexico`
--
-- in use (#1356 - View 'aw.view_noticia_clube_lexico' references invalid table(s) or column(s) or function(s) or definer/invoker of view lack rights to use them)

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comentario`
--
ALTER TABLE `comentario`
  ADD CONSTRAINT `comentario_ibfk_1` FOREIGN KEY (`idnoticia`) REFERENCES `noticia` (`idnoticia`) ON DELETE CASCADE;

--
-- Constraints for table `noticia_data`
--
ALTER TABLE `noticia_data`
  ADD CONSTRAINT `noticia_data_ibfk_1` FOREIGN KEY (`idnoticia`) REFERENCES `noticia` (`idnoticia`) ON DELETE CASCADE;

--
-- Constraints for table `noticia_has_clube`
--
ALTER TABLE `noticia_has_clube`
  ADD CONSTRAINT `noticia_has_clube_ibfk_1` FOREIGN KEY (`idclube`) REFERENCES `clube` (`idclube`) ON DELETE CASCADE,
  ADD CONSTRAINT `noticia_has_clube_ibfk_2` FOREIGN KEY (`idnoticia`) REFERENCES `noticia` (`idnoticia`) ON DELETE CASCADE;

--
-- Constraints for table `noticia_has_integrante`
--
ALTER TABLE `noticia_has_integrante`
  ADD CONSTRAINT `noticia_has_integrante_ibfk_1` FOREIGN KEY (`idnoticia`) REFERENCES `noticia` (`idnoticia`) ON DELETE CASCADE,
  ADD CONSTRAINT `noticia_has_integrante_ibfk_2` FOREIGN KEY (`idintegrante`) REFERENCES `integrante` (`idintegrante`) ON DELETE CASCADE;

--
-- Constraints for table `noticia_locais`
--
ALTER TABLE `noticia_locais`
  ADD CONSTRAINT `noticia_locais_ibfk_1` FOREIGN KEY (`idnoticia`) REFERENCES `noticia` (`idnoticia`) ON DELETE CASCADE,
  ADD CONSTRAINT `noticia_locais_ibfk_2` FOREIGN KEY (`idlocal`) REFERENCES `local` (`idlocal`) ON DELETE CASCADE;
