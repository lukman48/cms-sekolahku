<?php defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('backend/grid_index');?>
<script type="text/javascript">
DS.Buildings = _H.StrToObject('<?=$building_dropdown;?>');
var _grid = 'EXAM_ROOMS', _form = _grid + '_FORM';
new GridBuilder( _grid , {
   controller:'admission/exam_rooms',
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
      { header:'Gedung', renderer:'building_name' },
      { header:'Nama Ruang', renderer:'room_name' },
      { header:'Kapasitas', renderer:'room_capacity' }
   ]
});

new FormBuilder( _form , {
   controller:'admission/exam_rooms',
   fields: [
      { label:'Gedung', name:'building_id', type:'select', datasource:DS.Buildings },
      { label:'Nama Ruang', name:'room_name', type:'text' },
      { label:'Kapasitas', name:'room_capacity', type:'number' }
   ]
});
</script>
