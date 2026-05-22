<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<script type="text/javascript">
$(document).ready(function() {
   $('#btn-print').click(function() {
      var academic_year_id = $('#academic_year_id').val();
      var class_group_id = $('#class_group_id').val();
      var start_date = $('#start_date').val();
      var end_date = $('#end_date').val();
      if (!academic_year_id || !class_group_id) {
         toastr.error('Pilih tahun akademik dan kelas terlebih dahulu.');
         return;
      }
      $.post('<?=site_url('academic/attendance_list/print_pdf')?>', {
         academic_year_id: academic_year_id,
         class_group_id: class_group_id,
         start_date: start_date,
         end_date: end_date
      }, function(response) {
         if (response.status === 'success') {
            toastr.success('Rekap presensi berhasil dicetak.');
         } else {
            toastr.error(response.message);
         }
      }, 'json');
   });
});
</script>
<div class="panel panel-default">
   <div class="panel-heading"><i class="fa fa-print"></i> Cetak Rekap Presensi</div>
   <div class="panel-body">
      <div class="row">
         <div class="col-sm-4">
            <div class="form-group">
               <label><?=__session('_academic_year')?></label>
               <select id="academic_year_id" class="form-control">
                  <option value="">Pilih :</option>
                  <?php
                  $years = json_decode($academic_year_dropdown, true);
                  foreach ($years as $key => $value) {
                     echo '<option value="'.$key.'">'.$value.'</option>';
                  }
                  ?>
               </select>
            </div>
         </div>
         <div class="col-sm-4">
            <div class="form-group">
               <label>Kelas</label>
               <select id="class_group_id" class="form-control">
                  <option value="">Pilih :</option>
                  <?php
                  $classes = json_decode($class_group_dropdown, true);
                  foreach ($classes as $key => $value) {
                     echo '<option value="'.$key.'">'.$value.'</option>';
                  }
                  ?>
               </select>
            </div>
         </div>
      </div>
      <div class="row">
         <div class="col-sm-4">
            <div class="form-group">
               <label>Tanggal Awal</label>
               <input type="text" id="start_date" class="form-control date" placeholder="Kosongkan jika semua">
            </div>
         </div>
         <div class="col-sm-4">
            <div class="form-group">
               <label>Tanggal Akhir</label>
               <input type="text" id="end_date" class="form-control date" placeholder="Kosongkan jika semua">
            </div>
         </div>
      </div>
      <div class="row">
         <div class="col-sm-4">
            <button id="btn-print" class="btn btn-primary"><i class="fa fa-print"></i> Cetak Rekap</button>
         </div>
      </div>
   </div>
</div>
<script type="text/javascript">
$(document).find('input.date').datetimepicker({
   format: 'yyyy-mm-dd',
   weekStart: 1,
   todayBtn: 1,
   autoclose: 1,
   todayHighlight: 1,
   startView: 2,
   minView: 2,
   forceParse: 0
});
</script>