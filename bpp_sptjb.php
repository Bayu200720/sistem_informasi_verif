<?php
  $page_title = 'All Pengajuan';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
?>
<?php
 //delete pencairan
 //var_dump($_GET['status']);exit();
$status= $_GET['status'];


 if(isset($_POST['sptjb'])){
   $req_fields = array('no_sptjb','nominal','id_akun','tanggal');
   validate_fields($req_fields);
   var_dump($_POST);
   $teks5 = $_POST['nominal'];
    $nominal = preg_replace("/[^0-9]/", "", $teks5);
  
 

  if(empty($errors)){
     $no_sptjb  = remove_junk($db->escape($_POST['no_sptjb']));
     $tanggal  = remove_junk($db->escape($_POST['tanggal']));
     $nominal  = remove_junk($db->escape($nominal));
      $akun  = remove_junk($db->escape($_POST['id_akun']));

    

     if($db->escape($_POST['pph'])==''){
      $pph=0;
     }else{
      $pph = preg_replace("/[^0-9]/", "", $_POST['pph']);
     }
     if($db->escape($_POST['ppn'])==''){
      $ppn=0;
     }else{
      $ppn = preg_replace("/[^0-9]/", "", $_POST['ppn']);
     //$ppn  = remove_junk($db->escape($_POST['ppn']));
     }

    if($_POST['pph1'] == 'pph5p'){
      $pph = $nominal * 5/100;
    }else if($_POST['pph1']== 'pph15p'){
      $pph = $nominal * 15/100;
    }else if($_POST['pph1']== 'pph2p'){
      $pph = $nominal * 2/100;
    }else if($_POST['pph1']=='pph'){
      $pph=0;
    }
    //var_dump($_POST['pph1']);
    //var_dump($pph);exit();

     $keterangan   = remove_junk($db->escape($_POST['keterangan']));
     $date    = make_date();
     $id_pengajuan = remove_junk($db->escape($_GET['id']));
     $query  = "INSERT INTO detail_pengajuan (";
     $query .=" no_sptjb,nominal,id_akun,keterangan,id_pengajuan,pph,ppn,tanggal_dp";
     $query .=") VALUES (";
     $query .=" '{$no_sptjb}', '{$nominal}', '{$akun}', '{$keterangan}', '{$id_pengajuan}','{$pph}','{$ppn}','{$tanggal}'";
     $query .=")";
     if($db->query($query)){
       $session->msg('s',"Detail Pengajuan added ");
       redirect('bpp_sptjb.php?id='.$_GET["id"], false);
     } else {
       $session->msg('d',' Sorry failed to added!');
       redirect('bpp_sptjb.php?id='.$_GET["id"], false);
     }

   } else{
     $session->msg("d", $errors);
     redirect('bpp_sptjb.php?id='.$_GET["id"],false);
   }

 }



  $user = find_by_id('users',$_SESSION['user_id']); 

$sales = find_sptb_5pum_tahun($user['id_satker']);

?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
  <div class="col-md-6">
    <?php echo display_msg($msg); ?>
  </div>
</div>
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading clearfix">
          <strong>
            <span class="glyphicon glyphicon-th"></span>
            <span>SPTJB</span>
          </strong>
          <div class="pull-right">
          <a href="#" class="btn btn-primary" id="editsp2d" data-toggle="modal" data-target="#exampleModal" data-id='<?=$sale['id'];?>'>Add SPTJB</a>
          </div>
        </div>
        <div class="panel-body"  style="width: 100%;">
          <table id="tabel" class="table table-bordered table-striped" style="width: 100%;">
            <thead>
              <tr>
                <th> Tanggal </th>
                <th> Nomor SPM </th>
                <th class="text-center" style="width: 15%;"> Nomor SPTJB</th>
                <th class="text-center" style="width: 15%;"> Jumlah</th>          
                <th class="text-center" style="width: 15%;">Status</th>
                <th class="text-center" style="width: 15%;">Aksi</th>
             </tr>
            </thead>
           <tbody>
             <?php foreach ($sales as $sale):?>
             <tr>
               <td class="text-center"><?=$sale['tanggal_dp']?></td>
               <td class="text-center"><?=$sale['spm']?></td>
               <td class="text-center"><?=$sale['no_sptjb']?></td>
               <td class="text-center"><?=rupiah($sale['nominal']); ?></td>
               <td class="text-center"><?=$sale['keterangan'];?></td>
               <td style="display: none"></td>
            <td class="text-center">
                 <div class="btn-group">
                 
                     <a href="#" id="editpencairan" data-toggle="modal" data-target="#EditPanjar" data-id='<?=$sale['id'];?>' data-keterangan='<?=$sale['keterangan'];?>' data-tanggal='<?=$sale['tanggal'];?>' data-nominal='<?=$sale['nominal'];?>' data-spm='<?=$sale['spm'];?>' data-id_satker="<?=$sale['id_satker']?>" data-uraian="<?=$sale['spm']?>" class="btn btn-warning btn-xs" class="btn-edit" title="Edit" >
                       <span class="glyphicon glyphicon-edit"></span>
                     </a>
                     <a onclick="return confirm('Yakin Hapus?')" href="bpp_sptjb?id=<?php echo (int)$sale['id'];?>&status=pencairan" class="btn btn-danger btn-xs"  title="Delete" data-toggle="tooltip">
                       <span class="glyphicon glyphicon-trash"></span>
                     </a>
                  </div>
            </td>
                
             </tr>
            <?php endforeach;?>
           </tbody>
         </table>
        
        </div>
      </div>
    </div>
  </div>



