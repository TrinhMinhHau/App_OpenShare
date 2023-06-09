<?php
session_start();
$token = $_SESSION['token'];
if (isset($_POST['editprofile'])) {
    $id = $_POST['id'];
    $name = $_POST['fullName'];
    $email = $_POST['email'];
    $phoneNumber = $_POST['phone'];
    $img_old = $_POST['img'];
    if (isset($_FILES["fileToUpload"]["tmp_name"]) && !empty($_FILES["fileToUpload"]["tmp_name"])) {
        $image = file_get_contents($_FILES["fileToUpload"]["tmp_name"]);
        $image_base64 = base64_encode($image);
        $img =  "data:image/" . strtolower(pathinfo($_FILES["fileToUpload"]["name"], PATHINFO_EXTENSION)) . ";base64," . $image_base64;
    } else {
        $img = $img_old;
    }
    // Dữ liệu của câu hỏi cần cập nhật
    $data = array(
        'idUser' => $id,
        'name' => $name,
        'photoURL' => $img,
        'email' => $email,
        'phoneNumber' => $phoneNumber,
    );
    // Chuyển dữ liệu sang định dạng JSON
    $json_data = json_encode($data);

    // URL của API
    $url = 'http://localhost:8000/website_openshare/controllers/users/profile/editProfile.php';

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

    // Kiểm tra kết quả và hiển thị thông báo tương ứng
    if ($result === false) {
        echo 'Có lỗi xảy ra khi gửi yêu cầu PUT đến API';
    } else {
        $response = json_decode($result, true);
        $_SESSION['capnhat'] = 'Cập nhật thành công';
        header('location: ./view_profile.php');
    }

    // Đóng session cURL
    curl_close($curl);
}
