<!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> -->
<?php
session_start();
$token = $_SESSION['token_admin'];

// if (isset($_POST['changepassword'])) {
$id = $_POST['id'];
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
$url = 'http://localhost:8000/website_openshare/controllers/admin/Staff/changpassword.php';

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
    if ($response["success"] == 0) {
?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert"> <?= $response["message"]; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php
        // $_SESSION['error'] = $response["message"];
        // header('location: ./view_quanlytaikhoan.php ');
    } else {
        //    
    ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert"> <?= $response["message"]; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
<?php
        // $_SESSION['success'] = 'Đổi mật khẩu thành công';
        // header('location: ./view_quanlytaikhoan.php ');
    }
}

// Đóng session cURL
curl_close($curl);
//}
