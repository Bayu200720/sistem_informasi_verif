<?php
require_once('includes/load.php');
extract($_GET);

$q = "select * from `detail_transaksi` where `id_detail_pengajuan`=".$id; 
$result = $db->query($q);								
if($result){
	$hasil = find_by_id("detail_pengajuan",$id); 
    $user=find_by_id('users',$_SESSION['user_id']);
    $satker = find_all_global('satker',$user['id_satker'],'id');
	?>
<style type="text/css">
<!--
table td {padding-left:3px;}
.halman{
							page-break-after: always;
							 page-break-inside: avoid;
							 margin-top: 10px;
							 margin-bottom: 10px;
							 margin-left: 50px;
							 margin-right: 30px;

}
.style24 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 10px;
}
.style27 {padding-left:3px; font-weight: bold;}
-->
</style>

<div class="halman" align=center>
<form id="formulir_create">
<input type="hidden" name="mak" value="" />

<table width="755" border="0">
  <tr>
    <td height="23" colspan="5" class="style24"><div align="center"><strong>DAFTAR NOMINATIF<br>PEJABAT NEGARA/PEGAWAI NEGERI/PEGAWAI TIDAK TETAP<br>PADA SATKER BADAN PENELITIAN DAN PENGEMBANGAN SUMBER DAYA MANUSIA</strong></div></td>
  </tr>
 
  <tr>
    <td width="23" class="style24">&nbsp;</td>
    <td width="158" class="style24">&nbsp;</td>
    <td width="547" class="style24">&nbsp;</td>
    <td width="2" class="style24">&nbsp;</td>
    <td width="3" class="style24">&nbsp;</td>
  </tr>
  
</table>

<table  height="75" border="1" cellpadding="0" cellspacing="0">
  <tr>
    <td width="24"  class="style24"><div align="center" class="style27">No</div></td>
	<td width="128"  class="style24"><div align="center" class="style27">Penerima</div></td>
    <td width="128"  class="style24"><div align="center" class="style27">Tanggal</div></td>
    <td width="190"  class="style24"><div align="center" class="style27">Uraian</div></td>
    <td width="61"  class="style24"><div align="center" class="style27">Dibayar</div></td>
    <td width="61"  class="style24"><div align="center" class="style27">PPh21</div></td>
    <td width="61"  class="style24"><div align="center" class="style27">Diterima</div></td>
 </tr>


 <?php 
	$jml=0;
    $pph=0;
    $ths=0;
			$qj= "select * from `detail_transaksi` where `id_detail_pengajuan`='".$id."'";
            $result = $db->query($qj); 
            foreach ($result as $sale):  
            ?>		
					
                    <tr>
						<td class="style24"><div align="center" ><?php echo count_id() ?></div></td>
						 <td class="style24">&nbsp;<?php echo $sale['penerima']?></td>
                        <td class="style24">&nbsp;<?=$sale['tanggal_transaksi']?></td>
						<td class="style24"><?php echo $sale['uraian'] ?></td>
						<td class="style24" ><?=rupiah($sale['nominal'])?></td>
						<td class="style24" ><?php echo rupiah($sale['pph'])?></td>
                        <td class="style24" ><?php $hs=$sale['nominal']-$sale['pph']; echo rupiah($hs)?></td>
					  </tr>

					
                <?php $jml+=$sale['nominal']; 
                        $pph+=$sale['pph'];
                        $ths+=$hs;
                        endforeach;                       
                ?>


   
  <tr>
    <td class="style24">&nbsp;</td>
    <td class="style24">&nbsp;</td>
    <td class="style24">&nbsp;</td>
    <td class="style24">TOTAL</td>
    <td class="style24">      <?=rupiah($jml)?>  </td>
    <td class="style24">      <?=rupiah($pph)?>  </td>
    <td class="style24">   <?=rupiah($ths)?>  </td>
  </tr>
</table> 
<table width="754" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="4" class="style24"><p>  <br />
      </p>
    <p>&nbsp;</p></td>
  </tr>
  <tr>
    <td width="29" class="style24">&nbsp;</td>
    <td width="171" class="style24">&nbsp;<br /> 
      <?php $pengajuan = find_by_id('pengajuan',$hasil['id_pengajuan']); 
        if($pengajuan['id_jenis_pengajuan'] == 6){ 
        $nodin = find_by_id('nodin',$pengajuan['id_nodin']);
        if($nodin['id_satker'] == 1 OR $nodin['id_satker'] == 2 OR $nodin['id_satker'] == 3 OR $nodin['id_satker'] == 4 OR $nodin['id_satker'] == 14){ print "Bendahara Pengeluaran";}else{print "Bendahara Pengeluaran Pembantu";}}else{}?> </td>
    <td width="295" class="style24">&nbsp;</td>
    <td width="259" class="style24">&nbsp;Jakarta,    
      <label>
     <?=date_format(date_create($d['tanggal']),'d-m-Y')?>
      </label>
      <br />
    <?=$satker[0]['jabatan_pimpinan']?></td>
  </tr>
  <tr>
    <td class="style24">&nbsp;</td>
    <td class="style24"><br />
    <br />
    <br />
<br />

<?php if($pengajuan['id_jenis_pengajuan'] == 6)  print $satker[0]['bpp']; ?><br />
<?php if($pengajuan['id_jenis_pengajuan'] == 6)  print "NIP.".$satker[0]['nip_bpp'];  ?></td>
    <td class="style24">&nbsp;</td>
    <td class="style24"><br />
      <br />
      <br />
<br />

<?=$satker[0]['ppk']?><br />
NIP. <?=$satker[0]['nip_ppk']?></td>
  </tr>
  <tr>
    <td class="style24">&nbsp;</td>
    <td class="style24">&nbsp;</td>
    <td class="style24">&nbsp;</td>
    <td class="style24">&nbsp;</td>
  </tr>
  <tr>
    <td class="style24">&nbsp;</td>
    <td class="style24">&nbsp;</td>
    <td class="style24">&nbsp;</td>
    <td class="style24">&nbsp;</td>
  </tr>
</table>
</form>
</div>

<script language="javascript">window.print();</script>
<?php
}
?>