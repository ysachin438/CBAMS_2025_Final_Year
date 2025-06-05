<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Student Login</title>
  <link rel="stylesheet" href="<?= base_url('assets/css/student-login.css') ?>">
</head>
<body>
  <div class="login-wrapper">
    <div class="login-box">
      <h2>Student Login</h2>

      <?php if ($this->session->flashdata('error')): ?>
        <p class="error"><?php $this->session->flashdata('error'); ?></p>
      <?php endif; ?>

      <form action="<?= site_url('student/authenticate') ?>" method="post">
        
        <label for="roll_no">Roll Number</label>
        <input type="text" name="roll_no" placeholder="Enter Roll Number" required />

        <label for="password">Password</label>
        <input type="password" name="password" placeholder="Enter Password" required />

        <button type="submit">Login</button>
      </form>
    </div>
  </div>
</body>
</html>
