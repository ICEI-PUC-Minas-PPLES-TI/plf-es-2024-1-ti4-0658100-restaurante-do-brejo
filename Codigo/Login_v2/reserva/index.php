<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Histórico de Reservas</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <div class="sidebar">
    <div class="logo">
      <img src="Logo Restaurante do Brejo (sem fundo).png" alt="Logo">
    </div>
    <nav>
      <ul>
        <li><a href="../indexLogado.php"><img src="../images/icons/do-utilizador.png" alt="Ícone Pessoa"> Sua Conta</a>
        </li>
        <li><a href="../../index.php"><img src="casa.png" alt="Ícone Casa"> Tela Inicial</a></li>
        <li><a href="../../food.php"><img src="cardapio.png" alt="Ícone Menu"> Menu</a></li>
        <li><a href="index.php"><img src="reserva.png" alt="Ícone Reservas"> Reservas</a></li>
        <li><a href="../avaliacao.php"><img src="avaliacao.png" alt="Ícone Avaliações"> Avaliações</a></li>
        <li><a href="../../index.php"><img src="" alt=""> Sair</a></li>
      </ul>
    </nav>
  </div>

  <div class="content">
    <h1 class="titulo">• Histórico de Reservas •</h1>

    <!-- Verifica se há mensagens de status -->
    <?php if (isset($_GET['status'])): ?>
      <div class="status-message">
        <?php if ($_GET['status'] == 'sucesso'): ?>
          <p class="sucesso">Reserva realizada com sucesso!</p>
        <?php else: ?>
          <p class="erro">Erro ao realizar reserva: <?= htmlspecialchars($_GET['mensagem']) ?></p>
        <?php endif; ?>
      </div>
    <?php endif; ?>

    <div class="historico-container">
      <!-- Os dados das reservas serão carregados aqui -->
    </div>
    <a href="solicitar_reserva.php" class="btn-solicitar">Realizar solicitação de reserva</a>
  </div>

  <script>
    document.addEventListener("DOMContentLoaded", function () {
      const historicoContainer = document.querySelector(".historico-container");

      // Função para renderizar o histórico de reservas
      const renderHistorico = (reservas) => {
        historicoContainer.innerHTML = "";
        reservas.forEach((reserva) => {
          const reservaCard = document.createElement("div");
          reservaCard.classList.add("reserva-card");

          const reservaDetalhes = document.createElement("div");
          reservaDetalhes.classList.add("reserva-detalhes");
          reservaDetalhes.innerHTML = `
        <p><strong>Data:</strong> ${reserva.data}</p>
        <p><strong>Horário:</strong> ${reserva.hora}</p>
        <p><strong>Capacidade:</strong> ${reserva.capacidade_mesa} pessoas</p>
        <p><strong>Status:</strong> ${reserva.status}</p>
      `;

          reservaCard.appendChild(reservaDetalhes);
          historicoContainer.appendChild(reservaCard);
        });
      };

      // Requisição AJAX para obter o histórico de reservas
      fetch('obter_reservas.php')
        .then(response => {
          console.log('Raw response:', response);
          if (!response.ok) {
            throw new Error('Erro ao buscar dados: ' + response.statusText);
          }
          return response.text().then(text => {
            console.log('Response text:', text);
            try {
              return JSON.parse(text);
            } catch (error) {
              console.error('Erro ao parsear JSON:', error);
              throw new Error('Erro ao parsear JSON');
            }
          });
        })
        .then(data => {
          console.log('Parsed response:', data);
          if (data.error) {
            console.error('Erro:', data.error);
            historicoContainer.innerHTML = `<p class="erro">Erro ao carregar histórico de reservas: ${data.error}</p>`;
          } else {
            renderHistorico(data);
          }
        })
        .catch(error => {
          console.error('Erro ao carregar histórico de reservas:', error);
          historicoContainer.innerHTML = `<p class="erro">Erro ao carregar histórico de reservas: ${error.message}</p>`;
        });
    });

  </script>

</body>

</html>