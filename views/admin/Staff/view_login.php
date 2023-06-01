<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>website_openshare</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <!-- Favicons -->
    <?php include('../../../file.php') ?>

</head>

<body>
    <?php
    session_start();
    $userName = '';
    $password = '';
    if (isset($_POST['login'])) {
        $userName = $_POST['userName'];
        $password = $_POST['password'];

        $url = 'http://localhost:8000/website_openshare/controllers/admin/Staff/login.php';
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
                $_SESSION['token_admin'] = $result["token"];
                header('location:http://localhost:8000/website_openshare/Views/Admin/Trangchu/Trangchu.php');
            }
        }
    }
    ?>

    <main>
        <div class="container">
            <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

                            <div class="d-flex justify-content-center py-4">
                                <a href="index.html" class="logo d-flex align-items-center w-auto">
                                    <img src="http://localhost:8000/website_openshare/Views/users/assests/images/openshare_logo.png" alt="" width="200px" max-height="65px">
                                </a>
                            </div><!-- End Logo -->

                            <div class="card mb-3">

                                <div class="card-body">

                                    <div class="pt-4 pb-2">
                                        <h5 class="card-title text-center pb-0 fs-4">Đăng nhập bằng tài khoản của bạn</h5>
                                        <p class="text-center small">Nhập tài khoản và mật khẩu để đăng nhập</p>
                                    </div>

                                    <form class="row g-3 needs-validation" method="post" novalidate>

                                        <div class="col-12">
                                            <label for="yourUsername" class="form-label">Tên đăng nhập</label>
                                            <div class="input-group has-validation">
                                                <span class="input-group-text" id="inputGroupPrepend">@</span>
                                                <input type="text" name="userName" class="form-control" id="yourUsername" value="<?php if (isset($_POST['userName'])) echo $_POST['userName'];
                                                                                                                                    else ''  ?>" autocomplete="off" required>
                                                <div class="invalid-feedback">Vui lòng nhập tên đăng nhập</div>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <label for="yourPassword" class="form-label">Mật khẩu</label>
                                            <input type="password" name="password" class="form-control" id="yourPassword" value="<?php if (isset($_POST['password'])) echo $_POST['password'];
                                                                                                                                    else ''  ?>" autocomplete="off" required>
                                            <div class="invalid-feedback">Vui lòng nhập mật khẩu!</div>
                                        </div>
                                        <a href="./view_resetpassword.php">Quên mật khẩu ?</a>
                                        <div id="err_dl"></div>
                                        <div class="col-12">
                                            <button class="btn btn-primary w-100" type="submit" name="login">Đăng nhập</button>
                                        </div>

                                    </form>

                                </div>
                            </div>


                        </div>
                    </div>
                </div>

            </section>

        </div>
    </main><!-- End #main -->


</body>

</html>

<script>
    document.getElementById('err_dl').innerHTML = document.getElementById('err_ms').value;
</script>
<style>
    #err_dl {
        color: red;
        font-size: 0.875rem;

    }
</style>