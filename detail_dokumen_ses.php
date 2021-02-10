<?php
  $page_title = 'All Nodin';
  require_once('includes/load.php');
  $user=find_by_id('users',$_SESSION['user_id']);
  // Checkin What level user has permission to view this page

  if($user['user_level'] == 7 ){
         page_require_level(7);
  }else if($user['user_level'] == 2 ){
      page_require_level(2);
  }


  if(isset($_GET['s']) and $_GET['s'] == 'spm'){
    //var_dump($_GET); echo "ok";exit();
    if($_GET['s'] == 'spm'){
     
      $pengajuan = find_by_id('pengajuan',$_GET['id']);//var_dump($pengajuan);exit();
    $query  = "UPDATE pengajuan SET ";
          $query .= "file_spm=''";
          $query .= "WHERE id='{$pengajuan["id"]}'";
          $result = $db->query($query);
          $session->msg('s',' Berhasil di Batalkan');
          
        redirect('detail_dokumen_ses.php?id='.$pengajuan['id']);
    }else{
      $session->msg('d',' Gagal di batalkan!');
        redirect('detail_dokumen_ses.php'.$pengajuan['id'], false);
    }
  }

  if(isset($_GET['s']) and $_GET['s'] == 'sp2d'){
   
    if($_GET['s'] == 'sp2d'){
      $pengajuan = find_by_id('pengajuan',$_GET['id']);//var_dump($pengajuan);exit();
    $query  = "UPDATE pengajuan SET ";
          $query .= "file_sp2d=''";
          $query .= "WHERE id='{$pengajuan["id"]}'";
          $result = $db->query($query);
          $session->msg('s',' Berhasil di Batalkan');
          
        redirect('detail_dokumen_ses.php?id='.$pengajuan['id']);
    }else{
      $session->msg('d',' Gagal di batalkan!');
        redirect('detail_dokumen_ses.php?id='.$pengajuan['id'], false);
    }
  }
  

  if(isset($_POST['upload'])) {
    $id = $_POST['id'];
    //var_dump($_FILES['file_upload']);
     $pengajuan = find_by_id('pengajuan',$id);
    // var_dump($_FILES);exit(); 
  $photo = new Media();
  $photo->upload($_FILES['file_upload'],$pengajuan['SPM']);
   if($photo->process_sp2d($id)){
       $session->msg('s','dokumen has been uploaded.');
           if($user['user_level']==5){
          redirect('detail_dokumen_ses.php?id='.$pengajuan['id'], false);
       }else{
       redirect('detail_dokumen_ses.php?id='.$pengajuan['id']);
      }
   } else{
     $session->msg('d',join($photo->errors));
     if($user['user_level']==5){
          redirect('detail_dokumen_ses.php?id='.$pengajuan['id'], false);
       }else{
       redirect('detail_dokumen_ses.php?id='.$pengajuan['id']);
      }
   }
  }

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
                    redirect("detail_dokumen_ses.php?id=". $p_id, false);
                  } else {
                    $session->msg('d',' Sorry failed to updated!');
                    redirect('detail_dokumen_ses.php', false);
                  }
        } else {
           $session->msg("d", $errors);
           redirect('detail_dokumen_ses.php',false);
        }
  }
  
 
  
  if(isset($_POST['upload_spm'])) {
    $id = $_POST['id'];
    //var_dump($_FILES['file_upload']);
     $pengajuan = find_by_id('pengajuan',$id);
    // var_dump($_FILES);exit(); 
  $photo = new Media();
  $photo->upload($_FILES['file_upload'],$pengajuan['SPM']);
   if($photo->process_spm($id)){
       $session->msg('s','dokumen has been uploaded.');
           if($user['user_level']==5){
          redirect('detail_dokumen_ses.php', false);
       }else{
       redirect('detail_dokumen_ses.php?id='.$pengajuan['id']);
      }
   } else{
     $session->msg('d',join($photo->errors));
     if($user['user_level']==5){
          redirect('detail_dokumen_ses.php?id='.$pengajuan['id'], false);
       }else{
       redirect('detail_dokumen_ses.php?id='.$pengajuan['id']);
      }
   }
  
  }
?>
<?php

$sales = find_all_global('pengajuan',$_GET['id'],'id');
$idi= $_GET['id'];

