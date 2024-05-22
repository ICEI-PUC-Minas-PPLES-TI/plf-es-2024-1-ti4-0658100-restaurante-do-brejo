<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reserva de Mesa</title>
  <link rel="stylesheet" href="solicitar_reserva.css">
</head>
<body>
  <div class="sidebar">
    <div class="logo">
      <img src="Logo Restaurante do Brejo (sem fundo).png" alt="Logo">
    </div>
    <nav>
      <ul>
      <li><a href="../indexLogado.php"><img src="../images/icons/do-utilizador.png" alt="Ícone Pessoa"> Sua Conta</a></li>
        <li><a href="../../index.php"><img src="casa.png" alt="Ícone Casa"> Tela Inicial</a></li>
        <li><a href="../../food.php"><img src="cardapio.png" alt="Ícone Menu"> Menu</a></li>
        <li><a href="index.php"><img src="reserva.png" alt="Ícone Reservas"> Reservas</a></li>
        <li><a href="../avaliacao.php"><img src="avaliacao.png" alt="Ícone Avaliações"> Avaliações</a></li>
        <li><a href="../../index.php"><img src="" alt=""> Sair</a></li>
      </ul>
    </nav>
  </div>

  <div class="content">
    <h1 class="titulo">• Reserva de Mesa •</h1>
    <div class="reservas-container">
      <form action="processar_reserva.php" method="POST">
        <div class="calendar">
          <div class="month">
            <button type="button" id="prev-month" class="nav-arrow">←</button>
            <span id="month-year"></span>
            <button type="button" id="next-month" class="nav-arrow">→</button>
          </div>
          <div class="days" id="calendar-days"></div>
        </div>

        <div class="section">
          <h2>Horário</h2>
          <div id="horarios"></div>
        </div>

        <div class="section">
          <h2>Capacidade da mesa</h2>
          <div id="capacidades">
            <button type="button" class="btn-capacidade" data-capacidade="2">2 pessoas</button>
            <button type="button" class="btn-capacidade" data-capacidade="4">até 4 pessoas</button>
            <button type="button" class="btn-capacidade" data-capacidade="6">até 6 pessoas</button>
            <button type="button" class="btn-capacidade" data-capacidade="8">até 8 pessoas</button>
          </div>
        </div>

        <input type="hidden" name="data" id="data">
        <input type="hidden" name="hora" id="hora">
        <input type="hidden" name="capacidade_mesa" id="capacidade_mesa">
        <button type="submit" id="reservar-btn" class="reservar-btn">Solicitar Reserva</button>
      </form>
    </div>
  </div>

  <script src="solicitar_reserva.js"></script>
</body>
</html>
