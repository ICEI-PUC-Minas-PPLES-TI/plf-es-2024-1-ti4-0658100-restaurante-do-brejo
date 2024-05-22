document.addEventListener("DOMContentLoaded", function() {
  const monthYearDisplay = document.getElementById("month-year");
  const calendarDays = document.getElementById("calendar-days");
  const prevMonthBtn = document.getElementById("prev-month");
  const nextMonthBtn = document.getElementById("next-month");
  const horariosContainer = document.getElementById("horarios");
  const capacidadesButtons = document.querySelectorAll(".btn-capacidade");
  const reservarBtn = document.getElementById("reservar-btn");

  const dataInput = document.getElementById("data");
  const horaInput = document.getElementById("hora");
  const capacidadeInput = document.getElementById("capacidade_mesa");

  let selectedDate = null;
  let selectedTime = null;
  let selectedCapacity = null;

  const now = new Date();
  let currentMonth = now.getMonth();
  let currentYear = now.getFullYear();

  const renderCalendar = () => {
    calendarDays.innerHTML = "";
    const firstDayOfMonth = new Date(currentYear, currentMonth, 1);
    const lastDayOfMonth = new Date(currentYear, currentMonth + 1, 0);
    const prevLastDay = new Date(currentYear, currentMonth, 0);
    const daysInMonth = lastDayOfMonth.getDate();

    monthYearDisplay.textContent = firstDayOfMonth.toLocaleString("pt-BR", { month: "long", year: "numeric" });

    for (let i = 1; i < firstDayOfMonth.getDay(); i++) {
      const emptyCell = document.createElement("div");
      calendarDays.appendChild(emptyCell);
    }

    for (let i = 1; i <= daysInMonth; i++) {
      const dayCell = document.createElement("div");
      dayCell.textContent = i;
      dayCell.classList.add("day");
      dayCell.addEventListener("click", () => selectDate(i));
      calendarDays.appendChild(dayCell);
    }
  };

  const selectDate = (day) => {
    const days = document.querySelectorAll(".day");
    days.forEach(day => day.classList.remove("selected"));
    selectedDate = new Date(currentYear, currentMonth, day);
    const selectedDay = Array.from(days).find(d => d.textContent == day);
    if (selectedDay) selectedDay.classList.add("selected");
    dataInput.value = selectedDate.toISOString().split('T')[0]; // Formata a data para o input
  };

  const generateTimeOptions = () => {
    for (let hour = 11; hour <= 21; hour++) {
      const timeBtn = document.createElement("button");
      timeBtn.textContent = `${hour}:00`;
      timeBtn.type = "button"; // Para evitar o submit do formulário ao clicar
      timeBtn.addEventListener("click", () => selectTime(timeBtn));
      horariosContainer.appendChild(timeBtn);
    }
  };

  const selectTime = (btn) => {
    const timeButtons = horariosContainer.querySelectorAll("button");
    timeButtons.forEach(button => button.classList.remove("selected"));
    btn.classList.add("selected");
    selectedTime = btn.textContent;
    horaInput.value = selectedTime; // Preenche o input oculto
  };

  const selectCapacity = (btn) => {
    capacidadesButtons.forEach(button => button.classList.remove("selected"));
    btn.classList.add("selected");
    selectedCapacity = btn.getAttribute("data-capacidade");
    capacidadeInput.value = selectedCapacity; // Preenche o input oculto
  };

  prevMonthBtn.addEventListener("click", () => {
    if (currentMonth === 0) {
      currentMonth = 11;
      currentYear -= 1;
    } else {
      currentMonth -= 1;
    }
    renderCalendar();
  });

  nextMonthBtn.addEventListener("click", () => {
    if (currentMonth === 11) {
      currentMonth = 0;
      currentYear += 1;
    } else {
      currentMonth += 1;
    }
    renderCalendar();
  });

  capacidadesButtons.forEach(button => {
    button.addEventListener("click", () => selectCapacity(button));
  });

  reservarBtn.addEventListener("click", (e) => {
    if (!selectedDate || !selectedTime || !selectedCapacity) {
      e.preventDefault(); // Impede o envio do formulário se algo não estiver selecionado
      alert("Por favor, selecione a data, o horário e a capacidade da mesa.");
    }
  });

  renderCalendar();
  generateTimeOptions();
});
