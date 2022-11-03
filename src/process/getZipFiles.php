<?php
    session_start();
    include '../pages/koneksi.php';
    include "./function.php";
    if(isset($_SESSION['username'])){
        $sql = "SELECT * FROM tbl_berkas WHERE id = '".$_GET['id']."'";
        $exe = $conn->query($sql);
        $resp = $exe->fetch_array();
        $sertif = $resp['brk_sertif'];
        $laporan = $resp['brk_laporan'];
        $luaran = $resp['brk_luaran'];
        $name_file = $resp['mhs_nim'];
        $dokumentasi = $resp['brk_dokumentasi'];

        $files = array($sertif, $laporan, $luaran , $dokumentasi);
        $filesPath = '../files/';
        $zipName = $name_file.'-'.date("Y-m-d",time())."_".time().'.zip';
    
        echo createZipAndDownload($files, $filesPath, $zipName);
    }else{
        header("Location: ./logout.php");
    }