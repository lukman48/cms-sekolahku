<?php defined('BASEPATH') OR exit('No direct script access allowed');

class M_exam_schedules extends CI_Model {

	public static $pk = 'id';

	public static $table = 'exam_schedules';

	public function __construct() {
		parent::__construct();
	}

	public function get_where($keyword = '', $return_type = 'count', $limit = 0, $offset = 0) {
		$this->db->select("
			x1.id
			, x2.academic_year
			, x3.phase_name
			, x4.subject_name
			, x1.exam_date
			, x1.exam_start_time
			, x1.exam_end_time
			, x1.is_deleted
		");
		$this->db->join('academic_years x2', 'x1.academic_year_id = x2.id', 'LEFT');
		$this->db->join('admission_phases x3', 'x1.admission_phase_id = x3.id', 'LEFT');
		$this->db->join('exam_subjects x4', 'x1.exam_subject_id = x4.id', 'LEFT');
		if ( ! empty($keyword) ) {
			$this->db->like('x2.academic_year', $keyword);
			$this->db->or_like('x3.phase_name', $keyword);
			$this->db->or_like('x4.subject_name', $keyword);
		}
		if ( $return_type == 'count' ) return $this->db->count_all_results(self::$table . ' x1');
		if ( $limit > 0 ) $this->db->limit($limit, $offset);
		return $this->db->get(self::$table . ' x1');
	}
}
