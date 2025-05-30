<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>View Attendance Calendar</title>
<!-- Bootstrap CSS CDN -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
<link rel="stylesheet" href="<?= base_url('assets/css/main.css'); ?>">
<style>
  :root {
    --color-yellow: #FBDB93;
    --color-salmon: #BE5B50;
    --color-deep-red: #8A2D3B;
    --color-maroon: #641B2E;
    --color-green: #4CAF50;
  }

  body {
    background: #fff8e1;
    color: var(--color-maroon);
  }

  header, footer {
    background-color: var(--color-maroon);
    color: var(--color-yellow);
    padding: 1rem 2rem;
    text-align: center;
    font-weight: bold;
  }

  .card {
    border-radius: 10px;
    box-shadow: 0 3px 8px rgb(0 0 0 / 0.15);
    border: none;
  }

  .card.attendance-percent {
    background-color: var(--color-green);
    color: white;
  }

  .card.classes-count {
    background-color: var(--color-deep-red);
    color: var(--color-yellow);
  }

  .calendar-container {
    max-width: 700px;
    margin: 1.5rem auto 3rem auto;
    padding: 1rem;
    border: 2px solid var(--color-maroon);
    border-radius: 12px;
    background: white;
  }

  /* Calendar styling similar to previous example */
  table.calendar {
    width: 100%;
    border-collapse: collapse;
  }

  table.calendar th {
    background-color: var(--color-maroon);
    color: var(--color-yellow);
    padding: 0.6rem 0;
  }

  table.calendar td {
    width: 14.28%;
    height: 80px;
    text-align: center;
    vertical-align: middle;
    border: 1px solid #ddd;
    cursor: default;
    user-select: none;
    transition: background-color 0.3s ease;
  }

  .present {
    background-color: var(--color-green);
    color: white;
  }

  .absent {
    background-color: var(--color-salmon);
    color: white;
  }

  .holiday {
    background-color: var(--color-deep-red);
    color: var(--color-yellow);
  }

  .halfday {
    background-color: var(--color-yellow);
    color: black;
  }

  table.calendar td[data-tooltip]:hover::after {
    content: attr(data-tooltip);
    position: absolute;
    bottom: 100%;
    left: 50%;
    transform: translateX(-50%);
    background-color: var(--color-maroon);
    color: var(--color-yellow);
    padding: 4px 8px;
    border-radius: 6px;
    white-space: nowrap;
    font-size: 0.85rem;
    pointer-events: none;
    opacity: 0.9;
    z-index: 10;
  }
</style>
</head>
<body>
   <nav class="navbar">
    <div class="logo">Student Dashboard</div>
    <ul>
      <li><a href="#">Home</a></li>
      <li><a href="#">Attendance</a></li>
      <li><a href="#">Results</a></li>
      <li><a href="#">Logout</a></li>
    </ul>
  </nav>
<main class="container my-4">

  <!-- Top Cards -->
  <div class="row mb-4 justify-content-center gap-3">
    <div class="col-md-4 col-sm-6">
      <div class="card attendance-percent text-center p-4">
        <h5>Current Attendance %</h5>
        <h2 id="attendancePercent">85%</h2>
      </div>
    </div>
    <div class="col-md-4 col-sm-6">
      <div class="card classes-count text-center p-4">
        <h5>Total Classes / Attended</h5>
        <h2 id="classesCount">30 / 28</h2>
      </div>
    </div>
  </div>

  <!-- Calendar -->
  <div class="calendar-container">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <button class="btn btn-outline-maroon" id="prev-month">&#8592;</button>
      <div id="month-year" style="font-weight: bold; font-size: 1.3rem; color: var(--color-maroon)"></div>
      <button class="btn btn-outline-maroon" id="next-month">&#8594;</button>
    </div>
    <table class="calendar" id="calendar">
      <thead>
        <tr>
          <th>Sun</th><th>Mon</th><th>Tue</th><th>Wed</th><th>Thu</th><th>Fri</th><th>Sat</th>
        </tr>
      </thead>
      <tbody></tbody>
    </table>
  </div>

</main>

<footer>
  &copy; 2025 Attendance System
</footer>

<script>
  // For button style
  const style = document.createElement('style');
  style.innerHTML = `
    .btn-outline-maroon {
      color: var(--color-maroon);
      border: 2px solid var(--color-maroon);
      background: transparent;
      border-radius: 6px;
      padding: 0.3rem 0.8rem;
      font-size: 1.2rem;
      cursor: pointer;
      user-select: none;
      transition: all 0.3s ease;
    }
    .btn-outline-maroon:hover {
      background-color: var(--color-maroon);
      color: var(--color-yellow);
    }
  `;
  document.head.appendChild(style);

  // Sample attendance data - Replace with backend data
  const attendanceData = {
    "2025-05-01": "holiday",
    "2025-05-02": "present",
    "2025-05-03": "absent",
    "2025-05-04": "halfday",
    "2025-05-05": "present",
    "2025-05-07": "present",
    "2025-05-12": "absent",
    "2025-05-15": "holiday",
    "2025-05-20": "halfday",
    "2025-05-23": "present",
  };

  let today = new Date();
  let currentMonth = today.getMonth();
  let currentYear = today.getFullYear();

  const monthYearEl = document.getElementById("month-year");
  const calendarBody = document.getElementById("calendar").getElementsByTagName("tbody")[0];
  const prevBtn = document.getElementById("prev-month");
  const nextBtn = document.getElementById("next-month");

  function daysInMonth(month, year) {
    return new Date(year, month + 1, 0).getDate();
  }

  function renderCalendar(month, year) {
    calendarBody.innerHTML = "";

    const monthNames = ["January", "February", "March", "April", "May", "June",
                        "July", "August", "September", "October", "November", "December"];
    monthYearEl.textContent = `${monthNames[month]} ${year}`;

    const firstDay = new Date(year, month, 1).getDay();
    const totalDays = daysInMonth(month, year);

    let date = 1;
    for(let i = 0; i < 6; i++) {
      let row = document.createElement("tr");

      for(let j = 0; j < 7; j++) {
        if(i === 0 && j < firstDay) {
          let cell = document.createElement("td");
          cell.textContent = "";
          row.appendChild(cell);
        } else if(date > totalDays) {
          let cell = document.createElement("td");
          cell.textContent = "";
          row.appendChild(cell);
        } else {
          let cell = document.createElement("td");
          let fullDate = `${year}-${String(month + 1).padStart(2,'0')}-${String(date).padStart(2,'0')}`;
          cell.textContent = date;

          if(date === today.getDate() && month === today.getMonth() && year === today.getFullYear()) {
            cell.style.border = "2px solid var(--color-salmon)";
            cell.style.fontWeight = "bold";
          }

          let status = attendanceData[fullDate];
          if(status) {
            cell.classList.add(status);
            cell.setAttribute("data-tooltip", status.charAt(0).toUpperCase() + status.slice(1));
          }

          row.appendChild(cell);
          date++;
        }
      }
      calendarBody.appendChild(row);
    }
  }

  prevBtn.onclick = () => {
    currentMonth--;
    if(currentMonth < 0) {
      currentMonth = 11;
      currentYear--;
    }
    renderCalendar(currentMonth, currentYear);
  };

  nextBtn.onclick = () => {
    currentMonth++;
    if(currentMonth > 11) {
      currentMonth = 0;
      currentYear++;
    }
    renderCalendar(currentMonth, currentYear);
  };

  // Initial render
  renderCalendar(currentMonth, currentYear);

</script>

</body>
</html>
