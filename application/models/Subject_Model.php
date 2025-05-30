<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Subject_model extends CI_Model {

    public function get_by_teacher($teacher_id) {
        $this->db->select('*');
        $this->db->from('subjects');
        $this->db->where('teacher_id', $teacher_id);
        return $this->db->get()->result();
    }
}
