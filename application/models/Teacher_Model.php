<?php
class Teacher_Model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function verify_credentials($employee_id, $password)
    {
        $this->db->select('*');
        $this->db->from('teachers');
        $this->db->where('employee_number', $employee_id);
        $result = $this->db->get();

        if (!$password == $this->encryption->decrypt(($result->row())->hash_pass)) {
            return $result->row_array();
        } else {
            return false;
        }
    }
    public function get_teacher($teacher_id)
    {
        return $this->db->get_where('teachers', ['teacher_id' => $teacher_id])->row_array();
    }
    public function update_teacher($teacher_id, $data)
    {
        $this->db->where('teacher_id', $teacher_id);
        return $this->db->update('teachers', $data);
    }
}