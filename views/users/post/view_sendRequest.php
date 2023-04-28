<?php
session_start();
$token = $_SESSION['token'];

if (isset($_POST['sendRequest'])) {
    $idPost = $_POST['idPost'];
    $idUserRequest = $_POST['idUserRequest'];
    $message = $_POST['message'];
} else {
}



// Dữ liệu của câu hỏi cần cập nhật
$data = array(
    'idPost' => $idPost,
    'idUserRequest' => $idUserRequest,
    'message' => $message,
);

// Chuyển dữ liệu sang định dạng JSON
$json_data = json_encode($data);

// URL của API
$url = 'http://localhost:8000/website_openshare/controllers/users/post/request.php';

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
    echo 'Có lỗi xảy ra khi gửi yêu cầu PUT đến API';
} else {
    $response = json_decode($result, true);
    var_dump($response);
    if ($response[1] === 'ItemType is Inserted') {
        $_SESSION['send_request_success'] = "Gửi yêu cầu thành công";
        header('location: ./view_displaySendRequest.php');
        exit();
    } else {
        $_SESSION['send_request_error'] = "Gửi yêu cầu thất bại, bạn đã gửi yêu cầu cho bài cho này rồi !!!";
        header('location: ../TrangChu/index.php');
        exit();
    }
}

// Đóng session cURL
curl_close($curl);
