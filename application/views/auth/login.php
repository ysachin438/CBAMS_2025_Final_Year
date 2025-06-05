<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Select Role - Attendance System</title>
  <link rel="stylesheet" href="<?= base_url('assets/css/role_select.css'); ?>">
</head>
<body>
  <div class="background-image"></div>
  <?php if ($this->session->flashdata('toast_message')): ?>
        <div class="toast toast-<?= $this->session->flashdata('toast_type'); ?>">
            <?= $this->session->flashdata('toast_message'); ?>
        </div>
    <?php endif; ?>
  <div class="overlay-card">
    <h2>Select Your Role</h2>
    <div class="role-options">
      <a href="<?= base_url('index.php/student/index'); ?>" class="role-btn student">Student</a>
      <a href="<?= site_url('teacher/index'); ?>" class="role-btn teacher">Teacher</a>
      <a href="<?= base_url('index.php/admin/login'); ?>" class="role-btn admin">Admin</a>
    </div>
  </div>
</body>
</html>
