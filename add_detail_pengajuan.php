<?php
  $page_title = 'Add Detail Pengajuan';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(6);
  
  $all_categories = find_all('jenis');
  $all_photo = find_all('media');
?>

<?php
 if(isset($_POST['add_detail_pengajuan'])){
   $req_fields = array('no_sptjb','nominal','id_akun','pph','ppn');
   validate_fields($req_fields);
   var_dump($_POST);
   $teks5 = $_POST['nominal'];
  $nominal = preg_replace("/[^0-9]/", "", $teks5);
  
 

   if(empty($errors)){
     $no_sptjb  = remove_junk($db->escape($_POST['no_sptjb']));
     $nominal  = remove_junk($db->escape($nominal));
      $akun  = remove_junk($db->escape($_POST['id_akun']));

     if($db->escape($_POST['pph'])==''){
      $pph=0;
     }else{
      $pph = preg_replace("/[^0-9]/", "", $_POST['pph']);
    // $pph  = remove_junk($db->escape($_POST['pph']));
     }
     if($db->escape($_POST['ppn'])==''){
      $ppn=0;
     }else{
      $ppn = preg_replace("/[^0-9]/", "", $_POST['ppn']);
     //$ppn  = remove_junk($db->escape($_POST['ppn']));
     }

     $keterangan   = remove_junk($db->escape($_POST['keterangan']));
     $date    = make_date();
     $id_pengajuan = remove_junk($db->escape($_GET['id']));
     $query  = "INSERT INTO detail_pengajuan (";
     $query .=" no_sptjb,nominal,id_akun,keterangan,id_pengajuan,pph,ppn";
     $query .=") VALUES (";
     $query .=" '{$no_sptjb}', '{$nominal}', '{$akun}', '{$keterangan}', '{$id_pengajuan}','{$pph}','{$ppn}'";
     $query .=")";
     if($db->query($query)){
       $session->msg('s',"Detail Pengajuan added ");
       redirect('detail_pengajuan.php?id='.$_GET["id"], false);
     } else {
       $session->msg('d',' Sorry failed to added!');
       redirect('detail_pengajuan.php?id='.$_GET["id"], false);
     }

   } else{
     $session->msg("d", $errors);
     redirect('detail_pengajuan.php?id='.$_GET["id"],false);
   }

 }

?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
  <div class="col-md-12">
    <?php echo display_msg($msg); ?>
  </div>
</div>
  <div class="row">
  <div class="col-md-8">
      <div class="panel panel-default">
        <div class="panel-heading">
          <strong>
            <span class="glyphicon glyphicon-th"></span>
            <span>Add New Detail Pengajuan</span>
         </strong>
        </div>
        <div class="panel-body">
         <div class="col-md-12">
          <form method="post" action="" class="clearfix">
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon-th-large"></i>
                  </span>
                  <input type="text" class="form-control" name="no_sptjb" placeholder="NO SPTJB">
               </div>
              </div>

              <div class="form-group">
                <div class="input-group">
                <span class="input-group-addon">
                   <i class="glyphicon glyphicon-th-large"></i>
                  Akun</span>
                  <select class="form-control" name="id_akun">
                      <option value="">Pilih Jenis Pengajuan</option>
                      <?php $user=find_by_id('users',$_SESSION['user_id']); $jenis = find_all_global('akun',$user['id_satker'],'id_satker');//var_dump($jenis);exit();?>
                    <?php  foreach ($jenis as $j): ?>
                      <option value="<?php echo (int)$j['id'] ?>">
                        <?php echo $j['keterangan'] ?>-<?php echo $j['mak'] ?></option>
                    <?php endforeach; ?>
                </select>
               </div>
              </div>

              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon-th-large"></i>
                  </span>
                  <input type="text" id="rupiah" class="form-control" name="nominal" placeholder="Nominal">
               </div>
              </div>

              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon-th-large"></i>
                   PPH</span>
                  <input type="text" id="pph" class="form-control" name="pph" placeholder="pph" value="0" placeholder="PPH">
               </div>
              </div>

              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon-th-large"></i>
                  PPN</span>
                  <input type="text" id="ppn" class="form-control" name="ppn" placeholder="ppn" value="0">
               </div>
              </div>

              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon-th-large"></i>
                  </span>
                  <input type="text" class="form-control" name="keterangan" placeholder="Keterangan">
               </div>
              </div>

              <button type="submit" name="add_detail_pengajuan" class="btn btn-danger">Add Detail pengajuan</button>
          </form>
         </div>
        </div>
      </div>
    </div>
  </div>



<?php include_once('layouts/footer.php'); ?>
