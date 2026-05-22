<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Presences extends Admin_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model([
			'm_attendances',
			'm_teaching_agendas',
			'm_academic_years',
			'm_class_groups',
			'm_class_group_settings',
			'm_class_group_students',
		]);
		$this->pk = M_attendances::$pk;
		$this->table = M_attendances::$table;
	}

	public function index() {
		$this->vars['title'] = 'Presensi Siswa';
		$this->vars['academic'] = $this->vars['presences'] = TRUE;
		$this->vars['academic_year_dropdown'] = json_encode($this->m_academic_years->dropdown(), JSON_HEX_APOS | JSON_HEX_QUOT);
		$this->vars['class_group_dropdown'] = json_encode($this->m_class_groups->dropdown(), JSON_HEX_APOS | JSON_HEX_QUOT);
		$this->vars['content'] = 'academic/presences';
		$this->load->view('backend/index', $this->vars);
	}

	public function pagination() {
		if ($this->input->is_ajax_request()) {
			$keyword = trim($this->input->post('keyword', true));
			$page_number = _toInteger($this->input->post('page_number', true));
			$limit = _toInteger($this->input->post('per_page', true));
			$offset = ($page_number * $limit);
			$query = $this->m_attendances->get_where($keyword, 'rows', $limit, $offset);
			$total_rows = $this->m_attendances->get_where($keyword);
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
			'student_id' => _toInteger($this->input->post('student_id', true)),
			'attendance_date' => $this->input->post('attendance_date', true),
			'attendance_status' => $this->input->post('attendance_status', true),
			'notes' => $this->input->post('notes', true)
		];
	}

	private function validation() {
		$this->load->library('form_validation');
		$val = $this->form_validation;
		$val->set_rules('academic_year_id', __session('_academic_year'), 'trim|is_natural_no_zero|required');
		$val->set_rules('student_id', __session('_student'), 'trim|is_natural_no_zero|required');
		$val->set_rules('attendance_date', 'Tanggal', 'trim|required');
		$val->set_rules('attendance_status', 'Status Presensi', 'trim|required');
		$val->set_message('required', '{field} harus diisi');
		$val->set_message('is_natural_no_zero', '{field} harus diisi');
		$val->set_error_delimiters('<div>&sdot; ', '</div>');
		return $val->run();
	}

	public function teaching_agendas() {
		$this->vars['title'] = 'Agenda Mengajar';
		$this->vars['academic'] = $this->vars['teaching_agendas'] = TRUE;
		$this->vars['academic_year_dropdown'] = json_encode($this->m_academic_years->dropdown(), JSON_HEX_APOS | JSON_HEX_QUOT);
		$this->vars['class_group_dropdown'] = json_encode($this->m_class_groups->dropdown(), JSON_HEX_APOS | JSON_HEX_QUOT);
		$this->vars['content'] = 'academic/teaching_agendas';
		$this->load->view('backend/index', $this->vars);
	}

	public function teaching_agenda_save() {
		if ($this->input->is_ajax_request()) {
			$id = _toInteger($this->input->post('id', true));
			if ($this->teaching_agenda_validation()) {
				$dataset = [
					'academic_year_id' => _toInteger($this->input->post('academic_year_id', true)),
					'employee_id' => __session('user_type') === 'employee' ? __session('user_profile_id') : _toInteger($this->input->post('employee_id', true)),
					'class_group_setting_id' => _toInteger($this->input->post('class_group_setting_id', true)),
					'meeting_date' => $this->input->post('meeting_date', true),
					'meeting_time' => $this->input->post('meeting_time', true),
					'material_discussed' => $this->input->post('material_discussed', true),
					'notes' => $this->input->post('notes', true)
				];
				$dataset[(_isNaturalNumber( $id ) ? 'updated_by' : 'created_by')] = __session('user_id');
				if (!_isNaturalNumber( $id )) $dataset['created_at'] = date('Y-m-d H:i:s');
				$query = $this->model->upsert($id, M_teaching_agendas::$table, $dataset);
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

	public function teaching_agenda_pagination() {
		if ($this->input->is_ajax_request()) {
			$this->load->model('m_teaching_agendas');
			$keyword = trim($this->input->post('keyword', true));
			$page_number = _toInteger($this->input->post('page_number', true));
			$limit = _toInteger($this->input->post('per_page', true));
			$offset = ($page_number * $limit);
			$query = $this->m_teaching_agendas->get_where($keyword, 'rows', $limit, $offset);
			$total_rows = $this->m_teaching_agendas->get_where($keyword);
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

	private function teaching_agenda_validation() {
		$this->load->library('form_validation');
		$val = $this->form_validation;
		$val->set_rules('academic_year_id', __session('_academic_year'), 'trim|is_natural_no_zero|required');
		$val->set_rules('meeting_date', 'Tanggal', 'trim|required');
		$val->set_message('required', '{field} harus diisi');
		$val->set_message('is_natural_no_zero', '{field} harus diisi');
		$val->set_error_delimiters('<div>&sdot; ', '</div>');
		return $val->run();
	}

	public function get_class_group_students() {
		if ($this->input->is_ajax_request()) {
			$class_group_setting_id = _toInteger($this->input->post('class_group_setting_id', true));
			$rows = $this->m_class_group_students->get_students($class_group_setting_id);
			$this->vars['rows'] = $rows;
			$this->output
				->set_content_type('application/json', 'utf-8')
				->set_output(json_encode($this->vars, self::REQUIRED_FLAGS))
				->_display();
			exit;
		}
	}

	public function save_batch() {
		if ($this->input->is_ajax_request()) {
			$attendances = json_decode($this->input->post('attendances', true), true);
			$academic_year_id = _toInteger($this->input->post('academic_year_id', true));
			$attendance_date = $this->input->post('attendance_date', true);
			$success = 0;
			$errors = 0;
			if (is_array($attendances)) {
				foreach ($attendances as $att) {
					$dataset = [
						'academic_year_id' => $academic_year_id,
						'student_id' => _toInteger($att['student_id']),
						'attendance_date' => $attendance_date,
						'attendance_status' => $att['attendance_status'],
						'created_by' => __session('user_id'),
						'created_at' => date('Y-m-d H:i:s')
					];
					if ($this->db->insert('attendances', $dataset)) {
						$success++;
					} else {
						$errors++;
					}
				}
			}
			$this->vars['status'] = $errors == 0 ? 'success' : 'warning';
			$this->vars['message'] = $success . ' data berhasil disimpan.' . ($errors > 0 ? ' ' . $errors . ' data gagal.' : '');
			$this->output
				->set_content_type('application/json', 'utf-8')
				->set_output(json_encode($this->vars, self::REQUIRED_FLAGS))
				->_display();
			exit;
		}
	}
}
