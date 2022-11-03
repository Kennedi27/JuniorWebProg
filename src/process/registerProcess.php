<?php
    session_start();
    include "../pages/koneksi.php";
    if($_SESSION['token'] == $_POST['login_token']){
        // echo $_POST['login_token'];
        $nim = $_POST['username'];
        $pass = md5($_POST['password']);
        $confpass = md5($_POST['confpassword']);
        $yourname = $_POST['yourname'];
        $sqlCek = "SELECT id FROM tbl_login WHERE username = '$nim'";
        $exeSqlCek = $conn->query($sqlCek);
        if($exeSqlCek->num_rows < 1){
            if($pass == $confpass){
                $sql = "INSERT INTO tbl_login (username, password, level) VALUES ('$nim','$confpass',1)";
                $exeSql = $conn->query($sql);
                if($exeSql){
                    $sqlMhs = "INSERT INTO tbl_mahasiswa (mhs_nim, mhs_nama, mhs_status) VALUES('$nim', '$yourname', 'none')";
                    $exeSqlMhs = $conn->query($sqlMhs);
                    if($exeSqlMhs){
                        header("Location: ../pages/login.php?msg=register");
                    }else{
                        header("Location: ../pages/register.php?msg=failed");
                    }
                }else{
                    header("Location: ../pages/register.php?msg=error");
                }
            }else{
                header("Location: ../pages/register.php?msg=error");
            }
            $conn->close();
        }else{
            header("Location: ../pages/register.php?msg=exsist");
        }
    }else{
        echo "You don't have Authorize";
    }