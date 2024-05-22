<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Cadastrado</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .content {
            margin-left: 250px;
            padding: 20px;
            background: white;
            min-height: 100vh;
        }

        .details {
            background: #fff;
            padding: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .cardHeader {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .cardHeader h2 {
            margin: 0;
        }

        .cardHeader button {
            padding: 10px 20px;
            background: #28a745;
            color: #fff;
            border: none;
            cursor: pointer;
            transition: background 0.3s;
        }

        .cardHeader button:hover {
            background: #218838;
        }

        /* Modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0, 0, 0);
            background-color: rgba(0, 0, 0, 0.4);
            padding-top: 60px;
        }

        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        /* Tabela */
        #product-table {
            width: 100%;
            border-collapse: collapse;
        }

        #product-table th,
        #product-table td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        #product-table th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #ef9051;
            color: white;
        }

        #product-table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        #product-table tr:hover {
            background-color: #ddd;
        }
    </style>
</head>

<body>
    <!-- Início da barra de navegação -->
    <div class="sidebar">
        <div class="logo">
            <img src="images/icons/Logo Restaurante do Brejo (sem fundo).png" alt="Logo">
        </div>
        <nav>
            <ul>
                <li><a href="paginaFuncionario.php"><img src="images/icons/do-utilizador.png" alt="Ícone Pessoa">
                        Dashboard</a></li>
                <li><a href="gerenciamentoMenu.php"><img src="images/icons/cardapio.png" alt="Ícone Menu"> Gerenciar
                        Menu</a></li>
                <li><a href="gerir_reserva/index.php"><img src="images/icons/reserva.png" alt="Ícone Reservas">
                        Gerenciar Reservas</a></li>
                <li><a href="../index.php"><img src="" alt=""> Sair</a></li>
            </ul>
        </nav>
    </div>
    <!-- Fim da barra de navegação -->

    <div class="content">
        <h1 class="titulo">• Menu Cadastrado •</h1>
        <div class="details">
            <div class="recentOrders">
                <div class="cardHeader">

                    <button onclick="document.getElementById('modalNovoProduto').style.display='block'">Cadastrar
                        Novo</button>
                </div>
                <div id="modalNovoProduto" class="modal">
                    <div class="modal-content">
                        <span class="close"
                            onclick="document.getElementById('modalNovoProduto').style.display='none'">&times;</span>
                        <h2>Cadastrar Novo Produto</h2>
                        <form method="post" action="insert_product.php" enctype="multipart/form-data">
                            <label for="nome">Nome:</label>
                            <input type="text" id="nome" name="nome" required><br>
                            <label for="preco">Preço:</label>
                            <input type="number" id="preco" name="preco" min="0" step="0.01" required><br>
                            <label for="categoria">Categoria:</label>
                            <input type="text" id="categoria" name="categoria" required><br>
                            <label for="descricao">Descrição:</label><br>
                            <textarea id="descricao" name="descricao" rows="4" required></textarea><br>
                            <label for="imagem">Imagem:</label>
                            <input type="file" id="imagem" name="imagem" accept="image/*" required><br>
                            <button type="submit">Cadastrar</button>
                        </form>
                    </div>
                </div>
                <table id="product-table">
                    <thead>
                        <tr>
                            <th>Produto</th>
                            <th>Preço</th>
                            <th>Categoria</th>
                            <th>Descrição</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php include 'get_products.php'; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

</body>

</html>