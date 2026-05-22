<?php defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('backend/grid_index');?>
<script type="text/javascript">
DS.AcademicYears = _H.StrToObject('<?=$academic_year_dropdown;?>');
var _grid = 'EXAM_SUBJECTS', _form = _grid + '_FORM';
new GridBuilder( _grid , {
   controller:'admission/exam_subjects',
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
      { header:_ACADEMIC_YEAR, renderer:'academic_year' },
      { header:'Mata Pelajaran', renderer:'subject_name' },
      { header:'Urutan', renderer:'subject_order' }
   ]
});

new FormBuilder( _form , {
   controller:'admission/exam_subjects',
   fields: [
      { label:_ACADEMIC_YEAR, name:'academic_year_id', type:'select', datasource:DS.AcademicYears },
      { label:'Mata Pelajaran', name:'subject_name', type:'text' },
      { label:'Urutan', name:'subject_order', type:'number' }
   ]
});
</script>
