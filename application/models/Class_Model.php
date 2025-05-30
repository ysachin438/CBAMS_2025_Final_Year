<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Class_model extends CI_Model
{

    public function get_all()
    {
        $this->db->select('*');
        $this->db->from('classes');
        return $this->db->get()->result();
    }
    // public function get_by_teacher($teacher_id){
    //     $this->db->select('*');
    //     $this->db->from('classes');
    //     $this->db->where('teacher_id' ,$teacher_id);
    //     return $this->db->get()->result();
    // }
    // Class_model.php
    public function get_by_teacher($teacher_id)
    {
        $this->db->select('classes.*');
        $this->db->from('classes');
        $this->db->join('class_teacher', 'class_teacher.class_id = classes.class_id');
        $this->db->where('class_teacher.teacher_id', $teacher_id);
        return $this->db->get()->result();
    }
}
