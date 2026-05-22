<?php defined('BASEPATH') OR exit('No direct script access allowed');

class M_exam_rooms extends CI_Model {

	public static $pk = 'id';

	public static $table = 'exam_rooms';

	public function __construct() {
		parent::__construct();
	}

	public function get_where($keyword = '', $return_type = 'count', $limit = 0, $offset = 0) {
		$this->db->select("
			x1.id
			, x2.building_name
			, x1.room_name
			, x1.room_capacity
			, x1.is_deleted
		");
		$this->db->join('buildings x2', 'x1.building_id = x2.id', 'LEFT');
		if ( ! empty($keyword) ) {
			$this->db->like('x2.building_name', $keyword);
			$this->db->or_like('x1.room_name', $keyword);
		}
		if ( $return_type == 'count' ) return $this->db->count_all_results(self::$table . ' x1');
		if ( $limit > 0 ) $this->db->limit($limit, $offset);
		return $this->db->get(self::$table . ' x1');
	}

	public function dropdown() {
		$query = $this->db
			->select('x1.id, CONCAT(x2.building_name, " - ", x1.room_name) AS room_name')
			->join('buildings x2', 'x1.building_id = x2.id', 'LEFT')
			->where('x1.is_deleted', 'false')
			->order_by('x2.building_name', 'ASC')
			->order_by('x1.room_name', 'ASC')
			->get(self::$table . ' x1');
		$dataset = [];
		if ($query->num_rows() > 0) {
			foreach($query->result() as $row) {
				$dataset[$row->id] = $row->room_name;
			}
		}
		return $dataset;
	}
}
