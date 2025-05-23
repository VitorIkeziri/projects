-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 13-Nov-2024 às 22:30
-- Versão do servidor: 8.0.32
-- versão do PHP: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `logs`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `log$pedido`
--

DROP TABLE IF EXISTS `log$pedido`;
CREATE TABLE IF NOT EXISTS `log$pedido` (
  `ID` int NOT NULL,
  `acao` int NOT NULL,
  `usuario` text NOT NULL,
  `nrcupom` int NOT NULL,
  `data_hora_cadastro` datetime NOT NULL,
  `data_hora_altera` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `log$venda`
--

DROP TABLE IF EXISTS `log$venda`;
CREATE TABLE IF NOT EXISTS `log$venda` (
  `ID` int NOT NULL,
  `acao` int NOT NULL,
  `usuario` text NOT NULL,
  `nrcupom` int NOT NULL,
  `data_hora_cadastro` datetime NOT NULL,
  `data_hora_altera` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
