<?php
    session_start();
    include "../pages/koneksi.php";
    if($_SESSION['token'] == $_POST['login_token']){
        $nim = $_POST['username'];
        $pass = md5($_POST['password']);
        $sqlCek = "SELECT a.username, a.level, b.level_name, b.level_alias FROM tbl_login a INNER JOIN tbl_roles b ON a.level = b.level_id WHERE a.username = '$nim' AND a.password = '$pass'";
        $resultSql = $conn->query($sqlCek);
        if($resultSql->num_rows >= 1){
            while($dtUser = $resultSql->fetch_array()){
                $_SESSION['username'] = $dtUser['username'];
                $_SESSION['level'] = $dtUser['level'];
                $_SESSION['level_name'] = $dtUser['level_name'];
                $_SESSION['level_alias'] = $dtUser['level_alias'];
                $_SESSION['logedin'] = 'login';
            }
            header("Location: ../pages/index.php");
        }else{
            header("Location: ../pages/login.php?msg=error");
        }
    }else{
        echo "Kami menemukan aktivitas yang mencurigakan";
    }