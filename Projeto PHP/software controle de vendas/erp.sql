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
-- Database: `erp`
--

-- --------------------------------------------------------

--
-- Table structure for table `cliente`
--

DROP TABLE IF EXISTS `cliente`;
CREATE TABLE IF NOT EXISTS `cliente` (
  `Id_cliente` int NOT NULL AUTO_INCREMENT,
  `CPF` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `CEP` varchar(9) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `Nome` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `Endereco` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `Telefone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `data_cadastro` datetime NOT NULL,
  `Residencia` varchar(12) NOT NULL,
  `obs` text,
  PRIMARY KEY (`Id_cliente`)
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `cliente`
--

INSERT INTO `cliente` (`Id_cliente`, `CPF`, `CEP`, `Nome`, `Endereco`, `Telefone`, `data_cadastro`, `Residencia`, `obs`) VALUES
(25, '371.054.318-57', '17055-390', 'Vitor Barufaldi Ikezire', 'Rua Doutor Jo&amp;amp;amp;amp;amp;atilde;o G&amp;amp;amp;amp;amp;oacute;es Manso Say&amp;amp;amp;amp;amp;atilde;o Netto', '(14)93283-7522', '2023-07-02 14:05:14', '635', ''),
(28, '123.456.789-00', '', 'João Silva', 'Rua dos Exemplos, 123', '9999-9999', '2023-07-12 18:45:26', '101', NULL),
(29, '987.654.321-00', '', 'Maria Souza', 'Avenida das Amostras, 456', '8888-8888', '2023-07-12 18:45:26', '202', NULL),
(30, '654.321.987-00', '', 'Pedro Santos', 'Travessa das Ilustrações, 789', '7777-7777', '2023-07-12 18:45:26', '303', NULL),
(31, '112.233.445-56', '', 'Ana Pereira', 'Rua dos Modelos, 789', '6666-6666', '2023-07-12 18:45:26', '404', NULL),
(32, '998.877.665-50', '', 'Lucas Ferreira', 'Alameda dos Testes, 321', '5555-5555', '2023-07-12 18:45:26', '505', NULL),
(33, '123.456.789-00', '', 'João Silva', 'Rua dos Exemplos, 123', '9999-9999', '2023-07-12 18:46:40', '101', NULL),
(34, '987.654.321-00', '', 'Maria Souza', 'Avenida das Amostras, 456', '8888-8888', '2023-07-12 18:46:40', '202', NULL),
(35, '654.321.987-00', '', 'Pedro Santos', 'Travessa das Ilustrações, 789', '7777-7777', '2023-07-12 18:46:40', '303', NULL),
(36, '112.233.445-56', '', 'Ana Pereira', 'Rua dos Modelos, 789', '6666-6666', '2023-07-12 18:46:40', '404', NULL),
(37, '998.877.665-50', '', 'Lucas Ferreira', 'Alameda dos Testes, 321', '5555-5555', '2023-07-12 18:46:40', '505', NULL),
(38, '111.222.333-44', '', 'Mariana Oliveira', 'Avenida dos Exemplos, 567', '4444-4444', '2023-07-12 18:46:40', '606', NULL),
(39, '555.666.777-88', '', 'Gabriel Mendes', 'Rua das Ilustrações, 890', '3333-3333', '2023-07-12 18:46:40', '707', NULL),
(40, '999.888.777-66', '', 'Carolina Silva', 'Travessa das Amostras, 123', '2222-2222', '2023-07-12 18:46:40', '808', NULL),
(41, '777.888.999-00', '', 'Rafaela Costa', 'Avenida dos Modelos, 456', '1111-1111', '2023-07-12 18:46:40', '909', NULL),
(42, '444.555.666-77', '', 'Gustavo Santos', 'Rua das Testes, 789', '0000-0000', '2023-07-12 18:46:40', '1010', NULL),
(43, '222.333.444-55', '', 'Fernanda Souza', 'Travessa dos Exemplos, 321', '9999-9999', '2023-07-12 18:46:40', '111', NULL),
(44, '888.999.000-11', '', 'Pedroso Silva', 'Avenida das Ilustrações, 654', '8888-8888', '2023-07-12 18:46:40', '222', NULL),
(45, '777.666.555-44', '', 'Camila Pereira', 'Rua dos Amostras, 987', '7777-7777', '2023-07-12 18:46:40', '333', NULL),
(46, '555.444.333-22', '', 'Paulo Costa', 'Travessa dos Modelos, 654', '6666-6666', '2023-07-12 18:46:40', '444', NULL),
(47, '333.222.111-00', '', 'Isabela Mendes', 'Avenida das Testes, 321', '5555-5555', '2023-07-12 18:46:40', '555', NULL),
(48, '999.888.777-66', '', 'Marcelo Santos', 'Rua dos Exemplos, 789', '4444-4444', '2023-07-12 18:46:40', '666', NULL),
(49, '777.666.555-44', '', 'Carla Oliveira', 'Travessa das Ilustrações, 123', '3333-3333', '2023-07-12 18:46:40', '777', NULL),
(50, '555.444.333-22', '', 'Márcio Ferreira', 'Avenida das Amostras, 456', '2222-2222', '2023-07-12 18:46:40', '888', NULL),
(51, '333.222.111-00', '', 'Vanessa Costa', 'Rua dos Modelos, 789', '1111-1111', '2023-07-12 18:46:40', '999', NULL),
(52, '111.222.333-44', '', 'Júlia Silva', 'Travessa dos Testes, 321', '0000-0000', '2023-07-12 18:46:40', '1010', NULL),
(54, '371.054.318-56', '', 'Teste da sandro', 'Rua qualquer', '(14)93283-7522', '2024-08-16 20:05:47', '16', 'bbbb');

-- --------------------------------------------------------

--
-- Table structure for table `cupom`
--

DROP TABLE IF EXISTS `cupom`;
CREATE TABLE IF NOT EXISTS `cupom` (
  `nrloja` int NOT NULL,
  `cupom` int NOT NULL,
  `data_venda` datetime NOT NULL,
  `valor_total` decimal(10,2) NOT NULL,
  `valor_troco` float(10,2) NOT NULL,
  `nr_itens` int NOT NULL,
  `cpf_cliente` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `entrega` int NOT NULL,
  PRIMARY KEY (`cupom`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `cupom`
--

INSERT INTO `cupom` (`nrloja`, `cupom`, `data_venda`, `valor_total`, `valor_troco`, `nr_itens`, `cpf_cliente`, `entrega`) VALUES
(1, 1, '2024-10-24 11:19:01', '209.00', 21.00, 1, '', 0),
(1, 2, '2024-10-24 11:22:17', '212.00', 88.00, 1, '', 0),
(1, 3, '2024-10-24 11:26:47', '212.00', 18.00, 1, '371.054.318-57', 0),
(1, 4, '2024-10-24 11:28:35', '209.00', 11.00, 1, '371.054.318-57', 0),
(1, 5, '2024-10-24 11:30:06', '209.00', 101.00, 1, '', 0),
(1, 6, '2024-10-24 11:31:36', '209.00', 41.00, 1, '', 0),
(1, 7, '2024-10-24 11:32:47', '212.00', 108.00, 1, '', 0),
(1, 8, '2024-10-24 11:38:01', '209.00', 101.00, 1, '', 0),
(1, 9, '2024-10-24 11:39:21', '209.00', 11.00, 1, '', 0),
(1, 10, '2024-10-24 11:39:42', '209.00', 11.00, 1, '', 0),
(1, 11, '2024-10-24 11:42:23', '209.00', 41.00, 1, '', 0),
(1, 12, '2024-10-24 11:43:04', '213.00', 187.00, 1, '371.054.318-57', 0),
(1, 13, '2024-10-24 11:44:13', '209.00', 41.00, 1, '', 0),
(1, 14, '2024-10-24 11:45:30', '213.00', 27.00, 1, '', 0),
(1, 15, '2024-10-24 11:46:09', '212.00', 28.00, 1, '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `estoque`
--

DROP TABLE IF EXISTS `estoque`;
CREATE TABLE IF NOT EXISTS `estoque` (
  `nrloja` int NOT NULL,
  `Produto_id` int NOT NULL,
  `quantidade` int NOT NULL,
  `dth_inseri` datetime DEFAULT NULL,
  `dth_autaliza` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `formapagto`
--

DROP TABLE IF EXISTS `formapagto`;
CREATE TABLE IF NOT EXISTS `formapagto` (
  `nrloja` int NOT NULL,
  `cupom` int NOT NULL,
  `Forma_Pagamento` int NOT NULL,
  `data_venda` datetime NOT NULL,
  `valor_pagamento` decimal(10,2) NOT NULL,
  `valor_troco` decimal(10,2) NOT NULL,
  `cpf_cliente` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  PRIMARY KEY (`cupom`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `formapagto`
--

INSERT INTO `formapagto` (`nrloja`, `cupom`, `Forma_Pagamento`, `data_venda`, `valor_pagamento`, `valor_troco`, `cpf_cliente`) VALUES
(1, 1, 1, '2024-10-24 11:19:01', '209.00', '21.00', ''),
(1, 2, 4, '2024-10-24 11:22:17', '212.00', '88.00', ''),
(1, 3, 1, '2024-10-24 11:26:47', '212.00', '18.00', '371.054.318-57'),
(1, 4, 1, '2024-10-24 11:28:35', '209.00', '11.00', '371.054.318-57');

-- --------------------------------------------------------

--
-- Table structure for table `itens`
--

DROP TABLE IF EXISTS `itens`;
CREATE TABLE IF NOT EXISTS `itens` (
  `nrloja` int NOT NULL,
  `cupom` int NOT NULL,
  `Produto_id` int NOT NULL,
  `data_venda` datetime NOT NULL,
  `valor_produto` float NOT NULL,
  `quantidade` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pedido`
--

DROP TABLE IF EXISTS `pedido`;
CREATE TABLE IF NOT EXISTS `pedido` (
  `nrcomanda` int NOT NULL AUTO_INCREMENT,
  `nrloja` int NOT NULL,
  `cupom` int NOT NULL,
  `CPF` varchar(14) NOT NULL,
  `CEP` varchar(9) DEFAULT NULL,
  `produto_id` int NOT NULL,
  `data_pedido` date NOT NULL,
  `quantidade` int NOT NULL,
  `valor_unitario` decimal(10,2) NOT NULL,
  `valor_total` decimal(10,2) GENERATED ALWAYS AS ((`quantidade` * `valor_unitario`)) STORED,
  `status` enum('pendente','enviado','entregue','cancelado','separando') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'pendente',
  `data_entrega` datetime DEFAULT NULL,
  `observacoes` text,
  `Id_cliente` int DEFAULT NULL,
  PRIMARY KEY (`nrcomanda`),
  KEY `produto_id` (`produto_id`),
  KEY `Id_cliente` (`Id_cliente`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pedido_interno`
--

DROP TABLE IF EXISTS `pedido_interno`;
CREATE TABLE IF NOT EXISTS `pedido_interno` (
  `nrloja` int NOT NULL,
  `produto_id` int NOT NULL,
  `quantidade` int NOT NULL,
  `dth_inseri` datetime NOT NULL,
  `dth_autualiza` datetime NOT NULL,
  `valor` float NOT NULL,
  `dth_entrega` datetime NOT NULL,
  `Status` enum('pendente','enviado','entregue','cancelado','separado') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `venda`
--

DROP TABLE IF EXISTS `venda`;
CREATE TABLE IF NOT EXISTS `venda` (
  `nrloja` int NOT NULL,
  `cupom` int NOT NULL,
  `ID_Venda` int NOT NULL AUTO_INCREMENT,
  `CPF` varchar(14) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `CEP` varchar(9) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `Produto_id` int DEFAULT NULL,
  `Forma_Pagamento` int NOT NULL,
  `valor_total` float NOT NULL,
  `valor_troco` float DEFAULT NULL,
  `quantidade` int NOT NULL,
  `data_venda` datetime DEFAULT NULL,
  `datainseri` datetime DEFAULT NULL,
  `entrega` int DEFAULT NULL,
  `observacoes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  PRIMARY KEY (`ID_Venda`),
  UNIQUE KEY `cupom` (`cupom`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `venda`
--

INSERT INTO `venda` (`nrloja`, `cupom`, `ID_Venda`, `CPF`, `CEP`, `Produto_id`, `Forma_Pagamento`, `valor_total`, `valor_troco`, `quantidade`, `data_venda`, `datainseri`, `entrega`, `observacoes`) VALUES
(1, 1, 27, '', NULL, 2, 1, 209, 21, 1, '2024-10-24 11:19:01', '2024-10-24 11:19:01', 0, ''),
(1, 4, 28, '371.054.318-57', NULL, 1, 1, 209, 11, 1, '2024-10-24 11:28:35', '2024-10-24 11:28:35', 0, ''),
(1, 15, 29, '', NULL, 1, 1, 212, 28, 1, '2024-10-24 11:46:09', '2024-10-24 11:46:09', 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `venda_cliente`
--

DROP TABLE IF EXISTS `venda_cliente`;
CREATE TABLE IF NOT EXISTS `venda_cliente` (
  `nrloja` int NOT NULL,
  `cupom` int NOT NULL,
  `data_venda` datetime NOT NULL,
  `cpf_cliente` varchar(16) NOT NULL,
  `endereco` varchar(50) NOT NULL,
  `quantidade` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `venda_cliente`
--

INSERT INTO `venda_cliente` (`nrloja`, `cupom`, `data_venda`, `cpf_cliente`, `endereco`, `quantidade`) VALUES
(1, 1, '2024-10-24 11:19:01', '', '', 1),
(1, 2, '2024-10-24 11:22:17', '', '', 1),
(1, 3, '2024-10-24 11:26:47', '371.054.318-57', '', 1),
(1, 4, '2024-10-24 11:28:35', '371.054.318-57', '', 1);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `formapagto`
--
ALTER TABLE `formapagto`
  ADD CONSTRAINT `formapagto_ibfk_1` FOREIGN KEY (`cupom`) REFERENCES `cupom` (`cupom`);

--
-- Constraints for table `pedido`
--
ALTER TABLE `pedido`
  ADD CONSTRAINT `pedido_ibfk_1` FOREIGN KEY (`produto_id`) REFERENCES `config`.`produto` (`P_ID_Produto`) ON DELETE CASCADE,
  ADD CONSTRAINT `pedido_ibfk_2` FOREIGN KEY (`Id_cliente`) REFERENCES `cliente` (`Id_cliente`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


-- Adicionando chave estrangeira na tabela `estoque` referenciando `produto` no banco `config`
ALTER TABLE `estoque`
ADD CONSTRAINT `fk_estoque_produto`
FOREIGN KEY (`Produto_id`) REFERENCES `config`.`produto`(`P_ID_Produto`)
ON DELETE CASCADE
ON UPDATE CASCADE;

-- Adicionando chave estrangeira na tabela `pedido_interno` referenciando `produto` no banco `config`
ALTER TABLE `pedido_interno`
ADD CONSTRAINT `fk_pedido_interno_produto`
FOREIGN KEY (`produto_id`) REFERENCES `config`.`produto`(`P_ID_Produto`)
ON DELETE CASCADE
ON UPDATE CASCADE;

ALTER TABLE pedido_interno
ADD CONSTRAINT unique_pedido
UNIQUE (nrloja, produto_id, dth_inseri);

----Triger do status entregue inseri no produto 

DELIMITER //

CREATE TRIGGER troca_pedido
AFTER UPDATE ON pedido_interno
FOR EACH ROW
BEGIN
    -- Verifica se o status foi alterado para 'entregue'
    IF OLD.status <> NEW.status AND NEW.status = 'entregue' THEN
        -- Atualiza os dados na tabela produto no banco de dados config
        UPDATE config.produto
        SET 
            P_Quantidade = NEW.quantidade,
            P_Estoque = P_Estoque + NEW.quantidade,
            pid_estoque = NEW.pid_estoque
            P_valor_pagto = NEW.valor
        WHERE 
            P_ID_Produto = NEW.produto_id;
    END IF;
END;

//

DELIMITER ;