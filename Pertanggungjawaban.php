<?php
  $page_title = 'All SPM';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(6);
?>
<?php
$user=find_by_id('users',$_SESSION['user_id']);
$satker = find_all_global('satker',$user['id_satker'],'id');
$sales1 = find_all_global_tahun('nodin',$user['id_satker'],'id_satker',$satker[0]['tahun']);
$sales = find_nodin_j_pengajuan($satker[0]['tahun'],$user['id_satker']); 

?>

<?php include_once('layouts/header.php'); ?>
<div class="row">
  <div class="col-md-12">
    <?php echo display_msg($msg); ?>
  </div>
</div>
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading clearfix">
          <strong>
            <span class="glyphicon glyphicon-th"></span>
            <span><a href="nodin_bpp.php">All SPM</a></span>
          </strong>
          <div class="pull-right">
         
          </div>
        </div>
        <div class="panel-body" style="width:100%"> 
          <table id="tabel" class="table table-primary table-bordered table-striped table-dark table-hover " style="width:100%">
            <thead>
              <tr>
                <th class="text-center" >#</th>
                <th class="text-center" > SPM</th>
                <th class="text-center" > Jenis Pengajuan</th>
                <th class="text-center" >Tanggal Pencairan </th>
                <th class="text-center" >Batas Akhir Upload Pertanggungjawaban </th> 
                <th class="text-center" > Upload Pertanggungjawaban</th>
                <th class="text-center" > Upload Kekurangan</th>           
                <th class="text-center"> Status</th>
             </tr>
            </thead>
           <tbody >
             <?php foreach ($sales as $sale):?>
             <tr >
               <td class="text-center"><?php echo count_id();?></td>
               <td class="text-center"><?php echo $sale['SPM']; ?></td>
               <td class="text-center"><?php $jenis = find_by_id('jenis_pengajuan',$sale['id_jenis_pengajuan']); echo $jenis['keterangan'];  ?></td>
        	   <td class="text-center"><?php $tgl_p= find_cair_j_kcair($sale['SPM']); echo $tgl_p[0]['time_add'] ?></td>
               <td class="text-center">
                 <?php $tgl_p= find_cair_j_kcair($sale['SPM']); 
						$tgl_p[0]['time_add'];
						if($tgl_p[0]['time_add']==''){}else{echo $tgl2 = date('Y-m-d', strtotime('+10 days', strtotime($tgl_p[0]['time_add'])));} 
                 ?>
               </td>
               <td class="text-center">
                 <?php  if($sale['upload_pertanggungjawaban'] != ''){ ?>
                 <a class="btn btn-success" href="uploads/pertanggungjawaban/<?=$sale['upload_pertanggungjawaban'];?>" target="_BLANK">Preview</a><a href="batal_uploadPj.php?id=<?=$sale['id']?>" class="btn btn-danger">
                 <span class="glyphicon glyphicon-trash"></span></a>
                 <?php }else{ ?>
                 	<a class="btn btn-primary" href="media_pertanggungjawaban.php?id=<?=$sale['id']?>">Upload</a>
                 <?php } ?>
               </td>
               <td class="text-center">
               		<?php  if($sale['upload_kekurangan'] != ''){ ?>
                 <a class="btn btn-success" href="uploads/kekurangan/<?=$sale['upload_kekurangan'];?>" target="_BLANK">Preview</a><a href="batal_uploadPj.php?id=<?=$sale['id']?>&status=H_kurang" class="btn btn-danger">
                 <span class="glyphicon glyphicon-trash"></span></a>
                 <?php }else{ ?>
                 	<a class="btn btn-primary" href="media_kekurangan.php?id=<?=$sale['id']?>&status=U_kurang">Upload</a>
                 <?php } ?>
               </td>
               <td class="text-center"> 
                 <?php  
					 if($sale['upload_pertanggungjawaban']!=''){
                       $hasil=update_status_jp(1,$sale['SPM']);
						echo "<br><span class='btn btn-success glyphicon glyphicon-ok'></span>";
                     }else{
                       if($tgl_p[0]['time_add']==''){}else{
                          
                          date_default_timezone_set('Asia/Jakarta');
                          $sekarang = '2021-03-10';//date('Y-m-d');
                         
                          $int_tgl = strtotime($tgl2);
						  $int_tgl2 = strtotime($sekarang);
                                                  $jarak = $int_tgl-$int_tgl2;
                                                echo $selisih=($jarak/3600)/24,' hari'; 
                          						$selisih=($jarak/3600)/24;
                         
                          $hasil=update_status_jp($selisih,$sale['SPM']);
                         	if($sale['status_pj'] <= 0){
                              echo "<br><span class='btn btn-danger glyphicon glyphicon-warning-sign'></span>";
                            }
                         }
                     }
                 ?>
               
               </td>
               
            
              </tr>

            
             <?php endforeach;?>
           </tbody>
         </table>
        </div>
      </div>
    </div>
  </div>




<?php include_once('layouts/footer.php'); ?>
