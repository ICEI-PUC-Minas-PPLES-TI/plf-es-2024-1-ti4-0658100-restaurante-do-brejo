-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 22/05/2024 às 19:00
-- Versão do servidor: 8.2.0
-- Versão do PHP: 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `prestaurante`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `avaliacao_rest`
--

DROP TABLE IF EXISTS `avaliacao_rest`;
CREATE TABLE IF NOT EXISTS `avaliacao_rest` (
  `id_avaliacaorest` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `comentario` text NOT NULL,
  `nota` int NOT NULL,
  PRIMARY KEY (`id_avaliacaorest`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `avaliacao_rest`
--

INSERT INTO `avaliacao_rest` (`id_avaliacaorest`, `nome`, `comentario`, `nota`) VALUES
(1, 'Maria Silva', 'Excelente restaurante, comida deliciosa e atendimento amigável.', 5),
(2, 'João Souza', 'Boa experiência, porém o tempo de espera foi um pouco longo.', 3),
(3, 'Ana Costa', 'Ambiente agradável e pratos bem servidos. Recomendo!', 4),
(4, 'Pedro Martins', 'Não fiquei satisfeito com o serviço. Precisam melhorar.', 2),
(5, 'Luciana Queiroz', 'Incrível! Melhor experiência gastronômica que já tive.', 5);

-- --------------------------------------------------------

--
-- Estrutura para tabela `avaliacoes_pedidos`
--

DROP TABLE IF EXISTS `avaliacoes_pedidos`;
CREATE TABLE IF NOT EXISTS `avaliacoes_pedidos` (
  `id_avaliacaopedido` int NOT NULL AUTO_INCREMENT,
  `id_pedido` int NOT NULL,
  `id_cliente` int NOT NULL,
  `comentario` text NOT NULL,
  `nota` int NOT NULL,
  PRIMARY KEY (`id_avaliacaopedido`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `carrinho`
--

DROP TABLE IF EXISTS `carrinho`;
CREATE TABLE IF NOT EXISTS `carrinho` (
  `id_carrinho` int NOT NULL AUTO_INCREMENT,
  `id_usuario` int NOT NULL,
  `id_produto` int NOT NULL,
  `quantidade` int NOT NULL,
  `data_hora` timestamp NOT NULL,
  PRIMARY KEY (`id_carrinho`)
) ENGINE=MyISAM AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `pedidos`
--

DROP TABLE IF EXISTS `pedidos`;
CREATE TABLE IF NOT EXISTS `pedidos` (
  `id_pedido` int NOT NULL AUTO_INCREMENT,
  `id_cliente` int NOT NULL,
  `total` decimal(10,0) NOT NULL,
  `status_pedido` varchar(255) NOT NULL,
  `data` datetime NOT NULL,
  `endereco` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`id_pedido`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `pedidos`
--

INSERT INTO `pedidos` (`id_pedido`, `id_cliente`, `total`, `status_pedido`, `data`, `endereco`) VALUES
(1, 1, 121, 'Aceito', '2023-04-20 00:00:00', 'Rua das Flores, 123, São Paulo'),
(2, 1, 56, 'Aceito', '2023-04-21 00:00:00', 'Avenida Central, 456, Rio de Janeiro'),
(3, 1, 75, 'Aceito', '2023-04-22 00:00:00', 'Praça da Sé, 789, Salvador'),
(4, 1, 180, 'Aceito', '2023-04-23 00:00:00', 'Rua XV de Novembro, 234, Curitiba'),
(5, 2, 91, 'Cancelado', '2023-04-24 00:00:00', 'Rua dos Bobos, 0, Porto Alegre'),
(6, 2, 136, 'Cancelado', '2023-04-25 00:00:00', 'Avenida Paulista, 999, São Paulo'),
(7, 3, 210, 'Aceito', '2023-04-26 00:00:00', 'Setor Marista, 888, Goiânia'),
(8, 3, 50, 'Aceito', '2023-04-27 00:00:00', 'Rua Major Gote, 777, Patos de Minas'),
(9, 3, 115, 'Aceito', '2023-04-28 00:00:00', 'Beco Diagonal, 666, Londres'),
(10, 3, 100, 'Cancelado', '2023-04-29 00:00:00', 'Vila dos Atletas, 123, Rio de Janeiro');

-- --------------------------------------------------------

--
-- Estrutura para tabela `pedido_produtos`
--

DROP TABLE IF EXISTS `pedido_produtos`;
CREATE TABLE IF NOT EXISTS `pedido_produtos` (
  `id_pedido_produtos` int NOT NULL AUTO_INCREMENT,
  `id_pedido` int DEFAULT NULL,
  `id_produto` int DEFAULT NULL,
  PRIMARY KEY (`id_pedido_produtos`),
  KEY `id_pedido` (`id_pedido`),
  KEY `id_produto` (`id_produto`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `pedido_produtos`
--

INSERT INTO `pedido_produtos` (`id_pedido_produtos`, `id_pedido`, `id_produto`) VALUES
(7, 4, 5),
(6, 4, 4),
(5, 4, 1),
(4, 3, 2),
(3, 2, 5),
(2, 1, 3),
(1, 1, 2),
(8, 5, 3),
(9, 6, 2),
(10, 7, 1),
(11, 11, 1),
(12, 12, 7);

-- --------------------------------------------------------

--
-- Estrutura para tabela `produtos`
--

DROP TABLE IF EXISTS `produtos`;
CREATE TABLE IF NOT EXISTS `produtos` (
  `id_produto` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `categoria` varchar(255) NOT NULL,
  `preco` int NOT NULL,
  `descricao` varchar(800) NOT NULL,
  `atividade` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `caminho_img` varchar(250) NOT NULL,
  PRIMARY KEY (`id_produto`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `produtos`
--

INSERT INTO `produtos` (`id_produto`, `nome`, `categoria`, `preco`, `descricao`, `atividade`, `caminho_img`) VALUES
(1, 'Feijoada Completa', 'Prato Principal', 26, 'Feijoada tradicional brasileira, acompanhada de arroz, farofa, couve e laranja.', 'Ativo', 'images/produtos/feijoada.jpg'),
(2, 'Salada Caesar', 'Entrada', 19, 'Salada Caesar com alface romana, croutons, queijo parmesão e molho especial.', 'Ativo', 'images/produtos/saladacaesar.jpg'),
(3, 'Pizza Margherita', 'Pizza', 30, 'Pizza clássica com molho de tomate, muçarela, manjericão fresco e azeite de oliva.', 'Ativo', 'images/produtos/pizzamargherita.png'),
(4, 'Bacalhau à Brás', 'Prato Principal', 46, 'Bacalhau desfiado, preparado com batatas, ovos e cebolas, decorado com azeitonas.', 'Ativo', 'images/produtos/bacalhauabras.jpg'),
(5, 'Hambúrguer Gourmet', 'Sanduíche', 23, 'Hambúrguer de carne bovina, queijo cheddar, cebola caramelizada, molho especial, alface e tomate.', 'Ativo', 'images/produtos/hamburguer.jpg'),
(6, 'Risoto de Camarão', 'Prato Principal', 60, 'Risoto de camarão com ervas finas e um toque de limão siciliano.', 'Ativo', 'images/produtos/risotocamarao.png'),
(7, 'Sushi Variado', 'Japonês', 70, 'Seleção de sushi com os melhores peixes do dia, incluindo salmão, atum e peixe branco.', 'Ativo', 'images/produtos/sushi.png'),
(8, 'Tiramisu', 'pf', 15, 'Sobremesa italiana feita com camadas de biscoito, café, mascarpone e cacau em pó.', 'Ativo', 'images/produtos/tiramisu.png'),
(9, 'Lasanha à Bolonhesa', 'pf', 28, 'Lasanha à bolonhesa, com camadas de molho de carne, massa, queijo e bechamel.', 'Ativo', 'images/produtos/lasanha.png'),
(10, 'Coxinha de Frango', 'pf', 7, 'Coxinha de massa crocante recheada com frango desfiado e temperado.', 'Ativo', 'images/produtos/coxinha.png');

-- --------------------------------------------------------

--
-- Estrutura para tabela `reservas`
--

DROP TABLE IF EXISTS `reservas`;
CREATE TABLE IF NOT EXISTS `reservas` (
  `id_reserva` int NOT NULL AUTO_INCREMENT,
  `id_cliente` int NOT NULL,
  `data` date NOT NULL,
  `hora` time NOT NULL,
  `capacidade_mesa` int NOT NULL,
  `status` text NOT NULL,
  PRIMARY KEY (`id_reserva`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `endereco` varchar(250) NOT NULL,
  `email` varchar(255) NOT NULL,
  `celular` int NOT NULL,
  `senha` char(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `papel` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `endereco`, `email`, `celular`, `senha`, `papel`) VALUES
(1, 'Usuario1', 'Endereco1', 'usuario1@example.com', 2147483647, '$2y$10$qZ7BTzrBV20jUTtRHsDL6uJ0Zk5J.Y0zpeADeS1loxGDM/VPaJQ6e', 'usuario'),
(2, 'Usuario2', 'Endereco2', 'usuario2@example.com', 2147483647, '$2y$10$BlDyw5H3wXsjHWeQkDz2juJiVSJSI94DmawtkUZKXlv6zbje1hA/q', 'usuario'),
(3, 'Usuario3', 'Endereco3', 'usuario3@example.com', 2147483647, '$2y$10$vIj64kGCmI754boG7KDxReN3iIcGNOc1aTQTR5giaWSGl5IhnqZJa', 'usuario'),
(4, 'Usuario4', 'Endereco4', 'usuario4@example.com', 2147483647, '$2y$10$HSnY43UFdjm1boXZtuexSeOiZUC7eronWhjTxoAUffnUJDHb5TwSO', 'funcionario'),
(5, 'Usuario5', 'Endereco5', 'usuario5@example.com', 2147483647, '$2y$10$k3AhRuK.69FwdDQGR1TkcOYX8zosgVUZGhx3GXVktIVPgBSnS.M12', 'funcionario'),
(6, 'Usuario6', 'Endereco6', 'usuario6@example.com', 2147483647, '$2y$10$p5sRPg4eTSfn6B2mfSv6Cu1a.sn5QbcuZsSnM.4b6Xfa4Nmi8ydNa', 'funcionario'),
(7, 'Usuario7', 'Endereco7', 'usuario7@example.com', 2147483647, '$2y$10$ZeLeeP0EtKrQkeDUMUkRBOifyZ/D.rtk8kW5M1/xpt35B7IQf/hWO', 'adm'),
(8, 'Usuario8', 'Endereco8', 'usuario8@example.com', 2147483647, '$2y$10$QwPh3ytwQrg4NbCg.noFQuOrjT34GQPPv6wgaPjs3vuDSFP/BPoR2', 'usuario'),
(9, 'Usuario9', 'Endereco9', 'usuario9@example.com', 2147483647, '$2y$10$y4wqmVRSHMJkjfrRfeW8cexR67qlx/0JzDFwiPsNK/497f8LfkUD6', 'usuario'),
(10, 'Usuario10', 'Endereco10', 'usuario10@example.com', 2147483647, '$2y$10$11Fyk/R07f1dGSwAEAVL6eGW0NzXa1rZCyEowNTRIeHBguK5YLRse', 'usuario');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
