<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1" />
    <title>Register_OpenShare</title>
    <link rel="stylesheet" href="../assests/style.css" />
    <?php include('../../../file.php'); ?>

</head>

<body>
    <?php
    session_start();
    if (isset($_POST['register'])) {

        $name = $_POST['name'];
        $password = $_POST['password'];
        $userName = $_POST['userName'];
        $url = 'http://localhost:8000/website_openshare/controllers/users/auth/register.php';
        $data = array(
            'name' => $name,
            'password' => $password,
            'userName' => $userName,
        );

        $options = array(
            CURLOPT_URL => $url,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => array(
                'Access-Control-Allow-Origin: *',
                'Access-Control-Allow-Methods: POST',
                'Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With',
                "Accept: application/json",
            )
        );

        $curl = curl_init();
        curl_setopt_array($curl, $options);
        $response = curl_exec($curl);
        curl_close($curl);
        if ($response) {
            $result = json_decode($response, true);
        }
        if ($result["status"] == 422) {
    ?>
            <input type="hidden" id="err_ms" value="<?php echo ($result["message"]); ?>" />
    <?php
        } else {
            $_SESSION['res_suc'] = "Đăng ký thành công, vui lòng đăng nhập";
            header('location:./view_login.php');
        }
    }
    ?>
    <div class="container-box">
        <div class="container-login">
            <div class="left">
                <img src="../assests/images/openshare_logo.png" width="380px" height="100px" />
                <p>OPENSHARE CHO ĐI LÀ CÒN MÃI</p>
            </div>
            <div class="right">
                <form action="" class="form-login" method="post">
                    <input type="text" placeholder="Tên đăng nhập" name="userName" value="<?php if (isset($_POST['userName'])) echo $_POST['userName'];
                                                                                            else '';  ?>" required />
                    <input type="text" placeholder="Họ và tên" name="name" value="<?php if (isset($_POST['name'])) echo $_POST['name'];
                                                                                    else '';  ?>" required />
                    <input type="password" placeholder="Mật khẩu" name="password" id="password" value="<?php if (isset($_POST['password'])) echo $_POST['password'];
                                                                                                        else '';  ?>" required />
                    <i class="bi bi-eye" id="togglePassword" onclick="togglePasswordVisibility()"></i>
                    <div id="err_dl" style="margin-bottom: 5px;"></div>

                    <button class="loginBtn" type="submit" name="register">Đăng ký</button>
                    <div class="sign-in">
                        <span>Bạn đã có tài khoản ?</span>
                        <a href="./view_login.php" class="signupBtn">Đăng nhập</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
<script src="../assests/togglePassword.js"></script>
<script>
    document.getElementById('err_dl').innerHTML = document.getElementById('err_ms').value;
</script>
<style>
    #err_dl {
        color: red;
        font-size: 0.875rem;

    }

    /* #password {
        position: relative;
    }

    #togglePassword {
        position: absolute;
        top: 310px;
        right: 150px;
        display: none;
    } */

    #togglePassword {
        position: relative;
        display: block;
        top: -49px;
        right: -150px;
        display: none;
    }
</style>