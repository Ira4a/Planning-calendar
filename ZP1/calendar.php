<?php
  $searchDate = isset($_GET['search']) ? $_GET['search'] : null;
?>
<!DOCTYPE html>
<html lang="cs">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Calendar</title>
  <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300..700;1,300..700&display=swap" rel="stylesheet">
  <style>
        body {
          margin: 0;
          padding: 0;
          display: flex;
          justify-content: center;
          align-items: center;
          height: 100%;
          background-color: #f4f4f9;
          font-family: "Cormorant Garamond", serif;
          font-size: 20px;
          font-weight: 500;
          font-style: normal;
          overflow: hidden;
        }
        nav .bar {
          font-size: 50px;
          display: block;
          color: yellow;
          position: absolute;
          top: 0;
          left: 0;
          cursor: pointer;
          padding: 15px;
          transition: ease 600ms;
        }
	nav ul li {
	  list-style-type: none;
	}
        nav ul {
          background-color: #e6e6e6;
          box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
          padding: 15px;
          margin: 0;
          position: absolute;
          display: block;
          left: 0;
          top: -110%;
          width: 15%;
          height: 100%;
          z-index: 10; 
          transition: linear top 1s; 
        }
        nav:hover ul {
          top: 0;
        }
        nav ul a {
          font-size: 23px;
          color: #e6e600; 
          transition: ease 500ms;
        }
        nav ul a:hover {
          color: blue;
        }
        nav ul #user-name {
          display: block; 
          margin-top: 13px; 
          color: green;
          font-weight: 600;
        }
        nav form {
          margin-top: 20px;
        } 
        nav form input {
          width: 90%; 
          padding: 5px;
          outline: none;
	  border: 2px solid yellow;
	  border-radius: 10px;
	  background: transparent;
	  color: green;
        }
        nav form button {
          margin-top: 10px; 
          width: 90%;
          border: 2px solid yellow;
          border-radius: 15px;
          cursor: pointer;
          background: transparent;
          font-family: "Cormorant Garamond", serif;
          font-size: 15px;
          font-weight: 600;
          color: green;
          transition: ease 500ms;
        }
        nav form button:hover {
          border-color: blue;
          font-size: 20px;
          color: #e6e600;
        }
         #calendarDates div.highlight {
          border: 3px solid yellow !important;
        }
        #exit-but {
          position: absolute;
          bottom: 40px;
          left: 35px;
          background: transparent;
          padding: 10px 35px;
          border: 2px solid yellow;
          border-radius: 15px;
          cursor: pointer;
          font-family: "Cormorant Garamond", serif;
          font-size: 15px;
          font-weight: 600;
          color: green;
          transition: ease 500ms;
        }
        #exit-but:hover {
          border-color: blue;
          font-size: 20px;
          color: #e6e600;
        }
        .calendar {
          width: 100%;
          max-width: 800px;
          padding: 20px;
          background: white;
          border-radius: 10px;
          box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        .calendar-header {
          display: flex;
          justify-content: space-between;
          align-items: center;
          margin-bottom: 20px;
        }
        h2 {
          font-size: 40px;
        }
	#monthYear {
	  color: #4da6ff;
	}
        .calendar-header button {
          background: transparent;
          border: 2px solid #111;
          border-radius: 50px;
          font-size: 20px;
          cursor: pointer;
        }
        .calendar-days {
          display: grid;
          grid-template-columns: repeat(7, 1fr);
          margin-bottom: 10px;
          text-align: center;
          font-weight: bold;
          font-size: 20px;
        }
        #calendarDates {
          display: grid;
          grid-template-columns: repeat(7, 1fr);
          gap: 5px;
        }
        #calendarDates div {
          padding: 10px;
          background-color: #f0f0f0;
          border-radius: 5px;
          cursor: pointer;
          min-height: 60px;
          position: relative;
        }
        #calendarDates div.today {
          background-color: #ffeb3b;
        }
        #calendarDates div.has-event {
          background-color: #8bc34a;
          color: white;
        }
        #calendarDates div.searched-date {
          border: 2px solid yellow;
        }
        #eventList {
          position: absolute;
          right: 10px;
          top: 5px;
          max-width: 250px;
          max-height: 100vh;
          overflow-y: auto;
          overflow-x: hidden;
          scrollbar-width: thin;
          scroll-behavior: smooth;
          scrollbar-color: #ffeb3b #f4f4f9;
        }
        .event {
          background: #f2f2f2;
          padding: 10px;
          margin: 5px 0;
          border-radius: 5px;
          border: 1px solid #4da6ff;
          word-wrap: break-word;
          overflow-wrap: break-word;
        }
        button {
          outline: none;
        }
        #eventModal {
          display: none;
          position: fixed;
          top: 0;
          left: 0;
          width: 100%;
          height: 100%;
          background-color: rgba(0, 0, 0, 0.5);
          justify-content: center;
          align-items: center;
        }
        .modal-content {
          background: white;
          padding: 20px;
          border-radius: 5px;
          width: 300px;
        }
        .modal-content input,
        .modal-content textarea {
          width: 90%;
          margin-bottom: 10px;
          padding: 8px;
          resize: none;
          outline: none;
        }
        .modal-content button {
          padding: 8px 12px;
          margin-right: 5px;
          cursor: pointer;
          background: transparent;
          border: 1px solid yellow;
          color: green;
        }
        #deleteButton {
          background-color: red; 
          color: white; 
          display: none;
          border: 1px solid black;
        }
  </style>
