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
<nav>
    <div class="nav-left">
        <a href="../../../index.php">
            <img src="../../../views/users/assests/images/openshare_logo.png" alt="" height="41px" width="160px" /></a>
        <ul>
            <li>
                <a href="../../../index.php"><i class="bi bi-house-door-fill" style="cursor: pointer; font-size:30px; color:#012970"></i></a>
            </li>
        </ul>
    </div>
    <div class="nav-right">
        <li><a href="./view_login.php">Đăng nhập</a></li>
        <li><a href="./view_register.php">Đăng ký</a></li>
    </div>
</nav>
<?php
if (isset($_POST['resetpassword'])) {
    $tendangnhap = $_POST['userName'];
    $email = $_POST['email'];
    // Dữ liệu của câu hỏi cần cập nhật

    $data = array(
        'userName' => $tendangnhap,
        'email' => $email,
    );

    // Chuyển dữ liệu sang định dạng JSON
    $json_data = json_encode($data);

    // URL của API
    $url = 'http://localhost:8000/website_openshare/controllers/users/auth/resetpassword.php';

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
        // $_SESSION['cpw_error'] = "Tên đăng nhập hoặc email không trùng khớp với cơ sở dữ liệu của chúng tôi";
    } else {
        echo "<script>
        alert('Reset mật khẩu thành công, vui lòng kiểm tra email');;
        </script>";
    }
    // Đóng session cURL
    curl_close($curl);
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
    <?php include('../../../views/users/layout/footer.php'); ?>

</body>

</html>
<script>
    document.getElementById('err_dl').innerHTML = document.getElementById('err_ms').value;
</script>
<style>
    .nav-right li {
        list-style: none;
        padding: 10px;
    }

    .nav-right li a {
        text-decoration: none;
        color: #333;
    }

    .nav-right li a:hover {
        text-decoration: underline;
        color: #333;
    }
</style>
<style>
    #err_dl {
        color: red;
        font-size: 0.875rem;

    }
</style>