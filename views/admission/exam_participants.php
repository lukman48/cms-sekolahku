<?php defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('backend/grid_index');?>
<script type="text/javascript">
DS.AcademicYears = _H.StrToObject('<?=$academic_year_dropdown;?>');
DS.ExamRooms = _H.StrToObject('<?=$exam_room_dropdown;?>');
DS.AdmissionPhases = _H.StrToObject('<?=get_options('admission_phases')?>');

var _grid = 'EXAM_PARTICIPANTS', _form = _grid + '_FORM';
new GridBuilder( _grid , {
   controller:'admission/exam_participants',
   fields: [
      {
         header: '<input type="checkbox" class="check-all">',
         renderer: function( row ) {
            return CHECKBOX(row.id, 'id');
         },
         exclude_excel: true,
         sorting: false
      },
      {
         header: '<i class="fa fa-edit"></i>',
         renderer: function( row ) {
            return A(_form + '.OnEdit(' + row.id + ')', 'Edit');
         },
         exclude_excel: true,
         sorting: false
      },
      { header:'No. Pendaftaran', renderer:'registration_number' },
      { header:'Nama Peserta', renderer:'full_name' },
      { header:'Ruang', renderer:'room_name' },
      { header:'Nomor Kursi', renderer:'seat_number' }
   ]
});

new FormBuilder( _form , {
   controller:'admission/exam_participants',
   fields: [
      { label:_ACADEMIC_YEAR, name:'academic_year_id', type:'select', datasource:DS.AcademicYears },
      { label:'Gelombang Pendaftaran', name:'admission_phase_id', type:'select', datasource:DS.AdmissionPhases },
      { label:'Jadwal Ujian', name:'exam_schedule_id', type:'select', datasource: [] },
      { label:'Ruang Ujian', name:'exam_room_id', type:'select', datasource:DS.ExamRooms },
      { label:'Peserta', name:'registrant_id', type:'select', datasource: [] },
      { label:'Nomor Kursi', name:'seat_number', type:'text' }
   ]
});
</script>
