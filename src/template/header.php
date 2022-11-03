<?php
    session_start();
    if(!$_SESSION['logedin']){
        header("Location: ./login.php");
        exit();
    }
?>
<!DOCTYPE html>
    <html>
        <head>
            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
            <link rel="shortcut icon" href="../../../assets/assets/img/logo.png" type="image/x-icon">
            <link href="../../../assets/lib/adminlte/plugins/fontawesome-free/css/all.min.css" rel="stylesheet"/>
            <link href="../../../assets/lib/adminlte/plugins/fontawesome-free/css/fontawesome.min.css" rel="stylesheet"/>
            <link href="../../../assets/lib/adminlte/plugins/fontawesome-free/css/solid.min.css" rel="stylesheet"/>
            <link rel="stylesheet" href="../../../assets/lib/bootstrap/dist/css/bootstrap.min.css"/>
            <link href="../../../assets/lib/adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.css" rel="stylesheet"/>
            <link href="../../../assets/lib/adminlte/dist/css/adminlte.css" rel="stylesheet"/>
            <link href="../../../assets/lib/adminlte/plugins/sweetalert2/sweetalert2.css" rel="stylesheet"/>
            <link rel="stylesheet" href="../../../assets/plugin/datepicker/datepicker3.css">
            <link rel="stylesheet" href="../../../assets/plugin/selecpicker/bootstrap-select.min.css">
            <link href="../../../assets/lib/adminlte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css" rel="stylesheet"/>
        </head>
        