if(isset($_GET['s']) and $_GET['s']==='hapus_adk'){
    $query  = "UPDATE pengajuan SET ";
    $query .= "upload_adk=''";
    $query .= "WHERE id='{$idi}'";
   // echo $query; exit();
    $result = $db->query($query);
    $session->msg('s',' Berhasil di Batalkan');
    if($user['user_level']==5){
  redirect('detail_dokumen.php?id='.$idi);
  }else{
  redirect('detail_dokumen.php?id='.$idi, false);
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
            <span>Detail Dokumen</span>
          </strong>
          <div class="pull-right">
            <?php   if($user['user_level'] == 2 or $user['user_level'] == 7 ){?>
                <a href="pengajuan_verif.php" class="btn btn-warning">Back</a>
            <?php }else if($user['user_level'] == 3){ ?>
                <a href="pengajuan_spm.php" class="btn btn-warning">Back</a>
            <?php } ?>
          </div>
        </div>
        <div class="panel-body">
          <table class="table table-bordered table-striped">
            <thead>
              <tr>
               
                <th class="text-center" style="width: 15%;"> Upload Dokumen Pengajuan</th>
                <th class="text-center" style="width: 15%;"> Upload Dokumen Pertanggungjawaban</th>
                <th class="text-center" style="width: 15%;"> ADK SPP </th>
                <th class="text-center" style="width: 15%;"> SPM yang Telah di Proses</th>
                <th class="text-center" style="width: 15%;"> Dokumen SP2D</th>
                <th class="text-center" style="width: 15%;"> SP2D</th>
             
             </tr>
            </thead>
           <tbody>
             <?php foreach ($sales as $sale):?>
             <tr>
                   
                     <td class="text-center">
                        <?php if($sale['upload']==''){?><?php }else{?>
                             <a href="uploads/products/<?=$sale['upload']?>" class="btn btn-success" target="_blank">Preview</a>
                           
                        <?php } ?>
                    </td>
                    <td class="text-center"><?php if($sale['upload_pertanggungjawaban']==''){?><?php }else{?>
                             <a href="uploads/pertanggungjawaban/<?=$sale['upload_pertanggungjawaban']?>" class="btn btn-success" target="_blank">Preview</a>
                               
                             <?php } ?>
                    </td>

                    <td class="text-center"><?php if($sale['upload_adk']==''){?><?php }else{?>
                             <a href="uploads/adk/<?=$sale['upload_adk']?>" class="btn btn-success" target="_blank">Download</a>
                         <?php } ?>
                    </td>
                    <td class="text-center">
                        <?php if($user['user_level'] == 3){?>
                            <?php if($sale['file_spm']==''){?>
                            <a href="#" class="btn btn-primary" id="UploadSPM" data-toggle="modal" data-target="#uploadSPM" data-id='<?=$sale['id'];?>'>Upload File</a>     
                                <?php }else{ ?>
                                <a href="uploads/spm/<?=$sale['file_spm']?>" class="btn btn-success" target="_blank">Preview</a>
                                
                                <a href="detail_dokumen_ses.php?id=<?=$sale['id']?>&s=spm" class="btn btn-danger">Batal</a>
                                <?php } ?>
                        <?php }else{?>
                        
                            <?php if($sale['file_spm']!=''){?><a href="uploads/spm/<?=$sale['file_spm']?>" class="btn btn-success" target="_blank">Preview</a><?php } ?>
                        <?php } ?>
                    </td>
                    <td class="text-center">
                          <?php if($user['user_level'] == 5) { ?>
                            
                            <?php if($sale['file_sp2d']==''){?>
                                         <a href="#" class="btn btn-primary" id="UploadSP2D" data-toggle="modal" data-target="#uploadSP2D" data-id='<?=$sale['id'];?>'>Upload File</a>     
                                    <?php }else{ ?>
                                         <a href="uploads/sp2d/<?=$sale['file_sp2d']?>" class="btn btn-success" target="_blank">Preview</a>
                                         <a href="detail_dokumen_ses.php?id=<?=$sale['id']?>&s=sp2d" class="btn btn-danger">Batal</a>
                                    <?php } ?>
                                    
                            <?php }else{ ?>

                                    <?php if($sale['file_sp2d']!=''){?><a href="uploads/sp2d/<?=$sale['file_sp2d']?>" class="btn btn-success" target="_blank">Preview</a><?php } ?>
                            <?php } ?>
                    </td>
                    <td class="text-center">
                         <?php if($user['user_level'] == 6){
                            echo $sale['sp2d'];
                         }else{?>
                            <?php if($sale['sp2d'] == ''){?><a href="#" class="btn btn-primary" id="editsp2d" data-toggle="modal" data-target="#exampleModal" data-id='<?=$sale['id'];?>'>Input SP2D</a><?php }else{?>
                            <a href="#" class="btn btn-warning" id="editsp2d" data-toggle="modal" data-target="#exampleModal" data-id='<?=$sale['id'];?>' data-sp2d='<?=$sale['sp2d'];?>'><?=$sale['sp2d'];?></a> <?php } ?>
                        <?php } ?>
                    </td>

              
             </tr>


             <?php endforeach;?>
           </tbody>
         </table>
        </div>
      </div>
    </div>
  </div>


   <!-- Modal input nodin-->
<div class="modal fade" id="NodinPengajuan" tabindex="-1" role="dialog" aria-labelledby="nodin" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Nodin</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="nodin_bpp.php" method="POST">
      <div class="modal-body">
       <div class="form-group">
        <label for="exampleInputEmail1">Tanggal</label>
        <input type="date" class="form-control" id="nodin" name="tanggal" placeholder="tanggal">
       </div>
       <div class="form-group">
        <label for="exampleInputEmail1">Nomor Nodin</label>
        <input type="text" class="form-control" id="no_nodinn" name="no_nodin" placeholder="Nomor Nodin">
       </div>
       <div class="form-group">
        <label for="exampleInputEmail1">Pegawai Pengajuan</label>
        <input type="text" class="form-control" id="nodin" name="p_pengajuan" placeholder="Pegawai Pengajuan">
        <input type="hidden" class="form-control" id="id" value="<?php $users=find_by_id('users',$_SESSION['user_id']);echo $users['id_satker'] ;?>" name="id_satker" >
       </div>
       <div class="form-group">
        <label for="exampleInputEmail1">Jenis Pengajuan</label>
                <select class="form-control" name="id_jenis">
                      <option value="">Pilih Jenis Pengajuan</option>
                      <?php $jenis = find_all('jenis');?>
                    <?php  foreach ($jenis as $j): ?>
                      <option value="<?php echo (int)$j['id'] ?>">
                        <?php echo $j['keterangan'] ?></option>
                    <?php endforeach; ?>
                </select>
       </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <input type="submit" class="btn btn-primary" name="submit_nodin" value="Save">
      </div>
      </form>
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
        <input type="submit" class="btn btn-primary" name="upload_spm" value="Save">
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

 <!-- Modal Edit nodin-->
 <div class="modal fade" id="UpdateNodinPengajuan" tabindex="-1" role="dialog" aria-labelledby="nodin" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Update Nodin</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="nodin_bpp.php" method="POST">
      <div class="modal-body">
       <div class="form-group">
        <label for="exampleInputEmail1">Tanggal</label>
        <input type="date" class="form-control" id="tanggal" name="tanggal" placeholder="tanggal">
       </div>
       <div class="form-group">
        <label for="exampleInputEmail1">Nomor Nodin</label>
        <input type="text" class="form-control" id="no_nodin" name="no_nodin" placeholder="Nomor Nodin">
       </div>
       <div class="form-group">
        <label for="exampleInputEmail1">Pegawai Pengajuan</label>
        <input type="text" class="form-control" id="pp" name="p_pengajuan" placeholder="Pegawai Pengajuan">
        <input type="hidden" class="form-control" id="id" name="id" >
        <input type="hidden" class="form-control" id="id_user" value="<?php $users=find_by_id('users',$_SESSION['user_id']);echo $users['id_satker'] ;?>" name="id_satker" >
       </div>
       <div class="form-group">
        <label for="exampleInputEmail1">Jenis Pengajuan</label>
                <select class="form-control" name="id_jenis">
                      <option value="">Pilih Jenis Pengajuan</option>
                      <?php $jenis = find_all('jenis');?>
                    <?php  foreach ($jenis as $j): ?>
                      <option value="<?php echo (int)$j['id'] ?>">
                        <?php echo $j['keterangan'] ?></option>
                    <?php endforeach; ?>
                </select>
       </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <input type="submit" class="btn btn-primary" name="update_nodin" value="Update">
      </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Upload berkas SP2D-->
<div class="modal fade" id="uploadSP2D" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
<?php include_once('layouts/footer.php'); ?>
