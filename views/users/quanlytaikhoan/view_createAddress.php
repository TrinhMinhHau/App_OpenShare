<?php
session_start();
$token = $_SESSION['token'];
if (isset($_POST['createAddress'])) {
    $idUser = $_POST['idUser'];
    $address = $_POST['result'];
    // Dữ liệu của câu hỏi cần cập nhật
    $data = array(
        'idUser' => $idUser,
        'address' => $address,

    );
    // Chuyển dữ liệu sang định dạng JSON
    $json_data = json_encode($data);

    // URL của API
    $url = 'http://localhost:8000/website_openshare/controllers/users/address/create.php';

    // Khởi tạo một session cURL
    $curl = curl_init($url);

    // Cấu hình các tùy chọn cho session cURL
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
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
        echo 'Có lỗi xảy ra khi gửi yêu cầu POST đến API';
    } else {
        $response = json_decode($result, true);
        if ($response[1] === 'ItemType is Inserted') {
            $_SESSION['status_success'] = "Thêm mới địa chỉ thành công";
            header('location: ./view_profile.php');
            exit();
        } else {
            $_SESSION['status_error'] = "Địa chỉ đã tồn tại";
            header('location: ./view_profile.php');
            exit();
        }
    }

    // Đóng session cURL
    curl_close($curl);
}
