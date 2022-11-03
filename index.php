<?php
    session_start();
    if($_SESSION['logedin']){
        header("Location: ./src/index.php");
    }else{
        header("Location: ./src/pages/login.php");
    }