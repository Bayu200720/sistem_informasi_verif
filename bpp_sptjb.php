<?php
  $page_title = 'All Pengajuan';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
?>
<?php
 //delete pencairan
 //var_dump($_GET['status']);exit();
$status= $_GET['status'];


if($_GET['status'] == 'h'){
  $id =$_GET['id'];
  $query="DELETE FROM detail_pengajuan WHERE id =".$id;
  $hasil=$db->query($query);
  
  if($hasil){
      $session->msg('s',"Delete Success ");
      if($user['user_level']==2){
      redirect('bpp_sptjb.php', false);
      }else{
      redirect('bpp_sptjb.php', false);
      }
  } else {
      $session->msg('d',' Sorry failed to added!');
      if($user['user_level']==2){
      redirect('bpp_sptjb.php', false);
  }else{
      redirect('bpp_sptjb.php', false);
  }
  }
}
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
     $id_sptjb = $_POST['id_sptjb'];
     if($_POST['id_sptjb']){

       $query  = "UPDATE detail_pengajuan SET";
       $query .=" no_sptjb='{$no_sptjb}',nominal='{$nominal}',id_akun='{$akun}',keterangan='{$keterangan}',pph='{$pph}',ppn='{$ppn}',tanggal_dp='{$tanggal}'";
       $query .=" WHERE id= '{$id_sptjb}'";
     }
     else{
       $query  = "INSERT INTO detail_pengajuan (";
       $query .=" no_sptjb,nominal,id_akun,keterangan,id_pengajuan,pph,ppn,tanggal_dp";
       $query .=") VALUES (";
       $query .=" '{$no_sptjb}', '{$nominal}', '{$akun}', '{$keterangan}', '{$id_pengajuan}','{$pph}','{$ppn}','{$tanggal}'";
       $query .=")";
     }
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
          <a href="#" class="btn btn-primary" id="editsp2d" data-toggle="modal" data-target="#modal_sptjb" data-id='<?=$sale['id'];?>'>Add SPTJB</a>
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
                     <a href="#" data-id='<?=$sale['id'];?>' data-tanggal="<?=$sale['tanggal_dp']?>" data-no_sptjb="<?=$sale['no_sptjb']?>" data-id_akun="<?=$sale['id_akun']?>" data-nominal="<?=$sale['nominal']?>" data-pph="<?=$sale['pph']?>" data-ppn="<?=$sale['ppn']?>" data-keterangan="<?=$sale['keterangan']?>" class="btn btn-warning btn-xs btn-edit" title="Edit" >
                       <span class="glyphicon glyphicon-edit"></span>
                     </a>
                     <a onclick="return confirm('Yakin Hapus?')" href="bpp_sptjb.php?id=<?=$sale['id'];?>&status=h" class="btn btn-danger btn-xs"  title="Delete" data-toggle="tooltip">
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




<!-- Modal input sp2d-->
<div class="modal fade" id="modal_sptjb" tabindex="-1" role="dialog" aria-labelledby="modal_sptjbLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal_sptjbLabel">Add SPTJB</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="bpp_sptjb.php" method="POST">
      <input type="hidden" id="id_sptjb" name="id_sptjb">
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
              <input type="radio" class="radio-pajak" name="pph1" aria-label="Checkbox for following text input" value="pph5p">
              <label for="pph2p"><i > PPH 21 5%</i> </label>
              <input type="radio" class="radio-pajak" name="pph1" aria-label="Checkbox for following text input" value="pph15p">
              <label for="pph15p"><i > PPH 21 15%</i> </label>
              <input type="radio" class="radio-pajak" name="pph1" aria-label="Checkbox for following text input" value="pph2p">       
              <label for="pph2p"><i > PPH 23 2%</i></label>
              <input type="radio" class="radio-pajak" name="pph1" aria-label="Checkbox for following text input" value="ppn">       
              <label for="ppn"><i > PPN 10%</i></label>
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script>
  $(document).ready(function(){
    $('#modal_sptjb').on('hidden.bs.modal', function () { 
      location.reload(true);
      // alert('as')
    });
    $('.radio-pajak').on('click', function(){
      var nominal = getNum(hapustitik($('#nominal').val()));
      var pph = 0;
      var ppn = 0;
      if($(this).val() == 'pph2p'){
        pph = nominal * 2/100;
        $('#pph').val(pph);
      }
      if($(this).val() == 'pph15p'){
        pph = nominal * 15/100;
        $('#pph').val(pph);
      }
      if($(this).val() == 'ppn'){
        ppn = nominal * 10/100;
        $('#ppn').val(ppn);
      }
      if($(this).val() == 'pph5p'){
        pph = nominal * 5/100;
        $('#pph').val(pph);
      }
    });
    $('#nominal').on('keyup', function(){

      var nominal = getNum(hapustitik($('#nominal').val()));
      var pph = 0;
      var ppn = 0;
      if($('.radio-pajak').val() == 'pph2p'){
        pph = nominal * 2/100;
        $('#pph').val(pph);
      }
      if($('.radio-pajak').val() == 'pph15p'){
        pph = nominal * 15/100;
        $('#pph').val(pph);
      }
      if($('.radio-pajak').val() == 'ppn'){
        ppn = nominal * 10/100;
        $('#ppn').val(ppn);
      }
      console.log($('.radio-pajak').val());
    });
    $('.btn-edit').on('click', function(e){
      e.preventDefault();
      $('#modal_sptjb').modal('show');
      $('#id_sptjb').val($(this).data('id'));
      $('#tanggal').val($(this).data('tanggal'));
      $('#no_sptjb').val($(this).data('no_sptjb'));
      $('#id_akun').val($(this).data('id_akun'));
      $('#nominal').val($(this).data('nominal'));
      $('#pph').val($(this).data('pph'));
      $('#ppn').val($(this).data('ppn'));
      $('#keterangan').val($(this).data('keterangan'));
      $('#modal_sptjbLabel').html('Edit SPTJB');
    })
    function hapustitik(angka){
        var nilai = angka.split('.').join("");
        return nilai;
    }
    function getNum(val) {
       if (isNaN(val)) {
         return 0;
       }
       return val;
    }
  })
</script>