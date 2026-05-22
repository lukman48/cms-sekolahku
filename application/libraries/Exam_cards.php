<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Exam_cards extends TCPDF {

	protected $CI;

	public function __construct() {
		parent::__construct('P', 'mm', 'A4', true, 'UTF-8', false);
		$this->CI = &get_instance();
	}

	public function Header() {
	}

	public function Footer() {
		$str = '<table width="100%" border="0" cellpadding="2" cellspacing="0" style="border-top:1px solid #000000;">';
		$str .= '<tbody><tr>';
		$str .= '<td align="left" width="60%">Kartu Ujian ini berlaku sesuai jadwal yang tertera.</td>';
		$str .= '<td align="right" width="40%">Dicetak tanggal ' . indo_date(date('Y-m-d')) . ' pukul ' . date('H:i:s') . '</td>';
		$str .= '</tr></tbody></table>';
		$this->setY(-1);
		$this->writeHTML($str, true, false, true, false, 'L');
	}

	public function create_pdf($participant, $school_info) {
		$this->setHeaderFont([PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN]);
		$this->setFooterFont([PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA]);
		$this->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
		$this->SetAutoPageBreak(TRUE, 1);
		$this->setImageScale(PDF_IMAGE_SCALE_RATIO);
		$this->SetTitle('KARTU UJIAN TES TULIS');
		$this->SetAuthor($school_info['school_name']);
		$this->SetMargins(5, 1, 5, true);
		$this->AddPage();
		$this->SetFont('freesans', '', 10);

		$str = '
		<table width="100%" border="0" cellpadding="2" cellspacing="0" style="border-bottom:1px solid #000000;">
			<tbody>
				<tr>
					<td width="20%" align="center" valign="top">
						<img src="' . base_url('media_library/images/' . $school_info['logo']) . '" width="70px">
					</td>
					<td width="80%" valign="top" align="left">
						<br>
						<h2 style="line-height: 1.5em;">' . strtoupper($school_info['school_name']) . '</h2>
						<p>' . $school_info['street_address'] . '<br>
						Telp : ' . $school_info['phone'] . ' &sdot; Email : ' . $school_info['email'] . '</p>
					</td>
				</tr>
			</tbody>
		</table>
		<h3 style="text-align:center;">KARTU UJIAN TES TULIS</h3>
		<table width="100%" cellpadding="4" cellspacing="0" border="1">
			<tbody>
				<tr>
					<td width="35%">Nomor Pendaftaran</td>
					<td width="65%">' . $participant['registration_number'] . '</td>
				</tr>
				<tr>
					<td>Nama Lengkap</td>
					<td>' . $participant['full_name'] . '</td>
				</tr>
				<tr>
					<td>Jenis Kelamin</td>
					<td>' . $participant['gender'] . '</td>
				</tr>
				<tr>
					<td>Gedung / Ruang Ujian</td>
					<td>' . $participant['building_name'] . ' / ' . $participant['room_name'] . '</td>
				</tr>
				<tr>
					<td>Nomor Kursi</td>
					<td>' . $participant['seat_number'] . '</td>
				</tr>
				<tr>
					<td>Hari / Tanggal Ujian</td>
					<td>' . indo_date($participant['exam_date']) . '</td>
				</tr>
				<tr>
					<td>Jam Ujian</td>
					<td>' . $participant['exam_start_time'] . ' - ' . $participant['exam_end_time'] . '</td>
				</tr>
			</tbody>
		</table>
		<br>
		<table width="100%" cellpadding="4" cellspacing="0">
			<tbody>
				<tr>
					<td align="left" width="50%">' . $school_info['district'] . ', ' . indo_date(date('Y-m-d')) . '</td>
					<td align="right" width="50%">Panitia,</td>
				</tr>
				<tr><td colspan="2"><br><br><br></td></tr>
				<tr>
					<td align="left" width="50%">(' . $participant['full_name'] . ')</td>
					<td align="right" width="50%">(' . $school_info['head_school'] . ')</td>
				</tr>
				<tr>
					<td align="left">Peserta Ujian</td>
					<td align="right">Kepala ' . strtoupper($school_info['school_level'] >= 5 ? 'Universitas' : 'Sekolah') . '</td>
				</tr>
			</tbody>
		</table>';

		$this->writeHTML($str, true, false, true, false, 'C');
		$file_name = 'kartu-ujian-' . $participant['registration_number'] . '.pdf';
		$this->Output(FCPATH . 'media_library/students/' . $file_name, 'F');
		return $file_name;
	}
}
