-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tempo de Geração: Mar 23, 2012 as 01:49 AM
-- Versão do Servidor: 5.5.8
-- Versão do PHP: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Banco de Dados: `aw`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `clube`
--
-- Criação: Mar 16, 2012 as 07:47 PM
--

DROP TABLE IF EXISTS `clube`;
CREATE TABLE IF NOT EXISTS `clube` (
  `idclube` int(11) NOT NULL AUTO_INCREMENT,
  `idlocal` int(11) NOT NULL,
  `idcompeticao` int(11) NOT NULL,
  `nome_clube` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `nome_oficial` varchar(100) NOT NULL,
  PRIMARY KEY (`idclube`,`idlocal`,`idcompeticao`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Esta tabela representa ....' AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `clubes_lexico`
--
-- Criação: Mar 16, 2012 as 07:47 PM
--

DROP TABLE IF EXISTS `clubes_lexico`;
CREATE TABLE IF NOT EXISTS `clubes_lexico` (
  `idclube` int(11) NOT NULL,
  `idlexico` int(11) NOT NULL,
  PRIMARY KEY (`idclube`,`idlexico`),
  KEY `idlexico` (`idlexico`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `competicao`
--
-- Criação: Mar 16, 2012 as 07:47 PM
--

DROP TABLE IF EXISTS `competicao`;
CREATE TABLE IF NOT EXISTS `competicao` (
  `idcompeticao` int(11) NOT NULL AUTO_INCREMENT,
  `nome_competicao` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  PRIMARY KEY (`idcompeticao`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `fonte`
--
-- Criação: Mar 16, 2012 as 07:47 PM
--

DROP TABLE IF EXISTS `fonte`;
CREATE TABLE IF NOT EXISTS `fonte` (
  `idfonte` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) CHARACTER SET latin1 DEFAULT NULL,
  `main_url` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `ligado` tinyint(1) NOT NULL,
  PRIMARY KEY (`idfonte`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `fonte_has_parametros`
--
-- Criação: Mar 16, 2012 as 07:47 PM
--

DROP TABLE IF EXISTS `fonte_has_parametros`;
CREATE TABLE IF NOT EXISTS `fonte_has_parametros` (
  `idfonte` int(11) NOT NULL,
  `idparametros` int(11) NOT NULL,
  PRIMARY KEY (`idfonte`,`idparametros`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `funcao`
--
-- Criação: Mar 16, 2012 as 07:47 PM
--

DROP TABLE IF EXISTS `funcao`;
CREATE TABLE IF NOT EXISTS `funcao` (
  `idfuncao` int(11) NOT NULL AUTO_INCREMENT,
  `funcao` varchar(45) CHARACTER SET latin1 DEFAULT NULL,
  PRIMARY KEY (`idfuncao`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `integrante`
--
-- Criação: Mar 16, 2012 as 07:47 PM
--

DROP TABLE IF EXISTS `integrante`;
CREATE TABLE IF NOT EXISTS `integrante` (
  `idintegrante` int(11) NOT NULL AUTO_INCREMENT,
  `idclube` int(11) NOT NULL,
  `idfuncao` int(11) NOT NULL,
  `nome_integrante` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`idintegrante`,`idclube`,`idfuncao`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=180 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `integrantes_lexico`
--
-- Criação: Mar 16, 2012 as 07:47 PM
--

DROP TABLE IF EXISTS `integrantes_lexico`;
CREATE TABLE IF NOT EXISTS `integrantes_lexico` (
  `idintegrante` int(11) NOT NULL,
  `idlexico` int(11) NOT NULL,
  PRIMARY KEY (`idintegrante`,`idlexico`),
  KEY `idlexico` (`idlexico`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `lexico`
--
-- Criação: Mar 16, 2012 as 07:47 PM
--

DROP TABLE IF EXISTS `lexico`;
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

-- --------------------------------------------------------

--
-- Estrutura da tabela `local`
--
-- Criação: Mar 16, 2012 as 07:47 PM
--

DROP TABLE IF EXISTS `local`;
CREATE TABLE IF NOT EXISTS `local` (
  `idlocal` int(11) NOT NULL AUTO_INCREMENT,
  `nome_local` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `coordenadas` varchar(45) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`idlocal`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=338 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `noticia`
--
-- Criação: Mar 16, 2012 as 07:47 PM
--

DROP TABLE IF EXISTS `noticia`;
CREATE TABLE IF NOT EXISTS `noticia` (
  `idnoticia` int(11) NOT NULL AUTO_INCREMENT,
  `idfonte` int(11) NOT NULL,
  `data_pub` datetime DEFAULT NULL,
  `assunto` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `descricao` varchar(250) CHARACTER SET latin1 DEFAULT NULL,
  `texto` longtext CHARACTER SET latin1,
  `url` text CHARACTER SET latin1,
  `visivel` tinyint(1) NOT NULL,
  PRIMARY KEY (`idnoticia`,`idfonte`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=101 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `noticia_data`
--
-- Criação: Mar 21, 2012 as 11:26 PM
--

DROP TABLE IF EXISTS `noticia_data`;
CREATE TABLE IF NOT EXISTS `noticia_data` (
  `idnoticia` int(11) NOT NULL,
  `tempo` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `noticia_has_clube`
--
-- Criação: Mar 16, 2012 as 07:47 PM
--

DROP TABLE IF EXISTS `noticia_has_clube`;
CREATE TABLE IF NOT EXISTS `noticia_has_clube` (
  `idnoticia` int(11) NOT NULL,
  `idclube` int(11) NOT NULL,
  `qualificacao` int(1) NOT NULL,
  `idlexico` int(11) NOT NULL,
  PRIMARY KEY (`idnoticia`,`idclube`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `noticia_has_integrante`
--
-- Criação: Mar 16, 2012 as 07:47 PM
--

DROP TABLE IF EXISTS `noticia_has_integrante`;
CREATE TABLE IF NOT EXISTS `noticia_has_integrante` (
  `idnoticia` int(11) NOT NULL,
  `idintegrante` int(11) NOT NULL,
  `qualificacao` int(11) NOT NULL DEFAULT '0',
  `idlexico` int(11) NOT NULL,
  PRIMARY KEY (`idnoticia`,`idintegrante`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `noticia_locais`
--
-- Criação: Mar 16, 2012 as 07:47 PM
--

DROP TABLE IF EXISTS `noticia_locais`;
CREATE TABLE IF NOT EXISTS `noticia_locais` (
  `idnoticia` int(11) NOT NULL,
  `idlocal` int(11) NOT NULL,
  PRIMARY KEY (`idnoticia`,`idlocal`),
  KEY `idnoticia` (`idnoticia`,`idlocal`),
  KEY `idlocal` (`idlocal`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `parametros`
--
-- Criação: Mar 16, 2012 as 07:47 PM
--

DROP TABLE IF EXISTS `parametros`;
CREATE TABLE IF NOT EXISTS `parametros` (
  `idparametros` int(11) NOT NULL,
  `nome_parametro` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  PRIMARY KEY (`idparametros`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura stand-in para visualizar `view_noticia_clube`
--
DROP VIEW IF EXISTS `view_noticia_clube`;
CREATE TABLE IF NOT EXISTS `view_noticia_clube` (
`idnoticia` int(11)
,`assunto` varchar(100)
,`nome_clube` varchar(100)
);
-- --------------------------------------------------------

--
-- Estrutura stand-in para visualizar `view_noticia_clube_lexico`
--
DROP VIEW IF EXISTS `view_noticia_clube_lexico`;
CREATE TABLE IF NOT EXISTS `view_noticia_clube_lexico` (
`idnoticia` int(11)
,`assunto` varchar(100)
,`nome_clube` varchar(100)
,`contexto` varchar(255)
,`pol` int(10)
,`ambiguidade` int(10)
);
-- --------------------------------------------------------

--
-- Estrutura stand-in para visualizar `view_noticia_data`
--
DROP VIEW IF EXISTS `view_noticia_data`;
CREATE TABLE IF NOT EXISTS `view_noticia_data` (
`idnoticia` int(11)
,`assunto` varchar(100)
,`data_pub` datetime
,`tempo` varchar(100)
);
-- --------------------------------------------------------

--
-- Estrutura stand-in para visualizar `view_noticia_integrante`
--
DROP VIEW IF EXISTS `view_noticia_integrante`;
CREATE TABLE IF NOT EXISTS `view_noticia_integrante` (
`idnoticia` int(11)
,`assunto` varchar(100)
,`funcao` varchar(45)
,`nome_integrante` varchar(100)
);
-- --------------------------------------------------------

--
-- Estrutura stand-in para visualizar `view_noticia_local`
--
DROP VIEW IF EXISTS `view_noticia_local`;
CREATE TABLE IF NOT EXISTS `view_noticia_local` (
`idnoticia` int(11)
,`assunto` varchar(100)
,`nome_local` varchar(100)
,`coordenadas` varchar(45)
);
-- --------------------------------------------------------

--
-- Estrutura para visualizar `view_noticia_clube`
--
DROP TABLE IF EXISTS `view_noticia_clube`;

CREATE ALGORITHM=TEMPTABLE DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_noticia_clube` AS select `n`.`idnoticia` AS `idnoticia`,`n`.`assunto` AS `assunto`,`c`.`nome_clube` AS `nome_clube` from ((`noticia` `n` join `clube` `c`) join `noticia_has_clube` `nc`) where ((`n`.`idnoticia` = `nc`.`idnoticia`) and (`c`.`idclube` = `nc`.`idclube`)) order by `n`.`idnoticia`;

-- --------------------------------------------------------

--
-- Estrutura para visualizar `view_noticia_clube_lexico`
--
DROP TABLE IF EXISTS `view_noticia_clube_lexico`;

CREATE ALGORITHM=TEMPTABLE DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_noticia_clube_lexico` AS select `n`.`idnoticia` AS `idnoticia`,`n`.`assunto` AS `assunto`,`c`.`nome_clube` AS `nome_clube`,`l`.`contexto` AS `contexto`,`l`.`pol` AS `pol`,`l`.`ambiguidade` AS `ambiguidade` from ((((`noticia` `n` join `clube` `c`) join `noticia_has_clube` `nc`) join `lexico` `l`) join `clubes_lexico` `cl`) where ((`n`.`idnoticia` = `nc`.`idnoticia`) and (`c`.`idclube` = `nc`.`idclube`) and (`l`.`idlexico` = `nc`.`idlexico`) and (`cl`.`idclube` = `c`.`idclube`) and (`cl`.`idlexico` = `l`.`idlexico`)) order by `n`.`idnoticia`;

-- --------------------------------------------------------

--
-- Estrutura para visualizar `view_noticia_data`
--
DROP TABLE IF EXISTS `view_noticia_data`;

CREATE ALGORITHM=TEMPTABLE DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_noticia_data` AS select `n`.`idnoticia` AS `idnoticia`,`n`.`assunto` AS `assunto`,`n`.`data_pub` AS `data_pub`,`nd`.`tempo` AS `tempo` from (`noticia` `n` join `noticia_data` `nd`) where (`n`.`idnoticia` = `nd`.`idnoticia`) order by `n`.`idnoticia`;

-- --------------------------------------------------------

--
-- Estrutura para visualizar `view_noticia_integrante`
--
DROP TABLE IF EXISTS `view_noticia_integrante`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_noticia_integrante` AS select `n`.`idnoticia` AS `idnoticia`,`n`.`assunto` AS `assunto`,`f`.`funcao` AS `funcao`,`i`.`nome_integrante` AS `nome_integrante` from (((`noticia` `n` join `funcao` `f`) join `integrante` `i`) join `noticia_has_integrante` `ni`) where ((`n`.`idnoticia` = `ni`.`idnoticia`) and (`i`.`idintegrante` = `ni`.`idintegrante`) and (`f`.`idfuncao` = `i`.`idfuncao`)) order by `n`.`idnoticia`;

-- --------------------------------------------------------

--
-- Estrutura para visualizar `view_noticia_local`
--
DROP TABLE IF EXISTS `view_noticia_local`;

CREATE ALGORITHM=TEMPTABLE DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_noticia_local` AS select `n`.`idnoticia` AS `idnoticia`,`n`.`assunto` AS `assunto`,`l`.`nome_local` AS `nome_local`,`l`.`coordenadas` AS `coordenadas` from ((`noticia` `n` join `local` `l`) join `noticia_locais` `nl`) where ((`n`.`idnoticia` = `nl`.`idnoticia`) and (`l`.`idlocal` = `nl`.`idlocal`)) order by `n`.`idnoticia`;
