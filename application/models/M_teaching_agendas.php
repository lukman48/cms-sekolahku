<?php defined('BASEPATH') OR exit('No direct script access allowed');

class M_teaching_agendas extends CI_Model {

	public static $pk = 'id';

	public static $table = 'teaching_agendas';

	public function __construct() {
		parent::__construct();
	}

	public function get_where($keyword = '', $return_type = 'count', $limit = 0, $offset = 0) {
		$this->db->select("
			x1.id
			, x2.academic_year
			, x3.full_name AS employee_name
			, x4.class_group
			, x1.meeting_date
			, x1.meeting_time
			, x1.material_discussed
			, x1.notes
			, x1.is_deleted
		");
		$this->db->join('academic_years x2', 'x1.academic_year_id = x2.id', 'LEFT');
		$this->db->join('employees x3', 'x1.employee_id = x3.id', 'LEFT');
		$this->db->join('class_groups x4', 'x1.class_group_setting_id = x4.id', 'LEFT');
		if ( ! empty($keyword) ) {
			$this->db->like('x3.full_name', $keyword);
			$this->db->or_like('x4.class_group', $keyword);
			$this->db->or_like('x1.material_discussed', $keyword);
		}
		if ( $return_type == 'count' ) return $this->db->count_all_results(self::$table . ' x1');
		if ( $limit > 0 ) $this->db->limit($limit, $offset);
		return $this->db->get(self::$table . ' x1');
	}
}
