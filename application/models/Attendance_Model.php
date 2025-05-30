<?php
class Attendance_Model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_streak_data($id)
    {
        return [
            'current' => 7,
            'longest' => 18
        ]; // Replace with actual logic
    }

    public function get_weekly_attendance($id)
    {
        return [100, 100, 80, 90, 100, 100]; // Replace with actual logic
    }
    public function insert_or_update($data)
    {
        $this->db->where('student_id', $data['student_id']);
        $this->db->where('attendance_date', $data['attendance_date']);
        $this->db->where('subject_id', $data['subject_id']);
        $query = $this->db->get('attendance');

        if ($query->num_rows() > 0) {
            $this->db->where('id', $query->row()->id);
            return $this->db->update('attendance', ['status' => $data['status']]);
        } else {
            return $this->db->insert('attendance', $data);
        }
    }
    public function get_recent_by_teacher($teacher_id)
    {
        $this->db->select('a.attendance_date, a.subject_id, a.class_id,
                      s.name AS subject_name,
                      c.class_name AS class_name,
                      SUM(a.status = "Present") AS present_count,
                      SUM(a.status = "Absent") AS absent_count');
        $this->db->from('attendance a');
        $this->db->join('subjects s', 's.subject_id = a.subject_id');
        $this->db->join('classes c', 'c.class_id = a.class_id');
        $this->db->where('a.teacher_id', $teacher_id);
        $this->db->group_by(['a.attendance_date', 'a.class_id', 'a.subject_id']);
        $this->db->order_by('a.attendance_date', 'DESC');
        $this->db->limit(1);

        return $this->db->get()->row_array();
    }
    public function get_attendance_by_class_n_teacher($teacher_id, $class_id, $subject_id, $start_date, $end_date)
    {
        $this->db->select('a.*, s.name as student_name, s.roll_no, c.name as class_name, sub.name as subject_name');
        $this->db->from('attendance a');
        $this->db->join('students s', 's.student_id = a.student_id');
        $this->db->join('classes c', 'c.class_id = a.class_id');
        $this->db->join('subjects sub', 'sub.subject_id = a.subject_id');
        $this->db->where('a.teacher_id', $teacher_id);
        $this->db->where('a.class_id', $class_id);
        $this->db->where('a.subject_id', $subject_id);
        if (!empty($start_date)) {
            $this->db->where('a.date >=', $start_date);
        }
        if (!empty($end_date)) {
            $this->db->where('a.date <=', $end_date);
        }
        $this->db->order_by('a.attendance_date', 'DESC');

        return $this->db->get()->result_array();
    }
}
