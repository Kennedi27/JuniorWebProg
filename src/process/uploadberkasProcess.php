<?php
    session_start();
    include "../pages/koneksi.php";
    if($_SESSION['token'] == $_POST['daftar_token']){
        $add_sertif = $_FILES['add_sertif']['type'];
        $add_laporan = $_FILES['add_laporan']['type'];
        $add_luaran = $_FILES['add_luaran']['type'];
        $add_dockumentasi = $_FILES['add_dockumentasi']['type'];
        
        if($add_sertif == "application/pdf" && $add_laporan == "application/pdf" && $add_dockumentasi == "application/pdf" && $add_luaran == "application/pdf"){
            $filename_0 = $_SESSION['username']."-sertifikat-".date("Y-m-d",time())."_".time().".pdf";
            $filename_1 = $_SESSION['username']."-kegiatan-".date("Y-m-d",time())."_".time().".pdf";
            $filename_2 = $_SESSION['username']."-luaran-".date("Y-m-d",time())."_".time().".pdf";
            $filename_3 = $_SESSION['username']."-dokumentasi-".date("Y-m-d",time())."_".time().".pdf";

            $destination = array($filename_0, $filename_1, $filename_2, $filename_3);

            $start_date = $_POST['add_startdate'];
            $end_date = $_POST['add_enddate'];
            $i = 0;
            foreach ($_FILES as $fileupload) {
                if(move_uploaded_file($fileupload['tmp_name'], "../files/".$destination[$i])){
                    if($i == 3){
                        $sql = "INSERT INTO tbl_berkas (mhs_nim, brk_sertif, brk_laporan, brk_luaran, brk_start_date, brk_end_date, brk_dokumentasi) VALUES('".$_SESSION['username']."','$destination[0]','$destination[1]','$destination[2]','$start_date','$end_date ','$destination[3]')";
                        $execute = $conn->query($sql);
                        if($execute){
                            header("Location: ../pages/mahasiswa/pengumpulanberkas.php?msg=success");
                        }else{
                            header("Location: ../pages/mahasiswa/pengumpulanberkas.php?msg=exist");
                        }
                    }
                }else{
                    unlink($destination[0]);
                    unlink($destination[1]);
                    unlink($destination[2]);
                    unlink($destination[3]);
                }
                $i++;
            }

        }else{
            header("Location: ../pages/mahasiswa/pengumpulanberkas.php?msg=error");
        }
    }else{

        header("Location: ../pages/mahasiswa/pengumpulanberkas.php?msg=error");
    }



    