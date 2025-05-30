<div class="container my-4">
  <h3 class="mb-3 text-dark">📅 Mark Attendance</h3>

  <form method="post" action="<?= site_url('teacher/submit_attendance') ?>">
    <div class="row mb-3">
      <div class="col-md-4">
        <label class="form-label">Select Date</label>
        <input type="date" name="date" class="form-control" required>
      </div>

      <div class="col-md-4">
        <label class="form-label">Select Class</label>
        <select name="class_id" class="form-select" required>
          <option value="">-- Select Class --</option>
          <?php foreach ($classes as $class): ?>
            <option value="<?= $class->id ?>"><?= $class->name ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="col-md-4">
        <label class="form-label">Select Subject</label>
        <select name="subject_id" class="form-select" required>
          <option value="">-- Select Subject --</option>
          <?php foreach ($subjects as $subject): ?>
            <option value="<?= $subject->id ?>"><?= $subject->name ?></option>
          <?php endforeach; ?>
        </select>
      </div>
    </div>

    <div class="card p-3 shadow-sm rounded" style="background: rgba(255,255,255,0.85);">
      <h5 class="text-dark mb-3">Student List</h5>
      <table class="table table-bordered table-hover bg-white">
        <thead class="table-dark text-center">
          <tr>
            <th>Roll No</th>
            <th>Name</th>
            <th>Mark Attendance</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($students as $student): ?>
            <tr>
              <td><?= $student->roll_no ?></td>
              <td><?= $student->name ?></td>
              <td class="text-center">
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="attendance[<?= $student->id ?>]" value="Present" checked>
                  <label class="form-check-label text-success small">✔️ Present</label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="attendance[<?= $student->id ?>]" value="Absent">
                  <label class="form-check-label text-danger small">❌ Absent</label>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

    <div class="text-end mt-3">
      <button type="submit" class="btn btn-primary px-4 py-2" style="background-color: #BE5B50; border: none;">
        ✅ Submit Attendance
      </button>
    </div>
  </form>
</div>
