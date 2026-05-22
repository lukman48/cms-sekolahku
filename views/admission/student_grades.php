<?php defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('backend/grid_index');?>
<script type="text/javascript">
var _grid = 'STUDENT_GRADES', _form = _grid + '_FORM';
new GridBuilder( _grid , {
   controller:'admission/student_grades',
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
      { header:'<?=__session('_academic_year')?>', renderer:'academic_year' },
      { header:'Nama', renderer:'student_name' },
      { header:'No. Pendaftaran', renderer:'registration_number' },
      { header:'Mata Pelajaran', renderer:'subject_name' },
      { header:'Nilai', renderer:'grade' }
   ]
});

new FormBuilder( _form , {
   controller:'admission/student_grades',
   fields: [
      { label:'<?=__session('_academic_year')?>', name:'academic_year_id', type:'select', datasource: DS.ACADEMIC_YEARS },
      { label:'Nama', name:'registrant_id', type:'select', datasource: DS.REGISTRANTS },
      { label:'Mata Pelajaran', name:'student_grade_subject_id', type:'select', datasource: DS.SUBJECTS },
      { label:'Nilai', name:'grade', type:'text' }
   ]
});
</script>