<?php
if (isset($_GET['confirmotp'])) {
    $tendangnhap = $_GET['userName_u'];
    $email = $_GET['email_e'];
    $otp = $_GET['otpInput'];
    // Dữ liệu của câu hỏi cần cập nhật
    $data = array(
        'userName' => $tendangnhap,
        'email' => $email,
        'otp' => $otp,
    );

    // Chuyển dữ liệu sang định dạng JSON
    $json_data = json_encode($data);

    // URL của API
    $url = 'http://localhost:8000/website_openshare/controllers/admin/staff/resetpassword.php';

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
        alert('Mã OTP không chính xác');
        window.location.href = './view_enter_otp.php?userName=" . urlencode($tendangnhap) . "&email=" . urlencode($email) . "';
      </script>";
    } else {
        $newPassword = $response["newPassword"];
        echo "<script>
            var newPassword = '" . $newPassword . "';
            alert('Mật khẩu mới của bạn là: ' + newPassword);
            window.location.href = './view_login.php';
        </script>";
    }
    // Đóng session cURL
    curl_close($curl);
}
