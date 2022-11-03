<?php
    session_start();
    include "../pages/koneksi.php";
    if(isset($_POST['status'])){
        $sql = "UPDATE tbl_mahasiswa SET mhs_status = '".$_POST['status']."' WHERE mhs_nim = '".$_POST['mhs_nim']."'";
        $exeSql = $conn->query($sql);
        if($exeSql){
            if($_POST['status'] == 'tolak'){
                $sqldel = "DELETE FROM tbl_mahasiswa WHERE mhs_nim = '".$_POST['mhs_nim']."'";
                $exec = $conn->query($sqldel);
            }
            echo "success";
        }else{
            echo "failed";
        }
    }else{
        echo "failed";
    }