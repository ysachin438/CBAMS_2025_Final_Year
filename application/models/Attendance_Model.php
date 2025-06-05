<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Attendance_Model extends CI_Model
{
    // Define table name constants
    const TBL_ATTENDANCE_RECORDS = 'attendance_records';
    const TBL_STUDENTS           = 'students';
    const TBL_SUBJECTS           = 'subjects';
    const TBL_CLASSES            = 'classes';

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Fetches attendance report data for a given class, subject, and date range.
     *
     * @param int $class_id
     * @param int $subject_id
     * @param string $from_date (YYYY-MM-DD)
     * @param string $to_date (YYYY-MM-DD)
     * @return array
     */
    public function get_attendance_report_data($class_id, $subject_id, $from_date, $to_date)
    {
        $this->db->select(
            self::TBL_STUDENTS . '.student_id, ' .
                'CONCAT(' . self::TBL_STUDENTS . '.first_name, " ", ' . self::TBL_STUDENTS . '.last_name) as name, ' .
                'SUM(CASE WHEN ' . self::TBL_ATTENDANCE_RECORDS . '.status = \'Present\' THEN 1 ELSE 0 END) as present, ' .
                'SUM(CASE WHEN ' . self::TBL_ATTENDANCE_RECORDS . '.status = \'Absent\' THEN 1 ELSE 0 END) as absent'
        );
        $this->db->from(self::TBL_ATTENDANCE_RECORDS . ' ar');
        $this->db->join(self::TBL_STUDENTS . ' s', 'ar.student_id = s.student_id', 'left');

        $this->db->where('ar.class_id', $class_id);
        $this->db->where('ar.subject_id', $subject_id);
        $this->db->where('ar.attendance_date >= ', $from_date);
        $this->db->where('ar.attendance_date <= ', $to_date);

        $this->db->group_by('s.student_id, name');
        $this->db->order_by('name', 'ASC');

        $query = $this->db->get();
        return $query->result_array();
    }

    /**
     * Gets current and longest attendance streak for a student.
     * This is a placeholder and needs to be implemented based on your specific logic for streaks.
     *
     * @param int $student_id
     * @return array Example: ['current_streak' => 5, 'longest_streak' => 10]
     */
    public function get_streak_data($student_id)
    {
        // --- Placeholder: Complex streak logic needs to be implemented here ---
        $this->db->select('attendance_date');
        $this->db->from(self::TBL_ATTENDANCE_RECORDS);
        $this->db->where('student_id', $student_id);
        $this->db->where('status', 'Present');
        $this->db->order_by('attendance_date', 'ASC');
        $query = $this->db->get();
        $present_dates = $query->result_array();

        if (empty($present_dates)) {
            return ['current_streak' => 0, 'longest_streak' => 0];
        }

        // --- Actual streak calculation logic (simplified) ---
        $current_streak = 0;
        $longest_streak = 0;
        $temp_streak = 0;
        $previous_date = null;

        foreach ($present_dates as $record) {
            $current_date_obj = new DateTime($record['attendance_date']);
            if ($previous_date) {
                $diff = $previous_date->diff($current_date_obj)->days;
                if ($diff === 1) {
                    $temp_streak++;
                } else if ($diff > 1) {
                    if ($temp_streak > $longest_streak) {
                        $longest_streak = $temp_streak;
                    }
                    $temp_streak = 1;
                }
            } else {
                $temp_streak = 1;
            }
            $previous_date = $current_date_obj;
        }
        if ($temp_streak > $longest_streak) {
            $longest_streak = $temp_streak;
        }
        $current_streak = $temp_streak; // Simplified current streak

        return ['current_streak' => $current_streak, 'longest_streak' => $longest_streak];
    }

    /**
     * Gets weekly attendance data for a student, typically for a dashboard graph.
     * This is a placeholder and needs to be implemented based on your graph requirements.
     *
     * @param int $student_id
     * @return array Example: ['Monday' => 'Present', 'Tuesday' => 'Absent', ...]
     */
    public function get_weekly_attendance($student_id)
    {
        $today = date('Y-m-d');
        $start_of_week = date('Y-m-d', strtotime('monday this week', strtotime($today)));
        $end_of_week = date('Y-m-d', strtotime('sunday this week', strtotime($today)));

        $this->db->select('attendance_date, status, DAYNAME(attendance_date) as day_name');
        $this->db->from(self::TBL_ATTENDANCE_RECORDS);
        $this->db->where('student_id', $student_id);
        $this->db->where('attendance_date >= ', $start_of_week);
        $this->db->where('attendance_date <= ', $end_of_week);
        $this->db->order_by('attendance_date', 'ASC');
        $query = $this->db->get();
        $weekly_records = $query->result_array();

        $days = ['Monday' => 'N/A', 'Tuesday' => 'N/A', 'Wednesday' => 'N/A', 'Thursday' => 'N/A', 'Friday' => 'N/A'];

        foreach ($weekly_records as $record) {
            $day_name = $record['day_name'];
            if (array_key_exists($day_name, $days)) {
                $days[$day_name] = $record['status'];
            }
        }
        return $days;
    }

    public function insert_or_update($data)
    {
        $this->db->where('student_id', $data['student_id']);
        $this->db->where('attendance_date', $data['attendance_date']);
        $this->db->where('subject_id', $data['subject_id']);
        // Assuming class_id is also part of the unique key for an attendance record
        if (isset($data['class_id'])) {
            $this->db->where('class_id', $data['class_id']);
        }
        $query = $this->db->get(self::TBL_ATTENDANCE_RECORDS);

        if ($query->num_rows() > 0) {
            // Record exists, update status
            $update_data = ['status' => $data['status']];
            // Add other fields to update if necessary, e.g., teacher_id if it can change
            if (isset($data['teacher_id'])) {
                $update_data['teacher_id'] = $data['teacher_id'];
            }
            $this->db->where('id', $query->row()->id); // Assuming 'id' is the primary key of attendance_records
            return $this->db->update(self::TBL_ATTENDANCE_RECORDS, $update_data);
        } else {
            // Record does not exist, insert new record
            return $this->db->insert(self::TBL_ATTENDANCE_RECORDS, $data);
        }
    }

    public function get_recent_by_teacher($teacher_id)
    {
        $this->db->select(
            'ar.attendance_date, ar.subject_id, ar.class_id, ' .
                's.name AS subject_name, ' .
                'c.class_name AS class_name, ' .
                'SUM(ar.status = "Present") AS present_count, ' .
                'SUM(ar.status = "Absent") AS absent_count'
        );
        $this->db->from(self::TBL_ATTENDANCE_RECORDS . ' ar');
        $this->db->join(self::TBL_SUBJECTS . ' s', 's.subject_id = ar.subject_id');
        $this->db->join(self::TBL_CLASSES . ' c', 'c.class_id = ar.class_id');
        $this->db->where('ar.teacher_id', $teacher_id);
        $this->db->group_by(['ar.attendance_date', 'ar.class_id', 'ar.subject_id']);
        $this->db->order_by('ar.attendance_date', 'DESC');
        $this->db->limit(1);

        return $this->db->get()->row_array();
    }

    public function get_attendance_by_class_n_teacher($teacher_id, $class_id, $subject_id, $start_date, $end_date)
    {
        $this->db->select(
            'ar.*, ' .
                'st.first_name as student_name, st.roll_number, ' .
                'cls.class_name as class_name, ' .
                'sub.name as subject_name'
        );
        $this->db->from(self::TBL_ATTENDANCE_RECORDS . ' ar');
        $this->db->join(self::TBL_STUDENTS . ' st', 'st.student_id = ar.student_id');
        $this->db->join(self::TBL_CLASSES . ' cls', 'cls.class_id = ar.class_id');
        $this->db->join(self::TBL_SUBJECTS . ' sub', 'sub.subject_id = ar.subject_id');
        $this->db->where('ar.teacher_id', $teacher_id);
        $this->db->where('ar.class_id', $class_id);
        $this->db->where('ar.subject_id', $subject_id);
        if (!empty($start_date)) {
            // Assuming 'attendance_date' is the correct column name in TBL_ATTENDANCE_RECORDS
            $this->db->where('ar.attendance_date >= ', $start_date);
        }
        if (!empty($end_date)) {
            $this->db->where('ar.attendance_date <= ', $end_date);
        }
        $this->db->order_by('ar.attendance_date', 'DESC');

        return $this->db->get()->result_array();
    }

    /**
     * Inserts a batch of attendance records.
     *
     * @param array $data Batch of attendance records to insert.
     * @return bool True on success, false on failure.
     */
    public function insert_batch_attendance($attendance_data)
    {
        if (empty($attendance_data)) {
            return false;
        }

        foreach ($attendance_data as $record) {
            // Build unique constraint check
            $this->db->where([
                'student_id'      => $record['student_id'],
                'subject_id'      => $record['subject_id'],
                'class_id'        => $record['class_id'],
                'attendance_date' => $record['attendance_date'],
            ]);

            $query = $this->db->get(self::TBL_ATTENDANCE_RECORDS);

            if ($query->num_rows() > 0) {
                // Update existing record
                $this->db->where([
                    'student_id'      => $record['student_id'],
                    'subject_id'      => $record['subject_id'],
                    'class_id'        => $record['class_id'],
                    'attendance_date' => $record['attendance_date'],
                ]);

                $this->db->update(self::TBL_ATTENDANCE_RECORDS, [
                    'status'     => $record['status'],
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
            } else {
                // Insert new record
                $this->db->insert(self::TBL_ATTENDANCE_RECORDS, $record);
            }
        }

        return true;
    }
}
