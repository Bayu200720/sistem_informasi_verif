<?php
  $page_title = 'All Pengajuan';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(3);
?>
<?php
$sales = find_pengajuanok();

if(isset($_POST['update_sp2d'])){
  $req_fields = array('sp2d', 'id' );
  validate_fields($req_fields);
      if(empty($errors)){
        $p_id      = $db->escape($_POST['id']);
        $sp2d     = $db->escape($_POST['sp2d']);
        
        $sql  = "UPDATE pengajuan SET";
        $sql .= " sp2d='{$sp2d}'";
        $sql .= " WHERE id ='{$p_id}'";
        $result = $db->query($sql);
        if( $result && $db->affected_rows() === 1){
                 //$h= update_product_qty_ok($p_id);
                    $session->msg('s',"SP2D updated.");
                  redirect('pengajuan_spm.php', false);
                } else {
                  $session->msg('d',' Sorry failed to updated!');
                  redirect('pengajuan_spm.php', false);
                }
      } else {
         $session->msg("d", $errors);
         redirect('pengajuan_spm.php',false);
      }
}

if(isset($_GET['s'])){
  if($_GET['s'] == 'spm'){
    $pengajuan = find_by_id('pengajuan',$_GET['id']);//var_dump($pengajuan);exit();
  $query  = "UPDATE pengajuan SET ";
        $query .= "file_spm=''";
        $query .= "WHERE id='{$pengajuan["id"]}'";
        $result = $db->query($query);
        $session->msg('s',' Berhasil di Batalkan');
        
      redirect('pengajuan_spm.php');
  }else{
    $session->msg('d',' Gagal di batalkan!');
      redirect('pengajuan_spm.php', false);
  }
}

