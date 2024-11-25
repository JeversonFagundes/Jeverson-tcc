-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 25-Nov-2024 às 02:22
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
(1, 'pablo@yopmail.com', '$argon2id$v=19$m=65536,t=4,p=1$Um1QTGlQVW9wUkozaHhWSg$ytjOww8P9v/u6loF4OA6rcTYW94fXd97dEfe4X1N10E');

-- --------------------------------------------------------

--
-- Estrutura da tabela `aluno`
--

DROP TABLE IF EXISTS `aluno`;
CREATE TABLE IF NOT EXISTS `aluno` (
  `id_aluno` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `matricula` char(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `senha` varchar(255) DEFAULT NULL,
  `total_horas` int NOT NULL,
  `id_curso` int DEFAULT NULL,
  PRIMARY KEY (`id_aluno`),
  KEY `fk_aluno_curso` (`id_curso`)
) ENGINE=InnoDB AUTO_INCREMENT=94 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `aluno`
--

INSERT INTO `aluno` (`id_aluno`, `nome`, `matricula`, `email`, `senha`, `total_horas`, `id_curso`) VALUES
(88, 'Jeverson Miguel Rios Fagundes', '2022311922', 'jeverson.2022311922@aluno.iffar.edu.br', '$argon2id$v=19$m=65536,t=4,p=1$Um1QTGlQVW9wUkozaHhWSg$ytjOww8P9v/u6loF4OA6rcTYW94fXd97dEfe4X1N10E', 0, 9),
(89, 'Victor Yan', '2022311870', 'victor@yopmail.com', '$argon2id$v=19$m=65536,t=4,p=1$Um1QTGlQVW9wUkozaHhWSg$ytjOww8P9v/u6loF4OA6rcTYW94fXd97dEfe4X1N10E', 0, 12),
(92, 'Luiz Guilherme', '1111111111', 'luiz@yopmail.com', '$argon2id$v=19$m=65536,t=4,p=1$Um1QTGlQVW9wUkozaHhWSg$ytjOww8P9v/u6loF4OA6rcTYW94fXd97dEfe4X1N10E', 0, 11),
(93, 'Roberto Graziadei', '0000000000', 'roberto@yopmail.com', '$argon2id$v=19$m=65536,t=4,p=1$Um1QTGlQVW9wUkozaHhWSg$ytjOww8P9v/u6loF4OA6rcTYW94fXd97dEfe4X1N10E', 0, 13);

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
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `atividade_complementar`
--

INSERT INTO `atividade_complementar` (`id_atividade_complementar`, `natureza`, `descricao`, `carga_horaria_maxima`, `id_curso`) VALUES
(1, 1, 'Participação em eventos como palestras, seminários, congressos, fóruns relacionados à área de estudo: aproveitamento de 50% da carga horária dos certificados.', 20, 9),
(2, 2, 'Participação em cursos de extensão.', 15, 9),
(3, 3, 'Monitoria.', 15, 9),
(4, 4, 'Participação em projetos de ensino, pesquisa (iniciação científica) e/ou extensão vinculados ao Instituto Federal Farroupilha ou entidades parceiras.', 15, 9),
(5, 5, 'Participação em organização de eventos.', 15, 9),
(6, 6, 'Participação em serviço voluntário relacionado com a área do curso.', 20, 9),
(7, 7, 'Estágio curricular supervisionado não obrigatório.', 20, 9),
(8, 8, 'Visitas técnicas e viagens de estudo (não previstas na carga horária de disciplina \r\ndo curso).', 15, 9),
(9, 9, 'Publicação de resumo em anais de congressos, seminários, Iniciação Científica ou Mostra Científica: aproveitamento de 10 horas por publicação.', 20, 9),
(10, 10, 'Publicação em Revista Científica: aproveitamento de 15 horas por publicação.', 30, 9),
(11, 11, 'Remiação de trabalhos: 10 horas por premiação.', 20, 9),
(12, 12, 'Cursos de Línguas.', 20, 9),
(13, 13, 'Curso relacionado à área da Informática.', 30, 9),
(14, 14, 'Curso de Libras.', 15, 9),
(15, 15, 'Outras atividades avaliadas pelo Colegiado do Curso.', 15, 9),
(16, 1, 'Participação em eventos como palestras, seminários, congressos, fóruns relacionados com a área de estudo.', 41, 11),
(17, 2, 'Participação em cursos de extensão.', 41, 11),
(18, 3, 'Apresentação de trabalho em Mostra Técnica: aproveitamento de 10h por trabalho.', 7, 11),
(19, 4, 'Participação em programas de iniciação científica.', 41, 11),
(20, 5, 'Monitoria.', 41, 11),
(21, 6, 'Participação em projetos de ensino, pesquisa e/ou extensão vinculados ao Instituto Federal Farroupilha ou entidades parceiras.', 41, 11),
(22, 7, 'Participação em serviço voluntário relacionado com a área do curso.', 14, 11),
(23, 8, 'Estágio Curricular supervisionado não obrigatório na área do curso.', 41, 11),
(24, 9, 'Visitas Técnicas e viagens de estudos (não previstas na carga horária de disciplina do curso).', 20, 11),
(25, 10, 'Publicação de resumo em anais de congressos, seminários, Iniciação Científica ou Revista.', 7, 11),
(26, 11, 'Premiação de Trabalhos.Podem ser entregue o certificado contendo as horas ou apresentado a premiação.', 14, 11),
(27, 12, 'Cursos de Línguas.', 27, 11),
(28, 13, 'Curso relacionado à área administrativa.', 20, 11),
(29, 1, 'Participação como bolsista ou colaborador em projetos de ensino, pesquisa e extensão, e em programas de iniciação científica. Comprovante \"Documento emitido pelo órgão responsável.\"', 30, 12),
(30, 2, 'Participação como ouvinte em palestra, seminário, simpósio, congresso, conferência, jornadas e outros eventos de natureza técnica e científica relacionadas à área de formação. Comprovante \"Documento emitido pelo órgão responsável.\"', 20, 12),
(31, 3, 'Participação como colaborador na organização de palestras, painéis, seminários, simpósios, congressos, conferências, jornadas e outros eventos de natureza técnica e científica relacionadas à área de formação. Comprovante \"Documento emitido pelo órgão responsável.\"', 25, 12),
(32, 4, 'Participação em serviço voluntário relacionado com áreas do curso. Comprovante \"Atestado de participação assinado pelo responsável.\"', 20, 12),
(33, 5, 'Estágio curricular supervisionado não obrigatório. Comprovante \"Atestado da empresa onde realizou o estágio e do professor responsável pelo acompanhamento.\"', 40, 12),
(34, 6, 'Publicação, apresentação e premiação de trabalhos. 5 horas por resumo ou apresentação, 10 horas por artigo completo, e 10 horas por premiação, com máximo de 20 horas. Comprovante \"Exemplar da publicação / premiação.\"', 20, 12),
(35, 7, 'Participação em visitas técnicas e viagens de estudo. Comprovante \"Atestado de participação assinado pelo professor responsável.\"', 20, 12),
(36, 8, 'Curso de formação na área específica.20 horas por curso, com máximo de 40 horas. Comprovante \"Documento emitido pelo órgão responsável.\"', 40, 12),
(37, 9, 'Curso de línguas. Comprovante \"Documento emitido pelo órgão responsável.\"', 25, 12),
(38, 10, 'Atividade de monitoria nas áreas do curso. Comprovante \"Atestado de participação, com avaliação do aluno, assinado pelo professor responsável.\"', 30, 12),
(39, 1, 'Participação como bolsista ou colaborador em projetos de ensino, pesquisa e extensão, e em programas de iniciação científica. Comprovante \"Documento emitido pelo órgão responsável.\"', 20, 13),
(40, 2, 'Participação como ouvinte em palestra, seminário, simpósio, congresso, conferência, jornadas e outros eventos de natureza técnica e científica relacionadas à área de formação. Comprovante \"Documento de participação emitido pelo órgão responsável.\"', 15, 13),
(41, 3, 'Participação como colaborador na organização de palestras, painéis, seminários, simpósios, congressos, conferências, jornadas e outros eventos de natureza técnica e científica relacionadas à área de formação. Comprovante \"Documento de participação emitido pelo órgão responsável.\"', 12, 13),
(42, 4, 'Participação em serviço voluntário relacionado com áreas do curso. Comprovante \"Atestado de participação assinado pelo responsável.\"', 20, 13),
(43, 5, 'Estágio curricular Supervisionado não obrigatório. 25 horas (no mínimo 1 semestre). Comprovante \"Atestado da empresa onde realizou o estágio e do professor responsável pelo acompanhamento.\"', 25, 13),
(44, 6, 'Publicação, apresentação e premiação de trabalhos. 5 horas por resumo ou apresentação, 10 horas por artigo completo, e 10 horas por premiação, no máximo de 20 horas. Comprovante \"Exemplar da publicação / premiação.\"', 20, 13),
(45, 7, 'Participação em visitas técnicas e viagens de estudo. Comprovante \"Atestado de participação assinado pelo professor responsável.\"', 10, 13),
(46, 8, 'Curso de formação na área específica. Comprovante \"Documento emitido pelo órgão responsável.\"', 15, 13),
(47, 9, 'Participação como ouvinte em seminário de apresentação de Trabalho de Conclusão de Curso ou de Apresentação de Estágio. 1 hora por apresentação, com máximo de 8 horas. Comprovante \"Documento comprovatório da Coordenação de Eixo / Curso.\"', 8, 13),
(48, 10, 'Curso de línguas. Comprovante \"Documento emitido pelo órgão responsável.\"', 20, 13),
(49, 11, 'Atividade de monitoria nas áreas do curso. Comprovante \"Atestado de participação, com avaliação do aluno, assinado pelo professor responsável.\"', 20, 13);

-- --------------------------------------------------------

--
-- Estrutura da tabela `coordenador_curso`
--

DROP TABLE IF EXISTS `coordenador_curso`;
CREATE TABLE IF NOT EXISTS `coordenador_curso` (
  `id_coordenador` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `senha` varchar(255) DEFAULT NULL,
  `id_curso` int DEFAULT NULL,
  PRIMARY KEY (`id_coordenador`),
  KEY `fk_curso_coordenador` (`id_curso`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `coordenador_curso`
--

INSERT INTO `coordenador_curso` (`id_coordenador`, `nome`, `email`, `senha`, `id_curso`) VALUES
(14, 'Michel Michelon', 'michel@yopmail.com', '$argon2id$v=19$m=65536,t=4,p=1$Um1QTGlQVW9wUkozaHhWSg$ytjOww8P9v/u6loF4OA6rcTYW94fXd97dEfe4X1N10E', 9),
(15, 'Jeremias', 'jeremias@yopmail.com', '$argon2id$v=19$m=65536,t=4,p=1$Um1QTGlQVW9wUkozaHhWSg$ytjOww8P9v/u6loF4OA6rcTYW94fXd97dEfe4X1N10E', 12),
(16, 'Jeverson', 'jeverson@yopmail.com', '$argon2id$v=19$m=65536,t=4,p=1$Um1QTGlQVW9wUkozaHhWSg$ytjOww8P9v/u6loF4OA6rcTYW94fXd97dEfe4X1N10E', 13),
(17, 'Joceanny', 'joceanny@yopmail.com', '$argon2id$v=19$m=65536,t=4,p=1$Um1QTGlQVW9wUkozaHhWSg$ytjOww8P9v/u6loF4OA6rcTYW94fXd97dEfe4X1N10E', 11);

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
(12, 'Curso de Manutenção e Suporte em Informática (MSI)', 120),
(13, 'Curso de Markiting Subsequente', 120);

-- --------------------------------------------------------

--
-- Estrutura da tabela `entrega_atividade`
--

DROP TABLE IF EXISTS `entrega_atividade`;
CREATE TABLE IF NOT EXISTS `entrega_atividade` (
  `id_entrega_atividade` int NOT NULL AUTO_INCREMENT,
  `titulo_certificado` varchar(255) DEFAULT NULL,
  `carga_horaria_certificado` int DEFAULT NULL,
  `certificado` varchar(255) DEFAULT NULL,
  `carga_horaria_aprovada` int DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `id_aluno` int DEFAULT NULL,
  `caminho` varchar(255) NOT NULL,
  `id_atividade_complementar` int NOT NULL,
  `observacoes` text NOT NULL,
  PRIMARY KEY (`id_entrega_atividade`),
  KEY `fk_aluno_entrega_atividade` (`id_aluno`),
  KEY `fk_id_atividade_complementar` (`id_atividade_complementar`)
) ENGINE=InnoDB AUTO_INCREMENT=125 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `recuperar_senha`
--

DROP TABLE IF EXISTS `recuperar_senha`;
CREATE TABLE IF NOT EXISTS `recuperar_senha` (
  `id_recuperar_senha` int NOT NULL AUTO_INCREMENT,
  `email` varchar(255) DEFAULT NULL,
  `token` char(100) DEFAULT NULL,
  `data_criacao` datetime DEFAULT NULL,
  `usado` tinyint DEFAULT NULL,
  PRIMARY KEY (`id_recuperar_senha`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
  ADD CONSTRAINT `fk_aluno_entrega_atividade` FOREIGN KEY (`id_aluno`) REFERENCES `aluno` (`id_aluno`),
  ADD CONSTRAINT `fk_id_atividade_complementar` FOREIGN KEY (`id_atividade_complementar`) REFERENCES `atividade_complementar` (`id_atividade_complementar`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
