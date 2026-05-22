<?php defined('BASEPATH') OR exit('No direct script access allowed');

class M_exam_participants extends CI_Model {

	public static $pk = 'id';

	public static $table = 'exam_participants';

	public function __construct() {
		parent::__construct();
	}

	public function get_where($keyword = '', $return_type = 'count', $limit = 0, $offset = 0) {
		$this->db->select("
			x1.id
			, x2.academic_year
			, x3.phase_name
			, x4.subject_name
			, CONCAT(x5.building_name, ' - ', x6.room_name) AS room_name
			, x7.registration_number
			, x7.full_name
			, x1.seat_number
			, x1.is_deleted
		");
		$this->db->join('academic_years x2', 'x1.academic_year_id = x2.id', 'LEFT');
		$this->db->join('admission_phases x3', 'x1.admission_phase_id = x3.id', 'LEFT');
		$this->db->join('exam_schedules x4', 'x1.exam_schedule_id = x4.id', 'LEFT');
		$this->db->join('exam_rooms x6', 'x1.exam_room_id = x6.id', 'LEFT');
		$this->db->join('buildings x5', 'x6.building_id = x5.id', 'LEFT');
		$this->db->join('students x7', 'x1.registrant_id = x7.id', 'LEFT');
		if ( ! empty($keyword) ) {
			$this->db->like('x2.academic_year', $keyword);
			$this->db->or_like('x3.phase_name', $keyword);
			$this->db->or_like('x4.subject_name', $keyword);
			$this->db->or_like('x7.full_name', $keyword);
			$this->db->or_like('x7.registration_number', $keyword);
		}
		if ( $return_type == 'count' ) return $this->db->count_all_results(self::$table . ' x1');
		if ( $limit > 0 ) $this->db->limit($limit, $offset);
		return $this->db->get(self::$table . ' x1');
	}

	public function get_exam_participant_detail($id) {
		return $this->db
			->select("
				x7.registration_number
				, x7.full_name
				, x7.gender
				, x5.building_name
				, x6.room_name
				, x1.seat_number
				, x4.exam_date
				, x4.exam_start_time
				, x4.exam_end_time
				, x4.subject_name
			")
			->join('exam_schedules x4', 'x1.exam_schedule_id = x4.id', 'LEFT')
			->join('exam_rooms x6', 'x1.exam_room_id = x6.id', 'LEFT')
			->join('buildings x5', 'x6.building_id = x5.id', 'LEFT')
			->join('students x7', 'x1.registrant_id = x7.id', 'LEFT')
			->where('x1.id', $id)
			->where('x1.is_deleted', 'false')
			->get(self::$table . ' x1');
	}

	public function get_all_participants() {
		return $this->db
			->select("
				x7.registration_number
				, x7.full_name
				, x7.gender
				, x5.building_name
				, x6.room_name
				, x1.seat_number
				, x4.exam_date
				, x4.exam_start_time
				, x4.exam_end_time
				, x4.subject_name
			")
			->join('exam_schedules x4', 'x1.exam_schedule_id = x4.id', 'LEFT')
			->join('exam_rooms x6', 'x1.exam_room_id = x6.id', 'LEFT')
			->join('buildings x5', 'x6.building_id = x5.id', 'LEFT')
			->join('students x7', 'x1.registrant_id = x7.id', 'LEFT')
			->where('x1.is_deleted', 'false')
			->order_by('x7.full_name', 'ASC')
			->get(self::$table . ' x1');
	}
}
