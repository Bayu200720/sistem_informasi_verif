<?php 
	require_once('includes/load.php');
	$user 	= find_by_id('users',$_SESSION['user_id']);
	$satker 	= find_all_global('satker',$user['id_satker'], 'id');
	$sales 	= find_nodin_j_pengajuan_spm($_GET['spm']);

		// Enter the name of directory 
	$pathSPM 	= "uploads/spm/";  
	$pathSP2D 	= "uploads/sp2d/";  
	$pathPJ 	= "uploads/pertanggungjawaban/";
	$pathK 		= "uploads/kekurangan/";  

		// Enter the name to creating zipped directory 
	$zipcreated = "uploads/dokumen/Dokumen_RampungSPM_".$_GET['spm']." Tgl. ".strtotime(date('d-m-Y')).".zip"; 

		// Create new zip class 
	$zip = new ZipArchive; 

	if($zip->open($zipcreated, ZipArchive::CREATE ) === TRUE) {  
		$zip->addFile($pathSPM.$sales[0]['file_spm'], 'Dokumen SPM '." Tgl. ".strtotime(date('d-m-Y')).'.pdf'); 
		$zip->addFile($pathSP2D.$sales[0]['file_sp2d'], 'Dokumen SP2D '." Tgl. ".strtotime(date('d-m-Y')).'.pdf'); 
		$zip->addFile($pathSP2D.$sales[0]['upload_pertanggungjawaban'], 'Dokumen Pertanggungjawaban '." Tgl. ".strtotime(date('d-m-Y')).'.pdf'); 
		$zip->addFile($pathK.$sales[0]['upload_kekurangan'], 'Dokumen Kekurangan '." Tgl. ".strtotime(date('d-m-Y')).'.pdf'); 
		$zip ->close(); 
	} 

	$file_name = basename($zipcreated);

	header("Content-Type: application/zip");
	header("Content-Disposition: attachment; filename=$file_name");
	header("Content-Length: " . filesize($zipcreated));

	readfile($zipcreated);
	exit;
?>