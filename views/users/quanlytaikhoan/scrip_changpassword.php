<?php
session_start();
$token = $_SESSION['token'];
if (isset($_POST['submit'])) {
    $id = $_POST['idUser'];
    $oldpassword = $_POST['password'];
    $newpassword = $_POST['newpassword'];

    // Dữ liệu của câu hỏi cần cập nhật

    $data = array(
        'id' => $id,
        'old_password' => $oldpassword,
        'new_password' => $newpassword,
    );

    // Chuyển dữ liệu sang định dạng JSON
    $json_data = json_encode($data);

    // URL của API
    $url = 'http://localhost:8000/website_openshare/controllers/users/auth/changepassword.php';

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
        "Authorization: Bearer {$token}",
    ));

    // Thực thi session cURL và lấy kết quả trả về
    $result = curl_exec($curl);
    $response = json_decode($result, true);
    // Kiểm tra kết quả và hiển thị thông báo tương ứng
    if ($response["success"] == 0) {
        $_SESSION['cpw_error'] = "Mật khẩu hiện tại không đúng";
        header('location:./view_changepassword.php');
    } else {
        $_SESSION['cpw_suc'] = "Đổi mật khẩu thành công";
        header('location:../Trangchu/index.php');
    }
    // Đóng session cURL
    curl_close($curl);
}
