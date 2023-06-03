<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assests/style.css" />
    <?php include('../../../file.php'); ?>
    <title>Nhập mã OTP</title>
    <style>
        .otp-input {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 10vh;
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
        }

        .otp-input input[type="text"] {
            width: 40px;
            height: 40px;
            font-size: 18px;
            text-align: center;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin: 0 5px;
            outline: none;
            transition: box-shadow 0.3s ease-in-out;
        }

        .otp-input input[type="text"]:focus {
            box-shadow: 0 0 5px #2e87e6;
        }

        .resend-button {
            display: flex;
            justify-content: center;
            margin-top: 10px;
        }

        .resend-button button {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #2e87e6;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            outline: none;
        }

        .resend-button button:hover {
            background-color: #1c67a8;
        }

        .otp-description {
            text-align: center;
            margin-top: 10px;
            font-size: 14px;
            font-weight: bold;
        }
    </style>
</head>

<body>
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
    if (isset($_GET['reresetpassword'])) {
        $tendangnhap = $_GET['reuserName'];
        $email = $_GET['reemail'];
        // Dữ liệu của câu hỏi cần cập nhật
        $data = array(
            'userName' => $tendangnhap,
            'email' => $email,
        );

        // Chuyển dữ liệu sang định dạng JSON
        $json_data = json_encode($data);

        // URL của API
        $url = 'http://localhost:8000/website_openshare/controllers/users/auth/sendOtp.php';

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
        alert('Gửi lại mã OTP thành công');;
    </script>";
        }
        // Đóng session cURL
        curl_close($curl);
    }
    ?>
    <form action="./script_resetpassword.php" method="get">
        <p class="otp-description">Nhập mã OTP đã được gửi đến email của bạn</p>
        <div class="otp-input">
            <input type="text" id="digit1" maxlength="1" onkeyup="moveToNext(this, 'digit2')" required>
            <input type="text" id="digit2" maxlength="1" onkeyup="moveToNext(this, 'digit3')" required>
            <input type="text" id="digit3" maxlength="1" onkeyup="moveToNext(this, 'digit4')" required>
            <input type="text" id="digit4" maxlength="1" onkeyup="moveToNext(this, 'digit5')" required>
            <input type="text" id="digit5" maxlength="1" onkeyup="moveToNext(this, 'digit6')" required>
            <input type="text" id="digit6" maxlength="1" onkeyup="moveToNext(this, 'digit6')" required>
            <input type="hidden" value="<?php if (isset($_GET['userName'])) echo $_GET['userName'];
                                        else if (isset($_GET['reuserName'])) echo $_GET['reuserName']; ?>" name="userName_u">
            <input type="hidden" value="<?php if (isset($_GET['email'])) echo $_GET['email'];
                                        else if (isset($_GET['reemail'])) echo $_GET['reemail']; ?>" name="email_e">
            <input type="hidden" id="otpInput" value="" name="otpInput">
        </div>
        <div class="resend-button">
            <button type="submit" name="confirmotp">Xác nhận OTP</button>
        </div>
    </form>
    <form action="" method="get">
        <div class="resend-button">
            <input type="hidden" value="<?php if (isset($_GET['userName'])) echo $_GET['userName'];
                                        else if (isset($_GET['reuserName'])) echo $_GET['reuserName']; ?>" name="reuserName">
            <input type="hidden" value="<?php if (isset($_GET['email'])) echo $_GET['email'];
                                        else if (isset($_GET['reemail'])) echo $_GET['reemail']; ?>" name="reemail">
            <button type="submit" name="reresetpassword">Gửi lại mã OTP</button>
        </div>
        <div style="margin-bottom: 10px;"></div>
    </form>


    <script>
        function moveToNext(currentInput, nextInputId) {
            const currentLength = currentInput.value.length;
            const maxLength = currentInput.maxLength;

            if (currentLength === maxLength) {
                const nextInput = document.getElementById(nextInputId);
                if (nextInput) {
                    nextInput.focus();
                } else {
                    currentInput.blur();
                }

                updateOtpInputValue();
            }
        }

        function updateOtpInputValue() {
            const otpInputs = Array.from(document.querySelectorAll(".otp-input input[type='text']"))
                .map(input => input.value);
            const otp = otpInputs.join("");

            document.getElementById("otpInput").value = otp;
        }

        // Lấy giá trị từ các input và đặt vào "otpInput" khi submit form
        document.querySelector("form").addEventListener("submit", function() {
            updateOtpInputValue();
        });
    </script>
    <?php include('../../../views/users/layout/footer.php'); ?>

</body>

</html>
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