</head>
<body>
  <nav>
    <span class="bar">
      <i class="fa fa-bars"></i>
    </span>
    <ul>
      <span id="user-name"></span>
      <form method="GET" action="calendar.php">
        <input type="date" name="search"required>
        <button type="submit">Hledat</button>
      </form>

      <button id="exit-but">Odhlásit</button>
    </ul>
  </nav>

  <div class="calendar">
    <div class="calendar-header">
      <button id="prevMonth">&lt;</button>
      <h2 id="monthYear"></h2>
      <button id="nextMonth">&gt;</button>
    </div>
    <div class="calendar-days">
      <div>Po</div>
      <div>Út</div>
      <div>St</div>
      <div>Čt</div>
      <div>Pá</div>
      <div>So</div>
      <div>Ne</div>
    </div>
    <div id="calendarDates"></div>
  </div>

  <div id="eventList"></div>

  <div id="eventModal">
    <div class="modal-content">
      <h3 id="modalTitle">Přidat událost</h3>
      <input type="text" id="eventTitle" placeholder="Název události"/>
      <textarea id="eventDescription" placeholder="Popis události"></textarea>
      <button onclick="addEvent()">+ Přidat</button>
      <button onclick="closeModal()">Zavřít</button>
      <button id="deleteButton" onclick="deleteEvent()">Smazat</button>
    </div>
  </div>

