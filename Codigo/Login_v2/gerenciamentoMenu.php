<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel de controle</title>
    <!-- ======= Styles ====== -->
    <link rel="stylesheet" href="assets2/css/style.css">
</head>

<body>
    <!-- =============== Navigation ================ -->
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
                    <a  href="gerenciamentoMenu.php">
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
                    <a href="login.php">
                        <span class="icon">
                            <ion-icon name="log-out-outline"></ion-icon>
                        </span>
                        <span class="title">Sair</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- ========================= Main ==================== -->
        <div class="main">
            <div class="topbar">
                <div class="toggle">
                    <ion-icon name="menu-outline"></ion-icon>
                </div>

               
            </div>

            <!-- ======================= Cards ================== -->
           

            <!-- ================ Order Details List ================= -->
            <div class="details">
                <div class="recentOrders">
                    <div class="cardHeader">
                        <h2>Produtos Cadastrados</h2>
                        <a href="#" class="btn" id="btnNovoProduto">Cadastrar Novo</a>
                    </div>

                    <!-- Modal para cadastrar novo produto -->
                    <div id="modalNovoProduto" class="modal">
                        <div class="modal-content">
                            <span class="close" id="closeModal">&times;</span>
                            <h2>Cadastrar Novo Produto</h2>
                            <form id="formNovoProduto">
                                <label for="nome">Nome:</label>
                                <input type="text" id="nome" name="nome" required><br>
                                <label for="preco">Preço:</label>
                                <input type="number" id="preco" name="preco" min="0" step="0.01" required><br>
                                <label for="categoria">Categoria:</label>
                                <input type="text" id="categoria" name="categoria" required><br>
                                <label for="descricao">Descrição:</label><br>
                                <textarea id="descricao" name="descricao" rows="4" required></textarea><br>
                                <button type="submit">Cadastrar</button>
                            </form>
                        </div>
                    </div>

                    <!-- Tabela de produtos -->
                    <table id="product-table">
                        <thead>
                            <tr>
                                <td>Produto</td>
                                <td>Preço</td>
                                <td>Categoria</td>
                                <td>Descrição</td>
                                <td>Status</td>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Os dados da tabela serão preenchidos dinamicamente aqui -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- =========== Scripts =========  -->
    <script src="assets2/js/main.js"></script>

    <!-- ====== ionicons ======= -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

    <script>
        // Função para popular a tabela com os dados do banco de dados
        function populateTable() {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    var product_data = JSON.parse(this.responseText);
                    var tableBody = document.querySelector('#product-table tbody');

                    // Limpar a tabela antes de adicionar os novos dados
                    tableBody.innerHTML = '';

                    // Adicionar os dados da tabela
                    product_data.forEach(function (product) {
                        var row = '<tr>';
                        row += '<td>' + product.nome + '</td>';
                        row += '<td>' + product.preco + '</td>';
                        row += '<td>' + product.categoria + '</td>';
                        row += '<td>' + product.descricao + '</td>';
                        row += '<td>' + product.atividade + '</td>';
                        row += '</tr>';
                        tableBody.innerHTML += row;
                    });
                }
            };
            xhttp.open("GET", "get_products.php", true);
            xhttp.send();
        }

        // Chamar a função para popular a tabela quando a página carregar
        window.onload = populateTable;

        // Abre o modal ao clicar no botão "Cadastrar Novo"
        document.getElementById('btnNovoProduto').addEventListener('click', function() {
            document.getElementById('modalNovoProduto').style.display = 'block';
        });

        // Fecha o modal ao clicar no botão de fechar ou fora do modal
        document.querySelectorAll('.close, #modalNovoProduto').forEach(function(element) {
            element.addEventListener('click', function(event) {
                if (event.target.id === 'closeModal' || event.target.id === 'modalNovoProduto') {
                    document.getElementById('modalNovoProduto').style.display = 'none';
                }
            });
        });

        // Evita que o clique no modal feche o mesmo
        document.querySelector('.modal-content').addEventListener('click', function(event) {
            event.stopPropagation();
        });
    </script>
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Função para enviar os dados do formulário para o servidor
        function cadastrarNovoProduto(event) {
            event.preventDefault(); // Impede o envio do formulário padrão
            
            // Recupera os dados do formulário
            var formData = new FormData(document.getElementById('formNovoProduto'));

            // Envia os dados para o servidor usando AJAX
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'insert_product.php', true);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        // Se a inserção for bem-sucedida, atualize a tabela de produtos
                        populateTable();
                        // Feche o modal
                        document.getElementById('modalNovoProduto').style.display = 'none';
                        // Limpa o formulário
                        document.getElementById('formNovoProduto').reset();
                    } else {
                        alert('Erro ao cadastrar novo produto: ' + response.error);
                    }
                } else {
                    alert('Erro ao enviar requisição para o servidor');
                }
            };
            xhr.onerror = function() {
                alert('Erro ao enviar requisição para o servidor');
            };
            xhr.send(formData);
        }

        // Adiciona o evento de submit ao formulário
        document.getElementById('formNovoProduto').addEventListener('submit', cadastrarNovoProduto);
    });
</script>


</body>

</html>