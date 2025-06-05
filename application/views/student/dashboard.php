<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Student Dashboard</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
  <link rel="stylesheet" href="<?= base_url('assets/css/main.css'); ?>">
  
  <link rel="stylesheet" href="">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    :root {
      --light-yellow: #FBDB93;
      --salmon-red: #BE5B50;
      --deep-red: #8A2D3B;
      --dark-maroon: #641B2E;
    }

    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background-color: var(--light-yellow);
      color: var(--dark-maroon);
    }

    .navbar {
      background-color: var(--deep-red);
      color: white;
      padding: 15px 30px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .navbar .logo {
      font-size: 22px;
      font-weight: bold;
    }

    .navbar ul {
      list-style: none;
      display: flex;
      gap: 20px;
    }

    .navbar ul li a {
      color: white;
      text-decoration: none;
      font-weight: 500;
    }

    .container {
      padding: 30px;
    }

    .card-wrapper {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
      margin-bottom: 30px;
    }

    .card {
      background-color: #fff6e2;
      border-left: 6px solid var(--salmon-red);
      border-radius: 10px;
      padding: 20px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      flex: 1;
      min-width: 300px;
    }

    /* .student-photo {
      width: 100px;
      height: 100px;
      border-radius: 50%;
      border: 3px solid var(--dark-maroon);
      object-fit: cover;
      margin-bottom: 10px;
    }

    .student-info h3 {
      margin: 0;
      color: var(--deep-red);
    }

    .student-info p {
      margin: 4px 0;
    } */

    .card.student-info {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 20px;
      background-color: #fff6e2;
      border-left: 6px solid var(--salmon-red);
      border-radius: 10px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      gap: 30px;
      flex-wrap: wrap;
      /* makes it responsive on smaller screens */
    }

    .card.student-info .student-details {
      flex: 1;
    }

    .card.student-info .student-photo {
      width: 120px;
      height: 120px;
      border-radius: 50%;
      border: 4px solid var(--dark-maroon);
      object-fit: cover;
      flex-shrink: 0;
    }
    

    /* Color Variables */
    :root {
      --light-yellow: #FBDB93;
      --salmon-red: #BE5B50;
      --deep-red: #8A2D3B;
      --dark-maroon: #641B2E;
    }

    :root {
      --light-yellow: #FBDB93;
      --salmon-red: #BE5B50;
      --deep-red: #8A2D3B;
      --dark-maroon: #641B2E;
    }

    .streak-card {
      background-color: var(--light-yellow);
      background-color: #fff6e2;
      padding: 20px;
      border-radius: 15px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      text-align: center;
    }

    .streak-icon {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100px;
    }

    .streak-icon i {
      font-size: 50px;
      color: var(--salmon-red);
      animation: flicker 1.5s infinite;
    }

    .streak-current {
      font-size: 24px;
      font-weight: bold;
      color: var(--dark-maroon);
      margin-top: 10px;
    }

    .streak-longest {
      font-size: 18px;
      color: var(--deep-red);
      margin-top: 5px;
    }

    /* Fire Flicker Animation */
    @keyframes flicker {

      0%,
      100% {
        opacity: 1;
        transform: scale(1);
      }

      50% {
        opacity: 0.7;
        transform: scale(1.1);
      }
    }
    .dashboard-buttons {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
    }

    .dashboard-buttons button {
      background-color: var(--salmon-red);
      color: white;
      border: none;
      padding: 15px 25px;
      font-size: 16px;
      font-weight: bold;
      border-radius: 8px;
      cursor: pointer;
      transition: 0.3s ease;
    }

    .dashboard-buttons button:hover {
      background-color: var(--dark-maroon);
    }

    .footer {
      background-color: var(--dark-maroon);
      color: var(--light-yellow);
      text-align: center;
      padding: 12px 0;
      margin-top: 40px;
    }

    @media (max-width: 768px) {
      .card-wrapper {
        flex-direction: column;
      }

      .dashboard-buttons {
        flex-direction: column;
      }
    }
  </style>
</head>
<script>
  function animateCounter(id, endValue, speed = 30) {
    let count = 0;
    const counter = document.getElementById(id);
    if (!counter) return; // safety check

    const interval = setInterval(() => {
      counter.textContent = count;
      if (count >= endValue) {
        clearInterval(interval);
      }
      count++;
    }, speed);
  }

  // Animate both counters separately
  animateCounter("current-streak", 7, 50);
  animateCounter("longest-streak", 18, 50);
</script>


<body>
  <?php if ($this->session->flashdata('toast_message')): ?>
    <div class="toast toast-<?= $this->session->flashdata('toast_type'); ?>">
      <?= $this->session->flashdata('toast_message'); ?>
    </div>
  <?php endif; ?>


  <nav class="navbar">
    <div class="logo">Student Dashboard</div>
    <ul>
      <li><a href="#">Home</a></li>
      <li><a href="#">Attendance</a></li>
      <li><a href="#">Results</a></li>
      <li><a href="<?php echo site_url('auth/logout')?>">Logout</a></li>
    </ul>
  </nav>

  <div class="container">

    <div class="card-wrapper">
      <!-- Student Info Card -->
      <div class="card student-info">
        <div class="student-details">
          <p><strong>Name:</strong> <?= $student['first_name'] . ' ' . $student['last_name']; ?></p>
          <p><strong>Roll No:</strong> <?= $student['roll_number']; ?></p>
          <p><strong>Father's Name:</strong> <?= $student['father_name']; ?></p>
          <p><strong>Course:</strong> <? @$student['course']; ?></p>
          <p><strong>Branch:</strong> <?= $student['branch']; ?></p>
          <p><strong>Year:</strong> <?= $student['current_year']; ?></p>
        </div>
        <img src="<?= $student['profile_link']; ?>" class="student-photo" alt="Student Photo">
      </div>




      <!-- Streak Card -->
      <div class="card streak-card">
        <div class="streak-icon">
          <i class="bi bi-fire flicker"></i>
        </div>
        <div class="streak-current">
          Current Streak: <span id="current-streak"><?= @$streak['current']; ?></span> days
        </div>
        <div class="streak-longest">
          Longest Streak: <span id="longest-streak"><?= @$streak['longest']; ?></span> days
        </div>
      </div>





      <!-- Attendance Graph Card -->
      <div class="card">
        <h4>Attendance Percentage</h4>
        <canvas id="attendanceChart" height="160"></canvas>
      </div>
    </div>

    <!-- Dashboard Action Buttons -->
    <div class="dashboard-buttons">
      <button onclick="location.href='attendance_calendar'">View Attendance Calendar</button>
      <button onclick="location.href='scheduled_classes'">Scheduled Classes</button>
      <button onclick="location.href='view_results'">View Results</button>
      <button onclick="location.href='upcoming_exams'">Upcoming Exams</button>
    </div>
  </div>

  <div class="footer">
    &copy; <?= date('Y'); ?> Cloud Attendance System. All rights reserved.
  </div>

  <!-- Chart JS Script -->
  <script>
    const weeklyData = <?= json_encode($attendance_graph); ?>;
    const ctx = document.getElementById('attendanceChart').getContext('2d');
    const attendanceChart = new Chart(ctx, {
      type: 'line',
      data: {
        labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
        datasets: [{
          label: 'Attendance %',
          data: weeklyData,
          fill: false,
          borderColor: '#641B2E',
          backgroundColor: '#BE5B50',
          tension: 0.3,
          pointBackgroundColor: '#FBDB93'
        }]
      },
      options: {
        scales: {
          y: {
            min: 0,
            max: 100,
            title: {
              display: true,
              text: 'Percentage'
            }
          }
        }
      }
    });
  </script>

</body>

</html>