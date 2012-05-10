-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 07, 2012 at 03:21 PM
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
-- Structure for view `noticia_data_clube`
--

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `noticia_data_clube` AS select month(`nd`.`data_interpretada`) AS `mes`,`c`.`nome_oficial` AS `nome_oficial`,count(`n`.`idnoticia`) AS `nr_noticia` from (((`noticia_data` `nd` join `clube` `c`) join `noticia` `n`) join `noticia_has_clube` `nc`) where ((`n`.`idnoticia` = `nd`.`idnoticia`) and (`n`.`idnoticia` = `nc`.`idnoticia`) and (`nc`.`idclube` = `c`.`idclube`) and (`nd`.`idnoticia` = `nc`.`idnoticia`) and (`nd`.`data_interpretada` like '2012-%')) group by month(`nd`.`data_interpretada`),`c`.`idclube`;

--
-- VIEW  `noticia_data_clube`
-- Data: None
--

-- --------------------------------------------------------

--
-- Structure for view `noticia_x_clube`
--

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `noticia_x_clube` AS select `c`.`nome_oficial` AS `nome_oficial`,count(0) AS `nr_noticia` from (`clube` `c` join `noticia_has_clube` `nc`) where (`c`.`idclube` = `nc`.`idclube`) group by `c`.`idclube`;

--
-- VIEW  `noticia_x_clube`
-- Data: None
--

-- --------------------------------------------------------

--
-- Structure for view `nr_noticia_data`
--

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `nr_noticia_data` AS select month(`nd`.`data_interpretada`) AS `mes`,count(0) AS `nr_noticia` from `noticia_data` `nd` where (`nd`.`data_interpretada` like '2012-%') group by month(`nd`.`data_interpretada`);

--
-- VIEW  `nr_noticia_data`
-- Data: None
--

-- --------------------------------------------------------

--
-- Structure for view `nr_noticia_integrante`
--

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `nr_noticia_integrante` AS select `i`.`nome_integrante` AS `nome_integrante`,count(0) AS `nr_noticia` from (`integrante` `i` join `noticia_has_integrante` `ni`) where (`i`.`idintegrante` = `ni`.`idintegrante`) group by `i`.`idintegrante`;

--
-- VIEW  `nr_noticia_integrante`
-- Data: None
--

-- --------------------------------------------------------

--
-- Structure for view `nr_noticia_local`
--

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `nr_noticia_local` AS select distinct `l`.`nome_local` AS `nome_local`,count(0) AS `nr_noticia` from (`local` `l` join `noticia_locais` `nl`) where (`l`.`idlocal` = `nl`.`idlocal`) group by `l`.`idlocal`;

--
-- VIEW  `nr_noticia_local`
-- Data: None
--

-- --------------------------------------------------------

--
-- Structure for view `nr_noticia_local_clube`
--

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `nr_noticia_local_clube` AS select distinct `l`.`nome_local` AS `nome_local`,`c`.`nome_oficial` AS `nome_oficial`,count(`n`.`idnoticia`) AS `nr_noticia` from ((((`local` `l` join `clube` `c`) join `noticia_locais` `nl`) join `noticia_has_clube` `nc`) join `noticia` `n`) where ((`nl`.`idlocal` = `l`.`idlocal`) and (`n`.`idnoticia` = `nl`.`idnoticia`) and (`n`.`idnoticia` = `nc`.`idnoticia`) and (`nc`.`idclube` = `c`.`idclube`) and (`nl`.`idnoticia` = `nc`.`idnoticia`)) group by `l`.`idlocal`,`c`.`idclube`;

--
-- VIEW  `nr_noticia_local_clube`
-- Data: None
--