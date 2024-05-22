<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pedidos Solicitados</title>
  <link rel="stylesheet" href="style.css">
  <style>
    .pedidos-container {
      margin-top: 20px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
    }

    table, th, td {
      border: 1px solid #ddd;
    }

    th, td {
      padding: 12px;
      text-align: left;
    }

    th {
      background-color: #f2f2f2;
    }

    .btn-aceitar, .btn-cancelar {
      padding: 5px 10px;
      border: none;
      border-radius: 3px;
      cursor: pointer;
    }

    .btn-aceitar {
      background-color: #4CAF50;
      color: white;
    }

    .btn-cancelar {
      background-color: #f44336;
      color: white;
    }
  </style>
</head>
<body>
  <!-- Início da barra de navegação -->
  <div class="sidebar">
    <div class="logo">
      <img src="Logo Restaurante do Brejo (sem fundo).png" alt="Logo">
    </div>
    <nav>
      <ul>
        <li><a href="paginaFuncionario.php"><img src="images/icons/do-utilizador.png" alt="Ícone Pessoa"> Dashboard</a></li>
        <li><a href="gerenciamentoMenu.php"><img src="cardapio.png" alt="Ícone Menu"> Gerenciar Menu</a></li>
        <li><a href="gerir_reserva/index.php"><img src="reserva.png" alt="Ícone Reservas"> Gerenciar Reservas</a></li>
        <li><a href="../index.php"><img src="" alt=""> Sair</a></li>
      </ul>
    </nav>
  </div>
  <!-- Fim da barra de navegação -->

  <div class="content">
    <h1 class="titulo">• Pedidos Solicitados •</h1>

    <!-- Início dos pedidos -->
    <div class="pedidos-container">
      <table>
        <thead>
          <tr>
            <th>ID Cliente</th>
            <th>Total</th>
            <th>Data</th>
            <th>Endereço</th>
            <th>Status</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody id="pedidos-tbody">
          <!-- Os dados dos pedidos serão carregados aqui -->
        </tbody>
      </table>
    </div>
    <!-- Fim dos pedidos -->
  </div>

  <script>
document.addEventListener("DOMContentLoaded", function() {
  const pedidosTbody = document.getElementById("pedidos-tbody");

  const fetchPedidos = () => {
    fetch('obter_pedidos.php')
      .then(response => response.json())
      .then(data => {
        renderPedidos(data);
      })
      .catch(error => {
        console.error('Erro ao carregar pedidos:', error);
      });
  };

  const renderPedidos = (pedidos) => {
    pedidosTbody.innerHTML = "";
    pedidos.forEach((pedido) => {
      const row = document.createElement("tr");

      const idClienteCell = document.createElement("td");
      idClienteCell.textContent = pedido.id_cliente;
      row.appendChild(idClienteCell);

      const totalCell = document.createElement("td");
      totalCell.textContent = `R$${parseFloat(pedido.total).toFixed(2)}`;
      row.appendChild(totalCell);

      const dataCell = document.createElement("td");
      dataCell.textContent = pedido.data;
      row.appendChild(dataCell);

      const enderecoCell = document.createElement("td");
      enderecoCell.textContent = pedido.endereco;
      row.appendChild(enderecoCell);

      const statusCell = document.createElement("td");
      statusCell.textContent = pedido.status_pedido;
      row.appendChild(statusCell);

      const actionsCell = document.createElement("td");

      const btnAceitar = document.createElement("button");
      btnAceitar.classList.add("btn-aceitar");
      btnAceitar.textContent = "✔";
      btnAceitar.addEventListener("click", () => atualizarStatus(pedido.id_pedido, 'Aceito'));
      actionsCell.appendChild(btnAceitar);

      const btnCancelar = document.createElement("button");
      btnCancelar.classList.add("btn-cancelar");
      btnCancelar.textContent = "✖";
      btnCancelar.addEventListener("click", () => atualizarStatus(pedido.id_pedido, 'Cancelado'));
      actionsCell.appendChild(btnCancelar);

      row.appendChild(actionsCell);

      pedidosTbody.appendChild(row);
    });
  };

  const atualizarStatus = (id_pedido, status_pedido) => {
    fetch('atualizar_pedido.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded'
      },
      body: `id_pedido=${id_pedido}&status_pedido=${status_pedido}`
    })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        fetchPedidos(); // Recarrega a lista de pedidos após a atualização
      } else {
        console.error('Erro ao atualizar pedido:', data.error);
      }
    })
    .catch(error => {
      console.error('Erro ao atualizar pedido:', error);
    });
  };

  fetchPedidos();
});
</script>
</body>
</html>
