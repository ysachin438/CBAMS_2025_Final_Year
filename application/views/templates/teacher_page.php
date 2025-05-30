<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? $title : 'Dashboard' ?></title>
    <link rel="stylesheet" href="<?= base_url('assets/css/main.css'); ?>">
</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <!-- Toast Message Box -->
    <?php if ($this->session->flashdata('toast_message')): ?>
        <div class="toast toast-<?= $this->session->flashdata('toast_type'); ?>">
            <?= $this->session->flashdata('toast_message'); ?>
        </div>
    <?php endif; ?>

    <!--begin::App Wrapper-->
    <div class="app-wrapper">
        <?php $this->load->view('layouts/teacher/header'); ?>
        <?php $this->load->view('layouts/teacher/sidebar'); ?>
        <?php $this->load->view(isset($view) ? $view : 'index', $data); ?>
        
        <?php $this->load->view('layouts/teacher/footer'); ?>

</body>

</html>