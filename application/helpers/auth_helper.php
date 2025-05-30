<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

function check_student_login() {
    $CI =& get_instance();
    if (!$CI->session->userdata('is_logged_in')) {
        redirect('auth/index');
    }
}
