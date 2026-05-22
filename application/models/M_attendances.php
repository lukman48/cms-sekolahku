<?php defined('BASEPATH') OR exit('No direct script access allowed');

class M_attendances extends CI_Model {

	public static $pk = 'id';

	public static $table = 'attendances';

	public function __construct() {
		parent::__construct();
	}

	public function get_where($keyword = '', $return_type = 'count', $limit = 0, $offset = 0) {
		$this->db->select("
			x1.id
			, x2.academic_year
			, x3.full_name AS student_name
			, x3.identity_number
			, x4.class_group
			, x1.attendance_date
			, x1.attendance_status
			, x1.notes
			, x1.is_deleted
		");
		$this->db->join('academic_years x2', 'x1.academic_year_id = x2.id', 'LEFT');
		$this->db->join('students x3', 'x1.student_id = x3.id', 'LEFT');
		$this->db->join('class_groups x4', 'x3.class_group_id = x4.id', 'LEFT');
		if ( ! empty($keyword) ) {
			$this->db->like('x3.full_name', $keyword);
			$this->db->or_like('x3.identity_number', $keyword);
			$this->db->or_like('x4.class_group', $keyword);
		}
		if ( $return_type == 'count' ) return $this->db->count_all_results(self::$table . ' x1');
		if ( $limit > 0 ) $this->db->limit($limit, $offset);
		return $this->db->get(self::$table . ' x1');
	}

	public function get_student_attendances($student_id, $academic_year_id, $limit = 0, $offset = 0) {
		$this->db->select("
			x1.attendance_date
			, x1.attendance_status
			, x1.notes
		");
		$this->db->where('x1.student_id', $student_id);
		$this->db->where('x1.academic_year_id', $academic_year_id);
		$this->db->where('x1.is_deleted', 'false');
		$this->db->order_by('x1.attendance_date', 'DESC');
		if ( $limit > 0 ) $this->db->limit($limit, $offset);
		return $this->db->get(self::$table . ' x1');
	}

	public function get_attendance_report($academic_year_id, $class_group_id, $start_date = '', $end_date = '') {
		$this->db->select("
			x3.identity_number
			, x3.full_name AS student_name
			, x1.attendance_date
			, x1.attendance_status
			, x1.notes
		");
		$this->db->join('students x3', 'x1.student_id = x3.id', 'LEFT');
		$this->db->join('class_groups x4', 'x3.class_group_id = x4.id', 'LEFT');
		$this->db->where('x1.academic_year_id', $academic_year_id);
		$this->db->where('x3.class_group_id', $class_group_id);
		$this->db->where('x1.is_deleted', 'false');
		if ( ! empty($start_date) ) $this->db->where('x1.attendance_date >=', $start_date);
		if ( ! empty($end_date) ) $this->db->where('x1.attendance_date <=', $end_date);
		$this->db->order_by('x3.full_name', 'ASC');
		$this->db->order_by('x1.attendance_date', 'ASC');
		return $this->db->get(self::$table . ' x1');
	}
}
