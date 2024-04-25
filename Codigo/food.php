<?php
session_start();  // Continua necessário para acessar a sessão

include_once ('config.php');

$id = $_SESSION['id_cliente'] ;  // Acessa o ID do usuário na sessão, se disponível

// Se o ID não estiver disponível, você pode decidir como manipular isso.
// Por exemplo, você poderia redirecionar ou simplesmente não executar as operações que dependem do ID.
// Para este exemplo, vamos assumir que o resto do código pode lidar com um $id nulo.

// Consulta para a seção de pratos
$queryDishes = "SELECT id_produto, nome, preco, caminho_img, descricao FROM produtos WHERE categoria != 'pf'";
$resultadoDishes = $conn->query($queryDishes);
$dishes = [];

if ($resultadoDishes && $resultadoDishes->num_rows > 0) {
  while ($row = $resultadoDishes->fetch_assoc()) {
    $dishes[] = $row;
  }
}

// Consulta para a seção tradicionais (hot section)
$queryHot = "SELECT id_produto, nome, preco, caminho_img, descricao FROM produtos WHERE categoria = 'pf'";
$resultadoHot = $conn->query($queryHot);
$hotDishes = [];

if ($resultadoHot && $resultadoHot->num_rows > 0) {
  while ($row = $resultadoHot->fetch_assoc()) {
    $hotDishes[] = $row;
  }
}

// Consulta para itens no carrinho do usuário específico, se houver um id definido
$cartItems = [];
if ($id) {
  $queryCart = "SELECT p.id_produto, p.nome, p.preco, p.caminho_img, c.quantidade, c.data_hora 
                  FROM carrinho c 
                  JOIN produtos p ON c.id_produto = p.id_produto 
                  WHERE c.id_usuario = ?";
  $stmt = $conn->prepare($queryCart);
  $stmt->bind_param("i", $id);
  $stmt->execute();
  $resultadoCart = $stmt->get_result();

  if ($resultadoCart->num_rows > 0) {
    while ($row = $resultadoCart->fetch_assoc()) {
      $cartItems[] = $row;
    }
  }
}

$conn->close();

// Incluímos o restante do seu HTML e scripts abaixo desta linha
?>




<!DOCTYPE html>
<html>

