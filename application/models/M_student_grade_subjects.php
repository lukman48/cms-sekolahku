<?php defined('BASEPATH') OR exit('No direct script access allowed');

class M_student_grade_subjects extends CI_Model {

	public static $pk = 'id';

	public static $table = 'student_grade_subjects';

	public function __construct() {
		parent::__construct();
	}

	public function get_where($keyword = '', $return_type = 'count', $limit = 0, $offset = 0) {
		$this->db->select("
			x1.id
			, x2.academic_year
			, x1.subject_name
			, x1.is_active
			, x1.is_deleted
		");
		$this->db->join('academic_years x2', 'x1.academic_year_id = x2.id', 'LEFT');
		if ( ! empty($keyword) ) {
			$this->db->like('x2.academic_year', $keyword);
			$this->db->or_like('x1.subject_name', $keyword);
		}
		if ( $return_type == 'count' ) return $this->db->count_all_results(self::$table . ' x1');
		if ( $limit > 0 ) $this->db->limit($limit, $offset);
		return $this->db->get(self::$table . ' x1');
	}

	public function dropdown() {
		$query = $this->db
			->select('id, subject_name')
			->where('is_deleted', 'false')
			->where('is_active', 'true')
			->order_by('subject_name', 'ASC')
			->get(self::$table);
		$dataset = [];
		if ($query->num_rows() > 0) {
			foreach($query->result() as $row) {
				$dataset[$row->id] = $row->subject_name;
			}
		}
		return $dataset;
	}
}
