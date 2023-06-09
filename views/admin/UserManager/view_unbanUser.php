<?php
session_start();
$token = $_SESSION['token_admin'];
if (isset($_POST['undeletedata'])) {
    if (isset($_POST['UnBan_User'])) {
        $id = $_POST['UnBan_User'];
    } else {
    }



    // Dữ liệu của câu hỏi cần cập nhật
    $data = array(
        'idUser' => $id,

    );

    // Chuyển dữ liệu sang định dạng JSON
    $json_data = json_encode($data);

    // URL của API
    $url = 'http://localhost:8000/website_openshare/controllers/admin/UserManager/unbanUser.php';

    // Khởi tạo một session cURL
    $curl = curl_init($url);

    // Cấu hình các tùy chọn cho session cURL
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PUT');
    curl_setopt($curl, CURLOPT_POSTFIELDS, $json_data);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        "Accept: application/json",
        "Authorization: Bearer {$token}",
    ));

    // Thực thi session cURL và lấy kết quả trả về
    $result = curl_exec($curl);

    // Kiểm tra kết quả và hiển thị thông báo tương ứng
    if ($result === false) {
        echo 'Có lỗi xảy ra khi gửi yêu cầu PUT đến API';
    } else {
        $response = json_decode($result, true);
        if ($response[1] === 'Mở khóa tài khoản thành công') {
            $_SESSION['status'] = "Mở khóa tài khoản thành công";
            header('location: ./view_displayUser.php');
            exit();
        } else {
        }
    }

    // Đóng session cURL
    curl_close($curl);
}
