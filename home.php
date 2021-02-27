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
  <div class="modal-dialog modal-xl" style="width:90vw">
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



