<?php
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(3);
?>
<?php
  $d_sale = find_by_id('jenis',(int)$_GET['id']);
  $user = find_by_id('users',(int)$_SESSION['user_id']);
  if(!$d_sale){
    $session->msg("d","Missing jenis pengajuan id.");
      if($user['user_level']==2){
              redirect('jenis.php', false);
          }else{
    redirect('jenis.php');
        }
  }
?>
<?php
  $delete_id = delete_by_id('jenis',(int)$d_sale['id']);
  if($delete_id){
      $session->msg("s","Jenis pengajuan deleted.");
      if($user['user_level']==2){
              redirect('jenis.php', false);
          }else{
      redirect('jenis.php');
        }
  } else {
      $session->msg("d","Jenis pengajuan deletion failed.");
          if($user['user_level']==2){
              redirect('jenis.php', false);
          }else{
      redirect('jenis.php');
          }
  }
?>
