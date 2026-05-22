<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Exam_cards extends Admin_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('m_exam_participants');
	}

	public function index() {
		$this->vars['title'] = 'Cetak Kartu Ujian Tes Tulis';
		$this->vars['admission'] = $this->vars['exam_management'] = TRUE;
		$this->vars['content'] = 'admission/exam_cards';
		$this->load->view('backend/index', $this->vars);
	}

	public function pagination() {
		if ($this->input->is_ajax_request()) {
			$keyword = trim($this->input->post('keyword', true));
			$page_number = _toInteger($this->input->post('page_number', true));
			$limit = _toInteger($this->input->post('per_page', true));
			$offset = ($page_number * $limit);
			$query = $this->m_exam_participants->get_where($keyword, 'rows', $limit, $offset);
			$total_rows = $this->m_exam_participants->get_where($keyword);
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

	public function print_card() {
		if ($this->input->is_ajax_request()) {
			$id = _toInteger($this->input->post('id', true));
			$query = $this->m_exam_participants->get_exam_participant_detail($id);
			if ($query->num_rows() > 0) {
				$participant = $query->row_array();
				$this->load->library('exam_cards');
				$file_name = $this->exam_cards->create_pdf($participant, [
					'school_name' => __session('school_name'),
					'street_address' => __session('street_address'),
					'phone' => __session('phone'),
					'email' => __session('email'),
					'logo' => __session('logo'),
					'district' => __session('district'),
					'head_school' => __session('head_school'),
					'school_level' => __session('school_level'),
				]);
				$this->vars['status'] = 'success';
				$this->vars['file_name'] = $file_name;
			} else {
				$this->vars['status'] = 'error';
				$this->vars['message'] = 'Data tidak ditemukan.';
			}
			$this->output
				->set_content_type('application/json', 'utf-8')
				->set_output(json_encode($this->vars, self::REQUIRED_FLAGS))
				->_display();
			exit;
		}
	}

	public function print_all() {
		if ($this->input->is_ajax_request()) {
			$this->load->library('exam_cards');
			$query = $this->m_exam_participants->get_all_participants();
			$files = [];
			if ($query->num_rows() > 0) {
				foreach ($query->result_array() as $participant) {
					$file_name = $this->exam_cards->create_pdf($participant, [
						'school_name' => __session('school_name'),
						'street_address' => __session('street_address'),
						'phone' => __session('phone'),
						'email' => __session('email'),
						'logo' => __session('logo'),
						'district' => __session('district'),
						'head_school' => __session('head_school'),
						'school_level' => __session('school_level'),
					]);
					$files[] = $file_name;
				}
			}
			$this->vars['status'] = count($files) > 0 ? 'success' : 'warning';
			$this->vars['message'] = count($files) . ' kartu ujian berhasil dicetak.';
			$this->vars['files'] = $files;
			$this->output
				->set_content_type('application/json', 'utf-8')
				->set_output(json_encode($this->vars, self::REQUIRED_FLAGS))
				->_display();
			exit;
		}
	}
}
