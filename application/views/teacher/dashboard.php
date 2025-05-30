<style>
  .dashboard-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 1.5rem;
    padding: 2rem;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  }

  .dashboard-card {
    background: rgba(251, 219, 147, 0.2);
    /* Light Yellow Transparent */
    backdrop-filter: blur(10px);
    border: 1px solid #FBDB93;
    border-radius: 20px;
    padding: 1.2rem 1.5rem;
    color: #641B2E;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.07);
    font-size: 0.92rem;
    line-height: 1.4;
  }

  .badge-count {
    display: inline-block;
    padding: 3px 8px;
    font-size: 0.8rem;
    font-weight: 500;
    border-radius: 12px;
    margin-right: 0.6rem;
  }


  .dashboard-card h5 {
    font-weight: 600;
    color: #8A2D3B;
    margin-bottom: 0.5rem;
    font-size: 1rem;
  }

  .card-highlight {
    font-size: 1.5rem;
    font-weight: 600;
    color: #BE5B50;
    margin-top: 0.5rem;
  }

  .list-item {
    margin: 0.25rem 0;
    font-size: 0.9rem;
    color: #641B2E;
  }

  .icon-circle {
    width: 36px;
    height: 36px;
    background-color: #BE5B50;
    border-radius: 50%;
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 0.6rem;
    font-size: 1rem;
  }

  .card-header-icon {
    display: flex;
    align-items: center;
    margin-bottom: 0.7rem;
  }

  .dashboard-card p,
  .dashboard-card ul {
    margin-bottom: 0.3rem;
  }
</style>

<div class="dashboard-container">
  <!-- Card 1: Recent Class Attendance -->
  <?php if (!empty($recent_attendance)): ?>
    <div class="dashboard-card">
      <div class="card-header-icon">
        <div class="icon-circle"><i class="bi bi-person-check-fill"></i></div>
        <h5>Recent Class Attendance</h5>
      </div>
      <p>Subject: <strong><?= $recent_attendance['subject_name'] ?></strong></p>
      <p>Class: <?= $recent_attendance['class_name'] ?></p>
      <p>Date: <strong><?= date('d M Y', strtotime($recent_attendance['date'])) ?></strong></p>
      <div style="margin-top: 0.7rem;">
        <span class="badge-count" style="background-color: #d1e7dd; color: #0f5132;">
          ✔ Present: <?= $recent_attendance['present_count'] ?>
        </span>
        <span class="badge-count" style="background-color: #f8d7da; color: #842029;">
          ✘ Absent: <?= $recent_attendance['absent_count'] ?>
        </span>
      </div>
    </div>
  <?php else: ?>
    <div class="dashboard-card">
      <h5>No attendance records yet.</h5>
    </div>
  <?php endif; ?>


  <!-- Card 2: Upcoming Schedule -->
  <div class="dashboard-card">
    <div class="card-header-icon">
      <div class="icon-circle"><i class="bi bi-calendar-event-fill"></i></div>
      <h5>Upcoming Schedule</h5>
    </div>
    <ul class="list-unstyled">
      <li class="list-item">📚 OOP Class - 24 May, 10:00 AM</li>
      <li class="list-item">🧪 DBMS Lab - 24 May, 2:00 PM</li>
      <li class="list-item">📝 Mid-Term Exam - 27 May</li>
    </ul>
  </div>

  <!-- Card 3: Students and Courses -->
  <div class="dashboard-card">
    <div class="card-header-icon">
      <div class="icon-circle"><i class="bi bi-people-fill"></i></div>
      <h5>My Students</h5>
    </div>
    <p>Total Students: <strong>120</strong></p>
    <p>Courses Handled: <strong>4</strong></p>
    <p>Labs: <strong>2</strong></p>
  </div>

  <!-- Card 4: Notifications -->
  <div class="dashboard-card">
    <div class="card-header-icon">
      <div class="icon-circle"><i class="bi bi-bell-fill"></i></div>
      <h5>Notifications</h5>
    </div>
    <ul class="list-unstyled">
      <li class="list-item">⚠️ Attendance pending for 21 May</li>
      <li class="list-item">📌 New exam guidelines uploaded</li>
      <li class="list-item">📣 Staff meeting at 5 PM today</li>
    </ul>
  </div>
</div>