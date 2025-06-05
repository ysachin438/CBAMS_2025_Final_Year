<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Student extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Student_Model');
        $this->load->model('Attendance_Model');
        //Validate User Here
        // check_student_login();

    }

    public function index()
    {
        $this->load->view('auth/student_login');
    }
    public function dashboard()
    {
        // die('Heere');
        $student_id = $this->session->userdata('student_id');
        $data['student'] = $this->Student_Model->get_student_details($student_id); // Fetch details like name, photo, roll no, etc.
        print_r($data['student']);
        echo $this->db->last_query();
        die('I died here');
        $data['streak'] = $this->Attendance_Model->get_streak_data($student_id);  // Current and longest streak
        $data['attendance_graph'] = $this->Attendance_Model->get_weekly_attendance($student_id); // Attendance data
        $this->load->view('student/dashboard', $data);
    }
    public function authenticate()
    {
        $this->form_validation->set_rules('roll_no', 'Roll Number', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            // Validation failed, reload login view with errors
            set_toast_message('error', 'Validation failed. Please check your inputs and try again.');
            $this->load->view('auth/login');
        } else {

            $roll_no = $this->input->post('roll_no', TRUE);
            $password = $this->input->post('password', TRUE);

            // Check credentials
            $student = $this->Student_Model->verify_credentials($roll_no, $password);
            if ($student) {
                // Save session data
                $data = array(
                    'student_id' => $student['student_id'],
                    'roll_no' => $student['roll_number'],
                    'student_name' => $student['first_name'] . $student['last_name'],
                    'user_role' => 'student',
                    'is_logged_in' => TRUE
                );
                $this->session->set_userdata($data);
                redirect(site_url('student/dashboard'));
            } else {
                set_toast_message('error', 'Invalid Roll Number or Password.');
                redirect(site_url('student/index'));
            }
        }
    }
    public function add_student()
    {
        $this->load->view('student/add_student');
    }
    public function add_student_authenticate()
    {
        $students = $this->input->post('students');

        $error_messages = [];

        if (!empty($students)) {
            foreach ($students as $index => $student) {
                $this->form_validation->set_data($student);

                $this->form_validation->set_rules('roll_number', 'Roll Number', 'required|numeric');
                $this->form_validation->set_rules('first_name', 'First Name', 'required|alpha');
                $this->form_validation->set_rules('last_name', 'Last Name', 'required|alpha');
                // $this->form_validation->set_rules('dob', 'Date of Birth', 'required|valid_date');
                $this->form_validation->set_rules('course', 'Course', 'required');

                if ($this->form_validation->run() === FALSE) {
                    $error_messages[] = "Row " . ($index + 1) . ": " . validation_errors('', '');
                } else {
                    $data = array(
                        'roll_number'   => $student['roll_number'],
                        'first_name'    => $student['first_name'],
                        'last_name'     => $student['last_name'],
                        'date_of_birth' => $student['dob'],
                        'course'    => $student['course']
                    );

                    $is_exist = $this->Student_Model->getUserByRollNo($student['roll_number']);
                    if (!$is_exist) {
                        if ($this->Student_Model->insert_student($data)) {
                            set_toast_message('success', 'Added Successfully');
                        } else {
                            set_toast_message('error', 'Failed to add.');
                            redirect(site_url('Student/add_student'));
                        }
                    } else {
                        set_toast_message('error', 'Student Already Exist.');
                        redirect(site_url('student/add_student'));
                    }
                }
            }

            if (!empty($error_messages)) {
                set_toast_message('error', 'Some student data could not be processed. Please review details.');
            } else {
                set_toast_message('success', 'All students processed successfully!');
            }
        } else {
            set_toast_message('error', 'No student data was submitted.');
        }

        redirect(site_url('Student/index'));
    }

    public function valid_date($date)
    {
        return (DateTime::createFromFormat('Y-m-d', $date) !== false);
    }

    public function attendance_calendar(){

        $this->load->view('student/attendance_calendar');
    }
}