<!-- Modal -->
<div class="modal fade" id="EditPanjar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Panjar</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="bpp_sptjb" method="POST">
        <div class="modal-body">
          <div class="form-group">
                <label for="exampleInputEmail1">Uraian</label>
                <select name="uraian" id="uraian" class="form-control">
                  <?php 
                    $data = find_all('master_panjar');
                    foreach($data as $key => $value):?>
                      <option value="<?php echo $value['name'] ?>"><?php echo $value['name'] ?></option>
                  <?php endforeach;?>
                </select>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Tanggal</label>
                <input type="date" class="form-control" id="tanggal" name="tanggal" placeholder="tanggal">
                <input type="hidden" class="form-control" id="id" name="id" >
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Nominal</label>
                <input type="text" class="form-control" id="nominal" name="nominal" placeholder="Nominal">
            </div>
            <div class="form-group">
                    <label for="exampleInputEmail1">Satker</label>
                        <select class="form-control" id="id_satker" name="id_satker">
                            <option value="">Pilih Satker</option>
                            <?php $jenis = find_all('satker');?>
                            <?php  foreach ($jenis as $j): ?>
                            <option value="<?php echo (int)$j['id'] ?>">
                                <?php echo $j['keterangan'] ?></option>
                            <?php endforeach; ?>
                        </select>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Keterangan</label>
                <input type="text" class="form-control" id="keterangan" name="keterangan" placeholder="Keterangan">
            </div>
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" name="UpdatePanjar">Update</button>
      </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal input sp2d-->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"  aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add SPTJB</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="bpp_sptjb.php" method="POST">
      <div class="modal-body">
      
        <div class="form-group">
            <label for="exampleInputEmail1">Tanggal</label>
            <input type="date" class="form-control" id="tanggal" name="tanggal" placeholder="tanggal">
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Nomor SPTJB</label>
            <input type="number" class="form-control" id="no_sptjb" name="no_sptjb" placeholder="no_sptjb">
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">MAK</label>
            <select name="id_akun" class="form-control">
              <?php $user=find_by_id('users',$_SESSION['user_id']); $jenis = find_all_global('akun',$user['id_satker'],'id_satker');//var_dump($jenis);exit();?>
              <?php  foreach ($jenis as $j): ?>
                <option value="<?php echo (int)$j['id'] ?>">
                  <?php echo $j['id'] ?>-<?php echo $j['mak'] ?></option>
              <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Jumlah</label>
            <input type="number" class="form-control" id="nominal" name="nominal" placeholder="nominal">
        </div>
        <div class="form-group">
          <div class="input-group">
            <div class="input-group-text">
              <input type="radio" name="pph1" aria-label="Checkbox for following text input" value="pph2p">
              <label for="pph2p"><i > PPH 21 5%</i> </label>
              <input type="radio" name="pph1" aria-label="Checkbox for following text input" value="pph15p">
              <label for="pph15p"><i > PPH 21 15%</i> </label>
              <input type="radio" name="pph1" aria-label="Checkbox for following text input" value="pph5p">       
              <label for="pph5p"><i > PPH 23 2%</i></label>
              <input type="radio" name="pph1" aria-label="Checkbox for following text input" value="ppn">       
              <label for="pph5p"><i > PPN 10%</i></label>
          </div>
         </div>
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">PPH</label>
            <input type="number" class="form-control" id="pph" name="pph" placeholder="pph">
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">PPN</label>
            <input type="number" class="form-control" id="ppn" name="ppn" placeholder="ppn">
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Keterangan</label>
            <input type="text" class="form-control" id="keterangan" name="keterangan" placeholder="keterangan">
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <input type="submit" class="btn btn-primary" name="sptjb" value="Save">
      </div>
      </form>
    </div>
  </div>
</div>

<?php include_once('layouts/footer.php'); ?>

<script>
  $(document).ready(function(){
    $('.btn-edit').on('click', function(){
      $('#id_satker').val($(this).data('id_satker'));
      $('#uraian').val($(this).data('uraian'));
    });
  })
</script>