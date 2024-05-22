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
    <title>Avaliação do Estabelecimento</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .form-group {
            margin-bottom: 20px;
        }

        .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .btn {
            background-color: #ef9051;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .btn:hover {
            background-color: #d67b3b;
        }

        .star-rating .star {
            font-size: 30px;
            cursor: pointer;
            color: #ccc;
        }

        .star-rating .star:hover,
        .star-rating .star:hover~.star {
            color: #f0ad4e;
        }

        .star-rating .star.selected {
            color: #ffd700;
        }

        .compras-container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .titulo {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
        }

        .sidebar {
            background-color: #ef9051;
            /* Cor laranja */
        }

        .sidebar nav ul {
            list-style-type: none;
            padding: 0;
        }

        .sidebar nav ul li {
            margin: 15px 0;
        }

        .sidebar nav ul li a {
            text-decoration: none;
            color: #fff;
            display: flex;
            align-items: center;
        }

        .sidebar nav ul li a img {
            margin-right: 10px;
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
                <li><a href="indexLogado.php"><img src="images/icons/do-utilizador.png" alt="Ícone Pessoa"> Sua
                        Conta</a></li>
                <li><a href="#"><img src="images/icons/casa.png" alt="Ícone Casa"> Tela Inicial</a></li>
                <li><a href="../food.php"><img src="images/icons/cardapio.png" alt="Ícone Menu"> Menu</a></li>
                <li><a href="reserva/index.php"><img src="images/icons/reserva.png" alt="Ícone Reservas"> Reservas</a>
                </li>
                <li><a href="avaliacao.php"><img src="images/icons/avaliacao.png" alt="Ícone Avaliações"> Avaliação</a>
                </li>
                <li><a href="../index.php"><img src="" alt=""> Sair</a></li>
            </ul>
        </nav>
    </div>
    <!-- Fim da barra de navegação -->

    <div class="content">
        <h1 class="titulo">• Avaliação do Estabelecimento •</h1>
        <div class="compras-container">
            <?php
            if (isset($_GET['status'])) {
                if ($_GET['status'] == 'success') {
                    echo "<p style='color: green;'>Avaliação enviada com sucesso!</p>";
                } elseif ($_GET['status'] == 'error') {
                    $message = isset($_GET['message']) ? urldecode($_GET['message']) : "Erro ao enviar avaliação.";
                    echo "<p style='color: red;'>Erro: $message</p>";
                }
            }
            ?>
            <form action="submit_avaliacao.php" method="POST" id="formAvaliacao">
                <div class="form-group">
                    <label for="nome">Nome:</label>
                    <input type="text" id="nome" name="nome" class="form-control" placeholder="Seu nome" required>
                </div>
                <div class="form-group">
                    <label for="comentario">Comentário:</label>
                    <textarea id="comentario" name="comentario" rows="4" class="form-control"
                        placeholder="Deixe seu comentário aqui..." required></textarea>
                </div>
                <div class="form-group">
                    <label>Nota:</label>
                    <div class="star-rating">
                        <span class="star">&#9733;</span>
                        <span class="star">&#9733;</span>
                        <span class="star">&#9733;</span>
                        <span class="star">&#9733;</span>
                        <span class="star">&#9733;</span>
                    </div>
                    <input type="hidden" name="nota" id="nota">
                </div>
                <button type="submit" class="btn btn-primary">Enviar Avaliação</button>
            </form>

        </div>
    </div>

    <script>
        document.querySelectorAll('.star-rating .star').forEach(function (star, idx) {
            star.onclick = function () {
                let allStars = document.querySelectorAll('.star-rating .star');
                allStars.forEach((star, index) => {
                    if (index <= idx) {
                        star.classList.add('selected');
                    } else {
                        star.classList.remove('selected');
                    }
                });
                document.getElementById('nota').value = idx + 1; // Atribui a nota selecionada ao input escondido
            };
        });
    </script>
</body>

</html>
