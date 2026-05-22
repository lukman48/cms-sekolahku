<?php defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('backend/grid_index');?>
<script type="text/javascript">
DS.AcademicYears = _H.StrToObject('<?=$academic_year_dropdown;?>');
DS.ExamSubjects = _H.StrToObject('<?=$exam_subject_dropdown;?>');
DS.AdmissionPhases = _H.StrToObject('<?=get_options('admission_phases')?>');

var _grid = 'EXAM_SCHEDULES', _form = _grid + '_FORM';
new GridBuilder( _grid , {
   controller:'admission/exam_schedules',
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
      { header:'Hari/Tanggal', renderer:'exam_date' },
      { header:'Jam Mulai', renderer:'exam_start_time' },
      { header:'Jam Selesai', renderer:'exam_end_time' },
      { header:'Mata Pelajaran', renderer:'subject_name' },
      { header:'Gelombang', renderer:'phase_name' }
   ]
});

new FormBuilder( _form , {
   controller:'admission/exam_schedules',
   fields: [
      { label:_ACADEMIC_YEAR, name:'academic_year_id', type:'select', datasource:DS.AcademicYears },
      { label:'Gelombang Pendaftaran', name:'admission_phase_id', type:'select', datasource:DS.AdmissionPhases },
      { label:'Mata Pelajaran', name:'exam_subject_id', type:'select', datasource:DS.ExamSubjects },
      { label:'Tanggal Ujian', name:'exam_date', type:'date' },
      { label:'Jam Mulai', name:'exam_start_time', type:'time' },
      { label:'Jam Selesai', name:'exam_end_time', type:'time' }
   ]
});
</script>
