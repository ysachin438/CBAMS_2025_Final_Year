<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Teacher Loginjjj</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins&display=swap">
  <!-- Toastr CSS -->
<link rel="stylesheet" href="<?= base_url('assets/toastr/toastr.min.css') ?>">

  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #FBDB93;
      margin: 0;
      padding: 0;
    }

    .login-container {
      width: 100%;
      max-width: 400px;
      margin: 80px auto;
      background-color: #fff;
      border-radius: 12px;
      box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
      padding: 30px;
      border-top: 8px solid #641B2E;
    }

    .login-container h2 {
      color: #641B2E;
      text-align: center;
      margin-bottom: 20px;
    }

    .form-group {
      margin-bottom: 18px;
    }

    label {
      display: block;
      color: #641B2E;
      margin-bottom: 6px;
      font-weight: 500;
    }

    input[type="text"], input[type="password"] {
      width: 100%;
      padding: 10px;
      border: 1px solid #8A2D3B;
      border-radius: 8px;
      font-size: 14px;
      outline: none;
    }

    input[type="submit"] {
      background-color: #BE5B50;
      color: #fff;
      padding: 10px 20px;
      border: none;
      width: 100%;
      font-size: 16px;
      border-radius: 8px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    input[type="submit"]:hover {
      background-color: #8A2D3B;
    }

    .footer {
      margin-top: 20px;
      text-align: center;
      font-size: 13px;
      color: #444;
    }

    .error-message {
      color: red;
      font-size: 13px;
      margin-bottom: 10px;
    }
  </style>
</head>
<body>

<div class="login-container">
  <h2>Teacher Login</h2>
  <form method="post" action="<?= base_url('index.php/teacher/authenticate') ?>">
    <div class="form-group">
      <label for="username">Employee ID</label>
      <input type="text" id="employee_id" name="employee_id" value="<?= set_value('employee_id');?>" required placeholder="Enter employee ID">
      <?= form_error('employee_id', '<div class="text-danger">', '</div>'); ?>
    </div>

    <div class="form-group">
      <label for="password">Password</label>
      <input type="password" id="password" name="password" value="<?= set_value('password');?>" required placeholder="Enter password">
      <?= form_error('password', '<div class="text-danger">', '</div>'); ?>
    </div>

    <input type="submit" value="Login">
  </form>

  <div class="footer">
    &copy; <?= date("Y") ?> Cloud Attendance System
  </div>
</div>
<!-- T O A S T E R -->
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Toastr JS -->
<script src="<?= base_url('assets/toastr/toastr.min.js') ?>"></script>
<!-- TOASTER-->
<?php if ($this->session->flashdata('error')): ?>
    <script>
        toastr.error("<?= $this->session->flashdata('error'); ?>");
    </script>
<?php endif; ?>
</body>
</html>