if(isset($_POST['upload'])) {
  $id = $_POST['id'];
  //var_dump($_FILES['file_upload']);
   $pengajuan = find_by_id('pengajuan',$id);
  // var_dump($_FILES);exit(); 
$photo = new Media();
$photo->upload($_FILES['file_upload'],$pengajuan['SPM']);
 if($photo->process_spm($id)){
     $session->msg('s','dokumen has been uploaded.');
         if($user['user_level']==5){
        redirect('pengajuan_spm.php', false);
     }else{
     redirect('pengajuan_spm.php?id='.$pengajuan['id_nodin']);
    }
 } else{
   $session->msg('d',join($photo->errors));
   if($user['user_level']==5){
        redirect('pengajuan_spm.php?id='.$pengajuan['id_nodin'], false);
     }else{
     redirect('pengajuan_spm.php?id='.$pengajuan['id_nodin']);
    }
 }

}
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
            <span>All Pengajuan</span>
          </strong>
          <div class="pull-right">
            
          </div>
        </div>
        <div class="panel-body">
          <table class="table table-bordered table-striped">
            <thead>
              <tr>
                <th class="text-center" style="width: 50px;">#</th>
                <th> SPM </th>
                <th class="text-center" style="width: 15%;"> Nominal Pengajuan</th>
                <th class="text-center" style="width: 15%;"> Status Verifikasi</th>
                <th class="text-center" style="width: 15%;"> Status SPM </th>
                <th class="text-center">Dokumen</th> 
                <th class="text-center" style="width: 15%;"> Status KPPN </th>  
                <th class="text-center" style="width: 15%;">Status SP2D</th>
                <th class="text-center" style="width: 15%;">Status Pengambilan Uang</th>               
                <th class="text-center" style="width: 100px;"> Actions </th>
             </tr>
            
            </thead>
           <tbody>
             <?php foreach ($sales as $sale):?>

             <tr>
               <td class="text-center"><?php echo count_id();?></td>
               <td><?php echo remove_junk($sale['SPM']); ?>/<?php $nodin= find_by_id('nodin',$sale['id_nodin']); $jenis = find_by_id('jenis',$nodin['id_jenis']); echo $jenis['keterangan'];?>/<?php $nodin= find_by_id('nodin',$sale['id_nodin']);echo $nodin['tanggal']; ?></td>
               <td class="text-center" ><?php $tp=find_NominalPengajuan($sale['id']);echo rupiah($tp['jum']);?></td>

            <td class="text-center">
                <?php if($sale['status_verifikasi']=='0' and $user['user_level'] == 2){?>
                    
                        <a class="btn btn-success" href="<?php $jenis= find_by_id('jenis_pengajuan',$sale['id_jenis_pengajuan']); echo $jenis['link']?>.php?id=<?php echo $sale['id']?>&v=insert"><?=$jenis['keterangan']?></a>
                   
                <?php }else{
                    
                    $v = find_by_filed('verifikasi',$sale['id'],'id_pengajuan');  
                    if($v['status_pengajuan']==1){
                    ?>
                    <span class="label label-success">Terverifikasi verifikator</span><br>
                    <?php }else{ ?>
                    <span class="label label-danger">Ditolak verifikator</span><br>
                    <?php } ?>
                    <br>

                    <?php $p = find_by_filed('pengajuan',$sale['id'],'id');  
                    if($p['verifikasi_kasubbag_v']==1){   ?>
                    <span class="label label-success">Terverifikasi Kasubbag verifikator</span>
                    <?php }else{ ?>
                    <span class="label label-danger">Ditolak Kasubbag verifikator</span>
                    <?php } ?>
                        
                    <?php if($user['user_level'] == 2 ){  ?>
                            <a href="<?php $jenis= find_by_id('jenis_pengajuan',$sale['id_jenis_pengajuan']); echo $jenis['link'];?>.php?id=<?=$sale['id']?>" class="btn btn-success">Edit</a>
                                <br>
                          
                            <a href="batal_verifikasi.php?id=<?=$sale['id']?>" class="btn btn-danger">Batal
                            [<?php $user = find_by_id('users',(int)$sale['status_verifikasi']);echo $user['name'];?>]
                            </a>
                
                <?php }} ?>     
            </td>
             
             
            <td class="text-center">
            <?php if($sale['status_verifikasi']==0){ ?>
              <span class="label label-danger">belom di validasi oleh verifikator</span>
             <?php }else{ ?>
              <?php if($sale['status_spm']==0){?>
               <a href="update_spm.php?id=<?=$sale['id']?>" class="btn btn-success">Proses</a><?php }else{?>
                <span class="label label-success">SPM Telah Di Buat</span>
               <a href="batal_spm.php?id=<?=$sale['id']?>" class="btn btn-danger">Batal</a><?php } ?>
             <?php } ?>
             </td>

             <td class="text-center"> 
              <a href="detail_dokumen_ses.php?id=<?=$sale['id']?>" class="btn btn-success" >Buka Dokumen</a>
              </td>
            
             <!-- <td class="text-center">
                <?php if($sale['file_spm']==''){?>
               <a href="#" class="btn btn-primary" id="UploadSPM" data-toggle="modal" data-target="#uploadSPM" data-id='<?=$sale['id'];?>'>Upload File</a>     
                <?php }else{ ?>
                  <a href="uploads/spm/<?=$sale['file_spm']?>" class="btn btn-success" target="_blank">Preview</a>
                  
                  <a href="pengajuan_spm.php?id=<?=$sale['id']?>&s=spm" class="btn btn-danger">Batal</a>
                <?php } ?>
            </td> -->

            <!-- <td class="text-center">
              <?php if($sale['sp2d'] == ''){?><a href="#" class="btn btn-primary" id="editsp2d" data-toggle="modal" data-target="#exampleModal" data-id='<?=$sale['id'];?>'>Input SP2D</a><?php }else{?>
              <a href="#" class="btn btn-warning" id="editsp2d" data-toggle="modal" data-target="#exampleModal" data-id='<?=$sale['id'];?>' data-sp2d='<?=$sale['sp2d'];?>'><?=$sale['sp2d'];?></a> <?php } ?>
            </td> -->

            <td class="text-center">
            <?php if($sale['penolakan_kppn']!=''){?><span class="label label-danger">Penolakan KPPN perbaiakan= <?=$sale['penolakan_kppn'];?></span><?php }else{ ?>
               
               <?php } ?>
               <?php if($sale['status_kppn']==0){?><span class="label label-danger">Belom di Proses</span><?php }else{?>
                <span class="label label-success">Sudah di Proses oleh <?php $user = find_by_id('users',(int)$sale['status_kppn']);echo $user['name'];?></span><?php } ?>
            </td>

            <td class="text-center"><?php if($sale['status_sp2d']==0){?><span class="label label-danger">Belom Cair</span><?php }else{?>
             <span class="label label-success">Sudah Cair [<?php $user = find_by_id('users',(int)$sale['status_sp2d']);echo $user['name'];?>]</span><?php } ?>
            </td>
            <td class="text-center">
                <?php if($sale['status_pengambilan_uang']==0){?><span class="label label-danger">Belom di Ambil</span><?php }else{?>
                 <span class="label label-success">Sudah Diambil <?php $user = find_by_id('users',(int)$sale['status_sp2d']);?></span><?php } ?>
            </td>
            </td>
               <td class="text-center">
                  <div class="btn-group">
                    
                     <a href="detail_pengajuan.php?id=<?php echo (int)$sale['id'];?>" class="btn btn-primary btn-xs"  title="Detail Pengajuan" data-toggle="tooltip">
                       <span class="glyphicon glyphicon-edit"></span>
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


       <!-- Modal Upload berkas SPM-->
