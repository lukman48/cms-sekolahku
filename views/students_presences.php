<?php defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('backend/grid_index');?>
<script type="text/javascript">
var _grid = 'STUDENT_PRESENCES';
var attendanceStatus = { present:'Hadir', absent:'Tidak Hadir', sick:'Sakit', permit:'Izin' };
new GridBuilder( _grid , {
   controller:'student_profile/presences_pagination',
   fields: [
      { header:'Tanggal', renderer:'attendance_date' },
      {
         header:'Status',
         renderer: function( row ) {
            return attendanceStatus[row.attendance_status] || row.attendance_status;
         }
      },
      { header:'Keterangan', renderer:'notes' }
   ],
   disable_grid_buttons: true,
   disable_sorting: true
});
</script>
