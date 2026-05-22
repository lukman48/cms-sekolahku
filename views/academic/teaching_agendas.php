<?php defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('backend/grid_index');?>
<script type="text/javascript">
DS.AcademicYears = _H.StrToObject('<?=$academic_year_dropdown;?>');
DS.ClassGroups = _H.StrToObject('<?=$class_group_dropdown;?>');
var _grid = 'TEACHING_AGENDAS', _form = _grid + '_FORM';
new GridBuilder( _grid , {
   controller:'academic/presences/teaching_agenda_pagination',
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
      { header:'Tanggal', renderer:'meeting_date' },
      { header:'Jam', renderer:'meeting_time' },
      { header:'Guru', renderer:'employee_name' },
      { header:'Kelas', renderer:'class_group' },
      { header:'Materi', renderer:'material_discussed' },
      { header:'Keterangan', renderer:'notes' }
   ]
});

new FormBuilder( _form , {
   controller:'academic/presences/teaching_agenda_save',
   fields: [
      { label:_ACADEMIC_YEAR, name:'academic_year_id', type:'select', datasource:DS.AcademicYears },
      { label:'Tanggal', name:'meeting_date', type:'date' },
      { label:'Jam', name:'meeting_time', type:'time' },
      { label:'Kelas', name:'class_group_setting_id', type:'select', datasource: [] },
      { label:'Materi Pembahasan', name:'material_discussed', type:'textarea' },
      { label:'Keterangan', name:'notes', type:'textarea' }
   ]
});
</script>
