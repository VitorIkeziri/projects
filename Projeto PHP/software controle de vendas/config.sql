-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 25, 2024 at 03:48 PM
-- Server version: 8.0.32
-- PHP Version: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `config`
--

-- --------------------------------------------------------

--
-- Table structure for table `fpagamento`
--

DROP TABLE IF EXISTS `fpagamento`;
CREATE TABLE IF NOT EXISTS `fpagamento` (
  `ID_Pagamento` int NOT NULL AUTO_INCREMENT,
  `Descricao` text NOT NULL,
  PRIMARY KEY (`ID_Pagamento`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `fpagamento`
--

INSERT INTO `fpagamento` (`ID_Pagamento`, `Descricao`) VALUES
(1, 'Cartão Debito'),
(2, 'Cartão Crédito'),
(3, 'Dinheiro'),
(4, 'Pix'),
(5, 'POS');

-- --------------------------------------------------------

--
-- Table structure for table `pf_loja`
--

DROP TABLE IF EXISTS `pf_loja`;
CREATE TABLE IF NOT EXISTS `pf_loja` (
  `nrloja` int NOT NULL,
  `CNPJ` int NOT NULL,
  `razao_social` text NOT NULL,
  `cidade` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=armscii8;

--
-- Dumping data for table `pf_loja`
--

INSERT INTO `pf_loja` (`nrloja`, `CNPJ`, `razao_social`, `cidade`) VALUES
(1, 1234567891, 'Empresa teste L.T.D.A', 'Bauru-SP'),
(2, 1231313213, 'Teste ltda 2 ', 'Bastos-SP');

-- --------------------------------------------------------

--
-- Table structure for table `produto`
--

DROP TABLE IF EXISTS `produto`;
CREATE TABLE IF NOT EXISTS `produto` (
  `P_NroLoja` int DEFAULT NULL,
  `P_ID_Produto` int NOT NULL,
  `P_Descricao` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `P_Valor` decimal(10,2) DEFAULT NULL,
  `P_Classe` int NOT NULL,
  `P_Quantidade` int NOT NULL DEFAULT '0',
  `P_FlagPeso` char(1) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `P_Dimensoes` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `P_Categoria` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `P_Fornecedor` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `P_EANVALIDO` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `P_DataCadastro` date DEFAULT NULL,
  `P_Data_Criacao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `P_Ultima_Atualizacao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `P_Codigo_Interno` int NOT NULL,
  `P_Validade` date DEFAULT NULL,
  `P_Estoque` int DEFAULT NULL,
  `P_Custo` decimal(10,3) DEFAULT NULL,
  `P_Imagem` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `P_Marca` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `P_Modelo` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `P_Fabricante` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `P_Garantia` int DEFAULT NULL,
  PRIMARY KEY (`P_ID_Produto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `produto`
--

INSERT INTO `produto` (`P_NroLoja`, `P_ID_Produto`, `P_Descricao`, `P_Valor`, `P_Classe`, `P_Quantidade`, `P_FlagPeso`, `P_Dimensoes`, `P_Categoria`, `P_Fornecedor`, `P_EANVALIDO`, `P_DataCadastro`, `P_Data_Criacao`, `P_Ultima_Atualizacao`, `P_Codigo_Interno`, `P_Validade`, `P_Estoque`, `P_Custo`, `P_Imagem`, `P_Marca`, `P_Modelo`, `P_Fabricante`, `P_Garantia`) VALUES
(1, 1, 'Gás', '104.00', 3, 0, '', '10x20x20', 'A', 'SuperGás', '999', NULL, '2024-08-26 10:21:27', '2024-09-27 21:15:32', 111, NULL, 0, '0.000', '', '', '', '', 0),
(1, 2, 'Gás Entrega - A vista', '105.00', 0, 0, NULL, NULL, NULL, NULL, '999', NULL, '2024-08-26 10:21:27', '2024-10-10 15:43:58', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(1, 3, 'GÁS Entrega - Crédito', '108.00', 0, 0, NULL, NULL, NULL, NULL, '999', NULL, '2024-08-26 10:21:27', '2024-10-10 15:43:59', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
