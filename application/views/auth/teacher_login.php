<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Teacher Login</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins&display=swap">
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
  <?php if ($this->session->flashdata('error')): ?>
    <div class="error-message"><?= $this->session->flashdata('error'); ?></div>
  <?php endif; ?>

  <form method="post" action="<?= base_url('index.php/teacher/authenticate') ?>">
    <div class="form-group">
      <label for="username">Employee ID</label>
      <input type="text" id="employee_id" name="employee_id" required placeholder="Enter employee ID">
    </div>

    <div class="form-group">
      <label for="password">Password</label>
      <input type="password" id="password" name="password" required placeholder="Enter password">
    </div>

    <input type="submit" value="Login">
  </form>

  <div class="footer">
    &copy; <?= date("Y") ?> Cloud Attendance System
  </div>
</div>

</body>
</html>
