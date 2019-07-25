-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 26-Jul-2019 às 01:00
-- Versão do servidor: 10.3.16-MariaDB
-- versão do PHP: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `ordemservico`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `log_ordem_de_servico`
--

CREATE TABLE `log_ordem_de_servico` (
  `id` int(11) NOT NULL,
  `equipamento` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `servico` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `data_realizacao` varchar(150) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `od_ordem_de_servico`
--

CREATE TABLE `od_ordem_de_servico` (
  `id` int(11) NOT NULL,
  `equipamento` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `servico` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `data_pedido` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `data_servico_update` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `data_proximo_servico` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `periodo` char(1) COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `status_proximo_servico` varchar(150) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `od_ordem_de_servico`
--
ALTER TABLE `od_ordem_de_servico`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `od_ordem_de_servico`
--
ALTER TABLE `od_ordem_de_servico`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2147483648;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
