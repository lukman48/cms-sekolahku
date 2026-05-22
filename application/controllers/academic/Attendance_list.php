<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Attendance_list extends Admin_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model(['m_attendances', 'm_academic_years', 'm_class_groups']);
	}

	public function index() {
		$this->vars['title'] = 'Cetak Rekap Presensi';
		$this->vars['academic'] = $this->vars['attendance_list'] = TRUE;
		$this->vars['academic_year_dropdown'] = json_encode($this->m_academic_years->dropdown(), JSON_HEX_APOS | JSON_HEX_QUOT);
		$this->vars['class_group_dropdown'] = json_encode($this->m_class_groups->dropdown(), JSON_HEX_APOS | JSON_HEX_QUOT);
		$this->vars['content'] = 'academic/attendance_list';
		$this->load->view('backend/index', $this->vars);
	}

	public function print_pdf() {
		if ($this->input->is_ajax_request()) {
			$academic_year_id = _toInteger($this->input->post('academic_year_id', true));
			$class_group_id = _toInteger($this->input->post('class_group_id', true));
			$start_date = $this->input->post('start_date', true);
			$end_date = $this->input->post('end_date', true);
			$data = $this->m_attendances->get_attendance_report($academic_year_id, $class_group_id, $start_date, $end_date);
			if ($data->num_rows() > 0) {
				$this->load->library('tcpdf');
				$pdf = new TCPDF('L', 'mm', 'A4', true, 'UTF-8', false);
				$pdf->SetTitle('REKAP PRESENSI SISWA');
				$pdf->SetMargins(5, 5, 5, true);
				$pdf->SetAutoPageBreak(TRUE, 10);
				$pdf->AddPage();
				$pdf->SetFont('freesans', '', 9);
				$html = '
				<h2 style="text-align:center;">REKAP PRESENSI SISWA</h2>
				<table width="100%" border="1" cellpadding="3" cellspacing="0">
					<thead>
						<tr>
							<th>No</th>
							<th>NIS</th>
							<th>Nama</th>
							<th>Tanggal</th>
							<th>Status</th>
							<th>Keterangan</th>
						</tr>
					</thead>
					<tbody>';
				$no = 1;
				foreach ($data->result() as $row) {
					$html .= '<tr>
						<td>' . $no++ . '</td>
						<td>' . $row->identity_number . '</td>
						<td>' . $row->student_name . '</td>
						<td>' . indo_date($row->attendance_date) . '</td>
						<td>' . $row->attendance_status . '</td>
						<td>' . $row->notes . '</td>
					</tr>';
				}
				$html .= '</tbody></table>';
				$pdf->writeHTML($html, true, false, true, false, 'C');
				$file_name = 'rekap-presensi-' . date('Ymd') . '.pdf';
				$pdf->Output(FCPATH . 'media_library/students/' . $file_name, 'F');
				$this->vars['status'] = 'success';
				$this->vars['file_name'] = $file_name;
			} else {
				$this->vars['status'] = 'warning';
				$this->vars['message'] = 'Tidak ada data presensi pada periode yang dipilih.';
			}
			$this->output
				->set_content_type('application/json', 'utf-8')
				->set_output(json_encode($this->vars, self::REQUIRED_FLAGS))
				->_display();
			exit;
		}
	}
}
