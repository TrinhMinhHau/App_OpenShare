<?php
session_start();
$token = $_SESSION['token'];
if (isset($_POST['updateItem'])) {
    $idType = $_POST['idType'];
    $nameType = $_POST['CapNhat_LoaiDoDung'];

    // Dữ liệu của câu hỏi cần cập nhật
    $data = array(
        'idType' => $idType,
        'nameType' => $nameType,

    );

    // Chuyển dữ liệu sang định dạng JSON
    $json_data = json_encode($data);

    // URL của API
    $url = 'http://localhost:8000/website_openshare/controllers/admin/ItemType/updateItem.php';

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
        if ($response[1] === 'ItemType is Updated') {
            $_SESSION['status_update_success'] = "Cập nhật loại đồ dùng thành công";
            header('location: ./view_displayItem.php');
            exit();
        } else {
            $_SESSION['status_update_error'] = "Cập nhật loại đồ dùng thất bại";
            header('location: ./view_displayItem.php');
            exit();
        }
    }

    // Đóng session cURL
    curl_close($curl);
}
