<?php
    include "../pages/koneksi.php";
    $type = $_POST['type'];
    if($type == "getprodi"){
        $jurusan = $_POST['jurusan'];
        $sql = "SELECT DISTINCT prd_kode as kode, prd_name as nama FROM tbl_prodi WHERE jrs_kode = '".$jurusan."' ORDER BY prd_name";
        $result = $conn->query($sql);
        while($rs = $result->fetch_array()){
            echo "<option value='".$rs['kode']."'>".$rs['nama']."</option>";
        }
    }else if($type == "getmatkul"){
        $sql = "SELECT DISTINCT mtk_kode as kode, mtk_name as nama FROM tbl_matkul WHERE prd_kode ='".$_POST['prodi']."' AND mtk_semester = '".$_POST['semester']."' ORDER BY mtk_name";
        // echo $sql;
        $result = $conn->query($sql);
        while($rs = $result->fetch_array()){
            echo "<option value='".$rs['kode']."'>".$rs['nama']."</option>";
        }
    }