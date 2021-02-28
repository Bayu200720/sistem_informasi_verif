<?php
  $page_title = 'Home Page';
  require_once('includes/load.php');
  if (!$session->isUserLoggedIn(true)) { redirect('index.php', false);}
   $user = find_by_id('users',(int)$_SESSION['user_id']);
   $status = find_by_id('user_groups',(int)$user['user_level']);

?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
  <div class="col-md-12">
    <?php echo display_msg($msg); ?>
  </div>
 <div class="col-md-12">
    <div class="panel">
      <div class="jumbotron text-center">
         <h1>Selamat Datang <?php echo $user['name'];?></h1>
         <p>Status Anda Sebagai <?php echo $status['group_name'];?></p>
      </div>
    </div>
 </div>
 
   <div class="col-md-6">
  
   </div>
</div>
  <div class="row">
    <div class="col-md-3">
       <div class="panel panel-box clearfix">
         <div class="panel-icon pull-left bg-green">
          <i class="glyphicon glyphicon-user"></i>
        </div>
        <div class="panel-value pull-right">
          <h2 class="margin-top">  </h2>
          <p class="text-muted">SPM Belom di Verifikasi</p>
        </div>
       </div>
    </div>
    <div class="col-md-3">
       <div class="panel panel-box clearfix">
         <div class="panel-icon pull-left bg-red">
          <i class="glyphicon glyphicon-list"></i>
        </div>
        <div class="panel-value pull-right">
          <h2 class="margin-top"> </h2>
          <p class="text-muted">SPM Terverifikasi</p>
        </div>
       </div>
    </div>
    <div class="col-md-3">
       <div class="panel panel-box clearfix">
         <div class="panel-icon pull-left bg-blue">
          <i class="glyphicon glyphicon-shopping-cart"></i>
        </div>
        <div class="panel-value pull-right">
          <h2 class="margin-top"> </h2>
          <p class="text-muted">Pertanggungjawaban Belom di Upload</p>
        </div>
       </div>
    </div>
    <div class="col-md-3">
       <div class="panel panel-box clearfix">
         <div class="panel-icon pull-left bg-yellow">
          <i class="glyphicon glyphicon-usd"></i>
        </div>
        <div class="panel-value pull-right">
          <h2 class="margin-top"></h2>
          <p class="text-muted">SPTJB</p>
        </div>
       </div>
    </div>
</div>
  <div class="row">
   <div class="col-md-12">
      <div class="panel">
        <div class="jumbotron text-center">
          

        </div>
      </div>
   </div>
  </div>
  <div class="row">
   <div class="col-md-4">
     <div class="panel panel-default">
       <div class="panel-heading">
         <strong>
           <span class="glyphicon glyphicon-th"></span>
           <span>Total Pengajuan Setiap Sub Satker</span>
         </strong>
       </div>
       <div class="panel-body">
         <table class="table table-striped table-bordered table-condensed">
          <thead>
           <tr>
             <th>No</th>
             <th>Nama Satker</th>
             <th>Total SPM</th>
           <tr>
          </thead>
          <tbody>
            <?php $tot2=0; foreach ($products_sold as  $product_sold): ?>
              <tr>
                <td><?php echo count_id();?></td>
                <td><?php echo remove_junk(first_character($product_sold['keterangan'])); ?></td>
                <td><?php echo (int)$product_sold['totalSold']; ?></td>
                
              </tr>
            <?php $tot2+=$product_sold['totalSold'];  endforeach; ?>
            <tr>
               <td class="text-center"></td>
               <td class="text-center">Jumlah</td>
               <td><?php echo rupiah(remove_junk(first_character($tot2))); ?></td>
           </tr>

          <tbody>
         </table>
       </div>
     </div>
   </div>
   <div class="col-md-4">
      <div class="panel panel-default">
        <div class="panel-heading">
          <strong>
            <span class="glyphicon glyphicon-th"></span>
            <span>Realisasi Setiap Sub Satker</span>
          </strong>
        </div>
        <div class="panel-body">
          <table class="table table-striped table-bordered table-condensed">
       <thead>
         <tr>
           <th class="text-center" style="width: 50px;">#</th>
           <th>Satker</th>
           <th>Total Penyerapan</th>
         </tr>
       </thead>
       <tbody>
         <?php $n1=0;$tot1=0; foreach ($recent_products as  $recent_sale): $n1+=1; ?>
         <tr>
           <td class="text-center"><?php echo $n1;?></td>
           <td><?php echo remove_junk(ucfirst($recent_sale['keterangan'])); ?></td>
           <td>Rp. <?php echo rupiah(remove_junk(first_character($recent_sale['total']))); ?></td>
        </tr>

       <?php $tot1+=$recent_sale['total'];  endforeach; ?>
          <tr>
           <td class="text-center"></td>
           <td class="text-center">Jumlah</td>
           <td>Rp. <?php echo rupiah(remove_junk(first_character($tot1))); ?></td>
          </tr>
       </tbody>
     </table>
    </div>
   </div>
  </div>

  <div class="col-md-4">
      <div class="panel panel-default">
        <div class="panel-heading">
          <strong>
            <span class="glyphicon glyphicon-th"></span>
            <span>SPM Sub Satker yang Belom di Proses</span>
          </strong>
        </div>
        <div class="panel-body">
          <table class="table table-striped table-bordered table-condensed">
       <thead>
         <tr>
           <th class="text-center" style="width: 50px;">#</th>
           <th>Satker</th>
           <th>Total SPM</th>
         </tr>
       </thead>
       <tbody>
         <?php $n=0;$tot=0; foreach ($recent_sales  as  $r): $n+=1;?>
         <tr>
           <td class="text-center"><?php echo $n;?></td>
           <td><?php echo remove_junk(ucfirst($r['keterangan'])); ?></td>
           <td><?php echo rupiah(remove_junk(first_character($r['jumlah_SPM']))); ?></td>
        </tr>
        
       <?php $tot+=$r['jumlah_SPM'];  endforeach; ?>
         <tr>
           <td class="text-center"></td>
           <td class="text-center">Jumlah</td>
           <td><?php echo rupiah(remove_junk(first_character($tot))); ?></td>
        </tr>
       </tbody>
     </table>
    </div>
   </div>
  </div>
 </div>
</div>
 </div>


</div>


<?php include_once('layouts/footer.php'); ?>



<script type="text/javascript">
  $(document).ready(function() {
		$('#Body_dp').load('notif.php');
        $('#Detail_Nodin').modal('show');
    
    });
</script>

     <!-- Modal Detail Pengajuan-->
<div class="modal fade" id="Detail_Nodin" tabindex="-1" role="dialog" aria-labelledby="nodin" aria-hidden="true">
  <div class="modal-dialog modal-xl" style="width:50vw">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Pemberitahuan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div id="Body_dp" style="width:100%;">
      
    </div>
    </div>
  </div>
</div>



