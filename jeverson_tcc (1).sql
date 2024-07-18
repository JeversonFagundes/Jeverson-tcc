-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 18-Jul-2024 às 17:06
-- Versão do servidor: 8.0.31
-- versão do PHP: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `jeverson_tcc`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `administrador`
--

DROP TABLE IF EXISTS `administrador`;
CREATE TABLE IF NOT EXISTS `administrador` (
  `id_administrador` int NOT NULL AUTO_INCREMENT,
  `email` varchar(255) DEFAULT NULL,
  `senha` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_administrador`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `administrador`
--

INSERT INTO `administrador` (`id_administrador`, `email`, `senha`) VALUES
(1, 'admin@gmail.com', '$argon2id$v=19$m=65536,t=4,p=1$RXNUbEtQWEcueDBDZlRsVg$7lPv8IbT7GxiZdwQGtKCJl/VRPjhkfxbIh+B0ie1W8Q');

-- --------------------------------------------------------

--
-- Estrutura da tabela `aluno`
--

DROP TABLE IF EXISTS `aluno`;
CREATE TABLE IF NOT EXISTS `aluno` (
  `id_aluno` int NOT NULL AUTO_INCREMENT,
  `nome_aluno` varchar(255) DEFAULT NULL,
  `matricula` char(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `senha` varchar(255) DEFAULT NULL,
  `id_curso` int DEFAULT NULL,
  PRIMARY KEY (`id_aluno`),
  KEY `fk_aluno_curso` (`id_curso`)
) ENGINE=InnoDB AUTO_INCREMENT=78 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `aluno`
--

INSERT INTO `aluno` (`id_aluno`, `nome_aluno`, `matricula`, `email`, `senha`, `id_curso`) VALUES
(75, 'Jeverson', '2022311922', 'Jever@gmail.com', '$argon2id$v=19$m=65536,t=4,p=1$Mmoud2wxZWo2U1N1RElnYw$lbvtxUE3Mj7dADdHvZOJ+0zOR5DvhJ5mC84hOEC13Tw', 9),
(76, 'Victor Yan', '2022311870', 'vic@gmail.com', '$argon2id$v=19$m=65536,t=4,p=1$Lkc0Y1EwZ0xuSnpMY1NRMg$LlLOujZbC/Y1VX/OLadtF6OskxhGSRmeIJJb21uXy9I', 9);

-- --------------------------------------------------------

--
-- Estrutura da tabela `atividade_complementar`
--

DROP TABLE IF EXISTS `atividade_complementar`;
CREATE TABLE IF NOT EXISTS `atividade_complementar` (
  `id_atividade_complementar` int NOT NULL AUTO_INCREMENT,
  `natureza` int DEFAULT NULL,
  `descricao` text,
  `carga_horaria_maxima` int DEFAULT NULL,
  `id_curso` int DEFAULT NULL,
  PRIMARY KEY (`id_atividade_complementar`),
  KEY `fk_curso_atividade_complementar` (`id_curso`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `coordenador_curso`
--

DROP TABLE IF EXISTS `coordenador_curso`;
CREATE TABLE IF NOT EXISTS `coordenador_curso` (
  `id_coordenador` int NOT NULL AUTO_INCREMENT,
  `nome_coordenador` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `senha` varchar(255) DEFAULT NULL,
  `id_curso` int DEFAULT NULL,
  PRIMARY KEY (`id_coordenador`),
  KEY `fk_curso_coordenador` (`id_curso`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `coordenador_curso`
--

INSERT INTO `coordenador_curso` (`id_coordenador`, `nome_coordenador`, `email`, `senha`, `id_curso`) VALUES
(14, 'Fabio', 'Fabio@gmail.com', '$argon2id$v=19$m=65536,t=4,p=1$aHZiSlR3Wm1aVmpYbTFnaA$yCaT8jjPWk3xfi+8sl/qBuO5U8ST20xQDBBbGFRigi4', 9);

-- --------------------------------------------------------

--
-- Estrutura da tabela `curso`
--

DROP TABLE IF EXISTS `curso`;
CREATE TABLE IF NOT EXISTS `curso` (
  `id_curso` int NOT NULL AUTO_INCREMENT,
  `nome_curso` varchar(255) NOT NULL,
  `carga_horaria` int NOT NULL,
  PRIMARY KEY (`id_curso`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `curso`
--

INSERT INTO `curso` (`id_curso`, `nome_curso`, `carga_horaria`) VALUES
(9, 'Curso Técnico Integrado em Informática', 120),
(11, 'Curso Técnico Integrado em Administração', 120),
(12, 'Curso de Manutenção e Suporte em Informática (MSI))', 120),
(13, 'Curso de Markiting Subsequente', 120);

-- --------------------------------------------------------

--
-- Estrutura da tabela `entrega_atividade`
--

DROP TABLE IF EXISTS `entrega_atividade`;
CREATE TABLE IF NOT EXISTS `entrega_atividade` (
  `id_entrega_atividade` int NOT NULL AUTO_INCREMENT,
  `natureza` int DEFAULT NULL,
  `titulo_certificado` varchar(255) DEFAULT NULL,
  `carga_horaria_certificado` int DEFAULT NULL,
  `certificado` varchar(255) DEFAULT NULL,
  `carga_horaria_aprovada` int DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `id_aluno` int DEFAULT NULL,
  `caminho` varchar(255) NOT NULL,
  PRIMARY KEY (`id_entrega_atividade`),
  KEY `fk_aluno_entrega_atividade` (`id_aluno`)
) ENGINE=InnoDB AUTO_INCREMENT=77 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `entrega_atividade`
--

INSERT INTO `entrega_atividade` (`id_entrega_atividade`, `natureza`, `titulo_certificado`, `carga_horaria_certificado`, `certificado`, `carga_horaria_aprovada`, `status`, `id_aluno`, `caminho`) VALUES
(71, 1, '21', 121, 'UseCase Diagram1.png', 0, 'Em análise', 75, '66966fa990f9b.png'),
(73, 1, '112321', 21, 'exercicios_reviso.pdf', 0, 'Em análise', 75, '66994705e8b8a.pdf'),
(74, 1, '21', 21, 'exercicios_reviso.pdf', 0, 'Em análise', 75, '66994972572e7.pdf'),
(75, 0, '33344445', 1, 'horas complementares tcc.pdf', 0, 'Em análise', 75, '66994a02e6c05.pdf'),
(76, 1, '3', 1111111, '2911-7183-1-PB.pdf', 0, 'Em análise', 75, '66994a320ab5f.pdf');

-- --------------------------------------------------------

--
-- Estrutura da tabela `recuperar_senha`
--

DROP TABLE IF EXISTS `recuperar_senha`;
CREATE TABLE IF NOT EXISTS `recuperar_senha` (
  `email` varchar(255) DEFAULT NULL,
  `data_recuperacao` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `aluno`
--
ALTER TABLE `aluno`
  ADD CONSTRAINT `fk_aluno_curso` FOREIGN KEY (`id_curso`) REFERENCES `curso` (`id_curso`);

--
-- Limitadores para a tabela `atividade_complementar`
--
ALTER TABLE `atividade_complementar`
  ADD CONSTRAINT `fk_curso_atividade_complementar` FOREIGN KEY (`id_curso`) REFERENCES `curso` (`id_curso`);

--
-- Limitadores para a tabela `coordenador_curso`
--
ALTER TABLE `coordenador_curso`
  ADD CONSTRAINT `fk_curso_coordenador` FOREIGN KEY (`id_curso`) REFERENCES `curso` (`id_curso`);

--
-- Limitadores para a tabela `entrega_atividade`
--
ALTER TABLE `entrega_atividade`
  ADD CONSTRAINT `fk_aluno_entrega_atividade` FOREIGN KEY (`id_aluno`) REFERENCES `aluno` (`id_aluno`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;