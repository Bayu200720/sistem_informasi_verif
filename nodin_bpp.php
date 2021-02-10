<?php
  $page_title = 'All Nodin';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(6);
?>
<?php
$user=find_by_id('users',$_SESSION['user_id']);
$satker = find_all_global('satker',$user['id_satker'],'id');
$sales = find_all_global_tahun('nodin',$user['id_satker'],'id_satker',$satker[0]['tahun']);

?>
<?php
 if(isset($_POST['submit_nodin'])){
   $req_fields = array('id_jenis','tanggal','id_satker','p_pengajuan');
   validate_fields($req_fields);
   if(empty($errors)){
     $id_jenis   = remove_junk($db->escape($_POST['id_jenis']));
     $tanggal   = remove_junk($db->escape($_POST['tanggal']));
     $id_satker = remove_junk($db->escape($_POST['id_satker']));
     $p_pengajuan = remove_junk($db->escape($_POST['p_pengajuan']));
     $no_nodin = remove_junk($db->escape($_POST['no_nodin']));
     $user_id   = remove_junk($db->escape($_SESSION['user_id']));
     $date    = make_date();
     $tahun = $satker[0]['tahun'];
     $query  = "INSERT INTO nodin (";
     $query .=" tanggal,id_user,id_jenis,id_satker,p_pengajuan,no_nodin,tahun";
     $query .=") VALUES (";
     $query .=" '{$tanggal}','{$user_id}','{$id_jenis}','{$id_satker}','{$p_pengajuan}','{$no_nodin}','{$tahun}'";
     $query .=")";
     if($db->query($query)){
       $session->msg('s',"Nodin added ");
       if($user['user_level']==2){
        redirect('nodin_bpp.php', false);
       }else{
       redirect('nodin_bpp.php', false);
       }
     } else {
       $session->msg('d',' Sorry failed to added!');
       if($user['user_level']==2){
        redirect('nodin_bpp.php', false);
      }else{
         redirect('nodin_bpp.php', false);
      }
     }

   } else{
     $session->msg("d", $errors);
     redirect('nodin_bpp.php',false);
   }

 }

 if(isset($_POST['update_nodin'])){
  $req_fields = array('id_jenis','tanggal','p_pengajuan','id');
  validate_fields($req_fields);
  if(empty($errors)){
    $id   = remove_junk($db->escape($_POST['id']));
    $id_jenis   = remove_junk($db->escape($_POST['id_jenis']));
    $tanggal   = remove_junk($db->escape($_POST['tanggal']));
    $id_satker = remove_junk($db->escape($_POST['id_satker']));
    $p_pengajuan = remove_junk($db->escape($_POST['p_pengajuan']));
    $no_nodin = remove_junk($db->escape($_POST['no_nodin']));
    $user_id   = remove_junk($db->escape($_SESSION['user_id']));
    $date    = make_date();
    $query  = "UPDATE nodin SET ";
    $query .=" tanggal= '{$tanggal}',id_user='{$user_id}',id_jenis='{$id_jenis}',p_pengajuan='{$p_pengajuan}',no_nodin='{$no_nodin}'";
    $query .=" WHERE id='{$id}'";
 
    if($db->query($query)){
      $session->msg('s',"Nodin Updated ");
      if($user['user_level']==2){
       redirect('nodin_bpp.php', false);
      }else{
      redirect('nodin_bpp.php', false);
      }
    } else {
      $session->msg('d',' Sorry failed to Updated!');
      if($user['user_level']==2){
       redirect('nodin_bpp.php', false);
     }else{
        redirect('nodin_bpp.php', false);
     }
    }

  } else{
    $session->msg("d", $errors);
    redirect('nodin_bpp.php',false);
  }

}


