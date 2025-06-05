<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    // Load models, helpers, etc.
  }

  public function index()
  {
    // echo 'THis is auth controller';
    $this->load->view('auth/login');
  }
  public function logout()
  {
    // Destroy all session data
    $this->session->sess_destroy();

    // Optionally redirect to login page or home
    redirect(site_url('auth/index'));
  }
}
