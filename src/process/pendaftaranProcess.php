<?php
    session_start();
    include "../pages/koneksi.php";
    if($_SESSION['token'] == $_POST['daftar_token']){
        $add_nim = $_POST['add_nim'];
        $add_jurusan = $_POST['add_jurusan'];
        $add_prodi = $_POST['add_prodi'];
        $add_matkul = $_POST['add_matkul'];
        $add_angkatan = $_POST['add_angkatan'];
        $add_program = $_POST['add_program'];
        $add_jenisMbkm = $_POST['add_jenisMbkm'];
        $add_tempatKegiatan = $_POST['add_tempatKegiatan'];
        $add_semesterKlaim = $_POST['add_semesterKlaim'];
        $arr_add_matkul = implode(',', $add_matkul);
        if(is_uploaded_file($_FILES['add_buktiPenerimaan']['tmp_name'])){
            if($_FILES['add_buktiPenerimaan']['type'] == "application/pdf"){
                $filename = $_SESSION['username']."-".date("Y-m-d",time())."_".time().".pdf";
                $destination = "../files/".$filename;
                $temp_file = $_FILES['add_buktiPenerimaan']['tmp_name'];
                if(move_uploaded_file($temp_file, $destination)){
                    $sqlCek = "SELECT * FROM tbl_mahasiswa WHERE mhs_nim = '$add_nim' AND mhs_status = 'none'";
                    $exeCek = $conn->query($sqlCek);
                    if($exeCek->num_rows > 0){
                        $sql = "UPDATE tbl_mahasiswa SET
                                mhs_jurusan = '$add_jurusan',
                                mhs_prodi = '$add_prodi',
                                mhs_angkatan = '$add_angkatan',
                                mhs_program_ikuti = '$add_program',
                                mhs_jns_mbkm = '$add_jenisMbkm',
                                mhs_tmp_kegiatan = '$add_tempatKegiatan',
                                mhs_bukti_peneriamaan = '$filename',
                                mhs_klaim_matkul = '$arr_add_matkul',
                                mhs_semester = '$add_semesterKlaim',
                                mhs_status = 'pending' WHERE mhs_nim = '$add_nim'";
                        $result = $conn->query($sql);
                        if($result){
                            header("Location: ../pages/mahasiswa/index.php?msg=success");
                        }else{
                            header("Location: ../pages/mahasiswa/index.php?msg=error");
                        }
                    }else{
                        $sqlQuery = "INSERT INTO tbl_mahasiswa_history (mhs_nim, mhs_nama, mhs_jurusan, mhs_prodi, mhs_angkatan, mhs_program_ikuti, mhs_jns_mbkm, mhs_tmp_kegiatan, mhs_bukti_peneriamaan, mhs_klaim_matkul, mhs_semester, mhs_status) SELECT mhs_nim, mhs_nama, mhs_jurusan, mhs_prodi, mhs_angkatan, mhs_program_ikuti, mhs_jns_mbkm, mhs_tmp_kegiatan, mhs_bukti_peneriamaan, mhs_klaim_matkul, mhs_semester, mhs_status FROM tbl_mahasiswa WHERE mhs_nim='$add_nim'";
                        $execQuery = $conn->query($sqlQuery);
                        $sql = "UPDATE tbl_mahasiswa SET
                                mhs_jurusan = '$add_jurusan',
                                mhs_prodi = '$add_prodi',
                                mhs_angkatan = '$add_angkatan',
                                mhs_program_ikuti = '$add_program',
                                mhs_jns_mbkm = '$add_jenisMbkm',
                                mhs_tmp_kegiatan = '$add_tempatKegiatan',
                                mhs_bukti_peneriamaan = '$filename',
                                mhs_klaim_matkul = '$arr_add_matkul',
                                mhs_semester = '$add_semesterKlaim',
                                mhs_status = 'pending' WHERE mhs_nim = '$add_nim'";
                        $result = $conn->query($sql);
                        if($result){
                            header("Location: ../pages/mahasiswa/index.php?msg=success");
                        }else{
                            header("Location: ../pages/mahasiswa/index.php?msg=error");
                        }
                    }
                    
                }else{
                    header("Location: ../pages/mahasiswa/index.php?msg=error");
                    // echo "gagal".$filename;
                }
            }else{
                header("Location: ../pages/mahasiswa/index.php?msg=wrongext");
            }
        }else{
            header("Location: ../pages/mahasiswa/index.php?msg=error");
        }
    }else{
        header("Location: ../pages/mahasiswa/index.php?msg=auth");
    }
