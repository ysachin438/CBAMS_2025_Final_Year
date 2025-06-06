<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Teacher extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    // Load models, helpers, etc.
    $this->load->library('form_validation');
    $this->load->library('session');
    $this->load->helper('url');
    // Models are loaded below
    $this->load->model('Teacher_model');
    $this->load->model('Student_model');
     $this->load->model('Subject_model');
    $this->load->model('Class_model');
     $this->load->model('Attendance_model');
    $this->load->model('Schedule_model');
  }

  public function index()
  {
    die('Hello Man');
   $this->load->view('auth/teacher_login');
  }
  public function authenticate()
  {
    $this->form_validation->set_rules('employee_id', 'Employee ID', 'required|trim|alpha_numeric');
    $this->form_validation->set_rules('password', 'Password', 'required|trim');

    if ($this->form_validation->run() == FALSE) {
      // Validation failed, reload login view with errors
      $this->session->set_flashdata('error', validation_errors());
      $this->load->view('auth/teacher_login');
    } else {

      $employee_id = $this->input->post('employee_id', TRUE);
      $password = $this->input->post('password', TRUE);

      // Check credentials
      $teacher = $this->Teacher_model->verify_credentials($employee_id, $password);
      if ($teacher) {
        // Save session data
        $data = array(
          'teacher_id' => $teacher['teacher_id'],
          'employee_number' => $teacher['employee_number'],
          'teacher_name' => $teacher['first_name'] . ' ' . $teacher['last_name'],
          'teacher_email' => $teacher['email'],
          'user_role' => 'teacher',
          'is_logged_in' => TRUE
        );

        $this->session->set_userdata($data);
        redirect(site_url('teacher/dashboard'));
      } else {
        set_toast_message('error', 'Invalid Employee ID or Password.');
        redirect(site_url('teacher/index'));
      }
    }
  }
  public function dashboard()
  {
    $data['title'] = 'Teacher Dashboard';
    $data['view'] = 'teacher/dashboard';
    $data['data'] = '';
    $teacher_id = $this->session->userdata('teacher_id');
    $data['teacher'] = $this->Teacher_model->get_teacher($teacher_id);
    $data['recent_attendance'] = $this->Attendance_model->get_recent_by_teacher($teacher_id);
    $data['upcoming_schedule'] = $this->Schedule_model->get_upcoming_classes_by_teacher($teacher_id);
    // print_r($data['upcoming_schedule']);die('I died Here');
    $this->load->view('templates/teacher_page', $data);
  }

  public function get_mark_attendance()
  {
    $data['data'] = '';
    $data['title'] = 'Mark Attendance';
    $data['view'] = 'teacher/mark_attendance';
    $teacher_id = $this->session->userdata('teacher_id');
    $data['subjects'] = $this->Subject_model->get_by_teacher($teacher_id);
    $data['students'] = $this->Student_model->get_by_teacher($teacher_id);
    $data['classes'] = $this->Class_model->get_by_teacher($teacher_id);

    $this->load->view('templates/teacher_page', $data);
  }
  public function mark_attendance()
  {
    $this->form_validation->set_rules('attendance_date', 'Date', 'required');
    $this->form_validation->set_rules('subject_id', 'Subject', 'required');
    $this->form_validation->set_rules('student_id[]', 'Students', 'required');

    if ($this->form_validation->run() == FALSE) {
      redirect('teacher/mark_attendance');
    }

    $subject_id = $this->input->post('subject_id');
    $date = $this->input->post('attendance_date');
    $teacher_id = $this->session->userdata('teacher_id');

    $students = $this->input->post('student_id');
    $statuses = $this->input->post('status'); // status[student_id] =>  /absent/leave

    foreach ($students as $student_id) {
      $status = isset($statuses[$student_id]) ? $statuses[$student_id] : 'absent';

      $data = [
        'student_id' => $student_id,
        'teacher_id' => $teacher_id,
        'subject_id' => $subject_id,
        'attendance_date' => $date,
        'status' => $status
      ];

      $this->Attendance_model->insert_or_update($data); // custom method
    }

    set_toast_message('success', 'Attendance marked successfully.');
    redirect(site_url('teacher/mark_attendance'));
  }


  public function view_attendance()
  {
    $data['title'] = 'View Attendance';
    $data['view'] = 'teacher/view_attendance';
    $data['data'] = '';
    $teacher_id = $this->session->userdata('teacher_id');
    // Get filter parameters from GET request
    $class_id = $this->input->get('class_id') ?: null;
    $subject_id = $this->input->get('subject_id') ?: null;
    $start_date = $this->input->get('from_date') ?: null;
    $end_date = $this->input->get('to_date') ?: null;
    
    // Load data for filter dropdowns
    $data['classes'] = $this->Class_model->get_by_teacher($teacher_id);
    $data['subjects'] = $this->Subject_model->get_by_teacher($teacher_id);

    // Fetch attendance data based on filters
    $data['report_data'] = $this->Attendance_model->get_attendance_by_class_n_teacher($teacher_id, $class_id, $subject_id, $start_date, $end_date);
    
    // Pass current filter values to the view to repopulate filter fields
    $data['selected_class_id'] = $class_id;
    $data['selected_subject_id'] = $subject_id;
    $data['selected_from_date'] = $start_date;
    $data['selected_to_date'] = $end_date;
    $this->load->view('templates/teacher_page', $data);
  }

  public function edit_profile_details()
  {
    $id = $this->session->userdata('teacher_id');
    $teacher['teacher'] = $this->Teacher_model->get_teacher($id);
    $data['data'] = $teacher;
    $data['view'] = 'teacher/edit_form';
    $this->load->view('templates/teacher_page', $data);
  }

  public function update_profile()
  {
    $this->form_validation->set_rules('first_name', 'Name', 'required');
    $this->form_validation->set_rules('last_name', 'Name', 'required');
    $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
    $this->form_validation->set_rules('phone', 'Phone', 'required');
    $this->form_validation->set_rules('department', 'Department', 'required');

    if ($this->form_validation->run() == FALSE) {
      return $this->edit_profile_details();
    }

    $data = [
      'first_name' => $this->input->post('first_name'),
      'last_name' => $this->input->post('last_name'),
      'email' => $this->input->post('email'),
      'phone' => $this->input->post('phone'),
      'department' => $this->input->post('department'),
    ];

    if ($this->input->post('password')) {
      $data['password'] = password_hash($this->input->post('password'), PASSWORD_BCRYPT);
    }

    if ($this->Teacher_model->update_teacher($this->session->userdata('teacher_id'), $data)) {
      $session_data = array(
        'teacher_name' => $this->input->post('first_name') . ' ' . $this->input->post('last_name'),
        'teacher_email' => $this->input->post('email'),
        'is_logged_in' => TRUE
      );
      $this->session->set_userdata($session_data);
    }
    set_toast_message('success', 'Profile updated successfully.');
    redirect(site_url('teacher/dashboard'));
  }



  public function class_schedule()
  {
    // $data['schedule'] = $this->Schedule_model->get_schedule_by_teacher($this->session->userdata('teacher_id'));

    $data['view'] = 'teacher/class_schedule';
    $data['data'] = '';
    $this->load->view('templates/teacher_page', $data);
  }

  public function submit_attendance()
  {
    $this->form_validation->set_rules('date', 'Date', 'required');
    $this->form_validation->set_rules('class_id', 'Class', 'required');
    $this->form_validation->set_rules('subject_id', 'Subject', 'required');
    $this->form_validation->set_rules('attendance[]', 'Attendance', 'required');

    if ($this->form_validation->run() == FALSE) {
      $this->session->set_flashdata('error', validation_errors());
      redirect('teacher/get_mark_attendance');
    } else {
      $date = $this->input->post('date');
      $class_id = $this->input->post('class_id');
      $subject_id = $this->input->post('subject_id');
      $attendance_data = $this->input->post('attendance');
      $teacher_id = $this->session->userdata('teacher_id');

      $batch_attendance = [];
      foreach ($attendance_data as $student_id => $status) {
        $batch_attendance[] = [
          'student_id' => $student_id,
          'teacher_id' => $teacher_id,
          'class_id' => $class_id,
          'subject_id' => $subject_id,
          'attendance_date' => $date,
          'status' => $status,
          'created_at' => date('Y-m-d H:i:s'),
          'updated_at' => date('Y-m-d H:i:s')
        ];
      }
      // print_r($batch_attendance);die('I died at 236/Teacher.php');
      if (!empty($batch_attendance)) {
        // Assuming Attendance_model has a method insert_batch_attendance
        if ($this->Attendance_model->insert_batch_attendance($batch_attendance)) {
          $this->session->set_flashdata('success', 'Attendance submitted successfully.');
        } else {
          $this->session->set_flashdata('error', 'Failed to submit attendance. Please try again.');
        }
      } else {
        $this->session->set_flashdata('error', 'No attendance data to submit.');
      }
      redirect('teacher/get_mark_attendance');
    }
  }
}
?>