<?php
  $page_title = 'Edit Detail Pengajuan';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(6);
?>

<?php
   $transaksi = find_all_global('detail_transaksi',$_GET['id'],'id');
?>
<div class="row">
  <div class="col-md-12">
    <?php echo display_msg($msg); ?>
  </div>
</div>
  <div class="row">
  <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-body">
         <div class="col-md-12">
          <form method="post" action="transaksi_db_a.php" class="clearfix">
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon-th-large"></i>
                  Penerima</span>
                  <input type="text" class="form-control" name="penerima" placeholder="Penerima" value="<?=$transaksi[0]['penerima']?>">
               </div>
              </div>

              <div class="form-group">
                <div class="input-group">
                <span class="input-group-addon">
                   <i class="glyphicon glyphicon-th-large"></i>
                  ID</span>
                  <input type="text" class="form-control" name="id" placeholder="id" value="<?=$transaksi[0]['id_penerima']?>">
               </div>
              </div>

              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon-th-large"></i>
                  Nominal</span>
                  <input type="text" id="rupiah" class="form-control" name="nominal" placeholder="Nominal" value="<?=$transaksi[0]['nominal']?>">
                  <input type="hidden" name="id_t" value="<?=$transaksi[0]['id']?>">
                  <input type="hidden" name="id_dp" value="<?=$transaksi[0]['id_detail_pengajuan']?>">
               </div>
              </div>

              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon-th-large"></i>
                  Tanggal</span>
                  <input type="date" id="rupiah" class="form-control" name="tanggal" placeholder="tanggal" value="<?=$transaksi[0]['tanggal_transaksi']?>">
               </div>
              </div>

              <div class="form-group">
                <div class="input-group">
                  <div class="input-group-text">
                  <input type="radio" name="pph1" aria-label="Checkbox for following text input" value="pph2p">                 
                    <i > PPH 23 2%</i> 
                    <input type="radio" name="pph1" aria-label="Checkbox for following text input" value="pph15p">                 
                    <i > PPH 21 15%</i> 
                    <input type="radio" name="pph1" aria-label="Checkbox for following text input" value="pph5p">                 
                    <i > PPH 21 5%</i> 
                </div>
               </div>
              </div>

              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon-th-large"></i>
                   PPH</span>
                  <input type="text" id="pph" class="form-control" name="pph" placeholder="pph" placeholder="PPH" value="<?=$transaksi[0]['pph']?>">
               </div>
              </div>

              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon-th-large"></i>
                  PPN</span>
                  <input type="text" id="ppn" class="form-control" name="ppn" placeholder="ppn" value="<?=$transaksi[0]['ppn']?>">
               </div>
              </div>

              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon-th-large"></i>
                  Keterangan</span>
                  <input type="text" class="form-control" name="keterangan" placeholder="Keterangan" value="<?=$transaksi[0]['uraian']?>">
               </div>
              </div>

              <button type="submit" name="edit_transaksi" class="btn btn-warning">Update</button>
          </form>
         </div>
        </div>
      </div>
    </div>
  </div>

<script>

var rupiah = document.getElementById('rupiah');
  rupiah.addEventListener('keyup', function(e){
    // tambahkan 'Rp.' pada saat form di ketik
    // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
    rupiah.value = formatRupiah1(this.value, 'Rp. ');
  });

  var pph = document.getElementById('pph');
		pph.addEventListener('keyup', function(e){
			// tambahkan 'Rp.' pada saat form di ketik
			// gunakan fungsi formatpph() untuk mengubah angka yang di ketik menjadi format angka
			pph.value = formatRupiah1(this.value, 'Rp. ');
		});

    var ppn = document.getElementById('ppn');
		ppn.addEventListener('keyup', function(e){
			ppn.value = formatRupiah1(this.value, 'Rp. ');
		});
</script>