if($_GET['p']=='update'){

    $id   = remove_junk($db->escape($_GET['id']));
  
    $query  = "UPDATE nodin SET ";
    $query .=" status_pengajuan= 1";
    $query .=" WHERE id='{$id}'";
  //echo $query;exit();
    if($db->query($query)){
      $session->msg('s',"Telah di ajukan ke bagian keuangan ");
      if($user['user_level']==2){
       redirect('nodin_bpp.php', false);
      }else{
      redirect('nodin_bpp.php', false);
      }
    } else {
      $session->msg('d',' Sorry failed to Pengajuan!');
      if($user['user_level']==2){
       redirect('nodin_bpp.php', false);
     }else{
        redirect('nodin_bpp.php', false);
     }
    }

}

if($_GET['p']=='batal'){

  $id   = remove_junk($db->escape($_GET['id']));

  $query  = "UPDATE nodin SET ";
  $query .=" status_pengajuan= 0";
  $query .=" WHERE id='{$id}'";
//echo $query;exit();
  if($db->query($query)){
    $session->msg('s',"Telah di berhasil di batalkan  ");
    if($user['user_level']==2){
     redirect('nodin_bpp.php', false);
    }else{
    redirect('nodin_bpp.php', false);
    }
  } else {
    $session->msg('d',' Sorry failed to Pengajuan!');
    if($user['user_level']==2){
     redirect('nodin_bpp.php', false);
   }else{
      redirect('nodin_bpp.php', false);
   }
  }

}

 ?>

<?php

