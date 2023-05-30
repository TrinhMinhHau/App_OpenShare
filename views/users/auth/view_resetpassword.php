<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1" />
    <title>Website_OpenShare</title>
    <link rel="stylesheet" href="../assests/style.css" />
    <?php include('../../../file.php'); ?>
    <?php require __DIR__ . '/../../../configs/database.php'; ?>
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"> -->
</head>
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
    $fetch_user_by_userName = "SELECT * FROM `user` WHERE `userName`=? and email=?";
    $query_stmt = $conn->prepare($fetch_user_by_userName);
    $query_stmt->execute([$tendangnhap, $email]);
    if ($query_stmt->rowCount() == 0) {
        $loi = "Tên đăng nhập hoặc email không trùng khớp với cơ sở dữ liệu của chúng tôi";
    } else {
        $loi = "";

        $matkhaumoi = substr(md5(rand(0, 999999)), 0, 8);
        $matkhaumahoa = password_hash($matkhaumoi, PASSWORD_DEFAULT);
        $sql = "Update user SET password = ? where userName = ?";
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

<body>
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
                <form action="" class="form-login" method="post">
                    <input type="text" placeholder="Tên đăng nhập" name="userName" value="<?php if (isset($_POST['userName'])) echo $_POST['userName'];
                                                                                            else '';  ?>" required oninvalid="this.setCustomValidity('Vui lòng nhập tên đăng nhập !!!')" oninput="setCustomValidity('')" />
                    <input type="email" placeholder="email" name="email" value="<?php if (isset($_POST['email'])) echo $_POST['email'];
                                                                                else '';  ?>" id="email" required oninvalid="this.setCustomValidity('Vui lòng nhập email!!!')" oninput="setCustomValidity('')" />
                    <div id="err_dl" style="margin-bottom: 5px;"><?php if (isset($loi)) echo $loi;
                                                                    else '' ?></div>
                    <button class="loginBtn" type="submit" name="resetpassword">Lấy lại mật khẩu</button>
                    <div class="sign-up">
                        <a href="./view_login.php" class="signupBtn">Quay lại đăng nhập</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
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