<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login_OpenShare</title>
    <link rel="stylesheet" href="../assests/style.css" />
    <?php include('../../../file.php'); ?>
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"> -->
</head>

<body>
    <?php
    session_start();
    $userName = '';
    $password = '';
    if (isset($_GET['login'])) {
        $userName = $_GET['userName'];
        $password = $_GET['password'];

        $url = 'http://localhost:8000/website_openshare/controllers/users/auth/login.php';
        $data = array(
            'userName' => $userName,
            'password' => $password,
        );

        $options = array(
            CURLOPT_URL => $url,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Access-Control-Allow-Origin: *',
                'Access-Control-Allow-Methods: POST',
                'Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With'
            )
        );

        $curl = curl_init();
        curl_setopt_array($curl, $options);
        $response = curl_exec($curl);
        curl_close($curl);
        if ($response) {
            $result = json_decode($response, true);
        }

        if ($result["success"] == 0) {
    ?>
            <input type="hidden" id="err_ms" value="<?php echo ($result["message"]); ?>" />
    <?php
        } else {
            if ($result["success"] == 1) {
                $_SESSION['token'] = $result["token"];
                header('location:../Trangchu/index.php');
            }
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
                <?php
                if (isset($_SESSION['res_suc'])) { ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert"> <?= $_SESSION['res_suc']; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php
                    unset($_SESSION['res_suc']);
                }
                ?>
                <form action="" class="form-login" method="get">
                    <input type="text" placeholder="Tên đăng nhập" name="userName" required />
                    <input type="password" placeholder="Mật khẩu" name="password" id="password" required />
                    <i class="bi bi-eye" id="togglePassword" onclick="togglePasswordVisibility()"></i>
                    <div id="err_dl" style="margin-bottom: 5px;"></div>
                    <button class="loginBtn" type="submit" name="login">Login</button>
                    <div class="sign-up">
                        <a href="./view_register.php" class="signupBtn">Tạo tài khoản mới</a>
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

    #password {
        position: relative;
    }

    #togglePassword {
        position: absolute;
        top: 260px;
        right: 150px;
        display: none;
    }
</style>