if($_GET['status']=='delete_nodin'){
  $d_sale = find_by_id('nodin',(int)$_GET['id']);
  $user = find_by_id('users',(int)$_SESSION['user_id']);
  if(!$d_sale){
    $session->msg("d","Missing nodin id.");
      if($user['user_level']==2){
              redirect('nodin_bpp.php', false);
          }else{
    redirect('nodin_bpp.php');
        }
  }
?>
<?php
  $delete_id = delete_by_id('nodin',(int)$d_sale['id']);
  if($delete_id){
      $session->msg("s","nodin deleted.");
      if($user['user_level']==2){
              redirect('nodin_bpp.php', false);
          }else{
      redirect('nodin_bpp.php');
        }
  } else {
      $session->msg("d","nodin deletion failed.");
          if($user['user_level']==2){
              redirect('nodin_bpp.php', false);
          }else{
      redirect('nodin_bpp.php');
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
            <span>All Nodin</span>
          </strong>
          <div class="pull-right">
          <a href="#" class="btn btn-primary" id="nodin" data-toggle="modal" data-target="#NodinPengajuan">Tambah</a>
          </div>
        </div>
        <div class="panel-body"> 
          <table id="example" class="table table-primary table-bordered table-striped table-dark table-hover ">
            <thead>
              <tr>
                <th class="text-center" style="width: 50px;">#</th>
                <th class="text-center" style="width: 15%;"> Tanggal</th>
                <th class="text-center" style="width: 15%;"> Jenis </th>
                <th class="text-center" style="width: 15%;"> Pegawai Pengajuan </th>
                <th class="text-center" style="width: 15%;">Nomor Nodin </th>
                <th class="text-center" style="width: 100px;"> Cetak Nodin </th>
                <th class="text-center" style="width: 100px;"> Status Pengajuan </th>               
                <th class="text-center" style="width: 100px;"> Actions </th>
             </tr>
            </thead>
           <tbody >
             <?php foreach ($sales as $sale):?>
             <tr style="background-color:#3498DB;">
               <td class="text-center"><?php echo count_id();?></td>
               <td class="text-center"><?php echo $sale['tanggal']; ?></td>
               <td class="text-center"><?php $jenis = find_by_id('jenis',$sale['id_jenis']); echo $jenis['keterangan'];  ?></td>
        
               <td class="text-center"><?php echo $sale['p_pengajuan']; ?></td>
               <td class="text-center"><?php echo $sale['no_nodin']; ?></td>

            <td class="text-center">
             <a href="cetakNodin.php?id=<?=$sale['id']?>" class="btn btn-primary">Cetak</a>
            </td>
            <td class="text-center">
                  <?php if($sale['status_pengajuan'] == 1){?>
                    <a href="nodin_bpp.php?id=<?=$sale['id']?>&key=ajukan&p=batal" class="btn btn-success">Sudah Diajukan</a>
                  <?php }else{ ?>
                    <a href="nodin_bpp.php?id=<?=$sale['id']?>&key=ajukan&p=update" class="btn btn-primary">Ajukan</a>
                  <?php } ?>
            
            </td>
          

            <td class="text-center">
                  <div class="btn-group">
                     <a href="#"   class=""   >
                       
                     </a>
                     <a href="#" title="Edit" <?php $nodin = find_by_id('nodin',$sale['id']);?> class="btn btn-warning btn-xs" id="editnodin" data-toggle="modal" 
                     data-target="#UpdateNodinPengajuan" data-id='<?=$nodin['id'];?>' data-tanggal='<?=$nodin['tanggal'];?>' data-pp='<?=$nodin['p_pengajuan'];?>' data-no_nodin='<?=$nodin['no_nodin'];?>'>
                     <span class="glyphicon glyphicon-edit"></span>
                     </a>
                     <!-- <a href="pengajuan_bpp.php?id=<?php echo (int)$sale['id'];?>" class="btn btn-primary btn-xs"  title="Detail nodin" data-toggle="tooltip">
                       <span class="glyphicon glyphicon-edit"></span>
                     </a> -->

                     <?php $pengj = count_by_id_nodin('pengajuan',$sale['id']); if($pengj['total'] < 1 ){ ?>  
                     <a onclick="return confirm('Yakin Hapus?')" href="nodin_bpp.php?id=<?php echo (int)$sale['id'];?>&status=delete_nodin" class="btn btn-danger btn-xs"  title="Delete" data-toggle="tooltip">
                       <span class="glyphicon glyphicon-trash"></span>
                     </a>
                     <?php } ?>
                  </div>
               </td>
             </tr>

             <tr>
                   <td><a href="add_pengajuan.php?id=<?=$sale['id'];?>" class="btn btn-primary">Add pengajuan</a></td>
                   <td></td>
                   <td></td>
                   <td></td>
                   <td></td>
                   <td></td>
                   <td></td>
                   <td></td>
            </tr>
            <tr>
            		<td colspan="8">
						
						<table class="table table-bordered table-striped">
            <thead>
              <tr>
                <th class="text-center" style="width: 50px;">#</th>
                <th class="text-center"> SPM/Jenis Pengajuan </th>
                <th class="text-center" style="width: 15%;"> Status Verifikasi </th> 
                <th class="text-center" style="width: 15%;"> Status SPM </th>
                <th class="text-center">Berkas SPM</th>             
                <th class="text-center" style="width: 15%;"> Status KPPN </th> 
                <th class="text-center" style="width: 15%;"> Status SP2D </th>
                <th class="text-center" style="width: 15%;"> Status Pengambilan Uang </th>
                <th class="text-center" style="width: 100px;"> Actions </th>
             </tr>
            </thead>
           <tbody>
             <?php 
              $pengajuan = find_all_global('pengajuan',$sale['id'],'id_nodin');
              $no=1;
              foreach ($pengajuan as $p):?>
             <tr>
               <td class="text-center"><?php echo $no; $no++?></td>
               <td><?php echo remove_junk($p['SPM']); ?>/<?php $jenis = find_by_id('jenis_pengajuan',$p['id_jenis_pengajuan']); echo $jenis['keterangan']?></td>
               <td class="text-center"><?php if($p['status_verifikasi']==0){?><span class="label label-danger">Belom di Proses</span><?php }else{?>
             <span class="label label-success">Sudah di Proses oleh <?php $user = find_by_id('users',(int)$p['status_verifikasi']);echo $user['name'];?></span><?php } ?>
            <?php $verif = find_all_global('verifikasi',$p['id'],'id_pengajuan');if($verif[0]['id_pengajuan']!=NULL){?>
               <a href="<?php 
                  if($p['id_jenis_pengajuan']==1){
                    echo "verif_LSsppd.php?id=".$p['id_nodin']."&v=".$p['id'];
                  }else if($p['id_jenis_pengajuan']==2){
                    echo "verif_sppdLn.php?id=".$p['id_nodin']."&v=".$p['id'];
                  }else if($p['id_jenis_pengajuan']==3){
                    echo "verif_LSHonor.php?id=".$p['id_nodin']."&v=".$p['id'];
                  }else if($p['id_jenis_pengajuan']==4){
                    echo "verif_LSjasprof.php?id=".$p['id_nodin']."&v=".$p['id'];
                  }else if($p['id_jenis_pengajuan']==5){
                    echo "verif_LSkur50.php?id=".$p['id_nodin']."&v=".$p['id'];
                  }else{
                    echo "verif_GU.php?id=".$p['id_nodin']."&v=".$p['id'];
            
                  }
                
                ?>" class="btn btn-warning">Kekurangan</a>
            <?php } ?>
            </td>
            
            <td class="text-center"><?php if($p['status_spm']==0){?><span class="label label-danger">Belom di Proses</span><?php }else{?>
             <span class="label label-success">Sudah di Proses oleh <?php $user = find_by_id('users',(int)$p['status_spm']);echo $user['name'];?></span><?php } ?>
            </td>
            <td class="text-center">
                <a href="detail_dokumen.php?id=<?=$p['id']?>" class="btn btn-primary">Upload Dokumen</a>
            </td>

            <td class="text-center">
            <?php if($p['penolakan_kppn']!=''){?><span class="label label-danger">Penolakan KPPN perbaiakan= <?=$p['penolakan_kppn'];?></span><?php }else{ ?>
               
               <?php } ?>
               <?php if($p['status_kppn']==0){?><span class="label label-danger">Belom di Proses</span><?php }else{?>
                <span class="label label-success">Sudah di Proses oleh <?php $user = find_by_id('users',(int)$p['status_kppn']);echo $user['name'];?></span><?php } ?>
            </td>

            <td class="text-center"><?php if($p['status_sp2d']==0){?><span class="label label-danger">Belom Cair</span><?php }else{?>
             <span class="label label-success">Sudah Cair [<?php $user = find_by_id('users',(int)$p['status_sp2d']);echo $user['name'];?>]</span><?php } ?>
            </td>
            <td class="text-center">
                <?php if($p['status_pengambilan_uang']==0){?><span class="label label-danger">Belom di Ambil</span><?php }else{?>
                 <span class="label label-success">Sudah Diambil <?php $user = find_by_id('users',(int)$p['status_sp2d']);?></span><?php } ?>
            </td>
            

               <td class="text-center">
                  <div class="btn-group">
                     <a href="edit_pengajuan.php?id=<?php echo (int)$p['id'];?>" class="btn btn-warning btn-xs"  title="Edit" data-toggle="tooltip">
                       <span class="glyphicon glyphicon-edit"></span>
                     </a>
                     <a href="detail_pengajuan.php?id=<?php echo (int)$p['id'];?>" class="btn btn-primary btn-xs"  title="Detail Pengajuan" data-toggle="tooltip">
                       <span class="glyphicon glyphicon-edit"></span>
                     </a>
                        <?php $nodin= find_all_global('nodin',$p['id_nodin'],'id'); $tahun= explode("-",$nodin[0]['tanggal']); ?>
                     <a href="transaksi.php?id=<?php echo (int)$p['id'];?>&spm=<?=$p['SPM']?>&tahun=<?=$tahun[0]?>" class="btn btn-success btn-xs"  title="Detail Pengajuan API" data-toggle="tooltip">
                       <span class="glyphicon glyphicon-edit"></span>
                     </a>
                 <?php $detail_p = count_by_id_pengajuan('detail_pengajuan',$p['id']); if($detail_p['total'] < 1 ){ ?>
                     <a onclick="return confirm('Yakin Hapus?')" href="delete_pengajuan.php?id=<?php echo (int)$p['id'];?>" class="btn btn-danger btn-xs"  title="Delete" data-toggle="tooltip">
                       <span class="glyphicon glyphicon-trash"></span>
                     </a>
                  <?php } ?>
                  </div>
               </td>
             </tr>
             <?php endforeach;?>
           </tbody>
         </table>
		 
						
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

<?php include_once('layouts/footer.php'); ?>
