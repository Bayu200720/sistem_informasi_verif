<?php
  $page_title = 'All Pengajuan';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  $user = find_by_id('users',$_SESSION['user_id']);
 
   if($user['user_level'] == 2){ //echo "ok 3";exit();
   page_require_level(3); 
   }else if($user['user_level'] == 7 ){ //echo "7";exit();
     page_require_level(7); 
   }else{ //echo "3";exit();
     page_require_level(3); 
   }

   //ver_dump($_POST); exit();


?>
<?php
$sales = find_pengajuanok();

if(isset($_POST['cari'])){
  $sql = "select * from nodin where tanggal between '".$_POST['tgl1']."' and '".$_POST['tgl2']."'";
  echo $sql;
  $sales= find_pengajuanok_tgl($_POST['tgl1'],$_POST['tgl2']);
 }
//var_dump($sales);exit();
//print_r($sales);exit();//find_all('pengajuan');
$id = find_all_global('pengajuan',$_GET['id'],'id_nodin');
$idi= $_GET['id'];
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
              <form action="pengajuan_verif.php" method="POST" >
          
                    <input type="date"  name="tgl1">
              
                    <input type="date"   name="tgl2"> 
              
                    <input type="submit" class="btn btn-primary" name="cari" value="Cari">
                
              </form>
          </div>
        </div>
        <div class="panel-body">
          <table id="tabel" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th class="text-center" style="width: 50px;">#</th>
                <th class="text-center" > SPM </th>
                <th class="text-center" > Jenis Pengajuan</th>
                <th class="text-center" > Satker </th>
                <th class="text-center" > Tanggal </th>
                <th class="text-center" > Nominal Pengajuan </th>
                
                <th class="text-center" style="width: 100px;"> Actions </th>
             </tr>
            </thead>
           <tbody>
             <?php $tot=0; foreach ($sales as $sale):?>
             <tr>
               <td class="text-center"><?php echo count_id();?></td>
               <td class="text-center" >
                <?php echo remove_junk($sale['SPM']); ?>
                
              </td>
              <td class="text-center"><?php $nodin=find_by_id('nodin',$sale['id_nodin']);$jenis=find_by_id('jenis',$nodin['id_jenis']); echo $jenis['keterangan']?> </td>
              <td class="text-center" ><?php $nodin=find_by_id('nodin',$sale['id_nodin']);$satker=find_by_id('satker',$nodin['id_satker']); echo $satker['keterangan']?></td>
              <td class="text-center"><?php $nodin= find_by_id('nodin',$sale['id_nodin']);echo $nodin['tanggal']; ?></td>
              <td class="text-center" ><?php $tp=find_NominalPengajuan($sale['id']);echo rupiah($tp['jum']);?></td>
             
               <td class="text-center">
                  <div class="btn-group">
                     <a href="detail_dokumen_ses.php?id=<?=$sale['id']?>" class="btn btn-success btn-xs" title="Detail status Pengajuan" data-toggle="tooltip" > <span class="glyphicon glyphicon-edit"></span></a>
                     <a href="detail_pengajuan.php?id=<?php echo (int)$sale['id'];?>" class="btn btn-primary btn-xs"  title="Detail Pengajuan" data-toggle="tooltip">
                       <span class="glyphicon glyphicon-edit"></span>
                     </a>
            
                  </div>
               </td>
             </tr>
             <?php $tot+=$tp['jum']; endforeach;?>
           </tbody>
           <tr>
                <th class="text-center" >#</th>
                <th class="text-center" >  </th>
                <th class="text-center" >  </th>
                <th class="text-center" >  </th>
                <th class="text-center" >  </th>
                <th class="text-center" >  <?=rupiah($tot);?> </th>
                <th class="text-center" > </th>
             </tr>
         </table>
        </div>
      </div>
    </div>
  </div>
<?php include_once('layouts/footer.php'); ?>
