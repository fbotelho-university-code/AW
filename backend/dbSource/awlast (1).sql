-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 10, 2012 at 12:48 PM
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
-- Table structure for table `bitaites`
--

CREATE TABLE IF NOT EXISTS `bitaites` (
  `texto` varchar(10048) NOT NULL,
  `url` varchar(1024) NOT NULL,
  `idbitaite` int(11) NOT NULL AUTO_INCREMENT,
  `user` varchar(11) NOT NULL,
  `datapub` datetime DEFAULT NULL,
  `about` varchar(1024) NOT NULL,
  PRIMARY KEY (`idbitaite`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `bitaites`
--

INSERT INTO `bitaites` (`texto`, `url`, `idbitaite`, `user`, `datapub`, `about`) VALUES
('Se por acaso receber algum e-mail com o Assunto: \\''\\''Sem título\\''\\'', é favor reencaminhar para … o Sport Lisboa e Benfica!.', 'http://twitter.com/goncaloof/statuses/200563705400922113', 1, 'goncaloof@t', NULL, 'Sport Lisboa e Benfica'),
('Re: [FM12] - O sonho de um verdadeiro campeão! - Sport Lisboa e Benfica: Liga Zon SagresTiveste 7 jogos .Vou fal... http://t.co/i3PfNmnq', 'http://twitter.com/Futeboltuga/statuses/200478084942663680', 2, 'Futeboltuga', NULL, 'Sport Lisboa e Benfica'),
('Checkpoint (@ Estádio do Sport Lisboa e Benfica) http://t.co/Z9Fm64Kc', 'http://twitter.com/djakisy/statuses/200469163444158464', 3, 'djakisy@twi', NULL, 'Sport Lisboa e Benfica'),
('Sports City é um jogo eclético como o Sport Lisboa e Benfica. Qual é o teu pref... http://t.co/Erofj8s6', 'http://twitter.com/SL_Benfica/statuses/200333425947836417', 4, 'SL_Benfica@', NULL, 'Sport Lisboa e Benfica'),
('Artur: “Ainda tenho muito para jogar e ganhar no Benfica” - Sport Lisboa e Benfica: Sport Lisboa e BenficaArtur:... http://t.co/pBUWRSIm', 'http://twitter.com/lowcostsport/statuses/200316431504646144', 5, 'lowcostspor', NULL, 'Sport Lisboa e Benfica'),
('Telma Monteiro no Sport Lisboa e Benfica - Modalidades http://t.co/nVXrjBVw', 'http://twitter.com/SL_Benfica/statuses/200285033234313217', 6, 'SL_Benfica@', NULL, 'Sport Lisboa e Benfica'),
('RT @JG1904: pinas? \n#Sport Lisboa e Benfica - Modalidades\nTelma Monteiro está Online façam as vossas perguntas!\\"', 'http://twitter.com/marisacsr/statuses/200257913166635009', 7, 'marisacsr@t', NULL, 'Sport Lisboa e Benfica'),
('Telma Monteiro já está Online no Sport Lisboa e Benfica - Modalidades. Façam as... http://t.co/QfIh4dMk', 'http://twitter.com/SL_Benfica/statuses/200256374641410048', 8, 'SL_Benfica@', NULL, 'Sport Lisboa e Benfica'),
('Não percam, às 17h00, no Sport Lisboa e Benfica - Modalidades, Telma Monteiro. A... http://t.co/JvDCcaya', 'http://twitter.com/SL_Benfica/statuses/200243767234670593', 9, 'SL_Benfica@', NULL, 'Sport Lisboa e Benfica'),
('I\\''m at Estádio do Sport Lisboa e Benfica (Lisboa) http://t.co/t6TAMJBo', 'http://twitter.com/luispires2b/statuses/200231732232978432', 10, 'luispires2b', NULL, 'Sport Lisboa e Benfica'),
('RT @SL_Benfica: Sport Lisboa e Benfica - Formação do Glorioso presente no Apuramento do Campeona... http://t.co/uwf70jX1', 'http://twitter.com/katyserra/statuses/200186187565113344', 11, 'katyserra@t', NULL, 'Sport Lisboa e Benfica'),
('Sport Lisboa e Benfica - Formação do Glorioso presente no Apuramento do Campeona... http://t.co/uwf70jX1', 'http://twitter.com/SL_Benfica/statuses/200185620130316288', 12, 'SL_Benfica@', NULL, 'Sport Lisboa e Benfica'),
('Back again (@ Estádio do Sport Lisboa e Benfica) http://t.co/n964mOaH', 'http://twitter.com/djakisy/statuses/200095971235999744', 13, 'djakisy@twi', NULL, 'Sport Lisboa e Benfica'),
('Buy Portugal - Turkey Tickets,   Saturday, 02 June 2012. Estadio da Luz (Estadio do Sport Lisboa e Benfica), Lis... http://t.co/je6fQpsm', 'http://twitter.com/Soccer_Tickets/statuses/200024644265324546', 14, 'Soccer_Tick', NULL, 'Sport Lisboa e Benfica'),
('RT @fab_turner: and the only one RT @joanarmota #OneThingILove o meu Sport Lisboa e Benfica.', 'http://twitter.com/joanarmota/statuses/199987773124521984', 15, 'joanarmota@', NULL, 'Sport Lisboa e Benfica');
