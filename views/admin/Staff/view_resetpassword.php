<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>website_openshare</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <?php require __DIR__ . '/../../../configs/database.php'; ?>
    <!-- Favicons -->
    <?php include('../../../file.php') ?>

</head>

<body>
    <?php
    if (isset($_GET['resetpassword'])) {
        $tendangnhap = $_GET['userName'];
        $email = $_GET['email'];
        // Dữ liệu của câu hỏi cần cập nhật

        $data = array(
            'userName' => $tendangnhap,
            'email' => $email,
        );

        // Chuyển dữ liệu sang định dạng JSON
        $json_data = json_encode($data);

        // URL của API
        $url = 'http://localhost:8000/website_openshare/controllers/admin/staff/sendOtp.php';

        // Khởi tạo một session cURL
        $curl = curl_init($url);

        // Cấu hình các tùy chọn cho session cURL
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($curl, CURLOPT_POSTFIELDS, $json_data);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($json_data),
            "Accept: application/json",
        ));

        // Thực thi session cURL và lấy kết quả trả về
        $result = curl_exec($curl);
        $response = json_decode($result, true);
        // Kiểm tra kết quả và hiển thị thông báo tương ứng
        if ($response["success"] == 0) {
            echo "<script>
        alert('Tên đăng nhập hoặc email không trùng khớp với cơ sở dữ liệu của chúng tôi');;
    </script>";
        } else {
            echo "<script>
        alert('Gửi mã OTP thành công, vui lòng kiểm tra email');;
        window.location.href = 'view_enter_otp.php?userName=' + encodeURIComponent('$tendangnhap') + '&email=' + encodeURIComponent('$email');
        </script>";
        }
        // Đóng session cURL
        curl_close($curl);
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
                                        <h5 class="card-title text-center pb-0 fs-4">Quên mật khẩu</h5>
                                        <p class="text-center small">Nhập tài khoản và email để lấy lại mật khẩu</p>
                                    </div>

                                    <form class="row g-3 needs-validation" method="get" novalidate>

                                        <div class="col-12">
                                            <label for="yourUsername" class="form-label">Tên đăng nhập</label>
                                            <div class="input-group has-validation">
                                                <span class="input-group-text" id="inputGroupPrepend">@</span>
                                                <input type="text" name="userName" class="form-control" id="yourUsername" placeholder="Tên đăng nhập" value="<?php if (isset($_GET['userName'])) echo $_GET['userName'];
                                                                                                                                                                else ''  ?>" autocomplete="off" required>
                                                <div class="invalid-feedback">Vui lòng nhập tên đăng nhập</div>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <label for="yourPassword" class="form-label">email</label>
                                            <input type="email" name="email" class="form-control" id="yourPassword" placeholder="Nhập email" value="<?php if (isset($_GET['email'])) echo $_GET['email'];
                                                                                                                                                    else ''  ?>" autocomplete="off" required>
                                            <div class="invalid-feedback">Vui lòng nhập email!</div>
                                        </div>
                                        <a href="./view_login.php">Quay lại đăng nhập ?</a>
                                        <div id="err_dl" style="margin-bottom: 5px;"><?php if (isset($loi)) echo $loi;
                                                                                        else '' ?></div>
                                        <div class="col-12">
                                            <button class="btn btn-primary w-100" type="submit" name="resetpassword">Lấy lại mật khẩu</button>
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