<?php
    defined('BASEPATH') or exit('No direct script access allowed');

    class Schedule_model extends CI_Model
    {

        public function __construct()
        {
            parent::__construct();
            $this->load->database(); // Ensure database library is loaded
        }

        /**
         * Fetches upcoming class schedules for a specific teacher.
         *
         * Assumes a 'schedules' table with columns:
         * - teacher_id (INT)
         * - title (VARCHAR)
         * - schedule_datetime (DATETIME)
         * - type (VARCHAR, e.g., 'class', 'lab', 'exam')
         * - icon (VARCHAR, optional, stores an emoji or class for an icon)
         *
         * @param int $teacher_id The ID of the teacher.
         * @param int $limit The maximum number of upcoming classes to return.
         * @return array An array of schedule items.
         */
        public function get_upcoming_classes_by_teacher($teacher_id, $limit = 5)
        {
            $current_day = date('Monday'); // e.g., 'Monday'
            $current_time = date('H:i:s');

            $this->db->select('cs.day_of_week, cs.start_time, cs.end_time, s.name AS subject_name, c.class_name, cs.room_no');
            $this->db->from('class_schedule cs');
            $this->db->join('subjects s', 'cs.subject_id = s.subject_id');
            $this->db->join('classes c', 'cs.class_id = c.class_id');
            $this->db->where('cs.teacher_id', $teacher_id);

            // Only fetch classes from today onward
            $this->db->where("FIELD(cs.day_of_week, 'Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday') >= 
                      FIELD('$current_day', 'Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday')");

            // If today's class, filter based on time too
            $this->db->group_start();
            $this->db->where('cs.day_of_week !=', $current_day);
            $this->db->or_group_start();
            $this->db->where('cs.day_of_week', $current_day);
            $this->db->where('cs.start_time >=', $current_time);
            $this->db->group_end();
            $this->db->group_end();

            $this->db->order_by("FIELD(cs.day_of_week, 'Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday')");
            $this->db->order_by('cs.start_time', 'ASC');

            if ($limit > 0) {
                $this->db->limit($limit);
            }

            $query = $this->db->get();
            // print_r($this->db->last_query());die('I died Here');
            return $query->result_array();
        }
    }
