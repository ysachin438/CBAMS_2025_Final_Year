<?php
class Student_Model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function verify_credentials($roll_no, $password)
    {
        $this->db->select('*');
        $this->db->from('students');
        $this->db->where('roll_number', $roll_no);
        $result = $this->db->get();

        if (!$password == $this->encryption->decrypt(($result->row())->hash_pass)) {
            return $result->row_array();
        } else {
            return false;
        }
    }

    public function get_student_details($student_id)
    {
        return $this->db->get_where('students', ['student_id' => $student_id])->row_array();
    }

    public function insert_student($data)
    {
        return $this->db->insert('students', $data);
    }
    public function getUserByRollNo($roll_no){
            $this->db->select('students.*, courses.course_name as course');
            $this->db->from('students');
            $this->db->join('courses', 'courses.course_ id = students.course_id', 'left');
            $this->db->where('students.roll_number', $roll_no);
            return $this->db->get()->row_array();
    }

    public function get_by_teacher($teacher_id) {
        $this->db->select('students.*');
        $this->db->from('students');
        $this->db->join('subjects', 'students.course_id = subjects.course_id');
        $this->db->where('subjects.teacher_id', $teacher_id);
        $this->db->group_by('students.student_id'); // avoid duplicates
        return $this->db->get()->result();
    }
}
