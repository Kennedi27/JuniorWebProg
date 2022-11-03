<?php
    session_start();
    if(!$_SESSION['logedin']){
        header("Location: ./login.php");
        exit();
    }
    if(!$_SESSION['level']){
        header("Location: ./login.php");
        exit();
    }else{
        if($_SESSION['level'] == '1'){
            header("Location: ./mahasiswa/index.php");
        }else{
            header("Location: ./pegawai/index.php");
        }
    }