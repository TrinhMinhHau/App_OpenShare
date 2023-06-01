<?php
session_start();
$token = $_SESSION['token_admin'];
if (isset($_POST['deleteItem'])) {
    if (isset($_POST['idType'])) {
        $id = $_POST['idType'];
    } else {
    }



    // Dữ liệu của câu hỏi cần cập nhật
    $data = array(
        'idType' => $id,

    );

    // Chuyển dữ liệu sang định dạng JSON
    $json_data = json_encode($data);

    // URL của API
    $url = 'http://localhost:8000/website_openshare/controllers/admin/ItemType/deleteItem.php';

    // Khởi tạo một session cURL
    $curl = curl_init($url);

    // Cấu hình các tùy chọn cho session cURL
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'DELETE');
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
        if ($response[1] === 'TypeItem is Deleted') {
            $_SESSION['status_delete'] = "Xóa loại đồ dùng này thành công";
            header('location: ./view_displayItem.php');
            exit();
        } else {
        }
    }

    // Đóng session cURL
    curl_close($curl);
}
