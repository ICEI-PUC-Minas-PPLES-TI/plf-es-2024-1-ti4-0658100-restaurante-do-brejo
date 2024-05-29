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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <style>
  .fa-star {
    color: #ccc; /* Cor padrão das estrelas não marcadas */
  }

  .checked {
    color: orange; /* Cor das estrelas marcadas */
  }
</style>

</head>

<body>
  <div class="hero_area">
    <!-- header section strats -->
    <header class="header_section">
      <div class="container-fluid">
        <nav class="navbar navbar-expand-lg custom_nav-container">
          <a class="navbar-brand" href="index.php">
            <img src="images/logoRest.png" alt="" />
            <span>
              Restaurante<br>do Brejo
            </span>
          </a>

          <div class="navbar-collapse" id="">
            <div class="custom_menu-btn">
              <button onclick="openNav()">
                <span class="s-1"> </span>
                <span class="s-2"> </span>
                <span class="s-3"> </span>
              </button>
            </div>
            <div id="myNav" class="overlay">
              <div class="overlay-content">
                <a href="index.php">HOME</a>
                <a href="Login_v2/login.php">Menu</a>
                <a href="Login_v2/login.php">Login</a>
                <a href="contact.php">Fale conosco</a>
              </div>
            </div>
          </div>
        </nav>
      </div>
    </header>
    <!-- end header section -->
    <!-- slider section -->
    <section class=" slider_section position-relative">
      <div class="side_heading">
        <h5>
          B
          o
          a
          C
          o
          m
          i
          d
          a
        </h5>
      </div>
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-3 col-md-4 offset-md-1">
            <div id="carouselExampleIndicators" class="carousel slide " data-ride="carousel">
              <ol class="carousel-indicators">
                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active">
                  01
                </li>
                <li data-target="#carouselExampleIndicators" data-slide-to="1">
                  02
                </li>
                <li data-target="#carouselExampleIndicators" data-slide-to="2">
                  03
                </li>
                <li data-target="#carouselExampleIndicators" data-slide-to="3">
                  04
                </li>
              </ol>
              <div class="carousel-inner">
                <div class="carousel-item active">
                  <div class="img-box b-1">
                    <img src="images/slider-img.png" alt="" />
                  </div>
                </div>
                <div class="carousel-item">
                  <div class="img-box b-2">
                    <img src="images/hot-1.png" alt="" />
                  </div>
                </div>
                <div class="carousel-item">
                  <div class="img-box b-3">
                    <img src="images/hot-2.png" alt="" />
                  </div>
                </div>
                <div class="carousel-item">
                  <div class="img-box b-4">
                    <img src="images/hot-3.png" alt="" />
                  </div>
                </div>
              </div>
              <div class="carousel_btn-box">
                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                  <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                  <span class="sr-only">Next</span>
                </a>
              </div>
            </div>
          </div>
          <div class=" col-md-5 offset-md-1">
            <div class="detail-box">
              <h1>
                Comida <br>
                Caseira
              </h1>
              <p>
                Em nosso restaurante, a essência da culinária tradicional mineira é celebrada a cada prato servido,
                trazendo para a mesa o verdadeiro
                sabor da hospitalidade e da riqueza cultural de Minas Gerais.
              </p>

              <div class="btn-box">

                <a href="Login_v2/login.php" class="btn-2">
                  PEÇA AGORA
                </a>
              </div>

            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- end slider section -->
  </div>
  <!-- hot section -->

  <section class="hot_section layout_padding">
    <div class="container">
      <div class="heading_container">
        <h2>
          Alguns dos Nossos Pratos
        </h2>
        <hr>
      </div>

    </div>
    <div class="carousel_container">
      <div class="container">
        <div class="carousel-wrap ">
          <div class="owl-carousel">
            <div class="item">
              <div class="box">
                <div class="img-box">
                  <img src="images/hot-1.png" />
                </div>
                <div class="detail-box">

                  <p>
                    There are many variations of passages of Lorem Ipsum available,
                  </p>

                </div>
              </div>
            </div>
            <div class="item">
              <div class="box">
                <div class="img-box">
                  <img src="images/hot-2.png" />
                </div>
                <div class="detail-box">

                  <p>
                    There are many variations of passages of Lorem Ipsum available,
                  </p>

                </div>
              </div>
            </div>
            <div class="item">
              <div class="box">
                <div class="img-box">
                  <img src="images/hot-3.png" />
                </div>
                <div class="detail-box">

                  <p>
                    There are many variations of passages of Lorem Ipsum available,
                  </p>

                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  

  <?php include 'config.php'; ?>

<section class="client_section layout_padding">
    <div class="container">
        <div class="heading_container">
            <hr>
            <h2>
                comentários dos nossos clientes
            </h2>
        </div>
        <div id="carouselExample2Indicators" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <?php
                $result = $conn->query("SELECT * FROM avaliacao_rest");
                if ($result) {
                    $numRows = $result->num_rows;
                    for ($i = 0; $i < $numRows; $i++) {
                        echo "<li data-target='#carouselExample2Indicators' data-slide-to='$i'" . ($i === 0 ? " class='active'" : "") . "></li>";
                    }
                }
                ?>
            </ol>
            <div class="carousel-inner">
                <?php
                $first = true;
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='carousel-item" . ($first ? " active" : "") . "'>";
                    echo "<div class='box'>";
                    echo "<div class='client_id'>";
                    echo "<div class='img-box'>";
                    echo "<img src='images/client.png' alt='' class='img-fluid'>";
                    echo "</div>";
                    echo "<h4>" . htmlspecialchars($row['nome']) . "</h4>";
                    echo "</div>";
                    echo "<div class='detail-box'>";
                    echo "<p>" . htmlspecialchars($row['comentario']) . "</p>";
                    // Renderizar as estrelas baseadas na avaliação
                    echo "<div class='rating'>";
                    for ($i = 0; $i < 5; $i++) {
                        if ($i < $row['nota']) {
                            echo "<span class='fa fa-star checked'></span>";
                        } else {
                            echo "<span class='fa fa-star'></span>";
                        }
                    }
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";
                    echo "</div>";
                    $first = false;
                }
                $result->free();
                ?>
            </div>
        </div>
    </div>
</section>


  <!-- end client section -->

  <!-- contact section -->

  <section class="contact_section layout_padding-bottom ">
    <div class="container">
      <h2>
        Fale conosco!
      </h2>
      <div class="row">

        <div class="col-md-5">
          <div class="contact_box">
            <a href="">
              <div class="img-box">
                <img src="images/location.png" alt="">
              </div>
              <h6>
                Rua Pref. José Píres Carneiro, 128 - Brejo, Conceição do Mato Dentro - MG, 35860-000
              </h6>
            </a>
            <a href="">
              <div class="img-box">
                <img src="images/call.png" alt="">
              </div>
              <h6>
                (31) 3868-1338
              </h6>
            </a>
            <a href="">
              <div class="img-box">
                <img src="images/envelope.png" alt="">
              </div>
              <h6>
                brejo@gmail.com
              </h6>
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- end contact section -->

  <!-- subscribe section -->



  <!-- end subscribe section -->

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
  </script>
  <!-- end owl carousel script -->

</body>

</html>