<div class="modal fade" id="uploadSPM" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Upload SPM</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="" method="POST" enctype="multipart/form-data">
      <div class="modal-body">
       <div class="form-group">
        <label for="exampleInputEmail1">Upload File</label>
        <input type="file" class="form-control" id="sp2d" name="file_upload" placeholder="SP2D">
        <input type="hidden" class="form-control" id="id" name="id" >
       </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <input type="submit" class="btn btn-primary" name="upload" value="Save">
      </div>
      </form>
    </div>
  </div>
</div>


     <!-- Modal input sp2d-->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">SP2D</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="" method="POST">
      <div class="modal-body">
       <div class="form-group">
        <label for="exampleInputEmail1">Masukkan Kode SP2D</label>
        <input type="text" class="form-control" id="sp2d" name="sp2d" placeholder="SP2D">
        <input type="hidden" class="form-control" id="id" name="id" >
       </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <input type="submit" class="btn btn-primary" name="update_sp2d" value="Save">
      </div>
      </form>
    </div>
  </div>
</div>



  <!-- Modal edit sp2d-->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit SP2D</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="" method="POST">
      <div class="modal-body">
       <div class="form-group">
        <label for="exampleInputEmail1">Edit Kode SP2D</label>
        <input type="text" class="form-control" id="exampleInputEmail1" name="sp2d" placeholder="SP2D">
        <input type="text" class="form-control" id="id" name="id" >
       </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <input type="submit" class="btn btn-primary" name="update1_sp2d" value="Update">
      </div>
      </form>
    </div>
  </div>
</div>


<!-- Modal edit sp2d-->
<div class="modal fade" id="exampleModalOK" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Coba SP2D</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="" method="POST">
      <div class="modal-body">
       <div class="form-group">
        <label for="exampleInputEmail1">Edit Kode SP2D</label>
        <input type="text" class="form-control" id="exampleInputEmail1" name="sp2d" placeholder="SP2D">
        <input type="text" class="form-control" id="id" name="id" >
       </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <input type="submit" class="btn btn-primary" name="update1_sp2d" value="Update">
      </div>
      </form>
    </div>
  </div>
</div>
<?php include_once('layouts/footer.php'); ?>
