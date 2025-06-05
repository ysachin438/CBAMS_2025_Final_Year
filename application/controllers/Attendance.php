<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Attendance extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Attendance_Model');
        $this->load->model('Class_Model'); // Assuming you have a Class_Model
        $this->load->model('Subject_Model'); // Assuming you have a Subject_Model
        $this->load->helper('url');
        $this->load->library('form_validation');
    }

    public function view_report() {
        $data['classes'] = $this->Class_Model->get_all_classes(); // Assuming this method exists
        $data['subjects'] = $this->Subject_Model->get_all_subjects(); // Assuming this method exists

        $data['report_data'] = []; // Initialize with empty array

        // Check if form was submitted
        if ($this->input->get('class_id') && $this->input->get('from_date') && $this->input->get('to_date')) {
            
            $this->form_validation->set_data($this->input->get()); // Set GET data for validation
            $this->form_validation->set_rules('class_id', 'Class', 'required|numeric');
            $this->form_validation->set_rules('subject_id', 'Subject', 'required|numeric');
            $this->form_validation->set_rules('from_date', 'From Date', 'required');
            $this->form_validation->set_rules('to_date', 'To Date', 'required');

            if ($this->form_validation->run() == TRUE) {
                $class_id = $this->input->get('class_id');
                $subject_id = $this->input->get('subject_id');
                $from_date = $this->input->get('from_date');
                $to_date = $this->input->get('to_date');

                // Fetch report data from Attendance_Model
                // Assuming a method like get_attendance_report_data in your Attendance_Model
                $data['report_data'] = $this->Attendance_Model->get_attendance_report_data($class_id, $subject_id, $from_date, $to_date);
            } else {
                // If validation fails, you might want to pass errors to the view
                // For simplicity, we're just showing an empty report or you can set a flash message
                set_toast_message('error', validation_errors()); // Using your toast message helper
            }
        }

        $this->load->view('teacher/view_attendance', $data);
    }

    // You might have other attendance related methods here, like mark_attendance, etc.

} 