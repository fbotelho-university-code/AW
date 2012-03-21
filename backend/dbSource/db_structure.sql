-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tempo de Geração: Mar 21, 2012 as 07:32 PM
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

CREATE TABLE IF NOT EXISTS `competicao` (
  `idcompeticao` int(11) NOT NULL AUTO_INCREMENT,
  `nome_competicao` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  PRIMARY KEY (`idcompeticao`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `fonte`
--

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

CREATE TABLE IF NOT EXISTS `fonte_has_parametros` (
  `idfonte` int(11) NOT NULL,
  `idparametros` int(11) NOT NULL,
  PRIMARY KEY (`idfonte`,`idparametros`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `funcao`
--

CREATE TABLE IF NOT EXISTS `funcao` (
  `idfuncao` int(11) NOT NULL AUTO_INCREMENT,
  `funcao` varchar(45) CHARACTER SET latin1 DEFAULT NULL,
  PRIMARY KEY (`idfuncao`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `integrante`
--

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `noticia_has_clube`
--

CREATE TABLE IF NOT EXISTS `noticia_has_clube` (
  `idnoticia` int(11) NOT NULL,
  `idclube` int(11) NOT NULL,
  `qualificacao` int(1) NOT NULL,
  PRIMARY KEY (`idnoticia`,`idclube`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `noticia_has_integrante`
--

CREATE TABLE IF NOT EXISTS `noticia_has_integrante` (
  `idnoticia` int(11) NOT NULL,
  `idintegrante` int(11) NOT NULL,
  `qualificacao` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idnoticia`,`idintegrante`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `noticia_locais`
--

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

CREATE TABLE IF NOT EXISTS `parametros` (
  `idparametros` int(11) NOT NULL,
  `nome_parametro` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  PRIMARY KEY (`idparametros`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;