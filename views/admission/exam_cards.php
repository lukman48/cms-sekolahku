<?php defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('backend/grid_index');?>
<script type="text/javascript">
var _grid = 'EXAM_CARDS', _form = _grid + '_FORM';
new GridBuilder( _grid , {
   controller:'admission/exam_cards',
   fields: [
      { header:'<?=__session('_academic_year')?>', renderer:'academic_year' },
      { header:'Gelombang', renderer:'phase_name' },
      { header:'Mata Pelajaran', renderer:'subject_name' },
      { header:'Ruang', renderer:'room_name' },
      { header:'No. Daftar', renderer:'registration_number' },
      { header:'Nama', renderer:'full_name' },
      { header:'No. Kursi', renderer:'seat_number' },
      {
         header: '<i class="fa fa-print"></i>',
         renderer: function( row ) {
            return '<button type="button" class="btn btn-sm btn-success" onclick="print_card(' + row.id + ')"><i class="fa fa-print"></i></button>';
         },
         exclude_excel: true,
         sorting: false
      }
   ],
   disable_grid_buttons: true,
   disable_sorting: true
});

function print_card(id) {
   $.post('<?=site_url('admission/exam_cards/print_card')?>', {id: id}, function(response) {
      if (response.status === 'success') {
         toastr.success('Kartu ujian berhasil dicetak.');
      } else {
         toastr.error(response.message);
      }
   }, 'json');
}
</script>