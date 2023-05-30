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

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require '../../PHPMailer/src/Exception.php';
    require '../../PHPMailer/src/PHPMailer.php';
    require '../../PHPMailer/src/SMTP.php';
    $mail = new PHPMailer(true);
    $db_connection = new db();
    $conn = $db_connection->connect();
    if (isset($_POST['resetpassword'])) {
        $tendangnhap = $_POST['userName'];
        $email = $_POST['email'];
        $fetch_user_by_userName = "SELECT * FROM `nhanvien` WHERE `userName`=? and email=?";
        $query_stmt = $conn->prepare($fetch_user_by_userName);
        $query_stmt->execute([$tendangnhap, $email]);
        if ($query_stmt->rowCount() == 0) {
            $loi = "Tên đăng nhập hoặc email không trùng khớp với cơ sở dữ liệu của chúng tôi";
        } else {
            $loi = "";

            $matkhaumoi = substr(md5(rand(0, 999999)), 0, 8);
            $matkhaumahoa = password_hash($matkhaumoi, PASSWORD_DEFAULT);
            $sql = "Update nhanvien SET password = ? where userName = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$matkhaumahoa, $tendangnhap]);
            try {
                //Server settings
                $mail->SMTPDebug = 0;                                 // Enable verbose debug output
                $mail->isSMTP();                                      // Set mailer to use SMTP
                $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers

                $mail->SMTPAuth = true;
                // Enable SMTP authentication
                $mail->Username = 'tmhaunct2001@gmail.com';                 // SMTP username
                $mail->Password = 'ooakwovagpxsevav';                           // SMTP password
                $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
                $mail->Port = 587;                                    // TCP port to connect to

                //Recipients
                $mail->setFrom('tmhaunct2001@gmail.com', "OpenShareApp");
                $mail->addAddress($email, $tendangnhap);     // Add a recipient              // Name is optional
                $mail->isHTML(true);                                  // Set email format to HTML
                $mail->Subject = "Mail Reset Password From Open Share";
                $mail->Body    = "Mật khẩu mới của bạn là:" . $matkhaumoi;
                $mail->send();
                echo "<script>
            alert('Reset mật khẩu thành công, vui lòng kiểm tra email');;
            </script>";
            } catch (Exception $e) {
                echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
            }
        }


        // $insert_stmt->bindValue(':password', password_hash($password, PASSWORD_DEFAULT), PDO::PARAM_STR);
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

                                    <form class="row g-3 needs-validation" method="post" novalidate>

                                        <div class="col-12">
                                            <label for="yourUsername" class="form-label">Tên đăng nhập</label>
                                            <div class="input-group has-validation">
                                                <span class="input-group-text" id="inputGroupPrepend">@</span>
                                                <input type="text" name="userName" class="form-control" id="yourUsername" placeholder="Tên đăng nhập" value="<?php if (isset($_POST['userName'])) echo $_POST['userName'];
                                                                                                                                                                else ''  ?>" autocomplete="off" required>
                                                <div class="invalid-feedback">Vui lòng nhập tên đăng nhập</div>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <label for="yourPassword" class="form-label">email</label>
                                            <input type="email" name="email" class="form-control" id="yourPassword" placeholder="Nhập email" value="<?php if (isset($_POST['email'])) echo $_POST['email'];
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