<script>
  // Získání data hledání z PHP (pokud existuje)
  const searchDateFromPHP = "<?php echo $searchDate ?? ''; ?>";

  // Tlačítko pro odhlášení uživatele
  document.getElementById('exit-but').onclick = function() {
    localStorage.removeItem('username'); // Odstranit uživatelské jméno z localStorage
    window.location.href = 'index.htm'; // Přesměrovat na přihlašovací stránku
  };

  // Kontrola, zda je uživatel přihlášen
  const user = localStorage.getItem('username');
  if (!user) window.location.href = 'index.htm'; // Přesměrovat, pokud není přihlášen
  document.getElementById('user-name').textContent = 'Uživatel: ' + user;

  // Výběr prvků DOM potřebných pro kalendář
  const monthYear = document.getElementById('monthYear');
  const calendarDates = document.getElementById('calendarDates');
  const eventList = document.getElementById('eventList');
  const eventModal = document.getElementById('eventModal');
  const eventTitle = document.getElementById('eventTitle');
  const eventDescription = document.getElementById('eventDescription');
  const deleteButton = document.getElementById('deleteButton');

  // Inicializace dat
  let currentDate = new Date();
  let currentMonth = currentDate.getMonth();
  let currentYear = currentDate.getFullYear();
  let currentEventDate = null;
  let currentEvent = null;
  let events = JSON.parse(localStorage.getItem(`events_${user}`)) || [];

  // Pokud bylo zadáno hledané datum, nastavíme odpovídající měsíc a rok
  if (searchDateFromPHP) {
    const target = new Date(searchDateFromPHP);
    currentMonth = target.getMonth();
    currentYear = target.getFullYear();
  }

  // Otevření modálního okna pro přidání nebo úpravu události
  function openModal(date, event = null) {
    currentEventDate = date;
    currentEvent = event;

    eventTitle.value = event ? event.title : '';
    eventDescription.value = event ? event.description : '';
    deleteButton.style.display = event ? 'inline-block' : 'none';

    eventModal.style.display = 'flex';
  }

  // Přidání nové události
  function addEvent() {
    const title = eventTitle.value.trim();
    const description = eventDescription.value.trim();
    if (!title) return alert('Prosím, zadejte název události.');

    events.push({ date: currentEventDate, title, description });
    localStorage.setItem(`events_${user}`, JSON.stringify(events));
    closeModal();
    renderCalendar();
    showEventsForDate(currentEventDate);
  }

  // Zavření modálního okna
  function closeModal() {
    eventModal.style.display = 'none';
  }

  // Smazání existující události
  function deleteEvent() {
    if (!currentEvent) return;
    events = events.filter(event => event !== currentEvent);
    localStorage.setItem(`events_${user}`, JSON.stringify(events));
    closeModal();
    renderCalendar();
    showEventsForDate(currentEvent.date);
  }

  // Zobrazení kalendáře pro aktuální měsíc
  function renderCalendar() {
    calendarDates.innerHTML = '';
    const firstDay = new Date(currentYear, currentMonth, 1).getDay();
    const lastDate = new Date(currentYear, currentMonth + 1, 0).getDate();
    const today = new Date();
    const firstDayIndex = (firstDay + 6) % 7; // Přesun na pondělí jako první den

    // Prázdné buňky před prvním dnem měsíce
    for (let i = 0; i < firstDayIndex; i++) calendarDates.appendChild(document.createElement('div'));

    // Generování jednotlivých dnů měsíce
    for (let day = 1; day <= lastDate; day++) {
      const date = new Date(currentYear, currentMonth, day);
      const dateString = `${date.getFullYear()}-${String(date.getMonth()+1).padStart(2, '0')}-${String(date.getDate()).padStart(2, '0')}`;

      const dayDiv = document.createElement('div');
      dayDiv.textContent = day;

      // Zvýraznění dnešního dne
      if (
        date.getDate() === today.getDate() &&
        date.getMonth() === today.getMonth() &&
        date.getFullYear() === today.getFullYear()
      ) {
        dayDiv.classList.add('today');
      }

      // Zvýraznění dní s událostmi
      if (events.some(event => event.date === dateString)) {
        dayDiv.classList.add('has-event');
      }

      // Zvýraznění hledaného dne z PHP
      if (searchDateFromPHP && dateString === searchDateFromPHP) {
        dayDiv.classList.add('highlight');
        showEventsForDate(dateString);
      }

      // Kliknutí na den otevře modální okno s událostí
      dayDiv.onclick = () => {
        const dayEvents = events.filter(event => event.date === dateString);
        currentEvent = dayEvents[0] || null;
        openModal(dateString, currentEvent);
        showEventsForDate(dateString);
      };

      calendarDates.appendChild(dayDiv);
    }

    // Zobrazení názvu měsíce a roku
    const monthNames = [
      'Leden', 'Únor', 'Březen', 'Duben', 'Květen', 'Červen',
      'Červenec', 'Srpen', 'Září', 'Říjen', 'Listopad', 'Prosinec'
    ];
    monthYear.textContent = `${monthNames[currentMonth]} ${currentYear}`;
  }

  // Zobrazení seznamu událostí pro daný den
  function showEventsForDate(dateString) {
    const dayEvents = events.filter(event => event.date === dateString);
    eventList.innerHTML = '';
    if (dayEvents.length === 0) {
      eventList.innerHTML = '<p>Žádné události</p>';
      return;
    }

    // Vykreslení jednotlivých událostí
    dayEvents.forEach(event => {
      const eventDiv = document.createElement('div');
      eventDiv.classList.add('event');
      eventDiv.innerHTML = `<strong>${event.title}</strong><p>${event.description}</p>`;
      eventDiv.onclick = () => openModal(event.date, event);
      eventList.appendChild(eventDiv);
    });
  }

  // Přechod na předchozí měsíc
  document.getElementById('prevMonth').onclick = () => {
    currentMonth--;
    if (currentMonth < 0) {
      currentMonth = 11;
      currentYear--;
    }
    renderCalendar();
    eventList.innerHTML = '';
  };

  // Přechod na další měsíc
  document.getElementById('nextMonth').onclick = () => {
    currentMonth++;
    if (currentMonth > 11) {
      currentMonth = 0;
      currentYear++;
    }
    renderCalendar();
    eventList.innerHTML = '';
  };

  // Zavření modálního okna kliknutím mimo něj
  window.onclick = (event) => {
    if (event.target === eventModal) closeModal();
  };

  renderCalendar();
</script>
</body>
</html>
