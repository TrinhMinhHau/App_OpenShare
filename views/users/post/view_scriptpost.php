<?php
session_start();
$token = $_SESSION['token'];
if (isset($_POST['post'])) {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $address = $_POST['address'] ? $_POST['address'] : $_POST['result_post'];
    $idType = $_POST['type'];
    $arr_img = [];
    $file_arr = $_FILES['fileToUpload']['tmp_name'];
    if (is_array($file_arr)) {
        for ($i = 0; $i < count($file_arr); $i++) {
            $file_name = $file_arr[$i];
            $image = file_get_contents($file_name);
            $image_base64 = base64_encode($image);
            $image_noi = "data:image/" . strtolower(pathinfo($_FILES['fileToUpload']['name'][$i], PATHINFO_EXTENSION)) .  ";base64," . $image_base64;
            array_push($arr_img, $image_noi);
        }
    }
    $img_noi_encode = json_encode($arr_img);
    // Dữ liệu của câu hỏi cần cập nhật
    $data = array(
        'idUser' => $id,
        'title' => $title,
        "description" => $description,
        'address' => $address,
        'photos' => $img_noi_encode,
        'idType' => $idType,
    );
    // Chuyển dữ liệu sang định dạng JSON
    $json_data = json_encode($data);

    // URL của API
    $url = 'http://localhost:8000/website_openshare/controllers/users/post/create.php';

    // Khởi tạo một session cURL
    $curl = curl_init($url);

    // Cấu hình các tùy chọn cho session cURL
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
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

    var_dump($result);
    // Kiểm tra kết quả và hiển thị thông báo tương ứng
    if ($result === false) {
        echo 'Có lỗi xảy ra khi gửi yêu cầu PUT đến API';
    } else {
        $response = json_decode($result, true);

        $_SESSION['post_success'] = 'Đăng bài viết thành công';
        header('location: ../quanlytaikhoan/view_profile.php');
    }

    // Đóng session cURL
    curl_close($curl);
}
