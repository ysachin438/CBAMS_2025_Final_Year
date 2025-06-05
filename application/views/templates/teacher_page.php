<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? $title : 'Dashboard' ?></title>
    <link rel="stylesheet" href="<?= base_url('assets/css/main.css'); ?>">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins&display=swap">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/layout.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/header.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/main.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/sidebar.css'); ?>">
    <script src="<?php echo base_url('assets/js/sidebar.js'); ?>" defer></script>

</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <!--begin::App Wrapper-->
    <div class="app-wrapper">
        <?php $this->load->view('layouts/teacher/header'); ?>
        <?php $this->load->view('layouts/teacher/sidebar'); ?>
        <?php $this->load->view(isset($view) ? $view : 'index', $data); ?>

        <?php $this->load->view('layouts/teacher/footer'); ?>
    </div>

</body>

</html>