<?php defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('backend/grid_index');?>
<script type="text/javascript">
DS.AcademicYears = _H.StrToObject('<?=$academic_year_dropdown;?>');
DS.ClassGroups = _H.StrToObject('<?=$class_group_dropdown;?>');
var _grid = 'PRESENCES', _form = _grid + '_FORM';
new GridBuilder( _grid , {
   controller:'academic/presences',
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
      { header:_IDENTITY_NUMBER, renderer:'identity_number' },
      { header:'Nama ' + _STUDENT, renderer:'student_name' },
      { header:'Kelas', renderer:'class_group' },
      { header:'Tanggal', renderer:'attendance_date' },
      { header:'Status', renderer:'attendance_status' },
      { header:'Keterangan', renderer:'notes' }
   ]
});

new FormBuilder( _form , {
   controller:'academic/presences',
   fields: [
      { label:_ACADEMIC_YEAR, name:'academic_year_id', type:'select', datasource:DS.AcademicYears },
      { label:_STUDENT, name:'student_id', type:'select', datasource: [] },
      { label:'Tanggal', name:'attendance_date', type:'date' },
      { label:'Status Presensi', name:'attendance_status', type:'select', datasource: { present:'Hadir', absent:'Tidak Hadir', sick:'Sakit', permit:'Izin' } },
      { label:'Keterangan', name:'notes', type:'textarea' }
   ]
});

function batch_attendance() {
   $('.grid-button').html('<button class="btn btn-success btn-sm" onclick="open_batch_form()"><i class="fa fa-plus"></i> Presensi Massal</button>');
}
batch_attendance();

function open_batch_form() {
   var academic_year_id = prompt('Masukkan ID ' + _ACADEMIC_YEAR + ':');
   if (academic_year_id) {
      window.location.href = _BASE_URL + 'academic/presences/batch/' + academic_year_id;
   }
}
</script>
