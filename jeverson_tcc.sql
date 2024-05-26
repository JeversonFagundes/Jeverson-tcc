-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 26-Maio-2024 às 19:57
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
(1, 'admin@gmail.com', 'admin123');

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
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `aluno`
--

INSERT INTO `aluno` (`id_aluno`, `nome_aluno`, `matricula`, `email`, `senha`, `id_curso`) VALUES
(22, 'Jeverson Miguel Rios Fagundes', '2022412434', 'Jever@gmail.com', 'Kratos123', 4),
(23, 'Lauro', '2222222222', 'Lau@gmail.com', 'dede', 8),
(24, 'Wagner', '2022312289', 'wag@gmail.com', '123456', 4),
(25, 'Victor Yan', '2022311870', 'victor.2022311870@aluno.iffar.edu.br', 'magnata123', 8);

-- --------------------------------------------------------

--
-- Estrutura da tabela `atividade_complementar`
--

DROP TABLE IF EXISTS `atividade_complementar`;
CREATE TABLE IF NOT EXISTS `atividade_complementar` (
  `id_atividade_complementar` int NOT NULL AUTO_INCREMENT,
  `natureza` char(2) DEFAULT NULL,
  `descricao` text,
  `carga_horaria_maxima` int DEFAULT NULL,
  `id_curso` int DEFAULT NULL,
  PRIMARY KEY (`id_atividade_complementar`),
  KEY `fk_curso_atividade_complementar` (`id_curso`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `atividade_complementar`
--

INSERT INTO `atividade_complementar` (`id_atividade_complementar`, `natureza`, `descricao`, `carga_horaria_maxima`, `id_curso`) VALUES
(2, '1', 'Cursos relacionados a área de informática.', 40, 4),
(3, '2', 'Curso de literatura portuguesa.', 30, 4),
(4, '3', 'Participação em palestras.', 40, 4),
(5, '1', 'rrrrrrrererrr', 40, 8);

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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `coordenador_curso`
--

INSERT INTO `coordenador_curso` (`id_coordenador`, `nome_coordenador`, `email`, `senha`, `id_curso`) VALUES
(6, 'Fabio', 'Fabio@gmail.com', 'Fab', 4),
(7, 'Lauro', 'Lau@gmail.com', 'Lau123', 8),
(8, 'Victor Yan', 'v@gmail.com', '1234', 4);

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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `curso`
--

INSERT INTO `curso` (`id_curso`, `nome_curso`, `carga_horaria`) VALUES
(4, 'Informática', 50),
(8, 'Bootstrap', 30);

-- --------------------------------------------------------

--
-- Estrutura da tabela `entrega_atividade`
--

DROP TABLE IF EXISTS `entrega_atividade`;
CREATE TABLE IF NOT EXISTS `entrega_atividade` (
  `id_entrega_atividade` int NOT NULL AUTO_INCREMENT,
  `natureza` char(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `titulo_certificado` varchar(255) DEFAULT NULL,
  `carga_horaria_certificado` int DEFAULT NULL,
  `certificado` varchar(255) DEFAULT NULL,
  `carga_horaria_aprovada` int DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `id_aluno` int DEFAULT NULL,
  `caminho` varchar(255) NOT NULL,
  PRIMARY KEY (`id_entrega_atividade`),
  KEY `fk_aluno_entrega_atividade` (`id_aluno`)
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `entrega_atividade`
--

INSERT INTO `entrega_atividade` (`id_entrega_atividade`, `natureza`, `titulo_certificado`, `carga_horaria_certificado`, `certificado`, `carga_horaria_aprovada`, `status`, `id_aluno`, `caminho`) VALUES
(38, '1', 'Não sei', 20, 'DADOS.jpg', 0, 'Em análise', 25, '../certificados/66493bb2adaad.jpg'),
(44, 'Participação em palestras.', 'Neabi', 12, 'neabi.jpg', 0, 'Em análise', 24, '../certificados/6650e7b4edf22.jpg'),
(45, 'Cursos relacionados a área de informática.', 'Modelagem de dados', 21, 'MODELAGEM DE DADOS DE BANCO DE DADOS.pdf', 0, 'Em análise', 22, '../certificados/6650f07355738.pdf'),
(46, 'Participação em palestras.', 'Neabi', 4, 'neabi.jpg', 0, 'Em análise', 22, '../certificados/6650f449ddd86.jpg'),
(47, 'Cursos relacionados a área de informática.', 'Modelagem de dados', 50, 'matbásica.jpg', 0, 'Em análise', 22, '../certificados/6650fbb6cf20d.jpg');

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