<head>
  <!-- Basic -->
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <!-- Mobile Metas -->
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <!-- Site Metas -->
  <meta name="keywords" content="" />
  <meta name="description" content="" />
  <meta name="author" content="" />

  <title>Restaurante do Brejo</title>
  <!-- slider stylesheet -->
  <link rel="stylesheet" type="text/css"
    href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />

  <!-- bootstrap core css -->
  <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />

  <!-- fonts style -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700|Poppins:400,700|Raleway:400,700&display=swap"
    rel="stylesheet" />

  <!-- Custom styles for this template -->
  <link href="css/style.css" rel="stylesheet" />
  <!-- responsive style -->


  <style>
    .cart-menu {
      position: relative;
      display: inline-block;
    }


    .cart-btn {
      position: fixed;
      /* Fixa o botão em relação à viewport */
      right: 20px;
      /* Posiciona o botão no canto direito da tela */
      top: 4,5%;
      /* Posiciona verticalmente na metade da altura da tela */
      transform: translateY(-50%);
      /* Centraliza verticalmente */
      padding: 10px 20px;
      background-color: #ffa500;
      /* Cor de fundo */
      color: white;
      /* Cor do texto */
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }



    .cart-dropdown {
      display: none;
      position: fixed;
      /* Fixa o dropdown em relação à viewport, assim como o botão */
      right: 20px;
      /* Alinha o dropdown à direita, abaixo do botão */
      top: calc(2% + 50px);
      /* Ajusta a posição vertical para aparecer logo abaixo do botão */
      width: 300px;
      background-color: #f9f9f9;
      box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
      padding: 10px;
      border-radius: 5px;
      z-index: 1000;
    }



    .cart-item {
      margin-bottom: 10px;
      border-bottom: 1px solid #ddd;
      padding-bottom: 10px;
    }

    .cart-dropdown .btn {
      display: block;
      width: 100%;
      text-align: center;
      background-color: #4CAF50;
      color: white;
      padding: 10px 0;
      text-decoration: none;
    }

    .cart-dropdown .btn1 {
      display: block;
      width: 100%;
      text-align: center;
      background-color: #f9f9f9;
      color: black;
      padding: 10px 0;
      text-decoration: none;
    }

    /* Estilo global para todas as imagens dos pratos */
    .img-box img {
      width: 100%;
      /* Faz a imagem expandir para preencher o container */
      height: auto;
      /* Mantém a proporção da imagem */
      object-fit: cover;
      /* Garante que a imagem cubra toda a área designada sem perder a proporção */
      border-radius: 10px;
      /* Adiciona bordas arredondadas para uma aparência mais suave */
    }

    /* Estilo para o container das imagens para definir um tamanho fixo */
    .img-box {
      height: 200px;
      /* Define uma altura fixa para todas as imagens */
      overflow: hidden;
      /* Oculta partes da imagem que excedam o tamanho do container */
      border-radius: 10px;
      /* Assegura que a borda da imagem combine com o raio da borda do container */
      margin-bottom: 15px;
      /* Adiciona espaço abaixo do container da imagem */
    }

    /* Estilo para o container dos pratos para manter a consistência */
    .box {
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      /* Adiciona sombra para destacar */
      transition: transform 0.3s ease-in-out;
      /* Animação suave para hover */
    }

    /* Estilo para o hover nos pratos */
    .box:hover {
      transform: translateY(-5px);
      /* Movimenta o prato um pouco para cima quando o mouse está sobre ele */
    }

    .modal {
      position: fixed;
      z-index: 1;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      overflow: auto;
      background-color: rgb(0, 0, 0);
      background-color: rgba(0, 0, 0, 0.4);
    }

    .modal-content {
      background-color: #fefefe;
      margin: 15% auto;
      padding: 20px;
      border: 1px solid #888;
      width: 80%;
      box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
      animation-name: animatetop;
      animation-duration: 0.4s;
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
  </style>
</head>

<body class="sub_page1">
  <div class="hero_area1">
    <!-- header section strats -->
    <header class="header_section">
      <style>
        .header_section {
          background-color: #ef9851;
          /* Cor laranja */
        }
      </style>
      <div class="container-fluid">
        <nav class="navbar navbar-expand-lg custom_nav-container">
          <a class="navbar-brand" href="Login_v2/indexLogado.php">
            <img src="images/logoRest.png" alt="" />
          </a>
          <div class="cart-menu">
            <button class="cart-btn">Carrinho</button>
            <div class="cart-dropdown" style="display: none;">
              <?php if (!empty($cartItems)): ?>
                <?php foreach ($cartItems as $item): ?>
                  <div class="cart-item">
                    <img src="<?= htmlspecialchars($item['caminho_img']) ?>" alt="<?= htmlspecialchars($item['nome']) ?>"
                      style="width: 50px; height: auto;">
                    <p><?= htmlspecialchars($item['nome']) ?></p>
                    <p>Quantidade: <?= htmlspecialchars($item['quantidade']) ?></p>
                    <p>Preço: R$<?= number_format($item['preco'], 2, ',', '.') ?></p>
                    <!-- Verifique se 'id_produto' está disponível -->
                    <?php if (isset($item['id_produto'])): ?>
                      <button class="delete-btn" data-id="<?= $item['id_produto'] ?>">🗑️</button>
                    <?php else: ?>
                      <p>Erro: ID do produto não disponível</p>
                    <?php endif; ?>
                  </div>
                <?php endforeach; ?>
                <a href="#" class="btn open-modal">Pague Aqui!</a>

              <?php else: ?>
                <p>Nenhum item no carrinho.</p>
              <?php endif; ?>
            </div>


          </div>

        </nav>
      </div>
      <!-- Modal Pague Aqui -->
      <div id="paymentModal" class="modal" style="display:none;">
        <div class="modal-content">
          <span class="close">&times;</span>
          <h2>Informações de Pagamento</h2>
          
          <!-- Conteúdo do Modal -->
          <form action="process_payment.php" method="post" id="paymentForm">
          
            <!-- Botões de Método de Pagamento -->
            <button type="submit" class="btn" name="payment_method" value="cash">Pagar em
              Dinheiro na Entrega</button>
            <!-- Alterado para botão para poder usar 'disabled' -->
            <button type="button" class="btn" id="payCardBtn"
              onclick="window.location.href='stripe/public/checkout.php'">Pagamento em Cartão</button>

          </form>
        </div>
      </div>


    </header>
    <!-- end header section -->
  </div>

  <!-- dish section -->
  <section class="dish_section layout_padding">
    <div class="container">
      <div class="row">
        <?php if (!empty($dishes)): ?>
          <?php foreach ($dishes as $row): ?>
            <div class="col-md-6 col-lg-4">
              <div class="box">
                <div class="img-box">
                  <img src="<?= htmlspecialchars($row['caminho_img']) ?>" alt="<?= htmlspecialchars($row['nome']) ?>">
                </div>
                <div class="detail-box">
                  <h5><?= htmlspecialchars($row['nome']) ?></h5>
                  <p><?= htmlspecialchars($row['descricao']) ?></p>
                  <h4>R$<?= number_format($row['preco'], 2, ',', '.') ?></h4>
                  <a href="add_to_cart.php?id_produto=<?= $row['id_produto'] ?>" class="btn">Adicionar ao Carrinho</a>

                </div>
              </div>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <p>No dishes found.</p>
        <?php endif; ?>
      </div>
    </div>
  </section>


  <!-- end dish section -->

  <!-- hot section -->
  <section class="hot_section layout_padding">
    <div class="container">
      <div class="heading_container">
        <h2>Tradicionais</h2>
        <hr>
      </div>
      <p>Alguns de nossos pratos feitos tradicionais que servimos</p>
      <div class="carousel_container">
        <div class="container">
          <div class="carousel-wrap">
            <div class="owl-carousel">
              <?php if (!empty($hotDishes)): ?>
                <?php foreach ($hotDishes as $row): ?>
                  <div class="item">
                    <div class="box">
                      <div class="img-box">
                        <img src="<?= htmlspecialchars($row['caminho_img']) ?>" alt="<?= htmlspecialchars($row['nome']) ?>">
                      </div>
                      <div class="detail-box">
                        <h4>R$<?= number_format($row['preco'], 2, ',', '.') ?></h4>
                        <p><?= htmlspecialchars($row['descricao']) ?></p>
                        <a href="add_to_cart.php?id_produto=<?= $row['id_produto'] ?>" class="btn">Adicionar ao Carrinho</a>

                      </div>
                    </div>
                  </div>
                <?php endforeach; ?>
              <?php else: ?>
                <p>No products found.</p>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- end hot section -->



  <!-- footer section -->
  <section class="container-fluid footer_section">
    <div class="social_container">
      <h4>
        Nos siga!
      </h4>
      <div class="social-box">
        <a href="https://www.instagram.com/restaurantedobrejo/">
          <img src="images/insta.png" alt="">
        </a>
      </div>
    </div>
    <p>
      &copy; 2024 All Rights Reserved.
    </p>
  </section>
  <!-- footer section -->

  <script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
  <script type="text/javascript" src="js/bootstrap.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js">
  </script>

  <script>
    function openNav() {
      document.getElementById("myNav").classList.toggle("menu_width");
      document
        .querySelector(".custom_menu-btn")
        .classList.toggle("menu_btn-style");
    }
  </script>

  <!-- owl carousel script -->
  <script type="text/javascript">
    $(".owl-carousel").owlCarousel({
      loop: true,
      margin: 35,
      navText: [],
      autoplay: true,
      autoplayHoverPause: true,
      responsive: {
        0: {
          items: 1
        },
        600: {
          items: 2
        },
        1000: {
          items: 3
        }
      }
    });

    document.querySelector('.cart-btn').addEventListener('click', function () {
      var dropdown = document.querySelector('.cart-dropdown');
      dropdown.style.display = dropdown.style.display === 'none' ? 'block' : 'none';
    });

    document.querySelectorAll('.delete-btn').forEach(button => {
      button.addEventListener('click', function () {
        var productId = this.getAttribute('data-id');
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'delete_cart_item.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function () {
          if (this.status === 200) {
            location.reload();
          } else {
            alert('Erro ao deletar o item.');
          }
        };
        xhr.send('id_produto=' + productId);
      });
    });

    document.querySelector('.open-modal').addEventListener('click', function (event) {
      event.preventDefault();
      var modal = document.getElementById('paymentModal');
      var dropdown = document.querySelector('.cart-dropdown');
      dropdown.style.display = 'none'; // Fechar o dropdown do carrinho ao abrir o modal
      modal.style.display = 'block';
    });

    // Fechamento do modal com o botão close
    var closeBtn = document.querySelector('#paymentModal .close'); // Assegurar que o seletor está correto
    closeBtn.onclick = function () {
      var modal = document.getElementById('paymentModal');
      modal.style.display = "none";
    };

    // Fechar o modal ao clicar fora dele
    window.onclick = function (event) {
      var modal = document.getElementById('paymentModal');
      if (event.target == modal) {
        modal.style.display = "none";
      }
    };
  </script>
  <script>
    function showCardDetails() {
      var cardDetails = document.getElementById('cardDetails');
      cardDetails.style.display = 'block'; // Mostra os campos para pagamento com cartão
      // Alterar a action do formulário para redirecionar para o sistema de pagamentos
      var form = document.getElementById('paymentForm');
      form.action = 'process_card_payment.php';
    }

    // Para o botão de fechar o modal
    var span = document.getElementsByClassName("close")[0];
    span.onclick = function () {
      var modal = document.getElementById('paymentModal');
      modal.style.display = "none";
    }

    // Para fechar o modal quando clicar fora dele
    window.onclick = function (event) {
      var modal = document.getElementById('paymentModal');
      if (event.target == modal) {
        modal.style.display = "none";
      }
    }
  </script>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const addressInput = document.querySelector('input[name="address"]');
      const payCashBtn = document.getElementById('payCashBtn');
      const payCardBtn = document.getElementById('payCardBtn');

      // Função para verificar o estado do campo de endereço e ajustar a disponibilidade dos botões
      function toggleButtonState() {
        if (addressInput.value.trim() !== "") {
          payCashBtn.disabled = false;
          payCardBtn.disabled = false;
        } else {
          payCashBtn.disabled = true;
          payCardBtn.disabled = true;
        }
      }

      // Adiciona um evento 'input' que é disparado sempre que o usuário digita no campo de endereço
      addressInput.addEventListener('input', toggleButtonState);

      // Verifica inicialmente o estado do campo ao carregar a página
      toggleButtonState();
    });
  </script>


  <!-- end owl carousel script -->

</body>

</html>