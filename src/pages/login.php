<?php
    session_start();
    if(isset($_SESSION['logedin'])){
        echo "<script>history.back();</script>";
    }
    if(isset($_SESSION['token'])){
        $token = $_SESSION['token'];
    }else{
        $_SESSION['token'] = bin2hex(random_bytes(32));
    }
    $msg = "";
    if(isset($_GET['msg'])){
        $msg = $_GET['msg'];
    }
?>
<!DOCTYPE html>
    <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="../../assets/assets/css/login.css">
            <link rel="shortcut icon" href="../../assets/assets/img/logo.png" type="image/x-icon">
            <title>Login - MBKM</title>
        </head>

        <body>
            <div id="wrapper-login">
                <div class="left-side">
                    <div class="left-side-content">
                        <img src="../../assets/assets/img/bg-image.jpg" alt="" class="bg-image">
                    </div>
                    <div class="top-content">
                        <div class="content-center">
                            <img src="../../assets/assets/img/apps-logo.png" alt="Apps" class="apps-logo">
                            <div class="apps-name">Merdeka Belajar</div>
                            <div class="subtitle-apps">Tingkatkan Bakat Anda Dengan Mengikuti <br />Program Kampus Merdeka </div>
                        </div>
                        <div class="left-side-footer">
                            <a href="https://kampusmerdeka.kemdikbud.go.id/" class="wrap-learn" target="_blank">
                                <div class="rounded-icon"><i>i</i></div>
                                <span class="learn-more">Pelajari lebih lanjut tentang MBKM</span>
                            </a>
                            <div class="copyright">

                            </div>
                        </div>
                    </div>
                    <div class="green-l"></div>
                </div>
                <div class="right-side">
                    <div class="green-r"></div>
                    <form action="../process/loginProcess.php" method="post">
                        <input type="hidden" value="<?= $_SESSION['token'] ?>" name="login_token">
                        <div class="right-side-content">
                            <div class="text-war">
                                Kampus Merdeka merupakan bagian dari kebijakan Merdeka Belajar oleh Kementerian Pendidikan, Kebudayaan, Riset, dan Teknologi Republik Indonesia, bagi mahasiswa/i untuk mengasah kemampuan sesuai bakat dan minat.
                            </div>
                            <input type="text" name="username" placeholder="Username" id="username" class="input-login" autocomplete="off" required>
                            <input type="password" name="password" placeholder="Password" id="password" class="input-login" required>
                            <!-- <div class="rememberme">
                                <input type="checkbox" name="remember" id="remember"> Remember Me
                            </div> -->
                            <button class="_btn" type="submit" id="login">Masuk</button>
                            <a href="./register.php" class="_btn" id="sign_up">Daftar</a>
                            <!-- <a href="#" class="forgot-password">Forgot Your Password?</a> -->
                            <div class="alert-fail">
                                <?php
                                    if(isset($_GET['msg'])){
                                        if($_GET['msg'] == "error"){
                                        ?>
                                            <div class="icon-fail"><span>!</span></div>
                                            <div class="text-fail">Username atau Password salah. Silahkan Cek dan Ulangi Kembali</div>
                                    <?php
                                        }else if($msg == "register"){ ?>
                                            <!-- <div class="icon-fail"><span>!</span></div> -->
                                            <div class="text-success">Pendaftaran Berhasil!!</div><?php
                                        }else if($msg == "logout"){ ?>
                                            <!-- <div class="icon-fail"><span>!</span></div> -->
                                            <div class="text-success">Berhasil Logout</div><?php
                                        }
                                    }
                                ?>
                            </div>
                            <div class="footer-login">
                                <img src="../../assets/assets/img/logo.png" alt="" class="logo-footer">
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </body>
    </html>