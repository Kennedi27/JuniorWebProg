<?php
    session_start();
    include "../pages/koneksi.php";
    if($_SESSION['token'] == $_POST['daftar_token']){
        $edit_sertif = $_FILES['edit_sertif']['type'];
        $edit_laporan = $_FILES['edit_laporan']['type'];
        $edit_luaran = $_FILES['edit_luaran']['type'];
        $edit_dockumentasi = $_FILES['edit_dockumentasi']['type'];
        // var_dump($_FILES);
        if($edit_sertif == "application/pdf" && $edit_laporan == "application/pdf" && $edit_dockumentasi == "application/pdf" && $edit_luaran == "application/pdf"){
            $filename_0 = $_SESSION['username']."-sertifikat-".date("Y-m-d",time())."_".time().".pdf";
            $filename_1 = $_SESSION['username']."-kegiatan-".date("Y-m-d",time())."_".time().".pdf";
            $filename_2 = $_SESSION['username']."-luaran-".date("Y-m-d",time())."_".time().".pdf";
            $filename_3 = $_SESSION['username']."-dokumentasi-".date("Y-m-d",time())."_".time().".pdf";

            $destination = array($filename_0, $filename_1, $filename_2, $filename_3);

            $start_date = $_POST['edit_startdate'];
            $end_date = $_POST['edit_enddate'];
            $i = 0;
            foreach ($_FILES as $fileupload) {
                if(move_uploaded_file($fileupload['tmp_name'], "../files/".$destination[$i])){
                    if($i == 3){
                        $sql = "UPDATE tbl_berkas SET brk_sertif = '".$destination[0]."', brk_laporan = '".$destination[1]."', brk_luaran = '".$destination[2]."', brk_start_date = '$start_date', brk_end_date = '$end_date', brk_dokumentasi = '".$destination[3]."' WHERE id = '".$_POST['id']."'";
                        $execute = $conn->query($sql);
                        if($execute){
                            header("Location: ../pages/mahasiswa/pengumpulanberkas.php?msg=success");
                        }else{
                            header("Location: ../pages/mahasiswa/pengumpulanberkas.php?msg=error");
                        }
                        // echo $sql;
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
            // echo $_POST['id']."type";
            header("Location: ../pages/mahasiswa/pengumpulanberkas.php?msg=error");
        }
    }else{
        // echo $_POST['id'];
        // var_dump($_FILES);
        header("Location: ../pages/mahasiswa/pengumpulanberkas.php?msg=error");
    }



    