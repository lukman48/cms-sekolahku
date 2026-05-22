<?php defined('BASEPATH') OR exit('No direct script access allowed');

class M_student_grades extends CI_Model {

	public static $pk = 'id';

	public static $table = 'student_grades';

	public function __construct() {
		parent::__construct();
	}

	public function get_where($keyword = '', $return_type = 'count', $limit = 0, $offset = 0) {
		$this->db->select("
			x1.id
			, x2.academic_year
			, x3.full_name AS student_name
			, x3.registration_number
			, x4.subject_name
			, x1.grade
			, x1.is_deleted
		");
		$this->db->join('academic_years x2', 'x1.academic_year_id = x2.id', 'LEFT');
		$this->db->join('students x3', 'x1.registrant_id = x3.id', 'LEFT');
		$this->db->join('student_grade_subjects x4', 'x1.student_grade_subject_id = x4.id', 'LEFT');
		if ( ! empty($keyword) ) {
			$this->db->like('x2.academic_year', $keyword);
			$this->db->or_like('x3.full_name', $keyword);
			$this->db->or_like('x4.subject_name', $keyword);
		}
		if ( $return_type == 'count' ) return $this->db->count_all_results(self::$table . ' x1');
		if ( $limit > 0 ) $this->db->limit($limit, $offset);
		return $this->db->get(self::$table . ' x1');
	}
}
