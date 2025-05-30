<div class="main-content">
  <h2>View Attendance</h2>

  <form method="get" action="<?= site_url('attendance/view_report') ?>">
    <label for="class">Select Class:</label>
    <select name="class_id" id="class" required>
      <option value="">-- Select Class --</option>
      <!-- Load classes dynamically -->
    </select>

    <label for="class">Select Subject:</label>
    <select name="class_id" id="class" required>
      <option value="">-- Select Subject --</option>
      <!-- Load classes dynamically -->
    </select>

    <label for="from">From:</label>
    <input type="date" name="from_date" required>

    <label for="to">To:</label>
    <input type="date" name="to_date" required>

    <button type="submit">View Report</button>
  </form>

  <div class="report-section">
    <h3>Attendance Report</h3>

    <table border="1">
      <thead>
        <tr>
          <th>Student Name</th>
          <th>Present Days</th>
          <th>Absent Days</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($report_data as $row): ?>
          <tr>
            <td><?= @$row['name'] ?></td>
            <td><?= @$row['present'] ?></td>
            <td><?= @$row['absent'] ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

    <button onclick="exportCSV()">Export CSV</button>
    <button onclick="window.print()">Export PDF</button>
  </div>
</div>