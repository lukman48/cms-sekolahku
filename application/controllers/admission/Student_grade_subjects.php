<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Student_grade_subjects extends Admin_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model(['m_student_grade_subjects', 'm_academic_years']);
		$this->pk = M_student_grade_subjects::$pk;
		$this->table = M_student_grade_subjects::$table;
	}

	public function index() {
		$this->vars['title'] = 'Master Mata Pelajaran Nilai Rapor';
		$this->vars['admission'] = $this->vars['student_grade_subjects'] = TRUE;
		$this->vars['academic_year_dropdown'] = json_encode($this->m_academic_years->dropdown(), JSON_HEX_APOS | JSON_HEX_QUOT);
		$this->vars['content'] = 'admission/student_grade_subjects';
		$this->load->view('backend/index', $this->vars);
	}

	public function pagination() {
		if ($this->input->is_ajax_request()) {
			$keyword = trim($this->input->post('keyword', true));
			$page_number = _toInteger($this->input->post('page_number', true));
			$limit = _toInteger($this->input->post('per_page', true));
			$offset = ($page_number * $limit);
			$query = $this->m_student_grade_subjects->get_where($keyword, 'rows', $limit, $offset);
			$total_rows = $this->m_student_grade_subjects->get_where($keyword);
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
			'academic_year_id' => _toInteger($this->input->post('academic_year_id', true)),
			'subject_name' => $this->input->post('subject_name', true)
		];
	}

	private function validation() {
		$this->load->library('form_validation');
		$val = $this->form_validation;
		$val->set_rules('academic_year_id', __session('_academic_year'), 'trim|is_natural_no_zero|required');
		$val->set_rules('subject_name', 'Nama Mata Pelajaran', 'trim|required');
		$val->set_message('required', '{field} harus diisi');
		$val->set_message('is_natural_no_zero', '{field} harus diisi');
		$val->set_error_delimiters('<div>&sdot; ', '</div>');
		return $val->run();
	}
}
