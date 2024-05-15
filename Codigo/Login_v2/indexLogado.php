<?php

session_start();  // Inicia a sessão

// Verifica se o usuário não está logado
if (!isset($_SESSION['id_cliente'])) {
    header('Location: login.php');  // Redireciona para a página de login
    exit();  // Encerra a execução do script
}

// Agora atribua o valor da variável $_SESSION['id_cliente'] a $id_cliente
$id_cliente = $_SESSION['id_cliente'];

// Imprime o ID do cliente para visualização
echo "ID do Cliente: " . $id_cliente;

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Histórico de compras</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <!-- Início da barra de navegação -->
    <div class="sidebar">
        <style>
            .sidebar {
                background-color: #ef9851;
                /* Cor laranja */
            }
        </style>
        <div class="logo">
            <img src="images/icons/Logo Restaurante do Brejo (sem fundo).png" alt="Logo">
        </div>
        <nav>
            <ul>
                <li><a href="#"><img src="images/icons/do-utilizador.png" alt="Ícone Pessoa"> Sua Conta</a></li>
                <li><a href="#"><img src="images/icons/casa.png" alt="Ícone Casa"> Tela Inicial</a></li>
                <li><a href="../food.php"><img src="images/icons/cardapio.png" alt="Ícone Menu"> Menu</a></li>
                <li><a href="#"><img src="images/icons/reserva.png" alt="Ícone Reservas"> Reservas</a></li>
                <li><a href="avaliacao.php"><img src="images/icons/avaliacao.png" alt="Ícone Avaliações"> Avaliação</a></li>
                <li><a href="../index.php"><img src="" alt=""> Sair</a></li>
            </ul>
        </nav>
    </div>
    <!-- Fim da barra de navegação -->

    <div class="content">
        <h1 class="titulo">• Histórico de Compras •</h1>
        <div class="compras-container">
            <?php
            include 'config.php';

            // Preparando a consulta para evitar SQL Injection
            // Preparando a consulta para evitar SQL Injection
            $stmt = $conexao->prepare("SELECT p.id_pedido, p.status_pedido, p.data, p.total, p.endereco, prod.nome, prod.caminho_img
                                        FROM pedidos p
                                        JOIN pedido_produtos pp ON p.id_pedido = pp.id_pedido
                                        JOIN produtos prod ON pp.id_produto = prod.id_produto
                                        WHERE p.id_cliente = ?
                                        ORDER BY p.data DESC");
            $stmt->bind_param("i", $id_cliente); // Usando $id_cliente aqui
            $stmt->execute();
            $result = $stmt->get_result();

            // Restante do código...
            

            $pedidos = [];
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $id_pedido = $row['id_pedido'];
                    if (!isset($pedidos[$id_pedido])) {
                        $pedidos[$id_pedido] = [
                            'status_pedido' => $row['status_pedido'],
                            'data' => $row['data'],
                            'total' => $row['total'],
                            'endereco' => $row['endereco'],
                            'produtos' => []
                        ];
                    }
                    $pedidos[$id_pedido]['produtos'][] = [
                        'nome' => $row['nome'],
                        'imagem' => $row['caminho_img']
                    ];
                }

                // Exibindo os pedidos e produtos
                foreach ($pedidos as $id_pedido => $pedido) {
                    $jsonData = htmlspecialchars(json_encode($pedido));  // Encode de todo o objeto de pedido
                    echo "<div class='compra-card' onclick='showModal(`{$jsonData}`)'>";
                    echo "<img class='corner-image info-icon' src='images/icons/simbolo-de-informacao.png' alt='Small Image'>"; // Icone de informação
                    echo "<div class='produtos-container'>"; // Container para os produtos
                    foreach ($pedido['produtos'] as $produto) {
                        echo "<img src='../" . htmlspecialchars($produto['imagem']) . "' alt='" . htmlspecialchars($produto['nome']) . "' style='width:50px; margin-right: 5px;'>";
                        echo "<p>" . htmlspecialchars($produto['nome']) . "</p>"; // Nome do produto
                    }
                    echo "</div>";
                    echo "<span>Status: " . htmlspecialchars($pedido['status_pedido']) . "</span>"; // Status do pedido
                    echo "</div>";
                }
            } else {
                echo '<p>Nenhum pedido encontrado.</p>';
            }
            $conexao->close();

            ?>
        </div>
    </div>

    <!-- Início do modal -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <input type="hidden" id="selectedRating" value="0">

            <span class="close">&times;</span>
            <h2 id="modalStatus">Status do pedido:</h2>
            <div id="modalProductName">Produto:</div>
            <p id="modalDate">Data:</p>
            <p id="modalAddress">Endereço:</p>
            <h3>Resumo dos valores</h3>
            <p id="modalSubtotal">Subtotal: R$</p>
            <p id="modalTotal">Total: R$</p>
            <p id="modalPaymentMethod">Forma de pagamento:</p>
            <h3>Avaliação:</h3>
            <div class="star-rating">
                <span class="star-button">★</span>
                <span class="star-button">★</span>
                <span class="star-button">★</span>
                <span class="star-button">★</span>
                <span class="star-button">★</span>
            </div>
            <textarea id="commentBox" placeholder="Adicione um comentário sobre o pedido..." rows="4"
                style="width: 100%;"></textarea>
            <button onclick="submitReview(dadosPedido)" style="margin-top: 10px;">Enviar Avaliação</button>
        </div>
    </div>

    <!-- Fim do modal -->

    <script>
    var modal; // Definição global para garantir acessibilidade
    var dadosPedido; // Definição global para guardar os dados do pedido atual

    document.addEventListener('DOMContentLoaded', function () {
        modal = document.getElementById("myModal");
        var closeSpan = document.getElementsByClassName("close")[0];

        closeSpan.onclick = function () {
            modal.style.display = "none";
        };

        window.onclick = function (event) {
            if (event.target === modal) {
                modal.style.display = "none";
            }
        };

        document.querySelectorAll('.compra-card').forEach(function (card) {
            card.addEventListener('click', function () {
                var jsonData = this.getAttribute('data-json');
                if (jsonData) {
                    showModal(jsonData);
                }
            });
        });

        document.querySelectorAll('.star-button').forEach(function (star, index) {
            star.addEventListener('click', function () {
                document.querySelectorAll('.star-button').forEach((s, i) => {
                    s.style.color = i <= index ? 'orange' : 'gray';
                });
                document.getElementById('selectedRating').value = index + 1;
            });
        });
    });

    function showModal(jsonData) {
        try {
            dadosPedido = JSON.parse(jsonData); // Parse e armazena globalmente
            if (dadosPedido) {
                document.getElementById('modalStatus').textContent = 'Status do pedido: ' + dadosPedido.status_pedido;
                document.getElementById('modalDate').textContent = 'Data: ' + dadosPedido.data;
                document.getElementById('modalSubtotal').textContent = 'Subtotal: R$' + dadosPedido.total;
                document.getElementById('modalTotal').textContent = 'Total: R$' + dadosPedido.total;
                document.getElementById('modalPaymentMethod').textContent = 'Forma de pagamento: ' + (dadosPedido.paymentMethod || 'não informada');
                document.getElementById('modalAddress').textContent = 'Endereço: ' + dadosPedido.endereco;

                var productsList = 'Produtos:<br>';
                dadosPedido.produtos.forEach(function (produto) {
                    productsList += produto.nome + '<br><img src="../' + produto.imagem + '" style="width:50px;"><br>';
                });
                document.getElementById('modalProductName').innerHTML = productsList;

                modal.style.display = "block";
            }
        } catch (e) {
            console.error("Erro ao processar dados do pedido: ", e);
        }
    }

    function submitReview() {
        if (!dadosPedido) {
            console.error("Dados do pedido não estão disponíveis.");
            return;
        }
        var idPedido = dadosPedido.id_pedido; // Usa o id_pedido armazenado
        var rating = document.getElementById('selectedRating').value;
        var comment = document.getElementById('commentBox').value;

        fetch('submit_review.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'id_pedido=' + idPedido + '&nota=' + rating + '&comentario=' + comment
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
            if (data.status === 'success') {
                document.getElementById('commentBox').disabled = true;
                document.querySelectorAll('.star-button').forEach(button => {
                    button.onclick = null;
                    button.style.cursor = "default";
                });
                document.querySelectorAll('.star-button').forEach((star, index) => {
                    star.style.color = index < rating ? 'orange' : 'gray';
                });
                document.querySelector('button[onclick="submitReview()"]').style.display = 'none';
                document.getElementById('modalProductName').innerHTML += `<p>Comentário: ${comment}</p>`;
                modal.style.display = "none";
            }
        }).catch(error => console.error('Error:', error));
    }
</script>


</body>

</html>