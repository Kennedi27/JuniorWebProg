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
?>
<!DOCTYPE html>
    <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="../../assets/assets/css/login.css">
            <link rel="shortcut icon" href="../../assets/assets/img/logo.png" type="image/x-icon">
            <title>Register - MBKM</title>
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
                    <form action="../process/registerProcess.php" method="post">
                        <input type="hidden" value="<?= $_SESSION['token']?>" name="login_token">
                        <div class="right-side-content">
                            <div class="text-war">
                                <h3>Registrasi</h3>
                            </div>
                            <input type="text" name="username" placeholder="NIM" id="username" class="input-login" autocomplete="off" required>
                            <input type="text" name="yourname" placeholder="Nama Lengkap" id="yourname" class="input-login" autocomplete="off" required>
                            <input type="password" name="password" placeholder="Password" id="password" oninput="checkPassword()" class="input-login" required>
                            <span class="text-danger" id="alertpass"></span>
                            <input type="password" name="confpassword" placeholder="Konfirmasi Password" id="confPassword" oninput="checkPassword2()" class="input-login" required>
                            <span class="text-danger" id="alertpass2"></span>
                            <!-- <div class="rememberme">
                                <input type="checkbox" name="remember" id="remember"> Remember Me
                            </div> -->
                            <button class="_btn" type="submit" id="sign_up">Daftar</button>
                            <!-- <a href="./register.php" class="_btn" id="sign_up">Daftar</a> -->
                            <a href="login.php" class="forgot-password">Sudah Memiliki Akun? Login</a>
                            <div class="alert-fail">
                                <?php
                                    if(isset($_GET['msg'])){
                                        if($_GET['msg'] == "exsist"){
                                        ?>
                                            <div class="icon-fail"><span>!</span></div>
                                            <div class="text-fail">Username yang Anda daftarkan sudah terdaftar sebelumnya.</div>
                                <?php } }?>
                            </div>
                            <div class="footer-login">
                                <img src="../../assets/assets/img/logo.png" alt="" class="logo-footer">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <script src="./../../assets/lib/jquery/dist/jquery.min.js"></script>
        </body>
        <script>
            function checkPassword(){
                var password = $("#password").val();                
                if(password.length <= 8){
                    $('#alertpass').html('Password harus lebih dari 8 karakter');
                    $("#sign_up").attr("disabled", true);
                }else{
                    $('#alertpass').html("");
                    $("#sign_up").removeAttr("disabled");
                }
            }

            function checkPassword2(){
                var password = $("#password").val();
                var confpassword = $('#confPassword').val();
                if(password != confpassword){
                    $('#alertpass2').html('Password tidak sama');
                    $("#sign_up").attr("disabled", true);
                }else{
                    $('#alertpass2').html("");
                    $("#sign_up").removeAttr("disabled");
                }
            }
            
        </script>
    </html>