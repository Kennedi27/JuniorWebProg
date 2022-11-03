<?php
    include "../koneksi.php";
    if($_SESSION['level'] == '1'){
        $sqlDetailUser = "SELECT mhs_nama as nama FROM tbl_mahasiswa WHERE mhs_nim = '".$_SESSION['username']."'";
    }else{
        $sqlDetailUser = "SELECT pgw_nama as nama FROM tbl_pegawai WHERE pgw_nip = '".$_SESSION['username']."'";
    }
    // echo $sqlDetailUser;
    $result = $conn->query($sqlDetailUser);
    while($dtDetail = $result->fetch_array()){
        $namaLogin = $dtDetail['nama'];
        $_SESSION['namaLogin'] = $namaLogin;
    }
?>
        
<body class="sidebar sidebar-collapse" style="padding: 0 !important; margin: 0 !important">
    <div class="wrapper">
        <nav class="main-header navbar navbar-expand border-bottom navbar-dark bg-primary">
            <ul class="navbar-nav">
                <li class="nav-item" style="display: flex; flex-direction: row;">
                    <a class="nav-link" data-widget="pushmenu" href="#">
                        <i class="fa fa-bars" style="font-size: 27px;" aria-hidden="true"></i>
                    </a>
                    <h4 style="padding-top: 8px;"></h4>
                </li>
            </ul>

            <ul class="navbar-nav ml-auto">
                <li class="nav-item " hidden>
                    <a class="nav-link" href="#">
                        <i class="far fa-bell"></i>
                    </a>
                    <span class="badge badge-warning navbar-badge"></span>
                </li>
            </ul>
        </nav>

        <aside class="main-sidebar sidebar-dark-success elevation-5">
            <a href="index.php" class="brand-link bg-dark">
                <!-- <img src="../../../assets/assets/img/logo.png" class="brand-image img-circle elevation-3" style="opacity: .8"> -->
                <span class="brand-text font-weight-light"><b>Merdeka Belajar</b></span>
            </a>
            <div class="sidebar">
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="../../../assets/assets/img/logo-user.png" class="img-circle elevation-2 bg-white" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block" id="edit_me">
                            <?= $_SESSION['username']." | ".$_SESSION['level_name'] ?>
                        </a>
                    </div>
                </div>

                <nav class="mt-3">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                        <li class="nav-item ">
                            <a href="./index.php" class="nav-link">
                                <i class="nav-icon fas fa-home"></i>
                                <p>
                                    Home
                                </p>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a href="./pengumpulanberkas.php" class="nav-link">
                                <i class="nav-icon fas fa-file"></i>
                                <p>
                                    Pengumpulan Berkas
                                </p>
                            </a>
                        </li>
                        
                        <li class="nav-item ">
                            <a href="../logout.php" class="nav-link">
                                <i class="nav-icon fas fa-sign-out-alt"></i>
                                <p>
                                    Log Out
                                </p>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>