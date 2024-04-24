<?php
include_once ('config.php');

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

$userId = $_SESSION['userId'] ?? 1; // Exemplo: Pegando ID do usuário da sessão ou usando um default

// Consulta para itens no carrinho do usuário específico
// Consulta para itens no carrinho do usuário específico
$queryCart = "SELECT p.id_produto, p.nome, p.preco, p.caminho_img, c.quantidade, c.data_hora 
              FROM carrinho c 
              JOIN produtos p ON c.id_produto = p.id_produto 
              WHERE c.id_usuario = ?";
$stmt = $conn->prepare($queryCart);
$stmt->bind_param("i", $userId);
$stmt->execute();
$resultadoCart = $stmt->get_result();


$cartItems = [];

if ($resultadoCart->num_rows > 0) {
  while ($row = $resultadoCart->fetch_assoc()) {
    $cartItems[] = $row;
  }
}

$conn->close();
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
  <link href="css/responsive.css" rel="stylesheet" />

  <style>
    .cart-menu {
      position: relative;
      display: inline-block;
    }

    .cart-btn {
      position: absolute;
      right: 100px;
      /* Ajuste este valor para aumentar ou diminuir o espaço da borda direita */
      top: 50%;
      /* Centraliza verticalmente */
      transform: translateY(-50%);
      /* Ajuste fino para centralizar exatamente */
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
      position: absolute;
      right: 10px;
      /* Ajusta a posição 10px à esquerda da borda direita do seu contêiner posicionado */
      top: 50px;
      /* Exemplo: faz com que o dropdown comece 50px abaixo do topo do contêiner */
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
  </style>
</head>

<body class="sub_page">
  <div class="hero_area">
    <!-- header section strats -->
    <header class="header_section">
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
                    <img src="images/<?= htmlspecialchars($item['caminho_img']) ?>"
                      alt="<?= htmlspecialchars($item['nome']) ?>" style="width: 50px; height: auto;">
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
                <a href="stripe/public/checkout.php" class="btn">Pagamento em Cartão</a>
                <a href="" class="btn1">Pagamento em Dinheiro</a>
              <?php else: ?>
                <p>Nenhum item no carrinho.</p>
              <?php endif; ?>
            </div>


          </div>
          
        </nav>
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
                  <img src="images/<?= htmlspecialchars($row['caminho_img']) ?>"
                    alt="<?= htmlspecialchars($row['nome']) ?>">
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
                        <img src="images/<?= htmlspecialchars($row['caminho_img']) ?>"
                          alt="<?= htmlspecialchars($row['nome']) ?>">
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

        // Configurar a solicitação AJAX para enviar o ID do produto a ser deletado
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'delete_cart_item.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function () {
          if (this.status === 200) {
            // Recarrega a página para mostrar o carrinho atualizado
            location.reload();
          } else {
            alert('Erro ao deletar o item.');
          }
        };
        xhr.send('id_produto=' + productId);
      });
    });

  </script>
  <!-- end owl carousel script -->

</body>

</html>