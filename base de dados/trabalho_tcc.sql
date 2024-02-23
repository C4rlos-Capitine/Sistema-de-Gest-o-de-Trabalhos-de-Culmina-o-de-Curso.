-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Feb 23, 2024 at 10:28 AM
-- Server version: 8.2.0
-- PHP Version: 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `trabalho_tcc`
--

-- --------------------------------------------------------

--
-- Table structure for table `actua_em`
--

DROP TABLE IF EXISTS `actua_em`;
CREATE TABLE IF NOT EXISTS `actua_em` (
  `id_curso` int NOT NULL,
  `codigo_docente` varchar(12) NOT NULL,
  PRIMARY KEY (`id_curso`,`codigo_docente`),
  KEY `codigo_docente` (`codigo_docente`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `actua_em_area`
--

DROP TABLE IF EXISTS `actua_em_area`;
CREATE TABLE IF NOT EXISTS `actua_em_area` (
  `id_area` int NOT NULL,
  `codigo_docente` varchar(13) NOT NULL,
  PRIMARY KEY (`id_area`,`codigo_docente`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `actua_em_area`
--

INSERT INTO `actua_em_area` (`id_area`, `codigo_docente`) VALUES
(1, '01.1022.josa'),
(1, '01.1027.vama'),
(1, '01.1236.cj'),
(2, '01.1236.cj');

-- --------------------------------------------------------

--
-- Table structure for table `area_cientifica`
--

DROP TABLE IF EXISTS `area_cientifica`;
CREATE TABLE IF NOT EXISTS `area_cientifica` (
  `id_area_cientifica` int NOT NULL AUTO_INCREMENT,
  `id_curso` int NOT NULL,
  `designacao_area_cientifica` varchar(50) NOT NULL,
  PRIMARY KEY (`id_area_cientifica`),
  KEY `id_curso` (`id_curso`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `area_cientifica`
--

INSERT INTO `area_cientifica` (`id_area_cientifica`, `id_curso`, `designacao_area_cientifica`) VALUES
(1, 1, 'Densevolvimento de Sistemas'),
(2, 1, 'Redes de Computadores'),
(5, 1, 'Didatica de Informatica');

-- --------------------------------------------------------

--
-- Table structure for table `arquivo`
--

DROP TABLE IF EXISTS `arquivo`;
CREATE TABLE IF NOT EXISTS `arquivo` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_curso` int NOT NULL,
  `path` text NOT NULL,
  `nome` varchar(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `arquivo`
--

INSERT INTO `arquivo` (`id`, `id_curso`, `path`, `nome`) VALUES
(1, 1, 'arquivos/informatica-tcc.xlsx.xlsx', '28-05-23informatica-tcc.xlsx'),
(3, 1, 'arquivos/informatica-tcc.xlsx', '28-05-23informatica-tcc.xlsx'),
(4, 1, 'arquivos/informatica-tcc.xlsx', '28-05-23informatica-tcc.xlsx'),
(5, 1, 'arquivos/informatica-tcc.xlsx', '29-05-23informatica-tcc.xlsx'),
(6, 1, 'arquivos/informatica-tcc.xlsx', '31-05-23informatica-tcc.xlsx'),
(15, 2, 'arquivos/Electronica.xlsx', '11-06-23Electronica.xlsx'),
(16, 2, 'arquivos/Electronica2.xlsx', '12-06-23Electronica2.xlsx'),
(17, 1, 'arquivos/Info2.xlsx', '14-06-23Info2.xlsx'),
(18, 1, 'arquivos/Info2.xlsx', '14-06-23Info2.xlsx'),
(19, 1, 'arquivos/Info2.xlsx', '14-06-23Info2.xlsx'),
(20, 1, 'arquivos/Info2.xlsx', '14-06-23Info2.xlsx'),
(21, 1, 'arquivos/Info2.xlsx', '14-06-23Info2.xlsx'),
(22, 1, 'arquivos/Electronica2.xlsx', '17-06-23Electronica2.xlsx'),
(23, 1, 'arquivos/Electronica2.xlsx', '17-06-23Electronica2.xlsx'),
(24, 1, 'arquivos/Electronica2.xlsx', '17-06-23Electronica2.xlsx'),
(25, 1, 'arquivos/Electronica2.xlsx', '20-06-23Electronica2.xlsx'),
(26, 2, 'arquivos/ElectronicaB.xlsx', '26-06-23ElectronicaB.xlsx'),
(27, 2, 'arquivos/ElectronicaC.xlsx', '28-06-23ElectronicaC.xlsx'),
(28, 2, 'arquivos/ElectronicaC.xlsx', '28-06-23ElectronicaC.xlsx'),
(29, 1, 'arquivos/info2023.xlsx', '27-09-23info2023.xlsx');

-- --------------------------------------------------------

--
-- Table structure for table `codigo`
--

DROP TABLE IF EXISTS `codigo`;
CREATE TABLE IF NOT EXISTS `codigo` (
  `id` int NOT NULL AUTO_INCREMENT,
  `cod` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `codigo`
--

INSERT INTO `codigo` (`id`, `cod`) VALUES
(1, 1028);

-- --------------------------------------------------------

--
-- Table structure for table `curso`
--

DROP TABLE IF EXISTS `curso`;
CREATE TABLE IF NOT EXISTS `curso` (
  `id_curso` int NOT NULL AUTO_INCREMENT,
  `id_faculdade` int NOT NULL,
  `designacao` varchar(180) NOT NULL,
  `sigla` varchar(6) NOT NULL,
  PRIMARY KEY (`id_curso`),
  KEY `id_faculdade` (`id_faculdade`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `curso`
--

INSERT INTO `curso` (`id_curso`, `id_faculdade`, `designacao`, `sigla`) VALUES
(1, 1, 'Licenciatura em Informatica', 'LI'),
(2, 1, 'Engenharia Electronica', 'EE'),
(3, 1, 'Agro-processamento', 'AP'),
(16, 1, 'Engenharia Civil', 'ECC'),
(17, 3, 'Licenciatura em Ensino de Matematica', 'LEM'),
(18, 3, 'Ensino de Fisica', 'LEF');

-- --------------------------------------------------------

--
-- Table structure for table `dir_curso`
--

DROP TABLE IF EXISTS `dir_curso`;
CREATE TABLE IF NOT EXISTS `dir_curso` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_curso` int NOT NULL,
  `user_id` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dir_curso`
--

INSERT INTO `dir_curso` (`id`, `id_curso`, `user_id`) VALUES
(1, 1, 16),
(2, 2, 17),
(3, 16, 18);

-- --------------------------------------------------------

--
-- Table structure for table `docente`
--

DROP TABLE IF EXISTS `docente`;
CREATE TABLE IF NOT EXISTS `docente` (
  `codigo_docente` varchar(20) NOT NULL,
  `nome_docente` varchar(50) NOT NULL,
  `apelido` varchar(25) NOT NULL,
  `id_curso` int NOT NULL,
  `genero` varchar(1) NOT NULL,
  PRIMARY KEY (`codigo_docente`),
  KEY `id_curso` (`id_curso`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `docente`
--

INSERT INTO `docente` (`codigo_docente`, `nome_docente`, `apelido`, `id_curso`, `genero`) VALUES
('01.1236.cj', 'Claudia Ivete', 'Jovo', 1, 'F'),
('01.1020.cese', 'Celio Barbosa', 'Sengo', 1, 'M'),
('01.1022.josa', 'Jose Luis', 'Sambo', 1, 'M'),
('01.1023.urma', 'Uranio Stafane', 'Mahanjane', 2, 'M'),
('01.1025.arma', 'Armando Elisio', 'Maxlhaieie', 2, 'M'),
('01.1026.amvu', 'Ambrosio Patricio', 'Vumo', 2, 'M'),
('01.1027.vama', 'ValdinÃ¢ncio Florencio', 'Martins', 1, 'M');

-- --------------------------------------------------------

--
-- Table structure for table `docente_tcc`
--

DROP TABLE IF EXISTS `docente_tcc`;
CREATE TABLE IF NOT EXISTS `docente_tcc` (
  `id_curso` int NOT NULL,
  `codigo_docente` varchar(12) DEFAULT NULL,
  PRIMARY KEY (`id_curso`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `docente_tcc`
--

INSERT INTO `docente_tcc` (`id_curso`, `codigo_docente`) VALUES
(1, '01.1022.josa'),
(2, '01.1023.urma'),
(16, NULL),
(17, NULL),
(18, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `estudante`
--

DROP TABLE IF EXISTS `estudante`;
CREATE TABLE IF NOT EXISTS `estudante` (
  `codigo_estudante` varchar(20) NOT NULL,
  `nome_estudante` varchar(50) NOT NULL,
  `apelido` varchar(25) NOT NULL,
  `id_curso` int NOT NULL,
  `ano_ingresso` year NOT NULL,
  `sexo` varchar(1) NOT NULL,
  `id_minor` int NOT NULL,
  `regime` varchar(15) NOT NULL,
  PRIMARY KEY (`codigo_estudante`),
  KEY `id_curso` (`id_curso`),
  KEY `id_minor` (`id_minor`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `estudante`
--

INSERT INTO `estudante` (`codigo_estudante`, `nome_estudante`, `apelido`, `id_curso`, `ano_ingresso`, `sexo`, `id_minor`, `regime`) VALUES
('01.2356.2018', 'ABC', 'Mangue', 2, '2018', 'M', 4, 'laboral'),
('01.1234.2020', 'DEF', 'Cumbana', 2, '2020', 'F', 10, 'laboral'),
('01.1234.2016', 'ABC', 'Mangue', 2, '2016', 'M', 4, 'laboral'),
('01.1234.2017', 'DEF', 'Cumbana', 2, '2017', 'F', 4, 'laboral'),
('01.1234.2021', 'Xavier', 'Ilacinho', 1, '2021', 'M', 1, 'laboral'),
('01.2356.2020', 'Edilson Eugenio', 'Mangue', 1, '2020', 'M', 1, 'laboral'),
('01.2357.2020', 'Telma Da Calista', 'Cumbana', 1, '2020', 'F', 1, 'laboral'),
('01.2358.2020', 'Agostinho Domingos', 'Ngonga', 1, '2020', 'M', 1, 'laboral'),
('01.2357.2019', 'Jaime De Leite', 'Zandamela', 1, '2019', 'M', 2, 'pos-laboral'),
('01.2359.2019', 'Paulino', 'Camala', 1, '2019', 'M', 2, 'pos-laboral');

-- --------------------------------------------------------

--
-- Table structure for table `faculdade`
--

DROP TABLE IF EXISTS `faculdade`;
CREATE TABLE IF NOT EXISTS `faculdade` (
  `id_faculdade` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(180) NOT NULL,
  `sigla` varchar(6) NOT NULL,
  PRIMARY KEY (`id_faculdade`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `faculdade`
--

INSERT INTO `faculdade` (`id_faculdade`, `nome`, `sigla`) VALUES
(1, 'Faculdade De Engenharia E Tecnologia', 'FET'),
(2, 'Faculdade de Economia e Gestao', 'FEG'),
(3, 'Faculdade de CiÃªncias Naturais e MatemÃ¡tica', 'FCNM');

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

DROP TABLE IF EXISTS `groups`;
CREATE TABLE IF NOT EXISTS `groups` (
  `id_group` int NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `permissoes` text NOT NULL,
  PRIMARY KEY (`id_group`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id_group`, `name`, `permissoes`) VALUES
(1, 'administrador', '{\r\n\"admin\":1,\r\n\"user\":0\r\n}'),
(2, 'standard_user', '{\r\n\"admin\":0,\r\n\"user\":1\r\n}');

-- --------------------------------------------------------

--
-- Table structure for table `minor`
--

DROP TABLE IF EXISTS `minor`;
CREATE TABLE IF NOT EXISTS `minor` (
  `id_minor` int NOT NULL AUTO_INCREMENT,
  `id_curso` int NOT NULL,
  `designacao_minor` varchar(180) NOT NULL,
  `sigla` varchar(6) NOT NULL,
  PRIMARY KEY (`id_minor`),
  KEY `id_curso` (`id_curso`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `minor`
--

INSERT INTO `minor` (`id_minor`, `id_curso`, `designacao_minor`, `sigla`) VALUES
(1, 1, 'Engenharia de Desenvolvimento de Sistemas', 'EDS'),
(2, 1, 'Engenharia de Redes', 'ER'),
(3, 1, 'Ensino de informatica', 'EI'),
(4, 2, 'Telecomunicacoes', 'TEL'),
(10, 2, 'Computacao', 'COMP');

-- --------------------------------------------------------

--
-- Table structure for table `trabalho`
--

DROP TABLE IF EXISTS `trabalho`;
CREATE TABLE IF NOT EXISTS `trabalho` (
  `codigo_estudante` varchar(20) NOT NULL,
  `codigo_docente` varchar(20) DEFAULT NULL,
  `tema` varchar(180) DEFAULT NULL,
  `descricao` text,
  `data_submissao` date DEFAULT NULL,
  `id_minor` int NOT NULL,
  `ficheiro` varchar(100) DEFAULT NULL,
  `estado` int NOT NULL DEFAULT '0',
  `ano_registo` year DEFAULT NULL,
  `ficheiro_monografia` text,
  `data_submissao2` date DEFAULT NULL,
  PRIMARY KEY (`codigo_estudante`),
  KEY `codigo_docente` (`codigo_docente`),
  KEY `id_minor` (`id_minor`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `trabalho`
--

INSERT INTO `trabalho` (`codigo_estudante`, `codigo_docente`, `tema`, `descricao`, `data_submissao`, `id_minor`, `ficheiro`, `estado`, `ano_registo`, `ficheiro_monografia`, `data_submissao2`) VALUES
('01.2356.2020', '01.1020.cese', 'Sistema de Gest...ABCD', 'dfdsfsfdfsdfdsfs', '2023-06-26', 1, 'arquivos/trabalhos/6499f138db017', 5, '2023', 'arquivos/monografias/649b8905e2f14', '2023-06-28'),
('01.2357.2020', NULL, 'Sistema de Gestao de Associados', 'Sistema de Gesta de associados.......', '2023-06-20', 1, NULL, 2, '2023', NULL, NULL),
('01.2358.2020', NULL, 'Sistema de gestao de estagios', 'jjjjjjjjjjjjjjj', '2023-06-28', 1, 'arquivos/trabalhos/649c98ad1bce5', 4, '2023', NULL, NULL),
('01.2357.2019', NULL, 'Rede UPnet', 'Rede UPnet', '2023-06-20', 2, NULL, 2, '2023', NULL, NULL),
('01.2359.2019', '01.1020.cese', 'Zonas Sombreadas em Redes moveis', 'Zonas Sombreadas em redes Moveis', '2023-06-20', 2, NULL, 2, '2023', NULL, NULL),
('01.2356.2018', NULL, NULL, NULL, NULL, 4, NULL, 0, NULL, NULL, NULL),
('01.1234.2020', NULL, NULL, NULL, NULL, 10, NULL, 0, NULL, NULL, NULL),
('01.1234.2016', NULL, NULL, NULL, NULL, 4, NULL, 0, NULL, NULL, NULL),
('01.1234.2017', NULL, NULL, NULL, NULL, 4, NULL, 0, NULL, NULL, NULL),
('01.1234.2021', NULL, 'plataforma Alumni', 'hhhhhhhh', '2023-09-27', 1, NULL, 1, '2023', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL,
  `apelido` varchar(25) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(64) NOT NULL,
  `group_id` int NOT NULL,
  `salt` varchar(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `nome`, `apelido`, `username`, `password`, `group_id`, `salt`) VALUES
(1, 'Carlos', 'Mutemba', '01.1003.camu', '3664d59aea4a6eae23e1fd4e44a1241eea96d65a069fd5235053e8c2b013d2e6', 1, 'ˆ÷¸ihé^¾í:%Ç[¨†ºæÃ—<ÄŠØ«Õžâhd'),
(16, 'Agostinho Domingos', 'Ngonga', '01.1018.agng', '07d195e4a0c0825681399dd3220c95052fcba9aefee89d603f92b115e61dddf0', 2, '!£‚lè¡QŸ&¥˜LËQÅã40Sã©,lÐ\''),
(17, 'Frederico', 'Ngonga', '01.1021.frng', '063531350ad84f6f4628bb05a1248bf702923a449978412a62cd04307a0e1b06', 2, ',ÀG$H½`OZ¸¸­M‘JÉo5ï?b-ÿÖù¶©bê²'),
(18, 'Rodney', 'tivane', '01.1028.roti', '80ba7909e4c4e1dbc193b35258d42975cacf5af3320777f73656e7fdfb0fdf4d', 2, '»—š%^¹—$²ÇÝ“„éaÙzÁ^Rm´Âkô™Î\"');

-- --------------------------------------------------------

--
-- Table structure for table `user_session`
--

DROP TABLE IF EXISTS `user_session`;
CREATE TABLE IF NOT EXISTS `user_session` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `hash` varchar(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=74 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_session`
--

INSERT INTO `user_session` (`id`, `user_id`, `hash`) VALUES
(73, 16, '19506912f0e151cefc9fc8982891a03087fe6fd25b32e4d636008d313c6db14e');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
