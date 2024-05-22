document.addEventListener("DOMContentLoaded", function() {
  const reservasContainer = document.querySelector(".reservas-container");

  const fetchReservas = () => {
    fetch('obter_reservas.php')
      .then(response => response.json())
      .then(data => {
        renderReservas(data);
      })
      .catch(error => {
        console.error('Erro ao carregar reservas:', error);
      });
  };

  const renderReservas = (reservas) => {
    reservasContainer.innerHTML = "";
    reservas.forEach((reserva) => {
      const reservaCard = document.createElement("div");
      reservaCard.classList.add("reserva-card");

      const reservaDetalhes = document.createElement("div");
      reservaDetalhes.classList.add("reserva-detalhes");
      reservaDetalhes.innerHTML = `
        <p><strong>ID Cliente:</strong> ${reserva.id_cliente}</p>
        <p><strong>Data:</strong> ${reserva.data}</p>
        <p><strong>Horário:</strong> ${reserva.hora}</p>
        <p><strong>Capacidade:</strong> ${reserva.capacidade_mesa} pessoas</p>
        <p><strong>Status:</strong> ${reserva.status}</p>
      `;

      const reservaAcoes = document.createElement("div");
      reservaAcoes.classList.add("reserva-acoes");

      const btnAceitar = document.createElement("button");
      btnAceitar.classList.add("btn-aceitar");
      btnAceitar.textContent = "✔";
      btnAceitar.addEventListener("click", () => atualizarStatus(reserva.id_reserva, 'Aceita'));

      const btnCancelar = document.createElement("button");
      btnCancelar.classList.add("btn-cancelar");
      btnCancelar.textContent = "✖";
      btnCancelar.addEventListener("click", () => atualizarStatus(reserva.id_reserva, 'Cancelada'));

      reservaAcoes.appendChild(btnAceitar);
      reservaAcoes.appendChild(btnCancelar);

      reservaCard.appendChild(reservaDetalhes);
      reservaCard.appendChild(reservaAcoes);

      reservasContainer.appendChild(reservaCard);
    });
  };

  const atualizarStatus = (id_reserva, status) => {
    fetch('atualizar_reserva.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded'
      },
      body: `id_reserva=${id_reserva}&status=${status}`
    })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        fetchReservas(); // Recarrega a lista de reservas após a atualização
      } else {
        console.error('Erro ao atualizar reserva:', data.error);
      }
    })
    .catch(error => {
      console.error('Erro ao atualizar reserva:', error);
    });
  };

  fetchReservas();
});
