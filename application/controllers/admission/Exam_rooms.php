<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Exam_rooms extends Admin_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model(['m_exam_rooms', 'm_buildings']);
		$this->pk = M_exam_rooms::$pk;
		$this->table = M_exam_rooms::$table;
	}

	public function index() {
		$this->vars['title'] = 'Master Ruang Ujian';
		$this->vars['admission'] = $this->vars['exam_rooms'] = TRUE;
		$this->vars['building_dropdown'] = json_encode($this->m_buildings->dropdown(), JSON_HEX_APOS | JSON_HEX_QUOT);
		$this->vars['content'] = 'admission/exam_rooms';
		$this->load->view('backend/index', $this->vars);
	}

	public function pagination() {
		if ($this->input->is_ajax_request()) {
			$keyword = trim($this->input->post('keyword', true));
			$page_number = _toInteger($this->input->post('page_number', true));
			$limit = _toInteger($this->input->post('per_page', true));
			$offset = ($page_number * $limit);
			$query = $this->m_exam_rooms->get_where($keyword, 'rows', $limit, $offset);
			$total_rows = $this->m_exam_rooms->get_where($keyword);
			$total_page = $limit > 0 ? ceil(_toInteger($total_rows) / _toInteger($limit)) : 1;
			$this->vars['total_page'] = _toInteger($total_page);
			$this->vars['total_rows'] = _toInteger($total_rows);
			$this->vars['rows'] = $query->result();
			$this->output
				->set_content_type('application/json', 'utf-8')
				->set_output(json_encode($this->vars, self::REQUIRED_FLAGS))
				->_display();
			exit;
		}
	}

	public function save() {
		if ($this->input->is_ajax_request()) {
			$id = _toInteger($this->input->post('id', true));
			if ($this->validation()) {
				$dataset = $this->dataset();
				$dataset[(_isNaturalNumber( $id ) ? 'updated_by' : 'created_by')] = __session('user_id');
				if (!_isNaturalNumber( $id )) $dataset['created_at'] = date('Y-m-d H:i:s');
				$query = $this->model->upsert($id, $this->table, $dataset);
				$this->vars['status'] = $query ? 'success' : 'error';
				$this->vars['message'] = $query ? 'Data Anda berhasil disimpan.' : 'Terjadi kesalahan dalam menyimpan data';
			} else {
				$this->vars['status'] = 'error';
				$this->vars['message'] = validation_errors();
			}
			$this->output
				->set_content_type('application/json', 'utf-8')
				->set_output(json_encode($this->vars, self::REQUIRED_FLAGS))
				->_display();
			exit;
		}
	}

	private function dataset() {
		return [
			'building_id' => _toInteger($this->input->post('building_id', true)),
			'room_name' => $this->input->post('room_name', true),
			'room_capacity' => _toInteger($this->input->post('room_capacity', true))
		];
	}

	private function validation() {
		$this->load->library('form_validation');
		$val = $this->form_validation;
		$val->set_rules('building_id', 'Gedung', 'trim|is_natural_no_zero|required');
		$val->set_rules('room_name', 'Nama Ruang', 'trim|required');
		$val->set_rules('room_capacity', 'Kapasitas', 'trim|is_natural_no_zero|required');
		$val->set_message('required', '{field} harus diisi');
		$val->set_message('is_natural_no_zero', '{field} harus diisi dengan angka dan tidak boleh Nol');
		$val->set_error_delimiters('<div>&sdot; ', '</div>');
		return $val->run();
	}
}
