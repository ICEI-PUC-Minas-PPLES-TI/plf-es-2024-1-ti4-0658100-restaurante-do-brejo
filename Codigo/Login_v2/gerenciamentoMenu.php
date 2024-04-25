<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel de Controle - Restaurante do Brejo</title>
    <link rel="stylesheet" href="assets2/css/style.css">
</head>

<body>
    <div class="container">
        <div class="navigation">
            <ul>
                <li>
                    <a href="#">
                        <span class="icon">
                            <ion-icon name=""></ion-icon>
                        </span>
                        <span class="title">Restaurante do Brejo</span>
                    </a>
                </li>
                <li>
                    <a href="paginaFuncionario.php">
                        <span class="icon">
                            <ion-icon name="home-outline"></ion-icon>
                        </span>
                        <span class="title">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span class="icon">
                            <ion-icon name="chatbubble-outline"></ion-icon>
                        </span>
                        <span class="title">Gerenciamento do Menu</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span class="icon">
                            <ion-icon name="help-outline"></ion-icon>
                        </span>
                        <span class="title">Ajuda</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span class="icon">
                            <ion-icon name="settings-outline"></ion-icon>
                        </span>
                        <span class="title">Configurações</span>
                    </a>
                </li>
                <li>
                    <a href="../index.php">
                        <span class="icon">
                            <ion-icon name="log-out-outline"></ion-icon>
                        </span>
                        <span class="title">Sair</span>
                    </a>
                </li>
            </ul>
        </div>
        <div class="main">
            <div class="topbar">
                <div class="toggle">
                    <ion-icon name="menu-outline"></ion-icon>
                </div>
            </div>
            <div class="details">
                <div class="recentOrders">
                    <div class="cardHeader">
                        <h2>Produtos Cadastrados</h2>
                        <button onclick="document.getElementById('modalNovoProduto').style.display='block'">Cadastrar
                            Novo</button>
                    </div>
                    <div id="modalNovoProduto" class="modal">
                        <div class="modal-content">
                            <span class="close"
                                onclick="document.getElementById('modalNovoProduto').style.display='none'">&times;</span>
                            <h2>Cadastrar Novo Produto</h2>
                            <form method="post" action="insert_product.php">
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
    </div>
    <script src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>

</html>